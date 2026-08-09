<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.index');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'username' => ['required', 'string', 'max:30', 'unique:user,username,' . $user->id . ',id'],
            'email' => ['required', 'string', 'email', 'max:50', 'unique:user,email,' . $user->id . ',id'],
            'current_password' => ['required', 'current_password'],
            'new_password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ]);

        $user->username = $validated['username'];
        $user->email = $validated['email'];

        if ($validated['new_password']) {
            $user->password = $validated['new_password'];
        }

        if ($request->hasFile('avatar')) {
            // Régi kép törlése, ha van
            if ($user->avatar && file_exists(public_path($user->avatar))) {
                unlink(public_path($user->avatar));
            }

            // Új kép mentése
            $file = $request->file('avatar');
            $filename = $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('avatars'), $filename);
            $user->avatar = 'avatars/' . $filename;
        }

        $user->save();

        return redirect()->route('profile.index')->with('success', 'Profil adatai sikeresen frissítve!');
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = Auth::user();

        Auth::logout();

        $user->delete();

        return redirect()->route('home');
    }
}

