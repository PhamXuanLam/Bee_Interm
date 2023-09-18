<?php

namespace App\Jobs;

use App\Mail\ProductNotificationMail;
use App\Service\ProductService;
use App\Service\UserService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendProductNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public UserService $userService;

    public ProductService $productService;

    public function __construct(UserService $userService, ProductService $productService)
    {
        $this->userService = $userService;

        $this->productService = $productService;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $products = $this->productService->getProductsWhereStockLessThanTen();

        $users = $this->userService->getUsers();

        if ($users->isNotEmpty())
            foreach ($users as $user) {
                Mail::to($user->email)
                    ->send(new ProductNotificationMail($products));
            }
    }
}
