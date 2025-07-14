<!DOCTYPE html>
<html>
<head>
  <title>Register</title>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <script src="assets/js/animate.js" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/tsparticles@2.11.1/tsparticles.bundle.min.js"></script>
  <link rel="stylesheet" href="assets/css/theme.css">
</head>
<body class="bg-gray-100 text-gray-900 p-8">
    <div id="tsparticles"></div>
  <div class="max-w-md mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-4">Register</h1>
    <form id="registerForm">
      <input name="name" placeholder="Your Name" class="w-full mb-2 p-2 border rounded" required />
      <input name="email" type="email" placeholder="Email" class="w-full mb-2 p-2 border rounded" required />
      <input name="password" type="password" placeholder="Password" class="w-full mb-4 p-2 border rounded" required />

      <label class="block mb-2">Account Type:</label>
      <label><input type="radio" name="user_type" value="personal" checked> Personal</label>
      <label class="ml-4"><input type="radio" name="user_type" value="team"> Team</label>

      <div id="teamOptions" class="mt-4 hidden">
        <label><input type="radio" name="team_mode" value="create" checked> Create Team</label>
        <label class="ml-4"><input type="radio" name="team_mode" value="join"> Join Team</label>

        <input type="text" id="teamName" name="team_name" placeholder="Team Name" class="w-full mt-2 p-2 border rounded" required />
        <input type="text" id="inviteCode" name="invite_code" placeholder="Invite Code" class="w-full mt-2 p-2 border rounded hidden" />
      </div>

      <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded mt-4 w-full">Register</button>
    <a href="login.php" class="text-lime-500">Already have an account ?</a>    
    </form>
  </div>

  <script>
    const form = document.getElementById('registerForm');

    document.querySelectorAll('input[name="user_type"]').forEach(radio => {
      radio.addEventListener('change', e => {
        document.getElementById('teamOptions').classList.toggle('hidden', e.target.value !== 'team');
      });
    });

    document.querySelectorAll('input[name="team_mode"]').forEach(radio => {
      radio.addEventListener('change', e => {
        const isJoin = e.target.value === 'join';
        document.getElementById('inviteCode').classList.toggle('hidden', !isJoin);
        document.getElementById('inviteCode').required = isJoin;
        document.getElementById('teamName').classList.toggle('hidden', isJoin);
        document.getElementById('teamName').required = !isJoin;
      });
    });

    form.onsubmit = async e => {
      e.preventDefault();
      const data = new FormData(form);
      const res = await fetch('api/register/create.php', {
        method: 'POST',
        body: data
      });
      const result = await res.json();
      if (result.status === 'success') {
        Swal.fire('Success', 'Registered successfully!', 'success').then(() => {
          window.location.href = 'login.php';
        });
      } else {
        Swal.fire('Error', result.message || 'Registration failed', 'error');
      }
    };
  </script>
</body>
</html>
