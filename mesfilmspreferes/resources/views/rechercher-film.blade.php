@extends('layouts.app')

@section('title', 'Découvrir')

@section('styles')
<style>
    /* ── HERO SEARCH ── */
    .search-hero {
        background: linear-gradient(180deg, #16101a 0%, var(--bg) 100%);
        padding: 56px 24px 48px;
        text-align: center;
        border-bottom: 1px solid var(--border);
        margin-bottom: 48px;
    }
    .search-hero h1 {
        font-size: clamp(28px, 4vw, 44px);
        font-weight: 800;
        color: #fff;
        margin-bottom: 10px;
        letter-spacing: -0.02em;
    }
    .search-hero p {
        color: var(--text-muted);
        font-size: 16px;
        margin-bottom: 32px;
    }
    .search-bar {
        max-width: 620px;
        margin: 0 auto;
        display: flex;
        gap: 12px;
    }
    .search-bar input { flex: 1; }

    /* ── FILM GRID ── */
    .films-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
        gap: 20px;
    }
    @media (min-width: 768px) {
        .films-grid { grid-template-columns: repeat(auto-fill, minmax(185px, 1fr)); }
    }

    /* ── OVERLAY HOVER ── */
    .movie-card .card-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, transparent 30%, rgba(0,0,0,0.92) 100%);
        opacity: 0;
        transition: opacity 0.22s ease;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 16px;
        gap: 8px;
    }
    .movie-card:hover .card-overlay { opacity: 1; }

    .card-overlay .overlay-title {
        font-size: 13px;
        font-weight: 700;
        color: #fff;
        margin: 0;
        line-height: 1.3;
    }
    .card-overlay .overlay-year {
        font-size: 11px;
        color: rgba(255,255,255,0.55);
    }

    /* ── MODAL FICHE FILM ── */
    .film-modal-backdrop {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.85);
        z-index: 9000;
        overflow-y: auto;
        padding: 40px 16px;
        backdrop-filter: blur(4px);
    }
    .film-modal-backdrop.active { display: flex; align-items: flex-start; justify-content: center; }

    .film-modal {
        background: #13131e;
        border-radius: 16px;
        border: 1px solid rgba(255,255,255,0.1);
        width: 100%;
        max-width: 880px;
        overflow: hidden;
        position: relative;
        animation: modalIn 0.25s cubic-bezier(0.16,1,0.3,1);
    }
    @keyframes modalIn {
        from { opacity:0; transform: translateY(24px) scale(0.97); }
        to   { opacity:1; transform: none; }
    }

    .film-modal-close {
        position: absolute;
        top: 16px;
        right: 16px;
        z-index: 10;
        background: rgba(0,0,0,0.6);
        border: 1px solid rgba(255,255,255,0.15);
        color: #fff;
        border-radius: 50%;
        width: 38px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 18px;
        transition: background 0.18s;
    }
    .film-modal-close:hover { background: var(--red); border-color: var(--red); }

    /* Banniere */
    .film-banner {
        width: 100%;
        height: 340px;
        object-fit: cover;
        display: block;
        position: relative;
    }
    .film-banner-gradient {
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 340px;
        background: linear-gradient(180deg, rgba(19,19,30,0.1) 0%, rgba(19,19,30,0.7) 60%, #13131e 100%);
        pointer-events: none;
    }
    .film-banner-wrap { position: relative; }

    /* Corps */
    .film-modal-body {
        display: grid;
        grid-template-columns: 180px 1fr;
        gap: 28px;
        padding: 0 28px 32px;
        margin-top: -80px;
        position: relative;
    }
    @media (max-width: 600px) {
        .film-modal-body { grid-template-columns: 1fr; margin-top: -40px; }
        .film-poster-modal { display: none; }
        .film-banner { height: 200px; }
        .film-banner-gradient { height: 200px; }
    }

    .film-poster-modal {
        width: 180px;
        border-radius: 12px;
        border: 3px solid #13131e;
        box-shadow: 0 8px 32px rgba(0,0,0,0.6);
        flex-shrink: 0;
    }

    .film-info-title {
        font-size: clamp(22px, 3vw, 32px);
        font-weight: 800;
        color: #fff;
        line-height: 1.1;
        letter-spacing: -0.02em;
        margin-bottom: 10px;
    }
    .film-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        align-items: center;
        margin-bottom: 16px;
    }
    .film-meta-item {
        font-size: 13px;
        color: var(--text-muted);
        display: flex;
        align-items: center;
        gap: 5px;
    }
    .film-score {
        font-size: 14px;
        font-weight: 700;
        color: var(--gold);
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .film-overview {
        font-size: 14px;
        line-height: 1.7;
        color: rgba(255,255,255,0.75);
        margin-bottom: 20px;
        max-width: 580px;
    }

    /* Acteurs */
    .cast-scroll {
        display: flex;
        gap: 10px;
        overflow-x: auto;
        padding-bottom: 8px;
        scrollbar-width: thin;
        scrollbar-color: #333 transparent;
        margin-bottom: 24px;
    }
    .cast-card {
        flex-shrink: 0;
        width: 80px;
        text-align: center;
    }
    .cast-avatar {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--border);
        margin: 0 auto 6px;
        display: block;
        background: var(--bg-card-2);
    }
    .cast-name {
        font-size: 10px;
        font-weight: 600;
        color: var(--text);
        line-height: 1.3;
        word-break: break-word;
    }
    .cast-char {
        font-size: 9px;
        color: var(--text-muted);
        line-height: 1.2;
    }

    /* Note / Rating form */
    .rating-section {
        background: rgba(255,255,255,0.04);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 20px;
        margin-top: 8px;
    }
    .rating-section h4 {
        font-size: 14px;
        font-weight: 700;
        color: var(--text);
        margin-bottom: 14px;
        text-transform: uppercase;
        letter-spacing: 0.06em;
    }

    /* Étoiles inversées pour CSS trick */
    .star-rating-form { display: flex; flex-direction: row-reverse; gap: 6px; width: fit-content; }
    .star-rating-form input[type=radio] { display: none; }
    .star-rating-form label {
        font-size: 30px;
        color: rgba(255,255,255,0.12);
        cursor: pointer;
        transition: color 0.12s;
        line-height: 1;
    }
    .star-rating-form input[type=radio]:checked ~ label,
    .star-rating-form label:hover,
    .star-rating-form label:hover ~ label { color: var(--gold); }

    .action-buttons { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 20px; }
