<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | HALAMAN LOGIN
    |--------------------------------------------------------------------------
    */
    public function loginPage()
    {
        return view('auth.login');
    }

    /*
    |--------------------------------------------------------------------------
    | PROSES LOGIN
    |--------------------------------------------------------------------------
    */
    public function loginProcess(Request $request)
    {
        $request->validate([
            'nik' => 'required|digits:16',
            'password' => 'required'
        ], [
            'nik.required' => 'NIK wajib diisi.',
            'nik.digits' => 'NIK harus tepat 16 digit angka.'
        ]);

        $credentials = [
            'nik' => $request->nik,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials)) {

            $user = Auth::user();

            // Redirect sesuai role
            if ($user->hasRole('admin') || $user->hasRole('manager')) {
                return redirect()->route('admin.dashboard');
            }

            // Default ke dashboard user
            return redirect()->route('user.dashboard');
        }

        return back()->with('error', 'NIK atau Password salah!');
    }

    /*
    |--------------------------------------------------------------------------
    | HALAMAN REGISTER
    |--------------------------------------------------------------------------
    */
    public function registerPage()
    {
        return view('auth.register');
    }

    /*
    |--------------------------------------------------------------------------
    | PROSES REGISTER
    |--------------------------------------------------------------------------
    */
    public function registerProcess(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'nik' => 'required|digits:16|unique:users,nik',
            'password' => 'required|min:8|confirmed'
        ], [
            'nik.required' => 'NIK wajib diisi.',
            'nik.digits' => 'NIK harus tepat 16 digit angka.',
            'nik.unique' => 'NIK sudah terdaftar.',
            'password.min' => 'Password minimal 8 karakter.'
        ]);

        $user = User::create([
            'name' => $request->name,
            'nik' => $request->nik,
            'password' => Hash::make($request->password),
            'status' => 'approved' // ✅ langsung aktif
        ]);

        // Role default user
        $role = \App\Models\Role::where('name', 'user')->first();
        if ($role) {
            $user->roles()->attach($role->id);
        }

        return redirect()->route('login')
            ->with('success', 'Register berhasil! Silakan login.');
    }

    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('landing');
    }
}