<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Publication;

class PublicationSubmitted extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    protected $publication;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Publication $publication)
    {
      $this->publication = $publication;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
      return $this->from('example@example.com')
                  ->view('emails.publications.submitted')
                  ->with([
                    'reference_no' => $this->publication->id,
                    'title' => $this->publication->title,
                    'name' => $this->publication->name,
                    'app_name' => config('app.name')
                  ]);
    }
}
