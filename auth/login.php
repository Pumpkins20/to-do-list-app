<?php
// auth/login.php
session_start();

// Cek apakah user sudah login
if (isset($_SESSION['user_id'])) {
    header('Location: ../dashboard.php');
    exit();
}

// Include koneksi database dan fungsi autentikasi
require_once '../config/database.php';
require_once 'auth_functions.php';

// Proses form login
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = clean($conn, $_POST['username']);
    $password = $_POST['password'];
    
    $result = loginUser($conn, $username, $password);
    
    if ($result['status']) {
        $_SESSION['message'] = $result['message'];
        $_SESSION['message_type'] = 'success';
        header('Location: ../dashboard.php');
        exit();
    } else {
        $_SESSION['message'] = $result['message'];
        $_SESSION['message_type'] = 'danger';
    }
}

$base_path = '../';
include_once '../includes/header.php';
?>

<div class="card">
    <h2>Login</h2>
    <form action="" method="post">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit">Login</button>
    </form>
    <p style="margin-top: 15px;">Belum punya akun? <a href="register.php">Register</a></p>
</div>

<?php include_once '../includes/footer.php'; ?>

<?php
// auth/register.php
session_start();

// Cek apakah user sudah login
if (isset($_SESSION['user_id'])) {
    header('Location: ../dashboard.php');
    exit();
}

// Include koneksi database dan fungsi autentikasi
require_once '../config/database.php';
require_once 'auth_functions.php';

// Proses form register
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = clean($conn, $_POST['username']);
    $email = clean($conn, $_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Cek konfirmasi password
    if ($password !== $confirm_password) {
        $_SESSION['message'] = 'Password dan konfirmasi password tidak sama';
        $_SESSION['message_type'] = 'danger';
    } else {
        $result = registerUser($conn, $username, $email, $password);
        
        $_SESSION['message'] = $result['message'];
        $_SESSION['message_type'] = $result['status'] ? 'success' : 'danger';
        
        if ($result['status']) {
            header('Location: login.php');
            exit();
        }
    }
}

$base_path = '../';
include_once '../includes/header.php';
?>

<div class="card">
    <h2>Register</h2>
    <form action="" method="post">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            <small style="color: #666;">Minimal 6 karakter</small>
        </div>
        <div class="form-group">
            <label for="confirm_password">Konfirmasi Password</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
        </div>
        <button type="submit">Register</button>
    </form>
    <p style="margin-top: 15px;">Sudah punya akun? <a href="login.php">Login</a></p>
</div>

<?php include_once '../includes/footer.php'; ?>

<?php
// auth/logout.php
session_start();
require_once 'auth_functions.php';

// Logout user
logoutUser();
?>