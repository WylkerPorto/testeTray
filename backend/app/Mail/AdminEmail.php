<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $vendas;
    public $valorTotal;
    
    public function __construct($vendas, $valorTotal)
    {
        $this->vendas = $vendas;
        $this->valorTotal = $valorTotal;
    }

    public function build()
    {
        return $this->markdown('emails.admin')
                    ->subject('Relatório de Vendas - Dia')
                    ->with([
                        'vendas' => $this->vendas,
                        'valorTotal' => $this->valorTotal,
                    ]);
    }
}
