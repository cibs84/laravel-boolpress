<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewPostAdminEmail extends Mailable
{
    use Queueable, SerializesModels;

    private $new_post;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($_new_post)
    {
        // Prendo il nuovo post creato dall'utente, attraverso la funzione store() di Admin/PostController
        // che lo passa al __construct()
        $this->new_post = $_new_post;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = [
            "new_post" => $this->new_post
        ];

        // Invio il nuovo post alla view contenente il markup dell'email
        return $this->view('emails.new_post_admin_email', $data);
    }
}
