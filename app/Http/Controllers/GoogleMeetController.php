<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GoogleMeetService;

class GoogleMeetController extends Controller
{
    protected $googleMeetService;

    public function __construct(GoogleMeetService $googleMeetService)
    {
        $this->googleMeetService = $googleMeetService;
    }

    public function createMeeting()
    {
        $summary = 'Laravel Google Meet Meeting';
        $startTime = date('c', strtotime('+1 hour')); // 1 hour from now
        $endTime = date('c', strtotime('+2 hours')); // 2 hours from now

        $meetLink = $this->googleMeetService->createMeetLink($summary, $startTime, $endTime);

        return response()->json(['meet_link' => $meetLink]);
    }

    // public function auth()
    // {
    //     $authUrl = $this->googleMeetService->getAuthUrl();
    //     return redirect($authUrl);
    // }

    // public function callback(Request $request)
    // {
    //     try {
    //         if (!$request->has('code')) {
    //             throw new \Exception('Authorization code not provided');
    //         }

    //         if ($request->has('error')) {
    //             throw new \Exception($request->get('error_description', 'Authorization denied'));
    //         }

    //         $token = $this->googleMeetService->handleCallback($request->code);
            
    //         // Lưu thông tin xác thực vào session
    //         session(['google_authenticated' => true]);
            
    //         // Redirect về trang tạo lớp học
    //         return redirect()->route('classroom.create')
    //             ->with('success', 'Xác thực Google thành công! Bạn có thể tạo lớp học online.');
    //     } catch (\Exception $e) {
    //         return redirect()->route('classroom.create')
    //             ->with('error', 'Xác thực Google thất bại: ' . $e->getMessage());
    //     }
    // }

    // public function test()
    // {
    //     try {
    //         // Tạo thời gian bằng Carbon
    //         $startTime = Carbon::now()
    //             ->setTimezone('Asia/Ho_Chi_Minh')
    //             ->addHours(1); // Tạo meeting sau 1 giờ từ thời điểm hiện tại

    //         $meetLink = $this->googleMeetService->createMeeting(
    //             'Lớp Kiểm Tra',
    //             $startTime,
    //             60 // 60 phút
    //         );

    //         // Ghi log thông tin meeting
    //         Log::info('Test Meeting Created', [
    //             'link' => $meetLink,
    //             'start_time' => $startTime->toDateTimeString()
    //         ]);

    //         return response()->json([
    //             'success' => true, 
    //             'meet_link' => $meetLink,
    //             'start_time' => $startTime->toDateTimeString()
    //         ]);
    //     } catch (\Exception $e) {
    //         // Ghi log lỗi chi tiết
    //         Log::error('Meeting Creation Error', [
    //             'message' => $e->getMessage(),
    //             'trace' => $e->getTraceAsString()
    //         ]);

    //         return response()->json([
    //             'success' => false, 
    //             'error' => 'Không thể tạo meeting: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }
}
