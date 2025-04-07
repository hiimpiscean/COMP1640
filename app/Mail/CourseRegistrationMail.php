<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CourseRegistrationMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Registration data
     *
     * @var object
     */
    public $registrationData;

    /**
     * Email type
     *
     * @var string
     */
    protected $emailType;

    /**
     * Create a new message instance.
     *
     * @param object $registrationData
     * @param string $emailType
     * @return void
     */
    public function __construct($registrationData, $emailType = 'default')
    {
        $this->registrationData = $registrationData;
        $this->emailType = $emailType;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // Thiết lập chủ đề email dựa vào loại email
        $subject = $this->getSubjectByType();

        // Chọn view dựa vào loại email
        switch ($this->emailType) {
            case 'new_registration_to_staff':
                return $this->subject($subject)
                           ->view('emails.registrations.new_registration_staff');
            case 'approval_to_student':
                return $this->subject($subject)
                           ->view('emails.registrations.approved_student');
            case 'approval_to_teacher':
                return $this->subject($subject)
                           ->view('emails.registrations.approved_teacher');
            case 'rejection_to_student':
                return $this->subject($subject)
                           ->view('emails.registrations.rejected_student');
            default:
                return $this->subject($subject)
                           ->view('emails.registrations.default');
        }
    }

    /**
     * Get email subject based on email type
     *
     * @return string
     */
    protected function getSubjectByType()
    {
        switch ($this->emailType) {
            case 'new_registration_to_staff':
                return 'New Course Registration Request';
            case 'approval_to_student':
                return 'Your Course Registration Has Been Approved';
            case 'approval_to_teacher':
                return 'New Student Has Been Added To Your Course';
            case 'rejection_to_student':
                return 'Your Course Registration Status Update';
            default:
                return 'Course Registration Update';
        }
    }
} 