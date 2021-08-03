<?php

namespace App\Repositories;

use App\Models\Employee;
use App\Models\Sales;
use Carbon\Carbon;
use DB;

/**
 * Layer to handle datastore operations. Can be a local operation or external datastore
 */
class EmployeeRepository
{
    const CURRENCY_SIGN = "$";

    /**
     * Variable to hold injected dependency
     *
     * @var Employee
     */
    protected $employee;

    /**
     * Initializing the instances and variables
     *
     * @param Employee $employee
     */
    public function __construct(Employee $employee)
    {
        $this->employee = $employee;
    }

    /**
     * Fetching all employees
     *
     * @return array
     */
    public function getAllEmployeesData()
    {
        return Employee::all()->toArray();
    }

    /**
     * Fetching id and name of all employees
     *
     * @return array
     */
    public function getAllEmployeesDataForFilter()
    {
        return Employee::select('id', 'name')->get();
    }

    public function getEmployeeSalesDataForGrid($data)
    {
        $dateFrom = Carbon::createFromFormat('d/m/Y', $data['from'])->format('Y-m-d');
        $dateTo = Carbon::createFromFormat('d/m/Y', $data['to'])->format('Y-m-d');
        
        // Get Accumulated Sales for all employees within selected date range
        $salesData = Sales::join('employees', 'employees.id', '=', 'sales.employee_id')
            ->join('products', 'products.id', '=', 'sales.product_id')
            ->select('employees.name', DB::raw('sum(price) AS accumulatedSales'))
            ->where('date', '>=', $dateFrom)->where('date', '<=', $dateTo)
            ->groupBy('employees.name')
            ->orderBy('accumulatedSales', 'DESC')->get()->toArray();

        // Add Rank for Employees
        $areas = array_map(function ($sales) {
            static $rank = 1;
            $sales['rank'] = $rank;
            $sales['accumulatedSales'] = self::CURRENCY_SIGN . " " . round($sales['accumulatedSales'], 2);
            $rank++;
            return $sales;
        }, $salesData);

        return $areas;
    }
}
