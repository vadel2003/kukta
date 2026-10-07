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
            'name' => ['required', 'string', 'max:30', 'unique:user,name,' . $user->id . ',id'],
            'email' => ['required', 'string', 'email', 'max:50', 'unique:user,email,' . $user->id . ',id'],
            // A böngésző a feltöltés előtt 100x100-as JPEG-re vágja a képet (profile/index.blade.php).
            // A JS megkerülhető, ezért itt is ellenőrizzük: más méret/formátum nem jöhet be.
            'avatar' => ['nullable', 'image', 'mimes:jpeg', 'dimensions:width=100,height=100', 'max:2048'],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if ($request->hasFile('avatar')) {
            // Régi kép törlése, ha van
            if ($user->avatar && file_exists(public_path($user->avatar))) {
                unlink(public_path($user->avatar));
            }

            // Új kép mentése - a kiterjesztés fixen .jpg (a validáció csak JPEG-et enged),
            // nem a feltöltő által megadott fájlnévből vesszük
            $filename = $user->id . '_' . time() . '.jpg';
            $request->file('avatar')->move(public_path('avatars'), $filename);
            $user->avatar = 'avatars/' . $filename;
        } elseif ($request->boolean('remove_avatar') && $user->avatar) {
            // "Eltávolítás" link - visszaáll az alapértelmezett avatarra
            if (file_exists(public_path($user->avatar))) {
                unlink(public_path($user->avatar));
            }
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

        $user->password = $validated['new_password'];
        $user->save();

        return redirect()->route('profile.index')->with('success', 'Jelszó sikeresen frissítve!');
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = Auth::user();

        // A szuperadmin fiókja nem törölhető. A panel neki meg sem jelenik, de a kérés
        // kézzel is elküldhető, ezért itt is ellenőrizzük.
        if ($user->isAdmin()) {
            abort(403);
        }

        Auth::logout();

        // A profilkép fájlját a User modell deleting eseménye törli (User::booted())
        $user->delete();

        return redirect()->route('home');
    }
}

