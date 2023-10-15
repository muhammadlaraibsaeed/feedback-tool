<?php

namespace App\Mail;

use Exception;
use App\Models\Vote;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class VoteMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

     public $votes;
    public function __construct(Vote $vote)
    {
        $this->votes = $vote;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        try {

            // Email who comment on feedback
            $from = $this->votes->user->email;
            return $this->from($from)
                        ->view('frontend.mail.vote')
                        ->subject('Comment From '.$this->votes->user->name.' on FeedBack');

        } catch (Exception $e) {

            Log::info( "An exception occurred: " . $e->getMessage());
        }

    }
}
