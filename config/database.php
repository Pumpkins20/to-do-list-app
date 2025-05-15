<?php
// config/database.php
// File untuk konfigurasi dan koneksi ke database

// Parameter koneksi database
$host = "localhost"; // Hostname database
$username = "root";  // Username MySQL (ubah sesuai konfigurasi)
$password = "";      // Password MySQL (ubah sesuai konfigurasi)
$db_name = "to-do-list"; // Nama database

// Membuat koneksi
$conn = mysqli_connect($host, $username, $password, $db_name);

// Cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Set karakter encoding
mysqli_set_charset($conn, "utf8");

// Fungsi untuk membersihkan input (mencegah SQL injection)
function clean($conn, $data) {
    return mysqli_real_escape_string($conn, htmlspecialchars(trim($data)));
}

// Script untuk membuat database dan tabel (berjalan hanya sekali saat pertama kali setup)
function setupDatabase($conn) {
    // SQL untuk membuat tabel users
    $sql_create_users = "CREATE TABLE IF NOT EXISTS users (
        id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        email VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";

    // SQL untuk membuat tabel tasks
    $sql_create_tasks = "CREATE TABLE IF NOT EXISTS tasks (
        id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        user_id INT(11) NOT NULL,
        title VARCHAR(255) NOT NULL,
        description TEXT,
        status ENUM('pending', 'completed') DEFAULT 'pending',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    )";

    // Eksekusi pembuatan tabel
    if (mysqli_query($conn, $sql_create_users)) {
        echo "Tabel users berhasil dibuat.<br>";
    } else {
        echo "Error membuat tabel users: " . mysqli_error($conn) . "<br>";
    }

    if (mysqli_query($conn, $sql_create_tasks)) {
        echo "Tabel tasks berhasil dibuat.<br>";
    } else {
        echo "Error membuat tabel tasks: " . mysqli_error($conn) . "<br>";
    }
}

// Uncomment baris di bawah untuk menjalankan setup database pada pertama kali
setupDatabase($conn);
?>