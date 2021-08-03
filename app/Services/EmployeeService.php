<?php

namespace App\Services;

use App\Repositories\EmployeeRepository;
use App\Http\Requests\EmployeeFilterRequest;
use App\Jobs\ExportEmployeeLadder;

/**
 * Layer to call and perform datastore operations
 */
class EmployeeService
{

    /**
     * Variable to hold injected dependency
     *
     * @var EmployeeRepository 
     */
    protected $employeeRepository;

    /**
     * Initializing the instances and variables
     *
     * @param EmployeeRepository $employeeRepository
     */
    public function __construct(EmployeeRepository $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    public function getAllEmployees()
    {
        return $this->employeeRepository->getAllEmployeesData();
    }

    public function getAllEmployeesForFilter()
    {
        return $this->employeeRepository->getAllEmployeesDataForFilter();
    }

    public function getAccumulatedSales(EmployeeFilterRequest $request)
    {
        $validated = $request->validated();
        return $this->employeeRepository->getEmployeeSalesDataForGrid($validated);
    }

    public function exportSalesLadder(EmployeeFilterRequest $request)
    {
        $validated = $request->validated();
        ExportEmployeeLadder::dispatch($validated);
        return [];
    }
}
