<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\TimetableRepos;
use App\Services\GoogleMeetService;
use Illuminate\Support\Facades\Log;

class TimetableController extends Controller
{
    public function index()
    {
        $timetable = TimetableRepos::getAllTimetables();
        return view('timetable.index', compact('timetable'));
    }

    public function addTimetable(Request $request, GoogleMeetService $googleMeetService)
    {
        $request->validate([
            'course_id' => 'required|integer|exists:course_registration,course_id',
            'teacher_id' => 'required|integer|exists:teacher,id_t',
            'day_of_week' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'location' => 'nullable|string|max:100',
        ]);

        try {
            $meetLink = $googleMeetService->createMeetLink('Online Class', $request->start_time, $request->end_time);

            $timetable = (object) [
                'course_id' => $request->course_id,
                'teacher_id' => $request->teacher_id,
                'day_of_week' => $request->day_of_week,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'location' => $request->location,
                'meet_link' => $meetLink,
            ];

            TimetableRepos::insert($timetable);

            return redirect()->back()->with('success', 'Timetable added successfully!');
        } catch (\Exception $e) {
            Log::error("Error adding timetable: " . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to add timetable');
        }
    }

    public function updateTimetable(Request $request, $id)
    {
        $request->validate([
            'course_id' => 'required|integer|exists:course_registration,course_id',
            'teacher_id' => 'required|integer|exists:teacher,id_t',
            'day_of_week' => 'required|string|max:10',
            'start_time' => 'required',
            'end_time' => 'required',
            'location' => 'nullable|string|max:100',
            'meet_link' => 'nullable|string|max:100',
        ]);

        try {
            $timetable = TimetableRepos::getTimetableById($id);
            if (!$timetable) {
                return redirect()->back()->with('error', 'Timetable entry not found');
            }

            $updatedTimetable = (object) [
                'id' => $id,
                'course_id' => $request->course_id,
                'teacher_id' => $request->teacher_id,
                'day_of_week' => $request->day_of_week,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'location' => $request->location,
                'meet_link' => $request->meet_link,
            ];

            TimetableRepos::update($updatedTimetable);

            return redirect()->back()->with('success', 'Timetable updated successfully!');
        } catch (\Exception $e) {
            Log::error("Error updating timetable: " . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update timetable');
        }
    }

    public function deleteTimetable($id)
    {
        try {
            $timetable = TimetableRepos::getTimetableById($id);
            if (!$timetable) {
                return redirect()->back()->with('error', 'Timetable entry not found');
            }

            TimetableRepos::delete($id);

            return redirect()->back()->with('success', 'Timetable deleted successfully!');
        } catch (\Exception $e) {
            Log::error("Error deleting timetable: " . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to delete timetable');
        }
    }
}
