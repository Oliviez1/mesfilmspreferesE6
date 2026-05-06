@extends('layouts.app')

@section('title', 'Accueil')

@section('styles')
<style>
    .hero {
        min-height: 480px;
        background: linear-gradient(135deg, #0f0c1a 0%, #1a0a0f 50%, #0a0f1a 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 80px 24px;
        position: relative;
        overflow: hidden;
        border-bottom: 1px solid var(--border);
    }
    .hero::before {
        content: '';
        position: absolute;
        top: -120px; left: 50%; transform: translateX(-50%);
        width: 700px; height: 700px;
        background: radial-gradient(circle, rgba(229,9,20,0.12) 0%, transparent 65%);
        pointer-events: none;
    }
    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(229,9,20,0.15);
        border: 1px solid rgba(229,9,20,0.35);
        color: #ff6b6b;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        padding: 5px 14px;
        border-radius: 999px;
        margin-bottom: 24px;
    }
    .hero h1 {
        font-size: clamp(36px, 6vw, 72px);
        font-weight: 800;
        color: #fff;
        line-height: 1.05;
        letter-spacing: -0.03em;
        margin-bottom: 18px;
    }
    .hero h1 span { color: var(--red); }
    .hero p {
        font-size: 17px;
        color: rgba(255,255,255,0.55);
        max-width: 480px;
        margin: 0 auto 36px;
        line-height: 1.6;
    }
    .hero-ctas { display: flex; gap: 14px; justify-content: center; flex-wrap: wrap; }

    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 20px;
        margin-top: 48px;
    }
    .feature-card {
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: 14px;
        padding: 28px 24px;
        transition: border-color 0.2s, transform 0.2s, box-shadow 0.2s;
        text-decoration: none;
        display: block;
    }
    .feature-card:hover {
        border-color: rgba(229,9,20,0.4);
        transform: translateY(-4px);
        box-shadow: 0 12px 40px rgba(0,0,0,0.5);
    }
    .feature-icon {
        width: 48px; height: 48px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 22px;
        margin-bottom: 16px;
    }
    .feature-title {
        font-size: 17px;
        font-weight: 700;
        color: var(--text);
        margin-bottom: 6px;
    }
    .feature-desc {
        font-size: 13px;
        color: var(--text-muted);
        line-height: 1.5;
    }
    .stat-row {
        display: flex;
        gap: 32px;
        justify-content: center;
        flex-wrap: wrap;
        padding: 32px 24px;
        border-top: 1px solid var(--border);
        border-bottom: 1px solid var(--border);
        margin: 48px 0;
    }
    .stat-item { text-align: center; }
    .stat-num { font-size: 32px; font-weight: 800; color: #fff; line-height: 1; }
    .stat-label { font-size: 12px; color: var(--text-muted); margin-top: 4px; text-transform: uppercase; letter-spacing: 0.06em; }
</style>
@endsection

@section('content')

{{-- HERO --}}
<div class="hero">
    <div style="position:relative;z-index:1;">
        <div class="hero-badge"><i class="bi bi-lightning-fill"></i> Powéré par TMDB</div>
        <h1>Vos films.<br><span>Votre univers.</span></h1>
        <p>Découvrez, notez et partagez vos films préférés avec vos amis.</p>
        <div class="hero-ctas">
            <a href="{{ route('rechercherFilm') }}" class="btn-cine">
                <i class="bi bi-search"></i> Explorer les films
            </a>
            @guest
            <a href="{{ route('creerCompte') }}" class="btn-cine btn-cine-outline">
                <i class="bi bi-person-plus"></i> Créer un compte
            </a>
            @else
            <a href="{{ route('favoris') }}" class="btn-cine btn-cine-outline">
                <i class="bi bi-heart"></i> Ma liste
            </a>
            @endguest
        </div>
    </div>
</div>

<div class="page-content">

    {{-- STATS --}}
    <div class="stat-row">
        <div class="stat-item">
            <div class="stat-num">1M+</div>
            <div class="stat-label">Films disponibles</div>
        </div>
        <div class="stat-item">
            <div class="stat-num">4K+</div>
            <div class="stat-label">Genres</div>
        </div>
        <div class="stat-item">
            <div class="stat-num">24/7</div>
            <div class="stat-label">Accessible</div>
        </div>
    </div>

    {{-- FEATURES --}}
    <div class="section-title">
        <i class="bi bi-compass" style="color:var(--red);"></i> Ce que vous pouvez faire
    </div>

    <div class="features-grid">
        <a href="{{ route('rechercherFilm') }}" class="feature-card">
            <div class="feature-icon" style="background:rgba(229,9,20,0.15);color:var(--red);">
                <i class="bi bi-search"></i>
            </div>
            <div class="feature-title">Découvrir</div>
            <div class="feature-desc">Recherchez parmi des millions de films via l'API TMDB.</div>
        </a>

        <a href="{{ route('favoris') }}" class="feature-card">
            <div class="feature-icon" style="background:rgba(245,197,24,0.15);color:var(--gold);">
                <i class="bi bi-heart"></i>
            </div>
            <div class="feature-title">Ma liste</div>
            <div class="feature-desc">Sauvegardez vos coups de cœur et retrouvez-les facilement.</div>
        </a>

        <a href="{{ route('amis.index') }}" class="feature-card">
            <div class="feature-icon" style="background:rgba(99,102,241,0.15);color:#818cf8;">
                <i class="bi bi-people"></i>
            </div>
            <div class="feature-title">Amis</div>
            <div class="feature-desc">Connectez-vous avec vos amis et voyez leurs sélections.</div>
        </a>

        <a href="{{ route('partages.index') }}" class="feature-card">
            <div class="feature-icon" style="background:rgba(16,185,129,0.15);color:#34d399;">
                <i class="bi bi-share"></i>
            </div>
            <div class="feature-title">Partages</div>
            <div class="feature-desc">Partagez vos films préférés avec votre entourage.</div>
        </a>
    </div>

</div>
@endsection
