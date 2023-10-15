<?php

namespace App\Mail;

use Exception;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CommentMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
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
            $from = $this->comment->user->email;
            return $this->from($from)
                        ->view('frontend.mail.comment')
                        ->subject('Comment From '.$this->comment->user->name.' on FeedBack');

        } catch (Exception $e) {

            Log::info( "An exception occurred: " . $e->getMessage());
        }

    }
}
