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
              <a class="dropdown-item d-flex align-items-center" href="../users/users-profile/users-profile.php" id="myprofiledropdownselect">
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
                        <button id="Table View" style="margin-right: 15px" type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#InventoryReportModal">
                            <i class="bi bi-file-earmark-pdf"> Table View</i>
                        </button>
                        <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <li class="dropdown-header text-start">
                                <h6>Filter</h6>
                            </li>
                            <li><a class="dropdown-item-inv" href="#" data-status="in-stock">In Stock</a></li>
                            <li><a class="dropdown-item-inv" href="#" data-status="low-stock">Low Stock</a></li> 
                            <li><a class="dropdown-item-inv" href="#" data-status="overstock">Overstock</a></li>                                                       
                            <li><a class="dropdown-item-inv" href="#" data-status="out-of-stock">Out of Stock</a></li>
                            <li><a class="dropdown-item-inv" href="#" data-status="near-expiry">Near Expiry</a></li>
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
                    <li><a class="dropdown-item" href="#" data-period="week">This Week</a></li>
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
                    <li><a class="dropdown-item" href="#" data-period="week">This Week</a></li>
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
                  <button id="Table View" style="margin-right: 15px" type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#ExtralargeModal">
                    <i class="bi bi-file-earmark-pdf"> Table View</i>
                  </button>
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>
                    <li><a class="dropdown-item" href="#" data-period="today">Today</a></li>
                    <li><a class="dropdown-item" href="#" data-period="week">This Week</a></li>
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

          <!-- Deliveries Status Card -->
          <div class="card">
              <div class="card-body deliveries-card-body">
                  <h5 class="card-title">Expected Deliveries Status</h5>
                  <div class="activity" id="activity-content">
                      <!-- JavaScript will insert delivery status items here -->
                  </div>
              </div>
          </div>
          <!-- End Deliveries Status -->

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

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <style>
      .text-wrap {
        white-space: normal;
      }
      .datatable_report {
        max-height: 500px; 
        overflow-y: auto; 
      }
      .datatable_report_inv {
        max-height: 500px; 
        overflow-y: auto; 
      }
    </style>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <!-- Reports Table Modal -->
    <div class="modal fade" id="ExtralargeModal" tabindex="-1">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Reports Data</h5>
          </div>
          <div class="modal-body">
            <div class="container datatable_report">
              <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="d-flex gap-2 align-items-center">
                  <select id="firstFilter" class="form-select w-25">
                    <option value="all">All</option>
                    <option value="today">Today</option>
                    <option value="week">Week</option>
                    <option value="month">Month</option>
                    <option value="year">Year</option>
                  </select>
                  <select id="secondFilter" class="form-select w-25">
                    <option value="--:--">--:--</option>
                  </select>
                  <!-- <button id="salesbyitem" type="button" class="btn btn-primary">Sales By Item</button> -->
                </div>
              </div>

              <!-- <div class="card" id="salesByItem-card">
                <h2>Sales by Item</h2>
                <div class="card-body profile-card transactionsTableSize flex-column align-items-center">
                  <table id="salesByItem-example" class="display" style="width:100%">
                    <thead>
                      <tr class="highlight-row">
                        <th>Item Name</th>
                        <th>Quantity Sold</th>
                        <th>Price Per Unit</th>
                        <th>Subtotal</th>
                        <th>Discount Given</th>
                        <th>Net Sales</th>
                        <th>VAT Exempt Sales</th>
                        <th>Vatable Sales</th>
                      </tr>
                    </thead>
                    <tbody id="salesByItem-tableBody">
                      < Data rows will be inserted here by JavaScript >
                    </tbody>
                  </table>
                </div>
              </div> -->

              <div class="card" id="today-card">
                <h2>Today's Sales</h2>
                <div class="card-body profile-card transactionsTableSize flex-column align-items-center">
                  <table id="today-example" class="display" style="width:100%">
                    <thead>
                      <tr class="highlight-row">
                        <th>Invoice ID</th>
                        <th>Date</th>
                        <th>Total Items</th>
                        <th>Subtotal</th>
                        <th>Tax</th>
                        <th>Discount</th>
                        <th>Net Amount</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody id="today-tableBody">
                      <!-- Data rows will be inserted here by JavaScript -->
                    </tbody>
                  </table>
                </div>
              </div>

              <div class="card" id="week-card">
                <h2>This Week's Sales</h2>
                <div class="card-body profile-card transactionsTableSize flex-column align-items-center">
                  <table id="week-example" class="display" style="width:100%">
                    <thead>
                      <tr class="highlight-row">
                        <th>Invoice ID</th>
                        <th>Date</th>
                        <th>Total Items</th>
                        <th>Subtotal</th>
                        <th>Tax</th>
                        <th>Discount</th>
                        <th>Net Amount</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody id="week-tableBody">
                      <!-- Data rows will be inserted here by JavaScript -->
                    </tbody>
                  </table>
                </div>
              </div>

              <div class="card" id="month-card">
                <h2>This Month's Sales</h2>
                <div class="card-body profile-card transactionsTableSize flex-column align-items-center">
                  <table id="month-example" class="display" style="width:100%">
                    <thead>
                      <tr class="highlight-row">
                        <th>Invoice ID</th>
                        <th>Date</th>
                        <th>Total Items</th>
                        <th>Subtotal</th>
                        <th>Tax</th>
                        <th>Discount</th>
                        <th>Net Amount</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody id="month-tableBody">
                      <!-- Data rows will be inserted here by JavaScript -->
                    </tbody>
                  </table>
                </div>
              </div>

              <div class="card" id="year-card">
                <h2>This Year's Sales</h2>
                <div class="card-body profile-card transactionsTableSize flex-column align-items-center">
                  <table id="year-example" class="display" style="width:100%">
                    <thead>
                      <tr class="highlight-row">
                        <th>Invoice ID</th>
                        <th>Date</th>
                        <th>Total Items</th>
                        <th>Subtotal</th>
                        <th>Tax</th>
                        <th>Discount</th>
                        <th>Net Amount</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody id="year-tableBody">
                      <!-- Data rows will be inserted here by JavaScript -->
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

            <script>
              $(document).ready(function () {
                
                /*$('#salesbyitem').on('click', function () {
                  const salesByItemTable = $('#salesByItem-example');

                  // Destroy existing DataTable if it exists
                  if ($.fn.DataTable.isDataTable(salesByItemTable)) {
                    salesByItemTable.DataTable().clear().destroy();
                  }
                  
                  // Initialize DataTable for Sales By Item
                  salesByItemTable.DataTable({
                    ajax: {
                      url: 'fetchSalesByItem.php',
                      dataSrc: ''
                    },
                    columns: [
                      { data: 'ItemName' },
                      { data: 'QuantitySold' },
                      { 
                        data: 'PricePerUnit',
                        render: data => `₱${parseFloat(data).toFixed(2)}`
                      },
                      { 
                        data: 'Subtotal',
                        render: data => `₱${parseFloat(data).toFixed(2)}`
                      },
                      { 
                        data: 'DiscountGiven',
                        render: data => `₱${parseFloat(data).toFixed(2)}`
                      },
                      { 
                        data: 'NetSales',
                        render: data => `₱${parseFloat(data).toFixed(2)}`
                      },
                      { 
                        data: 'VATExemptSales',
                        render: data => `₱${parseFloat(data).toFixed(2)}`
                      },
                      { 
                        data: 'VatableSales',
                        render: data => `₱${parseFloat(data).toFixed(2)}`
                      }
                    ],
                    paging: false,
                    searching: false,
                    ordering: false
                  });
                });*/
                
                const filterTables = {
                  today: '#today-example',
                  week: '#week-example',
                  month: '#month-example',
                  year: '#year-example'
                };

                const secondFilterOptions = {
                  today: ["--:--"], 
                  week: ["--:--", "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
                  month: ["--:--", "January", "February", "March", "April", "May", "June", 
                          "July", "August", "September", "October", "November", "December"],
                  year: ["--:--", new Date().getFullYear(), new Date().getFullYear() - 1, new Date().getFullYear() - 2]
                };

                // Change first filter
                $('#firstFilter').on('change', function () {
                  const selectedFilter = $(this).val();
                  const secondFilter = $('#secondFilter');

                  // Update second filter options
                  secondFilter.empty(); // Clear existing options
                  const options = secondFilterOptions[selectedFilter] || ["--:--"];
                  options.forEach(option => {
                    secondFilter.append(new Option(option, option));
                  });

                  // Hide all cards initially
                  Object.keys(filterTables).forEach(key => {
                    $(`#${key}-card`).hide();
                  });

                  // Show all cards if 'all' is selected
                  if (selectedFilter === 'all') {
                    Object.keys(filterTables).forEach(key => {
                      $(`#${key}-card`).show();
                      $(`#${key}-card h2`).show(); // Show all h2 titles
                    });

                    // Load data for all tables
                    loadTableData('today');
                    loadTableData('week');
                    loadTableData('month');
                    loadTableData('year');
                  } else {
                    $(`#${selectedFilter}-card`).show();
                    loadTableData(selectedFilter);
                  }
                });

                // Change second filter
                $('#secondFilter').on('change', function () {
                  const selectedFilter = $('#firstFilter').val();
                  const selectedSecondFilter = $(this).val();

                  // Toggle h2 visibility based on second filter
                  const periodCardSelector = `#${selectedFilter}-card h2`;
                  if (selectedSecondFilter === "--:--") {
                    $(periodCardSelector).show();
                  } else {
                    $(periodCardSelector).hide();
                  }

                  // Only apply additional filtering if a specific value is selected (not "--:--")
                  if (selectedSecondFilter !== "--:--") {
                    if (selectedFilter === 'week') {
                      // For week, filter by specific day
                      loadTableData(selectedFilter, selectedSecondFilter);
                    } else if (selectedFilter === 'month') {
                      // For month, filter by specific month
                      loadTableData(selectedFilter, selectedSecondFilter);
                    } else if (selectedFilter === 'year') {
                      // For year, filter by specific year
                      loadTableData(selectedFilter, selectedSecondFilter);
                    }
                  } else {
                    // If "--:--" is selected, reload the default data for the period
                    loadTableData(selectedFilter);
                  }
                });

                // Initially trigger first filter change
                $('#firstFilter').trigger('change');

                // Function to load table data based on selected filter
                function loadTableData(period, secondFilterValue = null) {
                  const tableConfig = {
                    today: 'fetchTodaySales.php?period=today',
                    week: 'fetchTodaySales.php?period=week' + (secondFilterValue && secondFilterValue !== "--:--" ? `&day=${secondFilterValue}` : ''),
                    month: 'fetchTodaySales.php?period=month' + (secondFilterValue && secondFilterValue !== "--:--" ? `&month=${secondFilterValue}` : ''),
                    year: 'fetchTodaySales.php?period=year' + (secondFilterValue && secondFilterValue !== "--:--" ? `&year=${secondFilterValue}` : '')
                  };

                  const selectedTable = filterTables[period];
                  const selectedTableBody = `${selectedTable} tbody`;
                  const totalRowId = `${period}-total-row`;

                  // Destroy DataTable if it exists
                  if ($.fn.DataTable.isDataTable(selectedTable)) {
                    $(selectedTable).DataTable().clear().destroy();
                  }

                  // Common configuration for sales and invoice tables
                  if (['today', 'week', 'month', 'year'].includes(period)) {
                    const dataTable = $(selectedTable).DataTable({
                      "ajax": {
                        "url": tableConfig[period],
                        "dataSrc": "",
                        "complete": function(xhr) {
                          // Calculate total after data is loaded
                          const data = xhr.responseJSON;
                          const totalNet = data.reduce((sum, row) => sum + row.NetAmount, 0);
                          const totalItems = data.reduce((sum, row) => sum + row.TotalItems, 0);
                          const totalSubtotal = data.reduce((sum, row) => sum + row.Subtotal, 0);
                          const totalTax = data.reduce((sum, row) => sum + row.Tax, 0);
                          const totalDiscount = data.reduce((sum, row) => sum + row.Discount, 0);
                          
                          // Remove existing total row if it exists
                          $(`#${totalRowId}`).remove();
                          
                          // Append total row
                          $(selectedTableBody).append(`
                            <tr id="${totalRowId}" style="font-weight: bold; background-color: #f2f2f2;">
                              <td colspan="2">Total</td>
                              <td>${totalItems}</td>
                              <td>₱${totalSubtotal.toFixed(2)}</td>
                              <td>₱${totalTax.toFixed(2)}</td>
                              <td>₱${totalDiscount.toFixed(2)}</td>
                              <td>₱${totalNet.toFixed(2)}</td>
                              <td></td>
                            </tr>
                          `);
                        }
                      },
                      "columns": [
                        { "data": "InvoiceID" },
                        { "data": "SaleDate" },
                        { "data": "TotalItems" },
                        { "data": "Subtotal" },
                        { "data": "Tax" },
                        { "data": "Discount" },
                        { "data": "NetAmount" },
                        { "data": "Status" }
                      ],
                      "columnDefs": [
                        {
                          "targets": [3, 4, 5, 6],
                          "render": function (data) {
                            return "₱" + data.toFixed(2);
                          }
                        }
                      ],
                      "paging": false,
                      "searching": false,
                      "ordering": false
                    });
                  }
                }
              });
            </script>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button id="export_PDF" type="button" class="btn btn-primary">Export to PDF</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Inventory Reports Modal -->
    <div class="modal fade" id="InventoryReportModal" tabindex="-1">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Inventory Reports</h5>
          </div>
          <div class="modal-body">
            <div class="container datatable_report_inv">
              <!-- In Stock Items Report -->
              <div class="card">
                <h2>In Stock Items</h2>
                <div class="card-body profile-card transactionsTableSize flex-column align-items-center">
                  <table id="in-stock-example" class="display" style="width:100%">
                    <thead>
                      <tr class="highlight-row">
                        <th>Item ID</th>
                        <th>Brand Name</th>
                        <th>Generic Name</th>
                        <th>In Stock</th>
                        <th>Unit Price</th>
                        <th>Total Inventory Value</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody id="in-stock-tableBody">
                      <!-- Data rows will be inserted here by JavaScript -->
                    </tbody>
                  </table>
                </div>
              </div>

              <!-- Low Stock Items Report -->
              <div class="card">
                <h2>Low Stock Items</h2>
                <div class="card-body profile-card transactionsTableSize flex-column align-items-center">
                  <table id="low-stock-example" class="display" style="width:100%">
                    <thead>
                      <tr class="highlight-row">
                        <th>Item ID</th>
                        <th>Brand Name</th>
                        <th>Generic Name</th>
                        <th>In Stock</th>
                        <th>Reorder Level</th>
                        <th>Total Inventory Value</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody id="low-stock-tableBody">
                      <!-- Data rows will be inserted here by JavaScript -->
                    </tbody>
                  </table>
                </div>
              </div>

              <!-- Overstock Items Report -->
              <div class="card">
                <h2>Overstock Items</h2>
                <div class="card-body profile-card transactionsTableSize flex-column align-items-center">
                  <table id="overstock-example" class="display" style="width:100%">
                    <thead>
                      <tr class="highlight-row">
                        <th>Item ID</th>
                        <th>Brand Name</th>
                        <th>Generic Name</th>
                        <th>In Stock</th>
                        <th>Reorder Level</th>
                        <th>Excess Stock</th>
                        <th>Total Inventory Value</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody id="overstock-tableBody">
                      <!-- Data rows will be inserted here by JavaScript -->
                    </tbody>
                  </table>
                </div>
              </div>

              <!-- Out of Stock Items Report -->
              <div class="card">
                <h2>Out of Stock Items</h2>
                <div class="card-body profile-card transactionsTableSize flex-column align-items-center">
                  <table id="out-of-stock-example" class="display" style="width:100%">
                    <thead>
                      <tr class="highlight-row">
                        <th>Item ID</th>
                        <th>Brand Name</th>
                        <th>Generic Name</th>
                        <th>Last Known Price</th>
                      </tr>
                    </thead>
                    <tbody id="out-of-stock-tableBody">
                      <!-- Data rows will be inserted here by JavaScript -->
                    </tbody>
                  </table>
                </div>
              </div>

              <!-- Near Expiry Items Report -->
              <div class="card">
                <h2>Near Expiry Items</h2>
                <div class="card-body profile-card transactionsTableSize flex-column align-items-center">
                  <table id="near-expiry-example" class="display" style="width:100%">
                    <thead>
                      <tr class="highlight-row">
                        <th>Item ID</th>
                        <th>Brand Name</th>
                        <th>Generic Name</th>
                        <th>Expiry Date</th>
                        <th>Lot Number</th>
                        <th>Price Per Unit</th>
                        <th>Days to Expiry</th>
                      </tr>
                    </thead>
                    <tbody id="near-expiry-tableBody">
                      <!-- Data rows will be inserted here by JavaScript -->
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

            <script>
              $(document).ready(function() {
                // Fetch and display In Stock Items
                $('#in-stock-example').DataTable({
                  "ajax": {
                    "url": "fetchInventoryReports.php?report=in-stock", 
                    "dataSrc": ""
                  },
                  "columns": [
                    { "data": "ItemID" },
                    { "data": "BrandName" },
                    { "data": "GenericName" },
                    { "data": "InStock" },
                    { 
                      "data": "PricePerUnit",
                      "render": function(data) {
                        return data > 0 ? '₱' + parseFloat(data).toFixed(2) : 'N/A';
                      }
                    },
                    { 
                      "data": "TotalInventoryValue",
                      "render": function(data) {
                        return data > 0 ? '₱' + parseFloat(data).toFixed(2) : 'N/A';
                      }
                    },
                    { 
                      "data": "InventoryStatus",
                      "render": function(data) {
                        if (data === 'Critical') return '<span class="badge bg-danger">' + data + '</span>';
                        if (data === 'Low') return '<span class="badge bg-warning">' + data + '</span>';
                        return '<span class="badge bg-success">' + data + '</span>';
                      }
                    }
                  ],
                  "paging": false,
                  "searching": false
                });

                // Fetch and display Low Stock Items
                $('#low-stock-example').DataTable({
                  "ajax": {
                    "url": "fetchInventoryReports.php?report=low-stock",
                    "dataSrc": ""
                  },
                  "columns": [
                    { "data": "ItemID" },
                    { "data": "BrandName" },
                    { "data": "GenericName" },
                    { "data": "InStock" },
                    { "data": "ReorderLevel" },
                    { 
                      "data": "TotalInventoryValue",
                      "render": function(data) {
                        return data > 0 ? '₱' + parseFloat(data).toFixed(2) : 'N/A';
                      }
                    },
                    { 
                      "data": "InventoryStatus",
                      "render": function(data) {
                        if (data === 'Critical') return '<span class="badge bg-danger">' + data + '</span>';
                        if (data === 'Low') return '<span class="badge bg-warning">' + data + '</span>';
                        return '<span class="badge bg-success">' + data + '</span>';
                      }
                    }
                  ],
                  "paging": false,
                  "searching": false
                });

                // Fetch and display Overstock Items
                $('#overstock-example').DataTable({
                  "ajax": {
                    "url": "fetchInventoryReports.php?report=overstock",
                    "dataSrc": ""
                  },
                  "columns": [
                    { "data": "ItemID" },
                    { "data": "BrandName" },
                    { "data": "GenericName" },
                    { "data": "InStock" },
                    { "data": "ReorderLevel" },
                    { "data": "ExcessStock" },
                    { 
                      "data": "TotalInventoryValue",
                      "render": function(data) {
                        return data > 0 ? '₱' + parseFloat(data).toFixed(2) : 'N/A';
                      }
                    },
                    { 
                      "data": "InventoryStatus",
                      "render": function(data) {
                        if (data === 'Overstocked') return '<span class="badge bg-danger">' + data + '</span>';
                        if (data === 'Above Normal') return '<span class="badge bg-warning">' + data + '</span>';
                        return '<span class="badge bg-success">' + data + '</span>';
                      }
                    }
                  ],
                  "paging": false,
                  "searching": false
                });

                // Fetch and display Out of Stock Items
                $('#out-of-stock-example').DataTable({
                  "ajax": {
                    "url": "fetchInventoryReports.php?report=out-of-stock",
                    "dataSrc": ""
                  },
                  "columns": [
                    { "data": "ItemID" },
                    { "data": "BrandName" },
                    { "data": "GenericName" },
                    { 
                      "data": "LastKnownPrice",
                      "render": function(data) {
                        return data > 0 ? '₱' + parseFloat(data).toFixed(2) : 'N/A';
                      }
                    }
                  ],
                  "paging": false,
                  "searching": false
                });

                // Fetch and display Near Expiry Items
                $('#near-expiry-example').DataTable({
                  "ajax": {
                    "url": "fetchInventoryReports.php?report=near-expiry",
                    "dataSrc": ""
                  },
                  "columns": [
                    { "data": "ItemID" },
                    { "data": "BrandName" },
                    { "data": "GenericName" },
                    { "data": "ExpiryDate" },
                    { "data": "LotNumber" },
                    { 
                      "data": "PricePerUnit",
                      "render": function(data) {
                        return data > 0 ? '₱' + parseFloat(data).toFixed(2) : 'N/A';
                      }
                    },
                    { 
                      "data": "DaysToExpiry",
                      "render": function(data) {
                        return data + ' days';
                      }
                    }
                  ],
                  "paging": false,
                  "searching": false
                });
              });
            </script>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button id="export_PDF_inv" type="button" class="btn btn-primary">Export to PDF</button>
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
  
  <!-- DataTables CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
  <!-- DataTables JS -->
  <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
  <!-- jsPDF JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>



  <!-- Template Main JS File -->
  <script src="../main.js"></script>
  <script src="dash.js"></script>

</body>

</html>