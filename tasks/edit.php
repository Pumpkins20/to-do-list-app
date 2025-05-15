<?php
// tasks/edit.php
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

// Ambil data task
$task = getTaskById($conn, $task_id, $user_id);

// Jika task tidak ditemukan, redirect ke dashboard
if (!$task) {
    $_SESSION['message'] = 'Task tidak ditemukan';
    $_SESSION['message_type'] = 'danger';
    header('Location: ../dashboard.php');
    exit();
}

// Proses form edit task
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = clean($conn, $_POST['title']);
    $description = clean($conn, $_POST['description']);
    
    $result = updateTask($conn, $task_id, $user_id, $title, $description);
    
    $_SESSION['message'] = $result['message'];
    $_SESSION['message_type'] = $result['status'] ? 'success' : 'danger';
    
    if ($result['status']) {
        header('Location: ../dashboard.php');
        exit();
    }
}

$base_path = '../';
include_once '../includes/header.php';
?>

<div class="card">
    <h2>Edit Task</h2>
    <form action="" method="post">
        <div class="form-group">
            <label for="title">Judul</label>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($task['title']); ?>" required>
        </div>
        <div class="form-group">
            <label for="description">Deskripsi</label>
            <input type="text" id="description" name="description" value="<?php echo htmlspecialchars($task['description']); ?>">
        </div>
        <button type="submit">Simpan</button>
        <a href="../dashboard.php" class="btn" style="margin-left: 10px;">Batal</a>
    </form>
</div>

<?php include_once '../includes/footer.php'; ?>
