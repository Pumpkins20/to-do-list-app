<?php
// auth/register.php
// Halaman untuk registrasi user baru

session_start();

// Redirect ke dashboard jika sudah login
if (isset($_SESSION['user_id'])) {
    header("Location: ../dashboard.php");
    exit();
}

// Include files yang diperlukan
require_once('../config/database.php');
require_once('auth_functions.php');

$error = '';
$success = '';

// Jika form di-submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    // Validasi password sama
    if ($password !== $confirm_password) {
        $error = 'Password dan konfirmasi password tidak cocok';
    } else {
        // Coba registrasi user
        $result = registerUser($conn, $name, $email, $password);
        
        if ($result['status']) {
            $success = $result['message'];
            // Redirect ke login setelah 2 detik
            header("refresh:2;url=login.php");
        } else {
            $error = $result['message'];
        }
    }
}

// Include header
include('../includes/header.php');
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Daftar Akun Baru</h4>
                </div>
                <div class="card-body">
                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>
                    
                    <?php if (!empty($success)): ?>
                        <div class="alert alert-success"><?php echo $success; ?></div>
                    <?php endif; ?>
                    
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" minlength="6" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Konfirmasi Password</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" minlength="6" required>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Daftar</button>
                        </div>
                    </form>
                    
                    <div class="mt-3 text-center">
                        Sudah punya akun? <a href="login.php">Login di sini</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('../includes/footer.php'); ?>