<?php
// index.php
session_start();

// Jika user sudah login, redirect ke dashboard
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit();
}

include_once 'includes/header.php';
?>

<div class="card">
    <h2>Selamat Datang di TaskMaster!</h2>
    <p>TaskMaster adalah aplikasi to-do list sederhana yang membantu Anda mengatur tugas harian. Untuk mulai menggunakan aplikasi ini, silahkan login atau register terlebih dahulu.</p>
    <div style="margin-top: 20px;">
        <a href="auth/login.php" class="btn">Login</a>
        <a href="auth/register.php" class="btn" style="margin-left: 10px;">Register</a>
    </div>
</div>

<?php include_once 'includes/footer.php'; ?>