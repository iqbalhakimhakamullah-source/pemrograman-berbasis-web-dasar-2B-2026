
<?php
$pdo = new PDO('mysql:host=localhost;dbname=praktikum_db;charset=utf8', 'root', '');
$stmt = $pdo->query("SELECT username, password FROM users LIMIT 1");
$row = $stmt->fetch();

echo "Hash untuk password '123' di komputer Anda adalah:<br>";
echo "<textarea rows='3' cols='80'>" . $row['password'] . "</textarea>";
?>