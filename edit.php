<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "responsi";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil ID dari parameter URL
$id = $_GET['id'];

// Query untuk mendapatkan data berdasarkan ID
$sql = "SELECT * FROM pasar_lampung WHERE id = $id";
$result = $conn->query($sql);
$data = $result->fetch_assoc();

$update_success = false; // Variabel untuk mendeteksi status update

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $nama_pasar = isset($_POST['nama_pasar']) ? $_POST['nama_pasar'] : '';
    $luas__m2_ = isset($_POST['luas__m2_']) ? $_POST['luas__m2_'] : '';
    $jml_kios = isset($_POST['jml_kios']) ? $_POST['jml_kios'] : '';
    $x = isset($_POST['x']) ? $_POST['x'] : '';
    $y = isset($_POST['y']) ? $_POST['y'] : '';
    $wadmkk = isset($_POST['wadmkk']) ? $_POST['wadmkk'] : '';
    $alamat = isset($_POST['alamat']) ? $_POST['alamat'] : '';
    // Query untuk update data
    $update_sql = "UPDATE pasar_lampung SET 
        nama_pasar='$nama_pasar', 
        x='$x', 
        y='$y', 
        luas__m2_='$luas__m2_', 
        jml_kios='$jml_kios', 
        wadmkk='$wadmkk', 
        alamat='$alamat' 
        WHERE id=$id";

    if ($conn->query($update_sql) === TRUE) {
        $update_success = true; // Tandai bahwa update berhasil
        echo "<script>
        alert('Data berhasil diperbarui!');
        window.location.href = 'peta.php'; // Kembali ke halaman utama
    </script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perubahan Data</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fff5e6;
            /* Nuansa kuning lembut */
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        form {
            background-color: #fff;
            /* Putih untuk kontras */
            padding: 20px;
            border: 2px solid #ffcc00;
            /* Kuning sebagai aksen */
            border-radius: 10px;
            width: 100%;
            max-width: 700px;
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            flex: 1 1 100%;
            text-align: center;
            font-size: 22px;
            margin-bottom: 10px;
            color: #e63946;
            /* Merah cerah */
        }

        form label {
            flex: 0 0 120px;
            font-size: 14px;
            font-weight: bold;
            color: #e63946;
            /* Merah untuk teks label */
        }

        form input {
            flex: 1;
            padding: 8px;
            border: 1px solid #ffcc00;
            /* Border kuning */
            border-radius: 5px;
            font-size: 14px;
        }

        form input:focus {
            border-color: #e63946;
            /* Merah saat fokus */
            outline: none;
            box-shadow: 0 0 5px rgba(230, 57, 70, 0.5);
        }

        .full-width {
            flex: 1 1 100%;
        }

        form input[type="submit"] {
            background-color: #e63946;
            /* Merah untuk tombol */
            color: #fff;
            /* Putih untuk teks tombol */
            border: none;
            padding: 10px;
            font-size: 16px;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        form input[type="submit"]:hover {
            background-color: #ffcc00;
            /* Kuning saat hover */
            color: #e63946;
            /* Merah untuk teks */
        }
    </style>
</head>


<body>

    <div class="form-container">
        <form method="POST" action="">
            <h2>Perubahan Data</h2>

            <label for="nama_pasar">Kecamatan:</label>
            <input type="text" id="nama_pasar" name="nama_pasar" value="<?php echo $data['nama_pasar']; ?>" required>

            <label for="wadmkk">Nama Wilayah:</label>
            <input type="text" id="wadmkk" name="wadmkk" value="<?php echo $data['wadmkk']; ?>" required>

            <label for="luas__m2_">Luas:</label>
            <input type="number" id="luas__m2_" name="luas__m2_" value="<?php echo $data['luas__m2_']; ?>" required>

            <label for="jml_kios">Jumlah Kios:</label>
            <input type="number" id="jml_kios" name="jml_kios" value="<?php echo $data['jml_kios']; ?>" required>

            <label for="x">X:</label>
            <input type="text" id="x" name="x" value="<?php echo $data['x']; ?>" required>

            <label for="y">Y:</label>
            <input type="text" id="y" name="y" value="<?php echo $data['y']; ?>" required>

            <label for="alamat">Alamat:</label>
            <input type="text" id="alamat" name="alamat" value="<?php echo $data['alamat']; ?>" required class="full-width">

            <input type="submit" value="Simpan Perubahan" required class="full-width">
        </form>
    </div>

</body>

</html>