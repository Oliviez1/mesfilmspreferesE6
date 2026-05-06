@extends('layouts.app')
@section('title', 'Accueil — Mes Films Préférés')
@section('styles')
<style>
/* HERO */
.hero {
    position: relative;
    overflow: hidden;
    padding: 72px 28px 60px;
    background: #080810;
    border-bottom: 1px solid var(--border);
}
.hero::before {
    content: '';
    position: absolute; inset: 0;
    background: radial-gradient(ellipse 90% 50% at 50% -5%, rgba(229,9,20,0.08) 0%, transparent 65%);
    pointer-events: none;
}
.hero-inner { position: relative; z-index: 1; max-width: 680px; }
.hero-badge {
    display: inline-flex; align-items: center; gap: 7px;
    background: rgba(229,9,20,0.1); border: 1px solid rgba(229,9,20,0.22);
    color: #e07070; border-radius: 999px; padding: 4px 13px;
    font-size: 11.5px; font-weight: 600; letter-spacing: 0.04em;
    margin-bottom: 24px;
}
.hero h1 {
    font-size: clamp(30px, 4.5vw, 56px);
    font-weight: 800; color: #fff;
    line-height: 1.08; letter-spacing: -0.03em;
    margin-bottom: 18px;
}
.hero h1 em { font-style: normal; color: var(--red); }
.hero-sub {
    font-size: 15px; color: #50506a;
    max-width: 420px; margin-bottom: 32px;
    line-height: 1.75;
}
.hero-actions { display: flex; gap: 10px; flex-wrap: wrap; }

