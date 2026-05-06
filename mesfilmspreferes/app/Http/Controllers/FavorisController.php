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
            'film_id' => 'required',
            'film_title' => 'required|string|max:255',
            'film_poster_path' => 'nullable|string',
            'film_year' => 'nullable|string',
            'film_overview' => 'nullable|string',
        ]);

        // Vérifier si le film n'est pas déjà en favoris
        $existing = Favori::where('user_id', Auth::id())
            ->where('favori_id', $request->film_id)
            ->first();

        if ($existing) {
            return redirect()->route('favoris')->with('error', 'Ce film est déjà dans vos favoris.');
        }

        Favori::create([
            'favori_id' => $request->film_id,
            'film_title' => $request->film_title,
            'film_poster_path' => $request->film_poster_path,
            'film_year' => $request->film_year,
            'film_overview' => $request->film_overview,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('favoris')->with('success', 'Film ajouté aux favoris avec succès !');
    }

    public function destroy($id)
    {
        $favori = Favori::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $favori->delete();

        return redirect()->route('favoris')->with('success', 'Film retiré des favoris.');
    }

    public function updateAvis(Request $request, $id)
    {
        $request->validate([
            'avis' => 'nullable|string|max:1000',
        ]);

        $favori = Favori::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $favori->update([
            'avis' => $request->avis,
        ]);

        return redirect()->route('favoris')->with('success', 'Avis mis à jour.');
    }
}
