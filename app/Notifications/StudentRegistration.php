<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\RegistrationRequest;

class StudentRegistration extends Notification
{
    use Queueable;

    protected $registration;

    public function __construct(RegistrationRequest $registration)
    {
        $this->registration = $registration;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        $student = $this->registration->student;

        return [
            'type' => 'student_registration',
            'message' => "Sinh viên {$student->name} đã đăng ký yêu cầu xếp lớp",
            'registration_id' => $this->registration->id,
            'student_id' => $student->id,
            'student_name' => $student->name
        ];
    }
}

