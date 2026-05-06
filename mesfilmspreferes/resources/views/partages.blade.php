@extends('layouts.app')
@section('title', 'Partages')
@section('styles')
<style>
.partages-list { display: flex; flex-direction: column; gap: 12px; }
.partage-card {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 16px 20px;
    display: flex;
    gap: 18px;
    align-items: flex-start;
    transition: border-color 0.15s;
}
.partage-card:hover { border-color: var(--border-2); }
.partage-poster {
    flex-shrink: 0;
    width: 72px; height: 108px;
    border-radius: 7px;
    object-fit: cover;
    border: 1px solid var(--border);
    background: var(--bg-card-2);
}
.partage-poster-ph {
    flex-shrink: 0;
    width: 72px; height: 108px;
    border-radius: 7px;
    border: 1px solid var(--border);
    background: var(--bg-card-2);
    display: flex; align-items: center; justify-content: center;
    color: #222230; font-size: 24px;
}
.partage-title { font-size: 15px; font-weight: 700; color: #fff; margin-bottom: 4px; }
.partage-from { font-size: 12px; color: #4a4a60; margin-bottom: 10px; }
.partage-msg {
    font-size: 13px; color: #606075;
    background: rgba(255,255,255,0.03);
    border: 1px solid var(--border);
    border-radius: 8px;
    padding: 8px 12px;
    font-style: italic;
    margin-bottom: 10px;
    max-width: 400px;
}
</style>
@endsection
@section('content')
<div class="page-content">
    <div style="margin-bottom:32px;">
        <h1 style="font-size:22px;font-weight:800;color:#fff;margin-bottom:4px;">Partages</h1>
        <p style="font-size:13px;color:#4a4a60;">Films partagés par vos amis</p>
    </div>

    @if(isset($partages) && $partages->count() > 0)
    <div class="partages-list">
        @foreach($partages as $partage)
        <div class="partage-card">
            @if($partage->film_poster_path)
                <img src="https://image.tmdb.org/t/p/w185{{ $partage->film_poster_path }}" alt="{{ $partage->film_title }}" class="partage-poster" loading="lazy">
            @else
                <div class="partage-poster-ph"><i class="bi bi-film"></i></div>
            @endif
            <div style="flex:1;">
                <div class="partage-title">{{ $partage->film_title }}</div>
                <div class="partage-from">
                    <i class="bi bi-person"></i>
                    Partagé par <strong>{{ $partage->user->username ?? 'Utilisateur' }}</strong>
                    @if($partage->film_year) &middot; {{ $partage->film_year }} @endif
                </div>
                @if($partage->message)<div class="partage-msg">{{ $partage->message }}</div>@endif
                @if($partage->avis)<div class="partage-msg">{{ $partage->avis }}</div>@endif
                @if(auth()->id() == $partage->user_id)
                <form action="{{ route('partages.destroy', $partage->id) }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn-cine btn-cine-danger" style="font-size:12px;padding:6px 14px;">
                        <i class="bi bi-trash"></i> Supprimer
                    </button>
                </form>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="empty-state">
        <div class="empty-icon"><i class="bi bi-share"></i></div>
        <h3>Aucun partage</h3>
        <p>Les films partagés par vos amis apparaîtront ici.</p>
        <a href="{{ route('rechercherFilm') }}" class="btn-cine"><i class="bi bi-search"></i> Explorer des films</a>
    </div>
    @endif
</div>
@endsection
