@extends('layouts.app')
@section('title', 'Accueil')
@section('styles')
<style>
.hero {
    position: relative;
    overflow: hidden;
    padding: 90px 28px 80px;
    text-align: center;
    background: #080810;
    border-bottom: 1px solid var(--border);
}
.hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background:
        radial-gradient(ellipse 80% 60% at 50% -10%, rgba(229,9,20,0.1) 0%, transparent 70%);
    pointer-events: none;
}
.hero-eyebrow {
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    color: var(--red);
    margin-bottom: 20px;
    opacity: 0.85;
}
.hero h1 {
    font-size: clamp(34px, 5vw, 62px);
    font-weight: 800;
    color: #fff;
    line-height: 1.06;
    letter-spacing: -0.03em;
    margin-bottom: 18px;
}
.hero h1 em { font-style: normal; color: var(--red); }
.hero-sub {
    font-size: 16px;
    color: #50506a;
    max-width: 440px;
    margin: 0 auto 36px;
    line-height: 1.65;
    font-weight: 400;
}
.hero-actions { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }

/* TOP FILMS SCROLL */
.top-scroll-wrap {
    overflow-x: auto;
    scrollbar-width: none;
    padding-bottom: 4px;
    margin: 0 -24px;
    padding-left: 24px;
    padding-right: 24px;
}
.top-scroll-wrap::-webkit-scrollbar { display: none; }
.top-scroll {
    display: flex;
    gap: 14px;
    width: max-content;
}
.top-film-card {
    flex-shrink: 0;
    width: 140px;
    cursor: pointer;
    transition: transform 0.2s;
}
.top-film-card:hover { transform: translateY(-4px); }
.top-film-card img {
    width: 100%;
    aspect-ratio: 2/3;
    object-fit: cover;
    border-radius: 9px;
    display: block;
    border: 1px solid var(--border);
}
.top-film-card .top-rank {
    position: absolute;
    top: 7px; left: 7px;
    background: var(--red);
    color: #fff;
    font-size: 11px;
    font-weight: 700;
    border-radius: 5px;
    padding: 2px 7px;
    line-height: 1.6;
}
.top-film-card .top-name {
    font-size: 12px;
    font-weight: 600;
    color: var(--text);
    margin-top: 8px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.top-film-card .top-score {
    font-size: 11px;
    color: var(--gold);
    display: flex;
    align-items: center;
    gap: 3px;
    margin-top: 2px;
}
.top-film-rel { position: relative; }

/* STATS */
.stats-row {
    display: flex;
    justify-content: center;
    gap: 0;
    border: 1px solid var(--border);
    border-radius: 12px;
    overflow: hidden;
    background: var(--bg-card);
    margin-bottom: 48px;
}
.stat-item {
    flex: 1;
    padding: 24px 16px;
    text-align: center;
    border-right: 1px solid var(--border);
}
.stat-item:last-child { border-right: none; }
.stat-num { font-size: 28px; font-weight: 800; color: #fff; line-height: 1; }
.stat-label { font-size: 11px; color: #3a3a50; margin-top: 5px; text-transform: uppercase; letter-spacing: 0.08em; }

/* FEATURES */
.features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(210px, 1fr));
    gap: 14px;
}
.feature-card {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 24px 22px;
    text-decoration: none;
    display: block;
    transition: border-color 0.18s, background 0.18s;
}
.feature-card:hover { border-color: var(--border-2); background: var(--bg-card-2); }
.feature-icon {
    font-size: 18px;
    color: var(--red);
    margin-bottom: 14px;
    display: block;
}
.feature-title { font-size: 15px; font-weight: 700; color: var(--text); margin-bottom: 5px; }
.feature-desc { font-size: 12.5px; color: #4a4a62; line-height: 1.55; }
</style>
@endsection
@section('content')

<div class="hero">
    <div style="position:relative;z-index:1;">
        <div class="hero-eyebrow">Propulsé par TMDB</div>
        <h1>Découvrez.<br>Notez. <em>Partagez.</em></h1>
        <p class="hero-sub">Retrouvez tous vos films préférés, construisez votre liste et partagez-la avec vos amis.</p>
        <div class="hero-actions">
            <a href="{{ route('rechercherFilm') }}" class="btn-cine"><i class="bi bi-search"></i> Explorer</a>
            @guest
            <a href="{{ route('creerCompte') }}" class="btn-cine btn-cine-outline"><i class="bi bi-person-plus"></i> Créer un compte</a>
            @else
            <a href="{{ route('favoris') }}" class="btn-cine btn-cine-outline"><i class="bi bi-bookmark"></i> Ma liste</a>
            @endguest
        </div>
    </div>
</div>

<div class="page-content">

    {{-- TOP FILMS --}}
    @if(isset($topFilms) && count($topFilms) > 0)
    <div style="margin-bottom:48px;">
        <div class="section-title"><i class="bi bi-graph-up-arrow" style="color:var(--red);font-style:normal;"></i> Top 10 cette semaine</div>
        <div class="top-scroll-wrap">
            <div class="top-scroll">
                @foreach($topFilms as $i => $film)
                <div class="top-film-card" onclick="window.location.href='{{ route('rechercherFilm') }}'">
                    <div class="top-film-rel">
                        @if(isset($film['poster_path']) && $film['poster_path'])
                            <img src="https://image.tmdb.org/t/p/w342{{ $film['poster_path'] }}" alt="{{ $film['title'] ?? '' }}" loading="lazy">
                        @else
                            <div style="width:100%;aspect-ratio:2/3;background:var(--bg-card-2);border-radius:9px;border:1px solid var(--border);display:flex;align-items:center;justify-content:center;"><i class="bi bi-film" style="font-size:28px;color:#222230;"></i></div>
                        @endif
                        <span class="top-rank">#{{ $i + 1 }}</span>
                    </div>
                    <div class="top-name">{{ $film['title'] ?? '' }}</div>
                    @if(isset($film['vote_average']) && $film['vote_average'] > 0)
                    <div class="top-score"><i class="bi bi-star-fill"></i> {{ number_format($film['vote_average'],1) }}</div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    {{-- STATS --}}
    <div class="stats-row" style="margin-bottom:40px;">
        <div class="stat-item"><div class="stat-num">1M+</div><div class="stat-label">Films</div></div>
        <div class="stat-item"><div class="stat-num">19</div><div class="stat-label">Genres</div></div>
        <div class="stat-item"><div class="stat-num">FR</div><div class="stat-label">Langue</div></div>
        <div class="stat-item"><div class="stat-num">24/7</div><div class="stat-label">Accès</div></div>
    </div>

    {{-- FEATURES --}}
    <div class="section-title">Fonctionnalités</div>
    <div class="features-grid">
        <a href="{{ route('rechercherFilm') }}" class="feature-card">
            <span class="feature-icon"><i class="bi bi-search"></i></span>
            <div class="feature-title">Découvrir</div>
            <div class="feature-desc">Recherchez parmi des millions de titres via l'API TMDB.</div>
        </a>
        <a href="{{ route('favoris') }}" class="feature-card">
            <span class="feature-icon"><i class="bi bi-bookmark"></i></span>
            <div class="feature-title">Ma liste</div>
            <div class="feature-desc">Sauvegardez vos films et retrouvez-les à tout moment.</div>
        </a>
        <a href="{{ route('amis.index') }}" class="feature-card">
            <span class="feature-icon"><i class="bi bi-people"></i></span>
            <div class="feature-title">Amis</div>
            <div class="feature-desc">Connectez-vous avec vos amis et voyez leurs sélections.</div>
        </a>
        <a href="{{ route('partages.index') }}" class="feature-card">
            <span class="feature-icon"><i class="bi bi-share"></i></span>
            <div class="feature-title">Partages</div>
            <div class="feature-desc">Partagez vos films préférés avec votre entourage.</div>
        </a>
    </div>

</div>
@endsection
