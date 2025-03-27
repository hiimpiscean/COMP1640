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
}
