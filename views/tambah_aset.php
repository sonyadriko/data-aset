<?php
include '../config/database.php';

// Query untuk mengambil data provinsi
$query_provinsi = "SELECT id, nama_provinsi FROM provinsi";
$result_provinsi = mysqli_query($conn, $query_provinsi);

$query_kota = "SELECT id, nama FROM kota_kabupaten";
$result_kota = mysqli_query($conn, $query_kota);

$query_kecamatan = "SELECT id, nama FROM kecamatan";
$result_kecamatan = mysqli_query($conn, $query_kecamatan);

// Query untuk mengambil data kota_kabupaten dan kecamatan secara dinamis nanti via AJAX
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Tambah Data Aset</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc." />
    <meta name="author" content="Zoyothemes" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="../assets/images/favicon.ico">
    <link href="../assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style" />
    <link href="../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
</head>

<body data-menu-color="dark" data-sidebar="default">
    <div id="app-layout">
        <?php include 'partials/topbar.php' ?>
        <?php include 'partials/sidebar.php' ?>
        <div class="content-page">
            <div class="content">
                <div class="container-xxl">
                    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                        <div class="flex-grow-1">
                            <h4 class="fs-18 fw-semibold m-0">Tambah Data Aset</h4>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 col-xl-12">
                            <div class="card">
                                <div class="card-body">
                                    <form action="proses_upload.php" method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="user_id" value="<?php echo $_SESSION['id']?> ">
                                        <div class="form-group mb-2">
                                            <label for="no_kontrak">Kode Aset</label>
                                            <input type="text" class="form-control" id="no_kontrak" name="no_kontrak"
                                                placeholder="Masukkan Kode Aset" required>
                                        </div>

                                        <div class="form-group mb-2">
                                            <label for="objek_kerjasama">Objek Kerjasama</label>
                                            <input type="text" class="form-control" id="objek_kerjasama"
                                                name="objek_kerjasama" placeholder="Masukkan Objek Kerjasama" required>
                                        </div>

                                        <div class="form-group mb-2">
                                            <label for="provinsi">Provinsi:</label>
                                            <select class="form-control" name="provinsi" id="provinsi" required>
                                                <option value="">Pilih Provinsi</option>
                                                <?php while ($row = mysqli_fetch_assoc($result_provinsi)) { ?>
                                                <option value=" <?= $row['id'] ?>"><?= $row['nama_provinsi'] ?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <!-- Kabupaten Dropdown -->
                                        <div class="form-group mb-2">
                                            <label for="kabupaten">Kota/Kabupaten:</label>
                                            <select class="form-control" name="kabupaten" id="kabupaten" required>
                                                <option value="">Pilih Kota/Kabupaten</option>
                                            </select>
                                        </div>

                                        <!-- Kecamatan Dropdown -->
                                        <div class="form-group mb-2">
                                            <label for="kecamatan">Kecamatan:</label>
                                            <select class="form-control" name="kecamatan" id="kecamatan" required>
                                                <option value="">Pilih Kecamatan</option>
                                            </select>
                                        </div>

                                        <div class="form-group mb-2">
                                            <label for="jalan">Alamat Lengkap</label>
                                            <input type="text" class="form-control" id="jalan" name="jalan"
                                                placeholder="Masukkan Nama Jalan" required>
                                        </div>

                                        <div class="form-group mb-2">
                                            <label for="skema_kerjasama">Skema Kerjasama</label>
                                            <!-- <input type="text" class="form-control" id="skema_kerjasama"
                                                name="skema_kerjasama" placeholder="Masukkan Skema Kerjasama" required> -->
                                            <select class="form-control" name="skema_kerjasama" id="skema_kerjasama"
                                                required>
                                                <option value="" disabled>Pilih opsi</option>
                                                <option value="Jual">Jual</option>
                                                <option value="KSU">KSU</option>
                                                <option value="Sewa">Sewa</option>
                                            </select>
                                        </div>

                                        <div class="form-group mb-2">
                                            <label for="mitra">Nama Mitra</label>
                                            <input type="text" class="form-control" id="mitra" name="mitra"
                                                placeholder="Masukkan Nama Mitra" required>
                                        </div>

                                        <div class="form-group mb-2">
                                            <label for="bidang_usaha">Bidang Usaha Mitra</label>
                                            <input type="text" class="form-control" id="bidang_usaha"
                                                name="bidang_usaha" placeholder="Masukkan Bidang Usaha" required>
                                        </div>

                                        <div class="form-group mb-2">
                                            <label for="luas_objek">Luas Objek (Satuan m&sup2;)</label>
                                            <input type="text" class="form-control" id="luas_objek" name="luas_objek"
                                                placeholder="Masukkan Luas Objek" required>
                                        </div>

                                        <div class="form-group mb-2">
                                            <label for="nilai_kontrak">Nilai Kontrak</label>
                                            <input type="text" class="form-control" id="nilai_kontrak"
                                                name="nilai_kontrak" placeholder="Masukkan Nilai Kontrak" required>
                                        </div>

                                        <div class="form-group mb-2">
                                            <label for="tgl_mulai">Tanggal Mulai</label>
                                            <input type="date" class="form-control" id="tgl_mulai" name="tgl_mulai">
                                        </div>

                                        <div class="form-group mb-2">
                                            <label for="tgl_berakhir">Tanggal Berakhir</label>
                                            <input type="date" class="form-control" id="tgl_berakhir"
                                                name="tgl_berakhir" required>
                                        </div>

                                        <div class="form-group mb-2">
                                            <label for="no_nik">No NIK</label>
                                            <input type="text" class="form-control" id="no_nik" name="no_nik"
                                                placeholder="Masukkan No NIK">
                                        </div>

                                        <div class="form-group mb-2">
                                            <label for="no_kk">No KK</label>
                                            <input type="text" class="form-control" id="no_kk" name="no_kk"
                                                placeholder="Masukkan No KK" required>
                                        </div>

                                        <div class="form-group mb-2">
                                            <label for="no_npwp">No NPWP</label>
                                            <input type="text" class="form-control" id="no_npwp" name="no_npwp"
                                                placeholder="Masukkan No NPWP" required>
                                        </div>


                                        <div class="form-group mb-2">
                                            <label for="tgl_bayar">Tanggal Bayar</label>
                                            <input type="date" class="form-control" id="tgl_bayar" name="tgl_bayar"
                                                required>
                                        </div>

                                        <div class="form-group mb-2">
                                            <label for="file_kmz_option">Koordinat Lokasi (titik koordinat atau
                                                .KML):</label>
                                            <select class="form-control" id="file_kmz_option" name="file_kmz_option"
                                                required onchange="toggleInput()">
                                                <option value="">-- Pilih Opsi --</option>
                                                <option value="upload">Upload File KMZ</option>
                                                <option value="coordinate">Pilih Titik Koordinat</option>
                                            </select>
                                        </div>

                                        <!-- Form untuk Upload File -->
                                        <div class="form-group mb-2" id="file_kmz_upload" style="display: none;">
                                            <label for="file_kmz">File KMZ</label>
                                            <input type="file" class="form-control" id="file_kmz" name="file_kmz"
                                                accept=".kmz">
                                        </div>

                                        <!-- Form untuk Pilih Titik Koordinat -->
                                        <div class="form-group mb-2" id="coordinate_input" style="display: none;">
                                            <label for="latitude">Latitude</label>
                                            <input type="text" class="form-control" id="latitude" name="latitude"
                                                placeholder="Masukkan Latitude" readonly>

                                            <label for="longitude">Longitude</label>
                                            <input type="text" class="form-control" id="longitude" name="longitude"
                                                placeholder="Masukkan Longitude" readonly>

                                            <!-- Div untuk menampilkan peta Google Maps -->
                                            <div id="map-koordinat"
                                                style="width: 100%; height: 400px; margin-top: 10px;"></div>
                                        </div>

                                        <div class="form-group mb-2">
                                            <label for="berkas_shp">Upload Invoice (PDF)</label>
                                            <input type="file" class="form-control" id="berkas_shp" name="berkas_shp"
                                                accept=".pdf">
                                        </div>

                                        <div class="form-group mb-2">
                                            <label for="berkas_pks">Upload Berkas PKS (PDF)</label>
                                            <input type="file" class="form-control" id="berkas_pks" name="berkas_pks"
                                                accept=".pdf">
                                        </div>

                                        <div class="form-group mb-2">
                                            <label for="foto_npwp">Foto NPWP (JPG, PNG)</label>
                                            <input type="file" class="form-control" id="foto_npwp" name="foto_npwp"
                                                accept="image/*" required>
                                        </div>

                                        <div class="form-group mb-2">
                                            <label for="foto_ktp">Foto KTP (JPG, PNG)</label>
                                            <input type="file" class="form-control" id="foto_ktp" name="foto_ktp"
                                                accept="image/*" required>
                                        </div>

                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div> <!-- container-fluid -->
            </div> <!-- content -->

            <?php include 'partials/footer.php' ?>

        </div>
    </div>

    <!-- Vendor -->
    <script src="../assets/libs/jquery/jquery.min.js"></script>
    <script src="../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/libs/simplebar/simplebar.min.js"></script>
    <script src="../assets/libs/node-waves/waves.min.js"></script>
    <script src="../assets/libs/waypoints/lib/jquery.waypoints.min.js"></script>
    <script src="../assets/libs/jquery.counterup/jquery.counterup.min.js"></script>
    <script src="../assets/libs/feather-icons/feather.min.js"></script>

    <!-- Widgets Init Js -->
    <script src="../assets/js/pages/dashboard.init.js"></script>

    <!-- App js-->
    <script src="../assets/js/app.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        // Ketika provinsi dipilih
        $('#provinsi').change(function() {
            var id_provinsi = $(this).val();
            if (id_provinsi != '') {
                $.ajax({
                    url: "get_kabupaten.php", // File PHP untuk menangani request kabupaten
                    method: "POST",
                    data: {
                        provinsi_id: id_provinsi
                    },
                    success: function(data) {
                        $('#kabupaten').html(data); // Isi dropdown kabupaten
                        $('#kecamatan').html(
                            '<option value="">Pilih Kecamatan</option>'); // Reset kecamatan
                    }
                });
            }
        });

        // Ketika kabupaten dipilih
        $('#kabupaten').change(function() {
            var id_kabupaten = $(this).val();
            if (id_kabupaten != '') {
                $.ajax({
                    url: "get_kecamatan.php", // File PHP untuk menangani request kecamatan
                    method: "POST",
                    data: {
                        kabupaten_id: id_kabupaten
                    },
                    success: function(data) {
                        $('#kecamatan').html(data); // Isi dropdown kecamatan
                    }
                });
            }
        });
    });
    </script>

    <script>
    function toggleInput() {
        var option = document.getElementById('file_kmz_option').value;
        if (option === 'upload') {
            document.getElementById('file_kmz_upload').style.display = 'block';
            document.getElementById('coordinate_input').style.display = 'none';
        } else if (option === 'coordinate') {
            document.getElementById('file_kmz_upload').style.display = 'none';
            document.getElementById('coordinate_input').style.display = 'block';
        } else {
            document.getElementById('file_kmz_upload').style.display = 'none';
            document.getElementById('coordinate_input').style.display = 'none';
        }
    }
    // Fungsi untuk inisialisasi peta
    function initMap() {
        // Lokasi default (bisa disesuaikan sesuai kebutuhan)
        var defaultLocation = {
            lat: -7.250445,
            lng: 112.768845
        };

        // Membuat peta baru
        var map = new google.maps.Map(document.getElementById("map-koordinat"), {
            zoom: 13,
            center: defaultLocation,
        });

        // Membuat marker untuk menunjukkan titik yang dipilih
        var marker = new google.maps.Marker({
            position: defaultLocation,
            map: map,
            draggable: true // marker dapat digeser oleh pengguna
        });

        // Menampilkan koordinat default di input (jika diperlukan)
        document.getElementById("latitude").value = defaultLocation.lat;
        document.getElementById("longitude").value = defaultLocation.lng;

        // Menangkap event klik pada peta
        map.addListener("click", function(event) {
            // Mendapatkan lokasi klik
            var clickedLocation = event.latLng;

            // Memindahkan marker ke lokasi baru
            marker.setPosition(clickedLocation);

            // Memperbarui input latitude dan longitude
            document.getElementById("latitude").value = clickedLocation.lat();
            document.getElementById("longitude").value = clickedLocation.lng();
        });

        // Event ketika marker digeser
        marker.addListener('dragend', function(event) {
            // Memperbarui input saat marker digeser
            document.getElementById("latitude").value = event.latLng.lat();
            document.getElementById("longitude").value = event.latLng.lng();
        });
    }
    </script>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCl8CzSftxYHaty68D40iqk123zm-7wrsc&callback=initMap">
    </script>
    <!-- END wrapper -->
</body>

</html>