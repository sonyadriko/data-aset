<?php 
include '../config/database.php';

error_reporting(E_ALL);
ini_set('display_errors', 1); ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Data Aset</title>
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

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">

</head>

<!-- body start -->

<body data-menu-color="dark" data-sidebar="default">

    <!-- Begin page -->
    <div id="app-layout">


        <!-- Topbar Start -->
        <?php include 'partials/topbar.php' ?>
        <!-- end Topbar -->

        <!-- Left Sidebar Start -->
        <?php include 'partials/sidebar.php' ?>

        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">

                <!-- Start Content-->
                <div class="container-xxl">
                    <!-- <div class="container-xxl"> -->

                    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                        <div class="flex-grow-1">
                            <h4 class="fs-18 fw-semibold m-0">Data Aset</h4>
                            <a href="tambah_aset.php" class="btn btn-primary">
                                Tambah Data Aset
                            </a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 col-xl-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="table-responsive">
                                            <table id="areaTable" class="table table-hover table-bordered mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Kode Aset</th>
                                                        <th>Objek Kerjasama</th>
                                                        <th>Nama Mitra</th>
                                                        <th>Tanggal Mulai</th>
                                                        <th>Tanggal Berakhir</th>
                                                        <th>Update Terakhir</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                            $nomor = 1;
                                            $get_data = mysqli_query($conn, "
                                            SELECT * 
                                            FROM data_aset da
                                            JOIN PROVINSI ON da.provinsi = provinsi.id 
                                            JOIN user ON da.updated_by = user.id
                                            WHERE da.deleted_at IS NULL
                                        ");
                                            // $get_data = mysqli_query($conn, "SELECT * FROM data_aset WHERE deleted_at = NULL");
                                            while($display = mysqli_fetch_array($get_data)) {
                                                $no = $display['no'];
                                                $no_kontrak = $display['no_kontrak'];
                                                $objek = $display['objek_kerjasama'];                                            
                                                $mitra = $display['mitra'];
                                                $provinsi = $display['nama_provinsi'];
                                                $tgl_mulai = $display['tgl_mulai'];
                                                $tgl_berakhir = $display['tgl_berakhir'];
                                                $updated_at = $display['updated_at'];
                                                $updated_by = $display['username'];
                                              
                                            ?>
                                                    <tr>
                                                        <td><?php echo $nomor; ?></td>
                                                        <td><?php echo $no_kontrak; ?></td>
                                                        <td><?php echo $objek; ?></td>
                                                        <td><?php echo $mitra; ?></td>
                                                        <td><?php echo $tgl_mulai; ?></td>
                                                        <td><?php echo $tgl_berakhir; ?></td>
                                                        <td><?php echo $updated_at, " ", $updated_by; ?></td>
                                                        <td>
                                                            <div class="action-buttons">
                                                                <a href='edit_aset.php?id=<?php echo $no; ?>'
                                                                    class="btn btn-warning btn-user">Ubah</a>
                                                                <a href='detail_aset.php?id=<?php echo $no; ?>'
                                                                    class="btn btn-primary btn-user">Detail</a>
                                                                <button class="btn btn-danger btn-user delete-btn"
                                                                    data-id="<?= $no; ?>">Hapus</button>

                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php
                                            $nomor++;
                                                }
                                            ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>


                </div> <!-- container-fluid -->
            </div> <!-- content -->

            <!-- Footer Start -->
            <?php include 'partials/footer.php' ?>

            <!-- end Footer -->

        </div>
        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->


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
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js">
    </script>
    <script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#areaTable').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "lengthChange": true,
            "pageLength": 10,
            "language": {
                "paginate": {
                    "previous": "<i class='bi bi-arrow-left'></i>",
                    "next": "<i class='bi bi-arrow-right'></i>"
                }
            }
        });
    });
    </script>
    <script>
    $(document).ready(function() {
        $('.delete-btn').on('click', function() {
            var assetId = $(this).data('id');
            if (confirm('Are you sure you want to delete this asset?')) {
                $.ajax({
                    url: 'delete_aset.php?id=' + assetId,
                    type: 'POST',
                    success: function(response) {
                        alert(response); // Show success message
                        location.reload(); // Reload the page to reflect changes
                    },
                    error: function(xhr, status, error) {
                        alert('An error occurred: ' + error); // Show error message
                    }
                });
            }
        });
    });
    </script>

</body>

</html>