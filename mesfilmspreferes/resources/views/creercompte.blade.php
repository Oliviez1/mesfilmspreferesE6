@extends('layouts.app')

@section('title', 'Créer un compte')

@section('content')
<div class="container">
    <div style="max-width: 480px; margin: 0 auto;">
        <div style="text-align: center; margin-bottom: 40px;">
            <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #6366f1, #8b5cf6); border-radius: 20px; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 24px;">
                <i class="bi bi-person-plus" style="font-size: 40px; color: white;"></i>
            </div>
            <h1 style="margin-bottom: 12px;">Créer un compte</h1>
            <p style="color: #86868b; font-size: 17px;">Rejoignez la communauté</p>
        </div>
        
        <div style="background: white; border-radius: 16px; padding: 32px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
            <form action="{{ route('creerComptePost') }}" method="POST">
                @csrf

                @if($errors->any())
                    <div class="alert alert-danger" style="background: rgba(239, 68, 68, 0.1); color: #dc2626; border-left: 3px solid #dc2626; margin-bottom: 24px;">
                        <i class="bi bi-exclamation-circle me-2"></i>
                        <ul style="margin: 0; padding-left: 20px;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="mb-3">
                    <label>Prénom</label>
                    <input class="form-control" type="text" name="firstname" value="{{ old('firstname') }}" required autofocus>
                </div>

                <div class="mb-3">
                    <label>Nom</label>
                    <input class="form-control" type="text" name="lastname" value="{{ old('lastname') }}" required>
                </div>

                <div class="mb-3">
                    <label>Nom d'utilisateur</label>
                    <input class="form-control" type="text" name="username" value="{{ old('username') }}" required>
                </div>

                <div class="mb-3">
                    <label>Email</label>
                    <input class="form-control" type="email" name="email" value="{{ old('email') }}" required>
                </div>

                <div class="mb-4">
                    <label>Mot de passe</label>
                    <input class="form-control" type="password" name="password" required>
                </div>

                <button class="btn btn-primary" type="submit" style="width: 100%;">
                    <i class="bi bi-person-plus me-2"></i>Créer un compte
                </button>
            </form>
            
            <div style="text-align: center; margin-top: 24px; padding-top: 24px; border-top: 0.5px solid #e8e8ed;">
                <p style="color: #86868b; font-size: 15px; margin: 0;">
                    Déjà un compte ? 
                    <a href="{{ route('login') }}" style="color: #6366f1; text-decoration: none; font-weight: 500;">Se connecter</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection