<?php include '../fetchUser.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Dashboard - Mother & Child Pharmacy and Medical Supplies</title>
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

  <!-- Template Main CSS File -->
  <link href="../style.css" rel="stylesheet">

</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <i class="bi bi-list toggle-sidebar-btn"></i>
      <a href="dashboard.php" class="logo d-flex align-items-center">
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
            <a class="nav-link" href="../dashboard/dashboard.php">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-heading"></li>

        <?php if ($_SESSION['SuppliersPerms'] === 'on'): ?>
        <li class="nav-item">
            <a class="nav-link collapsed" href="../suppliers/suppliers.php">
                <i class="bi bi-shop"></i>
                <span>Suppliers</span>
            </a>
        </li><!-- End Suppliers Page Nav -->
        <?php endif; ?>

        <?php if ($_SESSION['TransactionsPerms'] === 'on'): ?>
        <li class="nav-item">
            <a class="nav-link collapsed" href="../transactions/transactions.php">
                <i class="bi bi-cash-coin"></i>
                <span>Transactions</span>
            </a>
        </li><!-- End Transactions Page Nav -->
        <?php endif; ?>

        <?php if ($_SESSION['POPerms'] === 'on'): ?>
        <li class="nav-item">
            <a class="nav-link collapsed" href="../purchaseorders/purchaseorders.php">
                <i class="bi bi-mailbox"></i>
                <span>Purchase Orders</span>
            </a>
        </li><!-- End Purchase Order Page Nav -->
        <?php endif; ?>

        <?php if ($_SESSION['POPerms'] === 'on'): ?>
        <li class="nav-item">
            <a class="nav-link collapsed" href="../delivery/delivery.php">
                <i class="bi bi-truck"></i>
                <span>Delivery</span>
            </a>
        </li><!-- End Delivery Page Nav -->
        <?php endif; ?>

        <?php if ($_SESSION['InventoryPerms'] === 'on'): ?>
        <li class="nav-item">
            <a class="nav-link collapsed" href="../inventory/inventory.php">
                <i class="bi bi-box-seam"></i>
                <span>Inventory</span>
            </a>
        </li><!-- End Inventory Page Nav -->
        <?php endif; ?>

        <li class="nav-heading"></li>

        <?php if ($_SESSION['POSPerms'] === 'on'): ?>
        <li class="nav-item">
            <a class="nav-link collapsed" href="../pos/pos.php">
                <i class="bi bi-printer"></i>
                <span>POS</span>
            </a>
        </li><!-- End POS Page Nav -->
        <?php endif; ?>

        <?php if ($_SESSION['REPerms'] === 'on'): ?>
        <li class="nav-item">
            <a class="nav-link collapsed" href="../returnexchange/returnexchange.php">
                <i class="bi bi-cart-dash"></i>
                <span>Return & Exchange</span>
            </a>
        </li><!-- End Return & Exchange Page Nav -->
        <?php endif; ?>

        <li class="nav-heading"></li>

        <?php if ($_SESSION['UsersPerms'] === 'on'): ?>
        <li class="nav-item">
            <a class="nav-link collapsed" href="../users/users.php">
                <i class="bi bi-person"></i>
                <span>Users</span>
            </a>
        </li><!-- End Users Page Nav -->
        <?php endif; ?>

        <?php if ($_SESSION['UsersPerms'] === 'on'): ?>
        <li class="nav-item">
            <a class="nav-link collapsed" href="../audittrail/audittrail.php">
                <i class="bi bi-clipboard-data"></i>
                <span>Audit Trail</span>
            </a>
        </li><!-- End Audit Trail Page Nav -->
        <?php endif; ?>

        <?php if ($_SESSION['UsersPerms'] === 'on'): ?>
        <li class="nav-item">
            <a class="nav-link collapsed" href="../backuprestore/backuprestore.php">
                <i class="bi bi-cloud-check"></i>
                <span>Backup & Restore</span>
            </a>
        </li><!-- End B&R Page Nav -->
        <?php endif; ?>

    </ul>

