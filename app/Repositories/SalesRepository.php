<?php

namespace App\Repositories;

use App\Models\Sales;
use Carbon\Carbon;

/**
 * Layer to handle datastore operations. Can be a local operation or external datastore
 */
class SalesRepository 
{
    const EXPORT_LOCATION = "exports/sales/";

    /**
     * Variable to hold injected dependency
     *
     * @var Sales
     */
    protected $sales;

    /**
     * Initializing the instances and variables
     *
     * @param Sales $sales
     */
    public function __construct(Sales $sales)
    {
        $this->sales = $sales;
    }

    /**
     * Fetching all sales data
     *
     * @return array
     */
    public function getAllSalesData()
    {
        return Sales::all()->toArray();
    }

    public function store($data) 
    {
        // $date = \date_parse($data['date']);
        $salesDate = Carbon::createFromFormat('Y-m-d\TH:i:s.uP', $data['date'])->format('Y-m-d');
        $data['date'] = $salesDate;
        $sales = Sales::create($data);
        return $sales->id;
    }

    public function getSalesDataForGrid($data)
    {
        $dateFrom = Carbon::createFromFormat('d/m/Y', $data['from'])->format('Y-m-d');
        $dateTo = Carbon::createFromFormat('d/m/Y', $data['to'])->format('Y-m-d');
        $customerId= $data['customer_id'];
        $employeeId= $data['employee_id'];
        $salesQuery = Sales::where('date', '>=', $dateFrom)->where('date', '<=', $dateTo);
        if($customerId != 0) {
            $salesQuery->where('customer_id', $customerId);
        }
        if($employeeId != 0) {
            $salesQuery->where('employee_id', $employeeId);
        }   
        return $salesQuery->get()->toArray();
    }
}
