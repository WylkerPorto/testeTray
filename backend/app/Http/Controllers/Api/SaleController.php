<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Services\SaleService;
use App\Http\Requests\SaleRequest;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    protected $saleService;

    public function __construct(SaleService $saleService)
    {
        $this->saleService = $saleService;
    }

    public function index()
    {
        return Sale::with('user')->get();
    }

    public function store(SaleRequest $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'value' => 'required|numeric',
        ]);

        $sale = $this->saleService->createSale($request->all());

        return response()->json($sale, 201);
    }

    public function show($id)
    {
        return Sale::with('user')->findOrFail($id);
    }

    public function update(SaleRequest $request, $id)
    {
        $sale = Sale::findOrFail($id);

        $this->saleService->updateSale($sale, $request->only('user_id', 'value'));

        return response()->json($sale, 200);
    }

    public function destroy($id)
    {
        $sale = Sale::findOrFail($id);

        $this->saleService->deleteSale($sale);

        return response()->json(null, 204);
    }
}
