@extends('layouts.app')
@section('title', 'Amis')
@section('styles')
<style>
.amis-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 14px;
}
.ami-card {
    background: #0d0d18;
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 20px 18px 16px;
    display: flex;
    flex-direction: column;
    gap: 0;
    transition: border-color .15s, transform .15s;
    position: relative;
    overflow: hidden;
}
.ami-card::before {
    content:'';
    position:absolute; top:0; left:0; right:0; height:3px;
    background: linear-gradient(90deg, rgba(229,9,20,0.6), rgba(229,9,20,0.1));
    opacity:0;
    transition: opacity .2s;
}
.ami-card:hover { border-color:rgba(255,255,255,0.1); transform:translateY(-2px); }
.ami-card:hover::before { opacity:1; }

.ami-top { display:flex; align-items:center; gap:14px; margin-bottom:14px; }
.ami-avatar {
    width:48px; height:48px;
    background: rgba(229,9,20,0.07);
    border: 1px solid rgba(229,9,20,0.15);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 20px; color: #bb3333; flex-shrink:0;
}
.ami-name { font-size:14px; font-weight:700; color:var(--text); margin-bottom:2px; }
.ami-username { font-size:11.5px; color:#38384e; }
.ami-films-count {
    font-size:11px; color:#30304a;
    background: rgba(255,255,255,0.03);
    border:1px solid var(--border);
    border-radius:20px;
    padding:3px 10px;
    display:inline-flex; align-items:center; gap:5px;
    margin-bottom:14px;
    width:fit-content;
}

/* MODAL */
.modal-dark .modal-content {
    background: #0e0e1a;
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 16px;
    color: var(--text);
}
.modal-dark .modal-header { border-bottom:1px solid var(--border); padding:20px 24px 16px; }
.modal-dark .modal-body { padding:24px; }
.modal-dark .modal-title { font-size:17px; font-weight:700; color:#fff; }
.modal-dark .btn-close { filter:invert(1) opacity(.4); }
</style>
@endsection
@section('content')
<div class="page-content">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:32px;flex-wrap:wrap;gap:12px;">
        <div>
            <h1 style="font-size:22px;font-weight:800;color:#fff;margin-bottom:4px;">Amis</h1>
            <p style="font-size:13px;color:#38384e;">{{ isset($amis) ? $amis->count() : 0 }} connexion{{ (isset($amis) && $amis->count() > 1) ? 's' : '' }}</p>
        </div>
        <button type="button" class="btn-cine" data-bs-toggle="modal" data-bs-target="#addFriendModal">
            <i class="bi bi-person-plus"></i> Ajouter un ami
        </button>
    </div>

    @if(session('success'))<div style="background:rgba(100,200,100,0.08);border:1px solid rgba(100,200,100,0.2);border-radius:8px;padding:10px 14px;color:#6dca6d;font-size:13px;margin-bottom:20px;">{{ session('success') }}</div>@endif
    @if(session('error'))<div style="background:rgba(200,80,80,0.08);border:1px solid rgba(200,80,80,0.2);border-radius:8px;padding:10px 14px;color:#ca6d6d;font-size:13px;margin-bottom:20px;">{{ session('error') }}</div>@endif

    @if(isset($amis) && $amis->count() > 0)
    <div class="amis-grid">
        @foreach($amis as $ami)
        @php
            $filmsCount = \App\Models\Favori::where('user_id', $ami->id)->count();
        @endphp
        <div class="ami-card">
            <div class="ami-top">
                <div class="ami-avatar"><i class="bi bi-person"></i></div>
                <div>
                    <div class="ami-name">{{ $ami->firstname }} {{ $ami->lastname }}</div>
                    <div class="ami-username">@{{ $ami->username }}</div>
                </div>
            </div>
            <div class="ami-films-count">
                <i class="bi bi-bookmark"></i> {{ $filmsCount }} film{{ $filmsCount > 1 ? 's' : '' }} en liste
            </div>
            <form action="{{ route('amis.destroy', $ami->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn-cine btn-cine-ghost" style="width:100%;justify-content:center;font-size:12px;padding:7px;">
                    <i class="bi bi-person-dash"></i> Retirer
                </button>
            </form>
        </div>
        @endforeach
    </div>
    @else
    <div class="empty-state">
        <div class="empty-icon"><i class="bi bi-people"></i></div>
        <h3>Aucun ami pour le moment</h3>
        <p>Ajoutez des amis pour partager vos films preferes.</p>
        <button type="button" class="btn-cine" data-bs-toggle="modal" data-bs-target="#addFriendModal">
            <i class="bi bi-person-plus"></i> Ajouter un ami
        </button>
    </div>
    @endif
</div>

{{-- MODAL --}}
<div class="modal fade modal-dark" id="addFriendModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ajouter un ami</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p style="font-size:12.5px;color:#42425a;margin-bottom:16px;">Entrez le nom d'utilisateur ou l'email de la personne a ajouter.</p>
                <form action="{{ route('amis.add') }}" method="POST">
                    @csrf
                    <div style="margin-bottom:14px;">
                        <label style="font-size:11px;font-weight:600;color:#40405a;text-transform:uppercase;letter-spacing:.06em;display:block;margin-bottom:8px;">Nom d'utilisateur ou email</label>
                        <input type="text" name="username" class="cine-input" placeholder="ex: jean_dupont" required autofocus>
                    </div>
                    <button type="submit" class="btn-cine" style="width:100%;justify-content:center;"><i class="bi bi-person-plus"></i> Ajouter</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
