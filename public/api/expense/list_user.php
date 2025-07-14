<?php
require_once __DIR__ . '/../../../db/db.php';
session_start();

$user_id = $_SESSION['user_id'];
$data = [];

$res = $conn->query("SELECT * FROM expenses WHERE user_id = $user_id ORDER BY created_at DESC");
while ($row = $res->fetch_assoc()) {
  $data[] = $row;
}
echo json_encode($data);
?>
