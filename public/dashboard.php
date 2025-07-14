<?php
session_start();
if (!isset($_SESSION['user_id'])) header("Location: login.php");
$isTeam = isset($_SESSION['team_id']) && $_SESSION['team_id'];
?>

<!DOCTYPE html>
<html>
<head>
  <title>Dashboard</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script> 
  <script src="assets/js/darkmode.js" defer></script>
  <link rel="stylesheet" href="assets/css/theme.css">
</head>
<body class="p-6 bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-white">
  <div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Welcome to Your Dashboard</h1>
    <div class="flex gap-4">
      <?php if ($isTeam): ?>
        <a href="team_dashboard.php" class="bg-indigo-600 text-white px-4 py-2 rounded">Team Dashboard</a>
      <?php endif; ?>
      <a href="api/auth/logout.php" class="bg-red-600 text-white px-4 py-2 rounded">Logout</a>
    </div>
  </div>
  <!-- <div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Welcome to Your Dashboard</h1>
    <a href="api/auth/logout.php" class="bg-red-600 text-white px-4 py-2 rounded">Logout</a>
  </div> -->

  <!-- Add Expense Form -->
  <form id="expenseForm" class="flex flex-wrap gap-2 mb-6 text-white">
    <input name="category" placeholder="Category" class="p-2 border rounded" required />
    <input name="amount" type="number" placeholder="Amount" class="p-2 border rounded" required />
    <input name="description" placeholder="Description" class="p-2 border rounded" />
    <input name="expense_date" type="date" class="p-2 border rounded" required />
    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Add</button>
  </form>

  <!-- Expense Table -->
  <div class="overflow-x-auto mb-6">
    <table class="table-auto w-full bg-white dark:bg-gray-800 rounded shadow">
      <thead>
        <tr class="bg-gray-200 dark:bg-gray-700 text-left">
          <th class="p-2">Category</th>
          <th class="p-2">Amount</th>
          <th class="p-2">Date</th>
          <th class="p-2">Description</th>
          <th class="p-2">Action</th>
        </tr>
      </thead>
      <tbody id="expenseList"></tbody>
    </table>
  </div>
  
  <div class="relative h-[40vh] w-full mb-10">
    <canvas id="chart" class="absolute top-0 left-0 w-full h-full"></canvas>
  </div>

  <script>
    // async function loadChart() {
    //   const res = await fetch('api/expense/get_user.php');
    //   const data = await res.json();
    //   const labels = data.map(e => e.category);
    //   const values = data.map(e => e.total);

    //   const ctx = document.getElementById('chart').getContext('2d');
    //   new Chart(ctx, {
    //     type: 'pie',
    //     data: {
    //       labels: labels,
    //       datasets: [{ data: values, backgroundColor: ['#60A5FA', '#34D399', '#F87171'] }]
    //     }
    //   });
    // }
    let chart = null;

    async function loadChart() {
      const res = await fetch('api/expense/get_user.php'); // or get_team.php
      const data = await res.json();
      const labels = data.map(e => e.category || `${e.category} (${e.name})`);
      const values = data.map(e => e.total);

      const ctx = document.getElementById('chart').getContext('2d');

      if (chart) chart.destroy(); // 🧽 remove the old one

      chart = new Chart(ctx, {
        type: 'doughnut', 
        data: {
          labels: labels,
          datasets: [{
            label: 'Expense',
            data: values,
            backgroundColor: ['#60A5FA', '#34D399', '#F87171', '#FBBF24']
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              labels: {
                color: '#fff',
                font: { size: 14 }
              }
            }
          }
        }
      });
    }

    async function loadExpenses() {
      const res = await fetch('api/expense/list_user.php');
      const data = await res.json();
      const table = document.getElementById('expenseList');
      table.innerHTML = '';
      data.forEach(row => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
          <td class="p-2">${row.category}</td>
          <td class="p-2">${row.amount}</td>
          <td class="p-2">${row.expense_date}</td>
          <td class="p-2">${row.description}</td>
          <td class="p-2">
            <button onclick="deleteExpense(${row.id})" class="text-red-500">Delete</button>
          </td>
        `;
        table.appendChild(tr);
      });
    }

    function deleteExpense(id) {
      fetch('api/expense/delete.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `id=${id}`
      }).then(() => {
        loadExpenses();
        loadChart();
      });
    }

    document.getElementById('expenseForm').onsubmit = async e => {
      e.preventDefault();
      const formData = new FormData(e.target);
      const res = await fetch('api/expense/add.php', { method: 'POST', body: formData });
      const data = await res.json();
      if (data.status === 'success') {
        loadExpenses();
        loadChart();
        e.target.reset();
      } else {
        Swal.fire('Error', 'Could not save expense', 'error');
      }
    };

    loadExpenses();
    loadChart();
  </script>
</body>
</html>
