<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class KomerceService
{
    protected string $baseUrl;
    protected string $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('services.komerce.base_url');
        $this->apiKey  = config('services.komerce.key');
    }

    protected function headers()
    {
        return [
            'Authorization' => $this->apiKey,
            'Accept'        => 'application/json',
        ];
    }

    /**
     * GET Domestic Destination (kota/kecamatan)
     */
    public function getDomesticDestination(array $params = [])
    {
        return Http::withHeaders($this->headers())
            ->get($this->baseUrl . '/shipping/domestic-destination', $params)
            ->json();
    }

    /**
     * POST Domestic Cost (hitung ongkir)
     */
    public function calculateDomesticCost(array $payload)
    {
        return Http::withHeaders($this->headers())
            ->post($this->baseUrl . '/shipping/domestic-cost', $payload)
            ->json();
    }
}
