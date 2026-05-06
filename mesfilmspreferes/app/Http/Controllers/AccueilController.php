<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccueilController extends Controller
{
    public function index()
    {
        $topFilms = [];
        try {
            $key = env('TMDB_API_KEY', '63905b28b94957ba2d061a85b849243f');
            $ctx = stream_context_create(['http' => ['timeout' => 5]]);
            $resp = @file_get_contents(
                "https://api.themoviedb.org/3/trending/movie/week?api_key={$key}&language=fr-FR",
                false, $ctx
            );
            if ($resp) {
                $data = json_decode($resp, true);
                $topFilms = array_slice($data['results'] ?? [], 0, 10);
            }
        } catch (\Exception $e) {}

        return view('accueil', compact('topFilms'));
    }
}
