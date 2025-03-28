<?php

namespace App\Http\Controllers;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\ClassAssignment;
use App\Models\RegistrationRequest;

class NotificationsController extends Notification
{
    use Queueable;

    protected $assignment;
    protected $registration;

    public function teacherAssignment(ClassAssignment $assignment)
    {
        $this->assignment = $assignment;

        return [
            'type' => 'teacher_assignment',
            'message' => "Sinh viên {$assignment->student->name} đã được xếp vào lớp {$assignment->class->name} của bạn",
            'assignment_id' => $assignment->id,
            'student_id' => $assignment->student->id,
            'student_name' => $assignment->student->name,
            'class_id' => $assignment->class->id,
            'class_name' => $assignment->class->name
        ];
    }

    public function classAssigned(ClassAssignment $assignment)
    {
        $this->assignment = $assignment;
        $class = $this->assignment->class;
        $teachers = $class->teachers;
        $teacherNames = $teachers->pluck('name')->implode(', ');

        return [
            'type' => 'class_assigned',
            'message' => "Bạn đã được xếp vào lớp {$class->name} với giáo viên {$teacherNames}",
            'assignment_id' => $this->assignment->id,
            'class_id' => $class->id,
            'class_name' => $class->name,
            'teacher_names' => $teacherNames
        ];
    }

    public function classConfirmation(ClassAssignment $assignment)
    {
        $this->assignment = $assignment;
        $student = $this->assignment->student;
        $class = $this->assignment->class;

        return [
            'type' => 'class_confirmation',
            'message' => "Sinh viên {$student->name} đã xác nhận tham gia lớp {$class->name}",
            'assignment_id' => $this->assignment->id,
            'student_id' => $student->id,
            'student_name' => $student->name,
            'class_id' => $class->id,
            'class_name' => $class->name
        ];
    }

    public function studentRegistration(RegistrationRequest $registration)
    {
        $this->registration = $registration;
        $student = $this->registration->student;

        return [
            'type' => 'student_registration',
            'message' => "Sinh viên {$student->name} đã đăng ký yêu cầu xếp lớp",
            'registration_id' => $this->registration->id,
            'student_id' => $student->id,
            'student_name' => $student->name
        ];
    }

    public function via($notifiable)
    {
        return ['database'];
    }
}