<?php

namespace App\Jobs;

use App\Models\Sales;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class SalesCsvProcess implements ShouldQueue
{
    use Queueable;

    public $header;
    public $data;

    /**
     * Create a new job instance.
     */
    public function __construct($header, $data)
    {
        $this->header = $header;
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach ($this->data as $sale_data) {
            $sales_data = array_combine($this->header, $sale_data);
            Sales::create($sales_data);
        }
    }
}
