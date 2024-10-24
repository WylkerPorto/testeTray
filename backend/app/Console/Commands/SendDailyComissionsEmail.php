<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Sale;
use Illuminate\Support\Facades\Mail;
use App\Mail\SellerEmail;
use App\Mail\AdminEmail;
use Carbon\Carbon;

class SendDailyComissionsEmail extends Command
{
    protected $signature = 'email:send-daily-comissions';

    protected $description = 'Envia um e-mail com as comissões do dia para o admin e vendedores';

    public function handle()
    {
        // Obtém a data atual (dia anterior se o sistema rodar após a meia-noite)
        $today = Carbon::now()->format('Y-m-d');

        // Busca todas as vendas do dia atual com os vendedores associados
        $sales = Sale::with('seller')
            ->whereDate('sale_date', $today)
            ->get();

        // Calcula valores totais
        $valorTotal = $sales->sum('value');
        $comissaoTotal = $sales->sum(function ($sale) {
            return $sale->value * 0.085; // Supondo que a comissão seja 8.5%
        });

        // Envia e-mail para o administrador
        $adminEmail = 'admin@exemplo.com';
        Mail::to($adminEmail)->queue(new AdminEmail($sales, $valorTotal));

        // Envia e-mails individualmente para cada vendedor
        $salesBySeller = $sales->groupBy('seller_id');
        foreach ($salesBySeller as $sellerId => $salesForSeller) {
            $seller = $salesForSeller->first()->seller;
            Mail::to($seller->email)->queue(new SellerEmail($salesForSeller, $valorTotal, $comissaoTotal));
        }

        $this->info('E-mails de comissões enviados com sucesso!');
    }
}
