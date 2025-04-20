<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Add User - MyBank</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(to right, #f3e8ff, #ede9fe);
      color: #333;
    }

    .navbar {
      background-color: #7F3DFF;
    }

    .navbar-brand img {
      height: 40px;
    }

    .card {
      border-radius: 1.5rem;
      box-shadow: 0 1rem 2rem rgba(0, 0, 0, 0.1);
    }

    .card-header {
      background-color: #7F3DFF;
      color: white;
      border-top-left-radius: 1.5rem;
      border-top-right-radius: 1.5rem;
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 1rem 1.5rem;
    }

    .card-header i {
      font-size: 1.6rem;
    }

    .form-label {
      font-weight: 600;
      color: #4b5563;
    }

    .input-group-text {
      background-color: #f3f4f6;
      border: 1px solid #e5e7eb;
      border-right: 0;
    }

    .form-control, .form-select {
      border: 1px solid #e5e7eb;
      border-radius: 0.75rem;
    }

    .form-actions-footer {
      display: flex;
      justify-content: space-between;
      margin-top: 2rem;
    }

    .btn-purple {
      background-color: #7F3DFF;
      color: white;
      font-weight: 600;
    }

    .btn-purple:hover {
      background-color: #6b2edb;
    }

    .btn-outline-secondary:hover {
      background-color: #f1f5f9;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark px-4">
  <a class="navbar-brand d-flex align-items-center" href="#">
      <img src="{{ asset('assets/logo.png') }}" alt="MyBank Logo" class="mx-auto mb-6 w-24 h-24 rounded-full shadow-lg object-cover"/>
    <span class="ms-2 fw-bold">MyBank</span>
  </a>
</nav>

<!-- Form Card -->
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card">
        <div class="card-header">
          <i class="bi bi-person-plus-fill"></i>
          <h4 class="mb-0">Add New User</h4>
        </div>
        <div class="card-body p-4">
          <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row mb-4">
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

            <div class="row mb-4">
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
                    <option value="">-- Choose Role --</option>
                    <option value="siswa">Siswa</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="form-actions-footer">
              <a href="{{ route('home') }}" class="btn btn-outline-warning">Cancel</a>
              <button type="submit" class="btn btn-purple">Submit User</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
