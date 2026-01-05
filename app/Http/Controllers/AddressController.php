<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class AddressController extends Controller
{
    public function setDefault(Address $address)
    {
        abort_if($address->user_id !== Auth::id(), 403);

        Address::where('user_id', Auth::id())
            ->update(['is_default' => false]);

        $address->update(['is_default' => true]);

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Alamat default diperbarui',
                'address' => $address,
            ]);
        }

        return back()->with('success', 'Alamat default diperbarui');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'province' => 'required',
            'city' => 'required',
            'district' => 'required',
            'subdistrict' => 'required',
            'postal_code' => 'required',
            'extra_detail' => 'required',
        ]);

        [$provinceId, $provinceName] = explode('|', $request->province);
        [$cityId, $cityName] = explode('|', $request->city);
        [$districtId, $districtName] = explode('|', $request->district);
        [$subId, $subName] = explode('|', $request->subdistrict);

        if (! $provinceName || ! $cityName || ! $districtName || ! $subName) {
            return back()->withErrors([
                'address' => 'Data wilayah tidak valid, silakan pilih ulang alamat',
            ]);
        }

        Address::where('user_id', Auth::id())->update(['is_default' => false]);

        Address::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'province_id' => $provinceId,
            'province_name' => $provinceName,
            'city_id' => $cityId,
            'city_name' => $cityName,
            'district_id' => $districtId,
            'district_name' => $districtName,
            'subdistrict_id' => $subId,
            'subdistrict_name' => $subName,
            'postal_code' => $request->postal_code,
            'extra_detail' => $request->extra_detail,
            'is_default' => true,
        ]);

        return back()->with('success', 'Alamat berhasil disimpan');
    }

    private function komerce()
    {
        return Http::withHeaders([
            'Accept' => 'application/json',
            'key' => config('services.komerce.key'),
        ])->baseUrl(rtrim(config('services.komerce.base_url'), '/'));
    }

    public function provinces()
    {
        $response = $this->komerce()->get('/api/v1/destination/province');

        // Memeriksa apakah permintaan berhasil
        if ($response->successful()) {

            // Mengambil data provinsi dari respons JSON
            // Jika 'data' tidak ada, inisialisasi dengan array kosong
            $provinces = $response->json()['data'] ?? [];
        }

        // returning the  with provinces data
        return response()->json($provinces);
    }

    public function cities($provinceId)
    {
        $res = $this->komerce()->get("/api/v1/destination/city/{$provinceId}");

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
