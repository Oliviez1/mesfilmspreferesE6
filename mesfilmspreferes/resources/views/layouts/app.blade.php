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
            --text-muted: #7070888;
            --text-dim:   #505068;
            --red:        #e50914;
            --red-hover:  #ff1420;
            --gold:       #f5c518;
            --radius:     10px;
            --nav-h:      60px;
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
            background: rgba(8,8,16,0.92);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
            padding: 0 28px;
        }
        .navbar-brand {
            font-size: 17px;
            font-weight: 800;
            letter-spacing: -0.01em;
            color: #fff !important;
            text-decoration: none;
            margin-right: 36px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .navbar-brand span { color: var(--red); }
        .nav-link {
            color: #6a6a80 !important;
            font-size: 13.5px;
            font-weight: 500;
            padding: 6px 13px !important;
            border-radius: 7px;
            transition: all 0.15s;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .nav-link:hover, .nav-link.active { color: #fff !important; background: rgba(255,255,255,0.06); }
        .nav-link i { font-size: 14px; }
        .btn-nav-register {
            background: var(--red) !important;
            color: #fff !important;
            border-radius: 7px;
            padding: 6px 16px !important;
            font-weight: 600;
            font-size: 13.5px;
        }
        .btn-nav-register:hover { background: var(--red-hover) !important; }

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
            transition: transform 0.2s, box-shadow 0.2s, border-color 0.2s;
            cursor: pointer;
            position: relative;
        }
        .movie-card:hover {
            transform: translateY(-5px) scale(1.015);
            box-shadow: 0 18px 48px rgba(0,0,0,0.65);
            border-color: rgba(255,255,255,0.16);
        }
        .movie-card img { width:100%; aspect-ratio:2/3; object-fit:cover; display:block; }
        .poster-placeholder {
            width:100%; aspect-ratio:2/3;
            background: var(--bg-card-2);
            display:flex; align-items:center; justify-content:center;
        }
        .poster-placeholder i { font-size:44px; color:rgba(255,255,255,0.12); }

        /* BUTTONS */
        .btn-cine {
            display: inline-flex; align-items: center; gap: 7px;
            background: var(--red); color: #fff; border: none;
            border-radius: 8px; padding: 10px 20px;
            font-size: 13.5px; font-weight: 600; cursor: pointer;
            transition: background 0.15s, transform 0.12s;
            text-decoration: none;
        }
        .btn-cine:hover { background: var(--red-hover); color: #fff; transform: translateY(-1px); }
        .btn-cine:active { transform: none; }
        .btn-cine-outline {
            background: transparent;
            border: 1px solid rgba(255,255,255,0.18);
            color: var(--text);
        }
        .btn-cine-outline:hover { background: rgba(255,255,255,0.07); color: var(--text); border-color: rgba(255,255,255,0.35); }
        .btn-cine-ghost {
            background: rgba(255,255,255,0.06);
            border: 1px solid var(--border);
            color: var(--text);
        }
        .btn-cine-ghost:hover { background: rgba(255,255,255,0.1); color: var(--text); }
        .btn-cine-gold { background: var(--gold); color: #000; }
        .btn-cine-gold:hover { background: #ffd000; color: #000; }
        .btn-cine-danger { background: rgba(229,9,20,0.12); border: 1px solid rgba(229,9,20,0.25); color: #ff6b6b; }
        .btn-cine-danger:hover { background: rgba(229,9,20,0.22); color: #ff6b6b; }

        /* INPUTS */
        .cine-input {
            background: var(--bg-card) !important;
            border: 1px solid var(--border-2) !important;
            border-radius: 9px !important;
            color: var(--text) !important;
            padding: 11px 16px !important;
            font-size: 14px !important;
            transition: border-color 0.15s, box-shadow 0.15s;
            width: 100%;
            outline: none;
        }
        .cine-input:focus {
            border-color: var(--red) !important;
            box-shadow: 0 0 0 3px rgba(229,9,20,0.12) !important;
            background: var(--bg-card-2) !important;
        }
        .cine-input::placeholder { color: #444458 !important; }
        textarea.cine-input { padding: 12px 16px !important; }

        /* SECTION TITLE */
        .section-title {
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 0.09em;
            text-transform: uppercase;
            color: #4a4a60;
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .section-title::after { content:''; flex:1; height:1px; background: var(--border); }

        /* BADGE */
        .badge-genre {
            display: inline-block;
            background: rgba(255,255,255,0.06);
            border: 1px solid var(--border);
            color: #8080a0;
            border-radius: 999px;
            padding: 3px 11px;
            font-size: 11.5px;
            font-weight: 500;
        }

        /* ALERTS */
        .alert-success-dark {
            background: rgba(16,185,129,0.09);
            border: 1px solid rgba(16,185,129,0.22);
            color: #34d399;
            border-radius: var(--radius);
            padding: 12px 16px;
            font-size: 13.5px;
            display: flex;
            align-items: center;
            gap: 9px;
        }
        .alert-error-dark {
            background: rgba(229,9,20,0.09);
            border: 1px solid rgba(229,9,20,0.22);
            color: #ff6b6b;
            border-radius: var(--radius);
            padding: 12px 16px;
            font-size: 13.5px;
            display: flex;
            align-items: center;
            gap: 9px;
        }

        /* SCROLLBAR */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #252535; border-radius: 3px; }

        /* EMPTY STATE */
        .empty-state {
            text-align: center;
            padding: 80px 32px;
            border: 1px solid var(--border);
            border-radius: 16px;
            background: var(--bg-card);
        }
        .empty-state .empty-icon {
            width: 56px; height: 56px;
            border-radius: 14px;
            background: rgba(255,255,255,0.05);
            border: 1px solid var(--border);
            display: inline-flex; align-items: center; justify-content: center;
            font-size: 24px; color: #3a3a50;
            margin-bottom: 20px;
        }
        .empty-state h3 { font-size: 18px; font-weight: 700; color: var(--text); margin-bottom: 8px; }
        .empty-state p { color: #5a5a74; font-size: 14px; max-width: 320px; margin: 0 auto 24px; }

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
            <i class="bi bi-film"></i>
            Mes Films <span>Préférés</span>
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#nav" style="color:#666;">
            <i class="bi bi-list" style="font-size:22px;"></i>
        </button>
        <div class="collapse navbar-collapse" id="nav">
            <ul class="navbar-nav me-auto gap-1">
                <li class="nav-item"><a class="nav-link" href="{{ route('rechercherFilm') }}"><i class="bi bi-search"></i> Découvrir</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('favoris') }}"><i class="bi bi-bookmark"></i> Ma liste</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('amis.index') }}"><i class="bi bi-people"></i> Amis</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('partages.index') }}"><i class="bi bi-share"></i> Partages</a></li>
            </ul>
            <ul class="navbar-nav gap-1 align-items-center">
                @guest
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Connexion</a></li>
                    <li class="nav-item"><a class="nav-link btn-nav-register" href="{{ route('creerCompte') }}">S'inscrire</a></li>
                @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('profil.show') }}"><i class="bi bi-person-circle"></i> {{ auth()->user()->username ?? auth()->user()->firstname }}</a></li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" class="d-inline m-0">
                            @csrf
                            <button class="nav-link border-0" type="submit" style="background:none;"><i class="bi bi-box-arrow-right"></i></button>
                        </form>
                    </li>
                @endguest
            </ul>
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
