<?php

namespace App\Services;

use App\Http\Requests\SalesCreateRequest;
use Illuminate\Http\Request;
use App\Repositories\SalesRepository;
use App\Jobs\ExportSales;
/**
 * Layer to call and perform datastore operations
 */
class SalesService
{

    /**
     * Variable to hold injected dependency
     *
     * @var SalesRepository
     */
    protected $salesRepository;

    /**
     * Initializing the instances and variables
     *
     * @param SalesRepository $salesRepository
     */
    public function __construct(SalesRepository $salesRepository)
    {
        $this->salesRepository = $salesRepository;
    }

    public function store(SalesCreateRequest $request)
    {
        $validated = $request->validated();
        return $this->salesRepository->store($validated);
    }

    public function getAllSales()
    {
        return $this->salesRepository->getAllSalesData();
    }
    /**
     * Method to get sales details
     *
     * @param Request $request
     * @return array
     */
    public function getSalesForGrid($request)
    {
        $validated = $request->validated();
        return $this->salesRepository->getSalesDataForGrid($validated);
    }

    public function exportCsv($request) 
    {
        $validated = $request->validated();
        ExportSales::dispatch($validated);
        return [];
    }
}
