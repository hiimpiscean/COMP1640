<?php

namespace App\Services;

use Google\Client;
use Google\Service\Calendar;
use Google\Service\Calendar\Event;

class GoogleMeetService
{
    protected $client;
    protected $calendarService;

    public function __construct()
    {
        $this->client = new Client();
        $this->client->setApplicationName('Google Meet Laravel');
        $this->client->setAuthConfig(storage_path('app/credentials.json')); // Đảm bảo file tồn tại
        $this->client->setScopes([Calendar::CALENDAR_EVENTS]);
        $this->client->setAccessType('offline');

        $this->calendarService = new Calendar($this->client);
    }

    public function createMeetLink($summary, $startTime, $endTime)
    {
        try {
            $event = new Event([
                'summary' => $summary,
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
            $event = $this->calendarService->events->insert($calendarId, $event, ['conferenceDataVersion' => 1]);

            return $event->getHangoutLink(); // Trả về link Meet
        } catch (\Exception $e) {
            return null; // Trả về null nếu thất bại
        }
    }
}
