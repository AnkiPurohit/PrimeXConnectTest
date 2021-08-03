<?php

namespace App\Jobs;

use App\Models\Product;
use App\Models\Stock;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessImportStock implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data;
    public $header;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data   = $data;
        //  $this->header = $header;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        if ($this->batch()->cancelled()) {
            // Determine if the batch has been cancelled...
            return;
        }
        foreach ($this->data as $stock) {
            $productId = Product::where('code', $stock[0])->value('id');
            $productionDate = Carbon::createFromFormat('d/m/Y', $stock[2]);
            if ($productId) {
                $stockData['product_id'] = $productId;
                $stockData['on_hand'] = $stock[1];
                $stockData['production_date'] =   $productionDate;
                Stock::create($stockData);
            }
        }
    }
}
