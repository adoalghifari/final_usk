<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login - MyBank</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet"/>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }
    .background-ovo {
      background: linear-gradient(160deg, #4b0082, #7f00ff);
    }
    .form-container {
      background: white;
      border-radius: 24px;
      padding: 2rem;
      max-width: 400px;
      width: 100%;
      box-shadow: 0 12px 32px rgba(0, 0, 0, 0.2);
    }
    .login-btn {
      background-color: #7f00ff;
      transition: all 0.3s ease-in-out;
    }
    .login-btn:hover {
      background-color: #5e00c7;
      box-shadow: 0 0 10px #a855f7;
    }
  </style>
</head>
<body class="background-ovo min-h-screen flex items-center justify-center px-4">

  <div class="form-container text-center">
    <!-- Logo -->
      <img src="{{ asset('assets/logo.png') }}" alt="MyBank Logo" class="mx-auto mb-6 w-24 h-24 rounded-full shadow-lg object-cover"/>

    <h2 class="text-2xl font-semibold text-gray-800 mb-2">Welcome to MyBank</h2>
    <p class="text-sm text-gray-500 mb-6">Login untuk mengakses dompet digital kamu</p>

    <form method="POST" action="{{ route('login') }}" class="space-y-4 text-left">
      @csrf
      <div>
        <label for="email" class="text-sm font-medium text-gray-600">Email</label>
        <input type="email" id="email" name="email" placeholder="you@example.com"
               class="w-full px-4 py-3 mt-1 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500"
               required />
      </div>
      <div>
        <label for="password" class="text-sm font-medium text-gray-600">Password</label>
        <input type="password" id="password" name="password"
               class="w-full px-4 py-3 mt-1 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500"
               required />
      </div>
      <button type="submit"
              class="login-btn w-full py-3 text-white font-semibold rounded-xl hover:shadow-lg">
        Login
      </button>
    </form>

  </div>

</body>
</html>
