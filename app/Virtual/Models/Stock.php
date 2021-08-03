<?php
/**
 * @OA\Schema(
 *     title="Stock",
 *     description="Stock model",
 *     @OA\Xml(
 *         name="Stock"
 *     )
 * )
 */
class Stock
{

    /**
     * @OA\Property(
     *     title="ID",
     *     description="ID",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */
    private $id;

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

    /**
     * @OA\Property(
     *     title="Created at",
     *     description="Created at",
     *     example="2020-01-27 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var \DateTime
     */
    private $created_at;

    /**
     * @OA\Property(
     *     title="Updated at",
     *     description="Updated at",
     *     example="2020-01-27 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var \DateTime
     */
    private $updated_at;

}