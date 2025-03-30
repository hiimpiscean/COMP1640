<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\CourseRegistration;

class CourseRegistrationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $registration;
    public $mailType;

    /**
     * Create a new message instance.
     *
     * @param CourseRegistration $registration
     * @param string $mailType
     * @return void
     */
    public function __construct(CourseRegistration $registration, $mailType)
    {
        $this->registration = $registration;
        $this->mailType = $mailType;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        switch ($this->mailType) {
            case 'new_registration_to_staff':
                return $this->subject('New Course Registration Request')
                            ->view('emails.registrations.new_registration_staff');
            
            case 'approval_to_student':
                return $this->subject('Your Course Registration Has Been Approved')
                            ->view('emails.registrations.approved_student');
            
            case 'approval_to_teacher':
                return $this->subject('New Student Added To Your Course')
                            ->view('emails.registrations.approved_teacher');
            
            default:
                return $this->subject('Course Registration Update')
                            ->view('emails.registrations.default');
        }
    }
}