@extends('layouts.app')
@section('title', 'Accueil')
@section('styles')
<style>
/* HERO */
.hero {
    position: relative;
    overflow: hidden;
    padding: 100px 28px 88px;
    text-align: center;
    background: #080810;
    border-bottom: 1px solid var(--border);
}
.hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background: radial-gradient(ellipse 80% 60% at 50% -10%, rgba(229,9,20,0.09) 0%, transparent 70%);
    pointer-events: none;
}
.hero-eyebrow {
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 0.16em;
    text-transform: uppercase;
    color: var(--red);
    margin-bottom: 22px;
    opacity: 0.8;
}
.hero h1 {
    font-size: clamp(36px, 5vw, 64px);
    font-weight: 800;
    color: #fff;
    line-height: 1.05;
    letter-spacing: -0.03em;
    margin-bottom: 20px;
}
.hero h1 em { font-style: normal; color: var(--red); }
.hero-sub {
    font-size: 15px;
    color: #46465e;
    max-width: 420px;
    margin: 0 auto 38px;
    line-height: 1.7;
    font-weight: 400;
}
.hero-actions { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }

/* BANDEROLE NOUVEAUTÉS */
.banner-strip {
    background: #0e0e18;
    border-bottom: 1px solid var(--border);
    padding: 0;
    overflow: hidden;
    position: relative;
}
.banner-strip-inner {
    display: flex;
    align-items: stretch;
}
.banner-label {
    flex-shrink: 0;
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 0 22px;
    background: var(--red);
    font-size: 10px;
    font-weight: 800;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: #fff;
    white-space: nowrap;
    z-index: 2;
}
.banner-scroll-wrap {
    overflow-x: auto;
    scrollbar-width: none;
    flex: 1;
}
.banner-scroll-wrap::-webkit-scrollbar { display: none; }
.banner-scroll {
    display: flex;
    gap: 0;
    width: max-content;
    padding: 14px 24px 14px 18px;
}
.banner-film-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 0 20px 0 0;
    margin-right: 20px;
    border-right: 1px solid var(--border);
    cursor: pointer;
    transition: opacity var(--t);
    text-decoration: none;
}
.banner-film-item:last-child { border-right: none; }
.banner-film-item:hover { opacity: 0.75; }
.banner-film-poster {
    width: 28px;
    height: 42px;
    object-fit: cover;
    border-radius: 4px;
    border: 1px solid var(--border);
    flex-shrink: 0;
    background: var(--bg-card-2);
}
.banner-film-info {}
.banner-film-title {
    font-size: 12px;
    font-weight: 600;
    color: var(--text);
    white-space: nowrap;
    max-width: 160px;
    overflow: hidden;
    text-overflow: ellipsis;
}
.banner-film-date {
    font-size: 10px;
    color: #404058;
    white-space: nowrap;
}

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
    transition: transform var(--t);
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
    border: 1px solid var(--border);
    border-radius: 12px;
    overflow: hidden;
    background: var(--bg-card);
    margin-bottom: 48px;
}
.stat-item {
    flex: 1;
    padding: 22px 16px;
    text-align: center;
    border-right: 1px solid var(--border);
}
.stat-item:last-child { border-right: none; }
.stat-num { font-size: 26px; font-weight: 800; color: #fff; line-height: 1; }
.stat-label { font-size: 10px; color: #333348; margin-top: 5px; text-transform: uppercase; letter-spacing: 0.09em; }

/* FEATURES */
.features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 12px;
}
.feature-card {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 22px 20px;
    text-decoration: none;
    display: block;
    transition: border-color var(--t), background var(--t);
}
.feature-card:hover { border-color: var(--border-2); background: var(--bg-card-2); }
.feature-icon {
    font-size: 17px;
    color: var(--red);
    margin-bottom: 12px;
    display: block;
}
.feature-title { font-size: 14px; font-weight: 700; color: var(--text); margin-bottom: 5px; }
.feature-desc { font-size: 12px; color: #3e3e58; line-height: 1.55; }
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

{{-- BANDEROLE NOUVEAUTÉS --}}
@if(isset($nowPlaying) && count($nowPlaying) > 0)
<div class="banner-strip">
    <div class="banner-strip-inner">
        <div class="banner-label"><i class="bi bi-lightning-fill"></i> À l'affiche</div>
        <div class="banner-scroll-wrap">
            <div class="banner-scroll">
                @foreach($nowPlaying as $film)
                <a href="{{ route('rechercherFilm') }}" class="banner-film-item">
                    @if(isset($film['poster_path']) && $film['poster_path'])
                        <img class="banner-film-poster" src="https://image.tmdb.org/t/p/w92{{ $film['poster_path'] }}" alt="" loading="lazy">
                    @else
                        <div class="banner-film-poster" style="display:flex;align-items:center;justify-content:center;"><i class="bi bi-film" style="font-size:12px;color:#333;"></i></div>
                    @endif
                    <div class="banner-film-info">
                        <div class="banner-film-title">{{ $film['title'] ?? '' }}</div>
                        <div class="banner-film-date">{{ isset($film['release_date']) && $film['release_date'] ? \Carbon\Carbon::parse($film['release_date'])->translatedFormat('d M Y') : '' }}</div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endif

<div class="page-content">

    {{-- TOP FILMS --}}
    @if(isset($topFilms) && count($topFilms) > 0)
    <div style="margin-bottom:48px;">
        <div class="section-title"><i class="bi bi-graph-up-arrow" style="color:var(--red);"></i> Top 10 cette semaine</div>
        <div class="top-scroll-wrap">
            <div class="top-scroll">
                @foreach($topFilms as $i => $film)
                <div class="top-film-card" onclick="window.location.href='{{ route('rechercherFilm') }}'">
                    <div class="top-film-rel">
                        @if(isset($film['poster_path']) && $film['poster_path'])
                            <img src="https://image.tmdb.org/t/p/w342{{ $film['poster_path'] }}" alt="{{ $film['title'] ?? '' }}" loading="lazy">
                        @else
                            <div style="width:100%;aspect-ratio:2/3;background:var(--bg-card-2);border-radius:9px;border:1px solid var(--border);display:flex;align-items:center;justify-content:center;"><i class="bi bi-film" style="font-size:28px;color:#1e1e2e;"></i></div>
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
