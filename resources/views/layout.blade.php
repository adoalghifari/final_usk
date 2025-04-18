<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - MyBank</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">

    <style>
        html, body {
            max-width: 100%;
            overflow-x: hidden;
        }

        body {
            background-color: #f4f6f5;
            color: #212529;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar, .card-header {
            background-color: #007f3e !important;
            color: #fff !important;
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

        .table thead {
            background-color: #007f3e;
            color: #fff;
        }

        .table tbody tr:hover {
            background-color: #f1fdf8;
        }

        .table th, .table td {
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
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
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
            .card-header, .card-body, .table, .list-group-item {
                font-size: 0.95rem;
            }

            .btn {
                font-size: 0.85rem;
                padding: 0.4rem 0.75rem;
            }
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

        .card-hover:hover {
            transform: scale(1.02);
            transition: 0.3s ease;
            box-shadow: 0 0 15px rgba(0, 123, 255, 0.2);
        }

        .rounded-icon {
            width: 55px;
            height: 55px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container-fluid px-3">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <i class="fas fa-university me-2"></i><strong>MyBank</strong>
        </a>

        <div class="ms-auto d-flex align-items-center">
            @auth
                <span class="me-3">👋 Hi, {{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-outline-warning btn-sm">
                        <i class="fas fa-sign-out-alt me-1"></i> Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">Login</a>
            @endauth
        </div>
    </div>
</nav>

<main class="py-3 container-fluid">

    {{-- Flash Message --}}
    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show animate__animated animate__fadeInDown" role="alert">
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function () {
        $('#userTable').DataTable({
            responsive: true,
            paging: true,
            searching: true,
            ordering: true,
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ entri",
                zeroRecords: "Tidak ada data yang sesuai",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                infoEmpty: "Menampilkan 0 sampai 0 dari 0 entri",
                infoFiltered: "(disaring dari _MAX_ total entri)"
            }
        });
    });

    document.addEventListener("DOMContentLoaded", function () {
        const counters = document.querySelectorAll('.count-up');
        counters.forEach(counter => {
            const updateCount = () => {
                const target = +counter.getAttribute('data-target');
                const count = +counter.innerText;
                const increment = target / 100;

                if (count < target) {
                    counter.innerText = Math.ceil(count + increment);
                    setTimeout(updateCount, 10);
                } else {
                    counter.innerText = target;
                }
            };
            updateCount();
        });
    });

    // Auto-hide flash message setelah 4 detik
    setTimeout(function () {
        const alertEl = document.querySelector('.alert');
        if (alertEl) {
            alertEl.classList.remove('show');
            alertEl.classList.add('animate__fadeOutUp');

            setTimeout(() => {
                alertEl.remove();
            }, 800);
        }
    }, 4000);
</script>

</body>
</html>
