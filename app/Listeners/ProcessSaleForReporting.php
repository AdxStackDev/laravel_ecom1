<?php

namespace App\Listeners;

use App\Events\ProductSold;
use App\Jobs\GenerateSalesReport;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ProcessSaleForReporting implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\ProductSold  $event
     * @return void
     */
    public function handle(ProductSold $event)
    {
        GenerateSalesReport::dispatch($event->productId);
    }
}
