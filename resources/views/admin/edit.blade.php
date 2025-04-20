<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Edit User - MyBank</title>
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

    .alert-success {
      background-color: #d1fae5;
      color: #065f46;
      border: none;
      border-radius: 0.75rem;
      padding: 1rem;
      margin-bottom: 1rem;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark px-4">
  <a class="navbar-brand d-flex align-items-center" href="#">
    <img src="{{ asset('assets/logo.png') }}" alt="MyBank Logo" />
    <span class="ms-2 fw-bold">MyBank</span>
  </a>
</nav>

<!-- Content -->
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-8">

      @if(session('success'))
        <div class="alert alert-success d-flex align-items-center">
          <i class="bi bi-check-circle-fill me-2"></i>
          {{ session('success') }}
        </div>
      @endif

      <div class="card">
        <div class="card-header">
          <i class="bi bi-pencil-square"></i>
          <h4 class="mb-0">Edit User</h4>
        </div>
        <div class="card-body p-4">
          <form action="{{ route('user.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row mb-4">
              <div class="col-md-6">
                <label class="form-label">Name</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                  <input type="text" class="form-control" name="name" value="{{ $user->name }}" required>
                </div>
              </div>
              <div class="col-md-6">
                <label class="form-label">Email</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                  <input type="email" class="form-control" name="email" value="{{ $user->email }}" required>
                </div>
              </div>
            </div>

            <div class="row mb-4">
              <div class="col-md-6">
                <label class="form-label">Password</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                  <input type="password" class="form-control" name="password" value="{{ $user->password }}" required>
                </div>
              </div>
              <div class="col-md-6">
                <label class="form-label">Role</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-shield-lock-fill"></i></span>
                  <select name="role" class="form-select" required>
                    <option value="">-- Choose Role --</option>
                    <option value="bank" {{ $user->role == 'bank' ? 'selected' : '' }}>Bank</option>
                    <option value="siswa" {{ $user->role == 'siswa' ? 'selected' : '' }}>Siswa</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="form-actions-footer">
              <a href="{{ route('home') }}" class="btn btn-outline-warning">Cancel</a>
              <button type="submit" class="btn btn-purple">Update User</button>
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
