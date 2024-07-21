<?php

namespace App\Console\Commands;

use App\Mail\PriceMail;
use App\Models\Cryptocurrency;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class CheckPriceChanges extends Command
{
    protected $signature = 'crypto:check-price-changes';
    protected $description = 'Check for cryptocurrency price changes';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): void
    {
        $cryptocurrencies = Cryptocurrency::all();

        foreach ($cryptocurrencies as $crypto) {
            $oldPrice = $crypto->price;
            $newPrice = Cryptocurrency::where('symbol', $crypto->symbol)->latest('timestamp')->first()->price;
            $priceChange = (($newPrice - $oldPrice) / $oldPrice) * 100;

            if (abs($priceChange) > 10) {
                Mail::to(env('ADMIN_EMAIL'))->send(new PriceMail($crypto, $priceChange));
            }
        }

        $this->info('Price changes checked and notifications sent if necessary.');
    }
}
