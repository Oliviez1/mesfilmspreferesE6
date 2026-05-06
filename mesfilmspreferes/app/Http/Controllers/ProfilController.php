<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller
{
    public function show()
    {
        if (!Auth::check()) return redirect()->route('login');

        $user = Auth::user();

        // Tous les films en liste
        $favoris = collect();
        try {
            $favoris = \App\Models\Favori::where('user_id', $user->id)
                ->orderByDesc('created_at')
                ->get();
        } catch (\Exception $e) {}

        // Nombre de films avec une note
        $notesCount = $favoris->filter(fn($f) => !is_null($f->note) && $f->note > 0)->count();

        // Nombre d'amis
        $amisCount = 0;
        try {
            $amisCount = \App\Models\FriendUser::where('user_id', $user->id)
                ->orWhere('friend_id', $user->id)
                ->distinct()
                ->count();
        } catch (\Exception $e) {}

        return view('profil', compact('favoris', 'notesCount', 'amisCount'));
    }

    public function update(Request $request)
    {
        if (!Auth::check()) return redirect()->route('login');

        $user = Auth::user();

        $rules = [
            'firstname' => 'required|string|max:255',
            'lastname'  => 'required|string|max:255',
            'username'  => 'required|string|max:255|unique:users,username,' . $user->id,
            'email'     => 'required|email|max:255|unique:users,email,' . $user->id,
        ];
        if ($request->filled('password')) {
            $rules['password'] = 'string|min:8';
        }

        $validated = $request->validate($rules);

        $user->firstname = $validated['firstname'];
        $user->lastname  = $validated['lastname'];
        $user->username  = $validated['username'];
        $user->email     = $validated['email'];
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return redirect()->route('profil.show')->with('success', 'Profil mis a jour.');
    }
}
