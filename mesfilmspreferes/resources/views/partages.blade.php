@extends('layouts.app')
@section('title', 'Partages')
@section('styles')
<style>
.partages-tabs { display:flex; gap:0; border-bottom:1px solid var(--border); margin-bottom:24px; }
.ptab-btn {
    padding:10px 18px; font-size:13px; font-weight:600; color:#46466a;
    background:none; border:none; border-bottom:2px solid transparent;
    cursor:pointer; margin-bottom:-1px; transition:color .15s, border-color .15s;
    display:flex; align-items:center; gap:6px;
}
.ptab-btn.active { color:#fff; border-bottom-color:var(--red); }
.ptab-btn:hover:not(.active) { color:var(--text); }
.ptab-pane { display:none; }
.ptab-pane.active { display:block; }

.partages-list { display:flex; flex-direction:column; gap:12px; }
.partage-card {
    background:#0d0d18;
    border:1px solid var(--border);
    border-radius:12px;
    padding:16px 20px;
    display:flex;
    gap:18px;
    align-items:flex-start;
    transition:border-color .15s;
}
.partage-card:hover { border-color:var(--border-2); }
.partage-poster {
    flex-shrink:0; width:64px; height:96px;
    border-radius:7px; object-fit:cover;
    border:1px solid var(--border); background:var(--bg-card-2);
}
.partage-poster-ph {
    flex-shrink:0; width:64px; height:96px;
    border-radius:7px; border:1px solid var(--border);
    background:#12121e; display:flex; align-items:center;
    justify-content:center; color:#222230; font-size:22px;
}
.partage-title { font-size:15px; font-weight:700; color:#fff; margin-bottom:3px; }
.partage-from { font-size:12px; color:#42425a; margin-bottom:8px; }
.partage-msg {
    font-size:13px; color:#52526a;
    background:rgba(255,255,255,0.025);
    border:1px solid var(--border);
    border-radius:8px;
    padding:8px 12px;
    font-style:italic;
    margin-bottom:10px;
    max-width:420px;
}
.badge-recu { display:inline-flex;align-items:center;gap:4px;font-size:10.5px;font-weight:600;color:#6dca6d;background:rgba(109,202,109,0.08);border:1px solid rgba(109,202,109,0.18);border-radius:20px;padding:2px 9px;margin-bottom:8px; }
.badge-envoye { display:inline-flex;align-items:center;gap:4px;font-size:10.5px;font-weight:600;color:#7a9ef5;background:rgba(122,158,245,0.08);border:1px solid rgba(122,158,245,0.18);border-radius:20px;padding:2px 9px;margin-bottom:8px; }
</style>
@endsection
@section('content')
<div class="page-content">
    <div style="margin-bottom:28px;">
        <h1 style="font-size:22px;font-weight:800;color:#fff;margin-bottom:4px;">Partages</h1>
        <p style="font-size:13px;color:#42425a;">Films partages entre amis</p>
    </div>

    @if(session('success'))<div style="background:rgba(100,200,100,0.08);border:1px solid rgba(100,200,100,0.2);border-radius:8px;padding:10px 14px;color:#6dca6d;font-size:13px;margin-bottom:16px;">{{ session('success') }}</div>@endif
    @if(session('error'))<div style="background:rgba(200,80,80,0.08);border:1px solid rgba(200,80,80,0.2);border-radius:8px;padding:10px 14px;color:#ca6d6d;font-size:13px;margin-bottom:16px;">{{ session('error') }}</div>@endif

    <div class="partages-tabs">
        <button class="ptab-btn active" onclick="switchPTab('recus',this)"><i class="bi bi-inbox"></i> Recus <span style="font-size:11px;color:#38384e;">({{ isset($partages) ? $partages->count() : 0 }})</span></button>
        <button class="ptab-btn" onclick="switchPTab('envoyes',this)"><i class="bi bi-send"></i> Envoyes <span style="font-size:11px;color:#38384e;">({{ isset($partagesEnvoyes) ? $partagesEnvoyes->count() : 0 }})</span></button>
    </div>

    {{-- RECUS --}}
    <div class="ptab-pane active" id="ptab-recus">
        @if(isset($partages) && $partages->count() > 0)
        <div class="partages-list">
            @foreach($partages as $partage)
            <div class="partage-card">
                @if($partage->film_poster_path)
                    <img src="https://image.tmdb.org/t/p/w185{{ $partage->film_poster_path }}" alt="{{ $partage->film_title }}" class="partage-poster" loading="lazy">
                @else
                    <div class="partage-poster-ph"><i class="bi bi-film"></i></div>
                @endif
                <div style="flex:1;">
                    <div class="badge-recu"><i class="bi bi-arrow-down-left"></i> Recu</div>
                    <div class="partage-title">{{ $partage->film_title }}</div>
                    <div class="partage-from">De <strong>{{ $partage->user->username ?? 'Utilisateur' }}</strong> &middot; {{ $partage->created_at->diffForHumans() }}</div>
                    @if($partage->message)<div class="partage-msg">{{ $partage->message }}</div>@endif
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="empty-state" style="padding:48px 24px;">
            <div class="empty-icon"><i class="bi bi-inbox"></i></div>
            <h3>Aucun partage recu</h3>
            <p>Quand un ami vous partage un film, il apparaitra ici.</p>
        </div>
        @endif
    </div>

    {{-- ENVOYES --}}
    <div class="ptab-pane" id="ptab-envoyes">
        @if(isset($partagesEnvoyes) && $partagesEnvoyes->count() > 0)
        <div class="partages-list">
            @foreach($partagesEnvoyes as $partage)
            <div class="partage-card">
                @if($partage->film_poster_path)
                    <img src="https://image.tmdb.org/t/p/w185{{ $partage->film_poster_path }}" alt="{{ $partage->film_title }}" class="partage-poster" loading="lazy">
                @else
                    <div class="partage-poster-ph"><i class="bi bi-film"></i></div>
                @endif
                <div style="flex:1;">
                    <div class="badge-envoye"><i class="bi bi-arrow-up-right"></i> Envoye</div>
                    <div class="partage-title">{{ $partage->film_title }}</div>
                    <div class="partage-from">{{ $partage->created_at->diffForHumans() }}</div>
                    @if($partage->message)<div class="partage-msg">{{ $partage->message }}</div>@endif
                    <form action="{{ route('partages.destroy', $partage->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn-cine btn-cine-danger" style="font-size:11.5px;padding:5px 12px;"><i class="bi bi-trash"></i> Supprimer</button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="empty-state" style="padding:48px 24px;">
            <div class="empty-icon"><i class="bi bi-send"></i></div>
            <h3>Aucun partage envoye</h3>
            <p>Partagez un film depuis votre liste de favoris.</p>
            <a href="{{ route('favoris') }}" class="btn-cine"><i class="bi bi-bookmark"></i> Ma liste</a>
        </div>
        @endif
    </div>
</div>
<script>
function switchPTab(tab, btn) {
    document.querySelectorAll('.ptab-btn').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.ptab-pane').forEach(p => p.classList.remove('active'));
    btn.classList.add('active');
    document.getElementById('ptab-' + tab).classList.add('active');
}
</script>
@endsection
