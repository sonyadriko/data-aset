<?php
include '../config/database.php';
if(isset($_POST['kabupaten_id'])) {
    $kabupaten_id = $_POST['kabupaten_id'];
    $query_kecamatan = "SELECT id, nama FROM kecamatan WHERE kota_kabupaten_id = '$kabupaten_id'";
    $result_kecamatan = mysqli_query($conn, $query_kecamatan);
    
    echo '<option value="">Pilih Kecamatan</option>';
    while ($row = mysqli_fetch_assoc($result_kecamatan)) {
        echo '<option value="'.$row['id'].'">'.$row['nama'].'</option>';
    }
}
?>