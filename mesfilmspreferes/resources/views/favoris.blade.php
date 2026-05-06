@extends('layouts.app')
@section('title', 'Ma liste')
@section('styles')
<style>
.favoris-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    gap: 18px;
}
.favori-card {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 10px;
    overflow: hidden;
    transition: border-color 0.18s, transform 0.18s;
    position: relative;
}
.favori-card:hover { border-color: var(--border-2); transform: translateY(-3px); }
.favori-card img { width:100%; aspect-ratio:2/3; object-fit:cover; display:block; }
.favori-card-body { padding: 12px 14px 14px; }
.favori-title { font-size: 13px; font-weight: 600; color: var(--text); margin-bottom: 3px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.favori-year { font-size: 11.5px; color: #4a4a60; margin-bottom: 10px; }
.favori-note { display: flex; align-items:center; gap:3px; font-size:12px; color: var(--gold); margin-bottom: 8px; }
.favori-avis { font-size: 12px; color: #55556a; line-height:1.45; margin-bottom:10px; font-style:italic; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }
</style>
@endsection
@section('content')
<div class="page-content">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:32px;flex-wrap:wrap;gap:12px;">
        <div>
            <h1 style="font-size:22px;font-weight:800;color:#fff;margin-bottom:4px;">Ma liste</h1>
            <p style="font-size:13px;color:#4a4a60;">Vos films sauvegardés</p>
        </div>
        <a href="{{ route('rechercherFilm') }}" class="btn-cine"><i class="bi bi-plus"></i> Ajouter</a>
    </div>

    @if(isset($favoris) && $favoris->count() > 0)
    <div class="favoris-grid">
        @foreach($favoris as $favori)
        <div class="favori-card">
            @if($favori->film_poster_path)
                <img src="https://image.tmdb.org/t/p/w342{{ $favori->film_poster_path }}" alt="{{ $favori->film_title }}" loading="lazy">
            @else
                <div style="width:100%;aspect-ratio:2/3;background:var(--bg-card-2);display:flex;align-items:center;justify-content:center;"><i class="bi bi-film" style="font-size:36px;color:#222230;"></i></div>
            @endif
            <div class="favori-card-body">
                <div class="favori-title">{{ $favori->film_title }}</div>
                @if($favori->film_year)<div class="favori-year">{{ $favori->film_year }}</div>@endif
                @if(isset($favori->note) && $favori->note)
                <div class="favori-note">
                    @for($s=1;$s<=5;$s++)<i class="bi bi-star{{ $s <= $favori->note ? '-fill' : '' }}"></i>@endfor
                </div>
                @endif
                @if(isset($favori->avis) && $favori->avis)<div class="favori-avis">{{ $favori->avis }}</div>@endif
                <form action="{{ route('favoris.destroy', $favori->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-cine btn-cine-danger" style="width:100%;padding:7px 14px;font-size:12px;justify-content:center;">
                        <i class="bi bi-trash"></i> Retirer
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="empty-state">
        <div class="empty-icon"><i class="bi bi-bookmark"></i></div>
        <h3>Aucun film sauvegardé</h3>
        <p>Explorez des films et ajoutez-les à votre liste.</p>
        <a href="{{ route('rechercherFilm') }}" class="btn-cine"><i class="bi bi-search"></i> Explorer</a>
    </div>
    @endif
</div>
@endsection
