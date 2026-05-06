<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name'))</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        
        :root {
            --apple-gray-1: #f5f5f7;
            --apple-gray-2: #e8e8ed;
            --apple-gray-3: #d2d2d7;
            --apple-gray-4: #86868b;
            --apple-gray-5: #1d1d1f;
            --apple-blue: #0071e3;
            --apple-blue-hover: #0077ed;
            --color-primary: #6366f1;
            --color-primary-light: #818cf8;
            --color-accent: #ec4899;
            --color-accent-light: #f472b6;
            --color-success: #10b981;
            --color-warning: #f59e0b;
        }
        
        body {
            padding-top: 60px;
            background: linear-gradient(180deg, #fafafa 0%, #f5f5f7 100%);
            min-height: 100vh;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            font-size: 17px;
            line-height: 1.47059;
            color: var(--apple-gray-5);
            letter-spacing: -0.022em;
        }
        
        .navbar {
            background-color: rgba(251, 251, 253, 0.8);
            backdrop-filter: saturate(180%) blur(20px);
            -webkit-backdrop-filter: saturate(180%) blur(20px);
            border-bottom: 0.5px solid rgba(0, 0, 0, 0.1);
            padding: 0;
            height: 60px;
        }
        
        @media (max-width: 991px) {
            .navbar {
                background-color: #ffffff;
                backdrop-filter: none;
                -webkit-backdrop-filter: none;
            }
        }
        
        .navbar .container-fluid {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 22px;
        }
        
        .navbar-brand {
            font-weight: 600;
            font-size: 19px;
            background: linear-gradient(135deg, var(--color-primary), var(--color-accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.01em;
            padding: 0;
            margin-right: 40px;
            transition: opacity 0.2s ease;
        }
        
        .navbar-brand:hover {
            opacity: 0.8;
        }
        
        .navbar-nav {
            gap: 8px;
        }
        
        .nav-link {
            color: var(--apple-gray-5);
            font-weight: 400;
            font-size: 17px;
            padding: 8px 12px;
            border-radius: 8px;
            transition: all 0.2s ease;
            letter-spacing: -0.022em;
        }
        
        .nav-link:hover {
            color: var(--color-primary);
        }
        
        .nav-link i {
            font-size: 16px;
            opacity: 0.7;
            transition: all 0.2s ease;
        }
        
        .nav-link:hover i {
            opacity: 1;
        }
        
        .nav-item:nth-child(1) .nav-link i { color: var(--color-primary); }
        .nav-item:nth-child(2) .nav-link i { color: #3b82f6; }
        .nav-item:nth-child(3) .nav-link i { color: var(--color-accent); }
        .nav-item:nth-child(4) .nav-link i { color: var(--color-success); }
        .nav-item:nth-child(5) .nav-link i { color: #8b5cf6; }
        .nav-item:nth-child(6) .nav-link i { color: var(--color-warning); }
        
        .nav-item:nth-child(1) .nav-link:hover { background-color: rgba(99, 102, 241, 0.1); }
        .nav-item:nth-child(2) .nav-link:hover { background-color: rgba(59, 130, 246, 0.1); color: #3b82f6; }
        .nav-item:nth-child(3) .nav-link:hover { background-color: rgba(236, 72, 153, 0.1); color: var(--color-accent); }
        .nav-item:nth-child(4) .nav-link:hover { background-color: rgba(16, 185, 129, 0.1); color: var(--color-success); }
        .nav-item:nth-child(5) .nav-link:hover { background-color: rgba(139, 92, 246, 0.1); color: #8b5cf6; }
        .nav-item:nth-child(6) .nav-link:hover { background-color: rgba(245, 158, 11, 0.1); color: var(--color-warning); }
        
        .container {
            max-width: 980px;
            margin: 0 auto;
            padding: 40px 22px;
            background-color: transparent;
            position: relative;
        }
        
        .container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(99, 102, 241, 0.2), transparent);
        }
        
        h1 {
            font-size: 48px;
            font-weight: 600;
            line-height: 1.08349;
            letter-spacing: -0.003em;
            background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-accent) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 24px;
        }
        
        h2 {
            font-size: 32px;
            font-weight: 600;
            line-height: 1.125;
            letter-spacing: 0.004em;
            color: var(--apple-gray-5);
            margin-bottom: 16px;
        }
        
        p {
            font-size: 17px;
            line-height: 1.47059;
            letter-spacing: -0.022em;
            color: var(--apple-gray-4);
        }
        
        .form-control {
            background-color: #ffffff;
            border: 1px solid var(--apple-gray-2);
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 17px;
            font-weight: 400;
            color: var(--apple-gray-5);
            transition: all 0.2s ease;
            height: auto;
        }
        
        .form-control:focus {
            background-color: #ffffff;
            border-color: var(--color-primary);
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
            outline: none;
        }
        
        .form-control::placeholder {
            color: var(--apple-gray-3);
        }
        
        label {
            font-weight: 500;
            font-size: 15px;
            color: var(--apple-gray-5);
            margin-bottom: 8px;
            display: block;
            letter-spacing: -0.016em;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-light) 100%);
            border: none;
            border-radius: 12px;
            padding: 12px 24px;
            font-size: 17px;
            font-weight: 500;
            color: #ffffff;
            transition: all 0.2s ease;
            letter-spacing: -0.022em;
            box-shadow: 0 2px 8px rgba(99, 102, 241, 0.25);
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, var(--color-primary-light) 0%, var(--color-primary) 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(99, 102, 241, 0.4);
        }
        
        .btn-primary:active {
            transform: translateY(0);
        }
        
        .btn-link {
            color: var(--apple-gray-5);
            text-decoration: none;
            padding: 0;
            font-weight: 400;
        }
        
        .btn-link:hover {
            color: var(--apple-gray-5);
            background-color: var(--apple-gray-1);
        }
        
        .alert {
            border-radius: 12px;
            border: none;
            padding: 16px 20px;
            font-size: 15px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }
        
        .alert-success {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(16, 185, 129, 0.05) 100%);
            color: #059669;
            border-left: 3px solid var(--color-success);
        }
        
        .navbar-toggler {
            border: none;
            padding: 8px;
        }
        
        .navbar-toggler:focus {
            box-shadow: none;
        }
        
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%2833, 37, 41, 0.75%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }
        
        @media (max-width: 991px) {
            .navbar-collapse {
                background-color: #ffffff;
                margin-top: 12px;
                padding: 16px;
                border-radius: 12px;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
                border: 0.5px solid rgba(0, 0, 0, 0.08);
            }
            
            .navbar-collapse.show {
                background-color: #ffffff;
            }
            
            .navbar-nav {
                padding: 0;
            }
            
            .nav-link {
                padding: 12px 16px;
                margin: 4px 0;
            }
            
            h1 {
                font-size: 40px;
            }
        }
        
        @media (max-width: 767px) {
            .container {
                padding: 32px 16px;
            }
            
            h1 {
                font-size: 32px;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('accueil') }}">MES FILMS PRÉFÉRÉS</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav" aria-controls="nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="nav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('rechercherFilm') }}">
                            <i class="bi bi-search me-1"></i>Rechercher
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('favoris') }}">
                            <i class="bi bi-heart me-1"></i>Favoris
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('amis.index') }}">
                            <i class="bi bi-people me-1"></i>Amis
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('partages.index') }}">
                            <i class="bi bi-share me-1"></i>Partages
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('profil.show') }}">
                            <i class="bi bi-person-circle me-1"></i>Profil
                        </a>
                    </li>
                </ul>

                <ul class="navbar-nav">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="bi bi-box-arrow-in-right me-1"></i>Connexion
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('creerCompte') }}">
                                <i class="bi bi-person-plus me-1"></i>Créer un compte
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button class="btn btn-link nav-link" type="submit">
                                    <i class="bi bi-box-arrow-right me-1"></i>Déconnexion
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
            <div class="container">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
