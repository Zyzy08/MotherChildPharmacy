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
  <link href="dash_style.css" rel="stylesheet">

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
                <span>Deliveries</span>
            </a>
        </li><!-- End Deliveries Page Nav -->
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
            <div class="col-xxl-6 col-md-6">
                <div class="card info-card sales-card">
                    <div class="filter">
                        <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <li class="dropdown-header text-start">
                                <h6>Filter</h6>
                            </li>
                            <li><a class="dropdown-item-inv" href="#" data-status="in-stock">In Stock</a></li>
                            <li><a class="dropdown-item-inv" href="#" data-status="low-stock">Low Stock</a></li>
                            <li><a class="dropdown-item-inv" href="#" data-status="out-of-stock">Out of Stock</a></li>
                        </ul>
                    </div>

                    <div class="card-body">
                        <h5 class="card-title">Inventory</h5>
                        <div class="d-flex align-items-center">
                            <div id="status-icon" class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-success-light">
                                <i class="bi bi-box-seam text-success"></i>
                            </div>
                            <div class="ps-3">
                                <h6 id="inventory-count">0</h6>
                                <span id="status-description" class="text-success small pt-1 fw-bold">Available Items</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customers Card -->
            <div class="col-xxl-6 col-xl-12">
              <div class="card info-card customers-card">
                <div class="filter">
                  <a id="filter-icon" class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
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
            
            <!-- Sales Card -->
            <div class="col-xxl-12 col-md-6">
              <div class="card info-card revenue-card">
                <div class="filter">
                  <a id="filter-icon" class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
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

            <!-- Reports Card -->
            <div class="col-12">
              <div class="card" style="height: 716px;">
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
                  <h5 class="card-title">Reports <span id="reports-period-text">| Today</span></h5>
                  <div id="reportsChart"></div>
                </div>
              </div>
            </div>

            <script>
              document.addEventListener("DOMContentLoaded", () => {
                let reportsChart = null;

                // Function to format currency
                const formatCurrency = (value) => {
                    return '₱' + parseFloat(value).toLocaleString(undefined, {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                };

                // Function to update the customers card
                const updateCustomersCard = (period) => {
                    fetch(`fetchCustomersData.php?period=${period}`)
                        .then(response => response.json())
                        .then(data => {
                            document.getElementById('customer-total').textContent = data.total;
                            document.getElementById('customer-percentage-change').textContent = `${data.percentage}%`;
                            document.getElementById('customer-change-text').textContent = data.changeType;
                            document.getElementById('customer-period-text').textContent = `| ${period.charAt(0).toUpperCase() + period.slice(1)}`;

                            // Update percentage change color
                            const percentageElement = document.getElementById('customer-percentage-change');
                            percentageElement.className = data.changeType === 'increase' ? 'text-success small pt-1 fw-bold' : 'text-danger small pt-1 fw-bold';
                        })
                        .catch(error => console.error('Error:', error));
                };

                // Function to update the sales card
                const updateSalesCard = (period) => {
                    fetch(`fetchSalesData.php?period=${period}`)
                        .then(response => response.json())
                        .then(data => {
                            document.getElementById('sales-total').textContent = data.total;
                            document.getElementById('percentage-change').textContent = `${data.percentage}%`;
                            document.getElementById('change-text').textContent = data.changeType;
                            document.getElementById('period-text').textContent = `| ${period.charAt(0).toUpperCase() + period.slice(1)}`;

                            // Update percentage change color
                            const percentageElement = document.getElementById('percentage-change');
                            percentageElement.className = data.changeType === 'increase' ? 'text-success small pt-1 fw-bold' : 'text-danger small pt-1 fw-bold';
                        })
                        .catch(error => console.error('Error:', error));
                };

                // Function to update reports chart
                const updateReportsChart = (period = 'today') => {
                    fetch(`fetchReports.php?period=${period}`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error(`HTTP error! status: ${response.status}`);
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.error) {
                                console.error('Error:', data.error);
                                return;
                            }

                            // Update period text in title
                            document.getElementById('reports-period-text').textContent = `| ${period.charAt(0).toUpperCase() + period.slice(1)}`;

                            // Update cards
                            updateSalesCard(period);
                            updateCustomersCard(period);

                            // Process chart data
                            const chartData = data.chart_data;
                            const categories = chartData.map(row => row.period);
                            const salesValues = chartData.map(row => parseFloat(row.total_sales));
                            const customerValues = chartData.map(row => parseInt(row.unique_customers));

                            // Destroy existing chart if it exists
                            if (reportsChart) {
                                reportsChart.destroy();
                            }

                            // Create new chart with dual axes
                            const chartOptions = {
                                series: [{
                                    name: 'Sales',
                                    type: 'line',
                                    data: salesValues
                                }, {
                                    name: 'Customers',
                                    type: 'line',
                                    data: customerValues
                                }],
                                chart: {
                                    height: 625,
                                    type: 'line',
                                    toolbar: {
                                        show: false
                                    },
                                    stacked: false
                                },
                                stroke: {
                                    width: [2, 2],
                                    curve: 'smooth'
                                },
                                colors: ['#2eca6a', '#ff771d'],
                                fill: {
                                    type: ['gradient', 'gradient'],
                                    gradient: {
                                        shade: 'light',
                                        type: "vertical",
                                        shadeIntensity: 0.3,
                                        opacityFrom: 1,
                                        opacityTo: 0.5,
                                        stops: [0, 90, 100]
                                    }
                                },
                                markers: {
                                    size: 4,
                                    hover: {
                                        size: 6
                                    }
                                },
                                xaxis: {
                                    categories: categories,
                                    labels: {
                                        formatter: function(value) {
                                            switch(period) {
                                                case 'today':
                                                    return `${value}:00`;
                                                case 'month':
                                                    return value;
                                                case 'year':
                                                    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                                                    return months[value - 1];
                                                default:
                                                    return value;
                                            }
                                        }
                                    }
                                },
                                yaxis: [{
                                    title: {
                                        text: 'Sales (₱)',
                                        style: {
                                            color: '#2eca6a'
                                        }
                                    },
                                    labels: {
                                        formatter: function(value) {
                                            return formatCurrency(value);
                                        },
                                        style: {
                                            colors: '#2eca6a'
                                        }
                                    },
                                    tickAmount: 14 // Increase this to add more horizontal grid lines
                                }, {
                                    opposite: true,
                                    title: {
                                        text: 'Customers',
                                        style: {
                                            color: '#ff771d'
                                        }
                                    },
                                    labels: {
                                        formatter: function(value) {
                                            return Math.round(value);
                                        },
                                        style: {
                                            colors: '#ff771d'
                                        }
                                    },
                                    tickAmount: 14 // Match this number if you want symmetrical grid lines
                                }],
                                grid: {
                                    show: true,
                                    borderColor: '#e0e0e0',
                                    strokeDashArray: 4 // Optional: use dashes for the grid lines
                                },
                                tooltip: {
                                    shared: true,
                                    intersect: false,
                                    y: {
                                        formatter: function(value, { seriesIndex }) {
                                            if (seriesIndex === 0) {
                                                return formatCurrency(value);
                                            }
                                            return value + ' customers';
                                        }
                                    }
                                },
                                legend: {
                                    position: 'top',
                                    horizontalAlign: 'right',
                                    markers: {
                                        width: 8,
                                        height: 8,
                                        radius: 4
                                    }
                                }
                            };

                            reportsChart = new ApexCharts(document.querySelector("#reportsChart"), chartOptions);
                            reportsChart.render();
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                };

                // Add click handlers for filter dropdowns
                document.querySelectorAll('.card .dropdown-item[data-period]').forEach(item => {
                    item.addEventListener('click', (e) => {
                        e.preventDefault();
                        const period = e.target.dataset.period;
                        updateReportsChart(period);
                    });
                });

                // Initial load with 'today' data
                updateReportsChart('today');
              });
            </script>

          </div>
        </div><!-- End Left side columns -->

        <!-- Right side columns -->
        <div class="col-lg-4">

          <!-- Deliveries Status -->
          <div class="card">
              <div class="card-body">
                  <h5 class="card-title">Deliveries Status</h5>
                  <div class="activity" id="activity-content">
                      <!-- JavaScript will insert delivery status items here -->
                  </div>
              </div>
          </div><!-- End Deliveries Status -->

          <!-- Today's Sales Card -->
          <div class="col-12">
              <div class="card recent-sales">
                  <div class="card-body">
                      <h5 class="card-title">Today's Sales</h5>
                      <div class="table-responsive" style="max-height: 500px;">
                          <table class="table table-borderless" id="salesTable">
                              <thead style="position: sticky; top: 0; background-color: #fff; z-index: 1;">
                                  <tr>
                                      <th scope="col">#</th>
                                      <th scope="col">Time</th>
                                      <th scope="col">Item</th>
                                      <th scope="col">Qty</th>
                                      <th scope="col">Price</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <!-- Data populated by JavaScript -->
                              </tbody>
                          </table>
                      </div>
                  </div>
              </div>
          </div><!-- End Today's Sales -->

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
      Designed by <a href="https://www.sti.edu/campuses-details.asp?campus_id=QU5H">STI College Angeles - BSIT4-A S.Y 2024-2025 </a>
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