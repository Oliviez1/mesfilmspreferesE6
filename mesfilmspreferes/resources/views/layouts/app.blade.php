<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name')) — CinéVault</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg:         #0a0a0f;
            --bg-card:    #12121a;
            --bg-card-2:  #1a1a26;
            --border:     rgba(255,255,255,0.08);
            --text:       #e8e8f0;
            --text-muted: #8888a0;
            --red:        #e50914;
            --red-hover:  #f40d1a;
            --gold:       #f5c518;
            --radius:     12px;
            --nav-h:      64px;
        }

        html { scroll-behavior: smooth; }

        body {
            padding-top: var(--nav-h);
            background: var(--bg);
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
            font-size: 15px;
            line-height: 1.6;
            color: var(--text);
            -webkit-font-smoothing: antialiased;
        }

        /* ── NAVBAR ── */
        .navbar {
            height: var(--nav-h);
            background: linear-gradient(180deg, rgba(10,10,15,0.98) 0%, rgba(10,10,15,0.85) 100%);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--border);
            padding: 0 24px;
        }

        .navbar-brand {
            font-size: 20px;
            font-weight: 800;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: var(--red) !important;
            text-decoration: none;
            margin-right: 32px;
        }

        .nav-link {
            color: var(--text-muted) !important;
            font-size: 14px;
            font-weight: 500;
            padding: 8px 14px !important;
            border-radius: 8px;
            transition: all 0.18s ease;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .nav-link:hover, .nav-link.active {
            color: var(--text) !important;
            background: rgba(255,255,255,0.07);
        }

        .nav-link i { font-size: 15px; }

        .btn-nav-login {
            background: var(--red);
            color: #fff !important;
            border-radius: 8px;
            padding: 7px 18px !important;
            font-weight: 600;
            font-size: 14px;
            transition: background 0.18s;
        }
        .btn-nav-login:hover { background: var(--red-hover) !important; color: #fff !important; }

        /* ── CONTENT WRAPPER ── */
        .page-content {
            max-width: 1280px;
            margin: 0 auto;
            padding: 40px 24px 80px;
        }

        /* ── CARDS ── */
        .movie-card {
            background: var(--bg-card);
            border-radius: var(--radius);
            overflow: hidden;
            border: 1px solid var(--border);
            transition: transform 0.22s ease, box-shadow 0.22s ease, border-color 0.22s ease;
            cursor: pointer;
            position: relative;
        }

        .movie-card:hover {
            transform: translateY(-6px) scale(1.02);
            box-shadow: 0 20px 50px rgba(0,0,0,0.6);
            border-color: rgba(255,255,255,0.18);
        }

        .movie-card img {
            width: 100%;
            aspect-ratio: 2/3;
            object-fit: cover;
            display: block;
        }

        .movie-card-body {
            padding: 14px 16px 16px;
        }

        .movie-card-title {
            font-size: 14px;
            font-weight: 600;
            color: var(--text);
            margin-bottom: 4px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .movie-card-year {
            font-size: 12px;
            color: var(--text-muted);
        }

        .movie-card-rating {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 12px;
            font-weight: 600;
            color: var(--gold);
        }

        /* ── POSTER PLACEHOLDER ── */
        .poster-placeholder {
            width: 100%;
            aspect-ratio: 2/3;
            background: var(--bg-card-2);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .poster-placeholder i { font-size: 48px; color: rgba(255,255,255,0.15); }

        /* ── BUTTONS ── */
        .btn-cine {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--red);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 11px 22px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.18s, transform 0.12s;
            text-decoration: none;
        }
        .btn-cine:hover { background: var(--red-hover); color: #fff; transform: translateY(-1px); }
        .btn-cine:active { transform: none; }

        .btn-cine-outline {
            background: transparent;
            border: 1px solid rgba(255,255,255,0.25);
            color: var(--text);
        }
        .btn-cine-outline:hover { background: rgba(255,255,255,0.08); color: var(--text); border-color: rgba(255,255,255,0.45); }

        .btn-cine-gold {
            background: var(--gold);
            color: #000;
        }
        .btn-cine-gold:hover { background: #ffd000; color: #000; }

        /* ── FORMS ── */
        .cine-input {
            background: var(--bg-card) !important;
            border: 1px solid var(--border) !important;
            border-radius: 10px !important;
            color: var(--text) !important;
            padding: 13px 18px !important;
            font-size: 15px !important;
            transition: border-color 0.18s, box-shadow 0.18s;
            width: 100%;
        }
        .cine-input:focus {
            border-color: var(--red) !important;
            box-shadow: 0 0 0 3px rgba(229,9,20,0.15) !important;
            outline: none !important;
            background: var(--bg-card-2) !important;
        }
        .cine-input::placeholder { color: var(--text-muted) !important; }

        /* ── STAR RATING ── */
        .star-rating { display: flex; gap: 4px; }
        .star-rating input { display: none; }
        .star-rating label {
            font-size: 28px;
            color: rgba(255,255,255,0.15);
            cursor: pointer;
            transition: color 0.12s;
            line-height: 1;
        }
        .star-rating label:hover,
        .star-rating label:hover ~ label,
        .star-rating input:checked ~ label { color: var(--gold); }
        .star-rating:hover label { color: var(--gold); }
        .star-rating label:hover ~ label { color: rgba(255,255,255,0.15); }

        /* ── SECTION TITLE ── */
        .section-title {
            font-size: 22px;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .section-title::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
            margin-left: 8px;
        }

        /* ── ALERTS ── */
        .alert-cine-success {
            background: rgba(16,185,129,0.12);
            border: 1px solid rgba(16,185,129,0.3);
            color: #34d399;
            border-radius: var(--radius);
            padding: 14px 18px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* ── BADGE ── */
        .badge-genre {
            display: inline-block;
            background: rgba(255,255,255,0.08);
            border: 1px solid var(--border);
            color: var(--text-muted);
            border-radius: 999px;
            padding: 3px 12px;
            font-size: 12px;
            font-weight: 500;
        }

        /* ── SCROLLBAR ── */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: var(--bg); }
        ::-webkit-scrollbar-thumb { background: #333; border-radius: 3px; }

        @media (max-width: 768px) {
            .page-content { padding: 24px 16px 60px; }
            .navbar { padding: 0 16px; }
        }
    </style>
    @yield('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid" style="max-width:1280px;margin:0 auto;">
            <a class="navbar-brand" href="{{ route('accueil') }}">
                <i class="bi bi-film me-1"></i>CinéVault
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#nav" style="color:var(--text);">
                <i class="bi bi-list" style="font-size:24px;"></i>
            </button>

            <div class="collapse navbar-collapse" id="nav">
                <ul class="navbar-nav me-auto gap-1">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('rechercherFilm') }}">
                            <i class="bi bi-search"></i> Découvrir
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('favoris') }}">
                            <i class="bi bi-heart"></i> Ma liste
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('amis.index') }}">
                            <i class="bi bi-people"></i> Amis
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('partages.index') }}">
                            <i class="bi bi-share"></i> Partages
                        </a>
                    </li>
                </ul>

                <ul class="navbar-nav gap-1 align-items-center">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Connexion</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn-nav-login" href="{{ route('creerCompte') }}">S'inscrire</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('profil.show') }}">
                                <i class="bi bi-person-circle"></i> Mon profil
                            </a>
                        </li>
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}" class="d-inline m-0">
                                @csrf
                                <button class="nav-link border-0" type="submit" style="background:none;">
                                    <i class="bi bi-box-arrow-right"></i> Déconnexion
                                </button>
                            </form>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main>
        @if(session('success'))
            <div class="page-content" style="padding-bottom:0;padding-top:20px;">
                <div class="alert-cine-success">
                    <i class="bi bi-check-circle-fill"></i>
                    {{ session('success') }}
                </div>
            </div>
        @endif
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
