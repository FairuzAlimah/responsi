<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Mengambil data dari form dan memeriksa keberadaannya
$nama_pasar = isset($_POST['nama_pasar']) ? $_POST['nama_pasar'] : '';
$luas__m2_ = isset($_POST['luas__m2_']) ? $_POST['luas__m2_'] : '';
$jml_kios = isset($_POST['jml_kios']) ? $_POST['jml_kios'] : '';
$x = isset($_POST['x']) ? $_POST['x'] : '';
$y = isset($_POST['y']) ? $_POST['y'] : '';
$wadmkk = isset($_POST['wadmkk']) ? $_POST['wadmkk'] : '';
$alamat = isset($_POST['alamat']) ? $_POST['alamat'] : '';

// Validasi input
if (empty($nama_pasar) || !is_numeric($luas__m2_) || !is_numeric($jml_kios) || !is_numeric($x) || !is_numeric($y)  || empty($wadmkk) || empty($alamat)) {
    die("Semua kolom harus diisi dan 'luas', 'jumlah kios', 'longitude', serta 'latitude' harus angka.");
}

// Validasi tambahan
if ($luas__m2_ <= 0 || $jml_kios <= 0 || $x < -180 || $x > 180 || $y < -90 || $y > 90) {
    die("Data tidak valid. Luas dan jumlah kios harus lebih dari 0, x antara -180 dan 180, dan y antara -90 dan 90.");
}

// Sesuaikan dengan setting MySQL
$servername = "localhost";
$username = "root";
$password = ""; // Ganti dengan password yang sesuai, jika ada
$dbname = "responsi"; // Pastikan nama database sesuai

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Mengonversi data ke tipe yang sesuai
$luas = (float)$luas__m2_;
$x = (float)$x;
$y = (float)$y;

// Menggunakan prepared statement untuk menghindari SQL Injection
$stmt = $conn->prepare("INSERT INTO pasar_lampung (nama_pasar, luas__m2_, jml_kios, x, y, wadmkk, alamat) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("siiddss", $nama_pasar, $luas__m2_, $jml_kios, $x, $y, $wadmkk, $alamat); // s = string, i = integer, d = double (float)

// Eksekusi statement
if ($stmt->execute()) {
    header("Location: success.php"); // Redirect ke success.php setelah berhasil
    exit; // Hentikan script setelah redirect
} else {
    echo "Error: " . $stmt->error;
}

// Tutup statement dan koneksi
$stmt->close();
$conn->close();
?>
