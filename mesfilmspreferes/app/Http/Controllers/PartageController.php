<?php

namespace App\Http\Controllers;

use App\Models\Partage;
use App\Models\Favori;
use App\Models\FriendUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PartageController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        
        // Récupérer les IDs des amis
        $friendIds = FriendUser::where('user_id', $userId)
            ->pluck('friend_id')
            ->merge(
                FriendUser::where('friend_id', $userId)
                    ->pluck('user_id')
            )
            ->unique()
            ->toArray();

        // Récupérer les partages reçus (partagés par les amis)
        $partages = Partage::whereIn('user_id', $friendIds)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('partages', compact('partages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'favori_id' => 'required|exists:favoris,id',
            'friend_id' => 'required|exists:users,id',
            'message' => 'nullable|string|max:500',
        ]);

        $favori = Favori::where('id', $request->favori_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Vérifier que c'est bien un ami
        $isFriend = FriendUser::where(function($query) use ($request) {
            $query->where('user_id', Auth::id())
                ->where('friend_id', $request->friend_id);
        })->orWhere(function($query) use ($request) {
            $query->where('user_id', $request->friend_id)
                ->where('friend_id', Auth::id());
        })->exists();

        if (!$isFriend) {
            return redirect()->back()->with('error', 'Vous ne pouvez partager qu\'avec vos amis.');
        }

        Partage::create([
            'user_id' => Auth::id(),
            'favori_id' => $favori->id,
            'film_title' => $favori->film_title,
            'film_poster_path' => $favori->film_poster_path,
            'film_tmdb_id' => $favori->favori_id,
            'friend_id' => $request->friend_id,
            'message' => $request->message,
            'avis' => $favori->avis,
        ]);

        return redirect()->back()->with('success', 'Film partagé avec succès !');
    }

    public function destroy($id)
    {
        $partage = Partage::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $partage->delete();

        return redirect()->route('partages.index')->with('success', 'Partage supprimé.');
    }
}
