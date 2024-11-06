<?php
include '../config/database.php';


// Prepare your SQL query
$query = "SELECT COUNT(*) AS total FROM data_aset WHERE tgl_berakhir <= CURDATE() + INTERVAL 30 DAY AND deleted_at IS NULL";
$query2 = "SELECT COUNT(*) AS total_aset FROM data_aset";
// Execute the query
$result = mysqli_query($conn, $query);
$result2 = mysqli_query($conn, $query2);

// Fetch the result
if ($result) {
    $data = mysqli_fetch_assoc($result);
    $total_assets = $data['total'];
} else {
    $total_assets = 0; // Set to 0 if the query fails
}

if ($result2) {
    $data2 = mysqli_fetch_assoc($result2);
    $total_assets_all = $data2['total_aset'];
} else {
    $total_assets_all = 0; // Set to 0 if the query fails
}


?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Dashboard</title>
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

                    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                        <div class="flex-grow-1">
                            <h4 class="fs-18 fw-semibold m-0">Dashboard</h4>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-xl-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <p class="text-muted mb-3 fw-semibold">Total Aset yang akan berakhir 1
                                                bulan</p>
                                            <h4 class="m-0 mb-3 fs-18">
                                                <a href="data_aset_alert.php"><?= $total_assets; ?> Aset</a>
                                            </h4>

                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-6 col-xl-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <p class="text-muted mb-3 fw-semibold">Total Aset Keseluruhan</p>
                                            <h4 class="m-0 mb-3 fs-18">
                                                <?= $total_assets_all; ?> Aset</a>
                                            </h4>

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

    <!-- Apexcharts JS -->
    <script src="../assets/libs/apexcharts/apexcharts.min.js"></script>

    <!-- for basic area chart -->
    <script src="https://apexcharts.com/samples/../assets/stock-prices.js"></script>

    <!-- Widgets Init Js -->
    <script src="../assets/js/pages/dashboard.init.js"></script>

    <!-- App js-->
    <script src="../assets/js/app.js"></script>

</body>

</html>