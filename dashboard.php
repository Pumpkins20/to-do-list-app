<?php
// dashboard.php
session_start();

// Include koneksi database dan fungsi
require_once 'config/database.php';
require_once 'auth/auth_functions.php';
require_once 'tasks/task_functions.php';

// Cek apakah user sudah login
requireLogin();

// Ambil data user yang sedang login
$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

// Ambil semua task milik user
$tasks = getUserTasks($conn, $user_id);

include_once 'includes/header.php';
?>

<div class="card">
    <h2>Dashboard</h2>
    <p>Selamat datang, <strong><?php echo htmlspecialchars($username); ?></strong>!</p>
    
    <!-- Form untuk menambahkan task baru -->
    <h3 style="margin-top: 20px;">Tambah Task Baru</h3>
    <form action="tasks/create.php" method="post" class="task-add-form">
        <input type="text" name="title" placeholder="Masukkan judul task..." required>
        <button type="submit">Tambah</button>
    </form>
    
    <!-- Daftar task -->
    <h3 style="margin-top: 20px;">Daftar Task</h3>
    <?php if (empty($tasks)) : ?>
        <p>Belum ada task. Silahkan tambahkan task baru.</p>
    <?php else : ?>
        <table>
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tasks as $task) : ?>
                    <tr>
                        <td class="<?php echo ($task['status'] == 'completed') ? 'task-completed' : ''; ?>">
                            <?php echo htmlspecialchars($task['title']); ?>
                        </td>
                        <td>
                            <?php echo ($task['status'] == 'completed') ? 'Selesai' : 'Belum Selesai'; ?>
                        </td>
                        <td>
                            <?php echo date('d-m-Y H:i', strtotime($task['created_at'])); ?>
                        </td>
                        <td class="task-actions">
                            <a href="tasks/edit.php?id=<?php echo $task['id']; ?>" class="btn btn-warning">Edit</a>
                            <a href="tasks/mark_complete.php?id=<?php echo $task['id']; ?>" class="btn <?php echo ($task['status'] == 'completed') ? 'btn-warning' : 'btn-success'; ?>">
                                <?php echo ($task['status'] == 'completed') ? 'Tandai Belum Selesai' : 'Tandai Selesai'; ?>
                            </a>
                            <a href="tasks/delete.php?id=<?php echo $task['id']; ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus task ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?php include_once 'includes/footer.php'; ?>


