<?php
require_once __DIR__ . '/../../../db/db.php';
session_start();

$name = $_POST['name'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
$type = $_POST['user_type'];
$mode = $_POST['team_mode'] ?? '';
$team_name = $_POST['team_name'] ?? '';
$token = $_POST['invite_code'] ?? '';

$check = $conn->query("SELECT id FROM users WHERE email = '$email'");
if ($check->num_rows > 0) {
  echo json_encode(['status' => 'error', 'message' => 'Email already registered']);
  exit;
}

if ($type === 'team') {
  if ($mode === 'create') {
    $conn->query("INSERT INTO teams (t_name, created_by) VALUES ('$team_name', 0)");
    $tid = $conn->insert_id;

    $conn->query("INSERT INTO users (name, email, password, user_type, team_id) VALUES ('$name', '$email', '$password', 'team', $tid)");
    $uid = $conn->insert_id;

    $conn->query("UPDATE teams SET created_by = $uid WHERE id = $tid");
    $conn->query("INSERT INTO team_members (team_id, user_id, role) VALUES ($tid, $uid, 'owner')");
  } elseif ($mode === 'join') {
    $res = $conn->query("SELECT team_id FROM invite_codes WHERE token = '$token'");
    if ($res->num_rows === 0) {
      echo json_encode(['status' => 'error', 'message' => 'Invalid invite code']);
      exit;
    }
    $tid = $res->fetch_assoc()['team_id'];
    $conn->query("INSERT INTO users (name, email, password, user_type, team_id) VALUES ('$name', '$email', '$password', 'team', $tid)");
    $uid = $conn->insert_id;
    $conn->query("INSERT INTO team_members (team_id, user_id, role) VALUES ($tid, $uid, 'member')");
  }
} else {
  $conn->query("INSERT INTO users (name, email, password, user_type) VALUES ('$name', '$email', '$password', 'personal')");
}

echo json_encode(['status' => 'success']);
