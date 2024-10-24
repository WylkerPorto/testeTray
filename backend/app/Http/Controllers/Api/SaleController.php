<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Services\SaleService;
use App\Http\Requests\SaleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Mail\SellerEmail;
use Illuminate\Support\Facades\Mail;

class SaleController extends Controller
{
    protected $saleService;

    public function __construct(SaleService $saleService)
    {
        $this->saleService = $saleService;
    }

    public function index()
    {
        $sales = Sale::with('seller')->orderBy('created_at', 'desc')->paginate(10);

        // Criptografa o ID da venda
        $sales->getCollection()->transform(function($sale) {
            $sale->uid = Crypt::encryptString($sale->id);
            //criptografa o ID do vendedor
            $sale->seller->uid = Crypt::encryptString($sale->seller->id);
            return $sale;
        });

        return $sales;
    }

    public function store(SaleRequest $request)
    {

        $sale = $this->saleService->createSale($request->all());

        return response()->json($sale, 201);
    }

    public function show($encryptedId)
    {
        $id = Crypt::decryptString($encryptedId);

        $sale = Sale::with('seller')->findOrFail($id);

        $sale->uid = Crypt::encryptString($sale->id);

        return response()->json($sale);
    }

    public function update(SaleRequest $request, $encryptedId)
    {
        $id = Crypt::decryptString($encryptedId);
    
        $sale = Sale::findOrFail($id);

        $updatedSale = $this->saleService->updateSale($sale, $request->all());

        return response()->json($updatedSale, 200);
    }

    public function destroy($encryptedId)
    {
        $id = Crypt::decryptString($encryptedId);
        
        $sale = Sale::findOrFail($id);

        $this->saleService->deleteSale($sale);

        return response()->json(null, 204);
    }

    public function resendCommission($encryptedId)
    {
        $id = Crypt::decryptString($encryptedId);

        // Busca a venda específica
        $sale = Sale::with('seller')->findOrFail($id);
        $salesForSeller = collect([$sale]);

        // Calcular o valor total e a comissão total
        $valorTotal = $salesForSeller->sum('value');
        $comissaoTotal = $salesForSeller->sum(function ($sale) {
            return $sale->value * 0.085; // Supondo que a comissão seja 8,5%
        });

        // Envia o e-mail para o vendedor
        Mail::to($sale->seller->email)->send(new SellerEmail($salesForSeller, $valorTotal, $comissaoTotal));

        return response()->json(['message' => 'E-mail reenviado com sucesso.'], 200);
    }
}
