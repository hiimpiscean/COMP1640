<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\ClassAssignment;

class ClassConfirmation extends Notification
{
    use Queueable;

    protected $assignment;

    public function __construct(ClassAssignment $assignment)
    {
        $this->assignment = $assignment;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
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
}
