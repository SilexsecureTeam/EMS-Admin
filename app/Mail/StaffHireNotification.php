<?php

namespace App\Mail;

use App\Models\StaffHire;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StaffHireNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $staffHire;

    /**
     * Create a new message instance.
     */
    public function __construct(StaffHire $staffHire)
    {
        $this->staffHire = $staffHire;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('New Staff Hire Application Submitted')
                    ->view('emails.staff_hire_notification');
    }
}
