<?php
include '../config/database.php';
date_default_timezone_set('Asia/Jakarta');
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch asset details
    $query = "SELECT * FROM data_aset WHERE no = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $aset = mysqli_fetch_assoc($result);

    if (!$aset) {
        die("Asset not found!");
    }

    // Fetch dropdown options
    $query_provinsi = "SELECT id, nama_provinsi FROM provinsi";
    $result_provinsi = mysqli_query($conn, $query_provinsi);

    $query_kota = "SELECT id, nama FROM kota_kabupaten";
    $result_kota = mysqli_query($conn, $query_kota);

    $query_kecamatan = "SELECT id, nama FROM kecamatan";
    $result_kecamatan = mysqli_query($conn, $query_kecamatan);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $uploads = [];

        function uploadFile($fileInputName, $directory) {
            if (isset($_FILES[$fileInputName]) && $_FILES[$fileInputName]['error'] == UPLOAD_ERR_OK) {
                $tmpName = $_FILES[$fileInputName]['tmp_name'];
                $name = basename($_FILES[$fileInputName]['name']);
                
                // Sanitize the file name
                $safeName = preg_replace('/[^a-zA-Z0-9-_\.]/', '', $name);
                $uploadPath = $directory . $safeName;

                // Check and restrict file type if necessary
                $allowedTypes = ['application/zip', 'application/vnd.google-earth.kmz', 'image/jpeg', 'application/pdf'];
                $fileType = mime_content_type($tmpName);

                if (in_array($fileType, $allowedTypes) && move_uploaded_file($tmpName, $uploadPath)) {
                    return $safeName;
                }
            }
            return null;
        }

        $uploadDir = '../uploads/';
        $uploads['file_kmz'] = uploadFile('file_kmz', $uploadDir);
        $uploads['berkas_shp'] = uploadFile('berkas_shp', $uploadDir);
        $uploads['berkas_pks'] = uploadFile('berkas_pks', $uploadDir);
        $uploads['foto_npwp'] = uploadFile('foto_npwp', $uploadDir);
        $uploads['foto_ktp'] = uploadFile('foto_ktp', $uploadDir);

        $berkas_shp = $uploads['berkas_shp'] ?: $aset['berkas_shp'];
        $berkas_pks = $uploads['berkas_pks'] ?: $aset['berkas_pks'];
        $foto_npwp = $uploads['foto_npwp'] ?: $aset['foto_npwp'];
        $foto_ktp = $uploads['foto_ktp'] ?: $aset['foto_ktp'];
        $file_kmz = $uploads['file_kmz'] ?: $aset['file_kmz'];

        $latitude = isset($_FILES['file_kmz']) && $_FILES['file_kmz']['error'] === UPLOAD_ERR_OK ? NULL : $_POST['latitude'];
        $longitude = isset($_FILES['file_kmz']) && $_FILES['file_kmz']['error'] === UPLOAD_ERR_OK ? NULL : $_POST['longitude'];

        $query = "UPDATE data_aset SET 
            no_kontrak = ?, objek_kerjasama = ?, provinsi = ?, kabupaten = ?, kecamatan = ?, jalan = ?, 
            skema_kerjasama = ?, mitra = ?, bidang_usaha = ?, luas_objek = ?, nilai_kontrak = ?, 
            tgl_mulai = ?, tgl_berakhir = ?, no_nik = ?, no_kk = ?, no_npwp = ?, tgl_bayar = ?, 
            latitude = ?, longitude = ?, berkas_shp = ?, berkas_pks = ?, foto_npwp = ?, foto_ktp = ?, 
            file_kmz = ?, updated_by = ? WHERE no = ?";

        $stmt = mysqli_prepare($conn, $query);
        $params = [
            $_POST['no_kontrak'], $_POST['objek_kerjasama'], $_POST['provinsi'], $_POST['kabupaten'], 
            $_POST['kecamatan'], $_POST['jalan'], $_POST['skema_kerjasama'], $_POST['mitra'], 
            $_POST['bidang_usaha'], $_POST['luas_objek'], $_POST['nilai_kontrak'], $_POST['tgl_mulai'], 
            $_POST['tgl_berakhir'], $_POST['no_nik'], $_POST['no_kk'], $_POST['no_npwp'], $_POST['tgl_bayar'], 
            $latitude, $longitude, $berkas_shp, $berkas_pks, $foto_npwp, $foto_ktp, $file_kmz, 
            $_POST['user_id'], $id
        ];
        $typeString = str_repeat('s', count($params) - 1) . 'i';
        mysqli_stmt_bind_param($stmt, $typeString, ...$params);

        if (mysqli_stmt_execute($stmt)) {
            echo "Data successfully updated!";
            header("Location: data_aset.php");
            exit();
        } else {
            echo "Error updating data: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    }
} else {
    die("ID not provided!");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Edit Data Aset</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                            <h4 class="fs-18 fw-semibold m-0">Edit Data Aset</h4>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-12 col-xl-12">
                            <div class="card">
                                <div class="card-body">
                                    <form action="edit_aset.php?id=<?= $id ?>" method="POST"
                                        enctype="multipart/form-data">
                                        <input type="hidden" name="user_id" value="<?php echo $_SESSION['id'] ?>">
                                        <div class="form-group mb-2">
                                            <label for="no_kontrak">Kode Aset</label>
                                            <input type="text" class="form-control" id="no_kontrak" name="no_kontrak"
                                                value="<?= $aset['no_kontrak'] ?>" required>
                                        </div>

                                        <div class="form-group mb-2">
                                            <label for="objek_kerjasama">Objek Kerjasama</label>
                                            <input type="text" class="form-control" id="objek_kerjasama"
                                                name="objek_kerjasama" value="<?= $aset['objek_kerjasama'] ?>" required>
                                        </div>

                                        <div class="form-group mb-2">
                                            <label for="provinsi">Provinsi:</label>
                                            <select class="form-control" name="provinsi" id="provinsi" required>
                                                <option value="">Pilih Provinsi</option>
                                                <?php while ($row = mysqli_fetch_assoc($result_provinsi)) { ?>
                                                <option value="<?= $row['id'] ?>"
                                                    <?= $row['id'] == $aset['provinsi'] ? 'selected' : '' ?>>
                                                    <?= $row['nama_provinsi'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <!-- Kabupaten Dropdown -->
                                        <div class="form-group mb-2">
                                            <label for="kabupaten">Kota/Kabupaten:</label>
                                            <select class="form-control" name="kabupaten" id="kabupaten" required>
                                                <option value="">Pilih Kota/Kabupaten</option>
                                                <?php while ($row = mysqli_fetch_assoc($result_kota)) { ?>
                                                <option value="<?= $row['id'] ?>"
                                                    <?= $row['id'] == $aset['kabupaten'] ? 'selected' : '' ?>>
                                                    <?= $row['nama'] ?></option>
                                                <?php } ?>
                                                <!-- Fetch cities based on selected province -->
                                            </select>
                                        </div>

                                        <!-- Kecamatan Dropdown -->
                                        <div class="form-group mb-2">
                                            <label for="kecamatan">Kecamatan:</label>
                                            <select class="form-control" name="kecamatan" id="kecamatan" required>
                                                <option value="">Pilih Kecamatan</option>
                                                <!-- Fetch districts based on selected city -->
                                                <?php while ($row = mysqli_fetch_assoc($result_kecamatan)) { ?>
                                                <option value="<?= $row['id'] ?>"
                                                    <?= $row['id'] == $aset['kecamatan'] ? 'selected' : '' ?>>
                                                    <?= $row['nama'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="form-group mb-2">
                                            <label for="jalan">Alamat Lengkap</label>
                                            <input type="text" class="form-control" id="jalan" name="jalan"
                                                value="<?= $aset['jalan'] ?>" required>
                                        </div>

                                        <div class="form-group mb-2">
                                            <label for="skema_kerjasama">Skema Kerjasama</label>
                                            <select class="form-control" name="skema_kerjasama" id="skema_kerjasama"
                                                required>
                                                <option value="" disabled>Pilih opsi</option>
                                                <option value="Jual"
                                                    <?= $aset['skema_kerjasama'] == 'Jual' ? 'selected' : '' ?>>Jual
                                                </option>
                                                <option value="KSU"
                                                    <?= $aset['skema_kerjasama'] == 'KSU' ? 'selected' : '' ?>>KSU
                                                </option>
                                                <option value="Sewa"
                                                    <?= $aset['skema_kerjasama'] == 'Sewa' ? 'selected' : '' ?>>Sewa
                                                </option>
                                            </select>
                                        </div>

                                        <div class="form-group mb-2">
                                            <label for="mitra">Nama Mitra</label>
                                            <input type="text" class="form-control" id="mitra" name="mitra"
                                                value="<?= $aset['mitra'] ?>" required>
                                        </div>

                                        <div class="form-group mb-2">
                                            <label for="bidang_usaha">Bidang Usaha Mitra</label>
                                            <input type="text" class="form-control" id="bidang_usaha"
                                                name="bidang_usaha" value="<?= $aset['bidang_usaha'] ?>" required>
                                        </div>

                                        <div class="form-group mb-2">
                                            <label for="luas_objek">Luas Objek(Satuan m&sup2;)</label>
                                            <input type="text" class="form-control" id="luas_objek" name="luas_objek"
                                                value="<?= $aset['luas_objek'] ?>" required>
                                        </div>

                                        <div class="form-group mb-2">
                                            <label for="nilai_kontrak">Nilai Kontrak</label>
                                            <input type="text" class="form-control" id="nilai_kontrak"
                                                name="nilai_kontrak" value="<?= $aset['nilai_kontrak'] ?>" required>
                                        </div>

                                        <div class="form-group mb-2">
                                            <label for="tgl_mulai">Tanggal Mulai</label>
                                            <input type="date" class="form-control" id="tgl_mulai" name="tgl_mulai"
                                                value="<?= $aset['tgl_mulai'] ?>">
                                        </div>

                                        <div class="form-group mb-2">
                                            <label for="tgl_berakhir">Tanggal Berakhir</label>
                                            <input type="date" class="form-control" id="tgl_berakhir"
                                                name="tgl_berakhir" value="<?= $aset['tgl_berakhir'] ?>" required>
                                        </div>

                                        <div class="form-group mb-2">
                                            <label for="no_nik">No NIK</label>
                                            <input type="text" class="form-control" id="no_nik" name="no_nik"
                                                value="<?= $aset['no_nik'] ?>">
                                        </div>

                                        <div class="form-group mb-2">
                                            <label for="no_kk">No KK</label>
                                            <input type="text" class="form-control" id="no_kk" name="no_kk"
                                                value="<?= $aset['no_kk'] ?>" required>
                                        </div>

                                        <div class="form-group mb-2">
                                            <label for="no_npwp">No NPWP</label>
                                            <input type="text" class="form-control" id="no_npwp" name="no_npwp"
                                                value="<?= $aset['no_npwp'] ?>" required>
                                        </div>

                                        <div class="form-group mb-2">
                                            <label for="tgl_bayar">Tanggal Bayar</label>
                                            <input type="date" class="form-control" id="tgl_bayar" name="tgl_bayar"
                                                value="<?= $aset['tgl_bayar'] ?>" required>
                                        </div>

                                        <div class="form-group mb-2">
                                            <label for="file_kmz_option">Pilih Opsi:</label>
                                            <select class="form-control" id="file_kmz_option" name="file_kmz_option"
                                                required onchange="toggleInput()">
                                                <option value="">-- Pilih Opsi --</option>
                                                <option value="upload"
                                                    <?= (empty($aset['latitude']) && empty($aset['longitude'])) ? 'selected' : '' ?>>
                                                    Upload File KMZ</option>
                                                <option value="coordinate"
                                                    <?= (!empty($aset['latitude']) && !empty($aset['longitude'])) ? 'selected' : '' ?>>
                                                    Pilih Titik Koordinat</option>
                                            </select>
                                        </div>

                                        <!-- Form for Upload File -->
                                        <div class="form-group mb-2" id="file_kmz_upload"
                                            style="display: <?= (empty($aset['latitude']) && empty($aset['longitude'])) ? 'block' : 'none' ?>;">
                                            <label for="file_kmz">File KMZ</label>
                                            <input type="file" class="form-control" id="file_kmz" name="file_kmz">

                                            <?php if (!empty($aset['file_kmz'])): ?>
                                            <small class="form-text text-muted">
                                                Current File: <?= htmlspecialchars($aset['file_kmz']) ?>
                                            </small>
                                            <?php endif; ?>
                                        </div>

                                        <!-- Form for Coordinate -->
                                        <div class="form-group mb-2" id="coordinate_input"
                                            style="display: <?= (!empty($aset['latitude']) && !empty($aset['longitude'])) ? 'block' : 'none' ?>;">
                                            <label for="latitude">Latitude</label>
                                            <input type="text" class="form-control" id="latitude" name="latitude"
                                                value="<?= htmlspecialchars($aset['latitude']) ?>" required>

                                            <label for="longitude">Longitude</label>
                                            <input type="text" class="form-control" id="longitude" name="longitude"
                                                value="<?= htmlspecialchars($aset['longitude']) ?>" required>

                                            <div id="map-koordinat"
                                                style="width: 100%; height: 400px; margin-top: 10px;"></div>
                                        </div>

                                        <!-- <div class="form-group mb-2">
                                            <label for="alamat">Alamat</label>
                                            <input type="text" class="form-control" id="alamat" name="alamat"
                                                value="<?= $aset['alamat'] ?>" required>
                                        </div> -->

                                        <div class="form-group mb-2">
                                            <label for="berkas_shp">Upload Invoice (PDF)</label>
                                            <input type="file" class="form-control" id="berkas_shp" name="berkas_shp">

                                            <?php if (!empty($aset['berkas_shp'])): ?>
                                            <small class="form-text text-muted">
                                                Current File: <?= htmlspecialchars($aset['berkas_shp']) ?>
                                            </small>
                                            <?php endif; ?>
                                        </div>


                                        <div class="form-group mb-2">
                                            <label for="berkas_pks">Upload Berkas PKS (PDF)</label>
                                            <input type="file" class="form-control" id="berkas_pks" name="berkas_pks">

                                            <?php if (!empty($aset['berkas_pks'])): ?>
                                            <small class="form-text text-muted">
                                                Current File: <?= htmlspecialchars($aset['berkas_pks']) ?>
                                            </small>
                                            <?php endif; ?>
                                        </div>


                                        <div class="form-group mb-2">
                                            <label for="foto_npwp">Foto NPWP</label>
                                            <input type="file" class="form-control" id="foto_npwp" name="foto_npwp">

                                            <?php if (!empty($aset['foto_npwp'])): ?>
                                            <small class="form-text text-muted">
                                                Current File: <?= htmlspecialchars($aset['foto_npwp']) ?>
                                            </small>
                                            <?php endif; ?>
                                        </div>

                                        <div class="form-group mb-2">
                                            <label for="foto_ktp">Foto KTP</label>
                                            <input type="file" class="form-control" id="foto_ktp" name="foto_ktp">

                                            <?php if (!empty($aset['foto_ktp'])): ?>
                                            <small class="form-text text-muted">
                                                Current File: <?= htmlspecialchars($aset['foto_ktp']) ?>
                                            </small>
                                            <?php endif; ?>
                                        </div>




                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                        <a href="data_aset.php" class="btn btn-secondary">Kembali</a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
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
    <script src="../assets/js/app.js"></script>
    <script>
    function toggleInput() {
        var option = document.getElementById("file_kmz_option").value;
        var fileKmzUpload = document.getElementById("file_kmz_upload");
        var coordinateInput = document.getElementById("coordinate_input");

        if (option === "upload") {
            fileKmzUpload.style.display = "block";
            coordinateInput.style.display = "none";
        } else if (option === "coordinate") {
            fileKmzUpload.style.display = "none";
            coordinateInput.style.display = "block";
        } else {
            fileKmzUpload.style.display = "none";
            coordinateInput.style.display = "none";
        }
    }

    // Call the function to set initial visibility based on the selected option
    toggleInput();
    </script>
    <script>
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
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCl8CzSftxYHaty68D40iqk123zm-7wrsc&callback=initMap">
    </script>
</body>

</html>