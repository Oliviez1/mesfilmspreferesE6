<?php

namespace App\Http\Controllers;

use App\Models\Partage;
use App\Models\FriendUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PartageController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $partages = Partage::where('friend_id', $userId)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        $partagesEnvoyes = Partage::where('user_id', $userId)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('partages', compact('partages', 'partagesEnvoyes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'film_id'    => 'required',
            'film_title' => 'required|string',
            'receiver_id'=> 'required|exists:users,id',
            'message'    => 'nullable|string|max:500',
        ]);

        $isFriend = FriendUser::where(function($q) use ($request) {
            $q->where('user_id', Auth::id())->where('friend_id', $request->receiver_id);
        })->orWhere(function($q) use ($request) {
            $q->where('user_id', $request->receiver_id)->where('friend_id', Auth::id());
        })->exists();

        if (!$isFriend) {
            return redirect()->back()->with('error', 'Vous ne pouvez partager qu\'avec vos amis.');
        }

        Partage::create([
            'user_id'          => Auth::id(),
            'friend_id'        => $request->receiver_id,
            'film_tmdb_id'     => $request->film_id,
            'film_title'       => $request->film_title,
            'film_poster_path' => $request->film_poster_path ?? null,
            'message'          => $request->message ?? null,
            'avis'             => null,
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
