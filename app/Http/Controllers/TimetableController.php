<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Timetable;

class TimetableController extends Controller
{
    public function index()
    {
        $timetable = Timetable::with(['course', 'teacher'])->orderBy('day_of_week')->orderBy('start_time')->get();
        return view('timetable.index', compact('timetable'));
    }
    public function addTimetable(Request $request)
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
            $timetable = Timetable::create([
                'course_id' => $request->course_id,
                'teacher_id' => $request->teacher_id,
                'day_of_week' => $request->day_of_week,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'location' => $request->location,
                'meet_link' => $request->meet_link,
            ]);

            return response()->json(['message' => 'Timetable entry added successfully!', 'timetable' => $timetable], 201); //TODO: đổi lại đầu ra của function
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to add timetable entry', 'details' => $e->getMessage()], 500); //TODO: đổi lại đầu ra của function
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

        $timetable = Timetable::find($id);

        if (!$timetable) {
            return response()->json(['error' => 'Timetable entry not found'], 404);
        }

        try {
            $timetable->update([
                'course_id' => $request->course_id,
                'teacher_id' => $request->teacher_id,
                'day_of_week' => $request->day_of_week,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'location' => $request->location,
                'meet_link' => $request->meet_link,
            ]);

            return response()->json(['message' => 'Timetable entry updated successfully!', 'timetable' => $timetable], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update timetable entry', 'details' => $e->getMessage()], 500);
        }
    }
    public function deleteTimetable($id)
    {
        $timetable = Timetable::find($id);

        if (!$timetable) {
            return response()->json(['error' => 'Timetable entry not found'], 404);
        }

        try {
            $timetable->delete();
            return response()->json(['message' => 'Timetable entry deleted successfully!'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete timetable entry', 'details' => $e->getMessage()], 500);
        }
    }//TODO: thay đổi phần generate link meet.
}
