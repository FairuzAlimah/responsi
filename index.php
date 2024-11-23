<?php
// Sesuaikan dengan setting MySQL
$servername = "localhost";
$username = "root";
$password = ""; // Sesuaikan jika ada password
$dbname = "responsi"; // Nama database

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query untuk mengambil data dari tabel pasar_lampung
$sql = "SELECT id, nama_pasar, x, y, luas__m2_, wadmkk, alamat, jml_kios FROM pasar_lampung";
$result = $conn->query($sql);

// Tambahkan style CSS
echo '<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #fff5e6;
        margin: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        flex-direction: column;
    }
    
    h1 {
        color: #e63946;
        font-size: 24px;
        margin-bottom: 20px;
    }
    
    table {
        width: 80%;
        border-collapse: collapse;
        margin: 20px 0;
        background-color: #fff;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }
    
    th, td {
        padding: 12px 15px;
        text-align: center;
        border: 1px solid #ffcc00;
        color: #333;
    }
    
    th {
        background-color: #e63946;
        color: white;
    }
    
    tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    
    tr:hover {
        background-color: #ffcc00;
        color: #e63946;
    }
    
    a {
        color: #e63946;
        text-decoration: none;
        font-weight: bold;
    }

    a:hover {
        text-decoration: underline;
    }

    /* Style for action buttons */
    .action-buttons a {
        display: block; /* Ensure buttons appear on new lines */
        padding: 8px 10px;
        border-radius: 5px;
        font-size: 13px;
        font-weight: bold;
        cursor: pointer;
        margin: 5px 0; /* Adds vertical spacing between the buttons */
        text-decoration: none;
    }

    .btn-edit {
        background-color: #4caf50; /* Hijau (Green) */
        color: white;
    }

    .btn-edit:hover {
        background-color: #45a049; /* Hijau lebih gelap */
    }

    .btn-delete {
        background-color: #e63946; /* Merah (Red) */
        color: white;
    }

    .btn-delete:hover {
        background-color: #c03434; /* Merah lebih gelap */
    }
</style>';

if ($result->num_rows > 0) {
    echo "<h1>Data Pasar Lampung</h1>";
    echo "<table><tr>
    <th>Nama Pasar</th>
    <th>X</th>
    <th>Y</th>
    <th>Luas (m²)</th>
    <th>Jumlah Kios</th>
    <th>Wilayah</th>
    <th>Alamat</th>
    <th>Aksi</th></tr>";

    // Output data dari setiap baris
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
        <td>" . $row["nama_pasar"] . "</td>
        <td>" . $row["x"] . "</td>
        <td>" . $row["y"] . "</td>
        <td>" . $row["luas__m2_"] . "</td>
        <td>" . $row["jml_kios"] . "</td>
        <td>" . $row["wadmkk"] . "</td>
        <td>" . $row["alamat"] . "</td>
        
        <td class='action-buttons'>
            <a href='edit.php?id=" . $row["id"] . "' class='btn-edit'>Edit</a>
            <a href='delete.php?id=" . $row["id"] . "' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")' class='btn-delete'>Hapus</a>
        </td></tr>";
    }

    echo "</table>";
} else {
    echo "0 results";
}

// Tutup koneksi
$conn->close();
?>