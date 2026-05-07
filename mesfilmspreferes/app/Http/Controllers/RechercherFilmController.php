<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class RechercherFilmController extends Controller
{
    private function tmdb(string $url): ?array
    {
        try {
            $ctx = stream_context_create(['http' => ['timeout' => 8]]);
            $response = file_get_contents($url, false, $ctx);
            if ($response === false) return null;
            $data = json_decode($response, true);
            return $data ?? null;
        } catch (\Exception $e) {
            return null;
        }
    }

    private function apiKey(): string
    {
        return env('TMDB_API_KEY', '63905b28b94957ba2d061a85b849243f');
    }

    /**
     * Enrichit chaque film avec credits (acteurs) depuis TMDB.
     */
    private function enrichMovies(array $movies): array
    {
        $key = $this->apiKey();
        return array_map(function($film) use ($key) {
            $id = $film['id'] ?? null;
            if (!$id) return $film;
            $detail = $this->tmdb("https://api.themoviedb.org/3/movie/{$id}?api_key={$key}&language=fr-FR&append_to_response=credits");
            if ($detail) {
                $film['runtime']  = $detail['runtime'] ?? null;
                $film['genres']   = $detail['genres'] ?? [];
                $film['credits']  = $detail['credits'] ?? [];
            }
            return $film;
        }, $movies);
    }

    public function create()
    {
        $key     = $this->apiKey();
        $url     = "https://api.themoviedb.org/3/movie/popular?api_key={$key}&language=fr-FR";
        $data    = $this->tmdb($url);
        $results = $data['results'] ?? [];
        $results = $this->enrichMovies($results);

        $amis = $this->getAmis();
        return view('rechercher-film', compact('results', 'amis'));
    }

    public function store(Request $request)
    {
        $key     = $this->apiKey();
        $query   = $request->input('query');
        $genreId = $request->input('genre_id');
        $results = null;
        $error   = null;

        try {
            if ($query) {
                $q    = urlencode($query);
                $url  = "https://api.themoviedb.org/3/search/movie?query={$q}&api_key={$key}&language=fr-FR";
                $data = $this->tmdb($url);
                $results = $data['results'] ?? [];
            } elseif ($genreId) {
                $url  = "https://api.themoviedb.org/3/discover/movie?with_genres={$genreId}&api_key={$key}&language=fr-FR&sort_by=popularity.desc";
                $data = $this->tmdb($url);
                $results = $data['results'] ?? [];
            } else {
                $url  = "https://api.themoviedb.org/3/movie/popular?api_key={$key}&language=fr-FR";
                $data = $this->tmdb($url);
                $results = $data['results'] ?? [];
            }

            if ($results !== null) {
                $results = $this->enrichMovies($results);
            }
        } catch (\Exception $e) {
            $error = 'Erreur lors de la connexion à l\'API TMDB.';
        }

        $amis = $this->getAmis();
        return view('rechercher-film', compact('results', 'error', 'amis'));
    }

    /**
     * Récupère la liste des amis de l'utilisateur connecté.
     * Retourne une collection vide si non connecté.
     */
    private function getAmis(): EloquentCollection
    {
        if (!Auth::check()) return new EloquentCollection();

        $userId = Auth::id();

        return User::whereIn('id', function($query) use ($userId) {
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
    }
}
