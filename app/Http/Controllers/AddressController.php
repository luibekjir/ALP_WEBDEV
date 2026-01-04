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

        // 🔥 DESTINATION ID DARI SUBDISTRICT
        $dest = $this->komerce()
            ->get("/api/v1/destination/sub-district/{$districtId}")
            ->json('data');

        $destinationId = collect($dest)
            ->firstWhere('id', (int) $subId)['destination_id'] ?? null;

        if (! $destinationId) {
            return back()->withErrors(['subdistrict' => 'Destination tidak ditemukan']);
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
            'destination_id' => $destinationId,
            'is_default' => true,
        ]);

        return back()->with('success', 'Alamat berhasil disimpan');
    }

    private function komerce()
    {
        return Http::withHeaders([
            'key' => config('services.komerce.key'),
        ])->baseUrl(rtrim(config('services.komerce.base_url'), '/'));
    }

    public function provinces()
    {
        $res = $this->komerce()->get('/api/v1/destination/province');

        return response()->json($res->json('data') ?? []);
    }

    public function cities($provinceId)
    {
        $res = $this->komerce()->get("/api/v1/destination/city/{$provinceId}");

        return response()->json($res->json('data') ?? []);
    }

    public function districts($cityId)
    {
        $res = $this->komerce()->get("/api/v1/destination/district/{$cityId}");

        return response()->json($res->json('data') ?? []);
    }

    public function subdistricts($districtId)
    {
        $res = $this->komerce()->get("/api/v1/destination/sub-district/{$districtId}");

        return response()->json($res->json('data') ?? []);
    }
}
