<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Member Area')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --background: 0 0% 3.9%;
            --foreground: 0 0% 98%;
            --card: 0 0% 3.9%;
            --card-foreground: 0 0% 98%;
            --popover: 0 0% 3.9%;
            --popover-foreground: 0 0% 98%;
            --primary: 0 0% 98%;
            --primary-foreground: 0 0% 9%;
            --secondary: 0 0% 14.9%;
            --secondary-foreground: 0 0% 98%;
            --muted: 0 0% 14.9%;
            --muted-foreground: 0 0% 63.9%;
            --accent: 0 0% 14.9%;
            --accent-foreground: 0 0% 98%;
            --destructive: 0 84.2% 60.2%;
            --destructive-foreground: 0 0% 98%;
            --border: 0 0% 14.9%;
            --input: 0 0% 14.9%;
            --ring: 0 0% 83.1%;
            --radius: 0.5rem;
        }

        * {
            border-color: hsl(var(--border));
        }

        body {
            background-color: hsl(var(--background));
            color: hsl(var(--foreground));
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            font-feature-settings: 'cv02', 'cv03', 'cv04', 'cv11';
            line-height: 1.5;
        }

        .sidebar {
            min-height: 100vh;
            background-color: hsl(var(--card));
            border-right: 1px solid hsl(var(--border));
            backdrop-filter: blur(8px);
        }

        .sidebar-header {
            padding: 1.5rem 1rem;
            border-bottom: 1px solid hsl(var(--border));
        }

        .sidebar-brand {
            font-size: 1.125rem;
            font-weight: 700;
            color: hsl(var(--foreground));
            letter-spacing: -0.025em;
        }

        .sidebar-user {
            font-size: 0.875rem;
            color: hsl(var(--muted-foreground));
            font-weight: 500;
        }

        .nav-section {
            padding: 1rem 0;
        }

        .nav-section + .nav-section {
            border-top: 1px solid hsl(var(--border));
        }

        .sidebar .nav-link {
            color: hsl(var(--muted-foreground));
            padding: 0.75rem 1rem;
            margin: 0.125rem 0.5rem;
            border-radius: var(--radius);
            font-weight: 500;
            font-size: 0.875rem;
            transition: all 0.15s ease-in-out;
            border: none;
            background: transparent;
            display: flex;
            align-items: center;
            text-decoration: none;
        }

        .sidebar .nav-link:hover {
            color: hsl(var(--foreground));
            background-color: hsl(var(--accent));
        }

        .sidebar .nav-link.active {
            color: hsl(var(--primary-foreground));
            background-color: hsl(var(--primary));
            font-weight: 600;
        }

        .sidebar .nav-link i {
            width: 1.25rem;
            text-align: center;
            margin-right: 0.75rem;
            font-size: 1rem;
        }

        .main-content {
            background-color: hsl(var(--background));
            min-height: 100vh;
        }

        .content-header {
            padding: 1.5rem 0;
            border-bottom: 1px solid hsl(var(--border));
            margin-bottom: 2rem;
        }

        .page-title {
            font-size: 1.875rem;
            font-weight: 700;
            color: hsl(var(--foreground));
            letter-spacing: -0.025em;
            margin: 0;
        }

        /* Alert Components - shadcn/ui style */
        .alert {
            border-radius: var(--radius);
            border: 1px solid hsl(var(--border));
            padding: 1rem;
            margin-bottom: 1rem;
            position: relative;
            backdrop-filter: blur(8px);
        }

        .alert-success {
            background-color: hsla(142, 76%, 36%, 0.1);
            border-color: hsl(142, 76%, 36%);
            color: hsl(142, 76%, 46%);
        }

        .alert-danger {
            background-color: hsla(var(--destructive), 0.1);
            border-color: hsl(var(--destructive));
            color: hsl(var(--destructive));
        }

        .alert-info {
            background-color: hsla(221, 83%, 53%, 0.1);
            border-color: hsl(221, 83%, 53%);
            color: hsl(221, 83%, 63%);
        }

        .btn-close {
            background: none;
            border: none;
            color: inherit;
            opacity: 0.7;
            font-size: 1.25rem;
            position: absolute;
            top: 0.75rem;
            right: 0.75rem;
        }

        .btn-close:hover {
            opacity: 1;
        }

        /* Balance Card - Modern glassmorphism */
        .balance-card {
            background: linear-gradient(135deg, 
                hsla(220, 30%, 18%, 0.8) 0%, 
                hsla(220, 30%, 12%, 0.8) 100%);
            border: 1px solid hsl(var(--border));
            border-radius: calc(var(--radius) * 2);
            backdrop-filter: blur(16px);
            color: hsl(var(--foreground));
            box-shadow: 0 8px 32px hsla(0, 0%, 0%, 0.3);
        }

        /* Tier Cards */
        .tier-card {
            background-color: hsl(var(--card));
            border: 1px solid hsl(var(--border));
            border-radius: var(--radius);
            transition: all 0.2s ease-in-out;
            backdrop-filter: blur(8px);
        }

        .tier-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px hsla(0, 0%, 0%, 0.15);
            border-color: hsl(var(--ring));
        }

        .tier-1 { 
            border-color: hsl(142, 76%, 36%);
        }
        
        .tier-2 { 
            border-color: hsl(45, 93%, 47%);
        }
        
        .tier-3 { 
            border-color: hsl(var(--destructive));
        }

        /* Logout button special styling */
        .logout-btn {
            color: hsl(var(--destructive));
            background: none;
            border: none;
            width: 100%;
            text-align: left;
            padding: 0.75rem 1rem;
            margin: 0.125rem 0.5rem;
            border-radius: var(--radius);
            font-weight: 500;
            font-size: 0.875rem;
            transition: all 0.15s ease-in-out;
            display: flex;
            align-items: center;
        }

        .logout-btn:hover {
            background-color: hsla(var(--destructive), 0.1);
            color: hsl(var(--destructive));
        }

        .card {
            color: hsl(var(--primary));
            background: linear-gradient(135deg, 
                hsla(220, 30%, 18%, 0.8) 0%, 
                hsla(220, 30%, 12%, 0.8) 100%);
        }

        /* Scrollbar styling */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: hsl(var(--background));
        }

        ::-webkit-scrollbar-thumb {
            background: hsl(var(--border));
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: hsl(var(--muted-foreground));
        }

        /* Mobile responsiveness */
        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                top: 0;
                left: -100%;
                width: 280px;
                z-index: 1050;
                transition: left 0.3s ease-in-out;
            }

            .sidebar.show {
                left: 0;
            }
        }

        /* Focus states for accessibility */
        .nav-link:focus-visible,
        .logout-btn:focus-visible {
            outline: 2px solid hsl(var(--ring));
            outline-offset: 2px;
        }
    </style>
