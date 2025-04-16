<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>Login Page </title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }
    .login-container {
      background: #F9F9F9;
      border-radius: 16px;
      box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.1);
      max-width: 400px;
      padding: 30px;
    }
    .btn-login {
      background-color: #0073e6;
      color: white;
      font-weight: 600;
      border-radius: 8px;
      padding: 12px 0;
      width: 100%;
      transition: background-color 0.3s;
    }
    .btn-login:hover {
      background-color: #005bb5;
    }
    .logo-img {
      display: block;
      margin: 0 auto 20px;
      max-width: 100px;
    }
  </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

  <div class="login-container">
    <!-- Logo Bank  -->
    <img src="{{ asset('assets/logo.png') }}" alt="Bank Jago Logo" class="logo-img"/>

    <h2 class="text-2xl font-semibold text-center mb-6 text-gray-800">Selamat Datang di MyBank</h2>
    <p class="text-center text-sm text-gray-600 mb-8">Silakan login untuk melanjutkan</p>

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
      @csrf
      <div>
        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
        <input type="email" id="email" name="email" placeholder="name@example.com"
               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
               required />
      </div>
      <div>
        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
        <input type="password" id="password" name="password"
               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
               required />
      </div>
      <button type="submit" class="btn-login">Login</button>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
</body>
</html>
