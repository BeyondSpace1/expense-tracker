<?php
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['team_id'])) {
  header("Location: login.php");
  exit;
}
require_once __DIR__ . '/../db/db.php';

$team_id = $_SESSION['team_id'];
$team = $conn->query("SELECT t_name FROM teams WHERE id = $team_id")->fetch_assoc();
$t_name = htmlspecialchars($team['t_name']);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Team Dashboard</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script> 
  <link rel="stylesheet" href="assets/css/theme.css">
</head>
<body class="p-6 bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-white">

  <!-- Header -->
  <div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Welcome to your team <span class="text-indigo-500"><?= $t_name ?></span></h1>
    <div class="flex gap-4">
      <button onclick="generateInvite()" class="bg-green-600 text-white px-4 py-2 rounded">Invite Member</button>
      <a href="dashboard.php" class="bg-gray-500 text-white px-4 py-2 rounded">Back to My Dashboard</a>
      <a href="api/auth/logout.php" class="bg-red-600 text-white px-4 py-2 rounded">Logout</a>
    </div>
  </div>

  <!-- Expense Form -->
  <form id="expenseForm" class="flex flex-wrap gap-2 mb-6">
    <input name="category" placeholder="Category" class="p-2 border rounded" required />
    <input name="amount" type="number" placeholder="Amount" class="p-2 border rounded" required />
    <input name="description" placeholder="Description" class="p-2 border rounded" />
    <input name="expense_date" type="date" class="p-2 border rounded" required />
    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Add</button>
  </form>

  <!-- Table -->
  <div class="overflow-x-auto mb-6">
    <table class="table-auto w-full bg-white dark:bg-gray-800 rounded shadow">
      <thead>
        <tr class="bg-gray-200 dark:bg-gray-700 text-left">
          <th class="p-2">Category</th>
          <th class="p-2">Amount</th>
          <th class="p-2">Date</th>
          <th class="p-2">Description</th>
          <th class="p-2">Added By</th>
          <th class="p-2">Action</th>
        </tr>
      </thead>
      <tbody id="expenseList"></tbody>
    </table>
  </div>
  <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
    <!-- Total Chart -->
    <div class="bg-white dark:bg-gray-800 p-4 rounded shadow">
      <h2 class="text-lg font-semibold mb-2">Total Team Spend</h2>
      <div class="text-3xl font-bold text-indigo-600" id="totalValue">₹0</div>
    </div>

    <!-- Pie Chart -->
    <div class="relative h-[40vh] w-full">
      <canvas id="chart" class="absolute top-0 left-0 w-full h-full"></canvas>
    </div>
  </div>


  <!-- Chart -->
  <div class="relative h-[40vh] w-full mb-10">
    <canvas id="chart" class="absolute top-0 left-0 w-full h-full"></canvas>
  </div>

  <script>
    let chart = null;

    // async function loadChart() {
    //   const res = await fetch('api/expense/get_team.php');
    //   const data = await res.json();
    //   const labels = data.map(e => `${e.category} (${e.name})`);
    //   const values = data.map(e => e.total);

    //   const ctx = document.getElementById('chart').getContext('2d');
    //   if (chart) chart.destroy();

    //   chart = new Chart(ctx, {
    //     type: 'bar',
    //     data: {
    //       labels: labels,
    //       datasets: [{
    //         label: 'Team Expenses',
    //         data: values,
    //         backgroundColor: ['#60A5FA', '#34D399', '#F87171', '#FBBF24']
    //       }]
    //     },
    //     options: {
    //       responsive: true,
    //       maintainAspectRatio: false,
    //     }
    //   });
    // }
  async function loadChart() {
    const res = await fetch('api/expense/get_team.php');
    const data = await res.json();

    const labels = data.map(e => e.name);
    const values = data.map(e => parseFloat(e.total));
    const total = values.reduce((a, b) => a + b, 0);

    document.getElementById('totalValue').textContent = `₹${total.toFixed(2)}`;

    const colors = [
      '#60A5FA', '#34D399', '#F87171', '#FBBF24',
      '#A78BFA', '#F472B6', '#38BDF8', '#4ADE80',
      '#FB7185', '#E879F9', '#FACC15'
    ];

    const ctx = document.getElementById('chart').getContext('2d');
    if (chart) chart.destroy();

    chart = new Chart(ctx, {
      type: 'pie',
      data: {
        labels: labels,
        datasets: [{
          data: values,
          backgroundColor: colors.slice(0, labels.length)
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'bottom'
          }
        }
      }
    });
  }


    async function loadExpenses() {
      const res = await fetch('api/expense/list_team.php');
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
          <td class="p-2 text-sm italic">${row.name}</td>
          <td class="p-2"><button onclick="deleteExpense(${row.id})" class="text-red-500">Delete</button></td>
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
      const res = await fetch('api/expense/add.php', {
        method: 'POST',
        body: formData
      });
      const data = await res.json();
      if (data.status === 'success') {
        loadExpenses();
        loadChart();
        e.target.reset();
      } else {
        Swal.fire('Error', 'Could not save expense', 'error');
      }
    };
    function generateInvite() {
      fetch('api/team/generate_code.php', {
        method: 'POST'
      })
      .then(res => res.json())
      .then(data => {
        if (data.status === 'success') {
          Swal.fire({
            icon: 'success',
            title: 'Invite Code',
            html: `<strong>${data.token}</strong><br><br>Share this code with your team member.`,
            confirmButtonText: 'Copy & Close'
          });
        } else {
          Swal.fire('Error', data.message || 'Could not generate invite code', 'error');
        }
    });
  }

    loadExpenses();
    loadChart();
  </script>
</body>
</html>
