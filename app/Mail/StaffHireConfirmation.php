<?php

namespace App\Mail;

use App\Models\StaffHire;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StaffHireConfirmation extends Mailable
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
        return $this->subject('Application Received - Thank You!')
                    ->view('emails.staff_hire_confirmation');
    }
}
