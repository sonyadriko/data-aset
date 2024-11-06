<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="User registration page." />
    <meta name="author" content="Zoyothemes" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="../assets/images/favicon.ico">

    <!-- App css -->
    <link href="../assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style" />

    <!-- Icons -->
    <link href="../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
</head>

<body class="bg-color">
    <!-- Begin page -->
    <div class="container-fluid">
        <div class="row vh-100">
            <div class="col-12">
                <div class="p-0">
                    <div class="row d-flex align-items-center">
                        <div class="col-md-6 col-xl-6 col-lg-6">
                            <div class="row">
                                <div class="col-md-6 mx-auto">
                                    <div class="mb-0 border-0">
                                        <div class="p-0">
                                            <div class="text-center">
                                                <div class="auth-title-section mb-3">
                                                    <h3 class="text-dark fs-20 fw-medium mb-2">Create an Account</h3>
                                                    <p class="text-dark text-capitalize fs-14 mb-0">Fill in your details
                                                        to register.</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="pt-0">
                                            <form id="registerForm" action="proses_register.php" method="POST"
                                                class="my-4">
                                                <div class="form-group mb-3">
                                                    <label for="email" class="form-label">Email</label>
                                                    <input class="form-control" type="email" id="email" name="email"
                                                        required placeholder="Enter your email">
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="password" class="form-label">Password</label>
                                                    <input class="form-control" type="password" required id="password"
                                                        name="password" placeholder="Enter your password">
                                                </div>

                                                <div class="form-group mb-0 row">
                                                    <div class="col-12">
                                                        <div class="d-grid">
                                                            <button class="btn btn-primary"
                                                                type="submit">Register</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            <div class="text-center text-muted">
                                                <p class="mb-0">Already have an account? <a
                                                        class='text-primary ms-2 fw-medium' href='login.php'>Log In</a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div
                            class="col-md-6 col-xl-6 col-lg-6 p-0 vh-100 d-flex justify-content-center account-page-bg">
                        </div>
                    </div>
                </div>
            </div>
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

    <!-- App js -->
    <script src="../assets/js/app.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    document.getElementById('registerForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the form from submitting normally
        const formData = new FormData(this);

        fetch('proses_register.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text()) // Change to text to inspect the raw response
            .then(data => {
                console.log('Raw response:', data); // Log the raw response
                try {
                    const jsonData = JSON.parse(data); // Parse the JSON data
                    if (jsonData.success) {
                        Swal.fire({
                            title: 'Registration Successful',
                            icon: 'success'
                        }).then(() => {
                            window.location.href = 'login.php'; // Redirect to login page
                        });
                    } else {
                        Swal.fire({
                            title: 'Registration Failed',
                            text: jsonData.message,
                            icon: 'error'
                        });
                    }
                } catch (error) {
                    console.error('Error parsing JSON:', error);
                    Swal.fire({
                        title: 'Error',
                        text: 'An unexpected error occurred. Please try again.',
                        icon: 'error'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error',
                    text: 'Network error. Please check your connection.',
                    icon: 'error'
                });
            });
    });
    </script>
</body>

</html>