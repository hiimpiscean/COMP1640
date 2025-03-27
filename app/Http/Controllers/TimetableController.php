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
}
