<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RechercherFilmController extends Controller
{
    private function getMoviesFromAPI($url)
    {
        try {
            $response = file_get_contents($url);
            
            if ($response === false) {
                throw new \Exception('Erreur lors de la requête API');
            }
            
            $data = json_decode($response, true);
            
            if (isset($data['results'])) {
                return $data['results'];
            }
        } catch (\Exception $e) {
            return null;
        }
        
        return null;
    }

    public function create()
    {
        $results = null;
        $apiKey = env('TMDB_API_KEY', '63905b28b94957ba2d061a85b849243f');
        
        // Afficher les films populaires par défaut
        $url = "https://api.themoviedb.org/3/movie/popular?api_key={$apiKey}&language=fr-FR";
        $results = $this->getMoviesFromAPI($url);
        
        return view('rechercher-film', compact('results'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'query' => 'required|string|min:2',
        ]);

        $results = null;
        $error = null;
        $apiKey = env('TMDB_API_KEY', '63905b28b94957ba2d061a85b849243f');

        $queryValue = $request->input('query');
        
        if ($queryValue) {
            try {
                $query = urlencode($queryValue);
                
                // On forme l'URL de la requête à l'API
                $url = "https://api.themoviedb.org/3/search/movie?query={$query}&api_key={$apiKey}&language=fr-FR";
                
                // On récupère les données
                $response = file_get_contents($url);
                
                if ($response === false) {
                    throw new \Exception('Erreur lors de la requête API');
                }
                
                // On met les données dans un tableau associatif qu'on peut exploiter
                $data = json_decode($response, true);
                
                if (isset($data['results'])) {
                    $results = $data['results'];
                } else {
                    $error = 'Aucun film trouvé.';
                }
            } catch (\Exception $e) {
                $error = $e->getMessage();
            }
        } else {
            // Si pas de recherche, afficher les films populaires
            $url = "https://api.themoviedb.org/3/movie/popular?api_key={$apiKey}&language=fr-FR";
            $results = $this->getMoviesFromAPI($url);
        }

        return view('rechercher-film', compact('results', 'error'));
    }
}
