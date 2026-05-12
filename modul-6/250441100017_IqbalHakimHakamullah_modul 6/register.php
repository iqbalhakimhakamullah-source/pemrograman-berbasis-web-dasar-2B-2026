<?php 
require_once 'config.php';

if (isLoggedIn()) {
    header('Location: dashboard.php');
    exit();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm'] ?? '';
    
    if (empty($username) || empty($password)) {
        $error = 'Username dan password wajib diisi!';
    } elseif ($password !== $confirm) {
        $error = 'Password dan konfirmasi tidak cocok!';
    } elseif (strlen($password) < 3) {
        $error = 'Password minimal 3 karakter!';
    } else {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            $error = 'Username sudah terdaftar!';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, 'user')");
            if ($stmt->execute([$username, $hash])) {
                $success = 'Registrasi berhasil! Silakan <a href="index.php" class="underline font-bold">login</a>.';
            } else {
                $error = 'Registrasi gagal, coba lagi.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Register - Manajemen Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="flex items-center justify-center p-4">
    <div class="card rounded-2xl shadow-2xl p-8 w-96">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-2">Daftar Akun</h2>
        <p class="text-center text-gray-500 mb-6">Isi data di bawah ini</p>
        
        <?php if ($error): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded-lg mb-4 text-sm">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded-lg mb-4 text-sm">
                <?= $success ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" onsubmit="return validateForm()">
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Username</label>
                <input type="text" name="username" placeholder="Pilih username" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Password</label>
                <input type="password" name="password" id="password" placeholder="Minimal 3 karakter" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500" required>
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Konfirmasi Password</label>
                <input type="password" name="confirm" id="confirm" placeholder="Ulangi password" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500" required>
            </div>
            <button type="submit" class="btn-primary w-full bg-purple-600 text-white font-bold py-2 rounded-lg hover:bg-purple-700 transition duration-300">
                Daftar
            </button>
        </form>
        <p class="text-center text-gray-600 mt-6">
            Sudah punya akun? 
            <a href="index.php" class="text-purple-600 font-semibold hover:underline">Login</a>
        </p>
    </div>
    
    <script>
        function validateForm() {
            var pass = document.getElementById('password').value;
            var conf = document.getElementById('confirm').value;
            if (pass !== conf) {
                alert('Password tidak cocok!');
                return false;
            }
            if (pass.length < 3) {
                alert('Password minimal 3 karakter!');
                return false;
            }
            return true;
        }
    </script>
</body>
</html>