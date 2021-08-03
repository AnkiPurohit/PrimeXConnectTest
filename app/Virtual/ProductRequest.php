<?php
/**
 * @OA\Schema(
 *      title="Product request",
 *      description="Product Request",
 *      type="object",
 *      required={"code","name"}
 * )
 */

class ProductRequest
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
     *      title="Code",
     *      description="Code of the product",
     *      example="P00001"
     * )
     *
     * @var string
     */
    public $code;

    /**
     * @OA\Property(
     *      title="Name",
     *      description="Name of the product",
     *      example="Product1"
     * )
     *
     * @var string
     */
    public $name;

    /**
     * @OA\Property(
     *      title="Description",
     *      description="Description of the product",
     *      example="This is product's description"
     * )
     *
     * @var string
     */
    public $description;
}