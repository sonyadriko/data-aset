<?php
include '../config/database.php';
if(isset($_POST['provinsi_id'])) {
    $provinsi_id = $_POST['provinsi_id'];
    $query_kabupaten = "SELECT id, nama FROM kota_kabupaten WHERE provinsi_id = '$provinsi_id'";
    $result_kabupaten = mysqli_query($conn, $query_kabupaten);
    
    echo '<option value="">Pilih Kota/Kabupaten</option>';
    while ($row = mysqli_fetch_assoc($result_kabupaten)) {
        echo '<option value="'.$row['id'].'">'.$row['nama'].'</option>';
    }
}
?>