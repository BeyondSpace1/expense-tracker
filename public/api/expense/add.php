<?php
require_once __DIR__.'/../../../db/db.php';
session_start();

$user_id = $_SESSION['user_id'];
$team_id = $_SESSION['team_id'] ?? null;

$cat = $_POST['category'];
$amt = $_POST['amount'];
$desc = $_POST['description'];
$date = $_POST['expense_date'];

if ($user_id) {
  $team = $team_id ?? 'NULL';
  $stmt = $conn->prepare("INSERT INTO expenses (user_id, team_id, category, amount, description, expense_date) VALUES (?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("iissss", $user_id, $team, $cat, $amt, $desc, $date);
  $stmt->execute();
  echo json_encode(['status' => 'success']);
} else {
  echo json_encode(['status' => 'error', 'message' => 'Not authenticated']);
}
?>