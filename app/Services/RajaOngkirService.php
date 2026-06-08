<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class RajaOngkirService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = env('RAJAONGKIR_API_KEY');
    }

    public function calculate($destination, $weight = 1000)
    {
        try {
            $response = Http::withHeaders([
                'key' => $this->apiKey
            ])
            ->timeout(15)
            ->asForm()
            ->post(
                'https://api.rajaongkir.com/starter/cost',
                [
                    'origin' => env('RAJAONGKIR_ORIGIN_ID', '65177'),
                    'destination' => $destination,
                    'weight' => $weight,
                    'courier' => 'jne'
                ]
            );

            if ($response->successful()) {
                return $response->json();
            }

            return [
                'success' => false,
                'status' => $response->status(),
                'message' => 'API Error: ' . $response->status()
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
}
