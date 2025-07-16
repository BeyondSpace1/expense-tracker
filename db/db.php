<?php
require_once __DIR__ . '/../vendor/autoload.php';

$env = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$env->load();

$conn = new mysqli(
  $_ENV['DB_HOST'],
  $_ENV['DB_USER'],
  $_ENV['DB_PASS'],
  $_ENV['DB_NAME']
);

if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);
?>