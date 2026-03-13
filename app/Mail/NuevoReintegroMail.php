<?php

namespace App\Mail;

use App\Models\Reintegro;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NuevoReintegroMail extends Mailable
{
    use Queueable, SerializesModels;

    public $reintegro;

    /**
     * Create a new message instance.
     */
    public function __construct(Reintegro $reintegro)
    {
        $this->reintegro = $reintegro;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Nueva Solicitud de Reintegro - REI-' . $this->reintegro->id_reintegro)
                    ->view('emails.nuevo-reintegro')
                    ->with([
                        'reintegro' => $this->reintegro,
                        'logoUrl' => asset('images/logo.png') // Asumiendo que el logo está en public/images/
                    ]);
    }
}
