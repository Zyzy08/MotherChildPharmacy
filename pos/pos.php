<?php include '../fetchUser.php'; ?>
<?php include 'fetchProductData.php'; ?>
<?php include 'fetchOrderNumber.php'; ?>


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

    <!-- Error Dialog -->
    <div class="toast-container position-fixed top-0 end-0 p-3"><div class="toast-container position-fixed top-0 start-50 translate-middle-x p-3">
      <div id="alert-toast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
          <div class="toast-header">
              <strong class="me-auto">Error</strong>
              <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
          </div>
          <div class="toast-body">
              Enter a valid quantity.
          </div>
      </div>
    </div>

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
          <a class="nav-link collapsed" href="../suppliers/suppliers.php">
              <i class="bi bi-truck"></i>
              <span>Suppliers</span>
          </a>
      </li><!-- End Suppliers Page Nav -->

      <li class="nav-item"></li>
      <a class="nav-link collapsed" href="../transactions/transactions.php">
          <i class="bi bi-cash-coin"></i>
          <span>Transactions</span>
      </a>
      </li><!-- End Transactions Page Nav -->

      <li class="nav-item"></li>
      <a class="nav-link collapsed" href="../purchaseorders/purchaseorders.php">
          <i class="bi bi-mailbox"></i>
          <span>Purchase Orders</span>
      </a>
      </li><!-- End Purchase Order Page Nav -->

      <li class="nav-item"></li>
      <a class="nav-link collapsed" href="../inventory/inventory.php">
          <i class="bi bi-box-seam"></i>
          <span>Inventory</span>
      </a>
      </li><!-- End Inventory Page Nav -->

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

      <li class="nav-item"></li>
      <a class="nav-link collapsed" href="../returnexchange/return.html">
          <i class="bi bi-cart-dash"></i>
          <span>Return & Exchange</span>
      </a>
      </li><!-- End Return & Exchange Page Nav -->

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
                          <div class="input-group">
                              <input type="text" name="query" placeholder="Search" title="Enter search keyword" class="form-control">
                              <span class="input-group-text">
                                  <i class="bi bi-search"></i>
                              </span>
                              <button type="button" title="Clear" class="btn btn-outline-secondary" id="clear-search">
                                  <i class="bi bi-x"></i>
                              </button>
                          </div>
                      </form>
                  </div>
                </div><!-- End Card Header -->
                
                <div class="card-body">

                  <div class="row align-items-top" id="product-list">
                    <!-- Product items will be inserted here dynamically -->
                  </div>

                </div><!-- End Card Body -->

                <!-- Pagination -->
                <div class="card-footer">
                  <div class="row align-items-top">

                    <!-- Pagination controls -->
                    <div class="col-lg-6">
                      <nav aria-label="Page navigation">
                        <ul class="pagination">
                          <li class="page-item" id="prev-page">
                            <a class="page-link" href="#">Previous</a>
                          </li>
                          <li class="page-item active" id="page-1">
                            <a class="page-link" href="#">1</a>
                          </li>
                          <li class="page-item" id="page-2">
                            <a class="page-link" href="#">2</a>
                          </li>
                          <li class="page-item" id="page-3">
                            <a class="page-link" href="#">3</a>
                          </li>
                          <li class="page-item" id="page-4">
                            <a class="page-link" href="#">4</a>
                          </li>
                          <li class="page-item" id="page-5">
                            <a class="page-link" href="#">5</a>
                          </li>
                          <li class="page-item" id="next-page">
                            <a class="page-link" href="#">Next</a>
                          </li>
                        </ul>
                      </nav>
                    </div><!-- End Pagination -->

                    <!-- Quantity Input -->
                    <div class="col-lg-3">
                        <input type="number" class="form-control" id="quantity-input" placeholder="Quantity" min="1">
                    </div>

                    <!-- Add Item Button -->
                    <div class="col-lg-3">
                        <div class="d-grid gap-2">
                            <button class="btn btn-primary" id="add-item-button" type="button">Add Item</button>
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
          <div class="card" id="basket">
              <div class="card-body">
                  <div class="list-group" id="basket-items" style="height: 500px; overflow-y: auto;">
                      <!-- Items will be dynamically inserted here -->
                  </div>
              </div>
              <div>
                  <div class="card-footer">
                      <div class="d-flex w-100 justify-content-between">
                          <small>Tax 12%:</small>
                          <p id="basket-tax">₱0.00</p>
                      </div>
                      <div class="d-flex w-100 justify-content-between">
                          <small>Total:</small>
                          <p id="basket-total">₱0.00</p>
                      </div>
                      <div class="d-grid gap-2 mt-3">
                        <button id="checkout" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#verticalycentered">
                          Checkout
                        </button>
                      </div>
                  </div>
              </div>
          </div>
        </div><!-- End Right side columns -->

      </div>
    </section>

    <!-- Checkout Modal -->
    <div class="modal fade" id="verticalycentered" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Checkout</h5>
          </div>
          <div class="modal-body">
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" id="seniorCitizenCheckbox">
              <label class="form-check-label" for="seniorCitizenCheckbox">Senior Citizen / PWD (20%)</label>
            </div>
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" id="promoCheckbox">
              <label class="form-check-label" for="promoCheckbox">Promotional (10%)</label>
            </div>
            <br><h2 id="total-display" style="font-weight: bold;">Total: ₱0.00</h2><br>

            <div class="row mb-0">
              <h2 for="paymentInput" class="col-sm-5" style="font-weight: bold;">Payment: ₱</h2>
              <div class="col-sm-6">
                <input type="number" id="paymentInput" class="form-control no-arrows" min="1" placeholder="0">
              </div>
            </div>

            <br><h2 id="change-display" style="font-weight: bold;">Change: ₱0.00</h2>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <div class="d-grid gap-2">
              <button id="confirm-button" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#largeModal" disabled>
                Confirm
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Receipt Modal -->
    <div class="modal fade" id="largeModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Receipt</h5>
          </div>

          <br><h5 style="font-weight: bold; text-align: center;">Mother & Child Pharmacy and Medical Supplies</h5>
          <h6 style="text-align: center;">Gen. Luna Street, Babo Sacan, Porac, Pampanga</h6>
          <h6 style="text-align: center;">
            ---------------------------------------------------------------------------------
          </h6><br>
          <div class="modal-body">
            <div id="receiptItems"></div> <!-- Container for receipt items -->
          </div>
          
          <div class="row text-center justify-content-between">
            <div class="col-xl-5">
              <small>Total Items:</small>
            </div>
            <div class="col-xl-5">
              <small id="total-items">0</small>
            </div>
          </div>

          <div class="row text-center justify-content-between">
            <div class="col-xl-5">
              <small>Subtotal:</small>
            </div>
            <div class="col-xl-5">
              <small id="sub-total">₱0.00</small>
            </div>
          </div>

          <div class="row text-center justify-content-between">
            <div class="col-xl-5">
              <small>Tax 12%:</small>
            </div>
            <div class="col-xl-5">
              <small id="tax">₱0.00</small>
            </div>
          </div>

          <div class="row text-center justify-content-between" style="font-weight: bold;">
            <div class="col-xl-5">
              <small>Amount Due:</small>
            </div>
            <div class="col-xl-5">
              <small id="amount-due">₱0.00</small>
            </div>
          </div>

          <div class="row text-center justify-content-between">
            <div class="col-xl-5">
              <small>Payment:</small>
            </div>
            <div class="col-xl-5">
              <small id="payment">₱0.00</small>
            </div>
          </div>

          <div class="row text-center justify-content-between">
            <div class="col-xl-5">
              <small>Change:</small>
            </div>
            <div class="col-xl-5">
              <small id="change">₱0.00</small>
            </div>
          </div>

          <h6 style="text-align: center;">
            ---------------------------------------------------------------------------------
          </h6>

          <div class="row text-center justify-content-between">
            <div class="col-xl-6">
              <small id="order-num">Order No.: #0000000</small>
            </div>
            <div class="col-xl-6">
              <small>Date: <?php echo date('F j, Y'); ?></small>
            </div>
          </div>

          <div class="row mb-3 text-center justify-content-between">
            <div class="col-xl-6">
              <small>Staff: <?php echo htmlspecialchars($employeeFullName); ?></small>
            </div>
            <div class="col-xl-6">
              <small>Time: 
                <?php date_default_timezone_set('Asia/Manila'); // Set timezone to GMT+8
                echo date('h:i A');?>
              </small>
            </div>
          </div>

          <div class="modal-footer">

            <button id="cancel-receipt" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

            <div class="d-grid gap-2">
              <button id="print-button" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">
                Print
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

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
  
  <!-- Template POS JS File -->
  <script src="pos.js"></script>

</body>

</html>