<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - MyBank</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">

    <style>
        html,
        body {
            max-width: 100%;
            overflow-x: hidden;
        }

        body {
            background-color: #f4f6f5;
            color: #212529;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar,
        .card-header {
            background: linear-gradient(135deg, #4b0082, #7f00ff) !important;
            color: #fff !important;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .card {
            background-color: #ffffff;
            border: 1px solid #dee2e6;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        .card-header h5 {
            font-weight: 600;
        }

        .btn {
            transition: all 0.3s ease-in-out;
            border-radius: 6px;
        }

        .btn:hover {
            transform: translateY(-2px);
            opacity: 0.95;
        }

        .btn-primary {
            background-color: #007f3e;
            border-color: #007f3e;
        }

        .btn-primary:hover {
            background-color: #006837;
            border-color: #006837;
        }

        .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
            color: #212529;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-outline-secondary:hover {
            background-color: #470650;
        }

        .table thead {
            background-color: #4b0082;
            color: white;
        }

        .table tbody tr:hover {
            background-color: #f1fdf8;
        }

        .table th,
        .table td {
            white-space: nowrap;
        }

        .list-group-item {
            background-color: #ffffff;
            border: 1px solid #e1e1e1;
            color: #212529;
            border-radius: 8px;
            margin-bottom: 8px;
        }

        .balance-box {
            font-size: 2rem;
            font-weight: bold;
            color: #007f3e;
            animation: fadeInUp 1s ease-out;
        }

        .text-muted {
            font-size: 0.875rem;
            color: #6c757d !important;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .modal-content {
            background-color: #ffffff;
            color: #212529;
            border-radius: 10px;
        }

        .btn-close {
            filter: none;
        }

        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 0.3rem;
        }

        @media (max-width: 768px) {

            .card-header,
            .card-body,
            .table,
            .list-group-item {
                font-size: 0.95rem;
            }

            .btn {
                font-size: 0.85rem;
                padding: 0.4rem 0.75rem;
            }
        }

        .ovo-gradient {
            background: linear-gradient(135deg, #4b0082, #7f00ff);
            /* Gradien dengan warna OVO */
            color: #fff;
        }

        .ovo-gradient .btn {
            background-color: #4b0082;
            border-color: #4b0082;
        }

        .ovo-gradient .btn:hover {
            background-color: #7f00ff;
            border-color: #7f00ff;
        }

        .ovo-gradient .card {
            background: linear-gradient(135deg, #4b0082, #7f00ff);
            border: none;
        }

        .ovo-gradient .navbar {
            background: linear-gradient(135deg, #4b0082, #7f00ff) !important;
        }

        /* Styling untuk navbar */
        .navbar {
            padding: 1rem 2rem;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar a {
            font-weight: bold;
            color: white;
            text-decoration: none;
        }

        .navbar a:hover {
            color: #f4f6f5;
        }

        /* Style untuk card dan info utama */
        .info-box {
            border-radius: 10px;
            background: #fff;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .info-box h5 {
            color: #4b0082;
        }

        /* Style untuk tombol */
        .btn-custom {
            background: #4b0082;
            color: white;
            border-radius: 8px;
        }

        .btn-custom:hover {
            background: #7f00ff;
        }


        .dark-mode .table {
            color: #f8f9fa;
        }

        .dark-mode .table thead {
            background-color: #3a3a4a;
        }

        .dark-mode .btn-warning,
        .dark-mode .btn-danger,
        .dark-mode .btn-primary {
            color: #fff;
        }

        .fade-in {
            animation: fadeInUp 0.8s ease-in-out;
        }

        .rounded-icon {
            width: 55px;
            height: 55px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .fade-in {
            animation: fadeIn 0.6s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card-hover:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
            transition: all 0.3s ease;
        }

        .rounded-icon {
            width: 50px;
            height: 50px;
            background: #4b0082;
            color: white;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .bg-gradient-primary {
            background: linear-gradient(135deg, #5c2f8f, #9b59b6);
        }

        .stat-card {
            background: linear-gradient(135deg, #7f00ff, #4b0082);
            color: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
            transform: translateY(-5px);
        }

        .icon-box {
            width: 60px;
            height: 60px;
            font-size: 1.5rem;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.2);
        }

        .table thead th {
            vertical-align: middle;
        }

        .scroll-box::-webkit-scrollbar {
            width: 6px;
        }

        .scroll-box::-webkit-scrollbar-thumb {
            background: #dee2e6;
            border-radius: 10px;
        }

        .stat-card {
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 1rem 1.5rem rgba(0, 0, 0, 0.1);
        }

        .bg-gradient-ovo {
            background: linear-gradient(135deg, #5c2f8f, #9b59b6);
        }

        .stat-card i {
            color: #fff;
        }

        .stat-card .stat-title {
            color: #fff;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #7f00ff;">
        <div class="container-fluid px-4">
            <a class="navbar-brand fw-bold d-flex align-items-center" href="#">
                <i class="fas fa-university me-2"></i>MyBank
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain"
                aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    @if (Auth::user()->role == 'bank')
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="/home"><i
                                    class="bi bi-house-door me-1"></i>Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('bank.transaksi') }}"><i
                                    class="bi bi-clock-history me-1"></i>History</a>
                        </li>
                    @endif
                </ul>

                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 d-flex align-items-center">
                    @auth
                        <li class="nav-item me-2">
                            <span class="navbar-text text-white">
                                👋 Hi, <strong>{{ Auth::user()->name }}</strong>
                            </span>
                        </li>
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="btn btn-sm btn-outline-dark rounded-pill px-3">
                                    <i class="fas fa-sign-out-alt me-1"></i> Logout
                                </button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a href="{{ route('login') }}" class="btn btn-sm btn-outline-light rounded-pill px-3">Login</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-3 container-fluid">

        {{-- Flash Message --}}
        @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show animate__animated animate__fadeInDown"
                role="alert">
                {{ session('status') }}
            </div>
        @endif
        
        @yield('content')
    </main>

    <footer class="text-center text-muted small py-4">
        &copy; {{ now()->year }} MyBank. All rights reserved.
    </footer>

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

</body>

</html>