</head>
<body>
    <div class="container-fluid p-0">
        <div class="row g-0">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar">
                <div class="position-sticky top-0">
                    <div class="sidebar-header">
                        <div class="sidebar-brand">Member Area</div>
                        <div class="sidebar-user">{{ auth()->user()->name }}</div>
                    </div>
                    
                    <div class="nav-section">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                                    <i class="fas fa-tachometer-alt"></i>
                                    Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('deposit.*') ? 'active' : '' }}" href="{{ route('deposit.index') }}">
                                    <i class="fas fa-credit-card"></i>
                                    Deposit
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">
                                    <i class="fas fa-shopping-bag"></i>
                                    Produk
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}" href="{{ route('orders.index') }}">
                                    <i class="fas fa-receipt"></i>
                                    Pesanan
                                </a>
                            </li>
                        </ul>
                    </div>
                    
                    @if(auth()->user()->isAdmin() || auth()->user()->isSupervisor())
                    <div class="nav-section">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <i class="fas fa-users"></i>
                                    Kelola User
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <i class="fas fa-box"></i>
                                    Kelola Produk
                                </a>
                            </li>
                        </ul>
                    </div>
                    @endif
                    
                    <div class="nav-section">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="logout-btn">
                                        <i class="fas fa-sign-out-alt"></i>
                                        Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 main-content">
                <div class="content-header">
                    <h1 class="page-title">@yield('page-title', 'Dashboard')</h1>
                </div>

                @if(session('success'))
                    <div class="alert alert-success" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                @endif

                @if(session('info'))
                    <div class="alert alert-info" role="alert">
                        <i class="fas fa-info-circle me-2"></i>
                        {{ session('info') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                @endif

                <div class="px-3 px-md-4">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>