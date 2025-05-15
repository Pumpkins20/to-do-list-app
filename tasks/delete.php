<?php
// tasks/delete.php
session_start();

// Include koneksi database dan fungsi
require_once '../config/database.php';
require_once '../auth/auth_functions.php';
require_once 'task_functions.php';

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$task_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Hapus task
$result = deleteTask($conn, $task_id, $user_id);

$_SESSION['message'] = $result['message'];
$_SESSION['message_type'] = $result['status'] ? 'success' : 'danger';

// Redirect ke dashboard
header('Location: ../dashboard.php');
exit();
?>