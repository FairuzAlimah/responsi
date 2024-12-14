<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>LAMPUNG</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <style>
        html,
        body {
            width: 100%;
            height: 100%;
            margin: 0;
            overflow: hidden;
        }

        #map {
            width: 100%;
            height: calc(100vh - 56px);
        }

        .header {
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #810404;
            padding: 2px 2px;
            border-radius: 2px;
        }

        .title {
            font-size: 25px;
            font-weight: bold;
            color: #FEF486;
            margin: 0;
            padding: 10px 0;
            text-align: center;
            background-color: #810404;
            border-radius: 1px;
            font-family: Arial, sans-serif;
        }

        .leaflet-control-scale {
            bottom: 15px;
            left: 7px;
        }
    </style>
</head>

<body>
    <h1 class="title">Persebaran Titik Pasar Tradisional di Provinsi Lampung</h1>
    <div id="map"></div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <script>
        // Inisialisasi peta
        var map = L.map("map").setView([-4.879205291600748, 104.89042232923009], 8);

        // Tile Layer Base Map
        var osm = L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        });
        osm.addTo(map);
    </script>

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

    // Ambil data dari tabel
    $sql = "SELECT * FROM pasar_lampung";
    $result = $conn->query($sql);
    $geojson = ['type' => 'FeatureCollection', 'features' => []];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $geojson['features'][] = [
                'type' => 'Feature',
                'geometry' => [
                    'type' => 'Point',
                    'coordinates' => [(float)$row["x"], (float)$row["y"]]
                ],
                'properties' => [
                    'nama_pasar' => $row["nama_pasar"],
                    'alamat' => $row["alamat"],
                    'jml_kios' => $row["jml_kios"],
                    'wadmkk' => $row["wadmkk"]
                ]
            ];
        }
    } else {
        echo "<script>console.log('Tidak ada data ditemukan');</script>";
    }
    $conn->close();
    ?>

    <script>
        // Data GeoJSON dari PHP
        var geojsonData = <?php echo json_encode($geojson); ?>;

        // Tambahkan data GeoJSON ke peta
        L.geoJSON(geojsonData, {
            pointToLayer: function (feature, latlng) {
                return L.marker(latlng, {
                    icon: L.icon({
                        iconUrl: "icon/pasar.png", // Path ke ikon
                        iconSize: [38, 38],
                        iconAnchor: [19, 38],
                        popupAnchor: [0, -30]
                    })
                });
            },
            onEachFeature: function (feature, layer) {
                // Buat konten popup
                var popup_content = `
                    <table class="table table-bordered table-striped">
                        <tr><td><strong>Nama</strong></td><td>${feature.properties.nama_pasar}</td></tr>
                        <tr><td><strong>Alamat</strong></td><td>${feature.properties.alamat}</td></tr>
                        <tr><td><strong>Jumlah Kios</strong></td><td>${feature.properties.jml_kios}</td></tr>
                        <tr><td><strong>Wilayah</strong></td><td>${feature.properties.wadmkk}</td></tr>
                        <tr><td><strong>Koordinat</strong></td><td>${feature.geometry.coordinates[1]}, ${feature.geometry.coordinates[0]}</td></tr>
                    </table>
                `;

                // Tambahkan popup ke layer
                layer.bindPopup(popup_content, { maxWidth: 300 });

                // Tambahkan tooltip saat mouseover
                layer.bindTooltip(feature.properties.nama_pasar, {
                    direction: "top",
                    sticky: true
                });
            }
        }).addTo(map);
    </script>
</body>

</html>
