<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use App\Models\Sale;
use App\Services\SellerService;
use App\Http\Requests\SellerRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class SellerController extends Controller
{
    protected $sellerService;

    public function __construct(SellerService $sellerService)
    {
        $this->sellerService = $sellerService;
    }

    public function index()
    {
        $sellers = Seller::orderBy('created_at', 'desc')->paginate(10);

        // Criptografa o ID do vendedor
        $sellers->getCollection()->transform(function($seller) {
            $seller->uid = Crypt::encryptString($seller->id);
            return $seller;
        });

        return $sellers;
    }
    
    public function store(SellerRequest $request)
    {
        $seller = $this->sellerService->createSeller($request->all());

        return response()->json($seller, 201);
    }
    
    public function show($encriptedId)
    {
        $id = Crypt::decryptString($encriptedId);
        
        $seller = Seller::findOrFail($id);
        
        $seller->uid = Crypt::encryptString($seller->id);
        
        return response()->json($seller);
    }
    
    public function update(SellerRequest $request, $encriptedId)
    {
        $id = Crypt::decryptString($encriptedId);
        $seller = Seller::findOrFail($id);
        
        $updatedSeller = $this->sellerService->updateSeller($seller, $request->all());
        
        return response()->json($updatedSeller, 200);
    }
    
    public function destroy($encriptedId)
    {
        $id = Crypt::decryptString($encriptedId);
        
        $seller = Seller::findOrFail($id);
        
        $this->sellerService->deleteSeller($seller);
        
        return response()->json(null, 204);
    }

    public function getSalesBySeller($encryptedId)
    {
        $id = Crypt::decryptString($encryptedId);

        $sales = Sale::with('seller')->where('seller_id', $id)
            ->orderBy('sale_date', 'desc')->get();
        
        return response()->json($sales, 200);
    }
}
