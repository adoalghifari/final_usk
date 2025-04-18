<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(to right, #e8f5e9, #ffffff);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar {
            background-color: #007f3e;
        }

        .navbar-brand img {
            height: 40px;
        }

        .card {
            border-radius: 1.5rem;
            box-shadow: 0 1rem 2rem rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #007f3e;
            color: white;
            border-top-left-radius: 1.5rem;
            border-top-right-radius: 1.5rem;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .card-header i {
            font-size: 1.8rem;
        }

        .form-control, .form-select {
            border-radius: 0.75rem;
        }

        .input-group-text {
            background-color: #f1f3f5;
            border-radius: 0.75rem 0 0 0.75rem;
        }

        .form-actions-footer {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }

        .btn {
            border-radius: 0.75rem;
            padding: 10px 20px;
        }

        .btn-success {
            background-color: #007f3e;
            border: none;
        }

        .btn-success:hover {
            background-color: #006837;
        }

        .btn-outline-secondary:hover {
            background-color: #e9ecef;
        }

        .card-body {
            padding: 2rem;
        }

        .form-label {
            font-weight: 500;
        }

        .form-section {
            margin-bottom: 1.5rem;
        }

    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark px-4">
    <a class="navbar-brand d-flex align-items-center" href="#">
        <img src="https://img.icons8.com/ios-filled/50/ffffff/bank.png" alt="Bank Logo">
        <span class="ms-2 fw-bold">MyBank</span>
    </a>
</nav>

<!-- Flash Message Section -->
<div class="container mt-3">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @elseif(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
</div>

<!-- Form Card -->
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-person-plus-fill"></i>
                    <h4 class="mb-0">Add New User</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row form-section">
                            <div class="col-md-6">
                                <label class="form-label">Name</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                                    <input type="text" class="form-control" name="name" placeholder="Full name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                                    <input type="email" class="form-control" name="email" placeholder="Email address" required>
                                </div>
                            </div>
                        </div>

                        <div class="row form-section">
                            <div class="col-md-6">
                                <label class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                    <input type="password" class="form-control" name="password" placeholder="Password" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Role</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-shield-lock-fill"></i></span>
                                    <select name="role" class="form-select" required>
                                        <option value="siswa" selected>Siswa</option> <!-- Set default to "siswa" -->
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-actions-footer">
                            <a href="{{ route('home') }}" class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit" class="btn btn-success">Submit User</button>
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
