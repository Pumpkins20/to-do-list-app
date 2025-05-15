<?php
// tasks/create.php
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

// Proses form tambah task
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $title = clean($conn, $_POST['title']);
    $description = isset($_POST['description']) ? clean($conn, $_POST['description']) : '';
    
    $result = addTask($conn, $user_id, $title, $description);
    
    $_SESSION['message'] = $result['message'];
    $_SESSION['message_type'] = $result['status'] ? 'success' : 'danger';
}

// Redirect ke dashboard
header('Location: ../dashboard.php');
exit();
?>