<?php
require_once __DIR__.'/../../../db/db.php';
session_start();

$user_id = $_SESSION['user_id'];
$id = $_POST['id'];

if ($user_id) {
  $conn->query("DELETE FROM expenses WHERE id = $id AND user_id = $user_id");
  echo json_encode(['status' => 'success']);
} else {
  echo json_encode(['status' => 'error', 'message' => 'Not authorized']);
}
?>