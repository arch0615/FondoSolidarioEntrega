<?php

namespace App\Mail;

use App\Models\Reintegro;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EstadoReintegroEscuelaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $reintegro;
    public $resultado;
    public $detalle;
    public $autorNombre;

    /**
     * EstadoReintegroEscuelaMail constructor.
     *
     * @param Reintegro $reintegro
     * @param string $resultado
     * @param string $detalle
     * @param string|null $autorNombre
     */
    public function __construct(Reintegro $reintegro, string $resultado, string $detalle = '', ?string $autorNombre = null)
    {
        $this->reintegro = $reintegro;
        $this->resultado = $resultado;
        $this->detalle = $detalle;
        $this->autorNombre = $autorNombre;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = "Reintegro REI-{$this->reintegro->id_reintegro} - {$this->resultado}";

        return $this->from(config('mail.from.address'), config('mail.from.name'))
                    ->subject($subject)
                    ->view('emails.estado-reintegro-escuela')
                    ->with([
                        'reintegro' => $this->reintegro,
                        'resultado' => $this->resultado,
                        'detalle' => $this->detalle,
                        'autorNombre' => $this->autorNombre,
                    ]);
    }
}