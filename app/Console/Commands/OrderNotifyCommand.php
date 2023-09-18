<?php

namespace App\Console\Commands;

use App\Jobs\SendOrderNotify;
use App\Service\OrderService;
use App\Service\UserService;
use Illuminate\Console\Command;

class OrderNotifyCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send-order-notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        dispatch(new SendOrderNotify(new OrderService(), new UserService()));
    }
}
