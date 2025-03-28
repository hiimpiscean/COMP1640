<?php

namespace App\Services;

use Google\Client;
use Google\Service\Calendar;
use Google\Service\Calendar\Event;
use Carbon\Carbon;

class GoogleMeetService
{
    protected $client;
    protected $calendarService;

    public function __construct()
     {
         $this->client = new Client();
         $this->client->setApplicationName('Google Meet Laravel');
         $this->client->setAuthConfig(storage_path('app/credentials.json'));
         $this->client->setScopes([Calendar::CALENDAR_EVENTS]);
         $this->client->setAccessType('offline');
 
         $this->calendarService = new Calendar($this->client);
     }
 
     public function createMeetLink($summary, $startTime, $endTime)
     {
         $event = new Event([
             'summary' => $summary,
             'start' => ['dateTime' => $startTime, 'timeZone' => 'Asia/Tokyo'],
             'end' => ['dateTime' => $endTime, 'timeZone' => 'Asia/Tokyo'],
             'conferenceData' => [
                 'createRequest' => [
                     'requestId' => uniqid(),
                     'conferenceSolutionKey' => ['type' => 'hangoutsMeet']
                 ]
             ]
         ]);
 
         $calendarId = 'primary';
         $event = $this->calendarService->events->insert($calendarId, $event, ['conferenceDataVersion' => 1]);
 
         $meetLink = $event->getHangoutLink();
 
         // Store the Meet link in the database
         $courseRegistration = CourseRegistration::find($courseRegistrationId);
         if ($courseRegistration) {
             $courseRegistration->update(['meet_link' => $meetLink]);
         }
 
         return $meetLink;
     }

    // public function __construct()
    // {
    //     $this->client = new Google_Client();
    //     $this->client->setClientId(config('services.google.client_id', env('GOOGLE_CLIENT_ID')));
    //     $this->client->setClientSecret(config('services.google.client_secret', env('GOOGLE_CLIENT_SECRET')));
    //     $this->client->setRedirectUri(config('services.google.redirect', env('GOOGLE_REDIRECT_URI')));
    //     $this->client->addScope(Google_Service_Calendar::CALENDAR_EVENTS);
    //     $this->client->setAccessType('offline');
    //     $this->client->setPrompt('consent');

    //     $tokenPath = storage_path('app/google/token.json');
    //     if (file_exists($tokenPath)) {
    //         try {
    //             $tokenJson = file_get_contents($tokenPath);
    //             $accessToken = json_decode($tokenJson, true);
                
    //             if (json_last_error() !== JSON_ERROR_NONE) {
    //                 throw new \Exception('Invalid JSON in token file');
    //             }
                
    //             if (!is_array($accessToken) || !isset($accessToken['access_token'])) {
    //                 throw new \Exception('Invalid token structure');
    //             }
                
    //             $this->client->setAccessToken($accessToken);
    //         } catch (\Exception $e) {
    //             // If there's any issue with the token file, delete it
    //             if (file_exists($tokenPath)) {
    //                 unlink($tokenPath);
    //             }
    //             // Không return ở đây, để tiếp tục khởi tạo client
    //         }
    //     }

    //     // Kiểm tra token hết hạn và refresh nếu cần
    //     if ($this->client->isAccessTokenExpired()) {
    //         if ($this->client->getRefreshToken()) {
    //             try {
    //                 $this->client->fetchAccessTokenWithRefreshToken($this->client->getRefreshToken());
                    
    //                 // Đảm bảo thư mục tồn tại
    //                 if (!file_exists(dirname($tokenPath))) {
    //                     mkdir(dirname($tokenPath), 0755, true);
    //                 }
                    
    //                 file_put_contents($tokenPath, json_encode($this->client->getAccessToken()));
    //             } catch (\Exception $e) {
    //                 // Xử lý lỗi refresh token
    //                 if (file_exists($tokenPath)) {
    //                     unlink($tokenPath);
    //                 }
    //             }
    //         }
    //     }
    // }

    // public function getAuthUrl()
    // {
    //     return $this->client->createAuthUrl();
    // }

    // public function handleCallback($code)
    // {
    //     $accessToken = $this->client->fetchAccessTokenWithAuthCode($code);
    //     $this->client->setAccessToken($accessToken);

    //     if (array_key_exists('error', $accessToken)) {
    //         throw new \Exception(join(', ', $accessToken));
    //     }

    //     $tokenPath = storage_path('app/google/token.json');
    //     if (!file_exists(dirname($tokenPath))) {
    //         mkdir(dirname($tokenPath), 0700, true);
    //     }
    //     file_put_contents($tokenPath, json_encode($accessToken));
        
    //     return $accessToken;
    // }

    // public function createMeeting($title, $startTime, $duration = 60)
    // {
    //     $service = new Google_Service_Calendar($this->client);

    //     // Parse thởi gian đầu vào
    //     $inputTime = Carbon::parse($startTime);

    //     $event = new Google_Service_Calendar_Event([
    //         'summary' => $title,
    //         'start' => [
    //             'dateTime' => $inputTime->format('Y-m-d\TH:i:s'),
    //             'timeZone' => 'Asia/Ho_Chi_Minh',
    //         ],
    //         'end' => [
    //             'dateTime' => $inputTime->copy()->addMinutes($duration)->format('Y-m-d\TH:i:s'),
    //             'timeZone' => 'Asia/Ho_Chi_Minh',
    //         ],
    //         'conferenceData' => [
    //             'createRequest' => [
    //                 'requestId' => uniqid(),
    //                 'conferenceSolutionKey' => ['type' => 'hangoutsMeet']
    //             ]
    //         ]
    //     ]);
    // }
}