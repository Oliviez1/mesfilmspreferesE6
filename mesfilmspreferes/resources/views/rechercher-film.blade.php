@extends('layouts.app')

@section('title', 'Rechercher un film')

@section('content')
<div class="container">
    <div style="text-align: center; margin-bottom: 48px;">
        <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #3b82f6, #60a5fa); border-radius: 20px; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 24px;">
            <i class="bi bi-search" style="font-size: 40px; color: white;"></i>
        </div>
        <h1 style="margin-bottom: 12px;">Rechercher un film</h1>
        <p style="color: #86868b; font-size: 17px;">Trouvez vos films préférés parmi des millions de titres</p>
    </div>
    
    <div style="max-width: 700px; margin: 0 auto;">
        <div style="background: white; border-radius: 16px; padding: 32px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
            <form action="{{ route('rechercherFilmPost') }}" method="POST">
                @csrf
                <div style="display: flex; gap: 12px;">
                    <div style="flex: 1;">
                        <input type="text" name="query" class="form-control" placeholder="Titre, réalisateur, acteur..." value="{{ old('query') }}" required style="padding: 16px; font-size: 17px;">
                    </div>
                    <button class="btn btn-primary" type="submit" style="padding: 16px 32px;">
                        <i class="bi bi-search me-2"></i>Rechercher
                    </button>
                </div>
            </form>
        </div>
        
        @if(isset($error))
            <div style="text-align: center; padding: 32px; background: white; border-radius: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); margin-top: 32px;">
                <div style="width: 64px; height: 64px; background: rgba(239, 68, 68, 0.1); border-radius: 16px; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 16px;">
                    <i class="bi bi-exclamation-triangle" style="font-size: 32px; color: #dc2626;"></i>
                </div>
                <p style="color: #dc2626; font-size: 17px; margin: 0;">{{ $error }}</p>
            </div>
        @elseif(isset($results) && count($results) > 0)
            <div style="margin-top: 48px;">
                <h2 style="font-size: 24px; font-weight: 600; margin-bottom: 24px; color: #1d1d1f;">
                    @if(request('query'))
                        Résultats de recherche
                    @else
                        Films populaires
                    @endif
                </h2>
                <div class="row g-4">
                    @foreach($results as $film)
                    <div class="col-md-6 col-lg-4">
                        <div style="background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.08); transition: transform 0.2s ease, box-shadow 0.2s ease;">
                            @if(isset($film['poster_path']) && $film['poster_path'])
                                <img src="https://image.tmdb.org/t/p/w500{{ $film['poster_path'] }}" alt="{{ $film['title'] ?? $film['name'] }}" style="width: 100%; height: 400px; object-fit: cover;">
                            @else
                                <div style="width: 100%; height: 400px; background: linear-gradient(135deg, #3b82f6, #60a5fa); display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-film" style="font-size: 64px; color: white; opacity: 0.5;"></i>
                                </div>
                            @endif
                            <div style="padding: 20px;">
                                <h3 style="font-size: 20px; font-weight: 600; margin-bottom: 8px; color: #1d1d1f;">{{ $film['title'] ?? $film['name'] }}</h3>
                                @if(isset($film['release_date']) && $film['release_date'])
                                    <p style="color: #86868b; font-size: 15px; margin-bottom: 12px;">{{ date('Y', strtotime($film['release_date'])) }}</p>
                                @endif
                                @if(isset($film['overview']) && $film['overview'])
                                    <p style="color: #1d1d1f; font-size: 14px; line-height: 1.5; margin-bottom: 16px; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">{{ $film['overview'] }}</p>
                                @endif
                                <form action="{{ route('favoris.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="film_id" value="{{ $film['id'] }}">
                                    <input type="hidden" name="film_title" value="{{ $film['title'] ?? $film['name'] }}">
                                    <input type="hidden" name="film_poster_path" value="{{ $film['poster_path'] ?? '' }}">
                                    <input type="hidden" name="film_year" value="{{ isset($film['release_date']) ? date('Y', strtotime($film['release_date'])) : '' }}">
                                    <input type="hidden" name="film_overview" value="{{ $film['overview'] ?? '' }}">
                                    <button type="submit" class="btn btn-primary" style="width: 100%; background: linear-gradient(135deg, #ec4899, #f472b6); border: none;">
                                        <i class="bi bi-heart me-2"></i>Ajouter aux favoris
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        @elseif(isset($results) && count($results) === 0)
            <div style="text-align: center; padding: 64px 32px; background: white; border-radius: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); margin-top: 48px;">
                <i class="bi bi-search" style="font-size: 64px; color: #d2d2d7; margin-bottom: 24px;"></i>
                <h2 style="font-size: 24px; font-weight: 600; margin-bottom: 12px; color: #1d1d1f;">Aucun résultat trouvé</h2>
                <p style="color: #86868b; font-size: 17px;">Essayez avec d'autres mots-clés.</p>
            </div>
        @endif
    </div>
</div>
@endsection
