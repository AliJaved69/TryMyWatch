<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - TryMyWatch</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    
    <style>
        :root {
            --primary: #0f0f0f;
            --secondary: #1a1a1a;
            --accent: #c9a96e;
            --accent-light: #e6d2a9;
            --text: #f5f5f5;
            --text-secondary: #a0a0a0;
            --sidebar-width: 250px;
        }

        body {
            background-color: var(--primary);
            color: var(--text);
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
        }

        .sidebar {
            width: var(--sidebar-width);
            background-color: var(--secondary);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            padding: 1rem;
            border-right: 1px solid #333;
        }

        .main-content {
            margin-left: var(--sidebar-width);
            padding: 2rem;
            width: calc(100% - var(--sidebar-width));
        }

        .nav {
            display: flex;
            flex-direction: column;
            width: 100%;
        }

        .nav-link {
            color: var(--text-secondary);
            padding: 0.8rem 1rem;
            border-radius: 8px;
            margin-bottom: 0.5rem;
            transition: all 0.3s ease;
            text-decoration: none;
            display: block;
        }

        .nav-link:hover {
            background-color: rgba(201, 169, 110, 0.1);
            color: var(--accent);
        }

        .nav-link.active {
            background-color: var(--accent) !important;
            color: #000 !important;
            font-weight: 600;
        }

        .nav-link i {
            width: 24px;
            margin-right: 10px;
        }
        
        /* Logout Button specific styles to match nav-link */
        button.nav-link {
            background: none;
            border: none;
            text-align: left;
            width: 100%;
            cursor: pointer;
        }

        .card {
            background-color: var(--secondary);
            border: 1px solid #333;
            color: var(--text);
            margin-bottom: 1.5rem;
        }

        .card-header {
            border-bottom: 1px solid #333;
            background-color: rgba(0,0,0,0.2);
            padding: 1rem;
            font-weight: 600;
        }
        
        .card-body {
            padding: 1.5rem;
        }

        .table {
            color: var(--text);
            --bs-table-bg: transparent;
            --bs-table-color: var(--text);
            --bs-table-border-color: #333;
        }

        .table tbody tr:hover {
            color: var(--text);
            background-color: rgba(255,255,255,0.05);
        }
        
        .form-control, .form-select {
            background-color: #2a2a2a;
            border: 1px solid #444;
            color: var(--text);
        }
        
        .form-control:focus, .form-select:focus {
            background-color: #2a2a2a;
            border-color: var(--accent);
            color: var(--text);
            box-shadow: 0 0 0 0.25rem rgba(201, 169, 110, 0.25);
        }
        
        .btn-primary {
            background-color: var(--accent);
            border-color: var(--accent);
            color: #000;
            font-weight: 600;
        }
        
        .btn-primary:hover {
            background-color: var(--accent-light);
            border-color: var(--accent-light);
            color: #000;
        }
        
        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }
        
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }
        
        .badge {
            padding: 0.5em 0.8em;
        }
        
        .text-accent {
            color: var(--accent);
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar d-flex flex-column">
        <div class="mb-4 px-3 pb-3 border-bottom border-secondary">
            <h4 class="m-0 fw-bold"><span class="text-accent">TryMyWatch</span> Admin</h4>
        </div>
        
        <nav class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-line"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                    <i class="fas fa-box"></i> Products
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <i class="fas fa-tags"></i> Categories
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                    <i class="fas fa-shopping-cart"></i> Orders
                </a>
            </li>
             <li class="nav-item">
                <a href="{{ route('admin.contact.index') }}" class="nav-link {{ request()->routeIs('admin.contact.*') ? 'active' : '' }}">
                    <i class="fas fa-envelope"></i> Messages
                </a>
            </li>
        </nav>
        
        <div class="mt-auto border-top border-secondary pt-3">
            <a href="{{ url('/') }}" class="nav-link">
                <i class="fas fa-home"></i> Back to Shop
            </a>
             <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="nav-link text-danger">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container-fluid">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
    
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
