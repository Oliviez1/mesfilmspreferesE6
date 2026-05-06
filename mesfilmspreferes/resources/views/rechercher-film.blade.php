@extends('layouts.app')

@section('title', 'Découvrir')

@section('styles')
<style>
/* HERO */
.search-hero {
    background: linear-gradient(180deg, #0f0f1a 0%, var(--bg) 100%);
    padding: 52px 24px 36px;
    text-align: center;
    border-bottom: 1px solid var(--border);
    margin-bottom: 32px;
}
.search-hero h1 { font-size: clamp(24px, 4vw, 40px); font-weight: 800; color: #fff; margin-bottom: 8px; letter-spacing: -0.025em; }
.search-hero p { color: var(--text-muted); font-size: 14px; margin-bottom: 24px; }
.search-bar { max-width: 600px; margin: 0 auto; display: flex; gap: 10px; }
.search-bar input { flex: 1; }

/* FILTRES GENRES */
.genre-filters {
    max-width: 820px;
    margin: 0 auto 28px;
    display: flex;
    flex-wrap: wrap;
    gap: 7px;
    justify-content: center;
    padding: 0 16px;
}
.genre-btn {
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(255,255,255,0.09);
    color: #60607a;
    border-radius: 999px;
    padding: 5px 15px;
    font-size: 12.5px;
    font-weight: 500;
    cursor: pointer;
    transition: background var(--t), border-color var(--t), color var(--t);
    white-space: nowrap;
    display: flex;
    align-items: center;
    gap: 5px;
}
.genre-btn:hover, .genre-btn.active {
    background: var(--red);
    border-color: var(--red);
    color: #fff;
}

/* GRILLE */
.films-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
    gap: 16px;
}
@media (min-width: 768px) { .films-grid { grid-template-columns: repeat(auto-fill, minmax(185px, 1fr)); } }

/* OVERLAY */
.movie-card .card-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(180deg, transparent 30%, rgba(0,0,0,0.9) 100%);
    opacity: 0; transition: opacity var(--t);
    display: flex; flex-direction: column; justify-content: flex-end;
    padding: 14px; gap: 6px;
}
.movie-card:hover .card-overlay { opacity: 1; }
.card-overlay .overlay-title { font-size: 13px; font-weight: 700; color: #fff; margin: 0; line-height: 1.3; }
.card-overlay .overlay-year { font-size: 11px; color: rgba(255,255,255,0.45); }

/* MODAL */
.film-modal-backdrop {
    display: none; position: fixed; inset: 0;
    background: rgba(0,0,0,0.85); z-index: 9000;
    overflow-y: auto; padding: 40px 16px;
    backdrop-filter: blur(8px);
}
.film-modal-backdrop.active { display: flex; align-items: flex-start; justify-content: center; }
.film-modal {
    background: #13131e; border-radius: 16px;
    border: 1px solid rgba(255,255,255,0.08);
    width: 100%; max-width: 880px; overflow: hidden;
    position: relative;
    animation: modalIn 0.18s cubic-bezier(0.16,1,0.3,1);
}
@keyframes modalIn { from { opacity:0; transform: translateY(20px) scale(0.97); } to { opacity:1; transform: none; } }

.film-modal-close {
    position: absolute; top: 14px; right: 14px; z-index: 10;
    background: rgba(0,0,0,0.6); border: 1px solid rgba(255,255,255,0.12);
    color: #fff; border-radius: 50%; width: 34px; height: 34px;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; font-size: 16px; transition: background var(--t);
}
.film-modal-close:hover { background: var(--red); border-color: var(--red); }

.film-banner { width: 100%; height: 300px; object-fit: cover; display: block; background: #1a1a2e; }
.film-banner-gradient {
    position: absolute; top: 0; left: 0; right: 0; height: 300px;
    background: linear-gradient(180deg, rgba(19,19,30,0.04) 0%, rgba(19,19,30,0.6) 60%, #13131e 100%);
    pointer-events: none;
}
.film-banner-wrap { position: relative; }

.film-modal-body {
    display: grid; grid-template-columns: 155px 1fr;
    gap: 24px; padding: 0 26px 30px;
    margin-top: -65px; position: relative;
}
@media (max-width: 580px) {
    .film-modal-body { grid-template-columns: 1fr; margin-top: -24px; }
    .film-poster-modal { display: none; }
    .film-banner { height: 170px; } .film-banner-gradient { height: 170px; }
}
.film-poster-modal {
    width: 155px; border-radius: 9px;
    border: 3px solid #13131e;
    box-shadow: 0 8px 28px rgba(0,0,0,0.65);
}
.film-info-title {
    font-size: clamp(18px, 3vw, 28px); font-weight: 800; color: #fff;
    line-height: 1.1; letter-spacing: -0.02em; margin-bottom: 10px;
}
.film-meta { display: flex; flex-wrap: wrap; gap: 10px; align-items: center; margin-bottom: 12px; }
.film-meta-item { font-size: 12.5px; color: var(--text-muted); display: flex; align-items: center; gap: 5px; }
.film-score { font-size: 13px; font-weight: 700; color: var(--gold); display: flex; align-items: center; gap: 4px; }
.film-overview { font-size: 13.5px; line-height: 1.7; color: rgba(255,255,255,0.65); margin-bottom: 16px; max-width: 540px; }

/* CASTING */
.cast-scroll {
    display: flex; gap: 10px; overflow-x: auto;
    padding-bottom: 6px; scrollbar-width: thin; scrollbar-color: #2a2a3a transparent;
    margin-bottom: 18px;
}
.cast-card { flex-shrink: 0; width: 72px; text-align: center; }
.cast-avatar {
    width: 54px; height: 54px; border-radius: 50%; object-fit: cover;
    border: 2px solid var(--border); margin: 0 auto 5px; display: block;
    background: var(--bg-card-2);
}
.cast-name { font-size: 10px; font-weight: 600; color: var(--text); line-height: 1.3; word-break: break-word; }
.cast-char { font-size: 9px; color: var(--text-muted); line-height: 1.2; }

/* NOTE */
.rating-section {
    background: rgba(255,255,255,0.025);
    border: 1px solid var(--border);
    border-radius: 10px; padding: 16px; margin-top: 8px;
}
.rating-section h4 { font-size: 11px; font-weight: 700; color: #50506a; margin-bottom: 12px; text-transform: uppercase; letter-spacing: 0.08em; }
.star-rating-form { display: flex; flex-direction: row-reverse; gap: 5px; width: fit-content; }
.star-rating-form input[type=radio] { display: none; }
.star-rating-form label { font-size: 26px; color: rgba(255,255,255,0.1); cursor: pointer; transition: color var(--t); line-height: 1; }
.star-rating-form input[type=radio]:checked ~ label,
.star-rating-form label:hover,
.star-rating-form label:hover ~ label { color: var(--gold); }

/* GUARD non-connecté */
.auth-guard-notice {
    background: rgba(229,9,20,0.07);
    border: 1px solid rgba(229,9,20,0.18);
    border-radius: 9px; padding: 14px 16px;
    display: flex; align-items: center; gap: 12px;
    font-size: 13px; color: rgba(255,255,255,0.55);
    margin-top: 14px;
}
.auth-guard-notice a { color: var(--red); font-weight: 600; text-decoration: none; }
.auth-guard-notice a:hover { text-decoration: underline; }

.action-buttons { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 16px; }

/* PARTAGE MODAL */
.share-modal-wrap {
    display: none; position: fixed; inset: 0;
    background: rgba(0,0,0,0.75); z-index: 9500;
    align-items: center; justify-content: center;
    padding: 20px;
}
.share-modal-wrap.active { display: flex; }
.share-modal {
    background: #15151f; border: 1px solid rgba(255,255,255,0.09);
    border-radius: 14px; padding: 26px; width: 100%; max-width: 380px;
    animation: modalIn 0.16s cubic-bezier(0.16,1,0.3,1);
}
.share-modal h3 { font-size: 16px; font-weight: 700; color: #fff; margin-bottom: 16px; display: flex; align-items: center; gap: 8px; }
.share-friends-list { display: flex; flex-direction: column; gap: 7px; max-height: 240px; overflow-y: auto; margin-bottom: 14px; }
.share-friend-item {
    display: flex; align-items: center; gap: 12px;
    background: rgba(255,255,255,0.03); border: 1px solid var(--border);
    border-radius: 9px; padding: 9px 12px; cursor: pointer;
    transition: border-color var(--t);
}
.share-friend-item:hover { border-color: rgba(229,9,20,0.4); }
.share-friend-name { font-size: 13.5px; font-weight: 600; color: var(--text); }
.share-friend-user { font-size: 11.5px; color: var(--text-muted); }
</style>
@endsection

@section('content')

<div class="search-hero">
    <h1>Découvrir des films</h1>
    <p>Des millions de titres, un seul endroit.</p>
    <form action="{{ route('rechercherFilmPost') }}" method="POST" class="search-bar">
        @csrf
        <input type="hidden" name="genre_id" id="form-genre-id" value="{{ request('genre_id', '') }}">
        <input type="text" name="query" class="cine-input" placeholder="Titre, réalisateur, acteur..." value="{{ old('query', request('query')) }}" autocomplete="off">
        <button class="btn-cine" type="submit"><i class="bi bi-search"></i> Rechercher</button>
    </form>
</div>

{{-- FILTRES GENRES --}}
<div class="genre-filters">
    <button class="genre-btn {{ !request('genre_id') ? 'active' : '' }}" onclick="filterGenre(0, this)"><i class="bi bi-grid-3x3-gap"></i> Tous</button>
    <button class="genre-btn {{ request('genre_id')==28 ? 'active' : '' }}" onclick="filterGenre(28, this)"><i class="bi bi-lightning"></i> Action</button>
    <button class="genre-btn {{ request('genre_id')==12 ? 'active' : '' }}" onclick="filterGenre(12, this)"><i class="bi bi-compass"></i> Aventure</button>
    <button class="genre-btn {{ request('genre_id')==16 ? 'active' : '' }}" onclick="filterGenre(16, this)"><i class="bi bi-palette"></i> Animation</button>
    <button class="genre-btn {{ request('genre_id')==35 ? 'active' : '' }}" onclick="filterGenre(35, this)"><i class="bi bi-emoji-laughing"></i> Comédie</button>
    <button class="genre-btn {{ request('genre_id')==80 ? 'active' : '' }}" onclick="filterGenre(80, this)"><i class="bi bi-shield-exclamation"></i> Crime</button>
    <button class="genre-btn {{ request('genre_id')==99 ? 'active' : '' }}" onclick="filterGenre(99, this)"><i class="bi bi-camera-reels"></i> Documentaire</button>
    <button class="genre-btn {{ request('genre_id')==18 ? 'active' : '' }}" onclick="filterGenre(18, this)"><i class="bi bi-masks-theater"></i> Drame</button>
    <button class="genre-btn {{ request('genre_id')==14 ? 'active' : '' }}" onclick="filterGenre(14, this)"><i class="bi bi-stars"></i> Fantastique</button>
    <button class="genre-btn {{ request('genre_id')==27 ? 'active' : '' }}" onclick="filterGenre(27, this)"><i class="bi bi-moon"></i> Horreur</button>
    <button class="genre-btn {{ request('genre_id')==10749 ? 'active' : '' }}" onclick="filterGenre(10749, this)"><i class="bi bi-heart"></i> Romance</button>
    <button class="genre-btn {{ request('genre_id')==878 ? 'active' : '' }}" onclick="filterGenre(878, this)"><i class="bi bi-rocket"></i> Sci-Fi</button>
    <button class="genre-btn {{ request('genre_id')==53 ? 'active' : '' }}" onclick="filterGenre(53, this)"><i class="bi bi-exclamation-triangle"></i> Thriller</button>
</div>

<div class="page-content" style="padding-top:0;">

@if(isset($error))
    <div style="text-align:center;padding:60px 0;">
        <i class="bi bi-exclamation-triangle" style="font-size:44px;color:var(--red);opacity:.6;"></i>
        <p style="color:var(--text-muted);margin-top:14px;">{{ $error }}</p>
    </div>
@elseif(isset($results) && count($results) > 0)
    <div class="section-title">
        <i class="bi bi-fire" style="color:var(--red);"></i>
        @if(request('query') || old('query')) Résultats de recherche
        @elseif(request('genre_id')) Films par genre
        @else Films populaires @endif
    </div>
    <div class="films-grid">
        @foreach($results as $film)
        <div class="movie-card" onclick="openFilmModal({{ json_encode($film) }})" style="cursor:pointer;">
            @if(isset($film['poster_path']) && $film['poster_path'])
                <img src="https://image.tmdb.org/t/p/w342{{ $film['poster_path'] }}" alt="{{ $film['title'] ?? $film['name'] }}" loading="lazy">
            @else
                <div class="poster-placeholder"><i class="bi bi-film"></i></div>
            @endif
            <div class="card-overlay">
                <p class="overlay-title">{{ $film['title'] ?? $film['name'] }}</p>
                <div style="display:flex;justify-content:space-between;align-items:center;">
                    <span class="overlay-year">{{ isset($film['release_date']) && $film['release_date'] ? substr($film['release_date'],0,4) : '' }}</span>
                    @if(isset($film['vote_average']) && $film['vote_average'] > 0)
                        <span style="font-size:11px;font-weight:700;color:var(--gold);"><i class="bi bi-star-fill"></i> {{ number_format($film['vote_average'],1) }}</span>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
@elseif(isset($results))
    <div style="text-align:center;padding:80px 0;">
        <i class="bi bi-binoculars" style="font-size:48px;color:rgba(255,255,255,0.08);"></i>
        <h3 style="font-size:17px;font-weight:700;color:var(--text);margin-top:18px;margin-bottom:8px;">Aucun résultat</h3>
        <p style="color:var(--text-muted);">Essayez d'autres mots-clés ou changez de genre.</p>
    </div>
@endif

</div>

{{-- ===== MODAL FICHE FILM ===== --}}
<div class="film-modal-backdrop" id="filmModal" onclick="closeOnBackdrop(event)">
    <div class="film-modal" id="filmModalContent">
        <button class="film-modal-close" onclick="closeFilmModal()" aria-label="Fermer"><i class="bi bi-x"></i></button>
        <div class="film-banner-wrap">
            <img id="modal-backdrop" src="" alt="" class="film-banner">
            <div class="film-banner-gradient"></div>
        </div>
        <div class="film-modal-body">
            <div>
                <img id="modal-poster" src="" alt="" class="film-poster-modal">
            </div>
            <div>
                <h2 class="film-info-title" id="modal-title"></h2>
                <div class="film-meta" id="modal-meta"></div>
                <div id="modal-genres" style="display:flex;flex-wrap:wrap;gap:6px;margin-bottom:12px;"></div>
                <p class="film-overview" id="modal-overview"></p>

                {{-- CASTING --}}
                <div id="modal-cast-section" style="display:none;margin-bottom:16px;">
                    <div class="section-title" style="margin-bottom:10px;"><i class="bi bi-people"></i> Casting</div>
                    <div class="cast-scroll" id="modal-cast"></div>
                </div>

                @auth
                <div class="action-buttons">
                    <form action="{{ route('favoris.add') }}" method="POST" id="modal-favori-form">
                        @csrf
                        <input type="hidden" name="film_id" id="modal-film-id">
                        <input type="hidden" name="film_title" id="modal-film-title">
                        <input type="hidden" name="film_poster_path" id="modal-film-poster">
                        <input type="hidden" name="film_year" id="modal-film-year">
                        <input type="hidden" name="film_overview" id="modal-film-overview">
                        <button type="submit" class="btn-cine"><i class="bi bi-heart"></i> Ma liste</button>
                    </form>
                    <button class="btn-cine btn-cine-outline" onclick="openShareModal()" type="button"><i class="bi bi-share"></i> Partager</button>
                </div>
                @endauth

                @auth
                <div class="rating-section" style="margin-top:18px;">
                    <h4><i class="bi bi-star" style="color:var(--gold);"></i> Votre note</h4>
                    <form action="#" method="POST" id="modal-note-form">
                        @csrf
                        <input type="hidden" name="film_id" id="note-film-id">
                        <div class="star-rating-form" style="margin-bottom:12px;">
                            @for($i=5;$i>=1;$i--)
                                <input type="radio" name="note" id="star{{$i}}" value="{{$i}}">
                                <label for="star{{$i}}">&#9733;</label>
                            @endfor
                        </div>
                        <textarea name="commentaire" class="cine-input" rows="3" placeholder="Votre avis... (optionnel)" style="margin-bottom:10px;"></textarea>
                        <button type="submit" class="btn-cine btn-cine-gold"><i class="bi bi-check2"></i> Enregistrer ma note</button>
                    </form>
                </div>
                @endauth

                @guest
                <div class="auth-guard-notice">
                    <i class="bi bi-lock" style="font-size:18px;color:var(--red);"></i>
                    <span><a href="{{ route('login') }}">Connectez-vous</a> ou <a href="{{ route('creerCompte') }}">créez un compte</a> pour noter, ajouter à votre liste et partager ce film.</span>
                </div>
                @endguest
            </div>
        </div>
    </div>
</div>

{{-- ===== MODAL PARTAGE ===== --}}
@auth
<div class="share-modal-wrap" id="shareModal">
    <div class="share-modal">
        <h3><i class="bi bi-share" style="color:var(--red);"></i> Partager avec un ami</h3>
        <form action="{{ route('partages.store') }}" method="POST" id="share-form">
            @csrf
            <input type="hidden" name="film_id" id="share-film-id">
            <input type="hidden" name="film_title" id="share-film-title">
            <input type="hidden" name="film_poster_path" id="share-film-poster">
            <input type="hidden" name="film_year" id="share-film-year">
            <input type="hidden" name="film_overview" id="share-film-overview">
            <input type="hidden" name="receiver_id" id="share-receiver-id">
            <div style="margin-bottom:12px;">
                <input type="text" class="cine-input" id="share-search-friend" placeholder="Chercher un ami..." autocomplete="off" oninput="filterFriends(this.value)">
            </div>
            <div class="share-friends-list" id="share-friends-list">
                @if(isset($amis) && count($amis) > 0)
                    @foreach($amis as $ami)
                    <label class="share-friend-item" onclick="selectFriend({{ $ami->id }}, '{{ addslashes($ami->firstname . ' ' . $ami->lastname) }}')">
                        <div>
                            <div class="share-friend-name">{{ $ami->firstname }} {{ $ami->lastname }}</div>
                            <div class="share-friend-user">@{{ $ami->username }}</div>
                        </div>
                    </label>
                    @endforeach
                @else
                    <p style="color:var(--text-muted);font-size:13px;text-align:center;padding:20px 0;">Vous n'avez pas encore d'amis ajoutés.<br><a href="{{ route('amis.index') }}" style="color:var(--red);">Ajouter des amis</a></p>
                @endif
            </div>
            <div id="share-selected" style="display:none;background:rgba(229,9,20,0.08);border:1px solid rgba(229,9,20,0.25);border-radius:8px;padding:10px 14px;font-size:13px;color:#ff6b6b;margin-bottom:12px;">
                <i class="bi bi-check-circle"></i> Sélectionné : <strong id="share-selected-name"></strong>
            </div>
            <div style="display:flex;gap:10px;">
                <button type="submit" class="btn-cine" style="flex:1;" id="share-submit-btn" disabled><i class="bi bi-send"></i> Envoyer</button>
                <button type="button" class="btn-cine btn-cine-outline" onclick="closeShareModal()">Annuler</button>
            </div>
        </form>
    </div>
</div>
@endauth

@endsection

@section('scripts')
<script>
const B_W = 'https://image.tmdb.org/t/p/w342';
const B_B = 'https://image.tmdb.org/t/p/w1280';
const B_F = 'https://image.tmdb.org/t/p/w185';
let currentFilm = null;

function filterGenre(genreId, btn) {
    document.querySelectorAll('.genre-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    document.getElementById('form-genre-id').value = genreId || '';
    btn.closest('form') || document.querySelector('.search-bar').closest('form').submit();
    document.querySelector('.search-bar').closest('form').submit();
}

function openFilmModal(film) {
    currentFilm = film;
    const backdrop = document.getElementById('modal-backdrop');
    backdrop.src = film.backdrop_path ? B_B + film.backdrop_path : (film.poster_path ? B_B + film.poster_path : '');
    const poster = document.getElementById('modal-poster');
    if (film.poster_path) { poster.src = B_W + film.poster_path; poster.style.display = 'block'; }
    else poster.style.display = 'none';
    document.getElementById('modal-title').textContent = film.title || film.name || 'Titre inconnu';
    let meta = '';
    if (film.release_date) meta += `<span class="film-meta-item"><i class="bi bi-calendar3"></i> ${film.release_date.substring(0,4)}</span>`;
    if (film.vote_average && film.vote_average > 0) meta += `<span class="film-score"><i class="bi bi-star-fill"></i> ${film.vote_average.toFixed(1)} <span style="color:var(--text-muted);font-weight:400;font-size:11px;">/10</span></span>`;
    if (film.runtime) { const h=Math.floor(film.runtime/60),m=film.runtime%60; meta += `<span class="film-meta-item"><i class="bi bi-clock"></i> ${h>0?h+'h ':''}${m}min</span>`; }
    if (film.original_language) meta += `<span class="film-meta-item"><i class="bi bi-translate"></i> ${film.original_language.toUpperCase()}</span>`;
    document.getElementById('modal-meta').innerHTML = meta;
    const genresEl = document.getElementById('modal-genres');
    genresEl.innerHTML = '';
    if (film.genres && film.genres.length > 0)
        film.genres.forEach(g => { const b=document.createElement('span'); b.className='badge-genre'; b.textContent=g.name; genresEl.appendChild(b); });
    document.getElementById('modal-overview').textContent = film.overview || 'Aucun synopsis disponible.';
    const castSection = document.getElementById('modal-cast-section');
    const castEl = document.getElementById('modal-cast');
    castEl.innerHTML = '';
    if (film.credits && film.credits.cast && film.credits.cast.length > 0) {
        film.credits.cast.slice(0,12).forEach(a => {
            const card = document.createElement('div'); card.className='cast-card';
            card.innerHTML = `<img class="cast-avatar" src="${a.profile_path ? B_F+a.profile_path : ''}" alt="${a.name}" onerror="this.style.opacity='0.15'">
                <div class="cast-name">${a.name}</div><div class="cast-char">${a.character||''}</div>`;
            castEl.appendChild(card);
        });
        castSection.style.display='block';
    } else castSection.style.display='none';
    const id=film.id, title=film.title||film.name||'';
    const poster_path=film.poster_path||'', year=film.release_date?film.release_date.substring(0,4):'';
    const ov=film.overview||'';
    ['modal-film-id','note-film-id','share-film-id'].forEach(i => { const el=document.getElementById(i); if(el) el.value=id; });
    ['modal-film-title','share-film-title'].forEach(i => { const el=document.getElementById(i); if(el) el.value=title; });
    ['modal-film-poster','share-film-poster'].forEach(i => { const el=document.getElementById(i); if(el) el.value=poster_path; });
    ['modal-film-year','share-film-year'].forEach(i => { const el=document.getElementById(i); if(el) el.value=year; });
    ['modal-film-overview','share-film-overview'].forEach(i => { const el=document.getElementById(i); if(el) el.value=ov; });
    document.getElementById('filmModal').classList.add('active');
    document.body.style.overflow='hidden';
}
function closeFilmModal() {
    document.getElementById('filmModal').classList.remove('active');
    document.body.style.overflow='';
}
function closeOnBackdrop(e) { if(e.target===document.getElementById('filmModal')) closeFilmModal(); }
document.addEventListener('keydown', e => { if(e.key==='Escape') { closeFilmModal(); closeShareModal(); } });

function openShareModal() { document.getElementById('shareModal').classList.add('active'); }
function closeShareModal() { document.getElementById('shareModal') && document.getElementById('shareModal').classList.remove('active'); }
function selectFriend(id, name) {
    const el = document.getElementById('share-receiver-id'); if(el) el.value = id;
    const sel = document.getElementById('share-selected');
    const selName = document.getElementById('share-selected-name');
    if(sel && selName) { sel.style.display='block'; selName.textContent=name; }
    const btn = document.getElementById('share-submit-btn'); if(btn) btn.disabled = false;
}
function filterFriends(q) {
    document.querySelectorAll('.share-friend-item').forEach(item => {
        item.style.display = item.textContent.toLowerCase().includes(q.toLowerCase()) ? '' : 'none';
    });
}
</script>
@endsection
