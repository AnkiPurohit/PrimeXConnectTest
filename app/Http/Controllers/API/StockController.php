<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StockCreateRequest;
use App\Models\Stock;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\StockService;
use Illuminate\Support\Facades\Bus;
use App\Jobs\ProcessImportStock;

class StockController extends Controller
{
    /** @var StockService */
    protected $stockService;

    public function __construct(StockService $stockService)
    {
        $this->stockService = $stockService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $product_id = isset($request->product_id) ? $request->product_id : null;
        return $this->stockService->getAllStocks($product_id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StockCreateRequest $request)
    {
        return $this->stockService->store($request);
        return response()->json(['success' => 'Stock On Hand added successfully ']);
    }

    /**
     * Import the products the specified resource from storage.
     *
     * @param  \App\Models\Stock  $product
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request)
    {
        return $this->stockService->import($request);
    }
}
