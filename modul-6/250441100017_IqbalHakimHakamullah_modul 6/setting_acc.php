<?php
require_once 'config.php';

// Pastikan user sudah login dan BUKAN admin
if (!isLoggedIn() || isAdmin()) {
    header('Location: dashboard.php');
    exit();
}

$error = '';
$success_username = '';
$success_password = '';

// Proses update username
if (isset($_POST['update_username'])) {
    $new_username = trim($_POST['new_username']);
    $current_password = $_POST['current_password'];
    
    if (empty($new_username) || empty($current_password)) {
        $error = 'Semua field harus diisi untuk mengubah username.';
    } else {
        // Verifikasi password lama
        $stmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $user = $stmt->fetch();
        
        if (password_verify($current_password, $user['password'])) {
            // Cek apakah username baru sudah dipakai user lain
            $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? AND id != ?");
            $stmt->execute([$new_username, $_SESSION['user_id']]);
            if ($stmt->fetch()) {
                $error = 'Username sudah digunakan oleh pengguna lain.';
            } else {
                $stmt = $pdo->prepare("UPDATE users SET username = ? WHERE id = ?");
                $stmt->execute([$new_username, $_SESSION['user_id']]);
                $_SESSION['username'] = $new_username;
                $success_username = 'Username berhasil diubah.';
            }
        } else {
            $error = 'Password saat ini salah.';
        }
    }
}

// Proses update password
if (isset($_POST['update_password'])) {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    
    if (empty($old_password) || empty($new_password) || empty($confirm_password)) {
        $error = 'Semua field password harus diisi.';
    } elseif ($new_password !== $confirm_password) {
        $error = 'Password baru dan konfirmasi tidak cocok.';
    } elseif (strlen($new_password) < 3) {
        $error = 'Password minimal 3 karakter.';
    } else {
        $stmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $user = $stmt->fetch();
        
        if (password_verify($old_password, $user['password'])) {
            $new_hash = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
            $stmt->execute([$new_hash, $_SESSION['user_id']]);
            $success_password = 'Password berhasil diubah. Silakan login kembali.';
            // Optional: logout paksa agar user login dengan password baru
            session_destroy();
            header('Refresh: 2; url=index.php');
            echo '<div class="text-center text-green-600 font-bold">Password diubah, Anda akan dialihkan ke halaman login...</div>';
            exit();
        } else {
            $error = 'Password lama salah.';
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Pengaturan Akun - Manajemen Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; }
        .card { background: rgba(255,255,255,0.95); backdrop-filter: blur(5px); }
    </style>
</head>
<body class="p-6">
    <div class="max-w-2xl mx-auto">
        <div class="card rounded-xl shadow-2xl p-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Pengaturan Akun</h1>
                <a href="dashboard.php" class="text-purple-600 hover:underline">← Kembali ke Dashboard</a>
            </div>
            
            <?php if ($error): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded-lg mb-4"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <?php if ($success_username): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded-lg mb-4"><?= htmlspecialchars($success_username) ?></div>
            <?php endif; ?>
            <?php if ($success_password): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded-lg mb-4"><?= htmlspecialchars($success_password) ?></div>
            <?php endif; ?>
            
            <!-- Form Ganti Username -->
            <div class="mb-8 p-4 border rounded-lg">
                <h2 class="text-xl font-semibold mb-4">Ubah Username</h2>
                <form method="POST">
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Username Baru</label>
                        <input type="text" name="new_username" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-purple-500" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Password Saat Ini</label>
                        <input type="password" name="current_password" class="w-full px-3 py-2 border rounded-lg" required>
                    </div>
                    <button type="submit" name="update_username" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700">Update Username</button>
                </form>
            </div>
            
            <!-- Form Ganti Password -->
            <div class="p-4 border rounded-lg">
                <h2 class="text-xl font-semibold mb-4">Ubah Password</h2>
                <form method="POST">
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Password Lama</label>
                        <input type="password" name="old_password" class="w-full px-3 py-2 border rounded-lg" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Password Baru</label>
                        <input type="password" name="new_password" class="w-full px-3 py-2 border rounded-lg" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Konfirmasi Password Baru</label>
                        <input type="password" name="confirm_password" class="w-full px-3 py-2 border rounded-lg" required>
                    </div>
                    <button type="submit" name="update_password" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700">Update Password</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>