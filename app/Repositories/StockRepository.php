<?php

namespace App\Repositories;

use App\Models\Stock;
use Carbon\Carbon;

/**
 * Layer to handle datastore operations. Can be a local operation or external datastore
 */
class StockRepository
{
    /**
     * Variable to hold injected dependency
     *
     * @var Stock
     */
    protected $stock;

    /**
     * Initializing the instances and variables
     *
     * @param Stock $stock
     */
    public function __construct(Stock $stock)
    {
        $this->stock = $stock;
    }

    public function getAllStocks($product_id = null)
    {
        if ($product_id) {
            return Stock::where('product_id', $product_id)->get();
        } else {
            return Stock::all();
        }
    }

    public function store($data)
    {
        $productionDate = Carbon::createFromFormat('d/m/Y', $data['production_date']);
        $data['production_date'] = $productionDate;
        $stock = Stock::create($data);
        return response()->json(['success' => 'Stock On-hand saved Successfully']);

    }
}
