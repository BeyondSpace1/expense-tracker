<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <script src="assets/js/animate.js" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/tsparticles@2.11.1/tsparticles.bundle.min.js"></script>
  <link rel="stylesheet" href="assets/css/theme.css">
</head>
<body class="flex justify-center items-center h-screen bg-gray-100 dark:bg-gray-900">
      <div id="tsparticles"></div>
  <form id="loginForm" class="bg-white dark:bg-gray-800 p-6 rounded shadow-lg w-80 text-white">
    <h2 class="text-lg font-semibold mb-4">Login</h2>
    <input name="email" type="email" placeholder="Email" class="w-full mb-2 p-2 border rounded" required />
    <input name="password" type="password" placeholder="Password" class="w-full mb-3 p-2 border rounded" required />
    <button type="submit" class="bg-blue-600 text-white w-full py-2 rounded">Login</button>
    <a href="./register.php" class="text-amber-300">New Here ?</a>
    <!-- <button id="darkToggle" type="button" class="mt-3 w-full border py-1 rounded">Toggle Mode</button> -->
  </form>
  <script>
    document.getElementById('loginForm').onsubmit = async e => {
      e.preventDefault();
      const form = e.target;
      const formData = new FormData(form);
      const res = await fetch('api/auth/login.php', { method: 'POST', body: formData });
      const data = await res.json();
      if (data.status === 'success') location.href = 'dashboard.php';
      else Swal.fire('Login Failed', data.message, 'error');
    };
  </script>
</body>
</html>