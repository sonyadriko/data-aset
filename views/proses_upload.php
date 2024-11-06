<?php
// Include database connection file
include '../config/database.php';

// Set timezone to Jakarta
date_default_timezone_set('Asia/Jakarta');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Initialize variables from POST request
    $no_kontrak = $_POST['no_kontrak'];
    $objek_kerjasama = $_POST['objek_kerjasama'];
    $provinsi = $_POST['provinsi'];
    $kabupaten = $_POST['kabupaten'];
    $kecamatan = $_POST['kecamatan'];
    $jalan = $_POST['jalan'];
    $skema_kerjasama = $_POST['skema_kerjasama'];
    $mitra = $_POST['mitra'];
    $bidang_usaha = $_POST['bidang_usaha'];
    $luas_objek = $_POST['luas_objek'];
    $nilai_kontrak = $_POST['nilai_kontrak'];
    $tgl_mulai = $_POST['tgl_mulai'];
    $tgl_berakhir = $_POST['tgl_berakhir'];
    $no_nik = $_POST['no_nik'];
    $no_kk = $_POST['no_kk'];
    $no_npwp = $_POST['no_npwp'];
    $tgl_bayar = $_POST['tgl_bayar'];
    $file_kmz_option = $_POST['file_kmz_option'];
    $created_by = $_POST['user_id'];
    $created_at = date('Y-m-d H:i:s');

    // File upload handling
    $uploads_dir = '../uploads/';
    
    // KMZ File or Coordinate Input Handling
    $kmz_file = null;
    if ($file_kmz_option == 'upload' && isset($_FILES['file_kmz'])) {
        $kmz_file = $uploads_dir . basename($_FILES['file_kmz']['name']);
        move_uploaded_file($_FILES['file_kmz']['tmp_name'], $kmz_file);
    } elseif ($file_kmz_option == 'coordinate') {
        $latitude = $_POST['latitude'];
        $longitude = $_POST['longitude'];
    }

    // Handle SHP and PKS file uploads
    $berkas_shp = null;
    if (isset($_FILES['berkas_shp'])) {
        $berkas_shp = $uploads_dir . basename($_FILES['berkas_shp']['name']);
        move_uploaded_file($_FILES['berkas_shp']['tmp_name'], $berkas_shp);
    }

    $berkas_pks = null;
    if (isset($_FILES['berkas_pks'])) {
        $berkas_pks = $uploads_dir . basename($_FILES['berkas_pks']['name']);
        move_uploaded_file($_FILES['berkas_pks']['tmp_name'], $berkas_pks);
    }

    // Handle NPWP and KTP images
    $foto_npwp = $uploads_dir . basename($_FILES['foto_npwp']['name']);
    move_uploaded_file($_FILES['foto_npwp']['tmp_name'], $foto_npwp);

    $foto_ktp = $uploads_dir . basename($_FILES['foto_ktp']['name']);
    move_uploaded_file($_FILES['foto_ktp']['tmp_name'], $foto_ktp);

    // Insert data into the database
    $sql = "INSERT INTO data_aset (no_kontrak, objek_kerjasama, provinsi, kabupaten, kecamatan, jalan, skema_kerjasama, mitra, bidang_usaha, luas_objek, nilai_kontrak, tgl_mulai, tgl_berakhir, no_nik, no_kk, no_npwp, tgl_bayar, file_kmz, latitude, longitude, berkas_shp, berkas_pks, foto_npwp, foto_ktp, created_at, created_by, updated_by)
            VALUES ('$no_kontrak', '$objek_kerjasama', '$provinsi', '$kabupaten', '$kecamatan', '$jalan', '$skema_kerjasama', '$mitra', '$bidang_usaha', '$luas_objek', '$nilai_kontrak', '$tgl_mulai', '$tgl_berakhir', '$no_nik', '$no_kk', '$no_npwp', '$tgl_bayar', '$kmz_file', '$latitude', '$longitude', '$berkas_shp', '$berkas_pks', '$foto_npwp', '$foto_ktp', '$created_at', '$created_by', '$created_by')";

    if (mysqli_query($conn, $sql)) {
        echo "Data uploaded successfully.";
        header("Location: data_aset.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
}
?>