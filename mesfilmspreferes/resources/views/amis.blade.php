@extends('layouts.app')

@section('title', 'Mes amis')

@section('content')
<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px;">
        <h1>Mes amis</h1>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addFriendModal">
            <i class="bi bi-person-plus me-2"></i>Ajouter un ami
        </button>
    </div>
    
    @if(isset($amis) && $amis->count() > 0)
        <div class="row g-4">
            @foreach($amis as $ami)
            <div class="col-md-6 col-lg-4">
                <div style="background: white; border-radius: 16px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); transition: transform 0.2s ease, box-shadow 0.2s ease;">
                    <div style="display: flex; align-items: center; margin-bottom: 16px;">
                        <div style="width: 56px; height: 56px; background: linear-gradient(135deg, #10b981, #34d399); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 16px;">
                            <i class="bi bi-person" style="font-size: 28px; color: white;"></i>
                        </div>
                        <div style="flex: 1;">
                            <h3 style="font-size: 20px; font-weight: 600; margin: 0; color: #1d1d1f;">{{ $ami->username ?? $ami->firstname . ' ' . $ami->lastname }}</h3>
                            <p style="color: #86868b; font-size: 15px; margin: 4px 0 0 0;">{{ $ami->email ?? '' }}</p>
                        </div>
                    </div>
                    <form action="{{ route('amis.destroy', $ami->id) }}" method="POST">
                        @csrf
                        @method('POST')
                        <button type="submit" class="btn" style="width: 100%; background: #f5f5f7; color: #1d1d1f; border: none; border-radius: 8px; padding: 8px;">
                            <i class="bi bi-person-dash me-1"></i>Retirer
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div style="text-align: center; padding: 64px 32px; background: white; border-radius: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
            <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #10b981, #34d399); border-radius: 20px; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 24px;">
                <i class="bi bi-people" style="font-size: 40px; color: white;"></i>
            </div>
            <h2 style="font-size: 28px; font-weight: 600; margin-bottom: 12px; color: #1d1d1f;">Aucun ami pour le moment</h2>
            <p style="color: #86868b; font-size: 17px; margin-bottom: 32px;">Ajoutez des amis pour partager vos films préférés.</p>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addFriendModal">
                <i class="bi bi-person-plus me-2"></i>Ajouter un ami
            </button>
        </div>
    @endif
</div>

<div class="modal fade" id="addFriendModal" tabindex="-1" aria-labelledby="addFriendModalLabel" aria-hidden="true">
    <div class="modal-dialog">
            <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 8px 32px rgba(0,0,0,0.12);">
            <div class="modal-header" style="border-bottom: 0.5px solid #e8e8ed; padding: 24px 24px 0 24px;">
                <h2 class="modal-title" id="addFriendModalLabel" style="font-size: 24px; font-weight: 600;">Ajouter un ami</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="modal-body" style="padding: 24px;">
                <form action="{{ route('amis.add') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label>Nom d'utilisateur ou email</label>
                        <input type="text" name="username" class="form-control" placeholder="Entrez le nom d'utilisateur ou l'email" required>
                    </div>
                    <button type="submit" class="btn btn-primary" style="width: 100%;">Ajouter</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
