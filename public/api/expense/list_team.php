<?php
require_once __DIR__ . '/../../../db/db.php';
session_start();

$team_id = $_SESSION['team_id'];
$data = [];

$res = $conn->query("
  SELECT expenses.*, users.name 
  FROM expenses 
  JOIN users ON expenses.user_id = users.id 
  WHERE expenses.team_id = $team_id 
  ORDER BY expenses.created_at DESC
");

while ($row = $res->fetch_assoc()) {
  $data[] = $row;
}
echo json_encode($data);
?>
