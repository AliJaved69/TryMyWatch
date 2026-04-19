<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Management Portal - TryMyWatch</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>

        /* Glassmorphic Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--glass);
            backdrop-filter: blur(15px);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            padding: 2rem 1.5rem;
            border-right: 1px solid rgba(241, 229, 172, 0.1);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            z-index: 1050;
        }

        .main-content {
            margin-left: var(--sidebar-width);
            padding: 2.5rem;
            width: calc(100% - var(--sidebar-width));
            transition: all 0.4s ease;
        }

        .nav-link {
            color: var(--text);
            padding: 1rem 1.2rem;
            border-radius: 12px;
            margin-bottom: 0.6rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            font-weight: 500;
            text-decoration: none;
        }

        .nav-link:hover {
            background: rgba(241, 229, 172, 0.05);
            color: var(--accent);
            transform: translateX(5px);
        }

        .nav-link.active {
            background: linear-gradient(135deg, var(--accent), var(--accent-light)) !important;
            color: #0b0c10 !important;
            box-shadow: 0 8px 20px rgba(241, 229, 172, 0.2);
        }

        .nav-link i {
            width: 28px;
            font-size: 1.1rem;
        }

        /* Glass Cards */
        .card {
            background: var(--glass);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(241, 229, 172, 0.05);
            border-radius: 20px;
            color: var(--text-bright);
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            margin-bottom: 2rem;
        }

        .card-header {
            background: rgba(0,0,0,0.2);
            border-bottom: 1px solid rgba(241, 229, 172, 0.05);
            padding: 1.5rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.9rem;
            color: var(--accent);
        }

        .table {
            color: var(--text);
            --bs-table-bg: transparent;
            --bs-table-border-color: rgba(255,255,255,0.05);
            vertical-align: middle;
        }

        .table thead th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 1px;
            color: var(--accent);
            border-bottom: 2px solid rgba(241, 229, 172, 0.1);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--accent), var(--accent-light));
            border: none;
            color: #0b0c10;
            font-weight: 700;
            border-radius: 10px;
            padding: 0.6rem 1.5rem;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(241, 229, 172, 0.3);
            color: #0b0c10;
        }

        .form-control, .form-select {
            background: rgba(11, 12, 16, 0.8);
            border: 1px solid rgba(197, 198, 199, 0.1);
            color: var(--text-bright);
            border-radius: 10px;
            padding: 0.8rem 1rem;
        }

        .form-control:focus {
            background: rgba(11, 12, 16, 0.9);
            border-color: var(--accent);
            box-shadow: 0 0 10px rgba(241, 229, 172, 0.1);
            color: var(--text-bright);
        }

        /* Mobile Sidebar */
        .sidebar-toggle {
            display: none;
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1100;
            background: var(--accent);
            color: #000;
            border: none;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            box-shadow: 0 5px 15px rgba(0,0,0,0.5);
        }

        @media (max-width: 992px) {
            .sidebar {
                left: -100%;
            }
            .sidebar.active {
                left: 0;
            }
            .main-content {
                margin-left: 0;
                width: 100%;
                padding: 1.5rem;
            }
            .sidebar-toggle {
                display: block;
            }
        }

        .gradient-text {
            background: linear-gradient(135deg, var(--accent), var(--accent-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body>

    <button class="sidebar-toggle" id="menuBtn">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Sidebar -->
    <div class="sidebar d-flex flex-column" id="sidebar">
        <div class="mb-5 px-2">
            <h4 class="m-0 fw-800 text-bright">
                <span class="gradient-text">TryMyWatch</span><br>
                <small class="fs-6 opacity-50 fw-normal">Management Portal</small>
            </h4>
        </div>
        
        <nav class="nav flex-column mb-auto">
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-chart-line me-3"></i> Dashboard
            </a>
            <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                <i class="fas fa-watch me-3"></i> Inventory
            </a>
            <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <i class="fas fa-layer-group me-3"></i> Categories
            </a>
            <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                <i class="fas fa-shopping-bag me-3"></i> Orders
            </a>
            <a href="{{ route('admin.contact.index') }}" class="nav-link {{ request()->routeIs('admin.contact.*') ? 'active' : '' }}">
                <i class="fas fa-concierge-bell me-3"></i> Messages
            </a>
        </nav>
        
        <div class="mt-auto pt-4 border-top border-silver-dim">
            <a href="{{ url('/') }}" class="nav-link mb-2">
                <i class="fas fa-external-link-alt me-3"></i> Launch Store
            </a>
            <form action="{{ route('logout') }}" method="POST" class="d-grid">
                @csrf
                <button type="submit" class="nav-link border-0 w-100 text-danger" style="background:transparent;">
                    <i class="fas fa-power-off me-3"></i> Terminate Session
                </button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container-fluid">
            <!-- Luxury Header for each page -->
            <div class="d-flex justify-content-between align-items-center mb-5 animate-fade-in">
                <div>
                    <h2 class="text-bright fw-bold mb-1">@yield('page_title', 'Dashboard')</h2>
                    <p class="text-muted small">System Operations & Oversight</p>
                </div>
                <div class="glass-card px-3 py-2 d-none d-md-block">
                    <span class="text-accent small"><i class="fas fa-shield-alt me-2"></i>Secure Admin Node</span>
                </div>
            </div>

            @if(session('success'))
                <div class="alert glass-card border-success border-opacity-25 text-success py-3 px-4 mb-4" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert glass-card border-danger border-opacity-25 text-danger py-3 px-4 mb-4" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
                </div>
            @endif
    
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('menuBtn').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
            this.querySelector('i').classList.toggle('fa-bars');
            this.querySelector('i').classList.toggle('fa-times');
        });
    </script>
</body>
</html>
