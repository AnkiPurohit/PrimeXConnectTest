<?php

namespace App\Services;

use App\Http\Requests\StockCreateRequest;
use App\Jobs\ProcessImportStock;
use App\Repositories\StockRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use Illuminate\Bus\Batch;

/**
 * Layer to call and perform datastore operations
 */
class StockService
{

    /**
     * Variable to hold injected dependency
     *
     * @var StockRepository
     */
    protected $stockRepository;

    /**
     * Initializing the instances and variables
     *
     * @param StockRepository $stockRepository
     */
    public function __construct(StockRepository $stockRepository)
    {
        $this->stockRepository = $stockRepository;
    }

    public function getAllStocks($product_id = null)
    {
        return $this->stockRepository->getAllStocks($product_id);
    }

    /**
     * Import the products the specified resource from storage.
     *
     * @param  \App\Models\Stock  $product
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request)
    {

        if ( $request->file == 'null') {
            return response()->json(['error' => 'Please upload file first']);
        } else {
            $upload_path = public_path('upload');
            $file_name = $request->file->getClientOriginalName();
            $generated_new_name = time() . '.' . $request->file->getClientOriginalExtension();
            $uploadFile = $request->file->move($upload_path, $generated_new_name);

            $data   =   file($uploadFile);
            // Chunking file
            $chunks = array_chunk($data, 1000);
            $header = [];
            
            $jobs = [];
            foreach ($chunks as $key => $chunk) {
                $data = array_map('str_getcsv', $chunk);
                if ($key === 0) {
                    $header = preg_replace('/[^A-Za-z0-9\-]/', '', $data[0]); // Removes special chars.
                    unset($data[0]);
                }
                $jobs[] = new ProcessImportStock($data);
                //ProcessImportStock::dispatch($data);
            }

            $batch = Bus::batch($jobs)->dispatch();
        
            $batchId = $batch->id;
            return response()->json(['success' => 'You have successfully uploaded "' . $file_name . '"']);
        }

    }

    public function store(StockCreateRequest $request)
    {
        $validated = $request->validated();
        return $this->stockRepository->store($validated);
    }
}
