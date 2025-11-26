<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('mahasiswa.profile.edit');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nim' => 'required|string|size:12|unique:users,nim,' . auth()->id(),
        ]);

        auth()->user()->update($request->only('name', 'nim'));

        return back()->with('success', 'Profil berhasil diupdate!');
    }

    public function updatePassword(Request $request)
    {
        $user = auth()->user();
        $isGoogleUser = !empty($user->google_id);

        $request->validate([
            'current_password' => $isGoogleUser ? 'nullable' : 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if (! $isGoogleUser) {
            if (! Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Password saat ini salah']);
            }
        }
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', 'Password berhasil diubah!');
    }
}
