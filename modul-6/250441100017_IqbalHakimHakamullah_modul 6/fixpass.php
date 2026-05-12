<?php
$pdo = new PDO('mysql:host=localhost;dbname=praktikum_db;charset=utf8', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Hash baru untuk password '123' yang benar
$hash_baru = password_hash('123', PASSWORD_DEFAULT);

// Update semua user
$stmt = $pdo->prepare("UPDATE users SET password = ?");
$stmt->execute([$hash_baru]);

echo "<h2>✅ Password semua user sudah direset ke '123'</h2>";
echo "Hash yang baru: " . $hash_baru . "<br>";
echo "<a href='index.php'>Kembali ke Login</a>";
?>