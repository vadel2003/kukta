<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
            'name' => ['required', 'string', 'min:3', 'max:30', 'unique:user,name,' . $user->id . ',id'],
            'email' => ['required', 'string', 'email', 'min:6', 'max:254', 'unique:user,email,' . $user->id . ',id'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
        ], [
            'avatar.image' => 'Csak JPG, PNG vagy WebP képet tölthetsz fel!',
            'avatar.mimes' => 'Csak JPG, PNG vagy WebP képet tölthetsz fel!',
            'avatar.max' => 'A kép legfeljebb 2 MB lehet!',
            'avatar.uploaded' => 'A kép legfeljebb 2 MB lehet!',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if ($request->hasFile('avatar')) {
            $user->deleteAvatarFile();
            $filename = $user->id . '_' . time() . '.' . $request->file('avatar')->extension();
            $request->file('avatar')->move(public_path('avatars'), $filename);
            $user->avatar = 'avatars/' . $filename;
        } elseif ($request->has('remove_avatar')) {
            $user->deleteAvatarFile();
            $user->avatar = null;
        }

        $user->save();

        return redirect()->route('profile.index')->with('success', 'Alapadatok sikeresen frissítve!');
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'new_password' => ['required', 'string', 'min:8', 'max:50', 'confirmed'],
        ]);

        $user->password = Hash::make($validated['new_password']);
        $user->save();

        return redirect()->route('profile.index')->with('success', 'Jelszó sikeresen frissítve!');
    }

    /**
     * Deletes the current user's account. The super admin account cannot be deleted.
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = Auth::user();

        if ($user->isAdmin()) {
            abort(403);
        }

        Auth::logout();
        $user->deleteAvatarFile();
        $user->delete();

        return redirect()->route('home');
    }
}
