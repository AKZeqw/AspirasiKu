<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class RegisterController extends Controller
{
    /**
     * Show the registration form.
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|ends_with:@mail.unej.ac.id|unique:users',
            'nim' => 'required|string|size:12|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'email.ends_with' => 'Email harus menggunakan domain @mail.unej.ac.id',
            'nim.size' => 'NIM harus 12 digit',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'nim' => $request->nim,
            'password' => Hash::make($request->password),
            'role' => 'mahasiswa',
        ]);

        auth()->login($user);

        return redirect()->route('mahasiswa.dashboard')->with('success', 'Registrasi berhasil!');
    }
}
