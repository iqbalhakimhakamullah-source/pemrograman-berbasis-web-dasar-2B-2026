<?php
// File ini cukup dijalankan SEKALI untuk membuat database dan akun

$pdo = new PDO('mysql:host=localhost;charset=utf8', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Hapus database lama jika ada
$pdo->exec("DROP DATABASE IF EXISTS praktikum_db");

// Buat database baru
$pdo->exec("CREATE DATABASE praktikum_db");
$pdo->exec("USE praktikum_db");

// Tabel users
$pdo->exec("
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') DEFAULT 'user'
)");

// Tabel products (minimal 5 kolom: code, name, price, stock, description)
$pdo->exec("
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(20) NOT NULL,
    name VARCHAR(100) NOT NULL,
    price INT NOT NULL,
    stock INT NOT NULL,
    description TEXT
)");

// Hash untuk password '123' (SUDAH PASTI BENAR)
$hash = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';

// Insert akun
$stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES ('admin', ?, 'admin'), ('user', ?, 'user')");
$stmt->execute([$hash, $hash]);

// Insert contoh data products
$pdo->exec("
INSERT INTO products (code, name, price, stock, description) VALUES
('B001', 'Belajar PHP Dasar', 75000, 10, 'Buku PHP untuk pemula'),
('B002', 'Database MySQL', 85000, 5, 'Panduan database MySQL'),
('B003', 'JavaScript Modern', 90000, 7, 'ES6 dan seterusnya')
");

echo "<!DOCTYPE html>
<html>
<head>
    <title>Setup Berhasil</title>
    <style>
        body { font-family: Arial; text-align: center; padding: 50px; }
        .success { background: #d4edda; color: #155724; padding: 20px; border-radius: 10px; display: inline-block; }
        button { background: blue; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; }
        button:hover { background: darkblue; }
    </style>
</head>
<body>
    <div class='success'>
        <h2>✅ DATABASE DAN AKUN BERHASIL DIBUAT!</h2>
        <p><strong>Username:</strong> admin | user</p>
        <p><strong>Password:</strong> 123 (untuk kedua akun)</p>
        <a href='index.php'><button>🔐 Login Sekarang</button></a>
    </div>
</body>
</html>";
?>