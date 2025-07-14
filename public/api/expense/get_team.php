<?php
require_once __DIR__ . '/../../../db/db.php';
session_start();

$team_id = $_SESSION['team_id'];
$data = [];

$res = $conn->query("
  SELECT users.name, SUM(expenses.amount) AS total 
  FROM expenses 
  JOIN users ON expenses.user_id = users.id 
  WHERE expenses.team_id = $team_id 
  GROUP BY users.id
");

while ($row = $res->fetch_assoc()) {
  $data[] = $row;
}
echo json_encode($data);
