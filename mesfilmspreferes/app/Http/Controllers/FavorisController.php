<?php

namespace App\Http\Controllers;

use App\Models\Favori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavorisController extends Controller
{
    public function index()
    {
        $favoris = Favori::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('favoris', compact('favoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'film_id'          => 'required',
            'film_title'       => 'required|string|max:255',
            'film_poster_path' => 'nullable|string',
            'film_year'        => 'nullable|string',
            'film_overview'    => 'nullable|string',
        ]);

        $existing = Favori::where('user_id', Auth::id())
            ->where('favori_id', $request->film_id)
            ->first();

        if ($existing) {
            return redirect()->route('favoris')->with('error', 'Ce film est deja dans vos favoris.');
        }

        Favori::create([
            'favori_id'        => $request->film_id,
            'film_title'       => $request->film_title,
            'film_poster_path' => $request->film_poster_path,
            'film_year'        => $request->film_year,
            'film_overview'    => $request->film_overview,
            'user_id'          => Auth::id(),
        ]);

        return redirect()->route('favoris')->with('success', 'Film ajoute a la liste.');
    }

    public function destroy($id)
    {
        $favori = Favori::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $favori->delete();

        return redirect()->route('favoris')->with('success', 'Film retire de la liste.');
    }

    public function updateNote(Request $request, $id)
    {
        $request->validate([
            'note' => 'nullable|integer|min:1|max:5',
            'avis' => 'nullable|string|max:1000',
        ]);

        $favori = Favori::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // On garde l'ancienne note si aucune nouvelle etoile selectionnee
        $note = $request->note ? (int) $request->note : $favori->note;
        // On efface l'avis seulement si le champ est vide et qu'il n'y avait rien avant
        $avis = ($request->filled('avis')) ? $request->avis : $favori->avis;

        $favori->update([
            'note' => $note,
            'avis' => $avis ?: null,
        ]);

        return redirect()->route('favoris')->with('success', 'Note enregistree !');
    }
}
