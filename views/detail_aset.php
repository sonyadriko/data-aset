<?php 
include '../config/database.php'; // Include your database connection
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Detail Aset</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc." />
    <meta name="author" content="Zoyothemes" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="../assets/images/favicon.ico">
    <!-- App css -->
    <link href="../assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style" />
    <!-- Icons -->
    <link href="../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <style>
    .lightbox {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.8);
    }

    .lightbox-content {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
    }

    .lightbox-content img {
        width: 100%;
        height: auto;
    }

    .close {
        position: absolute;
        top: 10px;
        right: 25px;
        color: #fff;
        font-size: 35px;
        font-weight: bold;
        transition: 0.3s;
    }

    .close:hover,
    .close:focus {
        color: #bbb;
        text-decoration: none;
        cursor: pointer;
    }
    </style>
</head>

<body data-menu-color="dark" data-sidebar="default">
    <!-- Begin page -->
    <div id="app-layout">
        <?php include 'partials/topbar.php'; ?>
        <?php include 'partials/sidebar.php'; ?>
        <div class="content-page">
            <div class="content">
                <!-- Start Content-->
                <div class="container-xxl">
                    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                        <div class="flex-grow-1">
                            <h4 class="fs-18 fw-semibold m-0">Detail Aset</h4>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 col-xl-12">
                            <div class="card">
                                <div class="card-body">

                                    <?php
                                    // Check if the ID is set in the URL
                                    if (isset($_GET['id'])) {
                                        $id = $_GET['id'];

                                        // Prepare and execute the SQL statement to fetch the asset details
                                        $query = "
                                        SELECT da.*, p.nama_provinsi AS provinsi_nama, k.nama AS kabupaten_nama, c.nama AS kecamatan_nama 
                                        FROM data_aset da
                                        JOIN provinsi p ON da.provinsi = p.id
                                        JOIN kota_kabupaten k ON da.kabupaten = k.id
                                        JOIN kecamatan c ON da.kecamatan = c.id
                                        WHERE da.no = ?
                                    ";
                                    
                                        $stmt = mysqli_prepare($conn, $query);
                                        mysqli_stmt_bind_param($stmt, 'i', $id);
                                        mysqli_stmt_execute($stmt);
                                        $result = mysqli_stmt_get_result($stmt);

                                        // Fetch the asset details
                                        if ($aset = mysqli_fetch_assoc($result)) {
                                            ?>
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>Kode Aset</th>
                                            <td><?= htmlspecialchars($aset['no_kontrak'] ?? 'NULL') ?></td>
                                        </tr>
                                        <tr>
                                            <th>Objek Kerjasama</th>
                                            <td><?= htmlspecialchars($aset['objek_kerjasama'] ?? 'NULL') ?></td>
                                        </tr>
                                        <tr>
                                            <th>Provinsi</th>
                                            <td><?= htmlspecialchars($aset['provinsi_nama'] ?? 'NULL') ?></td>
                                        </tr>
                                        <tr>
                                            <th>Kabupaten</th>
                                            <td><?= htmlspecialchars($aset['kabupaten_nama'] ?? 'NULL') ?></td>
                                        </tr>
                                        <tr>
                                            <th>Kecamatan</th>
                                            <td><?= htmlspecialchars($aset['kecamatan_nama'] ?? 'NULL') ?></td>
                                        </tr>
                                        <tr>
                                            <th>Alamat Lengkap</th>
                                            <td><?= htmlspecialchars($aset['jalan'] ?? 'NULL') ?></td>
                                        </tr>
                                        <tr>
                                            <th>Skema Kerjasama</th>
                                            <td><?= htmlspecialchars($aset['skema_kerjasama'] ?? 'NULL') ?></td>
                                        </tr>
                                        <tr>
                                            <th>Nama Mitra</th>
                                            <td><?= htmlspecialchars($aset['mitra'] ?? 'NULL') ?></td>
                                        </tr>
                                        <tr>
                                            <th>Bidang Usaha Mitra</th>
                                            <td><?= htmlspecialchars($aset['bidang_usaha'] ?? 'NULL') ?></td>
                                        </tr>
                                        <tr>
                                            <th>Luas Objek (Satuan m&sup2;)</th>
                                            <td><?= htmlspecialchars($aset['luas_objek'] ?? 'NULL') ?></td>
                                        </tr>
                                        <tr>
                                            <th>Nilai Kontrak</th>
                                            <td><?= htmlspecialchars($aset['nilai_kontrak'] ?? 'NULL') ?></td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Mulai</th>
                                            <td><?= htmlspecialchars($aset['tgl_mulai'] ?? 'NULL') ?></td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Berakhir</th>
                                            <td><?= htmlspecialchars($aset['tgl_berakhir'] ?? 'NULL') ?></td>
                                        </tr>
                                        <tr>
                                            <th>No NIK</th>
                                            <td><?= htmlspecialchars($aset['no_nik'] ?? 'NULL') ?></td>
                                        </tr>
                                        <tr>
                                            <th>No KK</th>
                                            <td><?= htmlspecialchars($aset['no_kk'] ?? 'NULL') ?></td>
                                        </tr>
                                        <tr>
                                            <th>No NPWP</th>
                                            <td><?= htmlspecialchars($aset['no_npwp'] ?? 'NULL') ?></td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Bayar</th>
                                            <td><?= htmlspecialchars($aset['tgl_bayar'] ?? 'NULL') ?></td>
                                        </tr>
                                        <!-- <tr>
                                            <th>Latitude</th>
                                            <td><?= htmlspecialchars($aset['latitude'] ?? 'NULL') ?></td>
                                        </tr>
                                        <tr>
                                            <th>Longitude</th>
                                            <td><?= htmlspecialchars($aset['longitude'] ?? 'NULL') ?></td>
                                        </tr> -->
                                        <tr>
                                            <th> Invoice (PDF)</th>
                                            <td>
                                                <?php if (!empty($aset['berkas_shp'])): ?>
                                                <embed src="<?= htmlspecialchars($aset['berkas_shp']) ?>"
                                                    type="application/pdf" width="100%" height="600px" />
                                                <?php else: ?>
                                                NULL
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th> Berkas PKS (PDF)</th>
                                            <td>
                                                <?php if (!empty($aset['berkas_pks'])): ?>
                                                <embed src="<?= htmlspecialchars($aset['berkas_pks']) ?>"
                                                    type="application/pdf" width="100%" height="600px" />
                                                <?php else: ?>
                                                NULL
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Foto NPWP</th>
                                            <td>
                                                <?php if (!empty($aset['foto_npwp'])): ?>
                                                <img src="<?= htmlspecialchars($aset['foto_npwp']) ?>" alt="Foto NPWP"
                                                    style="max-width: 100px; height: auto; cursor: pointer;"
                                                    onclick="openLightbox('<?= htmlspecialchars($aset['foto_npwp']) ?>')">
                                                <?php else: ?>
                                                NULL
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Foto KTP</th>
                                            <td>
                                                <?php if (!empty($aset['foto_ktp'])): ?>
                                                <img src="<?= htmlspecialchars($aset['foto_ktp']) ?>" alt="Foto KTP"
                                                    style="max-width: 100px; height: auto; cursor: pointer;"
                                                    onclick="openLightbox('<?= htmlspecialchars($aset['foto_ktp']) ?>')">
                                                <?php else: ?>
                                                NULL
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>File KMZ</th>
                                            <td>
                                                <?php if (!empty($aset['file_kmz'])): ?>
                                                <a href="<?= htmlspecialchars($aset['file_kmz']) ?>"
                                                    target="_blank">Download</a>
                                                <?php else: ?>
                                                NULL
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- Conditionally render the map if latitude and longitude are available -->

                                    <!-- Check if the KMZ file exists and generate its URL -->
                                    <?php $kmzFileUrl = !empty($aset['file_kmz']) ? htmlspecialchars($aset['file_kmz']) : null; ?>
                                    <?php if (!empty($aset['latitude']) && !empty($aset['longitude'])): ?>
                                    <div id="map" style="height: 500px; width: 100%;"></div>
                                    <?php endif; ?>

                                    <!-- <div id="map" style="height: 500px; width: 100%;"></div> -->
                                    <a href="data_aset.php" class="btn btn-secondary mt-2">Kembali</a>
                                    <?php
                                        } else {
                                            echo "Aset tidak ditemukan.";
                                        }

                                        // Close the statement
                                        mysqli_stmt_close($stmt);
                                    } else {
                                        echo "ID aset tidak ditentukan.";
                                    }

                                    // Close the database connection
                                    mysqli_close($conn);
                                    ?>
                                </div>
                                <div id="lightbox" class="lightbox">
                                    <span class="close" onclick="closeLightbox()">&times;</span>
                                    <img class="lightbox-content" id="lightbox-img">
                                </div>

                                <script>
                                function openLightbox(src) {
                                    var lightbox = document.getElementById('lightbox');
                                    var lightboxImg = document.getElementById('lightbox-img');
                                    lightbox.style.display = 'block';
                                    lightboxImg.src = src;
                                }

                                function closeLightbox() {
                                    var lightbox = document.getElementById('lightbox');
                                    lightbox.style.display = 'none';
                                }
                                </script>
                            </div>
                        </div>
                    </div>
                </div> <!-- container-fluid -->
            </div> <!-- content -->

            <?php include 'partials/footer.php'; ?>
        </div>
    </div>
    <!-- END wrapper -->

    <!-- Vendor -->
    <script src="../assets/libs/jquery/jquery.min.js"></script>
    <script src="../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/libs/simplebar/simplebar.min.js"></script>
    <script src="../assets/libs/node-waves/waves.min.js"></script>
    <script src="../assets/libs/waypoints/lib/jquery.waypoints.min.js"></script>
    <script src="../assets/libs/jquery.counterup/jquery.counterup.min.js"></script>
    <script src="../assets/libs/feather-icons/feather.min.js"></script>
    <!-- App js-->
    <script src="../assets/js/app.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCl8CzSftxYHaty68D40iqk123zm-7wrsc&callback=initMap"
        async defer>
    </script>
    <script>
    var latitude = <?= json_encode($aset['latitude'] ?? null) ?>;
    var longitude = <?= json_encode($aset['longitude'] ?? null) ?>;
    var kmzFileUrl = <?= json_encode($kmzFileUrl) ?>;

    function initMap() {
        var latitude = <?= json_encode($aset['latitude'] ?? 'null') ?>;
        var longitude = <?= json_encode($aset['longitude'] ?? 'null') ?>;
        var kmzFileUrl = <?= json_encode($kmzFileUrl) ?>;

        console.log(kmzFileUrl);

        var location = {
            lat: parseFloat(latitude),
            lng: parseFloat(longitude)
        };

        // Initialize the map
        var mapDiv = document.getElementById("map");
        if (!mapDiv) {
            console.error("Map div not found!");
            return;
        }

        var map = new google.maps.Map(mapDiv, {
            zoom: 15,
            center: location
        });

        // Add a marker at the location
        new google.maps.Marker({
            position: location,
            map: map,
            title: "Lokasi Aset"
        });

        // Validate the KMZ file URL
        // if (kmzFileUrl) {
        //     var layer = new google.maps.KmlLayer({
        //         url: kmzFileUrl,
        //         map: map
        //     });

        //     layer.addListener('status_changed', function() {
        //         if (layer.getStatus() !== google.maps.KmlLayerStatus.OK) {
        //             console.error('Error loading KMZ file: ' + layer.getStatus());
        //             alert('Error loading KMZ file: ' + layer.getStatus());
        //         }
        //     });
        // } else {
        //     console.error("KMZ file URL is not defined.");
        // }
    }
    </script>
</body>

</html>