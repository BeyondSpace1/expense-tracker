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
<body class="flex justify-center items-center h-screen bg-gray-100 dark:bg-gray-900">
    <div id="tsparticles"></div>

  <form id="regForm" class="bg-white dark:bg-gray-800 p-6 rounded shadow-lg w-96 text-white">
    <h2 class="text-xl font-semibold mb-4">Register</h2>
    <input name="name" placeholder="Name" class="w-full mb-2 p-2 border rounded" required />
    <input name="email" type="email" placeholder="Email" class="w-full mb-2 p-2 border rounded" required />
    <input name="password" type="password" placeholder="Password" class="w-full mb-2 p-2 border rounded" required />

    <select name="user_type" id="user_type" class="w-full mb-2 p-2 border rounded">
      <option value="personal">Personal</option>
      <option value="team">Team</option>
    </select>

    <div id="team_options" class="hidden mb-2">
      <label><input type="radio" name="team_mode" value="create" checked> Create Team</label>
      <label><input type="radio" name="team_mode" value="join"> Join Team</label>
      <input type="text" name="invite_code" id="invite_code" class="w-full p-2 border mt-2 rounded" placeholder="Invite Code" disabled />
    </div>

    <button type="submit" class="bg-green-600 text-white py-2 w-full rounded">Register</button>
    <a href="login.php" class="text-teal-500">Already have an account ?</a>    
    <!-- <button id="darkToggle" type="button" class="mt-3 w-full border py-1 rounded">Toggle Mode</button> -->
  </form>

  <script>
    document.getElementById('user_type').addEventListener('change', function () {
      document.getElementById('team_options').style.display = this.value === 'team' ? 'block' : 'none';
    });

    document.querySelectorAll('input[name=team_mode]').forEach(r => {
      r.addEventListener('change', () => {
        document.getElementById('invite_code').disabled = document.querySelector('input[name=team_mode]:checked').value !== 'join';
      });
    });

    document.getElementById('regForm').onsubmit = async e => {
      e.preventDefault();
      const formData = new FormData(e.target);
      const res = await fetch('api/register/create.php', {
        method: 'POST',
        body: formData
      });
      const data = await res.json();
      if (data.status === 'success') {
        Swal.fire('Success', 'Registration complete', 'success').then(() => window.location = 'login.php');
      } else {
        Swal.fire('Error', data.message, 'error');
      }
    };
  </script>
</body>
</html>