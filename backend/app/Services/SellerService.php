<?php

namespace App\Services;

use App\Models\Seller;

class SellerService
{
    public function createSeller(array $data)
    {
        return Seller::create($data);
    }

    public function updateSeller(Seller $seller, array $data)
    {
        $seller->update($data);
        return $seller;
    }

    public function deleteSeller(Seller $seller)
    {
        $seller->delete();
    }
}
