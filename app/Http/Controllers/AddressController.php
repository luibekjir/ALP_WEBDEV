<?php
use App\Models\Address;
use Illuminate\Support\Facades\Auth;

public function setDefault(Address $address)
{
    abort_if($address->user_id !== Auth::id(), 403);

    // reset semua
    Address::where('user_id', Auth::id())
        ->update(['is_default' => false]);

    // set yang dipilih
    $address->update(['is_default' => true]);

    return back()->with('success', 'Alamat default diperbarui');
}

    public function store(Request $request)
    {
        $request->validate([
            'receiver_name' => 'required',
            'phone'         => 'required',
            'address'       => 'required',
            'city'          => 'required',
            'district'      => 'required',
            'zip_code'      => 'required',
        ]);

        // 🔹 HIT API KOMERCE (DOMESTIC DESTINATION)
        $response = Http::withHeaders([
            'key' => config('services.komerce.key'),
        ])->get(
            'https://sandbox.komerce.id/api/v1/shipping/domestic-destination',
            [
                'search' => $request->city,
            ]
        );

        $destinationId = $response['data'][0]['id'] ?? null;

        if (!$destinationId) {
            return back()->withErrors('Kota tidak ditemukan di sistem pengiriman');
        }

        $user = Auth::user();

        // nonaktifkan default lama
        $user->addresses()->update(['is_default' => false]);

        // simpan alamat baru + destination_id
        $user->addresses()->create([
            'receiver_name'  => $request->receiver_name,
            'phone'          => $request->phone,
            'address'        => $request->address,
            'city'           => $request->city,
            'district'       => $request->district,
            'zip_code'       => $request->zip_code,
            'destination_id' => $destinationId,
            'is_default'     => true,
        ]);

        return back()->with('success', 'Alamat berhasil disimpan');
    }
 

