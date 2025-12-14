<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;

class PricingCheck extends Component
{
    public $keyword = '';
    public $destinations = [];
    public $selectedDestination = null;
    public $showDropdown = false;

    public function updatedKeyword()
    {
        if (strlen($this->keyword) < 3) {
            $this->destinations = [];
            $this->showDropdown = false;
            return;
        }

        try {
            $response = Http::withHeaders([
                'x-api-key' => config('services.komerce.key'),
            ])
            ->timeout(5)
            ->get(config('services.komerce.url') . '/tariff/api/v1/destination/search', [
                'keyword' => $this->keyword,
            ]);

            if ($response->successful()) {
                $this->destinations = $response->json('data') ?? [];
                $this->showDropdown = true;
                return;
            }
        } catch (ConnectionException $e) {
            // fallback dummy
        }

        // fallback agar demo tetap jalan
        $this->destinations = [
            [
                'id' => 72910,
                'label' => 'KEDUNGWULUH, PURWOKERTO BARAT, BANYUMAS, 53131',
            ],
            [
                'id' => 72911,
                'label' => 'KOBER, PURWOKERTO BARAT, BANYUMAS, 53132',
            ],
        ];
        $this->showDropdown = true;
    }

    public function selectDestination($id, $label)
    {
        $this->selectedDestination = $id;
        $this->keyword = $label;
        $this->showDropdown = false;

        // nanti di sini panggil calculateShipping()
    }

    public function render()
    {
        return view('livewire.pricing-check');
    }
}
