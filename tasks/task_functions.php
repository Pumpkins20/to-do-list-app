<?php
// tasks/task_functions.php
// File untuk fungsi-fungsi pengelolaan task

// Fungsi untuk menambahkan task baru
function addTask($conn, $user_id, $title, $description = '') {
    // Validasi input
    if (empty($title)) {
        return array('status' => false, 'message' => 'Judul task tidak boleh kosong');
    }
    
    // Insert task baru
    $sql = "INSERT INTO tasks (user_id, title, description) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iss", $user_id, $title, $description);
    
    if (mysqli_stmt_execute($stmt)) {
        return array('status' => true, 'message' => 'Task berhasil ditambahkan');
    } else {
        return array('status' => false, 'message' => 'Gagal menambahkan task: ' . mysqli_error($conn));
    }
}

// Fungsi untuk mengambil semua task milik user tertentu
function getUserTasks($conn, $user_id) {
    $sql = "SELECT * FROM tasks WHERE user_id = ? ORDER BY created_at DESC";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    $tasks = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $tasks[] = $row;
    }
    
    return $tasks;
}

// Fungsi untuk mengambil detail task berdasarkan ID
function getTaskById($conn, $task_id, $user_id) {
    $sql = "SELECT * FROM tasks WHERE id = ? AND user_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $task_id, $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if (mysqli_num_rows($result) == 1) {
        return mysqli_fetch_assoc($result);
    } else {
        return false;
    }
}

// Fungsi untuk update task
function updateTask($conn, $task_id, $user_id, $title, $description = '') {
    // Validasi input
    if (empty($title)) {
        return array('status' => false, 'message' => 'Judul task tidak boleh kosong');
    }
    
    // Cek apakah task milik user tersebut
    $task = getTaskById($conn, $task_id, $user_id);
    if (!$task) {
        return array('status' => false, 'message' => 'Task tidak ditemukan');
    }
    
    // Update task
    $sql = "UPDATE tasks SET title = ?, description = ? WHERE id = ? AND user_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssii", $title, $description, $task_id, $user_id);
    
    if (mysqli_stmt_execute($stmt)) {
        return array('status' => true, 'message' => 'Task berhasil diupdate');
    } else {
        return array('status' => false, 'message' => 'Gagal mengupdate task: ' . mysqli_error($conn));
    }
}

// Fungsi untuk menghapus task
function deleteTask($conn, $task_id, $user_id) {
    // Cek apakah task milik user tersebut
    $task = getTaskById($conn, $task_id, $user_id);
    if (!$task) {
        return array('status' => false, 'message' => 'Task tidak ditemukan');
    }
    
    // Hapus task
    $sql = "DELETE FROM tasks WHERE id = ? AND user_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $task_id, $user_id);
    
    if (mysqli_stmt_execute($stmt)) {
        return array('status' => true, 'message' => 'Task berhasil dihapus');
    } else {
        return array('status' => false, 'message' => 'Gagal menghapus task: ' . mysqli_error($conn));
    }
}

// Fungsi untuk mengubah status task
function toggleTaskStatus($conn, $task_id, $user_id) {
    // Cek apakah task milik user tersebut
    $task = getTaskById($conn, $task_id, $user_id);
    if (!$task) {
        return array('status' => false, 'message' => 'Task tidak ditemukan');
    }
    
    // Toggle status
    $new_status = ($task['status'] == 'pending') ? 'completed' : 'pending';
    $message = ($new_status == 'completed') ? 'Task ditandai selesai' : 'Task ditandai belum selesai';
    
    // Update status
    $sql = "UPDATE tasks SET status = ? WHERE id = ? AND user_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sii", $new_status, $task_id, $user_id);
    
    if (mysqli_stmt_execute($stmt)) {
        return array('status' => true, 'message' => $message);
    } else {
        return array('status' => false, 'message' => 'Gagal mengubah status task: ' . mysqli_error($conn));
    }
}