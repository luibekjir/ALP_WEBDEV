<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Password;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function login()
    {
        return view('login');
    }

    public function register()
    {
        return view('register');
    }

    public function forgotPassword()
    {
        return view('forgot-password');
    }

    public function profile()
    {
        $user = Auth::user();
        $orders = $user->orders()
            ->with(['items.product'])
            ->latest()
            ->get();

        $events = $user->events()
            ->withPivot('registered_at')
            ->orderByPivot('registered_at', 'desc')
            ->get();

        $defaultAddress = $user->defaultAddress;
        $addresses = $user->addresses;

        // Fetch provinces from Komerce API
        $provinces = [];
        try {
            $response = Http::withHeaders([
                'key' => config('services.komerce.key'),
            ])->get(
                rtrim(config('services.komerce.base_url'), '/').'/api/v1/destination/province'
            );

            $provinces = $response->successful()
                ? $response->json('data')
                : [];

        } catch (\Exception $e) {
            $provinces = [];
        }

        return view('profile', compact(
            'user',
            'orders',
            'events',
            'addresses',
            'defaultAddress',
            'provinces'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|min:6|confirmed',

            'address' => 'required|string',
            'subdistrict' => 'required|string',
            'district' => 'required|string',
            'city' => 'required|string',
            'zip_code' => 'required|string',
        ]);

        // Split id|name untuk city, district, subdistrict
        [$cityId, $cityName] = explode('|', $validated['city']);
        [$districtId, $districtName] = explode('|', $validated['district']);
        [$subdistrictId, $subdistrictName] = explode('|', $validated['subdistrict']);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'password' => Hash::make($validated['password']),
            'role' => 'user',
        ]);

        // 2️⃣ Buat address pertama (DEFAULT)
        Address::create([
            'user_id' => $user->id,
            'address' => $validated['address'],
            'city_id' => $cityId,
            'city_name' => $cityName,
            'district_id' => $districtId,
            'district_name' => $districtName,
            'subdistrict_id' => $subdistrictId,
            'subdistrict_name' => $subdistrictName,
            'zip_code' => $validated['zip_code'],
            'is_default' => true,
        ]);

        return redirect('/login')->with('success', 'User created successfully!');
    }

    public function authLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('status', __($status));
        }

        return back()->withErrors(['email' => __($status)]);
    }

    public function showResetForm(Request $request, $token)
    {
        return view('reset-password', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => bcrypt($password),
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect('/login')->with('status', 'Password telah direset. Silakan login dengan password baru Anda.');
        }

        return back()->withErrors(['email' => __($status)]);
    }

    // public function profile(User $user, Order $order)
    // {
    //     // Check if user is authorized
    //     if (Auth::id() !== $user->id && Auth::user()->role !== 'admin') {
    //         return redirect('/')->with('error', 'Unauthorized');
    //     }
    //     $orders = $user->orders()
    //     ->with(['items.product'])
    //     ->latest()
    //     ->get();

    // return view('profile', compact('user', 'orders'));
    // }

    public function updateProfile(Request $request, User $user)
    {
        if (Auth::id() !== $user->id) {
            return redirect('/')->with('error', 'Unauthorized');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'nullable|string',
            'password' => 'required|confirmed|min:6',

            // ADDRESS WAJIB
            'address' => 'required|string',
            'subdistrict' => 'required|string',
            'district' => 'required|string',
            'city' => 'required|string',
            'zip_code' => 'required|string',
        ]);

        $user->update($validated);

        return redirect('/profile')->with('success', 'Profil berhasil diperbarui!');
    }

    public function changePasswordForm()
    {
        $user = Auth::user();

        return view('change-password', compact('user'));
    }

    public function updatePassword(Request $request, User $user)
    {
        if (Auth::id() !== $user->id) {
            return redirect('/')->with('message', 'Unauthorized');
        }

        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        if (! Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with(['message' => 'Password saat ini tidak sesuai!']);
        }

        if ($request->password_confirmation != $request->password) {
            return redirect()->back()->with('message', 'Password Baru dan Konfirmasi Password tidak sama!');
        }

        $user->update(['password' => bcrypt($request->password)]);

        return redirect('/profile')->with('success', 'Password berhasil diubah');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('');
    }

    public function destroy()
    {
        $user = Auth::user();

        Auth::logout();

        $user->delete();

        return redirect('/');
    }
}
