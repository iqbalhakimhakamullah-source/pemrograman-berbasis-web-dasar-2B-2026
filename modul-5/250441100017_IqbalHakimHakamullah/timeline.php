<?php
// Array asosiatif riwayat belajar (minimal 5 data)
$riwayat_belajar = [
    ["tahun" => "2025", "event" => " Masuk kuliah Sistem Informasi"],
    ["tahun" => "2025", "event" => " Belajar HTML & CSS pertama kali"],
    ["tahun" => "2026", "event" => " Belajar JavaScript & PHP dasar"],
    ["tahun" => "2026", "event" => " Membuat website portofolio pertama"],
    ["tahun" => "2026", "event" => " disini letak pusingnya"]
];

// Fungsi untuk memberi penekanan pada tahun tertentu
function beriPenekanan($tahun) {
    if($tahun == "2022" || $tahun == "2024") {
        return "<strong style='color:#e67e22; font-size:18px'>✨ $tahun</strong>";
    }
    return "<strong>$tahun</strong>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Timeline Belajar Coding</title>
    <style>
        body { font-family: Arial; margin: 30px; background: #f0f2f5; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 25px; border-radius: 15px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h1 { text-align: center; color: #2c3e50; }
        .timeline {
            position: relative;
            margin: 30px 0;
        }
        .timeline::before {
            content: '';
            position: absolute;
            width: 3px;
            background: #3498db;
            top: 0;
            bottom: 0;
            left: 20px;
        }
        .timeline-item {
            position: relative;
            margin-bottom: 30px;
            padding-left: 60px;
        }
        .timeline-item .tahun {
            position: absolute;
            left: 0;
            width: 45px;
            background: #3498db;
            color: white;
            text-align: center;
            padding: 5px;
            border-radius: 8px;
        }
        .timeline-item .konten {
            background: #f8f9fa;
            padding: 12px 18px;
            border-radius: 10px;
            border-left: 4px solid #3498db;
        }
        .nav {
            text-align: center;
            margin-top: 30px;
        }
        .nav a {
            margin: 0 10px;
            text-decoration: none;
            background: #2c3e50;
            color: white;
            padding: 8px 15px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1> Timeline Perjalanan Belajar Coding</h1>
    
    <div class="timeline">
        <?php foreach($riwayat_belajar as $item): ?>
        <div class="timeline-item">
            <div class="tahun">
                <?php echo beriPenekanan($item['tahun']); ?>
            </div>
            <div class="konten">
                <?php echo $item['event']; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    
    <div class="nav">
        <a href="index.php"> Kembali ke Profil</a>
        <a href="blog.php">Menuju Blog Developer ▶</a>
    </div>
</div>
</body>
</html>