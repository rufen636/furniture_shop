<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;

class GoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'go';

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
        $product = Product::first();
        $data = ['title' => 'chair'];
//        dd($product->filter($data));
    }
}
