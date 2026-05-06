@extends('layouts.app')
@section('title', 'Mon profil')
@section('styles')
<style>
.profil-grid {
    display: grid;
    grid-template-columns: 300px 1fr;
    gap: 24px;
    align-items: start;
}
@media(max-width:768px){ .profil-grid{ grid-template-columns:1fr; } }

.profil-card {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 14px;
    overflow: hidden;
}
.profil-card-header {
    background: linear-gradient(135deg, rgba(229,9,20,0.08), rgba(229,9,20,0.03));
    border-bottom: 1px solid var(--border);
    padding: 28px 24px;
    text-align: center;
}
.profil-avatar {
    width: 72px; height: 72px;
    background: rgba(229,9,20,0.12);
    border: 1px solid rgba(229,9,20,0.22);
    border-radius: 50%;
    display: inline-flex; align-items: center; justify-content: center;
    font-size: 30px; color: var(--red); margin-bottom: 14px;
}
.profil-username { font-size: 18px; font-weight: 800; color: #fff; margin-bottom: 3px; }
.profil-email { font-size: 12.5px; color: #404055; }
.profil-stats {
    display: flex;
    border-top: 1px solid var(--border);
}
.profil-stat {
    flex: 1;
    padding: 16px 10px;
    text-align: center;
    border-right: 1px solid var(--border);
}
.profil-stat:last-child { border-right: none; }
.profil-stat-num { font-size: 20px; font-weight: 800; color: #fff; line-height: 1; }
.profil-stat-label { font-size: 10.5px; color: #3a3a50; text-transform: uppercase; letter-spacing: .07em; margin-top: 3px; }

.form-block { padding: 24px; }
.field-group { margin-bottom: 16px; }
.field-label { display: block; font-size: 11.5px; font-weight: 600; color: #4a4a60; text-transform: uppercase; letter-spacing: .06em; margin-bottom: 7px; }

/* FILMS NOTÉS */
.notes-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
    gap: 14px;
}
.note-card {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 9px;
    overflow: hidden;
    transition: border-color .15s, transform .15s;
}
.note-card:hover { border-color: var(--border-2); transform: translateY(-3px); }
.note-card img { width:100%; aspect-ratio:2/3; object-fit:cover; display:block; }
.note-card-body { padding: 9px 11px 11px; }
.note-film-title { font-size: 12px; font-weight: 600; color: var(--text); white-space:nowrap; overflow:hidden; text-overflow:ellipsis; margin-bottom: 4px; }
.note-stars { display:flex; gap:2px; font-size:11px; color:var(--gold); }
.note-comment { font-size: 11px; color: #45455a; margin-top: 4px; line-height:1.4; font-style:italic; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }
</style>
@endsection
@section('content')
<div class="page-content">
@auth

<div style="margin-bottom:28px;">
    <h1 style="font-size:22px;font-weight:800;color:#fff;margin-bottom:4px;">Mon profil</h1>
    <p style="font-size:13px;color:#4a4a60;">Gérez vos informations personnelles</p>
</div>

<div class="profil-grid">

    {{-- COLONNE GAUCHE : avatar + stats + form --}}
    <div>
        <div class="profil-card" style="margin-bottom:20px;">
            <div class="profil-card-header">
                <div class="profil-avatar"><i class="bi bi-person"></i></div>
                <div class="profil-username">{{ auth()->user()->username ?? auth()->user()->firstname }}</div>
                <div class="profil-email">{{ auth()->user()->email }}</div>
            </div>
            <div class="profil-stats">
                <div class="profil-stat">
                    <div class="profil-stat-num">{{ isset($favoris) ? $favoris->count() : 0 }}</div>
                    <div class="profil-stat-label">Films</div>
                </div>
                <div class="profil-stat">
                    <div class="profil-stat-num">{{ isset($notesCount) ? $notesCount : 0 }}</div>
                    <div class="profil-stat-label">Notes</div>
                </div>
                <div class="profil-stat">
                    <div class="profil-stat-num">{{ isset($amisCount) ? $amisCount : 0 }}</div>
                    <div class="profil-stat-label">Amis</div>
                </div>
            </div>
        </div>

        <div class="profil-card">
            <div class="form-block">
                <div class="section-title" style="margin-bottom:18px;">Modifier</div>
                @if($errors->any())
                <div class="alert-error-dark" style="margin-bottom:16px;"><i class="bi bi-exclamation-circle"></i>
                    <ul style="margin:0;padding-left:16px;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
                @endif
                <form action="{{ route('profil.update') }}" method="POST">
                    @csrf
                    <div class="field-group">
                        <label class="field-label">Prénom</label>
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
                    <div class="field-group" style="margin-bottom:20px;">
                        <label class="field-label">Nouveau mot de passe <span style="color:#2a2a40;font-weight:400;">(optionnel)</span></label>
                        <input type="password" name="password" class="cine-input" placeholder="Laisser vide pour ne pas changer">
                    </div>
                    <button type="submit" class="btn-cine" style="width:100%;justify-content:center;"><i class="bi bi-check2"></i> Enregistrer</button>
                </form>
            </div>
        </div>
    </div>

    {{-- COLONNE DROITE : films notés --}}
    <div>
        <div class="section-title" style="margin-bottom:20px;">Films notés &amp; vus</div>

        @if(isset($favorisNotes) && $favorisNotes->count() > 0)
        <div class="notes-grid">
            @foreach($favorisNotes as $f)
            <div class="note-card">
                @if($f->film_poster_path)
                    <img src="https://image.tmdb.org/t/p/w185{{ $f->film_poster_path }}" alt="{{ $f->film_title }}" loading="lazy">
                @else
                    <div style="width:100%;aspect-ratio:2/3;background:var(--bg-card-2);display:flex;align-items:center;justify-content:center;"><i class="bi bi-film" style="font-size:24px;color:#1e1e2e;"></i></div>
                @endif
                <div class="note-card-body">
                    <div class="note-film-title">{{ $f->film_title }}</div>
                    @if($f->note)
                    <div class="note-stars">
                        @for($s=1;$s<=5;$s++)<i class="bi bi-star{{ $s <= $f->note ? '-fill' : '' }}"></i>@endfor
                    </div>
                    @endif
                    @if($f->avis)<div class="note-comment">{{ $f->avis }}</div>@endif
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="empty-state" style="padding:48px 24px;">
            <div class="empty-icon"><i class="bi bi-star"></i></div>
            <h3>Aucune note</h3>
            <p>Notez des films depuis la page découvrir pour les voir ici.</p>
        </div>
        @endif
    </div>

</div>

@else
<div class="empty-state" style="max-width:400px;margin:80px auto;">
    <div class="empty-icon"><i class="bi bi-person-lock"></i></div>
    <h3>Accès restreint</h3>
    <p>Connectez-vous pour accéder à votre profil.</p>
    <a href="{{ route('login') }}" class="btn-cine">Se connecter</a>
</div>
@endauth
</div>
@endsection
