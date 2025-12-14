<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class PricingCheck extends Component
{
    public $destinations = [];
    public $keyword = '53131';

    public function mount()
    {
        $this->fetchDestinations();
    }

    public function fetchDestinations()
    {
        $response = Http::withHeaders([
            'x-api-key' => config('services.komerce.key'),
        ])->get(config('services.komerce.url') . '/tariff/api/v1/destination/search', [
            'keyword' => $this->keyword,
        ]);

        if ($response->successful()) {
            $this->destinations = $response->json('data') ?? [];
        } else {
            $this->destinations = [];
        }
    }

    public function updatedKeyword()
    {
        if (strlen($this->keyword) >= 3) {
            $this->fetchDestinations();
        }
    }

    public function render()
    {
        return view('livewire.pricing-check');
    }
}