/* FILMS À L'AFFICHE — scrollable horizontal */
.banner-strip {
    background: #0b0b16;
    border-bottom: 1px solid var(--border);
    overflow: hidden;
}
.banner-strip-inner { display: flex; align-items: stretch; }
.banner-label {
    flex-shrink: 0;
    display: flex; align-items: center; gap: 8px;
    padding: 0 20px;
    background: var(--red);
    font-size: 10px; font-weight: 800;
    letter-spacing: 0.12em; text-transform: uppercase;
    color: #fff; white-space: nowrap; z-index: 2;
}
.banner-scroll-wrap { overflow-x: auto; scrollbar-width: none; flex: 1; }
.banner-scroll-wrap::-webkit-scrollbar { display: none; }
.banner-scroll {
    display: flex; width: max-content;
    padding: 12px 20px 12px 16px;
    gap: 0;
}
.banner-film-item {
    display: flex; align-items: center; gap: 10px;
    padding: 0 18px 0 0; margin-right: 18px;
    border-right: 1px solid var(--border);
    cursor: pointer; text-decoration: none;
    transition: opacity var(--t);
}
.banner-film-item:last-child { border-right: none; }
.banner-film-item:hover { opacity: 0.7; }
.banner-film-poster {
    width: 26px; height: 39px;
    object-fit: cover; border-radius: 4px;
    border: 1px solid var(--border); flex-shrink: 0;
    background: #1a1a28;
}
.banner-film-title { font-size: 12px; font-weight: 600; color: var(--text); white-space: nowrap; max-width: 150px; overflow: hidden; text-overflow: ellipsis; }
.banner-film-date { font-size: 10px; color: #3a3a52; white-space: nowrap; }

/* TOP 10 */
.top-section { margin-bottom: 52px; }
.top-scroll-wrap {
    overflow-x: auto; scrollbar-width: none;
    margin: 0 -24px; padding: 4px 24px 12px;
}
.top-scroll-wrap::-webkit-scrollbar { display: none; }
.top-scroll { display: flex; gap: 12px; width: max-content; }
.top-film-card {
    flex-shrink: 0; width: 130px;
    cursor: pointer; transition: transform var(--t);
}
.top-film-card:hover { transform: translateY(-5px); }
.top-film-card img {
    width: 100%; aspect-ratio: 2/3;
    object-fit: cover; border-radius: 9px;
    display: block; border: 1px solid var(--border);
}
.top-rank-badge {
    position: absolute; top: 7px; left: 7px;
    background: rgba(0,0,0,0.75);
    border: 1px solid rgba(255,255,255,0.12);
    color: #fff; font-size: 11px; font-weight: 800;
    border-radius: 6px; padding: 2px 8px; line-height: 1.6;
    backdrop-filter: blur(4px);
}
.top-rank-badge.rank-1 { background: rgba(229,9,20,0.85); border-color: var(--red); }
.top-film-name {
    font-size: 12px; font-weight: 600; color: var(--text);
    margin-top: 8px; white-space: nowrap;
    overflow: hidden; text-overflow: ellipsis;
}
.top-film-score {
    font-size: 11px; color: var(--gold);
    display: flex; align-items: center; gap: 3px; margin-top: 2px;
}
.top-film-rel { position: relative; }

/* STATS */
.stats-row {
    display: flex; justify-content: center;
    border: 1px solid var(--border); border-radius: 12px;
    overflow: hidden; background: #0d0d1a;
    margin-bottom: 48px;
}
.stat-item {
    flex: 1; padding: 22px 16px; text-align: center;
    border-right: 1px solid var(--border);
}
.stat-item:last-child { border-right: none; }
.stat-num { font-size: 24px; font-weight: 800; color: #fff; line-height: 1; }
.stat-label { font-size: 10px; color: #30304a; margin-top: 5px; text-transform: uppercase; letter-spacing: 0.09em; }

/* FEATURES */
.features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 10px;
}
.feature-card {
    background: #0d0d18;
    border: 1px solid var(--border);
    border-radius: 12px; padding: 20px 18px;
    text-decoration: none; display: block;
    transition: border-color var(--t), background var(--t);
}
.feature-card:hover { border-color: rgba(255,255,255,0.12); background: #131320; }
.feature-icon {
    width: 34px; height: 34px;
    border-radius: 8px;
    background: rgba(229,9,20,0.1);
    display: inline-flex; align-items: center; justify-content: center;
    font-size: 15px; color: #cc4444;
    margin-bottom: 12px;
}
.feature-title { font-size: 14px; font-weight: 700; color: #d0d0e8; margin-bottom: 5px; }
.feature-desc { font-size: 12px; color: #36364e; line-height: 1.6; }
</style>
@endsection
@section('content')

{{-- HERO --}}
<div class="hero">
    <div class="hero-inner">
        <div class="hero-badge"><i class="bi bi-film"></i> Propulsé par TMDB</div>
        <h1>Vos films.<br>Votre <em>liste.</em></h1>
        <p class="hero-sub">Recherchez parmi des millions de titres, notez ce que vous avez vu et partagez vos coups de cœur avec vos amis.</p>
        <div class="hero-actions">
            <a href="{{ route('rechercherFilm') }}" class="btn-cine"><i class="bi bi-compass"></i> Explorer les films</a>
            @guest
            <a href="{{ route('creerCompte') }}" class="btn-cine btn-cine-outline"><i class="bi bi-person-plus"></i> Créer un compte</a>
            @else
            <a href="{{ route('favoris') }}" class="btn-cine btn-cine-outline"><i class="bi bi-bookmark"></i> Ma liste</a>
            @endguest
        </div>
    </div>
</div>

{{-- BANDEROLE A L'AFFICHE --}}
@if(isset($nowPlaying) && count($nowPlaying) > 0)
<div class="banner-strip">
    <div class="banner-strip-inner">
        <div class="banner-label"><i class="bi bi-play-fill"></i> A l'affiche</div>
        <div class="banner-scroll-wrap">
            <div class="banner-scroll">
                @foreach($nowPlaying as $film)
                <a href="{{ route('rechercherFilm') }}" class="banner-film-item">
                    @if(isset($film['poster_path']) && $film['poster_path'])
                        <img class="banner-film-poster" src="https://image.tmdb.org/t/p/w92{{ $film['poster_path'] }}" alt="" loading="lazy">
                    @else
                        <div class="banner-film-poster" style="display:flex;align-items:center;justify-content:center;background:#1a1a28;"><i class="bi bi-film" style="font-size:10px;color:#333;"></i></div>
                    @endif
                    <div>
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

    {{-- TOP 10 --}}
    @if(isset($topFilms) && count($topFilms) > 0)
    <div class="top-section">
        <div class="section-title"><i class="bi bi-bar-chart-fill" style="color:var(--red);"></i> Top 10 cette semaine</div>
        <div class="top-scroll-wrap">
            <div class="top-scroll">
                @foreach($topFilms as $i => $film)
                <div class="top-film-card" onclick="window.location.href='{{ route('rechercherFilm') }}'">
                    <div class="top-film-rel">
                        @if(isset($film['poster_path']) && $film['poster_path'])
                            <img src="https://image.tmdb.org/t/p/w300{{ $film['poster_path'] }}" alt="{{ $film['title'] ?? '' }}" loading="lazy">
                        @else
                            <div style="width:100%;aspect-ratio:2/3;background:#12121e;border-radius:9px;border:1px solid var(--border);display:flex;align-items:center;justify-content:center;"><i class="bi bi-film" style="font-size:24px;color:#1a1a2e;"></i></div>
                        @endif
                        <span class="top-rank-badge {{ $i === 0 ? 'rank-1' : '' }}">#{{ $i + 1 }}</span>
                    </div>
                    <div class="top-film-name">{{ $film['title'] ?? '' }}</div>
                    @if(isset($film['vote_average']) && $film['vote_average'] > 0)
                    <div class="top-film-score"><i class="bi bi-star-fill"></i> {{ number_format($film['vote_average'],1) }}</div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    {{-- STATS --}}
    <div class="stats-row" style="margin-bottom:44px;">
        <div class="stat-item"><div class="stat-num">1M+</div><div class="stat-label">Films</div></div>
        <div class="stat-item"><div class="stat-num">19</div><div class="stat-label">Genres</div></div>
        <div class="stat-item"><div class="stat-num">FR</div><div class="stat-label">Langue</div></div>
        <div class="stat-item"><div class="stat-num">24/7</div><div class="stat-label">Acces</div></div>
    </div>

    {{-- FONCTIONNALITES --}}
    <div class="section-title">Ce que vous pouvez faire</div>
    <div class="features-grid">
        <a href="{{ route('rechercherFilm') }}" class="feature-card">
            <div class="feature-icon"><i class="bi bi-compass"></i></div>
            <div class="feature-title">Decouvrir</div>
            <div class="feature-desc">Recherchez parmi des millions de titres via TMDB, filtrez par genre.</div>
        </a>
        <a href="{{ route('favoris') }}" class="feature-card">
            <div class="feature-icon"><i class="bi bi-bookmark"></i></div>
            <div class="feature-title">Ma liste</div>
            <div class="feature-desc">Sauvegardez vos films, notez-les et retrouvez-les a tout moment.</div>
        </a>
        <a href="{{ route('amis.index') }}" class="feature-card">
            <div class="feature-icon"><i class="bi bi-people"></i></div>
            <div class="feature-title">Amis</div>
            <div class="feature-desc">Ajoutez vos amis et voyez leurs selections de films.</div>
        </a>
        <a href="{{ route('partages.index') }}" class="feature-card">
            <div class="feature-icon"><i class="bi bi-share"></i></div>
            <div class="feature-title">Partages</div>
            <div class="feature-desc">Partagez vos films preferes directement avec vos amis.</div>
        </a>
    </div>

</div>
@endsection
