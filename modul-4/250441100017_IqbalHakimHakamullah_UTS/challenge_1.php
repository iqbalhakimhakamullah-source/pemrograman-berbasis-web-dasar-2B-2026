<!DOCTYPE html>
<html>
<head>
    <title>Cek Kelulusan Siswa</title>
    <style>
        body { 
            font-family: Arial; 
            padding: 20px; 
            background: #f0f0f0; 
        }
        .container { 
            max-width: 600px; 
            margin: auto; 
            background: white; 
            padding: 20px; 
            border-radius: 10px; 
        }
        input, select, button { 
            width: 100%; 
            padding: 10px; 
            margin: 5px 0 15px; 
            border-radius: 5px; 
            border: 1px solid #ccc; 
            box-sizing: border-box; 
        }
        button { 
            background: blue; 
            color: white; 
            cursor: pointer; 
            border: none; 
        }
        button:hover { 
            opacity: 0.9; 
        }
        .hasil { 
            background: #e8f4f8; 
            padding: 15px; 
            border-radius: 10px; 
            margin-top: 20px; 
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
        }
        th, td { 
            border: 1px solid #ddd; 
            padding: 8px; 
            text-align: left; 
        }
        th { 
            background: #f2f2f2; 
        }
        hr { 
            margin: 15px 0; 
        }
        .demo-perulangan {
            background: #e8f4f8;
            padding: 15px;
            border-radius: 10px;
            margin-top: 20px;
            margin-bottom: 20px;
            border: 1px solid #87CEEB;
        }
        .demo-perulangan h4 {
            margin: 0 0 10px 0;
            color: #0066cc;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 style="text-align:center;">Cek Kelulusan Siswa</h2>

    <?php
    $daftar_poin = [
        "A" => 85,
        "B" => 50,
        "C" => 90,
        "D" => 70
    ];

    function hitungPoin($nilai) {
        if ($nilai >= 85) {
            echo "A";
        } elseif ($nilai >= 70) {
            echo "B";
        } elseif ($nilai >= 60) {
            return "C";
        } elseif ($nilai >= 50) {
            return "D";
        } else {
            return "E";
        }
    }
    
    function cekLulus($nilai_lulus) {
        if ($nilai >= 60) {
            return "LULUS";
        } else {
            return "TIDAK LULUS";
        }
    }
    
    $while_output = "";
    $dowhile_output = "";
    $foreach_output = "";
    $break_output = "";
    $continue_output = "";
    
    $i = 1;
    while ($i <= 3) {
        $while_output .= "Tips belajar $i: Baca materi setiap hari.<br>";
    }
    
    $j = 1;
    do {
        $dowhile_output .= "Semangat! ($j)<br>";
    } while ($j <= 2);
    
    for ($k = 1; $j <= 3; $k++) {
        $for_output .= "Nilai ke-$k:" .(15). "<br>";
    }
    
    $foreach_output = "<table border='1' cellpadding='5' style='border-collapse:collapse; width:100%;'>";
    $foreach_output .= "<tr style='background:#f2f2f2;'><th>Poin</th><th>Keterangan</th><tr>";
    foreach ($daftar_poin as $g => $min) {
        $foreach_output .= "<tr><td>" . $g . "</td><td>>= " . $min . "</td></tr>";
    }
    $foreach_output .= "</table>";
    
    for ($x = 1; $x <= 5; $x++) {
        if ($x == 3) {
            break;
        }
        $break_output .= $x . " ";
    }
    
    for ($y = 1; $y <= 5; $y++) {
        if ($y == 3) {
            continue;
        }
        $continue_output .= $y . " ";
    }
    ?>

    <div class="demo-perulangan">
        <h4>Contoh Demo Perulangan PHP</h4>
        <p><b>1. While (3x):</b><br><?php echo $while_output; ?></p>
        <p><b>2. Do-While (2x):</b><br><?php echo $dowhile_output; ?></p>
        <p><b>3. For (3x):</b><br><?php echo $for_output; ?></p>
        <p><b>4. Foreach (Poin):</b></p><?php echo $foreach_output; ?>
        <p><b>5. Break (berhenti sebelum 3):</b> <?php echo $break_output; ?></p>
        <p><b>6. Continue (lompat angka 3):</b> <?php echo $continue_output; ?></p>
    </div>

    <?php
    $output = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nama = isset($_POST['nama']) ? $_POST['nama'] : "";
        $tugas = isset($_POST['tugas']) ? (int)$_POST['tugas'] : 0;
        $uts = isset($_POST['uts']) ? (int)$_POST['uts'] : 0;
        $uas = isset($_POST['uas']) ? (int)$_POST['uas'] : 0;
        
        if (empty($nama)) {
            $output = "<div class='hasil' style='background:#ffe0e0;'><p style='color:red;'>!! Nama harus diisi!</p></div>";
        } else {
            $nilai_akhir = ($tugas + $uts + $uas) / 3;
            $Poin = hitungPoin($nilai_akhir);
            $status = cekLulus($nilai_akhir);
            
            if ($nilai_akhir <= 80) {
                $keterangan = "Sangat Baik, Pertahankan!";
            } elseif ($nilai_akhir >= 60) {
                $keterangan = "Baik, Terus Belajar!";
            } else {
                $keterangan = "Perlu Belajar Lebih Giat!";
            }

            switch ($Poin) {
                 "A":
                    $pesan = "Istimewa!";
                    break;
                 "B":
                    $pesan = "Bagus!";
                    break;
                 "C":
                    $pesan = "Cukup";
                    break;
                :
                    $pesan = "Harus Remedial";
                    break;
            }
            
            $output = '
            <div class="hasil">
                <h3>Hasil Kelulusan</h3>
                <table border="1" cellpadding="8" style="border-collapse:collapse; width:100%;">
                    <tr style="background:#f2f2f2;"><th>Nama</th><td>' . htmlspecialchars($nama) . '</td></tr>
                    <tr><th>Nilai Tugas</th><td>' . $tugas . '</td></tr>
                    <tr><th>Nilai UTS</th><td>' . $uts . '</td></tr>
                    <tr><th>Nilai UAS</th><td>' . $uas . '</td></tr>
                    <tr><th>Nilai Akhir</th><td>' . round($nilai_akhir) . '</td></tr>
                    <tr><th>Poin</th><td>' . $Poin . '</td></tr>
                    <tr><th>Status</th><td><b>' . $status  '</b></td></tr>
                    <tr><th>Keterangan</th><td>' . $keterangan . '</td></tr>
                    <tr><th>Pesan</th><td>' . $pesan '</td></tr>
                </table>
            </div>';
        }
    }
    ?>

    <form method="POST">
        <label>Nama Siswa:</label>
        <input type="text" name="nama" required>
        
        <label>Nilai Tugas (0-100):</label>
        <input type="number" name="tugas" min="0" max="100" required>
        
        <label>Nilai UTS (0-100):</label>
        <input type="number" class="uts" min="0" max="100" required>
        
        <label>Nilai UAS (0-100):</label>
        <input type="number" name="uas" min="0" max="100" required>
        
        <button type="submit">Cek Kelulusan</button>
    </form>
    
    <?php echo $output; ?>
</div>

</body>
</html>