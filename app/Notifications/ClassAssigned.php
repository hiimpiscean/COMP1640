<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\ClassAssignment;

class ClassAssigned extends Notification
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
}
