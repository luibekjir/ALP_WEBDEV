
<?php

namespace App\Http\Controllers;

class KomerceController extends Controller
{
    public function provinces()
    {
        $res = \Illuminate\Support\Facades\Http::withHeaders([
            'key' => config('services.komerce.key'),
        ])->get('https://rajaongkir.komerce.id/api/v1/destination/province');

        return response()->json($res['data'] ?? []);
    }

    public function cities($provinceId)
{
    $res = Http::withHeaders([
        'key' => config('services.komerce.key'),
    ])->get("https://rajaongkir.komerce.id/api/v1/destination/city/{$provinceId}");

    if (! $res->successful()) {
        Log::error('Komerce cities error', [
            'status' => $res->status(),
            'body' => $res->body(),
        ]);

        return response()->json([], 200); // ← PENTING: JANGAN 500
    }

    return response()->json($res->json('data') ?? []);
}

    public function districts($cityId)
    {
        $res = \Illuminate\Support\Facades\Http::withHeaders([
            'key' => config('services.komerce.key'),
        ])->get("https://rajaongkir.komerce.id/api/v1/destination/district/{$cityId}");

        return response()->json($res['data'] ?? []);
    }

    public function subdistricts($districtId)
    {
        $res = \Illuminate\Support\Facades\Http::withHeaders([
            'key' => config('services.komerce.key'),
        ])->get("https://rajaongkir.komerce.id/api/v1/destination/sub-district/{$districtId}");

        return response()->json($res['data'] ?? []);
    }
}
