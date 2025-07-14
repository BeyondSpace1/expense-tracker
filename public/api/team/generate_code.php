<?php
require_once __DIR__ . '/../../../db/db.php';
session_start();

if (!isset($_SESSION['team_id']) || empty($_SESSION['team_id'])) {
  echo json_encode(['status' => 'error', 'message' => 'Not part of a team']);
  exit;
}

$team_id = intval($_SESSION['team_id']);
$token = bin2hex(random_bytes(4)); // 8-char code like 'da97730e'

$stmt = $conn->prepare("INSERT INTO invite_codes (team_id, token) VALUES (?, ?)");
$stmt->bind_param("is", $team_id, $token);
$stmt->execute();

echo json_encode(['status' => 'success', 'token' => $token]);
?>
