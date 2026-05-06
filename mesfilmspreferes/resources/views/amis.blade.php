@extends('layouts.app')
@section('title', 'Amis')
@section('styles')
<style>
.amis-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    gap: 14px;
}
.ami-card {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 20px;
    display: flex;
    flex-direction: column;
    gap: 14px;
    transition: border-color 0.15s;
}
.ami-card:hover { border-color: var(--border-2); }
.ami-avatar {
    width: 44px; height: 44px;
    background: rgba(229,9,20,0.1);
    border: 1px solid rgba(229,9,20,0.2);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 18px; color: var(--red); flex-shrink: 0;
}
.ami-name { font-size: 15px; font-weight: 700; color: var(--text); }
.ami-username { font-size: 12px; color: #4a4a60; margin-top: 1px; }

/* MODAL ADD */
.modal-dark .modal-content {
    background: #12121e;
    border: 1px solid rgba(255,255,255,0.09);
    border-radius: 16px;
    color: var(--text);
}
.modal-dark .modal-header {
    border-bottom: 1px solid var(--border);
    padding: 20px 24px 16px;
}
.modal-dark .modal-body { padding: 24px; }
.modal-dark .modal-title { font-size: 17px; font-weight: 700; color: #fff; }
.modal-dark .btn-close { filter: invert(1) opacity(.5); }
</style>
@endsection
@section('content')
<div class="page-content">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:32px;flex-wrap:wrap;gap:12px;">
        <div>
            <h1 style="font-size:22px;font-weight:800;color:#fff;margin-bottom:4px;">Amis</h1>
            <p style="font-size:13px;color:#4a4a60;">Vos connexions</p>
        </div>
        <button type="button" class="btn-cine" data-bs-toggle="modal" data-bs-target="#addFriendModal">
            <i class="bi bi-person-plus"></i> Ajouter
        </button>
    </div>

    @if(isset($amis) && $amis->count() > 0)
    <div class="amis-grid">
        @foreach($amis as $ami)
        <div class="ami-card">
            <div style="display:flex;align-items:center;gap:14px;">
                <div class="ami-avatar"><i class="bi bi-person"></i></div>
                <div>
                    <div class="ami-name">{{ $ami->firstname }} {{ $ami->lastname }}</div>
                    <div class="ami-username">@{{ $ami->username }}</div>
                </div>
            </div>
            <form action="{{ route('amis.destroy', $ami->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn-cine btn-cine-ghost" style="width:100%;justify-content:center;font-size:12.5px;padding:7px;">
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
        <p>Ajoutez des amis pour partager vos films préférés.</p>
        <button type="button" class="btn-cine" data-bs-toggle="modal" data-bs-target="#addFriendModal">
            <i class="bi bi-person-plus"></i> Ajouter un ami
        </button>
    </div>
    @endif
</div>

<div class="modal fade modal-dark" id="addFriendModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ajouter un ami</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('amis.add') }}" method="POST">
                    @csrf
                    <div style="margin-bottom:14px;">
                        <label style="font-size:12px;font-weight:600;color:#4a4a60;text-transform:uppercase;letter-spacing:.06em;display:block;margin-bottom:8px;">Nom d'utilisateur ou email</label>
                        <input type="text" name="username" class="cine-input" placeholder="Rechercher un utilisateur..." required autofocus>
                    </div>
                    <button type="submit" class="btn-cine" style="width:100%;justify-content:center;"><i class="bi bi-person-plus"></i> Ajouter</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
