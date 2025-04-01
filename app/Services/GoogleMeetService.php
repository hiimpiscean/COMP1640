<?php

namespace App\Services;

use Google\Client;
use Google\Service\Calendar;
use Google\Service\Calendar\Event;
use App\Models\Timetable;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class GoogleMeetService
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var Calendar
     */
    protected $calendarService;

    /**
     * Khởi tạo dịch vụ GoogleMeet
     */
    public function __construct()
    {
        try {       
            $this->client = new Client();
            $this->client->setApplicationName('Google Meet Laravel');
            
            // Sử dụng thông tin xác thực từ biến môi trường
            $this->client->setClientId(env('GOOGLE_CLIENT_ID'));
            $this->client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
            $this->client->setScopes([Calendar::CALENDAR_EVENTS]);
            $this->client->setAccessType('offline');
            
            // Kiểm tra và sử dụng token
            $tokenPath = storage_path('app/google/token.json');
            if (file_exists($tokenPath)) {
                $accessToken = json_decode(file_get_contents($tokenPath), true);
                $this->client->setAccessToken($accessToken);
                
                // Refresh token nếu hết hạn
                if ($this->client->isAccessTokenExpired() && $this->client->getRefreshToken()) {
                    $this->client->fetchAccessTokenWithRefreshToken($this->client->getRefreshToken());
                    file_put_contents($tokenPath, json_encode($this->client->getAccessToken()));
                }
            }
            
            $this->calendarService = new Calendar($this->client);
        } catch (\Exception $e) {
            Log::error('GoogleMeetService initialization error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Tạo liên kết Google Meet cho một sự kiện
     * 
     * @param string $summary Tiêu đề cuộc họp
     * @param string $startTime Thời gian bắt đầu (định dạng ISO 8601)
     * @param string $endTime Thời gian kết thúc (định dạng ISO 8601)
     * @param string $description Mô tả cuộc họp (tùy chọn)
     * @return string|null URL của cuộc họp Google Meet hoặc null nếu có lỗi
     * @throws \Exception Khi có lỗi kết nối
     */
    public function createMeetLink(string $summary, string $startTime, string $endTime, string $description = ''): ?string
    {
        try {
            // Kiểm tra xem đã xác thực chưa
            if (!$this->client->getAccessToken()) {
                Log::error('Google client not authenticated');
                return null;
            }
            
            $event = new Event([
                'summary' => $summary,
                'description' => $description,
                'start' => ['dateTime' => $startTime, 'timeZone' => 'Asia/Ho_Chi_Minh'],
                'end' => ['dateTime' => $endTime, 'timeZone' => 'Asia/Ho_Chi_Minh'],
                'conferenceData' => [
                    'createRequest' => [
                        'requestId' => uniqid(),
                        'conferenceSolutionKey' => ['type' => 'hangoutsMeet']
                    ]
                ]
            ]);

            $calendarId = 'primary';
            $event = $this->calendarService->events->insert(
                $calendarId, 
                $event, 
                ['conferenceDataVersion' => 1]
            );

            return $event->getHangoutLink();
        } catch (\Exception $e) {
            Log::error('Google Meet creation error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Tạo liên kết Google Meet cho một lịch học
     * 
     * @param Timetable $timetable Đối tượng lịch học
     * @return string|null URL của cuộc họp Google Meet hoặc null nếu có lỗi
     */
    public function createMeetLinkForTimetable(Timetable $timetable): ?string
    {
        try {
            // Kiểm tra xem đã xác thực chưa
            if (!$this->client->getAccessToken()) {
                Log::error('Google client not authenticated');
                return null;
            }
            
            // Lấy thông tin khóa học và giáo viên
            $course = $timetable->course;
            $teacher = $timetable->teacher;
            
            if (!$course || !$teacher) {
                throw new \Exception('Không tìm thấy thông tin khóa học hoặc giáo viên');
            }
            
            // Tạo tiêu đề và mô tả cho cuộc họp
            $summary = "Lớp học: {$course->course_name}";
            $description = "Giáo viên: {$teacher->name_t}\n";
            $description .= "Ngày học: {$timetable->day_of_week}\n";
            $description .= "Thời gian: {$timetable->start_time} - {$timetable->end_time}\n";
            
            // Chuyển đổi thời gian bắt đầu và kết thúc sang định dạng ISO 8601
            $dayOfWeek = $this->getNextDayOfWeek($timetable->day_of_week);
            
            // Lấy giờ và phút từ start_time và end_time
            [$startHour, $startMinute] = explode(':', $timetable->start_time);
            [$endHour, $endMinute] = explode(':', $timetable->end_time);
            
            // Tạo đối tượng Carbon cho ngày học tiếp theo với giờ bắt đầu và kết thúc
            $startDateTime = Carbon::parse($dayOfWeek)
                ->setTime((int)$startHour, (int)$startMinute)
                ->setTimezone('Asia/Ho_Chi_Minh');
                
            $endDateTime = Carbon::parse($dayOfWeek)
                ->setTime((int)$endHour, (int)$endMinute)
                ->setTimezone('Asia/Ho_Chi_Minh');
            
            // Chuyển đổi sang định dạng ISO 8601
            $startTime = $startDateTime->toIso8601String();
            $endTime = $endDateTime->toIso8601String();
            
            // Tạo liên kết Google Meet
            $meetLink = $this->createMeetLink($summary, $startTime, $endTime, $description);
            
            // Cập nhật liên kết trong bảng Timetable
            if ($meetLink) {
                $timetable->update(['meet_link' => $meetLink]);
            }
            
            return $meetLink;
        } catch (\Exception $e) {
            Log::error('Timetable Meet creation error: ' . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Lấy ngày tiếp theo của một ngày trong tuần
     * 
     * @param string $dayName Tên ngày trong tuần (ví dụ: 'Monday', 'Tuesday',...)
     * @return string Ngày tiếp theo ở định dạng Y-m-d
     * @throws \Exception Nếu tên ngày không hợp lệ
     */
    private function getNextDayOfWeek(string $dayName): string
    {
        $days = [
            'monday' => 1,
            'tuesday' => 2,
            'wednesday' => 3,
            'thursday' => 4,
            'friday' => 5,
            'saturday' => 6,
            'sunday' => 0,
        ];
        
        $dayNum = $days[strtolower($dayName)] ?? null;
        
        if ($dayNum === null) {
            throw new \Exception('Tên ngày không hợp lệ');
        }
        
        $now = Carbon::now();
        $daysUntilNext = ($dayNum - $now->dayOfWeek + 7) % 7;
        
        // Nếu hôm nay là ngày cần tìm và chưa qua giờ học, trả về ngày hôm nay
        if ($daysUntilNext === 0) {
            return $now->format('Y-m-d');
        }
        
        // Nếu không, trả về ngày tiếp theo
        return $now->addDays($daysUntilNext)->format('Y-m-d');
    }
}