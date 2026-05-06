@extends('layouts.app')

@section('title', 'Accueil')

@section('content')
<div class="container">
    <h1>Bienvenue sur Mes Films Préférés</h1>
    <p style="font-size: 19px; margin-bottom: 48px;">Découvrez, partagez et organisez vos films préférés avec vos amis.</p>
    
    <div class="row g-4">
        <div class="col-md-6 col-lg-4">
            <div style="background: white; border-radius: 16px; padding: 32px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); transition: transform 0.2s ease, box-shadow 0.2s ease;">
                <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #6366f1, #8b5cf6); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 16px;">
                    <i class="bi bi-search" style="font-size: 24px; color: white;"></i>
                </div>
                <h3 style="font-size: 24px; font-weight: 600; margin-bottom: 8px; color: #1d1d1f;">Rechercher</h3>
                <p style="color: #86868b; margin: 0;">Trouvez vos films préférés parmi des millions de titres.</p>
                <a href="{{ route('rechercherFilm') }}" class="btn btn-primary mt-3" style="width: 100%;">Explorer</a>
            </div>
        </div>
        
        <div class="col-md-6 col-lg-4">
            <div style="background: white; border-radius: 16px; padding: 32px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); transition: transform 0.2s ease, box-shadow 0.2s ease;">
                <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #ec4899, #f472b6); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 16px;">
                    <i class="bi bi-heart" style="font-size: 24px; color: white;"></i>
                </div>
                <h3 style="font-size: 24px; font-weight: 600; margin-bottom: 8px; color: #1d1d1f;">Favoris</h3>
                <p style="color: #86868b; margin: 0;">Conservez vos films préférés dans une collection personnelle.</p>
                <a href="{{ route('favoris') }}" class="btn btn-primary mt-3" style="width: 100%; background: linear-gradient(135deg, #ec4899, #f472b6); border: none;">Voir mes favoris</a>
            </div>
        </div>
        
        <div class="col-md-6 col-lg-4">
            <div style="background: white; border-radius: 16px; padding: 32px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); transition: transform 0.2s ease, box-shadow 0.2s ease;">
                <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #10b981, #34d399); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 16px;">
                    <i class="bi bi-people" style="font-size: 24px; color: white;"></i>
                </div>
                <h3 style="font-size: 24px; font-weight: 600; margin-bottom: 8px; color: #1d1d1f;">Amis</h3>
                <p style="color: #86868b; margin: 0;">Connectez-vous avec vos amis et partagez vos découvertes.</p>
                <a href="{{ route('amis.index') }}" class="btn btn-primary mt-3" style="width: 100%; background: linear-gradient(135deg, #10b981, #34d399); border: none;">Gérer mes amis</a>
            </div>
        </div>
    </div>
</div>
@endsection