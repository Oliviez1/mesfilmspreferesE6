@extends('layouts.app')

@section('title', 'Profil')

@section('content')
<div class="container">
    <h1 style="margin-bottom: 32px;">Mon profil</h1>
    
    <div style="max-width: 600px;">
    <div style="background: white; border-radius: 16px; padding: 32px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
            @if(auth()->check())
                <div style="text-align: center; margin-bottom: 32px;">
                    <div style="width: 100px; height: 100px; background: linear-gradient(135deg, #6366f1, #8b5cf6); border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 16px;">
                        <i class="bi bi-person" style="font-size: 48px; color: white;"></i>
                    </div>
                    <h2 style="font-size: 28px; font-weight: 600; margin-bottom: 8px; color: #1d1d1f;">{{ auth()->user()->username ?? auth()->user()->firstname . ' ' . auth()->user()->lastname }}</h2>
                    <p style="color: #86868b; font-size: 17px;">{{ auth()->user()->email }}</p>
                </div>
                
                <form action="{{ route('profil.update') }}" method="POST">
                    @csrf
                    @method('POST')
                    
                    <div class="mb-3">
                        <label>Prénom</label>
                        <input type="text" name="firstname" class="form-control" value="{{ auth()->user()->firstname ?? '' }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label>Nom</label>
                        <input type="text" name="lastname" class="form-control" value="{{ auth()->user()->lastname ?? '' }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label>Nom d'utilisateur</label>
                        <input type="text" name="username" class="form-control" value="{{ auth()->user()->username ?? '' }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="{{ auth()->user()->email }}" required>
                    </div>
                    
                    <div class="mb-4">
                        <label>Nouveau mot de passe (laisser vide pour ne pas changer)</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                    
                    <button type="submit" class="btn btn-primary" style="width: 100%;">
                        <i class="bi bi-check-circle me-2"></i>Mettre à jour
                    </button>
                </form>
            @else
                <div style="text-align: center; padding: 32px;">
                    <p style="color: #86868b; font-size: 17px;">Veuillez vous connecter pour voir votre profil.</p>
                    <a href="{{ route('login') }}" class="btn btn-primary mt-3">Se connecter</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
