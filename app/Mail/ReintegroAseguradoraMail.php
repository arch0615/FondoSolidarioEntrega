<?php

namespace App\Mail;

use App\Models\Reintegro;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReintegroAseguradoraMail extends Mailable
{
    use Queueable, SerializesModels;

    public $reintegro;

    public function __construct(Reintegro $reintegro)
    {
        $this->reintegro = $reintegro;
    }

    public function build()
    {
        $subject = "Solicitud de Reintegro REI-{$this->reintegro->id_reintegro} - {$this->reintegro->alumno->nombre_completo}";

        return $this->from(config('mail.from.address'), config('mail.from.name'))
                    ->subject($subject)
                    ->view('emails.reintegro-aseguradora')
                    ->with([
                        'reintegro' => $this->reintegro,
                    ]);
    }
}
