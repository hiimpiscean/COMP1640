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
}
