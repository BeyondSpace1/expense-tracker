<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Expense Tracker</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- TailwindCSS -->
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <!-- tsParticles -->
  <script src="https://cdn.jsdelivr.net/npm/tsparticles@2.11.1/tsparticles.bundle.min.js"></script>

  <!-- Custom -->
  <link rel="stylesheet" href="assets/css/theme.css" />
  <script src="assets/js/darkmode.js" defer></script>
  <script src="assets/js/animate.js" defer></script>

  <style>
    #tsparticles {
      position: fixed;
      top: 0;
      left: 0;
      z-index: -1;
      width: 100%;
      height: 100%;
    }
  </style>
</head>

<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-white">
  <div id="tsparticles"></div>

  <div class="relative z-10 flex flex-col items-center justify-center min-h-screen text-center px-6">
    <h1 class="text-5xl font-extrabold mb-4">💸 Expense Tracker</h1>
    <p class="text-lg mb-6 max-w-md">
      Smart, simple, and collaborative expense management — for you and your team.
    </p>
    <div class="flex gap-4">
      <a href="login.php" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded shadow">
        Login
      </a>
      <a href="register.php" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded shadow">
        Register
      </a>
    </div>
    <!-- <button id="darkToggle" class="mt-6 text-sm px-4 py-2 border rounded">Toggle Theme</button> -->
  </div>
</body>
</html>