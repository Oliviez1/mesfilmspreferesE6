@extends('layouts.app')
@section('title', 'Ma liste')
@section('styles')
<style>
.favoris-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(175px, 1fr));
    gap: 16px;
}
.favori-card {
    background: #0d0d18;
    border: 1px solid var(--border);
    border-radius: 10px;
    overflow: hidden;
    transition: border-color 0.15s, transform 0.15s;
    position: relative;
}
.favori-card:hover { border-color: var(--border-2); transform: translateY(-3px); }
.favori-card img { width:100%; aspect-ratio:2/3; object-fit:cover; display:block; }
.favori-card-body { padding: 10px 12px 12px; }
.favori-title { font-size: 13px; font-weight: 600; color: var(--text); margin-bottom: 3px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.favori-year { font-size: 11.5px; color: #48485e; margin-bottom: 8px; }

/* Etoiles interactives */
.star-rating { display:flex; gap:3px; margin-bottom:8px; flex-direction: row-reverse; justify-content: flex-end; }
.star-rating input[type=radio] { display:none; }
.star-rating label {
    font-size: 18px;
    color: #2e2e40;
    cursor: pointer;
    transition: color 0.1s;
    line-height:1;
}
.star-rating input[type=radio]:checked ~ label { color: #f5c518; }
.star-rating label:hover, .star-rating label:hover ~ label { color: #f5c518; }

/* Note affichee (lecture seule) */
.note-display { display:flex; gap:2px; margin-bottom:4px; font-size:13px; color: #f5c518; }
.note-display .empty { color: #2e2e40; }
.favori-avis-text { font-size: 11.5px; color: #48485e; font-style:italic; margin-bottom:8px; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }

/* Formulaire de note */
.note-form-toggle { font-size:11px; color:#4a4a60; cursor:pointer; text-decoration:underline; margin-bottom:8px; display:block; }
.note-form-toggle:hover { color:#7a7a9a; }
.note-form { display:none; margin-bottom:10px; }
.note-form.open { display:block; }
.note-form textarea {
    width:100%; font-size:11.5px; padding:6px 8px;
    background:#12121e; border:1px solid var(--border);
    border-radius:6px; color:var(--text); resize:none;
    margin-top:6px; margin-bottom:6px;
    box-sizing: border-box;
}
.note-form textarea:focus { outline:none; border-color:#3a3a50; }
</style>
@endsection
@section('content')
<div class="page-content">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:32px;flex-wrap:wrap;gap:12px;">
        <div>
            <h1 style="font-size:22px;font-weight:800;color:#fff;margin-bottom:4px;">Ma liste</h1>
            <p style="font-size:13px;color:#38384e;">{{ $favoris->count() }} film{{ $favoris->count() > 1 ? 's' : '' }}</p>
        </div>
        <a href="{{ route('rechercherFilm') }}" class="btn-cine"><i class="bi bi-plus"></i> Ajouter</a>
    </div>

    @if(session('success'))
        <div style="background:rgba(100,200,100,0.08);border:1px solid rgba(100,200,100,0.2);border-radius:8px;padding:10px 14px;color:#6dca6d;font-size:13px;margin-bottom:20px;">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div style="background:rgba(200,80,80,0.08);border:1px solid rgba(200,80,80,0.2);border-radius:8px;padding:10px 14px;color:#ca6d6d;font-size:13px;margin-bottom:20px;">{{ session('error') }}</div>
    @endif

    @if(isset($favoris) && $favoris->count() > 0)
    <div class="favoris-grid">
        @foreach($favoris as $favori)
        <div class="favori-card">
            @if($favori->film_poster_path)
                <img src="https://image.tmdb.org/t/p/w300{{ $favori->film_poster_path }}" alt="{{ $favori->film_title }}" loading="lazy">
            @else
                <div style="width:100%;aspect-ratio:2/3;background:#12121e;display:flex;align-items:center;justify-content:center;"><i class="bi bi-film" style="font-size:30px;color:rgba(255,255,255,0.06);"></i></div>
            @endif
            <div class="favori-card-body">
                <div class="favori-title" title="{{ $favori->film_title }}">{{ $favori->film_title }}</div>
                @if($favori->film_year)<div class="favori-year">{{ $favori->film_year }}</div>@endif

                {{-- Note affichee --}}
                @if($favori->note)
                <div class="note-display">
                    @for($s=1;$s<=5;$s++)
                        <i class="bi bi-star{{ $s <= $favori->note ? '-fill' : '' }}{{ $s > $favori->note ? ' empty' : '' }}"></i>
                    @endfor
                </div>
                @endif
                @if($favori->avis)<div class="favori-avis-text">&laquo;&nbsp;{{ $favori->avis }}&nbsp;&raquo;</div>@endif

                {{-- Toggle formulaire de note --}}
                <span class="note-form-toggle" onclick="toggleNote('note-{{ $favori->id }}')">
                    <i class="bi bi-pencil" style="font-size:10px;"></i> {{ $favori->note ? 'Modifier la note' : 'Ajouter une note' }}
                </span>

                <div class="note-form" id="note-{{ $favori->id }}">
                    <form action="{{ route('favoris.updateNote', $favori->id) }}" method="POST">
                        @csrf
                        <div class="star-rating">
                            @for($s=5;$s>=1;$s--)
                            <input type="radio" id="star{{ $s }}-{{ $favori->id }}" name="note" value="{{ $s }}" {{ $favori->note == $s ? 'checked' : '' }}>
                            <label for="star{{ $s }}-{{ $favori->id }}">&#9733;</label>
                            @endfor
                        </div>
                        <textarea name="avis" rows="2" placeholder="Votre avis (optionnel)">{{ $favori->avis }}</textarea>
                        <button type="submit" class="btn-cine" style="width:100%;justify-content:center;font-size:12px;padding:6px 0;">
                            <i class="bi bi-check2"></i> Enregistrer
                        </button>
                    </form>
                </div>

                <form action="{{ route('favoris.destroy', $favori->id) }}" method="POST" style="margin-top:6px;">
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
        <h3>Aucun film sauvegarde</h3>
        <p>Explorez des films et ajoutez-les a votre liste.</p>
        <a href="{{ route('rechercherFilm') }}" class="btn-cine"><i class="bi bi-compass"></i> Explorer</a>
    </div>
    @endif
</div>
<script>
function toggleNote(id) {
    const el = document.getElementById(id);
    el.classList.toggle('open');
}
</script>
@endsection
