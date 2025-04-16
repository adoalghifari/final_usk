<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User - Bank Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa; /* background cerah */
            color: #212529; /* teks gelap */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar, .card-header {
            background-color: #007f3e !important; /* hijau Pegadaian */
            color: #ffffff !important;
        }

        .navbar-brand img {
            height: 40px;
        }

        .card {
            background-color: #ffffff;
            border: 1px solid #dee2e6;
            border-radius: 1rem;
            box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.1);
            color: #212529;
        }

        .form-control, .form-select {
            background-color: #ffffff;
            color: #212529;
            border: 1px solid #ced4da;
            border-radius: 0.5rem;
        }

        .form-control::placeholder {
            color: #6c757d;
        }

        .form-actions-footer {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .btn {
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }

        .btn:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }

        .btn-outline-secondary {
            color: #212529;
            border-color: #ced4da;
        }

        .btn-outline-secondary:hover {
            background-color: #e2e6ea;
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

        .list-group-item {
            background-color: #ffffff;
            border: 1px solid #dee2e6;
            color: #212529;
            border-radius: 0.5rem;
            margin-bottom: 8px;
        }

        .modal-content {
            background-color: #ffffff;
            color: #212529;
            border-radius: 10px;
        }

        .btn-close {
            filter: none;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="https://img.icons8.com/ios-filled/50/ffffff/bank.png" alt="Bank Logo">
            <span class="ms-2 fw-bold">MyBank</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>
    </nav>

    <!-- Form Card -->
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card text-white">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Add New User</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control" name="name" required placeholder="Enter full name">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" required placeholder="Enter email address">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Password</label>
                                    <input type="password" class="form-control" name="password" required placeholder="Enter password">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Role</label>
                                    <select name="role" class="form-select" required>
                                        <option value="">--- Choose Role ---</option>
                                        <option value="admin">Admin</option>
                                        <option value="bank">Bank</option>
                                        <option value="siswa">Siswa</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-actions-footer">
                                <a href="{{ route('home') }}" class="btn btn-outline-secondary">Cancel</a>
                                <button type="submit" class="btn btn-success">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
