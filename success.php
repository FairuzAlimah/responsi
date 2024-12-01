<!DOCTYPE html>
<html>
<head>
    <title>Success</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fff5e6; /* Latar belakang kuning lembut */
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            flex-direction: column;
            text-align: center;
        }

        h2 {
            color: #e63946; /* Merah cerah */
            font-size: 24px;
            margin-bottom: 10px;
        }

        p {
            color: #333;
            font-size: 16px;
            margin-bottom: 20px;
        }

        button {
            background-color: #e63946; /* Merah cerah untuk tombol */
            color: #fff; /* Putih untuk teks tombol */
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin: 5px;
        }

        button:hover {
            background-color: #ffcc00; /* Kuning saat hover */
            color: #e63946; /* Merah untuk teks */
        }

        a {
            text-decoration: none; /* Menghilangkan underline pada link */
        }

    </style>
</head>
<body>
    <h2>Data Berhasil Dimasukkan</h2>
    <p>Data Anda telah berhasil dimasukkan ke dalam sistem.</p>
    
    <!-- Tautan untuk kembali ke halaman form -->
    <a href="peta.php">
        <button>Open WebGIS</button>
    </a>

    <!-- Tambahan tombol untuk kembali ke tabel -->
    <br><br>
    <a href="index.php">
        <button>Kembali ke Tabel</button>
    </a>
</body>
</html>
