<?php

namespace HelpDesk\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailReporteImpresionesAnual extends Mailable
{
    use Queueable, SerializesModels;

     /**
     * The data.
     *
     * @var string
     */
    public $filename;

    /**
     * anio
     *
     * @var int
     */
    public $anio;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($filename,$anio)
    {
        $this->filename = $filename;
        $this->anio = $anio;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('vendor.mail.html.reportes.reporte_anual_impresiones',[
            'anio' => $this->anio,
        ])
        ->subject('Reporte Anual Impresiones '.$this->anio)
        ->attach($this->filename);
    }
}
