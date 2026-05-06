@extends('layouts.app')
@section('title', 'Mon profil')
@section('styles')
<style>
.profil-grid {
    display: grid;
    grid-template-columns: 290px 1fr;
    gap: 24px;
    align-items: start;
}
@media(max-width:768px){ .profil-grid{ grid-template-columns:1fr; } }

.profil-card {
    background: #0d0d18;
    border: 1px solid var(--border);
    border-radius: 14px;
    overflow: hidden;
}
.profil-card-header {
    background: linear-gradient(160deg, rgba(229,9,20,0.06) 0%, transparent 100%);
    border-bottom: 1px solid var(--border);
    padding: 28px 22px;
    text-align: center;
}
.profil-avatar {
    width: 68px; height: 68px;
    background: rgba(229,9,20,0.08);
    border: 1px solid rgba(229,9,20,0.18);
    border-radius: 50%;
    display: inline-flex; align-items: center; justify-content: center;
    font-size: 26px; color: #cc3333; margin-bottom: 14px;
}
.profil-username { font-size: 17px; font-weight: 800; color: #fff; margin-bottom: 3px; }
.profil-email { font-size: 12px; color: #30304a; }
.profil-stats { display: flex; border-top: 1px solid var(--border); }
.profil-stat {
    flex: 1; padding: 15px 8px; text-align: center;
    border-right: 1px solid var(--border);
}
.profil-stat:last-child { border-right: none; }
.profil-stat-num { font-size: 20px; font-weight: 800; color: #fff; line-height: 1; }
.profil-stat-label { font-size: 10px; color: #2c2c42; text-transform: uppercase; letter-spacing: .08em; margin-top: 3px; }

.form-block { padding: 22px; }
.field-group { margin-bottom: 14px; }
.field-label { display: block; font-size: 11px; font-weight: 600; color: #40405a; text-transform: uppercase; letter-spacing: .07em; margin-bottom: 6px; }

/* GRILLE FILMS */
.notes-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(138px, 1fr));
    gap: 14px;
}
.note-card {
    background: #0d0d18;
    border: 1px solid var(--border);
    border-radius: 9px;
    overflow: hidden;
    transition: border-color var(--t), transform var(--t);
}
.note-card:hover { border-color: var(--border-2); transform: translateY(-3px); }
.note-card img { width:100%; aspect-ratio:2/3; object-fit:cover; display:block; }
.note-card-body { padding: 8px 10px 10px; }
.note-film-title { font-size: 12px; font-weight: 600; color: var(--text); white-space:nowrap; overflow:hidden; text-overflow:ellipsis; margin-bottom: 5px; }
.note-stars { display:flex; gap:2px; font-size:12px; color:#f5c518; margin-bottom:3px; }
.note-stars .empty { color:#2a2a3a; }
.note-comment { font-size: 11px; color: #38384e; margin-top: 3px; line-height:1.4; font-style:italic; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }

/* ONGLETS */
.tab-bar {
    display: flex; gap: 0;
    border-bottom: 1px solid var(--border);
    margin-bottom: 24px;
}
.tab-btn {
    padding: 10px 18px;
    font-size: 13px; font-weight: 600;
    color: #46466a;
    background: none; border: none;
    border-bottom: 2px solid transparent;
    cursor: pointer;
    transition: color var(--t), border-color var(--t);
    margin-bottom: -1px;
    display: flex; align-items: center; gap: 6px;
}
.tab-btn.active { color: #fff; border-bottom-color: var(--red); }
.tab-btn:hover:not(.active) { color: var(--text); }
.tab-pane { display: none; }
.tab-pane.active { display: block; }
</style>
@endsection
@section('content')
<div class="page-content">
@auth

<div style="margin-bottom:28px;">
    <h1 style="font-size:21px;font-weight:800;color:#fff;margin-bottom:4px;">Mon profil</h1>
    <p style="font-size:12.5px;color:#38384e;">Gerez vos informations et consultez vos films</p>
</div>

@if(session('success'))<div style="background:rgba(100,200,100,0.08);border:1px solid rgba(100,200,100,0.2);border-radius:8px;padding:10px 14px;color:#6dca6d;font-size:13px;margin-bottom:20px;">{{ session('success') }}</div>@endif

<div class="profil-grid">

    {{-- COLONNE GAUCHE --}}
    <div>
        <div class="profil-card" style="margin-bottom:18px;">
            <div class="profil-card-header">
                <div class="profil-avatar"><i class="bi bi-person"></i></div>
                <div class="profil-username">{{ auth()->user()->username ?? auth()->user()->firstname }}</div>
                <div class="profil-email">{{ auth()->user()->email }}</div>
            </div>
            <div class="profil-stats">
                <div class="profil-stat">
                    <div class="profil-stat-num">{{ $favoris->count() }}</div>
                    <div class="profil-stat-label">Films</div>
                </div>
                <div class="profil-stat">
                    <div class="profil-stat-num">{{ $notesCount }}</div>
                    <div class="profil-stat-label">Notes</div>
                </div>
                <div class="profil-stat">
                    <div class="profil-stat-num">{{ $amisCount }}</div>
                    <div class="profil-stat-label">Amis</div>
                </div>
            </div>
        </div>

        <div class="profil-card">
            <div class="form-block">
                <div class="section-title" style="margin-bottom:16px;">Modifier le profil</div>
                @if($errors->any())
                <div style="background:rgba(200,80,80,0.08);border:1px solid rgba(200,80,80,0.2);border-radius:8px;padding:10px 14px;color:#ca6d6d;font-size:12.5px;margin-bottom:14px;">
                    <ul style="margin:0;padding-left:16px;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
                @endif
                <form action="{{ route('profil.update') }}" method="POST">
                    @csrf
                    <div class="field-group">
                        <label class="field-label">Prenom</label>
                        <input type="text" name="firstname" class="cine-input" value="{{ auth()->user()->firstname ?? '' }}" required>
                    </div>
                    <div class="field-group">
                        <label class="field-label">Nom</label>
                        <input type="text" name="lastname" class="cine-input" value="{{ auth()->user()->lastname ?? '' }}" required>
                    </div>
                    <div class="field-group">
                        <label class="field-label">Pseudo</label>
                        <input type="text" name="username" class="cine-input" value="{{ auth()->user()->username ?? '' }}" required>
                    </div>
                    <div class="field-group">
                        <label class="field-label">Email</label>
                        <input type="email" name="email" class="cine-input" value="{{ auth()->user()->email }}" required>
                    </div>
                    <div class="field-group" style="margin-bottom:18px;">
                        <label class="field-label">Nouveau mot de passe <span style="font-weight:400;">(optionnel)</span></label>
                        <input type="password" name="password" class="cine-input" placeholder="Laisser vide pour ne pas changer">
                    </div>
                    <button type="submit" class="btn-cine" style="width:100%;justify-content:center;"><i class="bi bi-check2"></i> Enregistrer</button>
                </form>
            </div>
        </div>
    </div>

    {{-- COLONNE DROITE --}}
    <div>
        <div class="tab-bar">
            <button class="tab-btn active" onclick="switchTab('notes', this)">
                <i class="bi bi-star-fill" style="color:#f5c518;font-size:11px;"></i> Films notes
                <span style="font-size:11px;color:#38384e;">({{ $notesCount }})</span>
            </button>
            <button class="tab-btn" onclick="switchTab('liste', this)">
                <i class="bi bi-bookmark"></i> Ma liste
                <span style="font-size:11px;color:#38384e;">({{ $favoris->count() }})</span>
            </button>
        </div>

        {{-- ONGLET FILMS NOTES --}}
        <div class="tab-pane active" id="tab-notes">
            @php
                $favorisNotesFiltres = $favoris->filter(fn($f) => !is_null($f->note) && $f->note > 0);
            @endphp
            @if($favorisNotesFiltres->count() > 0)
            <div class="notes-grid">
                @foreach($favorisNotesFiltres as $f)
                <div class="note-card">
                    @if($f->film_poster_path)
                        <img src="https://image.tmdb.org/t/p/w185{{ $f->film_poster_path }}" alt="{{ $f->film_title }}" loading="lazy">
                    @else
                        <div style="width:100%;aspect-ratio:2/3;background:#12121e;display:flex;align-items:center;justify-content:center;"><i class="bi bi-film" style="font-size:24px;color:rgba(255,255,255,0.05);"></i></div>
                    @endif
                    <div class="note-card-body">
                        <div class="note-film-title" title="{{ $f->film_title }}">{{ $f->film_title }}</div>
                        <div class="note-stars">
                            @for($s=1;$s<=5;$s++)
                                <i class="bi bi-star{{ $s <= $f->note ? '-fill' : '' }}{{ $s > $f->note ? ' empty' : '' }}"></i>
                            @endfor
                        </div>
                        @if($f->avis)<div class="note-comment">{{ $f->avis }}</div>@endif
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="empty-state" style="padding:48px 24px;">
                <div class="empty-icon"><i class="bi bi-star"></i></div>
                <h3>Aucune note</h3>
                <p>Notez vos films depuis la page Ma liste.</p>
                <a href="{{ route('favoris') }}" class="btn-cine"><i class="bi bi-bookmark"></i> Ma liste</a>
            </div>
            @endif
        </div>

        {{-- ONGLET MA LISTE --}}
        <div class="tab-pane" id="tab-liste">
            @if($favoris->count() > 0)
            <div class="notes-grid">
                @foreach($favoris as $f)
                <div class="note-card">
                    @if($f->film_poster_path)
                        <img src="https://image.tmdb.org/t/p/w185{{ $f->film_poster_path }}" alt="{{ $f->film_title }}" loading="lazy">
                    @else
                        <div style="width:100%;aspect-ratio:2/3;background:#12121e;display:flex;align-items:center;justify-content:center;"><i class="bi bi-film" style="font-size:24px;color:rgba(255,255,255,0.05);"></i></div>
                    @endif
                    <div class="note-card-body">
                        <div class="note-film-title" title="{{ $f->film_title }}">{{ $f->film_title }}</div>
                        @if($f->film_year)<div style="font-size:10.5px;color:#30303e;margin-bottom:4px;">{{ $f->film_year }}</div>@endif
                        @if($f->note)
                        <div class="note-stars">
                            @for($s=1;$s<=5;$s++)
                                <i class="bi bi-star{{ $s <= $f->note ? '-fill' : '' }}{{ $s > $f->note ? ' empty' : '' }}"></i>
                            @endfor
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="empty-state" style="padding:48px 24px;">
                <div class="empty-icon"><i class="bi bi-bookmark"></i></div>
                <h3>Liste vide</h3>
                <p>Ajoutez des films a votre liste depuis la page Decouvrir.</p>
                <a href="{{ route('rechercherFilm') }}" class="btn-cine"><i class="bi bi-compass"></i> Decouvrir</a>
            </div>
            @endif
        </div>
    </div>
</div>

@else
<div class="empty-state" style="max-width:380px;margin:80px auto;">
    <div class="empty-icon"><i class="bi bi-person-lock"></i></div>
    <h3>Acces restreint</h3>
    <p>Connectez-vous pour acceder a votre profil.</p>
    <a href="{{ route('login') }}" class="btn-cine">Se connecter</a>
</div>
@endauth
</div>
@endsection
@section('scripts')
<script>
function switchTab(tab, btn) {
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));
    btn.classList.add('active');
    document.getElementById('tab-' + tab).classList.add('active');
}
</script>
@endsection
