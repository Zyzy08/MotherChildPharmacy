<?php include '../fetchUser.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>POS - Mother & Child Pharmacy and Medical Supplies</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="../resources/img/favicon.png" rel="icon">
  <link href="../resources/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../resources/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../resources/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../resources/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="../resources/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="../resources/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="../resources/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="../resources/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- POS CSS File -->
  <link href="pos_styles.css" rel="stylesheet">

</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <i class="bi bi-list toggle-sidebar-btn"></i>
      <a href="pos.php" class="logo d-flex align-items-center">
        <img src="../resources/img/logo.png" alt="">
        <span class="d-none d-lg-block span1">Mother & Child</span>
        <span class="d-none d-lg-block span2">Pharmacy and Medical Supplies</span>
      </a>
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="../users/uploads/<?php echo htmlspecialchars($picture); ?>" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo htmlspecialchars($formattedName); ?></span>
          </a><!-- End Profile Image Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6><?php echo htmlspecialchars($employeeFullName); ?></h6>
              <span><?php echo htmlspecialchars($role); ?></span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="../users/users-profile/users-profile.php">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center sign-out-link" href="../#">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>            

          </ul><!-- End Profile Dropdown Items -->

        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link collapsed" href="../dashboard/dashboard.php">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-heading"></li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="../suppliers/suppliers.html">
          <i class="bi bi-truck"></i>
          <span>Suppliers</span>
        </a>
      </li><!-- End Suppliers Page Nav -->

      <li class="nav-item"></li>
        <a class="nav-link collapsed" href="../transactions/transactions.html">
          <i class="bi bi-cash-coin"></i>
          <span>Transactions</span>
        </a>
      </li><!-- End Transactions Page Nav -->

      <li class="nav-item"></li>
        <a class="nav-link collapsed" href="../inventory/inventory.php">
          <i class="bi bi-box-seam"></i>
          <span>Inventory</span>
        </a>
      </li><!-- End Inventory Page Nav -->

      <li class="nav-item"></li>
        <a class="nav-link collapsed" href="../returnexchange/return.html">
          <i class="bi bi-cart-dash"></i>
          <span>Return & Exchange</span>
        </a>
      </li><!-- End Return & Exchange Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="../users/users.php">
          <i class="bi bi-person"></i>
          <span>Users</span>
        </a>
      </li><!-- End Users Page Nav -->

      <li class="nav-heading"></li>

      <li class="nav-item"></li>
        <a class="nav-link" href="pos.php">
          <i class="bi bi-printer"></i>
          <span>POS</span>
        </a>
      </li><!-- End POS Page Nav -->

    </ul>

  </aside><!-- End Sidebar-->

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>POS</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="../dashboard/dashboard.php">Home</a></li>
          <li class="breadcrumb-item active">POS</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section pos">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-8">
          <div class="row">

            <!-- Product List -->
            <div class="col-12">
              <div class="card">

                <div class="card-header">
                  <div class="search-bar">
                    <form class="search-form d-flex align-items-center" method="POST" action="#">
                      <input type="text" name="query" placeholder="Search" title="Enter search keyword">
                      <button type="submit" title="Search"><i class="bi bi-search"></i></button>
                    </form>
                  </div>
                </div><!-- End Card Header -->
                
                <div class="card-body">

                  <div class="row align-items-top">

                    <div class="col-lg-3">
                      <!-- Card with an image on top -->
                      <div class="card clickable-card">
                        <img src="../inventory/products-icon/biogesic.png" class="card-img-top"
                          style="width: 100px; height: 100px; object-fit: contain; margin: 0 auto;">
                        <div class="card-body">
                          <h5 class="card-title">Biogesic</h5>
                          <p class="card-text">Paracetamol</p>
                        </div>
                      </div><!-- End Card with an image on top -->
                    </div>

                    <div class="col-lg-3">
                      <!-- Card with an image on top -->
                      <div class="card clickable-card">
                        <img src="../inventory/products-icon/Advil.png" class="card-img-top"
                          style="width: 100px; height: 100px; object-fit: contain; margin: 0 auto;">
                        <div class="card-body">
                          <h5 class="card-title">Advil</h5>
                          <p class="card-text">Ibuprofen</p>
                        </div>
                      </div><!-- End Card with an image on top -->
                    </div>

                    <style>
                      .clickable-card {
                        cursor: pointer;
                        transition: background-color 0.3s, box-shadow 0.3s;
                      }

                      .clickable-card:hover {
                        background-color: #f8f9fa; /* Light highlight color on hover */
                      }

                      .clickable-card.active {
                        background-color: #e0e0e0; /* Highlight color when clicked */
                        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
                      }
                    </style>

                    <script>
                      // Select all card elements
                      const cards = document.querySelectorAll('.clickable-card');

                      // Add a click event listener to each card
                      cards.forEach(card => {
                        card.addEventListener('click', function() {
                          // Remove 'active' class from all cards
                          cards.forEach(c => c.classList.remove('active'));
                          // Add 'active' class to the clicked card
                          this.classList.add('active');
                        });
                      });
                    </script>


                    <div class="col-lg-3">
                      <!-- Card with an image on top -->
                      <div class="card">
                        <img src="../inventory/products-icon/buscopanVenus.png" class="card-img-top"
                          style="width: 100px; height: 100px; object-fit: contain; margin: 0 auto;">
                        <div class="card-body">
                          <h5 class="card-title">Buscopan Venus</h5>
                          <p class="card-text">Hyoscine</p>
                        </div>
                      </div><!-- End Card with an image on top -->
                    </div>

                    <div class="col-lg-3">
                      <!-- Card with an image on top -->
                      <div class="card">
                        <img src="../inventory/products-icon/Diatabs.png" class="card-img-top"
                          style="width: 100px; height: 100px; object-fit: contain; margin: 0 auto;">
                        <div class="card-body">
                          <h5 class="card-title">Diatabs</h5>
                          <p class="card-text">Loperamide</p>
                        </div>
                      </div><!-- End Card with an image on top -->
                    </div>

                  </div>

                  <div class="row align-items-top">
                    
                    <div class="col-lg-3">
                      <!-- Card with an image on top -->
                      <div class="card">
                        <img src="../inventory/products-icon/Imodium.png" class="card-img-top"
                          style="width: 100px; height: 100px; object-fit: contain; margin: 0 auto;">
                        <div class="card-body">
                          <h5 class="card-title">Imodium</h5>
                          <p class="card-text">Loperamide</p>
                        </div>
                      </div><!-- End Card with an image on top -->
                    </div>

                    <div class="col-lg-3">
                      <!-- Card with an image on top -->
                      <div class="card">
                        <img src="../inventory/products-icon/kremilS.png" class="card-img-top"
                          style="width: 100px; height: 100px; object-fit: contain; margin: 0 auto;">
                        <div class="card-body">
                          <h5 class="card-title">Kremil S</h5>
                          <p class="card-text">Aluminum Hydroxide</p>
                        </div>
                      </div><!-- End Card with an image on top -->
                    </div>

                    <div class="col-lg-3">
                      <!-- Card with an image on top -->
                      <div class="card">
                        <img src="../inventory/products-icon/medicol.png" class="card-img-top"
                          style="width: 100px; height: 100px; object-fit: contain; margin: 0 auto;">
                        <div class="card-body">
                          <h5 class="card-title">Medicol Advance</h5>
                          <p class="card-text">Ibuprofen</p>
                        </div>
                      </div><!-- End Card with an image on top -->
                    </div>

                    <div class="col-lg-3">
                      <!-- Card with an image on top -->
                      <div class="card">
                        <img src="../inventory/products-icon/neozep.png" class="card-img-top"
                          style="width: 100px; height: 100px; object-fit: contain; margin: 0 auto;">
                        <div class="card-body">
                          <h5 class="card-title">Neozep</h5>
                          <p class="card-text">Paracetamol</p>
                        </div>
                      </div><!-- End Card with an image on top -->
                    </div>

                  </div>

                </div><!-- End Card Body -->

                <div class="card-footer">
                  <div class="row align-items-top">

                    <!-- Pages -->
                    <div class="col-lg-6">
                      <nav aria-label="Pages">
                        <ul class="pagination">
                          <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                          </li>
                          <li class="page-item active" aria-current="page"><a class="page-link" href="#">1</a></li>
                          <li class="page-item"><a class="page-link" href="#">2</a></li>
                          <li class="page-item"><a class="page-link" href="#">3</a></li>
                          <li class="page-item">
                            <a class="page-link" href="#">Next</a>
                          </li>
                        </ul>
                      </nav>
                    </div>
                    
                    <!-- Quantity -->
                    <div class="col-lg-3">
                      <input type="number" class="form-control">
                    </div>

                    <!-- Add Item Button -->
                    <div class="col-lg-3">
                      <div class="d-grid gap-2">
                        <button class="btn btn-primary" type="button">Add Item</button>
                      </div>
                    </div>

                  </div>
                </div><!-- End Card Footer -->

              </div>
            </div><!-- End Product List -->

          </div>
        </div><!-- End Left side columns -->

        <!-- Right side columns -->
        <div class="col-lg-4">

          <!-- Basket -->
          <div class="card">
            <div class="card-body">
              <div class="list-group" style="height: 500px; overflow-y: auto;">

                <a href="#" class="list-group-item list-group-item-action">
                  <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">Biogesic</h5>
                    <button type="button" class="btn btn-danger btn-sm-custom">
                      <i class="bi bi-trash"></i>
                    </button>
                  </div>
                  <p class="mb-1">Paracetamol</p>
                  <div class="d-flex w-100 justify-content-between">
                    <small>₱20</small>
                    <small>x2</small>
                  </div>
                </a>

                <a href="#" class="list-group-item list-group-item-action">
                  <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">Advil</h5>
                    <button type="button" class="btn btn-danger btn-sm-custom">
                      <i class="bi bi-trash"></i>
                    </button>
                  </div>
                  <p class="mb-1">Ibuprofen</p>
                  <div class="d-flex w-100 justify-content-between">
                    <small>₱10</small>
                    <small>x1</small>
                  </div>
                </a>

              </div><!-- End List group Advanced Content -->
            </div>

            <div>
              <div class="card-footer">

                <div class="d-flex w-100 justify-content-between">
                  <small>Tax 12%:</small>
                  <p>₱3.6</p>
                </div><!-- Tax -->

                <div class="d-flex w-100 justify-content-between">
                  <small>Total:</small>
                  <p>₱30.6</p>
                </div><!-- Total -->

                <div class="d-grid gap-2 mt-3">
                  <button class="btn btn-primary" type="button">Checkout</button>
                </div><!-- Checkout Button -->

              </div><!-- End Basket Footer -->
            </div>

          </div><!-- End Basket -->
        </div><!-- End Right side columns -->

      </div>
    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>Mother & Child Pharmacy and Medical Supplies</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
      Designed by <a href="https://www.sti.edu/campuses-details.asp?campus_id=QU5H">STI College Angeles - BSIT4-A s.y 2024-2025 </a>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="../resources/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="../resources/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../resources/vendor/chart.js/chart.umd.js"></script>
  <script src="../resources/vendor/echarts/echarts.min.js"></script>
  <script src="../resources/vendor/quill/quill.js"></script>
  <script src="../resources/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="../resources/vendor/tinymce/tinymce.min.js"></script>
  <script src="../resources/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="../main.js"></script>

</body>

</html>