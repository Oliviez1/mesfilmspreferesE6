@extends('layouts.app')

@section('title', 'Connexion')

@section('styles')
<style>
.auth-wrap {
    min-height: calc(100vh - 70px);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px 16px;
    background: radial-gradient(ellipse at 50% 0%, rgba(229,9,20,0.08) 0%, transparent 60%);
}
.auth-card {
    width: 100%;
    max-width: 440px;
    background: #13131e;
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 20px;
    padding: 40px 36px;
    box-shadow: 0 24px 64px rgba(0,0,0,0.6);
}
.auth-logo {
    text-align: center;
    margin-bottom: 32px;
}
.auth-logo .icon-wrap {
    width: 64px; height: 64px;
    background: rgba(229,9,20,0.15);
    border: 1px solid rgba(229,9,20,0.3);
    border-radius: 16px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    color: var(--red);
    margin-bottom: 16px;
}
.auth-logo h1 {
    font-size: 22px;
    font-weight: 800;
    color: #fff;
    margin-bottom: 6px;
}
.auth-logo p { color: var(--text-muted); font-size: 14px; }

.auth-field { margin-bottom: 18px; }
.auth-field label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 0.06em;
    margin-bottom: 8px;
}
.auth-field .input-wrap { position: relative; }
.auth-field .input-wrap i {
    position: absolute;
    left: 14px; top: 50%; transform: translateY(-50%);
    color: var(--text-muted);
    font-size: 16px;
    pointer-events: none;
}
.auth-field input {
    width: 100%;
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 10px;
    padding: 12px 14px 12px 42px;
    color: #fff;
    font-size: 15px;
    transition: border-color 0.2s, box-shadow 0.2s;
    outline: none;
}
.auth-field input:focus {
    border-color: var(--red);
    box-shadow: 0 0 0 3px rgba(229,9,20,0.15);
}
.auth-field input::placeholder { color: rgba(255,255,255,0.2); }

.auth-submit {
    width: 100%;
    background: var(--red);
    color: #fff;
    border: none;
    border-radius: 10px;
    padding: 13px;
    font-size: 15px;
    font-weight: 700;
    cursor: pointer;
    margin-top: 8px;
    transition: background 0.2s, transform 0.15s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}
.auth-submit:hover { background: #c8000f; transform: translateY(-1px); }
.auth-submit:active { transform: none; }

.auth-divider {
    text-align: center;
    margin-top: 24px;
    padding-top: 24px;
    border-top: 1px solid rgba(255,255,255,0.07);
    font-size: 14px;
    color: var(--text-muted);
}
.auth-divider a { color: var(--red); text-decoration: none; font-weight: 600; }
.auth-divider a:hover { text-decoration: underline; }

.auth-error {
    background: rgba(229,9,20,0.1);
    border: 1px solid rgba(229,9,20,0.3);
    border-radius: 10px;
    padding: 12px 16px;
    color: #ff6b6b;
    font-size: 13px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 8px;
}
</style>
@endsection

@section('content')
<div class="auth-wrap">
    <div class="auth-card">
        <div class="auth-logo">
            <div class="icon-wrap"><i class="bi bi-film"></i></div>
            <h1>Mes Films Préférés</h1>
            <p>Connectez-vous à votre compte</p>
        </div>

        @if($errors->any())
        <div class="auth-error">
            <i class="bi bi-exclamation-circle"></i> {{ $errors->first() }}
        </div>
        @endif

        <form action="{{ route('loginPost') }}" method="POST">
            @csrf
            <div class="auth-field">
                <label>Email</label>
                <div class="input-wrap">
                    <i class="bi bi-envelope"></i>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="votre@email.com" required autofocus>
                </div>
            </div>
            <div class="auth-field">
                <label>Mot de passe</label>
                <div class="input-wrap">
                    <i class="bi bi-lock"></i>
                    <input type="password" name="password" placeholder="••••••••" required>
                </div>
            </div>
            <button type="submit" class="auth-submit">
                <i class="bi bi-box-arrow-in-right"></i> Se connecter
            </button>
        </form>

        <div class="auth-divider">
            Pas encore de compte ? <a href="{{ route('creerCompte') }}">Créer un compte</a>
        </div>
    </div>
</div>
@endsection
