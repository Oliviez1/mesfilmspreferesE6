@extends('layouts.app')

@section('title', 'Mes favoris')

@section('content')
<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px;">
        <h1>Mes favoris</h1>
        <a href="{{ route('rechercherFilm') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Ajouter un film
        </a>
    </div>
    
    @if(isset($favoris) && $favoris->count() > 0)
        <div class="row g-4">
            @foreach($favoris as $favori)
            <div class="col-md-6 col-lg-4">
                <div style="background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.08); transition: transform 0.2s ease, box-shadow 0.2s ease;">
                    @if($favori->film_poster_path)
                        <img src="https://image.tmdb.org/t/p/w500{{ $favori->film_poster_path }}" alt="{{ $favori->film_title }}" style="width: 100%; height: 400px; object-fit: cover;">
                    @else
                        <div style="width: 100%; height: 400px; background: linear-gradient(135deg, #6366f1, #8b5cf6); display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-film" style="font-size: 64px; color: white; opacity: 0.5;"></i>
                        </div>
                    @endif
                    <div style="padding: 20px;">
                        <h3 style="font-size: 20px; font-weight: 600; margin-bottom: 8px; color: #1d1d1f;">{{ $favori->film_title }}</h3>
                        @if($favori->film_year)
                            <p style="color: #86868b; font-size: 15px; margin-bottom: 12px;">{{ $favori->film_year }}</p>
                        @endif
                        @if($favori->avis)
                            <p style="color: #1d1d1f; font-size: 15px; margin-bottom: 16px; line-height: 1.5;">{{ $favori->avis }}</p>
                        @endif
                        <div style="display: flex; gap: 8px;">
                            <form action="{{ route('favoris.destroy', $favori->id) }}" method="POST" style="flex: 1;">
                                @csrf
                                @method('POST')
                                <button type="submit" class="btn" style="width: 100%; background: #f5f5f7; color: #1d1d1f; border: none; border-radius: 8px; padding: 8px;">
                                    <i class="bi bi-trash me-1"></i>Supprimer
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div style="text-align: center; padding: 64px 32px; background: white; border-radius: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
            <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #ec4899, #f472b6); border-radius: 20px; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 24px;">
                <i class="bi bi-heart" style="font-size: 40px; color: white;"></i>
            </div>
            <h2 style="font-size: 28px; font-weight: 600; margin-bottom: 12px; color: #1d1d1f;">Aucun favori pour le moment</h2>
            <p style="color: #86868b; font-size: 17px; margin-bottom: 32px;">Commencez à ajouter vos films préférés à votre collection.</p>
            <a href="{{ route('rechercherFilm') }}" class="btn btn-primary">
                <i class="bi bi-search me-2"></i>Rechercher un film
            </a>
        </div>
    @endif
</div>
@endsection
