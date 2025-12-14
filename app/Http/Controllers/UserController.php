<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
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
    public function profile(){
        $user = Auth::user();
        return view('profile', compact('user'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|min:6|confirmed',
            'phone'     => 'required|string|max:20',
            'address'   => 'required|string|max:255',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'role' => 'user',
        ]);

        return redirect('/login')->with('success', 'User created successfully!');
    }
    public function authLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
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

    public function showProfile(User $user)
    {
        // Check if user is authorized
        if (Auth::id() !== $user->id && Auth::user()->role !== 'admin') {
            return redirect('/')->with('error', 'Unauthorized');
        }
        return view('profile', compact('user'));
    }


    public function updateProfile(Request $request, User $user)
    {
        if (Auth::id() !== $user->id) {
            return redirect('/')->with('error', 'Unauthorized');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:1000',
        ]);

        $user->update($validated);

        return redirect()->route('profile.show', $user)->with('success', 'Profil berhasil diperbarui');
    }

    public function changePasswordForm(User $user)
    {
        if (Auth::id() !== $user->id) {
            return redirect('/')->with('error', 'Unauthorized');
        }
        return view('change-password', compact('user'));
    }

    public function updatePassword(Request $request, User $user)
    {
        if (Auth::id() !== $user->id) {
            return redirect('/')->with('error', 'Unauthorized');
        }

        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai']);
        }

        $user->update(['password' => bcrypt($request->password)]);

        return redirect()->route('profile.show', $user)->with('success', 'Password berhasil diubah');
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('');

    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }


    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