</aside><!-- End Sidebar -->


  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-8">
          <div class="row">

            <!-- Inventory Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card sales-card">
                <div class="card-body">
                  <h5 class="card-title">Inventory</h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-box-seam"></i>
                    </div>
                    <div class="ps-3">
                      <h6 id="total-stock">0</h6>
                      <span class="text-muted small pt-2 ps-1">In-stock</span>
                      <span class="text-muted small pt-2 ps-1">items</span>
                    </div>
                  </div>
                </div>
              </div>
            </div><!-- End Inventory Card -->

            <!-- Sales Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card revenue-card">
                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>
                    <li><a class="dropdown-item" href="#" data-period="today">Today</a></li>
                    <li><a class="dropdown-item" href="#" data-period="month">This Month</a></li>
                    <li><a class="dropdown-item" href="#" data-period="year">This Year</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Sales <span id="period-text">| Today</span></h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-currency-dollar"></i>
                    </div>
                    <div class="ps-3">
                      <h6 id="sales-total">₱0.00</h6>
                      <span id="percentage-change" class="text-success small pt-1 fw-bold">0%</span> 
                      <span id="change-text" class="text-muted small pt-2 ps-1">increase</span>
                    </div>
                  </div>
                </div>
              </div>
            </div><!-- End Sales Card -->

            <!-- Customers Card -->
            <div class="col-xxl-4 col-xl-12">
              <div class="card info-card customers-card">
                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>
                    <li><a class="dropdown-item" href="#" data-period="today">Today</a></li>
                    <li><a class="dropdown-item" href="#" data-period="month">This Month</a></li>
                    <li><a class="dropdown-item" href="#" data-period="year">This Year</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Customers <span id="customer-period-text">| Today</span></h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-people"></i>
                    </div>
                    <div class="ps-3">
                      <h6 id="customer-total">0</h6>
                      <span id="customer-percentage-change" class="text-success small pt-1 fw-bold">0%</span> 
                      <span id="customer-change-text" class="text-muted small pt-2 ps-1">increase</span>
                    </div>
                  </div>
                </div>
              </div>
            </div><!-- End Customers Card -->

            <!-- Reports -->
            <div class="col-12">
              <div class="card">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Reports <span>/Today</span></h5>

                  <!-- Line Chart -->
                  <div id="reportsChart"></div>

                  <script>
                    document.addEventListener("DOMContentLoaded", () => {
                      new ApexCharts(document.querySelector("#reportsChart"), {
                        series: [{
                          name: 'Inventory',
                          data: [31, 40, 28, 51, 42, 82, 56],
                        }, {
                          name: 'Sales',
                          data: [11, 32, 45, 32, 34, 52, 41]
                        }, {
                          name: 'Customers',
                          data: [15, 11, 32, 18, 9, 24, 11]
                        }],
                        chart: {
                          height: 350,
                          type: 'area',
                          toolbar: {
                            show: false
                          },
                        },
                        markers: {
                          size: 4
                        },
                        colors: ['#2eca6a', '#4154f1', '#ff771d'],
                        fill: {
                          type: "gradient",
                          gradient: {
                            shadeIntensity: 1,
                            opacityFrom: 0.3,
                            opacityTo: 0.4,
                            stops: [0, 90, 100]
                          }
                        },
                        dataLabels: {
                          enabled: false
                        },
                        stroke: {
                          curve: 'smooth',
                          width: 2
                        },
                        xaxis: {
                          type: 'datetime',
                          categories: ["2018-09-19T00:00:00.000Z", "2018-09-19T01:30:00.000Z", "2018-09-19T02:30:00.000Z", "2018-09-19T03:30:00.000Z", "2018-09-19T04:30:00.000Z", "2018-09-19T05:30:00.000Z", "2018-09-19T06:30:00.000Z"]
                        },
                        tooltip: {
                          x: {
                            format: 'dd/MM/yy HH:mm'
                          },
                        }
                      }).render();
                    });
                  </script>
                  <!-- End Line Chart -->

                </div>

              </div>
            </div><!-- End Reports -->

          </div>
        </div><!-- End Left side columns -->

        <!-- Right side columns -->
        <div class="col-lg-4">

          <!-- Recent Activity -->
          <div class="card">
            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filter</h6>
                </li>

                <li><a class="dropdown-item" href="#">Today</a></li>
                <li><a class="dropdown-item" href="#">This Month</a></li>
                <li><a class="dropdown-item" href="#">This Year</a></li>
              </ul>
            </div>

            <div class="card-body">
              <h5 class="card-title">Recent Activity <span>| Today</span></h5>

              <div class="activity">

                <div class="activity-item d-flex">
                  <div class="activite-label">32 min</div>
                  <i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
                  <div class="activity-content">
                    Quia quae rerum <a href="#" class="fw-bold text-dark">explicabo officiis</a> beatae
                  </div>
                </div><!-- End activity item-->

                <div class="activity-item d-flex">
                  <div class="activite-label">56 min</div>
                  <i class='bi bi-circle-fill activity-badge text-danger align-self-start'></i>
                  <div class="activity-content">
                    Voluptatem blanditiis blanditiis eveniet
                  </div>
                </div><!-- End activity item-->

                <div class="activity-item d-flex">
                  <div class="activite-label">2 hrs</div>
                  <i class='bi bi-circle-fill activity-badge text-primary align-self-start'></i>
                  <div class="activity-content">
                    Voluptates corrupti molestias voluptatem
                  </div>
                </div><!-- End activity item-->

                <div class="activity-item d-flex">
                  <div class="activite-label">1 day</div>
                  <i class='bi bi-circle-fill activity-badge text-info align-self-start'></i>
                  <div class="activity-content">
                    Tempore autem saepe <a href="#" class="fw-bold text-dark">occaecati voluptatem</a> tempore
                  </div>
                </div><!-- End activity item-->

                <div class="activity-item d-flex">
                  <div class="activite-label">2 days</div>
                  <i class='bi bi-circle-fill activity-badge text-warning align-self-start'></i>
                  <div class="activity-content">
                    Est sit eum reiciendis exercitationem
                  </div>
                </div><!-- End activity item-->

                <div class="activity-item d-flex">
                  <div class="activite-label">4 weeks</div>
                  <i class='bi bi-circle-fill activity-badge text-muted align-self-start'></i>
                  <div class="activity-content">
                    Dicta dolorem harum nulla eius. Ut quidem quidem sit quas
                  </div>
                </div><!-- End activity item-->

              </div>

            </div>
          </div><!-- End Recent Activity -->

          <!-- Recent Sales -->
          <div class="col-12">
            <div class="card recent-sales overflow-auto">

              <div class="filter">
                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                  <li class="dropdown-header text-start">
                    <h6>Filter</h6>
                  </li>

                  <li><a class="dropdown-item" href="#">Today</a></li>
                  <li><a class="dropdown-item" href="#">This Month</a></li>
                  <li><a class="dropdown-item" href="#">This Year</a></li>
                </ul>
              </div>

              <div class="card-body">
                <h5 class="card-title">Recent Sales <span>| Today</span></h5>

                <table class="table table-borderless datatable">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Product</th>
                      <th scope="col">Price</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <th scope="row"><a href="#">#2457</a></th>
                      <td><a href="#" class="text-primary">At praesentium minu</a></td>
                      <td>$64</td>
                    </tr>
                    <tr>
                      <th scope="row"><a href="#">#2147</a></th>
                      <td><a href="#" class="text-primary">Blanditiis dolor omnis similique</a></td>
                      <td>$47</td>
                    </tr>
                    <tr>
                      <th scope="row"><a href="#">#2049</a></th>
                      <td><a href="#" class="text-primary">At recusandae consectetur</a></td>
                      <td>$147</td>
                    </tr>
                    <tr>
                      <th scope="row"><a href="#">#2644</a></th>
                      <td><a href="#" class="text-primar">Ut voluptatem id earum et</a></td>
                      <td>$67</td>
                    </tr>
                    <tr>
                      <th scope="row"><a href="#">#2644</a></th>
                      <td><a href="#" class="text-primary">Sunt similique distinctio</a></td>
                      <td>$165</td>
                    </tr>
                  </tbody>
                </table>

              </div>

            </div>
          </div><!-- End Recent Sales -->

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
  <script src="dash.js"></script>

</body>

</html>