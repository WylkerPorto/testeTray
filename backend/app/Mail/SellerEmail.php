<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SellerEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $vendas;
    public $valorTotal;
    public $comissaoTotal;

    /**
     * Create a new message instance.
     */
    public function __construct($vendas, $valorTotal, $comissaoTotal)
    {
        $this->vendas = $vendas;
        $this->valorTotal = $valorTotal;
        $this->comissaoTotal = $comissaoTotal;
    }

    public function build()
    {
        return $this->markdown('emails.seller')
                    ->subject('Relatório de Vendas - Dia')
                    ->with([
                        'vendas' => $this->vendas,
                        'valorTotal' => $this->valorTotal,
                        'comissaoTotal' => $this->comissaoTotal,
                    ]);
    }
}
