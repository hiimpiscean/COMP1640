<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Services\CourseRegistrationService;
use Illuminate\Http\Request;
use App\Models\CourseRegistration;

class RegistrationController extends Controller
{
    protected $registrationService;
    
    public function __construct(CourseRegistrationService $registrationService)
    {
        $this->registrationService = $registrationService;
        $this->middleware('auth');
        $this->middleware('role:staff');
    }
    
    /**
     * Display a listing of pending course registrations.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pendingRegistrations = CourseRegistration::with(['student', 'course', 'teacher'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        return view('staff.registrations.index', compact('pendingRegistrations'));
    }
    
    /**
     * Display a specific registration.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $registration = CourseRegistration::with(['student', 'course', 'teacher'])->findOrFail($id);
        return view('staff.registrations.show', compact('registration'));
    }
    
    /**
     * Approve a course registration.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function approve($id)
    {
        try {
            $this->registrationService->approveRegistration($id);
            
            return redirect()->route('staff.registrations.index')
                ->with('success', 'Registration approved. Student and teacher have been notified.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Approval failed: ' . $e->getMessage()]);
        }
    }
    
    /**
     * Reject a course registration.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function reject($id)
    {
        try {
            $this->registrationService->rejectRegistration($id);
            
            return redirect()->route('staff.registrations.index')
                ->with('success', 'Registration rejected.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Rejection failed: ' . $e->getMessage()]);
        }
    }
}
