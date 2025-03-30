<?php

namespace App\Services;

use App\Models\CourseRegistration;
use App\Models\User;
use App\Models\Course;
use Illuminate\Support\Facades\Mail;
use App\Mail\CourseRegistrationMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CourseRegistrationService
{
    /**
     * Create a new course registration and notify staff
     *
     * @param int $studentId
     * @param int $courseId
     * @return CourseRegistration
     */
    public function createRegistration($studentId, $courseId)
    {
        try {
            DB::beginTransaction();
            
            // Find the course to get teacher_id
            $course = Course::findOrFail($courseId);
            
            // Create registration with pending status
            $registration = CourseRegistration::create([
                'student_id' => $studentId,
                'teacher_id' => $course->teacher_id,
                'course_id' => $courseId,
                'status' => 'pending',
                'created_at' => now(),
            ]);
            
            // Load relationships for the email
            $registration->load(['student', 'teacher', 'course']);
            
            // Get all staff members
            $staffMembers = User::where('role', 'staff')->get();
            
            // Send email to each staff member
            foreach ($staffMembers as $staff) {
                Mail::to($staff->email)
                    ->send(new CourseRegistrationMail($registration, 'new_registration_to_staff'));
            }
            
            DB::commit();
            return $registration;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Registration creation failed: ' . $e->getMessage());
            throw $e;
        }
    }
    
    /**
     * Approve a registration and notify student and teacher
     *
     * @param int $registrationId
     * @return CourseRegistration
     */
    public function approveRegistration($registrationId)
    {
        try {
            DB::beginTransaction();
            
            // Find and update the registration
            $registration = CourseRegistration::with(['student', 'teacher', 'course'])->findOrFail($registrationId);
            $registration->status = 'approved';
            $registration->save();
            
            // Send email to student
            Mail::to($registration->student->email)
                ->send(new CourseRegistrationMail($registration, 'approval_to_student'));
            
            // Send email to teacher
            Mail::to($registration->teacher->email)
                ->send(new CourseRegistrationMail($registration, 'approval_to_teacher'));
            
            DB::commit();
            return $registration;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Registration approval failed: ' . $e->getMessage());
            throw $e;
        }
    }
    
    /**
     * Reject a registration
     *
     * @param int $registrationId
     * @return CourseRegistration
     */
    public function rejectRegistration($registrationId)
    {
        try {
            $registration = CourseRegistration::findOrFail($registrationId);
            $registration->status = 'rejected';
            $registration->save();
            
            return $registration;
        } catch (\Exception $e) {
            Log::error('Registration rejection failed: ' . $e->getMessage());
            throw $e;
        }
    }
}