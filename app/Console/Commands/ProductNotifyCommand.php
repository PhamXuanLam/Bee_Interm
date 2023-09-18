<?php

namespace App\Console\Commands;

use App\Jobs\SendProductNotification;
use App\Service\ProductService;
use App\Service\UserService;
use Illuminate\Console\Command;

class ProductNotifyCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send-product-notification';

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
        dispatch(new SendProductNotification(new UserService(), new ProductService()));
    }
}
