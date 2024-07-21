<?php

namespace App\Console\Commands;

use Exception;
use App\Models\Cryptocurrency;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class FetchCryptoPrices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crypto:fetch-prices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch and store cryptocurrency prices';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        try {
            $url = 'https://api.coingecko.com/api/v3/coins/markets';
            $data = [
                'vs_currency' => 'usd',
                'order' => 'market_cap_desc',
                'per_page' => 10,
                'page' => 1,
                'sparkline' => false,
            ];
            $response = Http::timeout(30)
                ->retry(3, 100)
                ->withHeaders(['Content-Type' => 'application/json','X-CMC_PRO_API_KEY'=>env('CONINMARKETCAP')])
                ->withOptions([
                    'curl' => [
                        CURLOPT_SSL_CIPHER_LIST => 'DEFAULT@SECLEVEL=1',
                    ],
                ])->get($url, $data);

            if ($response->successful()) {
                $cryptos = json_decode($response->body(), true);
                foreach ($cryptos as $crypto) {
                    Cryptocurrency::updateOrCreate(
                        ['symbol' => $crypto['symbol']],
                        [
                            'name' => $crypto['name'],
                            'price' => $crypto['current_price'],
                            'timestamp' => now(),
                        ]
                    );
                }
                $this->info('Cryptocurrency prices fetched and stored successfully.');

            } else {
                Log::error('Failed to fetch CryptoPrice', [
                    'status' => $response->status(),
                    'response' => $response->body(),
                ]);
                $this->info('Cryptocurrency prices fetched error!');
            }
        } catch (Exception $exception) {
            Log::error('HTTP request failed', ['message' => $exception->getMessage()]);
            $this->info($exception->getMessage());
        }
    }
}
