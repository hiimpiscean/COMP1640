<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Services\CourseRegistrationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;

class RegistrationController extends Controller
{
    protected $registrationService;
    
    public function __construct(CourseRegistrationService $registrationService)
    {
        $this->registrationService = $registrationService;
        $this->middleware('auth');
        $this->middleware('role:student');
    }
    
    /**
     * Show the form for registering for a course.
     *
     * @param int $courseId
     * @return \Illuminate\Http\Response
     */
    public function create($courseId)
    {
        $course = Course::findOrFail($courseId);
        return view('student.registrations.create', compact('course'));
    }
    
    /**
     * Register student for a course.
     *
     * @param Request $request
     * @param int $courseId
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $courseId)
    {
        try {
            $this->registrationService->createRegistration(Auth::id(), $courseId);
            
            return redirect()->route('student.courses')
                ->with('success', 'Course registration request submitted. You will be notified when it is approved.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Registration failed: ' . $e->getMessage()]);
        }
    }
    
    /**
     * Show student's registered courses.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $registrations = CourseRegistration::with('course')
            ->where('student_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('student.registrations.index', compact('registrations'));
    }
}
