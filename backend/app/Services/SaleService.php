<?php

namespace App\Services;

use App\Models\Sale;

class SaleService
{
    public function createSale(array $data)
    {
        return Sale::create($data);
    }

    public function updateSale(Sale $sale, array $data)
    {
        $sale->update($data);
        return $sale;
    }

    public function deleteSale(Sale $sale)
    {
        $sale->delete();
    }
}
