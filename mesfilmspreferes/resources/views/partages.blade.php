@extends('layouts.app')

@section('title', 'Partages')

@section('content')
<div class="container">
    <h1 style="margin-bottom: 32px;">Partages</h1>
    
    @if(isset($partages) && $partages->count() > 0)
        <div class="row g-4">
            @foreach($partages as $partage)
            <div class="col-md-6">
                <div style="background: white; border-radius: 16px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); transition: transform 0.2s ease, box-shadow 0.2s ease;">
                    <div style="display: flex; align-items: start; margin-bottom: 16px;">
                        @if($partage->film_poster_path)
                            <img src="https://image.tmdb.org/t/p/w200{{ $partage->film_poster_path }}" alt="{{ $partage->film_title }}" style="width: 80px; height: 120px; object-fit: cover; border-radius: 8px; margin-right: 16px;">
                        @else
                            <div style="width: 80px; height: 120px; background: linear-gradient(135deg, #8b5cf6, #a78bfa); border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-right: 16px;">
                                <i class="bi bi-film" style="font-size: 32px; color: white; opacity: 0.5;"></i>
                            </div>
                        @endif
                        <div style="flex: 1;">
                            <h3 style="font-size: 20px; font-weight: 600; margin-bottom: 8px; color: #1d1d1f;">{{ $partage->film_title }}</h3>
                            <p style="color: #86868b; font-size: 15px; margin-bottom: 12px;">
                                <i class="bi bi-person me-1"></i>Partagé par {{ $partage->user->username ?? 'Utilisateur' }}
                            </p>
                            @if($partage->message)
                                <p style="color: #1d1d1f; font-size: 15px; line-height: 1.5; margin-bottom: 12px;">{{ $partage->message }}</p>
                            @endif
                            @if($partage->avis)
                                <div style="background: #f5f5f7; border-radius: 8px; padding: 12px; margin-top: 12px;">
                                    <p style="color: #1d1d1f; font-size: 15px; margin: 0; font-style: italic;">"{{ $partage->avis }}"</p>
                                </div>
                            @endif
                        </div>
                    </div>
                    @if(auth()->id() == $partage->user_id)
                        <form action="{{ route('partages.destroy', $partage->id) }}" method="POST">
                            @csrf
                            @method('POST')
                            <button type="submit" class="btn" style="width: 100%; background: #f5f5f7; color: #1d1d1f; border: none; border-radius: 8px; padding: 8px;">
                                <i class="bi bi-trash me-1"></i>Supprimer
                            </button>
                        </form>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div style="text-align: center; padding: 64px 32px; background: white; border-radius: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
            <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #8b5cf6, #a78bfa); border-radius: 20px; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 24px;">
                <i class="bi bi-share" style="font-size: 40px; color: white;"></i>
            </div>
            <h2 style="font-size: 28px; font-weight: 600; margin-bottom: 12px; color: #1d1d1f;">Aucun partage pour le moment</h2>
            <p style="color: #86868b; font-size: 17px; margin-bottom: 32px;">Les films partagés par vos amis apparaîtront ici.</p>
        </div>
    @endif
</div>
@endsection
