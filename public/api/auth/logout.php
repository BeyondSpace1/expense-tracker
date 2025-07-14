<?php
session_start();
session_destroy();
// echo json_encode(['status' => 'logged_out']);
header("Location: /");
exit();
?>