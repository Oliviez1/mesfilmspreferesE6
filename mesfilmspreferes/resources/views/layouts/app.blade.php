<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Mes Films Préférés')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg:         #080810;
            --bg-card:    #10101a;
            --bg-card-2:  #18182a;
            --border:     rgba(255,255,255,0.07);
            --border-2:   rgba(255,255,255,0.12);
            --text:       #e2e2ee;
            --text-muted: #70708a;
            --text-dim:   #505068;
            --red:        #e50914;
            --red-hover:  #ff1420;
            --gold:       #f5c518;
            --radius:     10px;
            --nav-h:      60px;
            --t:          0.12s;
        }

        html { scroll-behavior: smooth; }

        body {
            padding-top: var(--nav-h);
            background: var(--bg);
            min-height: 100vh;
            font-family: 'Inter', -apple-system, sans-serif;
            font-size: 15px;
            line-height: 1.6;
            color: var(--text);
            -webkit-font-smoothing: antialiased;
        }

        /* NAV */
        .navbar {
            height: var(--nav-h);
            background: rgba(8,8,16,0.96);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
            padding: 0 28px;
        }
        .navbar-brand {
            font-size: 16px;
            font-weight: 800;
            letter-spacing: -0.01em;
            color: #fff !important;
            text-decoration: none;
            margin-right: 36px;
            display: flex;
            align-items: center;
            gap: 9px;
        }
        .navbar-brand .brand-accent { color: var(--red); }

        /* NAV LINKS — style pill actif */
        .nav-link {
            color: #6a6a80 !important;
            font-size: 13.5px;
            font-weight: 500;
            padding: 7px 14px !important;
            border-radius: 8px;
            transition: color var(--t), background var(--t);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 7px;
            white-space: nowrap;
        }
        .nav-link i { font-size: 13px; }
        .nav-link:hover { color: #c0c0d8 !important; background: rgba(255,255,255,0.05); }
        .nav-link.active { color: #fff !important; background: rgba(255,255,255,0.08); }

        /* Boutons nav droite */
        .btn-nav-login {
            border: 1px solid rgba(255,255,255,0.13) !important;
            color: #b0b0c8 !important;
        }
        .btn-nav-login:hover { border-color: rgba(255,255,255,0.28) !important; color: #fff !important; background: rgba(255,255,255,0.07) !important; }
        .btn-nav-register {
            background: var(--red) !important;
            color: #fff !important;
            border-radius: 8px;
            padding: 7px 16px !important;
            font-weight: 600;
            font-size: 13.5px;
            transition: background var(--t) !important;
            border: none !important;
        }
        .btn-nav-register:hover { background: var(--red-hover) !important; }

        /* NAV TABS redesignés */
        .nav-tabs-bar {
            display: flex;
            gap: 2px;
            align-items: center;
        }
        .nav-tab-item {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 13.5px;
            font-weight: 500;
            color: #60607a;
            text-decoration: none;
            transition: color var(--t), background var(--t);
            position: relative;
        }
        .nav-tab-item:hover { color: #c0c0d8; background: rgba(255,255,255,0.05); }
        .nav-tab-item.active { color: #fff; background: rgba(255,255,255,0.08); }
        .nav-tab-item i { font-size: 13px; }

        /* LAYOUT */
        .page-content {
            max-width: 1260px;
            margin: 0 auto;
            padding: 40px 24px 100px;
        }

        /* CARDS FILM */
        .movie-card {
            background: var(--bg-card);
            border-radius: var(--radius);
            overflow: hidden;
            border: 1px solid var(--border);
            transition: transform var(--t), box-shadow var(--t), border-color var(--t);
            cursor: pointer;
            position: relative;
        }
        .movie-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 40px rgba(0,0,0,0.6);
            border-color: rgba(255,255,255,0.14);
        }
        .movie-card img { width:100%; aspect-ratio:2/3; object-fit:cover; display:block; }
        .poster-placeholder {
            width:100%; aspect-ratio:2/3;
            background: var(--bg-card-2);
            display:flex; align-items:center; justify-content:center;
        }
        .poster-placeholder i { font-size:44px; color:rgba(255,255,255,0.06); }

        /* POSTER PLACEHOLDER DARK */
        .film-placeholder-dark {
            width:100%; aspect-ratio:2/3;
            background: #14141e;
            display:flex; align-items:center; justify-content:center;
            border-radius: inherit;
        }
        .film-placeholder-dark i { font-size:32px; color:rgba(255,255,255,0.07); }

        /* BUTTONS */
        .btn-cine {
            display: inline-flex; align-items: center; gap: 7px;
            background: var(--red); color: #fff; border: none;
            border-radius: 8px; padding: 10px 20px;
            font-size: 13.5px; font-weight: 600; cursor: pointer;
            transition: background var(--t), transform var(--t);
            text-decoration: none;
        }
        .btn-cine:hover { background: var(--red-hover); color: #fff; transform: translateY(-1px); }
        .btn-cine:active { transform: none; }
        .btn-cine-outline {
            background: transparent;
            border: 1px solid rgba(255,255,255,0.16);
            color: var(--text);
        }
        .btn-cine-outline:hover { background: rgba(255,255,255,0.07); color: var(--text); border-color: rgba(255,255,255,0.3); }
        .btn-cine-ghost {
            background: rgba(255,255,255,0.06);
            border: 1px solid var(--border);
            color: var(--text);
        }
        .btn-cine-ghost:hover { background: rgba(255,255,255,0.1); color: var(--text); }
        .btn-cine-gold { background: var(--gold); color: #000; }
        .btn-cine-gold:hover { background: #ffd000; color: #000; }
        .btn-cine-danger { background: rgba(229,9,20,0.1); border: 1px solid rgba(229,9,20,0.22); color: #ff6b6b; }
        .btn-cine-danger:hover { background: rgba(229,9,20,0.2); color: #ff6b6b; }

        /* INPUTS */
        .cine-input,
        select.cine-input {
            background: var(--bg-card) !important;
            border: 1px solid var(--border-2) !important;
            border-radius: 9px !important;
            color: var(--text) !important;
            padding: 11px 16px !important;
            font-size: 14px !important;
            transition: border-color var(--t), box-shadow var(--t);
            width: 100%;
            outline: none;
            appearance: none;
            -webkit-appearance: none;
        }
        .cine-input:focus,
        select.cine-input:focus {
            border-color: var(--red) !important;
            box-shadow: 0 0 0 3px rgba(229,9,20,0.12) !important;
            background: var(--bg-card-2) !important;
        }
        .cine-input::placeholder { color: #444458 !important; }
        textarea.cine-input { padding: 12px 16px !important; resize: vertical; }
        select.cine-input option { background: #13131e; color: var(--text); }

        /* SECTION TITLE */
        .section-title {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.10em;
            text-transform: uppercase;
            color: #50506a;
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .section-title::after { content:''; flex:1; height:1px; background: var(--border); }

        /* BADGE */
        .badge-genre {
            display: inline-block;
            background: rgba(255,255,255,0.05);
            border: 1px solid var(--border);
            color: #8080a0;
            border-radius: 999px;
            padding: 3px 11px;
            font-size: 11.5px;
            font-weight: 500;
        }

        /* ALERTS */
        .alert-success-dark {
            background: rgba(16,185,129,0.08);
            border: 1px solid rgba(16,185,129,0.2);
            color: #34d399;
            border-radius: var(--radius);
            padding: 12px 16px;
            font-size: 13.5px;
            display: flex;
            align-items: center;
            gap: 9px;
        }
        .alert-error-dark {
            background: rgba(229,9,20,0.08);
            border: 1px solid rgba(229,9,20,0.2);
            color: #ff6b6b;
            border-radius: var(--radius);
            padding: 12px 16px;
            font-size: 13.5px;
            display: flex;
            align-items: center;
            gap: 9px;
        }

        /* SCROLLBAR */
        ::-webkit-scrollbar { width: 4px; height: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #252535; border-radius: 4px; }

        /* EMPTY STATE — tout sombre, jamais de fond blanc */
        .empty-state {
            text-align: center;
            padding: 80px 32px;
            border: 1px solid var(--border);
            border-radius: 16px;
            background: #0d0d18;
        }
        .empty-state .empty-icon {
            width: 56px; height: 56px;
            border-radius: 14px;
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.07);
            display: inline-flex; align-items: center; justify-content: center;
            font-size: 22px; color: #35355a;
            margin-bottom: 20px;
        }
        .empty-state h3 { font-size: 17px; font-weight: 700; color: #c0c0d8; margin-bottom: 8px; }
        .empty-state p { color: #45455e; font-size: 13.5px; max-width: 320px; margin: 0 auto 24px; }

        a, button { transition: color var(--t), background var(--t), border-color var(--t), box-shadow var(--t), transform var(--t); }

        @media (max-width: 768px) {
            .page-content { padding: 24px 14px 60px; }
            .navbar { padding: 0 14px; }
        }
    </style>
    @yield('styles')
</head>
<body>
<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container-fluid" style="max-width:1260px;margin:0 auto;">
        <a class="navbar-brand" href="{{ route('accueil') }}">
            <svg width="20" height="20" viewBox="0 0 22 22" fill="none" aria-label="Logo" style="flex-shrink:0;">
                <rect x="1" y="4" width="20" height="14" rx="3" stroke="#e50914" stroke-width="1.8"/>
                <circle cx="11" cy="11" r="3.2" stroke="#e50914" stroke-width="1.6"/>
                <line x1="1" y1="7.5" x2="4" y2="7.5" stroke="#e50914" stroke-width="1.6"/>
                <line x1="1" y1="14.5" x2="4" y2="14.5" stroke="#e50914" stroke-width="1.6"/>
                <line x1="18" y1="7.5" x2="21" y2="7.5" stroke="#e50914" stroke-width="1.6"/>
                <line x1="18" y1="14.5" x2="21" y2="14.5" stroke="#e50914" stroke-width="1.6"/>
            </svg>
            Mes Films <span class="brand-accent">Préférés</span>
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#nav" style="color:#555;">
            <i class="bi bi-list" style="font-size:22px;"></i>
        </button>
        <div class="collapse navbar-collapse" id="nav">
            <div class="nav-tabs-bar me-auto">
                <a class="nav-tab-item {{ request()->routeIs('rechercherFilm') ? 'active' : '' }}" href="{{ route('rechercherFilm') }}">
                    <i class="bi bi-compass"></i> Découvrir
                </a>
                <a class="nav-tab-item {{ request()->routeIs('favoris') ? 'active' : '' }}" href="{{ route('favoris') }}">
                    <i class="bi bi-bookmark"></i> Ma liste
                </a>
                <a class="nav-tab-item {{ request()->routeIs('amis.index') ? 'active' : '' }}" href="{{ route('amis.index') }}">
                    <i class="bi bi-people"></i> Amis
                </a>
                <a class="nav-tab-item {{ request()->routeIs('partages.index') ? 'active' : '' }}" href="{{ route('partages.index') }}">
                    <i class="bi bi-share"></i> Partages
                </a>
            </div>
            <div class="nav-tabs-bar gap-2">
                @guest
                    <a class="nav-tab-item btn-nav-login" href="{{ route('login') }}">Connexion</a>
                    <a class="nav-link btn-nav-register" href="{{ route('creerCompte') }}">S'inscrire</a>
                @else
                    <a class="nav-tab-item {{ request()->routeIs('profil.show') ? 'active' : '' }}" href="{{ route('profil.show') }}">
                        <i class="bi bi-person-circle"></i> {{ auth()->user()->username ?? auth()->user()->firstname }}
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="d-inline m-0">
                        @csrf
                        <button class="nav-tab-item" type="submit" title="Déconnexion" style="background:none;border:none;cursor:pointer;">
                            <i class="bi bi-box-arrow-right"></i>
                        </button>
                    </form>
                @endguest
            </div>
        </div>
    </div>
</nav>
<main>
    @if(session('success'))
    <div style="max-width:1260px;margin:0 auto;padding:16px 24px 0;">
        <div class="alert-success-dark"><i class="bi bi-check-circle-fill"></i> {{ session('success') }}</div>
    </div>
    @endif
    @if(session('error'))
    <div style="max-width:1260px;margin:0 auto;padding:16px 24px 0;">
        <div class="alert-error-dark"><i class="bi bi-exclamation-circle-fill"></i> {{ session('error') }}</div>
    </div>
    @endif
    @yield('content')
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>
