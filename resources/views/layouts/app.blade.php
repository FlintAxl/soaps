<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soap Haven</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    

</head>
<body class="@auth @if(auth()->user()->role === 'admin') admin-logged-in @endif @endauth">
    @auth
        @if(auth()->user()->role === 'admin')
        <!-- Admin Sidebar -->
        <div class="sidebar">


            <div class="admin-header">
                <i class="fas fa-user-shield"></i> Admin Dashboard
            </div>
            <a href="{{ route('users.index') }}">
                <i class="fas fa-users"></i> User Management
            </a>
            <a href="{{ route('products.index') }}">
                <i class="fas fa-box"></i> Product Management
            </a>
            <a href="{{ route('admin.orders.index') }}">
                <i class="fas fa-shopping-bag"></i> Manage Orders
            </a>
            <a href="{{ route('products.public.index') }}">
                <i class="fas fa-store"></i> User Products View
            </a>
            @can('admin')
            <a href="{{ route('admin.reviews.index') }}">
                <i class="fas fa-star"></i> Review Management
            </a>
            @endcan
            <!-- New Charts & Reports Section -->
            <div class="admin-header mt-4">
                <i class="fas fa-chart-line"></i> Charts & Reports
            </div>
            <!-- New Charts & Reports Section -->
            <a href="{{ route('admin.reports.sales') }}">
                <i class="fas fa-chart-bar"></i> Sales Reports
            </a>
            <div class="admin-header mt-4">
                <i class="fas fa-user"></i> User Actions
            </div>
            <a href="{{ route('profile.show') }}">
                <i class="fas fa-user"></i> My Profile
            </a>   <a href="{{ route('cart.index') }}">
                <i class="fas fa-user"></i> My Cart
            </a>
            <a href="{{ route('orders.index') }}">
                <i class="fas fa-shopping-bag"></i> My Orders
            </a>
            <a class="text-danger" href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
        @endif
    @endauth

    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">Soap Haven</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @auth
                    <!-- Regular user navigation -->
                        @if(auth()->user()->role !== 'admin')

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('profile.show') }}">
                                <i class="fas fa-user"></i> My Profile
                            </a>
                        </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('orders.index') }}">
                                    <i class="fas fa-shopping-bag"></i> My Orders
                                </a>
                            </li>
                          <!-- CART TO -->
                          @auth
                          <li class="nav-item">
                              <a class="nav-link" href="{{ route('cart.index') }}">
                                  <i class="fas fa-shopping-cart"></i> Cart
                                  @php
                                      $cartCount = count((array) session('cart_'.Auth::id(), []));
                                  @endphp
                                  @if($cartCount > 0)
                                      <span class="badge bg-danger">{{ $cartCount }}</span>
                                  @endif
                              </a>
                          </li>
                      @else
                          <li class="nav-item">
                              <a class="nav-link" href="{{ route('login') }}">
                                  <i class="fas fa-shopping-cart"></i> Cart
                              </a>
                          </li>
                      @endauth
                            <li class="nav-item">
                                <a class="nav-link text-danger" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        @endif
                    @else


                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt"></i> Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('users.create') }}">
                                <i class="fas fa-user-plus"></i> Register
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <div class="main-content">
        <div class="container mt-4">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

    @stack('scripts')
</body>

<style>
        /* Profile photo styling */
        .profile-photo {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 50%;
        border: 3px solid #fff;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    /* Profile card styling */
    .profile-card {
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    /* Edit form styling */
    .profile-form .form-control {
        background-color: #f8f9fa;
    }

    :root {
        --primary-purple: #9370DB;
        --light-purple: #D8BFD8;
        --very-light-purple: #E6E6FA;
        --hover-purple: #B794F4;
        --text-purple: #4B0082;
        --danger-color: #FF6B81;
    }

    body {
        background-color: #FFFFFF;
        color: #333;
    }

    /* Navbar styling */
    .navbar {
        background-color: white !important;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    .navbar-brand {
        color: var(--primary-purple) !important;
        font-weight: bold;
    }

    .nav-link {
        color: #333 !important;
    }

    .nav-link:hover {
        color: var(--primary-purple) !important;
    }

    .nav-link.text-danger {
        color: var(--danger-color) !important;
    }

    /* Sidebar styling */
    .sidebar {
        height: 100%;
        width: 250px;
        position: fixed;
        z-index: 1;
        top: 0;
        left: 0;
        background-color: white;
        overflow-x: hidden;
        padding-top: 60px;
        box-shadow: 2px 0 5px rgba(147, 112, 219, 0.1);
        border-right: 1px solid var(--very-light-purple);
    }

    .sidebar a {
        padding: 10px 15px;
        text-decoration: none;
        font-size: 16px;
        color: #333;
        display: block;
        transition: 0.3s;
        border-left: 3px solid transparent;
    }

    .sidebar a:hover {
        background-color: var(--very-light-purple);
        border-left: 3px solid var(--primary-purple);
        color: var(--text-purple);
    }

    .sidebar .admin-header {
        font-weight: bold;
        padding: 15px;
        border-bottom: 1px solid var(--light-purple);
        margin-bottom: 10px;
        color: var(--primary-purple);
    }

    .sidebar a i {
        color: var(--primary-purple);
        margin-right: 8px;
    }

    .sidebar a.text-danger {
        color: var(--danger-color) !important;
    }

    .sidebar a.text-danger i {
        color: var(--danger-color);
    }

    /* Adjust main content when sidebar is present */
    .main-content {
        margin-left: 0;
        padding: 20px;
        background-color: white;
    }

    /* Only push content when admin is logged in */
    .admin-logged-in .main-content {
        margin-left: 250px;
    }

    /* Adjust navbar when sidebar is present */
    .admin-logged-in .navbar {
        margin-left: 250px;
        width: calc(100% - 250px);
    }

    /* Alert styling */
    .alert-success {
        background-color: #E6F4EA;
        border-color: #C3E6CB;
        color: #155724;
    }

    .alert-danger {
        background-color: #FFEBEE;
        border-color: #F5C6CB;
        color: #721C24;
    }

    /* Button styling */
    .btn-primary {
        background-color: var(--primary-purple);
        border-color: var(--primary-purple);
    }

    .btn-primary:hover {
        background-color: var(--hover-purple);
        border-color: var(--hover-purple);
    }

    /* For mobile view */
    @media screen and (max-width: 768px) {
        .sidebar {
            width: 100%;
            height: auto;
            position: relative;
            padding-top: 0;
            border-right: none;
            border-bottom: 1px solid var(--light-purple);
        }
        .main-content, .admin-logged-in .main-content {
            margin-left: 0;
        }
        .admin-logged-in .navbar {
            margin-left: 0;
            width: 100%;
        }
    }
</style>
</html>
