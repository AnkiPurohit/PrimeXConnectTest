<?php
/**
 * @OA\Schema(
 *     title="ProductResource",
 *     description="Product resource",
 *     @OA\Xml(
 *         name="ProductResource"
 *     )
 * )
 */
class ProductResource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     * 
     */
    private $data;
}