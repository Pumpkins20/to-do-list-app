<!-- includes/header.php -->
<?php
// Memulai session
//session_start();

// Cek apakah ada pesan
$alert_message = '';
if (isset($_SESSION['message'])) {
    $alert_type = isset($_SESSION['message_type']) ? $_SESSION['message_type'] : 'success';
    $alert_message = '<div class="alert alert-' . $alert_type . '">' . $_SESSION['message'] . '</div>';
    // Hapus pesan setelah ditampilkan
    unset($_SESSION['message']);
    unset($_SESSION['message_type']);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskMaster - Aplikasi To-Do List</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f5f5;
            color: #333;
            line-height: 1.6;
        }
        
        .container {
            width: 90%;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        
        header {
            background-color: #4834d4;
            color: white;
            padding: 15px 0;
            margin-bottom: 30px;
        }
        
        header .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        header h1 {
            font-size: 24px;
        }
        
        nav a {
            color: white;
            text-decoration: none;
            margin-left: 15px;
            transition: color 0.3s;
        }
        
        nav a:hover {
            color: #ccc;
        }
        
        .card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 25px;
            margin-bottom: 30px;
        }
        
        .card h2 {
            margin-bottom: 20px;
            color: #333;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }
        
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        
        button, .btn {
            background-color: #4834d4;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
            display: inline-block;
            text-decoration: none;
        }
        
        button:hover, .btn:hover {
            background-color: #352a9d;
        }
        
        .btn-danger {
            background-color: #e74c3c;
        }
        
        .btn-danger:hover {
            background-color: #c0392b;
        }
        
        .btn-success {
            background-color: #2ecc71;
        }
        
        .btn-success:hover {
            background-color: #27ae60;
        }
        
        .btn-warning {
            background-color: #f39c12;
        }
        
        .btn-warning:hover {
            background-color: #e67e22;
        }
        
        .alert {
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        table th, table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        
        table th {
            background-color: #f9f9f9;
        }
        
        .task-actions {
            display: flex;
            gap: 5px;
        }
        
        .task-completed {
            text-decoration: line-through;
            color: #888;
        }
        
        .task-add-form {
            display: flex;
            margin-bottom: 20px;
        }
        
        .task-add-form input {
            flex: 1;
            margin-right: 10px;
        }

        footer {
            text-align: center;
            margin-top: 50px;
            padding: 15px 0;
            color: #888;
            font-size: 14px;
        }

        @media (max-width: 768px) {
            .task-actions {
                flex-direction: column;
                gap: 5px;
            }
            
            .task-actions .btn {
                width: 100%;
                text-align: center;
                margin-bottom: 5px;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <h1>TaskMaster</h1>
            <nav>
                <?php if(isset($_SESSION['user_id'])): ?>
                    <a href="<?php echo isset($base_path) ? $base_path : ''; ?>dashboard.php">Dashboard</a>
                    <a href="<?php echo isset($base_path) ? $base_path : ''; ?>auth/logout.php">Logout</a>
                <?php else: ?>
                    <a href="<?php echo isset($base_path) ? $base_path : ''; ?>index.php">Home</a>
                    <a href="<?php echo isset($base_path) ? $base_path : ''; ?>auth/login.php">Login</a>
                    <a href="<?php echo isset($base_path) ? $base_path : ''; ?>auth/register.php">Register</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <div class="container">
        <?php echo $alert_message; ?>
