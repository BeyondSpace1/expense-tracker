<?php
require_once __DIR__.'/../../../db/db.php';
session_start();

$email = $_POST['email'];
$pass = $_POST['password'];

$res = $conn->query("SELECT * FROM users WHERE email = '$email'");
if ($res->num_rows === 1) {
  $user = $res->fetch_assoc();
  if (password_verify($pass, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['team_id'] = $user['team_id'];
    echo json_encode(['status' => 'success']);
  } else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid password']);
  }
} else {
  echo json_encode(['status' => 'error', 'message' => 'User not found']);
}
?>