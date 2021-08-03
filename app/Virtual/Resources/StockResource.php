<?php
/**
 * @OA\Schema(
 *     title="StockResource",
 *     description="Stock resource",
 *     @OA\Xml(
 *         name="StockResource"
 *     )
 * )
 */
class StockResource
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