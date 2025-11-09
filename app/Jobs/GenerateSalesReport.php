<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class GenerateSalesReport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The product ID.
     *
     * @var int
     */
    protected $productId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $productId)
    {
        $this->productId = $productId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // In a real application, you would generate a sales report here.
        // For now, we'll just log a message.
        Log::info("Generating sales report for product: {$this->productId}");
    }
}
