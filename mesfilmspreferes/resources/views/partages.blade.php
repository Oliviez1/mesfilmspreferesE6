@extends('layouts.app')
@section('title', 'Partages')
@section('styles')
<style>
.partages-list { display: flex; flex-direction: column; gap: 10px; }
.partage-card {
    background: #0d0d18;
    border: 1px solid var(--border);
    border-radius: 12px; padding: 14px 18px;
    display: flex; gap: 16px; align-items: flex-start;
    transition: border-color 0.15s;
}
.partage-card:hover { border-color: rgba(255,255,255,0.1); }
.partage-poster {
    flex-shrink: 0; width: 68px; height: 102px;
    border-radius: 7px; object-fit: cover;
    border: 1px solid var(--border);
    background: #12121e;
}
.partage-poster-ph {
    flex-shrink: 0; width: 68px; height: 102px;
    border-radius: 7px; border: 1px solid var(--border);
    background: #12121e;
    display: flex; align-items: center; justify-content: center;
    color: rgba(255,255,255,0.06); font-size: 22px;
}
.partage-title { font-size: 15px; font-weight: 700; color: #fff; margin-bottom: 4px; }
.partage-from { font-size: 12px; color: #38384e; margin-bottom: 10px; }
.partage-msg {
    font-size: 13px; color: #55556a;
    background: rgba(255,255,255,0.025);
    border: 1px solid var(--border);
    border-radius: 8px; padding: 8px 12px;
    font-style: italic; margin-bottom: 10px; max-width: 400px;
}
</style>
@endsection
@section('content')
<div class="page-content">
    <div style="margin-bottom:32px;">
        <h1 style="font-size:22px;font-weight:800;color:#fff;margin-bottom:4px;">Partages</h1>
        <p style="font-size:13px;color:#38384e;">Films partages par vos amis</p>
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
                    Partage par <strong>{{ $partage->user->username ?? 'Utilisateur' }}</strong>
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
        <p>Les films partages par vos amis apparaitront ici.</p>
        <a href="{{ route('rechercherFilm') }}" class="btn-cine"><i class="bi bi-compass"></i> Explorer des films</a>
    </div>
    @endif
</div>
@endsection
