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

        // Films sauvegardés
        $favoris = collect();
        try { $favoris = \App\Models\Favori::where('user_id', $user->id)->orderByDesc('created_at')->get(); } catch (\Exception $e) {}

        // Films notés (ceux qui ont une note)
        $favorisNotes = collect();
        try { $favorisNotes = \App\Models\Favori::where('user_id', $user->id)->whereNotNull('note')->orderByDesc('created_at')->get(); } catch (\Exception $e) {}

        $notesCount = $favorisNotes->count();

        // Nombre d'amis
        $amisCount = 0;
        try {
            $amisCount = \App\Models\User::where(function($q) use ($user) {
                $q->whereHas('amis', fn($q2) => $q2->where('ami_id', $user->id)->where('statut', 'accepte'))
                  ->orWhereHas('demandesAmis', fn($q2) => $q2->where('user_id', $user->id)->where('statut', 'accepte'));
            })->count();
        } catch (\Exception $e) {}

        return view('profil', compact('favoris', 'favorisNotes', 'notesCount', 'amisCount'));
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

        return redirect()->route('profil.show')->with('success', 'Profil mis à jour.');
    }
}
