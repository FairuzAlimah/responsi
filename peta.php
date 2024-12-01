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
            /* Memusatkan konten secara horizontal */
            align-items: center;
            /* Memusatkan konten secara vertikal */
            background-color: #810404;
            /* Latar belakang merah */
            padding: 2px 2px;
            /* Memberikan ruang di dalam container */
            border-radius: 2px;
            /* Memberikan sudut melengkung pada container */
        }

        /* Gaya untuk gambar di samping judul */
        .title-image {
            width: 45px;
            /* Ukuran gambar */
            height: auto;
            /* Menjaga rasio gambar */
            margin-right: 10px;
            /* Jarak antara gambar dan teks */
        }

        /* Gaya untuk judul */
        .title {
            font-size: 25px;
            font-weight: bold;
            color: #FEF486;
            /* Warna teks kuning */
            margin: 0;
            /* Menghilangkan margin default */
            padding: 10px 0;
            /* Memberikan padding vertikal pada judul */
            text-align: center;
            /* Memastikan teks berada di tengah */
            background-color: #810404;
            /* Latar belakang merah */
            border-radius: 1px;
            /* Sudut melengkung pada latar belakang judul */
        }

        /* Legend */
        #legend {
            position: absolute;
            bottom: 67px;
            right: 10px;
            z-index: 1000;
            background: white;
            padding: 10px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
            border-radius: 6px;
            font-family: Arial, sans-serif;
            font-size: 12px;
            max-width: 300px;
            display: none;
            /* Hidden by default */
        }

        #legend h4 {
            margin: 1;
            font-size: 15px;
            text-align: center;
            border-bottom: 1px solid #ccc;
        }

        #toggleLegend {
            position: absolute;
            bottom: 67px;
            right: 10px;
            z-index: 1100;
            background: white;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
            border-color: #36393f;
            padding: 8px;
            border-radius: 6px;
            cursor: pointer;
        }

        #toggleLegend i {
            font-size: 20px;
            color: #114c79;
        }

        .leaflet-control-scale {
            bottom: 15px;
            left: 7px;
        }
    </style>
</head>

<body>
    <h1 class="title">WebGIS - PROVINSI LAMPUNG</h1>

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

    <script>
        <?php
        // Koneksi ke database dan ambil data GeoJSON
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "responsi";

        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM pasar_lampung";
        $result = $conn->query($sql);
        $geojson = ['type' => 'FeatureCollection', 'features' => []];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $y = $row["y"];
                $x = $row["x"];
                $nama_pasar = $row["nama_pasar"];
                $geojson['features'][] = [
                    'type' => 'Feature',
                    'geometry' => [
                        'type' => 'Point',
                        'coordinates' => [(float)$x, (float)$y]
                    ],
                    'properties' => ['info' => $nama_pasar]
                ];
                
            }
        } else {
            echo "console.log('Tidak ada data ditemukan');";
        }
        $conn->close();

        
        ?>
        

        var geojsonData = <?php echo json_encode($geojson); ?>;
        L.geoJSON(geojsonData, {
            pointToLayer: function(feature, latlng) {
                return L.marker(latlng).bindTooltip(feature.properties.info, {
                    sticky: true,
                    direction: 'top'
                });
            }
        }).addTo(map);
    </script>

   
</html>