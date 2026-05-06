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

        // Partages recus : partages dont je suis le destinataire (friend_id = moi)
        $partages = Partage::where('friend_id', $userId)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        // Partages envoyes : partages que j'ai crees
        $partagesEnvoyes = Partage::where('user_id', $userId)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('partages', compact('partages', 'partagesEnvoyes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'favori_id'  => 'required|exists:favoris,id',
            'friend_id'  => 'required|exists:users,id',
            'message'    => 'nullable|string|max:500',
        ]);

        $favori = Favori::where('id', $request->favori_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $isFriend = FriendUser::where(function($q) use ($request) {
            $q->where('user_id', Auth::id())->where('friend_id', $request->friend_id);
        })->orWhere(function($q) use ($request) {
            $q->where('user_id', $request->friend_id)->where('friend_id', Auth::id());
        })->exists();

        if (!$isFriend) {
            return redirect()->back()->with('error', 'Vous ne pouvez partager qu\'avec vos amis.');
        }

        Partage::create([
            'user_id'          => Auth::id(),
            'favori_id'        => $favori->id,
            'film_title'       => $favori->film_title,
            'film_poster_path' => $favori->film_poster_path,
            'film_tmdb_id'     => $favori->favori_id,
            'friend_id'        => $request->friend_id,
            'message'          => $request->message,
            'avis'             => $favori->avis,
        ]);

        return redirect()->back()->with('success', 'Film partage avec succes !');
    }

    public function destroy($id)
    {
        $partage = Partage::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $partage->delete();

        return redirect()->route('partages.index')->with('success', 'Partage supprime.');
    }
}
