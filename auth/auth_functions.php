<?php
// auth/auth_functions.php
// File untuk fungsi-fungsi autentikasi

// Fungsi untuk registrasi user baru
function registerUser($conn, $username, $email, $password) {
    // Validasi input
    if (empty($username) || empty($email) || empty($password)) {
        return array('status' => false, 'message' => 'Semua field harus diisi');
    }
    
    // Validasi email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return array('status' => false, 'message' => 'Format email tidak valid');
    }
    
    // Validasi password (minimal 6 karakter)
    if (strlen($password) < 6) {
        return array('status' => false, 'message' => 'Password minimal 6 karakter');
    }
    
    // Cek apakah username sudah ada
    $check_username = "SELECT id FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $check_username);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    
    if (mysqli_stmt_num_rows($stmt) > 0) {
        return array('status' => false, 'message' => 'Username sudah digunakan');
    }
    
    // Cek apakah email sudah ada
    $check_email = "SELECT id FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $check_email);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    
    if (mysqli_stmt_num_rows($stmt) > 0) {
        return array('status' => false, 'message' => 'Email sudah digunakan');
    }
    
    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Insert user baru
    $insert_user = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $insert_user);
    mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashed_password);
    
    if (mysqli_stmt_execute($stmt)) {
        return array('status' => true, 'message' => 'Registrasi berhasil, silahkan login');
    } else {
        return array('status' => false, 'message' => 'Registrasi gagal: ' . mysqli_error($conn));
    }
}

// Fungsi untuk login user
function loginUser($conn, $username, $password) {
    // Validasi input
    if (empty($username) || empty($password)) {
        return array('status' => false, 'message' => 'Username dan password harus diisi');
    }
    
    // Cek user di database
    $sql = "SELECT id, username, password FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        
        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            // Password benar, buat session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            
            return array('status' => true, 'message' => 'Login berhasil');
        } else {
            return array('status' => false, 'message' => 'Password salah');
        }
    } else {
        return array('status' => false, 'message' => 'Username tidak ditemukan');
    }
}

// Fungsi untuk cek apakah user sudah login
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Fungsi untuk redirect jika user belum login
function requireLogin() {
    if (!isLoggedIn()) {
        $_SESSION['message'] = 'Silahkan login terlebih dahulu';
        $_SESSION['message_type'] = 'danger';
        header('Location: auth/login.php');
        exit();
    }
}

// Fungsi untuk logout user
function logoutUser() {
    // Hapus semua session
    session_unset();
    session_destroy();
    
    // Redirect ke halaman login
    header('Location: ../auth/login.php');
    exit();
}
?>