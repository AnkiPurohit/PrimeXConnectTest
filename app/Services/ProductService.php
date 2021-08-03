<?php

namespace App\Services;
use Illuminate\Http\Request;
use App\Jobs\ProcessImportProduct;
use App\Http\Requests\ProductCreateRequest;
use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\Bus;
use Illuminate\Bus\Batch;

/**
 * Layer to call and perform datastore operations
 */
class ProductService
{

    /**
     * Variable to hold injected dependency
     *
     * @var ProductRepository 
     */
    protected $productRepository;

    /**
     * Initializing the instances and variables
     *
     * @param ProductRepository $productRepository
     */
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getAllProducts($page, $size, $sort, $stock, $availability)
    {
        return $this->productRepository->getAllProductData($page, $size, $sort, $stock, $availability);
    }

    public function store($request)
    {
        $validated = $request->validated();
        return $this->productRepository->store($validated);
    }

    public function update(ProductCreateRequest $request)
    {
        $validated = $request->validated();
        return $this->productRepository->update($validated);
    }

    public function destroy($request)
    {
        return $this->productRepository->destroy($request);
    }

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
                $jobs[] = new ProcessImportProduct($data,$header);
            }

            $batch = Bus::batch($jobs)->dispatch();
        
            $batchId = $batch->id;
            return response()->json(['success' => 'You have successfully uploaded "' . $file_name . '"']);
        }

    }

    
}
