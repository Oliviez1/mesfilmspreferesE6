<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\FriendUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AmisController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        
        // Récupérer les amis (relations bidirectionnelles)
        $amis = User::whereIn('id', function($query) use ($userId) {
            $query->select('friend_id')
                ->from('friend_user')
                ->where('user_id', $userId);
        })
        ->orWhereIn('id', function($query) use ($userId) {
            $query->select('user_id')
                ->from('friend_user')
                ->where('friend_id', $userId);
        })
        ->where('id', '!=', $userId)
        ->get();

        return view('amis', compact('amis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
        ]);

        // Trouver l'utilisateur par username ou email
        $friend = User::where('username', $request->username)
            ->orWhere('email', $request->username)
            ->first();

        if (!$friend) {
            return redirect()->route('amis.index')->with('error', 'Utilisateur non trouvé.');
        }

        if ($friend->id == Auth::id()) {
            return redirect()->route('amis.index')->with('error', 'Vous ne pouvez pas vous ajouter vous-même.');
        }

        // Vérifier si l'amitié existe déjà
        $existing = FriendUser::where(function($query) use ($friend) {
            $query->where('user_id', Auth::id())
                ->where('friend_id', $friend->id);
        })->orWhere(function($query) use ($friend) {
            $query->where('user_id', $friend->id)
                ->where('friend_id', Auth::id());
        })->first();

        if ($existing) {
            return redirect()->route('amis.index')->with('error', 'Cet utilisateur est déjà dans vos amis.');
        }

        FriendUser::create([
            'user_id' => Auth::id(),
            'friend_id' => $friend->id,
        ]);

        return redirect()->route('amis.index')->with('success', 'Ami ajouté avec succès !');
    }

    public function destroy($id)
    {
        $userId = Auth::id();
        
        // Supprimer la relation d'amitié (bidirectionnelle)
        FriendUser::where(function($query) use ($userId, $id) {
            $query->where('user_id', $userId)
                ->where('friend_id', $id);
        })->orWhere(function($query) use ($userId, $id) {
            $query->where('user_id', $id)
                ->where('friend_id', $userId);
        })->delete();

        return redirect()->route('amis.index')->with('success', 'Ami retiré avec succès.');
    }
}
