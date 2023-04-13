<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FormularioContacto extends Mailable
{
    use Queueable, SerializesModels;

    public $formulario;

    /**
     * Create a new message instance.
     */
    public function __construct($formulario)
    {
        $this->formulario = $formulario;
    }

    public function build()
    {
        return $this->view('emails.contacto')->with([
            'data' => json_encode($this->formulario),
        ]);
    }
}
