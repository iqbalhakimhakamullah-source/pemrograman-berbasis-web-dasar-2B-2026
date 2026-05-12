<?php
// Fungsi kustom untuk memproses dan menampilkan data
function tampilkanProfil($data) {
    echo "<div style='background:#e9f7fe; padding:15px; border-radius:10px; margin-top:20px;'>";
    echo "<h3>Hasil Profil Developer:</h3>";
    echo "<table border='1' cellpadding='8' cellspacing='0' style='border-collapse:collapse; width:100%'>";
    foreach($data as $key => $value) {
        if($key != 'pengalaman' && $key != 'tools_penunjang') {
            echo "<tr><td width='200'><strong>$key</strong></td><td>$value</td></tr>";
        }
    }
    echo "<tr><td><strong>Tools Penunjang</strong></td><td>" . implode(", ", $data['tools_penunjang']) . "</td></tr>";
    echo "</table>";
    
    echo "<div style='margin-top:15px;'><strong>Pengalaman:</strong><br>" . nl2br($data['pengalaman']) . "</div>";
    echo "</div>";
}

$hasil_data = null;
$pesan = "";

// Data statis (tidak bisa diubah pengguna)
$nama        = "Iqbal Hakim Hakamullah";
$id_developer = "250441100017";
$kota_lahir  = "Sampang, 30 Desember 2007";
$email       = "iqbalhakimhakamullah@gmail.com";
$wa          = "0838-7769-5584";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $framework = trim($_POST['framework'] ?? '');
    $pengalaman = trim($_POST['pengalaman'] ?? '');
    $minat = $_POST['minat'] ?? '';
    $skill = $_POST['skill'] ?? '';
    $tools = $_POST['tools'] ?? [];
    
    // Validasi input wajib (yang statis sudah pasti terisi)
    if(empty($framework) || empty($pengalaman) || empty($minat) || empty($skill)) {
        $pesan = "<div style='color:red; background:#ffe0e0; padding:10px; border-radius:5px;'> Semua input wajib diisi!</div>";
    } else {
        // Proses explode untuk framework
        $arr_framework = explode(",", $framework);
        $framework_bersih = array_map('trim', $arr_framework);
        
        // Cek jumlah framework
        if(count($framework_bersih) > 2) {
            $pesan = "<div style='color:blue; background:#e0f0ff; padding:10px; border-radius:5px;'> Skill Anda cukup luas di bidang development!</div>";
        } else {
            $pesan = "<div style='color:green; background:#e0ffe0; padding:10px; border-radius:5px;'> Data berhasil disimpan!</div>";
        }
        
        $hasil_data = [
            'Nama' => $nama,
            'ID Developer' => $id_developer,
            'Kota/Tgl Lahir' => $kota_lahir,
            'Email' => $email,
            'No WhatsApp' => $wa,
            'Framework/Tools' => implode(", ", $framework_bersih),
            'Minat Bidang' => $minat,
            'Tingkat Skill' => $skill,
            'tools_penunjang' => $tools,
            'pengalaman' => $pengalaman
        ];
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profil Developer</title>
    <style>
        body { font-family: Arial; margin: 30px; background: #f0f2f5; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 25px; border-radius: 15px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h1 { text-align: center; color: #2c3e50; margin-bottom: 25px; }
        .form-group { margin-bottom: 20px; }
        label { display: inline-block; width: 180px; font-weight: bold; }
        input, select, textarea { padding: 8px; width: 300px; border: 1px solid #ddd; border-radius: 5px; }
        .static-value { display: inline-block; padding: 8px 10px; color: #2c3e50; font-weight: 500; background: #f4f6f8; border-radius: 5px; border: 1px solid #ddd; min-width: 200px; }
        button { background: #3498db; color: white; padding: 10px 25px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; margin-top: 10px; }
        button:hover { background: #2980b9; }
        .nav { margin-top: 30px; text-align: center; }
        .nav a { margin: 0 10px; text-decoration: none; background: #2c3e50; color: white; padding: 8px 15px; border-radius: 5px; }
        
        .checkbox-group, .radio-group { 
            display: flex; 
            align-items: flex-start; 
            margin-bottom: 20px;
        }
        
        .checkbox-group .group-label, 
        .radio-group .group-label { 
            display: inline-block; 
            width: 150px; 
            font-weight: bold; 
            flex-shrink: 0; 
            padding-top: 5px;
        }
        
        .checkbox-options, 
        .radio-options { 
            display: flex; 
            flex-wrap: wrap; 
            gap: 10px; 
            flex: 1;
        }
        
        .checkbox-options label, 
        .radio-options label { 
            width: auto; 
            font-weight: normal; 
            display: inline-flex; 
            align-items: center; 
            gap: 8px; 
            cursor: pointer;
            margin: 0;
            padding: 5px 0;
        }
        
        .form-group:last-of-type {
            margin-bottom: 20px;
        }
        
        textarea {
            width: 300px;
            font-family: Arial;
        }
    </style>
</head>
<body>
<div class="container">
    <h1> Profil Interaktif Developer Pemula</h1>
    
    <?php echo $pesan; ?>
    
    <form method="POST">
        <div class="form-group">
            <label>Nama Lengkap:</label>
            <span class="static-value"><?php echo htmlspecialchars($nama); ?></span>
        </div>
        <div class="form-group">
            <label>ID Developer:</label>
            <span class="static-value"><?php echo htmlspecialchars($id_developer); ?></span>
        </div>
        <div class="form-group">
            <label>Kota/Tgl Lahir:</label>
            <span class="static-value"><?php echo htmlspecialchars($kota_lahir); ?></span>
        </div>
        <div class="form-group">
            <label>Email:</label>
            <span class="static-value"><?php echo htmlspecialchars($email); ?></span>
        </div>
        <div class="form-group">
            <label>No WhatsApp:</label>
            <span class="static-value"><?php echo htmlspecialchars($wa); ?></span>
        </div>
        <div class="form-group">
            <label>Framework/Tools (pisah koma):</label>
            <input type="text" name="framework" placeholder="Contoh: Bootstrap, React, Vue" required>
        </div>
        
        <!-- Tools Penunjang dengan margin rapi -->
        <div class="checkbox-group">
            <span class="group-label">Tools Penunjang:</span>
            <div class="checkbox-options">
                <label><input type="checkbox" name="tools[]" value="VS Code"> VS Code</label>
                <label><input type="checkbox" name="tools[]" value="GitHub"> GitHub</label>
                <label><input type="checkbox" name="tools[]" value="Figma"> Figma</label>
                <label><input type="checkbox" name="tools[]" value="Postman"> Postman</label>
            </div>
        </div>
        
        <!-- Minat Bidang dengan margin rapi -->
        <div class="radio-group">
            <span class="group-label">Minat Bidang:</span>
            <div class="radio-options">
                <label><input type="radio" name="minat" value="Frontend" required> Frontend</label>
                <label><input type="radio" name="minat" value="Backend"> Backend</label>
                <label><input type="radio" name="minat" value="Fullstack"> Fullstack</label>
            </div>
        </div>
        
        <div class="form-group">
            <label>Tingkat Skill:</label>
            <select name="skill" required>
                <option value="">Pilih</option>
                <option>Dasar</option>
                <option>Cukup</option>
                <option>Profesional</option>
            </select>
        </div>
        <div class="form-group">
            <label>Cerita Pengalaman:</label>
            <textarea name="pengalaman" rows="4" cols="40" placeholder="Ceritakan pengalaman membuat aplikasi/website..." required></textarea>
        </div>
        <button type="submit">Simpan Profil</button>
    </form>
    
    <?php
    if($hasil_data) {
        tampilkanProfil($hasil_data);
    }
    ?>
    
    <div class="nav">
        <a href="timeline.php"> Timeline Belajar</a>
        <a href="blog.php"> Blog Developer</a>
    </div>
</div>
</body>
</html>