</style>
@endsection

@section('content')

{{-- HERO BARRE DE RECHERCHE --}}
<div class="search-hero">
    <h1>🎬 Découvrir des films</h1>
    <p>Des millions de titres, un seul endroit.</p>
    <form action="{{ route('rechercherFilmPost') }}" method="POST" class="search-bar">
        @csrf
        <input type="text" name="query" class="cine-input" placeholder="Titre, réalisateur, acteur..." value="{{ old('query', request('query')) }}" required autocomplete="off">
        <button class="btn-cine" type="submit">
            <i class="bi bi-search"></i> Rechercher
        </button>
    </form>
</div>

<div class="page-content" style="padding-top:0;">

    @if(isset($error))
        <div style="text-align:center;padding:60px 0;">
            <i class="bi bi-exclamation-triangle" style="font-size:48px;color:var(--red);opacity:.7;"></i>
            <p style="color:var(--text-muted);margin-top:16px;">{{ $error }}</p>
        </div>

    @elseif(isset($results) && count($results) > 0)
        <div class="section-title">
            @if(request('query') || old('query'))
                <i class="bi bi-search" style="color:var(--red);"></i>
                Résultats
            @else
                <i class="bi bi-fire" style="color:var(--red);"></i>
                Films populaires
            @endif
        </div>

        <div class="films-grid">
            @foreach($results as $film)
            <div class="movie-card" onclick="openFilmModal({{ json_encode($film) }})">
                @if(isset($film['poster_path']) && $film['poster_path'])
                    <img src="https://image.tmdb.org/t/p/w342{{ $film['poster_path'] }}" alt="{{ $film['title'] ?? $film['name'] }}" loading="lazy">
                @else
                    <div class="poster-placeholder"><i class="bi bi-film"></i></div>
                @endif

                <div class="card-overlay">
                    <p class="overlay-title">{{ $film['title'] ?? $film['name'] }}</p>
                    <div style="display:flex;justify-content:space-between;align-items:center;">
                        <span class="overlay-year">
                            {{ isset($film['release_date']) && $film['release_date'] ? date('Y', strtotime($film['release_date'])) : '' }}
                        </span>
                        @if(isset($film['vote_average']) && $film['vote_average'] > 0)
                            <span style="font-size:11px;font-weight:700;color:var(--gold);">
                                <i class="bi bi-star-fill"></i>
                                {{ number_format($film['vote_average'], 1) }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

    @elseif(isset($results) && count($results) === 0)
        <div style="text-align:center;padding:80px 0;">
            <i class="bi bi-binoculars" style="font-size:56px;color:rgba(255,255,255,0.1);"></i>
            <h3 style="font-size:20px;font-weight:700;color:var(--text);margin-top:20px;margin-bottom:8px;">Aucun résultat</h3>
            <p style="color:var(--text-muted);">Essayez avec d'autres mots-clés.</p>
        </div>
    @endif

</div>

{{-- ======== MODAL FICHE FILM ======== --}}
<div class="film-modal-backdrop" id="filmModal" onclick="closeOnBackdrop(event)">
    <div class="film-modal" id="filmModalContent">
        <button class="film-modal-close" onclick="closeFilmModal()"><i class="bi bi-x"></i></button>

        {{-- Bannière --}}
        <div class="film-banner-wrap">
            <img id="modal-backdrop" src="" alt="" class="film-banner" style="background:var(--bg-card-2);">
            <div class="film-banner-gradient"></div>
        </div>

        {{-- Corps --}}
        <div class="film-modal-body">
            <div>
                <img id="modal-poster" src="" alt="" class="film-poster-modal">
            </div>

            <div>
                <h2 class="film-info-title" id="modal-title"></h2>
                <div class="film-meta" id="modal-meta"></div>
                <div id="modal-genres" style="display:flex;flex-wrap:wrap;gap:6px;margin-bottom:16px;"></div>

                <p class="film-overview" id="modal-overview"></p>

                {{-- Acteurs --}}
                <div id="modal-cast-section" style="display:none;margin-bottom:20px;">
                    <div class="section-title" style="font-size:14px;"><i class="bi bi-people"></i> Casting</div>
                    <div class="cast-scroll" id="modal-cast"></div>
                </div>

                {{-- Actions --}}
                <div class="action-buttons">
                    <form action="{{ route('favoris.add') }}" method="POST" id="modal-favori-form">
                        @csrf
                        <input type="hidden" name="film_id" id="modal-film-id">
                        <input type="hidden" name="film_title" id="modal-film-title">
                        <input type="hidden" name="film_poster_path" id="modal-film-poster">
                        <input type="hidden" name="film_year" id="modal-film-year">
                        <input type="hidden" name="film_overview" id="modal-film-overview">
                        <button type="submit" class="btn-cine">
                            <i class="bi bi-heart"></i> Ajouter à ma liste
                        </button>
                    </form>
                </div>

                {{-- Note --}}
                <div class="rating-section" style="margin-top:24px;">
                    <h4><i class="bi bi-star" style="color:var(--gold);"></i> Votre note</h4>
                    <form action="#" method="POST" id="modal-note-form">
                        @csrf
                        <input type="hidden" name="film_id" id="note-film-id">
                        <div class="star-rating-form" style="margin-bottom:16px;">
                            @for($i = 5; $i >= 1; $i--)
                                <input type="radio" name="note" id="star{{ $i }}" value="{{ $i }}">
                                <label for="star{{ $i }}">&#9733;</label>
                            @endfor
                        </div>
                        <textarea name="commentaire" id="modal-commentaire" class="cine-input" rows="3" placeholder="Votre avis sur ce film... (optionnel)" style="resize:vertical;margin-bottom:12px;"></textarea>
                        <button type="submit" class="btn-cine btn-cine-gold">
                            <i class="bi bi-check2"></i> Enregistrer ma note
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
const IMG_BASE_W = 'https://image.tmdb.org/t/p/w342';
const IMG_BASE_B = 'https://image.tmdb.org/t/p/w1280';

function openFilmModal(film) {
    // Bannière
    const backdrop = document.getElementById('modal-backdrop');
    if (film.backdrop_path) {
        backdrop.src = IMG_BASE_B + film.backdrop_path;
        backdrop.style.display = 'block';
    } else if (film.poster_path) {
        backdrop.src = IMG_BASE_B + film.poster_path;
        backdrop.style.display = 'block';
    } else {
        backdrop.src = '';
        backdrop.style.display = 'none';
    }

    // Poster
    const poster = document.getElementById('modal-poster');
    if (film.poster_path) {
        poster.src = IMG_BASE_W + film.poster_path;
        poster.style.display = 'block';
    } else {
        poster.style.display = 'none';
    }

    // Titre
    document.getElementById('modal-title').textContent = film.title || film.name || 'Titre inconnu';

    // Meta
    let meta = '';
    if (film.release_date) {
        const y = film.release_date.substring(0, 4);
        meta += `<span class="film-meta-item"><i class="bi bi-calendar3"></i> ${y}</span>`;
    }
    if (film.vote_average && film.vote_average > 0) {
        meta += `<span class="film-score"><i class="bi bi-star-fill"></i> ${film.vote_average.toFixed(1)} <span style="color:var(--text-muted);font-weight:400;font-size:12px;">/ 10</span></span>`;
    }
    if (film.runtime) {
        const h = Math.floor(film.runtime / 60);
        const m = film.runtime % 60;
        meta += `<span class="film-meta-item"><i class="bi bi-clock"></i> ${h > 0 ? h+'h ' : ''}${m}min</span>`;
    }
    if (film.original_language) {
        meta += `<span class="film-meta-item"><i class="bi bi-translate"></i> ${film.original_language.toUpperCase()}</span>`;
    }
    document.getElementById('modal-meta').innerHTML = meta;

    // Genres
    const genresEl = document.getElementById('modal-genres');
    genresEl.innerHTML = '';
    if (film.genres && film.genres.length > 0) {
        film.genres.forEach(g => {
            const badge = document.createElement('span');
            badge.className = 'badge-genre';
            badge.textContent = g.name;
            genresEl.appendChild(badge);
        });
    } else if (film.genre_ids && film.genre_ids.length > 0) {
        film.genre_ids.slice(0,3).forEach(id => {
            const badge = document.createElement('span');
            badge.className = 'badge-genre';
            badge.textContent = '#' + id;
            genresEl.appendChild(badge);
        });
    }

    // Synopsis
    const overview = film.overview || 'Aucun synopsis disponible pour ce film.';
    document.getElementById('modal-overview').textContent = overview;

    // Acteurs
    const castSection = document.getElementById('modal-cast-section');
    const castEl = document.getElementById('modal-cast');
    castEl.innerHTML = '';
    if (film.credits && film.credits.cast && film.credits.cast.length > 0) {
        const cast = film.credits.cast.slice(0, 12);
        cast.forEach(actor => {
            const card = document.createElement('div');
            card.className = 'cast-card';
            const imgSrc = actor.profile_path ? 'https://image.tmdb.org/t/p/w185' + actor.profile_path : '';
            card.innerHTML = `
                <img class="cast-avatar" src="${imgSrc || ''}" alt="${actor.name}"
                     onerror="this.style.opacity='0.3'">
                <div class="cast-name">${actor.name}</div>
                <div class="cast-char">${actor.character || ''}</div>`;
            castEl.appendChild(card);
        });
        castSection.style.display = 'block';
    } else {
        castSection.style.display = 'none';
    }

    // Champs hidden formulaires
    const id = film.id;
    const title = film.title || film.name || '';
    const poster_path = film.poster_path || '';
    const year = film.release_date ? film.release_date.substring(0,4) : '';
    const overview_val = film.overview || '';

    document.getElementById('modal-film-id').value = id;
    document.getElementById('modal-film-title').value = title;
    document.getElementById('modal-film-poster').value = poster_path;
    document.getElementById('modal-film-year').value = year;
    document.getElementById('modal-film-overview').value = overview_val;
    document.getElementById('note-film-id').value = id;

    // Ouvrir
    document.getElementById('filmModal').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeFilmModal() {
    document.getElementById('filmModal').classList.remove('active');
    document.body.style.overflow = '';
}

function closeOnBackdrop(e) {
    if (e.target === document.getElementById('filmModal')) closeFilmModal();
}

document.addEventListener('keydown', e => {
    if (e.key === 'Escape') closeFilmModal();
});
</script>
@endsection
