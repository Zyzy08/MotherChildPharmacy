<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Login - Mother & Child Pharmacy and Medical Supplies</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="resources/img/favicon.png" rel="icon">
  <link href="resources/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="resources/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="resources/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="resources/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="resources/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="resources/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="resources/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="resources/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="style.css" rel="stylesheet">

</head>

<body>

  <main>
      <div class="container">

        <section class="section register min-vh-90 d-flex flex-column align-items-center justify-content-center py-4 position-relative">

          <div class="container">
            <div class="row justify-content-center">
              <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                <div class="d-flex justify-content-center py-4">
                  <a href="index.html" class="logo d-flex align-items-center w-auto">
                      <img src="resources/img/logo.png" alt="">
                      <div class="d-flex flex-column">
                          <span class="d-none d-lg-block span1">Mother & Child</span>
                          <span class="d-none d-lg-block span3">Pharmacy and Medical Supplies</span>
                      </div>
                  </a>
                </div><!-- End Logo -->
                
                <div class="card mb-3">

                  <div class="card-body">

                    <div class="pt-4 pb-2">
                      <h5 class="card-title text-center pb-0 fs-4">Login</h5>
                      <p class="text-center small">Enter your username & password to login</p>
                    </div>

                    <form action="checkCredentials.php" method="POST">

                      <div class="col-12">
                        <label for="username" class="form-label">Username</label>
                        <div class="input-group has-validation">
                          <input type="text" name="username" class="form-control" id="username" required>
                          <div class="invalid-feedback">Please enter your username.</div>
                        </div>
                      </div>

                      <div class="col-12 position-relative">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="password" required>
                        <div class="invalid-feedback">Please enter your password!</div>
                        <!-- Password toggle icon -->
                        <img src="resources/img/show.png" alt="Toggle Password" id="toggle-password" class="toggle-password">
                      </div>

                      <div class="col-12">
                        <button class="btn btn-primary w-100" type="submit">Login</button>
                      </div>

                    </form>

                    <?php
                    session_start();
                    if (isset($_SESSION['login_error']) && $_SESSION['login_error'] !== "") {
                        $error_id = $_SESSION['login_error_id'];
                        echo '<p id="error-' . $error_id . '" class="error-message">' . $_SESSION['login_error'] . '</p>';
                        unset($_SESSION['login_error']);
                        unset($_SESSION['login_error_id']);
                    }
                    ?>

                  </div>
                </div>

              </div>
            </div>
          </div>
        
        </section>

      </div>
  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer1" class="footer1">

    <!-- Right Decoration -->
    <img src="resources/img/right_dec.png" alt="Right Decoration" class="right-dec position-absolute start-0 top-50 translate-middle-y">

    <!-- Left Decoration -->
    <img src="resources/img/left_dec.png" alt="Left Decoration" class="left-dec position-absolute end-0 top-50 translate-middle-y">

    <div class="border">
      <div class="copyright">
        &copy; Copyright <strong><span>Mother & Child Pharmacy and Medical Supplies</span></strong>. All Rights Reserved
      </div>
      <div class="credits">
        Designed by <a href="https://www.sti.edu/campuses-details.asp?campus_id=QU5H">STI College Angeles - BSIT4-A s.y 2024-2025 </a>
      </div>
    </div>

  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="resources/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="resources/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="resources/vendor/chart.js/chart.umd.js"></script>
  <script src="resources/vendor/echarts/echarts.min.js"></script>
  <script src="resources/vendor/quill/quill.js"></script>
  <script src="resources/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="resources/vendor/tinymce/tinymce.min.js"></script>
  <script src="resources/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="main.js"></script>

</body>

</html>