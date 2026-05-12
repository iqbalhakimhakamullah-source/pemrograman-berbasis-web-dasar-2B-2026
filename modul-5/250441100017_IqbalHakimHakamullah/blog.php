<?php
// Array daftar artikel
$artikel_list = [
    ["judul" => "Belajar HTML Pertama Kali", "slug" => "html-pertama", "tgl" => "15 Januari 2022"],
    ["judul" => "Error Pertama yang Bikin Frustasi", "slug" => "error-pertama", "tgl" => "20 Maret 2022"],
    ["judul" => "Membuat Website Portofolio", "slug" => "portofolio", "tgl" => "10 September 2023"],
    ["judul" => "Belajar PHP Dasar", "slug" => "php-dasar", "tgl" => "5 Februari 2024"]
];

// Konten artikel berdasarkan slug
$konten_artikel = [
    "html-pertama" => [
        "isi" => "Hari pertama belajar HTML, saya membuat halaman web sederhana berisi 'Halo Dunia!'. Rasanya sangat membanggakan meskipun hanya teks biasa. Saya belajar tentang tag heading, paragraf, dan gambar.",
        "gambar" => "img/html.jpg",
        "link" => "https://www.w3schools.com/html/"
    ],
    "error-pertama" => [
        "isi" => "Error pertama yang saya alami adalah lupa menutup tag HTML! Saya bingung kenapa tampilan berantakan. Setelah 2 jam debugging, ternyata hanya kurang tag penutup. Pelajaran berharga: selalu periksa tag dengan teliti.",
        "gambar" => "img/error.jpg",
        "link" => "https://developer.mozilla.org/id/docs/Learn/HTML"
    ],
    "portofolio" => [
        "isi" => "Membuat website portofolio pertama adalah momen yang tak terlupakan. Saya mendesain layout sederhana dengan CSS, menampilkan proyek-proyek saya, dan bangga ketika teman-teman memuji hasilnya.",
        "gambar" => "img/portofolio.jpg",
        "link" => "https://www.freecodecamp.org/news/how-to-build-a-developer-portfolio-website/"
    ],
    "php-dasar" => [
        "isi" => "Belajar PHP membuka wawasan saya tentang web dinamis. Saya belajar membuat form, koneksi database, dan CRUD sederhana. Meskipun tantangan banyak, tapi sangat seru!",
        "gambar" => "img/php.jpg",
        "link" => "https://www.w3schools.com/php/"
    ]
];

// Kutipan motivasi acak
$kutipan_motivasi = [
    " 'Kesalahan adalah bukti bahwa kamu sedang mencoba.'",
    " 'Jangan takut error, takutlah jika tidak belajar dari error.'",
    " 'Setiap expert pernah menjadi pemula.'",
    " 'Coding itu seperti olahraga, makin sering latihan makin jago.'",
    " 'Konsistensi lebih penting dari kecepatan.'"
];

$kutipan_acak = $kutipan_motivasi[array_rand($kutipan_motivasi)];

// Ambil artikel yang dipilih (GET)
$artikel_terpilih = $_GET['artikel'] ?? '';
$detail_artikel = null;
$judul_terpilih = "";
$tgl_terpilih = "";

if($artikel_terpilih && isset($konten_artikel[$artikel_terpilih])) {
    foreach($artikel_list as $artikel) {
        if($artikel['slug'] == $artikel_terpilih) {
            $judul_terpilih = $artikel['judul'];
            $tgl_terpilih = $artikel['tgl'];
            break;
        }
    }
    $detail_artikel = $konten_artikel[$artikel_terpilih];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Blog Developer</title>
    <style>
        body { font-family: Arial; margin: 30px; background: #f0f2f5; }
        .container { max-width: 1000px; margin: 0 auto; background: white; padding: 25px; border-radius: 15px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h1 { text-align: center; color: #2c3e50; }
        .blog-wrapper { display: flex; gap: 25px; margin-top: 20px; }
        .sidebar { width: 250px; background: #f8f9fa; padding: 15px; border-radius: 10px; }
        .sidebar ul { list-style: none; padding: 0; }
        .sidebar li { margin: 12px 0; }
        .sidebar a { text-decoration: none; color: #3498db; display: block; padding: 8px; border-radius: 5px; }
        .sidebar a:hover { background: #e3f2fd; }
        .content { flex: 1; }
        .kutipan { background: #fff3e0; padding: 12px 18px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #ff9800; }
        .gambar-artikel { max-width: 100%; border-radius: 8px; margin: 15px 0; }
        .nav { text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #ddd; }
        .nav a { margin: 0 10px; text-decoration: none; background: #2c3e50; color: white; padding: 8px 15px; border-radius: 5px; }
        .artikel-box { background: #f8f9fa; padding: 20px; border-radius: 10px; }
    </style>
</head>
<body>
<div class="container">
    <h1> Blog Reflektif Developer</h1>
    
    <div class="blog-wrapper">
        <div class="sidebar">
            <h3> Daftar Artikel</h3>
            <ul>
                <?php foreach($artikel_list as $artikel): ?>
                <li>
                    <a href="?artikel=<?php echo $artikel['slug']; ?>">
                         <?php echo $artikel['judul']; ?>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="content">
            <div class="kutipan">
                 <strong>Kutipan Hari Ini:</strong> <?php echo $kutipan_acak; ?>
            </div>

            <?php if($detail_artikel): ?>
                <div class="artikel-box">
                    <h2><?php echo $judul_terpilih; ?></h2>
                    <p style="color: #888; font-size: 14px;"> Diposting: <?php echo $tgl_terpilih; ?></p>
                    
                    <p><?php echo $detail_artikel['isi']; ?></p>
                    
                    <img src="<?php echo $detail_artikel['gambar']; ?>" alt="Ilustrasi" class="gambar-artikel" 
                         onerror="this.src='https://via.placeholder.com/400x200?text=Gambar+Ilustrasi'">
                    
                    <p> <strong>Link Referensi:</strong> 
                        <a href="<?php echo $detail_artikel['link']; ?>" target="_blank">Klik untuk belajar lebih lanjut</a>
                    </p>
                </div>
            <?php else: ?>
                <div style="text-align: center; padding: 50px; background: #f8f9fa; border-radius: 10px; color: #888;">
                    <p> Klik judul artikel di samping untuk membaca refleksi pengalaman coding.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="nav">
        <a href="index.php"> Kembali ke Profil</a>
        <a href="timeline.php"> Timeline Belajar</a>
    </div>
</div>

</body>
</html>