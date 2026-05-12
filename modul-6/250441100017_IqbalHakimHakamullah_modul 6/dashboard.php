<?php 
require_once 'config.php';

if (!isLoggedIn()) {
    header('Location: index.php');
    exit();
}

// CREATE
if (isset($_POST['create'])) {
    $stmt = $pdo->prepare("INSERT INTO products (code, name, price, stock, description) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$_POST['code'], $_POST['name'], $_POST['price'], $_POST['stock'], $_POST['description']]);
    header('Location: dashboard.php');
    exit();
}

// UPDATE
if (isset($_POST['update'])) {
    $stmt = $pdo->prepare("UPDATE products SET code=?, name=?, price=?, stock=?, description=? WHERE id=?");
    $stmt->execute([$_POST['code'], $_POST['name'], $_POST['price'], $_POST['stock'], $_POST['description'], $_POST['id']]);
    header('Location: dashboard.php');
    exit();
}

// DELETE (hanya admin)
if (isset($_GET['delete']) && isAdmin()) {
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$_GET['delete']]);
    header('Location: dashboard.php');
    exit();
}

$products = $pdo->query("SELECT * FROM products ORDER BY id DESC")->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Manajemen Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .card {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(5px);
        }
        .btn-transition {
            transition: all 0.3s ease;
        }
        .btn-transition:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body class="p-6">
    <div class="max-w-7xl mx-auto">
        <div class="card rounded-xl shadow-lg p-4 mb-6 flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <h1 class="text-2xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                    Manajemen Produk
                </h1>
                <span class="px-3 py-1 bg-gray-200 rounded-full text-sm font-semibold">
                    <?= htmlspecialchars($_SESSION['role']) === 'admin' ? '👑 Admin' : '👤 User' ?>
                </span>
            </div>
            <div class="flex items-center space-x-4">
                <span class="text-gray-700">Halo, <strong><?= htmlspecialchars($_SESSION['username']) ?></strong></span>
                <?php if (!isAdmin()): ?>
                    <a href="setting_acc.php" class="text-gray-700 hover:text-purple-600">⚙️ Pengaturan Akun</a>
                <?php endif; ?>
                <?php if (isAdmin()): ?>
                    <a href="manage_users.php" class="text-gray-700 hover:text-purple-600">👥 Kelola User</a>
                <?php endif; ?>
                    <a href="logout.php" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-lg">Logout</a>
            </div>
        </div>

        <div class="card rounded-xl shadow-lg p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                <span class="bg-green-500 text-white rounded-full w-7 h-7 inline-flex items-center justify-center mr-2">+</span>
                Tambah Produk Baru
            </h2>
            <form method="POST" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <input type="text" name="code" placeholder="Kode Produk" 
                       class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500" required>
                <input type="text" name="name" placeholder="Nama Produk" 
                       class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500" required>
                <input type="number" name="price" placeholder="Harga" 
                       class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500" required>
                <input type="number" name="stock" placeholder="Stok" 
                       class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500" required>
                <input type="text" name="description" placeholder="Deskripsi" 
                       class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                <button type="submit" name="create" 
                        class="md:col-span-5 bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300 btn-transition">
                    + Simpan
                </button>
            </form>
        </div>
>
        <div class="card rounded-xl shadow-lg p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">📋 Daftar Produk</h2>
            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gradient-to-r from-purple-600 to-pink-600 text-white">
                            <th class="p-3 text-left">ID</th>
                            <th class="p-3 text-left">Kode</th>
                            <th class="p-3 text-left">Nama</th>
                            <th class="p-3 text-left">Harga</th>
                            <th class="p-3 text-left">Stok</th>
                            <th class="p-3 text-left">Deskripsi</th>
                            <th class="p-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($products) == 0): ?>
                            <tr>
                                <td colspan="7" class="text-center p-8 text-gray-500">Belum ada data produk. Silakan tambah produk di atas.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($products as $p): ?>
                            <form method="POST" class="contents">
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="p-3"><?= $p['id'] ?><input type="hidden" name="id" value="<?= $p['id'] ?>"></td>
                                    <td class="p-3"><input type="text" name="code" value="<?= htmlspecialchars($p['code']) ?>" class="w-full px-2 py-1 border rounded"></td>
                                    <td class="p-3"><input type="text" name="name" value="<?= htmlspecialchars($p['name']) ?>" class="w-full px-2 py-1 border rounded"></td>
                                    <td class="p-3"><input type="number" name="price" value="<?= $p['price'] ?>" class="w-28 px-2 py-1 border rounded"></td>
                                    <td class="p-3"><input type="number" name="stock" value="<?= $p['stock'] ?>" class="w-20 px-2 py-1 border rounded"></td>
                                    <td class="p-3"><input type="text" name="description" value="<?= htmlspecialchars($p['description']) ?>" class="w-full px-2 py-1 border rounded"></td>
                                    <td class="p-3 text-center whitespace-nowrap">
                                        <button type="submit" name="update" 
                                                class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm transition">
                                            Update
                                        </button>
                                        <?php if (isAdmin()): ?>
                                            <a href="?delete=<?= $p['id'] ?>" onclick="return confirm('Yakin hapus?')" 
                                               class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm ml-1 transition">
                                                Hapus
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            </form>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>