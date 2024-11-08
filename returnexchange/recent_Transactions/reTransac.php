<?php include '../../fetchUser.php'; ?>
<?php include '../fetchProductData.php'; ?>
<?php include '../fetchOrderNumber.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Transactions - Mother & Child Pharmacy and Medical Supplies</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="../../resources/img/favicon.png" rel="icon">
  <link href="../../resources/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../../resources/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../../resources/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../../resources/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="../../resources/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="../../resources/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="../../resources/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="../../resources/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Return and Exchange Transactions CSS File -->
  <link href="reTransac.css" rel="stylesheet">

</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <i class="bi bi-list toggle-sidebar-btn"></i>
      <a href="reTransac.php" class="logo d-flex align-items-center">
        <img src="../../resources/img/logo.png" alt="">
        <span class="d-none d-lg-block span1">Mother & Child</span>
        <span class="d-none d-lg-block span2">Pharmacy and Medical Supplies</span>
      </a>
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="../../users/uploads/<?php echo htmlspecialchars($picture); ?>" alt="Profile" class="rounded-circle">
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
              <a class="dropdown-item d-flex align-items-center" href="../../users/users-profile/users-profile.php">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center sign-out-link" href="../../#">
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
            <a class="nav-link collapsed" href="../../dashboard/dashboard.php">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-heading"></li>

        <?php if ($_SESSION['SuppliersPerms'] === 'on'): ?>
        <li class="nav-item">
            <a class="nav-link collapsed" href="../../suppliers/suppliers.php">
                <i class="bi bi-shop"></i>
                <span>Suppliers</span>
            </a>
        </li><!-- End Suppliers Page Nav -->
        <?php endif; ?>

        <?php if ($_SESSION['TransactionsPerms'] === 'on'): ?>
        <li class="nav-item">
            <a class="nav-link collapsed" href="../../transactions/transactions.php">
                <i class="bi bi-cash-coin"></i>
                <span>Transactions</span>
            </a>
        </li><!-- End Transactions Page Nav -->
        <?php endif; ?>

        <?php if ($_SESSION['POPerms'] === 'on'): ?>
        <li class="nav-item">
            <a class="nav-link collapsed" href="../../purchaseorders/purchaseorders.php">
                <i class="bi bi-mailbox"></i>
                <span>Purchase Orders</span>
            </a>
        </li><!-- End Purchase Order Page Nav -->
        <?php endif; ?>

        <?php if ($_SESSION['POPerms'] === 'on'): ?>
        <li class="nav-item">
            <a class="nav-link collapsed" href="../../delivery/delivery.php">
                <i class="bi bi-truck"></i>
                <span>Deliveries</span>
            </a>
        </li><!-- End Deliveries Page Nav -->
        <?php endif; ?>

        <?php if ($_SESSION['InventoryPerms'] === 'on'): ?>
        <li class="nav-item">
            <a class="nav-link collapsed" href="../../inventory/inventory.php">
                <i class="bi bi-box-seam"></i>
                <span>Inventory</span>
            </a>
        </li><!-- End Inventory Page Nav -->
        <?php endif; ?>

        <li class="nav-heading"></li>

        <?php if ($_SESSION['POSPerms'] === 'on'): ?>
        <li class="nav-item">
            <a class="nav-link collapsed" href="../../pos/pos.php">
                <i class="bi bi-printer"></i>
                <span>POS</span>
            </a>
        </li><!-- End POS Page Nav -->
        <?php endif; ?>

        <?php if ($_SESSION['REPerms'] === 'on'): ?>
        <li class="nav-item">
            <a class="nav-link" href="../../returnexchange/returnexchange.php">
                <i class="bi bi-cart-dash"></i>
                <span>Return & Exchange</span>
            </a>
        </li><!-- End Return & Exchange Page Nav -->
        <?php endif; ?>

        <li class="nav-heading"></li>

        <?php if ($_SESSION['UsersPerms'] === 'on'): ?>
        <li class="nav-item">
            <a class="nav-link collapsed" href="../../users/users.php">
                <i class="bi bi-person"></i>
                <span>Users</span>
            </a>
        </li><!-- End Users Page Nav -->
        <?php endif; ?>

        <?php if ($_SESSION['UsersPerms'] === 'on'): ?>
        <li class="nav-item">
            <a class="nav-link collapsed" href="../../audittrail/audittrail.php">
                <i class="bi bi-clipboard-data"></i>
                <span>Audit Trail</span>
            </a>
        </li><!-- End Audit Trail Page Nav -->
        <?php endif; ?>

        <?php if ($_SESSION['UsersPerms'] === 'on'): ?>
        <li class="nav-item">
            <a class="nav-link collapsed" href="../../backuprestore/backuprestore.php">
                <i class="bi bi-cloud-check"></i>
                <span>Backup & Restore</span>
            </a>
        </li><!-- End B&R Page Nav -->
        <?php endif; ?>

    </ul>

  </aside><!-- End Sidebar -->

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Return & Exchange</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="../../dashboard/dashboard.php">Home</a></li>
          <li class="breadcrumb-item"><a href="../../returnexchange/returnexchange.php">Return & Exchange</a></li>
          <li class="breadcrumb-item active">Transactions</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section pos">
      <div class="row">
        <div class="col-lg-12">

          <?php
          // Database connection
          $conn = new mysqli($servername, $username, $password, $dbname);

          if ($conn->connect_error) {
              die("Connection failed: " . $conn->connect_error);
          }
          ?>

          <div class="card">
              <div class="card-body" style="height: 425px; overflow-y: auto;">
                  <div class="accordion" id="accordionExample">
                      <?php
                      // Fetch sales data
                      $sql = "SELECT * FROM sales ORDER BY SaleDate DESC";
                      $result = $conn->query($sql);

                      if ($result->num_rows > 0) {
                          while($row = $result->fetch_assoc()) {
                              // Format date and time
                              $dateTime = new DateTime($row['SaleDate']);
                              $formattedDate = $dateTime->format('M d, Y');
                              $formattedTime = $dateTime->format('h:i A');

                              // Format monetary values
                              $netAmount = number_format($row['NetAmount'], 2);

                              echo <<<HTML
                              <div class="accordion-item">
                                  <h2 class="accordion-header" id="heading{$row['InvoiceID']}">
                                      <button class="accordion-button collapsed" type="button" 
                                              data-bs-toggle="collapse" 
                                              data-bs-target="#collapse{$row['InvoiceID']}" 
                                              aria-expanded="false" 
                                              aria-controls="collapse{$row['InvoiceID']}">
                                          <div style="position: relative; width: 100%;">
                                              <div style="position: absolute; left: 0;">
                                                  <strong>Order #{$row['InvoiceID']}</strong>&nbsp;
                                                  <span>{$formattedDate} | {$formattedTime}</span>
                                              </div>
                                              <div style="position: absolute; right: 0; margin-right: 50px;">
                                                  <span style="text-decoration: underline;">{$row['TotalItems']} item/s</span>&nbsp;
                                                  <span>|</span>&nbsp;
                                                  <span style="text-decoration: underline;">₱{$netAmount}</span>
                                              </div>
                                          </div>
                                      </button>
                                  </h2>
                                  <div id="collapse{$row['InvoiceID']}" 
                                      class="accordion-collapse collapse" 
                                      aria-labelledby="heading{$row['InvoiceID']}" 
                                      data-bs-parent="#accordionExample">
                                      <div class="accordion-body">
                                        <div class="card mb-3">
                                            <div class="row g-0" style="height: 200px">
                                                <div class="col-md-4">
                                                    <img src="../../inventory/products-icon/sample.png" class="img-fluid rounded-start" alt="Product Icon" style="height: 100%; object-fit: cover;">
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="card-body">
                                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                                            <span class="badge bg-info text-dark">x0</span>
                                                            <span class="badge bg-primary">₱0.00</span>
                                                        </div>
                                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                                          <small class="card-text">₱0.00</small>
                                                          <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" id="gridCheck1">
                                                            <label class="form-check-label" for="gridCheck1">
                                                              Return
                                                            </label>
                                                          </div>
                                                        </div>
                                                        <h5 class="card-title">Brand_name 0mg</h5>
                                                        <p class="card-text">Generic_name</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-primary">Select Order</button>
                                    </div>
                                  </div>
                              </div>
          HTML;
                          }
                      } else {
                          echo '<div class="alert alert-info">No transactions found.</div>';
                      }
                      ?>
                  </div>
              </div>
          </div>

          <?php
          $conn->close();
          ?>

        </div>
      </div>
    </section>
  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>Mother & Child Pharmacy and Medical Supplies</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
      Designed by <a href="https://www.sti.edu/campuses-details.asp?campus_id=QU5H">STI College Angeles - BSIT4-A S.Y 2024-2025 </a>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="../../resources/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="../../resources/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../../resources/vendor/chart.js/chart.umd.js"></script>
  <script src="../../resources/vendor/echarts/echarts.min.js"></script>
  <script src="../../resources/vendor/quill/quill.js"></script>
  <script src="../../resources/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="../../resources/vendor/tinymce/tinymce.min.js"></script>
  <script src="../../resources/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="../../main.js"></script>
  
  <!-- Template Return and Exchange JS File -->
  <script src="reTransac.js"></script>

</body>

</html>