<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GoogleMeetService;
use App\Models\Timetable;
use Illuminate\Support\Facades\Log;
use App\Repository\TimetableRepos;

class GoogleMeetController extends Controller
{
    protected $googleMeetService;
    protected $timetableRepos;

    public function __construct(GoogleMeetService $googleMeetService, TimetableRepos $timetableRepos)
    {
        $this->googleMeetService = $googleMeetService;
        $this->timetableRepos = $timetableRepos;
    }

        /**
     * Chuyển hướng người dùng đến trang xác thực Google
     * 
     * @return \Illuminate\Http\Response
     */
    public function auth()
    {
        try {
            $client = new \Google\Client();
            $client->setApplicationName('Google Meet Laravel');
            
            // Sử dụng thông tin xác thực từ biến môi trường
            $client->setClientId(env('GOOGLE_CLIENT_ID'));
            $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
            $client->setRedirectUri(url('/auth/google/callback'));
            $client->setScopes([\Google\Service\Calendar::CALENDAR_EVENTS]);
            $client->setAccessType('offline');
            $client->setPrompt('consent');
            
            $authUrl = $client->createAuthUrl();
            return redirect($authUrl);
        } catch (\Exception $e) {
            Log::error('Google Auth Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Lỗi xác thực Google: ' . $e->getMessage());
        }
    }

    /**
     * Xử lý callback từ Google sau khi xác thực
     * 
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function callback(Request $request)
    {
        try {
            if (!$request->has('code')) {
                throw new \Exception('Không nhận được mã xác thực');
            }

            if ($request->has('error')) {
                throw new \Exception($request->get('error_description', 'Xác thực bị từ chối'));
            }

            $client = new \Google\Client();
            $client->setApplicationName('Google Meet Laravel');
            
            // Sử dụng thông tin xác thực từ biến môi trường
            $client->setClientId(env('GOOGLE_CLIENT_ID'));
            $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
            $client->setRedirectUri(url('/auth/google/callback'));
            $client->setScopes([\Google\Service\Calendar::CALENDAR_EVENTS]);
            
            // Lấy token từ code
            $token = $client->fetchAccessTokenWithAuthCode($request->code);
            
            if (array_key_exists('error', $token)) {
                throw new \Exception(join(', ', $token));
            }
            
            // Lưu token vào file
            $tokenPath = storage_path('app/google/token.json');
            if (!file_exists(dirname($tokenPath))) {
                mkdir(dirname($tokenPath), 0755, true);
            }
            
            file_put_contents($tokenPath, json_encode($token));
            
            // Lưu thông tin xác thực vào session
            session(['google_authenticated' => true]);
            
            return redirect()->to('/staff/timetable')->with('success', 'Xác thực Google thành công!');
        } catch (\Exception $e) {
            Log::error('Google Callback Error: ' . $e->getMessage());
            return redirect()->to('/staff/timetable')->with('error', 'Xác thực Google thất bại: ' . $e->getMessage());
        }
    }
    
    /**
     * Tạo một cuộc họp Google Meet mới
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createMeeting(Request $request)
    {
        try {
            $request->validate([
                'summary' => 'required|string|max:255',
                'start_time' => 'required|date_format:Y-m-d H:i:s',
                'end_time' => 'required|date_format:Y-m-d H:i:s|after:start_time',
                'description' => 'nullable|string'
            ]);

            // Chuyển đổi thời gian sang định dạng ISO 8601
            $startTime = \Carbon\Carbon::parse($request->start_time)->toIso8601String();
            $endTime = \Carbon\Carbon::parse($request->end_time)->toIso8601String();
            
            $meetLink = $this->googleMeetService->createMeetLink(
                $request->summary,
                $startTime,
                $endTime,
                $request->description ?? ''
            );

            if (!$meetLink) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không thể tạo liên kết Google Meet'
                ], 500);
            }

            return response()->json([
                'success' => true,
                'meet_link' => $meetLink
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Tạo liên kết Google Meet cho một lịch học cụ thể
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createMeetingForTimetable(Request $request)
    {
        try {
            $request->validate([
                'timetable_id' => 'required|exists:timetable,id'
            ]);

            $timetable = Timetable::with(['course', 'teacher'])->findOrFail($request->timetable_id);
            
            $meetLink = $this->googleMeetService->createMeetLinkForTimetable($timetable);

            if (!$meetLink) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không thể tạo liên kết Google Meet cho lịch học này'
                ], 500);
            }

            return response()->json([
                'success' => true,
                'meet_link' => $meetLink,
                'timetable' => $timetable
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Tạo liên kết Google Meet cho tất cả các lịch học của một khóa học
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createMeetingsForCourse(Request $request)
    {
        try {
            $request->validate([
                'course_id' => 'required|exists:course_registration,course_id'
            ]);

            // Sử dụng repository để lấy timetables thay vì Eloquent với relationships
            $timetables = $this->timetableRepos->getTimetablesByCourseId($request->course_id);

            if (count($timetables) == 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không tìm thấy lịch học nào cho khóa học này'
                ], 404);
            }

            $results = [];
            foreach ($timetables as $timetableData) {
                // Lấy thông tin course và teacher từ repository
                $course = $this->timetableRepos->getCourseById($timetableData->course_id);
                $teacher = $this->timetableRepos->getTeacherById($timetableData->teacher_id);
                
                // Tạo đối tượng Timetable mới từ dữ liệu
                $timetable = new Timetable();
                $timetable->id = $timetableData->id;
                $timetable->course_id = $timetableData->course_id;
                $timetable->teacher_id = $timetableData->teacher_id;
                $timetable->day_of_week = $timetableData->day_of_week;
                $timetable->start_time = $timetableData->start_time;
                $timetable->end_time = $timetableData->end_time;
                $timetable->location = $timetableData->location;
                
                // Truyền đầy đủ tham số
                $meetLink = $this->googleMeetService->createMeetLinkForTimetable($timetable, $course, $teacher);
                $results[] = [
                    'timetable_id' => $timetableData->id,
                    'day_of_week' => $timetableData->day_of_week,
                    'time' => $timetableData->start_time . ' - ' . $timetableData->end_time,
                    'meet_link' => $meetLink,
                    'success' => $meetLink !== null
                ];
            }

            return response()->json([
                'success' => true,
                'results' => $results
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi: ' . $e->getMessage()
            ], 500);
        }
    }

}
