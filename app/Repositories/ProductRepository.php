<?php

namespace App\Repositories;

use App\Models\Product;
use DB;

/**
 * Layer to handle datastore operations. Can be a local operation or external datastore
 */
class ProductRepository
{
    const API_BASE_URL = "/api/products/";
    const FILTER_FIELD = "available_stock";
    const SORT_FIELD = "total_on_hand";

    /**
     * Variable to hold injected dependency
     *
     * @var Product
     */
    protected $product;

    /**
     * Initializing the instances and variables
     *
     * @param Product $product
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Fetching all products
     * Get Product Details
     * Get Product Details with Pagination
     * Get Product Details with Stock Details
     * Get Product Details with Stock Details With Pagination
     * Get Product Details with Stock Details With Sorting
     * Get Product Details with Stock Details With Filtering
     * @return array
     */
    public function getAllProductData($page, $size, $sort, $stock, $availability)
    {
        if (!$stock) {
            $data = $this->getProductsQuery($page, $size)->get();
            $total = $this->getProductsQuery(false, $size)->count();
        } else {
            $data = $this->getProductStocksQuery($page, $size, $sort, $availability)->get();
            $total = $this->getProductStocksQuery(false, $size, $sort, $availability)->get()->count();
        }

        if (!$page) {
            return response()->json($data);
        } else {
            return response()->json($this->getDataWithPaginationPayload($page, $size, $total, $data));
        }
    }

    public function getDataWithPaginationPayload($page, $size, $total, $data)
    {

        if ($page == 1) {
            $from = 1;
            $to = $size;
            $prevPageUrl = NULL;
        } else {
            $prevPageUrl = "/api/products/" . ($page - 1);
            $from = ($size * ($page - 1)) + 1; //21
            $to = $size * $page; //30
        }

        $nextPageUrl = "/api/products/" . ($page + 1);
        $lastPage = round($total / $size);
        return array(
            'data' => $data,
            'current_page' => $page,
            'per_page' => $size,
            'total' => $total,
            'next_page_url' => $nextPageUrl,
            'prev_page_url' => $prevPageUrl,
            'last_page' => $lastPage,
            'from' => $from,
            'to' => $to
        );
    }
    public function getProductsQuery($page, $size)
    {
        $query = Product::query();
        if ($page) {
            $query = $this->getQueryWithPagination($query, $page, $size);
        }
        return $query;
    }

    public function getProductStocksQuery($page, $size, $sort, $availability)
    {
        $query = Product::leftJoin('stocks', 'products.id', '=', 'stocks.product_id')
            ->select('products.*', DB::raw('sum(on_hand) as total_on_hand, sum(taken) as total_taken, (sum(on_hand) - sum(taken)) as available_stock'))
            ->groupBy('stocks.product_id');

        if ($availability) {
            $query = $this->getQueryWithAvailability($query, $availability);
        }

        if ($sort) {
            $sortArray = explode("|", $sort);
            $sortBy = $sortArray[1];
            $query = $this->getQueryWithSortStock($query, $sortBy);
        }

        if ($page) {
            $query = $this->getQueryWithPagination($query, $page, $size);
        }

        return $query;
    }

    public function getQueryWithSortStock($query, $sortBy)
    {
        return $query->orderBy(self::SORT_FIELD, $sortBy);
    }

    public function getQueryWithAvailability($query, $availability)
    {
        if ($availability == "yes") {
            return $query->having(self::FILTER_FIELD, '>', 0);
        } else {
            return $query->havingRaw('(' . self::FILTER_FIELD . ' <= 0 or ' . self::FILTER_FIELD . ' is null)');
        }
    }

    public function getQueryWithPagination($query, $page, $size)
    {
        return $query->skip(($page - 1) * $size)->take($size);
    }

    public function store($data)
    {
        $product = Product::create($data);
        return response()->json(['success' => 'Product saved Successfully', 'id' => $product->id]);

    }
    public function update($data)
    {
        Product::where('id', $data['id'])->update($data);
        return response()->json(['success' => 'Product Updated Successfully']);

    }
    public function destroy($data)
    {
        $product = Product::find( $data['id']);
        $product->update([
            'code' => time() . '::' . $product->code
        ]);
        Product::where('id', $data['id'])->delete();
        return response()->json(['success' => 'Product Deleted Successfully']);

    }
}
