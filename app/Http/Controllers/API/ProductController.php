<?php


namespace App\Http\Controllers\API;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\ProductService;
use Illuminate\Support\Facades\Bus;
use App\Http\Requests\ProductCreateRequest;
use App\Http\Controllers\Controller;


class ProductController extends Controller
{
    /**
     * @OA\Tag(
     *     name="Product",
     *     description="API Endpoints of Product Management"
     * )
     */
    

    /** @var ProductService */
    protected $productService;

    const DEFAULT_SIZE = 10;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * @OA\Get(
     *      path="/api/products",
     *      operationId="getProducts",
     *      tags={"Product"},
     *      security={{"bearer_token":{}}},
     *      summary="get Product List",
     *      description="get Product List with stock as optional parameter. Also sorting by stock on hand and filter by availability is supported as optional parameters",
     *      @OA\Parameter(
     *          name="stock",
     *          description="set if want to get stock summary",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="page",
     *          description="set if want to use pagination. ",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="size",
     *          description="set if want to use pagination. ",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="sort",
     *          description="set if want to sort by stock on hand. ",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="availability",
     *          description="set if want to filter by available and Unavailable products. ",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/ProductResource")
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Invalid Input"
     *      )
     *     )
     * @return \Illuminate\Http\Response
     */
    
    public function index(Request $request)
    {
        $page = isset($request->page) ? $request->page : false;
        $size = isset($request->size) ? $request->size : self::DEFAULT_SIZE;
        $sort = isset($request->sort) ? $request->sort : false;
        $stock = isset($request->stock) ? $request->stock : false;
        $availability = isset($request->availability) ? $request->availability : false;

        return $this->productService->getAllProducts($page, $size, $sort, $stock, $availability);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductCreateRequest $request)
    {
        return $this->productService->store($request);
        return response()->json(['success' => 'Product added successfully ']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductCreateRequest $request)
    {
        return $this->productService->update($request);
        return response()->json(['success' => 'Product Updated successfully ']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        return $this->productService->destroy($request);
        return response()->json(['success' => 'Product Deleted successfully ']);
    }

    /**
     * Import the products the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request)
    {
        return $this->productService->import($request);

    }
    public function batch()
    {
        $batchId = request('id');
        return Bus::findBatch($batchId);
    }
}
