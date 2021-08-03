<?php
/**
 * @OA\Schema(
 *      title="Product Stock request",
 *      description="Product Stock Request",
 *      type="object",
 *      required={"product_id","on_hand", "production_date"}
 * )
 */

class StockRequest
{
    /**
     * @OA\Property(
     *      title="Product ID",
     *      description="ID of the product",
     *      example="1"
     * )
     *
     * @var integer
     */
    public $product_id;

    /**
     * @OA\Property(
     *      title="On hand",
     *      description="Quantity of Hand of the product",
     *      example="2"
     * )
     *
     * @var integer
     */
    public $on_hand;

    /**
     * @OA\Property(
     *      title="Taken",
     *      description="Quantity of the product taken",
     *      example="1"
     * )
     *
     * @var integer
     */
    public $taken;

    /**
     * @OA\Property(
     *     title="Production Date",
     *     description="Production Date of the product",
     *     example="2020-01-27",
     *     format="date",
     *     type="string"
     * )
     *
     * @var \Date
     */
    private $production_date;    
}