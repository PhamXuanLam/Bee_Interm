<?php

namespace App\Jobs;

use App\Mail\OrderNotifyMail;
use App\Service\OrderService;
use App\Service\UserService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendOrderNotify implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public OrderService $orderService;
    public UserService $userService;
    public function __construct(OrderService $orderService, UserService $userService)
    {
        $this->orderService = $orderService;
        $this->userService = $userService;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $customers = $this->orderService->getCustomer();
        foreach ($customers as $customer) {
            $orders = $this->orderService->getOrdersByCustomerId($customer->customer_id)->toArray();
            $data[$customer->customer->full_name] = $this->orderService->getOrderDetails($orders);
        }
        $users = $this->userService->getUsers();
        if ($users->isNotEmpty())
            foreach ($users as $user) {
                Mail::to($user->email)
                    ->send(new OrderNotifyMail($data, $customers));
            }
    }
}
