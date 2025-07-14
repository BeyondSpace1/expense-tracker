<?php
require_once __DIR__.'/../../../db/db.php';
session_start();

$user_id = $_SESSION['user_id'];
if (!$user_id) {
  echo json_encode([]);
  exit;
}

$sql = "SELECT category, SUM(amount) AS total FROM expenses WHERE user_id = $user_id GROUP BY category";
$res = $conn->query($sql);

$data = [];
while ($row = $res->fetch_assoc()) {
  $data[] = $row;
}
echo json_encode($data);
?>