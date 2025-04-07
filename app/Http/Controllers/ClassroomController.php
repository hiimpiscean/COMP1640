<?php

namespace App\Http\Controllers;

use App\Services\GoogleMeetService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ClassroomController extends Controller
{
    protected $googleMeetService;

    public function __construct(GoogleMeetService $googleMeetService)
    {
        $this->googleMeetService = $googleMeetService;
    }

    public function index()
    {
        // Lấy danh sách lớp học từ session
        $classes = session('classes', []);
        return view('classroom.index', compact('classes'));
    }

    public function create()
    {
        return view('classroom.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'teacher' => 'required|string|max:255',
            'start_time' => 'required|date|after:now',
            'duration' => 'required|integer|min:30|max:300',
            'class_type' => 'required|in:online,offline',
            'location' => 'nullable|string|max:255|required_if:class_type,offline',
        ]);

        try {
            $originalStartTime = Carbon::parse($request->start_time);
            // Tạo thông tin lớp học mới
            $class = [
                'id' => uniqid(),
                'name' => $request->name,
                'teacher' => $request->teacher,
                'start_time' => $originalStartTime->format('d/m/Y H:i'),
                'duration' => $request->duration,
                'class_type' => $request->class_type,
                'meet_link' => null,
                'location' => null
            ];

            // Nếu là lớp học online, tạo Google Meet link
            if ($request->class_type === 'online') {
                // Kiểm tra xem đã xác thực Google chưa
                $tokenPath = storage_path('app/google/token.json');
                if (!file_exists($tokenPath)) {
                    return redirect()->route('auth.google')
                        ->with('info', 'Vui lòng xác thực với Google trước khi tạo cuộc họp');
                }

                try {
                    $meetLink = $this->googleMeetService->createMeeting(
                        $request->name,
                        Carbon::parse($request->start_time)->setTimezone('UTC'), 
                        (int) $request->duration
                    );

                    $class['meet_link'] = $meetLink;

                } catch (\Exception $e) {
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Lỗi khi tạo Google Meet: ' . $e->getMessage());
                }
            } else if ($request->class_type === 'offline') {
                // Nếu là lớp học offline, lưu thông tin địa điểm
                $class['location'] = $request->location;
            }

            // Lưu lớp học vào session
            $classes = session('classes', []);
            $classes[] = $class;
            session(['classes' => $classes]);

            return redirect()->route('classroom.index')
                ->with('success', $class['class_type'] === 'online' 
                    ? 'Tạo lớp học online thành công! ' : 'Tạo lớp học offline thành công!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        // Tìm lớp học trong session theo id
        $classes = session('classes', []);
        $class = collect($classes)->firstWhere('id', $id);

        if (!$class) {
            return redirect()->route('classroom.index')
                ->with('error', 'Không tìm thấy lớp học');
        }

        return view('classroom.show', compact('class'));
    }
}
