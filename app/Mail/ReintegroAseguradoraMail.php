<?php

namespace App\Mail;

use App\Models\Reintegro;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

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

        $mail = $this->from(config('mail.from.address'), config('mail.from.name'))
                    ->subject($subject)
                    ->view('emails.reintegro-aseguradora')
                    ->with([
                        'reintegro' => $this->reintegro,
                    ]);

        // Adjuntar archivos del reintegro
        foreach ($this->reintegro->archivos as $archivo) {
            $path = Storage::disk('public')->path($archivo->ruta_archivo);
            if (file_exists($path)) {
                $mail->attach($path, [
                    'as' => $archivo->nombre_archivo,
                    'mime' => mime_content_type($path),
                ]);
            }
        }

        return $mail;
    }
}
