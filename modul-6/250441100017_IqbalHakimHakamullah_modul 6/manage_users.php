<?php
require_once 'config.php';
if (!isLoggedIn() || !isAdmin()) {
    header('Location: dashboard.php');
    exit();
}

$message = '';
$error = '';

if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $user_id = (int)$_GET['delete'];
    $stmt = $pdo->prepare("SELECT role FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch();
    if ($user && $user['role'] === 'user') {
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ? AND role = 'user'");
        $stmt->execute([$user_id]);
        $message = "User berhasil dihapus.";
    } else {
        $error = "Tidak dapat menghapus user tersebut (mungkin admin atau tidak ditemukan).";
    }
    header("Location: manage_users.php?message=" . urlencode($message) . "&error=" . urlencode($error));
    exit();
}

$message = $_GET['message'] ?? '';
$error = $_GET['error'] ?? '';

$users = $pdo->query("SELECT id, username, role, created_at FROM users ORDER BY created_at DESC")->fetchAll();

function formatTanggal($timestamp) {
    if (!$timestamp) return '-';
    $hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    $bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    $waktu = strtotime($timestamp);
    $nama_hari = $hari[date('w', $waktu)];
    $tanggal = date('j', $waktu);
    $bulan_indo = $bulan[date('n', $waktu)-1];
    $tahun = date('Y', $waktu);
    $jam = date('H:i', $waktu);
    return "$nama_hari, $tanggal $bulan_indo $tahun - $jam";
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Kelola User - Manajemen Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; }
        .card { background: rgba(255,255,255,0.95); backdrop-filter: blur(5px); }
    </style>
</head>
<body class="p-6">
    <div class="max-w-5xl mx-auto">
        <div class="card rounded-xl shadow-2xl p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Kelola Akun User</h1>
                <a href="dashboard.php" class="text-purple-600 hover:underline">← Kembali ke Dashboard</a>
            </div>
            <?php if ($message): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded-lg mb-4"><?= htmlspecialchars($message) ?></div>
            <?php endif; ?>
            <?php if ($error): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded-lg mb-4"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gradient-to-r from-purple-600 to-pink-600 text-white">
                            <th class="p-3 text-left">ID</th>
                            <th class="p-3 text-left">Username</th>
                            <th class="p-3 text-left">Role</th>
                            <th class="p-3 text-left">Dibuat</th>
                            <th class="p-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-3"><?= $user['id'] ?></td>
                            <td class="p-3"><?= htmlspecialchars($user['username']) ?></td>
                            <td class="p-3">
                                <span class="px-2 py-1 rounded text-xs <?= $user['role'] === 'admin' ? 'bg-red-200' : 'bg-blue-200' ?>">
                                    <?= $user['role'] ?>
                                </span>
                            </td>
                            <td class="p-3 text-sm"><?= formatTanggal($user['created_at']) ?></td>
                            <td class="p-3 text-center">
                                <?php if ($user['role'] === 'user'): ?>
                                    <a href="?delete=<?= $user['id'] ?>" onclick="return confirm('Yakin hapus user <?= htmlspecialchars($user['username']) ?>?')" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">Hapus</a>
                                <?php else: ?>
                                    <span class="text-gray-400 text-sm">Tidak bisa hapus admin</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>