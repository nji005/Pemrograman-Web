<?php
session_start(); // aktifkan session untuk menyimpan data sementara
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Aplikasi Biodata Mahasiswa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ffffff; /* Putih */
            color: #1e293b;
            margin: 0;
            padding: 20px;
        }
        h2 {
            color: #2563eb;
            border-bottom: 2px solid #e5e7eb;
            padding-bottom: 5px;
        }
        form {
            background-color: #f9fafb;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        label {
            display: block;
            margin-top: 12px;
            margin-bottom: 6px;
            font-weight: bold;
        }
        input[type="text"], select, textarea {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #cbd5e1;
            background-color: #ffffff;
            color: #1e293b;
        }
        input[type="radio"], input[type="checkbox"] {
            margin-right: 6px;
        }
        .btn {
            margin-top: 15px;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            background-color: #2563eb;
            color: #ffffff;
            font-weight: bold;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #1d4ed8;
        }
        table {
            border-collapse: collapse;
            margin-top: 15px;
            width: 100%;
            background-color: #f9fafb;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        table, th, td {
            border: 1px solid #b7cce6ff;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #e2e8f0;
            color: #1e293b;
        }
    </style>
</head>
<body>

    <h2>Form Biodata Mahasiswa</h2>
    <form method="POST" action="">
        <label>Nama Lengkap:</label>
        <input type="text" name="nama" placeholder="Masukkan nama lengkap" required>

        <label>NIM:</label>
        <input type="text" name="nim" placeholder="Contoh: 2023001001" required>

        <label>Program Studi:</label>
        <select name="prodi" required>
            <option value="">-- Pilih Program Studi --</option>
            <option value="Informatika">Informatika</option>
            <option value="Teknik Sipil">Teknik Sipil</option>
            <option value="Teknik Elektro">Teknik Elektro</option>
        </select>

        <label>Jenis Kelamin:</label>
        <input type="radio" name="jk" value="Laki-laki" required>  Laki-laki
        <input type="radio" name="jk" value="Perempuan">  Perempuan

        <label>Hobi:</label>
        <input type="checkbox" name="hobi[]" value="Membaca">Membaca
        <input type="checkbox" name="hobi[]" value="Olahraga">Olahraga
        <input type="checkbox" name="hobi[]" value="Musik">Musik
        

        <label>Alamat:</label>
        <textarea name="alamat" rows="3" placeholder="Masukkan alamat lengkap" required></textarea>

        <button type="submit" class="btn">Kirim</button>
    </form>

    <?php
    // Simpan biodata ke session saat form dikirim
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nama   = $_POST['nama'];
        $nim    = $_POST['nim'];
        $prodi  = $_POST['prodi'];
        $jk     = $_POST['jk'];
        $hobi   = isset($_POST['hobi']) ? implode(", ", $_POST['hobi']) : "-";
        $alamat = $_POST['alamat'];

        // Simpan ke session
        $_SESSION['biodata'] = [
            'nama'   => $nama,
            'nim'    => $nim,
            'prodi'  => $prodi,
            'jk'     => $jk,
            'hobi'   => $hobi,
            'alamat' => $alamat
        ];

        echo "<h3>Hasil Biodata</h3>";
        echo "<table>";
        echo "<tr><th>Nama Lengkap</th><td>$nama</td></tr>";
        echo "<tr><th>NIM</th><td>$nim</td></tr>";
        echo "<tr><th>Program Studi</th><td>$prodi</td></tr>";
        echo "<tr><th>Jenis Kelamin</th><td>$jk</td></tr>";
        echo "<tr><th>Hobi</th><td>$hobi</td></tr>";
        echo "<tr><th>Alamat</th><td>$alamat</td></tr>";
        echo "</table>";
    }
    ?>

    <h2>Form Pencarian</h2>
    <form method="GET" action="">
        <label>Kata Kunci:</label>
        <input type="text" name="keyword" placeholder="Masukkan kata kunci" required>
        <button type="submit" class="btn">Cari</button>
    </form>

    <?php
    if (isset($_GET['keyword'])) {
        $keyword = strtolower(htmlspecialchars($_GET['keyword']));
        echo "<p>Anda mencari data dengan kata kunci: <strong style='color:#2563eb;'>$keyword</strong></p>";

        // cek apakah ada biodata di session
        if (isset($_SESSION['biodata'])) {
            $biodata = $_SESSION['biodata'];

            // cari kecocokan di semua field biodata
            $found = false;
            foreach ($biodata as $key => $value) {
                if (strpos(strtolower($value), $keyword) !== false) {
                    $found = true;
                    break;
                }
            }

            if ($found) {
                echo "<h3>Data Ditemukan</h3>";
                echo "<table>";
                echo "<tr><th>Nama Lengkap</th><td>{$biodata['nama']}</td></tr>";
                echo "<tr><th>NIM</th><td>{$biodata['nim']}</td></tr>";
                echo "<tr><th>Program Studi</th><td>{$biodata['prodi']}</td></tr>";
                echo "<tr><th>Jenis Kelamin</th><td>{$biodata['jk']}</td></tr>";
                echo "<tr><th>Hobi</th><td>{$biodata['hobi']}</td></tr>";
                echo "<tr><th>Alamat</th><td>{$biodata['alamat']}</td></tr>";
                echo "</table>";
            } else {
                echo "<p style='color:red;'>❌ Data tidak ditemukan</p>";
            }
        } else {
            echo "<p style='color:red;'>⚠️ Belum ada biodata yang disimpan.</p>";
        }
    }
    ?>

</body>
</html>
