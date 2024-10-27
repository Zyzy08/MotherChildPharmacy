<?php include '../fetchUser.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Deliveries - Mother & Child Pharmacy and Medical Supplies</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="../resources/img/favicon.png" rel="icon">
    <link href="../resources/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="../resources/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../resources/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="../resources/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="../resources/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="../resources/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="../resources/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="../resources/vendor/simple-datatables/style.css" rel="stylesheet">
    <link rel="stylesheet" href="deli_styles.css">

    <!-- DataTables Imports -->
    <link rel="stylesheet" href="../transactions/dataTablesTransactions/dataTablesT.css" />
    <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.1.6/js/dataTables.js"></script>

    <!-- Template Main CSS File -->
    <link href="../style.css" rel="stylesheet">

</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <i class="bi bi-list toggle-sidebar-btn"></i>
            <a href="../dashboard/dashboard.php" class="logo d-flex align-items-center">
                <img src="../resources/img/logo.png" alt="">
                <span class="d-none d-lg-block span1">Mother & Child</span>
                <span class="d-none d-lg-block span2">Pharmacy and Medical Supplies</span>
            </a>
        </div><!-- End Logo -->

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">

                <li class="nav-item dropdown pe-3">

                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <img src="../users/uploads/<?php echo htmlspecialchars($picture); ?>" alt="Profile"
                            class="rounded-circle">
                        <span
                            class="d-none d-md-block dropdown-toggle ps-2"><?php echo htmlspecialchars($formattedName); ?></span>
                    </a><!-- End Profile Image Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6><?php echo htmlspecialchars($employeeName); ?></h6>
                            <span><?php echo htmlspecialchars($role); ?></span>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center"
                                href="../users/users-profile/users-profile.php">
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
                    <a class="nav-link" href="../delivery/delivery.php">
                        <i class="bi bi-truck"></i>
                        <span>Deliveries</span>
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
            <h1>Deliveries</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="../dashboard/dashboard.php">Home</a></li>
                    <li class="breadcrumb-item active">Deliveries</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section users">
            <div class="row">
                <div class="containerAddArchive">
                    <div class="button" id="addUser" onclick="location.href='delivery-receive.php'">
                        <img src="../resources/img/add.png" alt="Add New Order"> Receive Delivery
                    </div>
                </div>
                <br>
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body profile-card transactionsTableSize flex-column align-items-center">
                            <table id="example" class="display">
                                <thead>
                                    <tr class="highlight-row">
                                        <th>Delivery ID</th>
                                        <th>Order ID</th>
                                        <th>Supplier</th>
                                        <th>Delivery Date</th>
                                        <th>Total Items</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="tableBody">
                                    <!-- Data rows will be inserted here by JavaScript -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="copyright">
            &copy; Copyright <strong><span>Mother & Child Pharmacy and Medical Supplies</span></strong>. All Rights
            Reserved
        </div>
        <div class="credits">
            Designed by <a href="https://www.sti.edu/campuses-details.asp?campus_id=QU5H">STI College Angeles - BSIT4-A
                S.Y. 2024-2025 </a>
        </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <div id="overlayEdit" class="overlay">
        <div class="overlay-content">
            <span id="closeBtnEdit" class="close-btn">&times;</span>
            <h2>Delivery Details</h2>
            <form id="userFormEdit" method="post" enctype="multipart/form-data">
                <div class="container">
                    <table class="table table-sm" id="poDetailsTable">
                        <thead>
                            <tr>
                                <th scope="col">Delivery ID</th>
                                <th scope="col">Supplier Name</th>
                                <th scope="col">Received By</th>
                                <th scope="col">Date (Time)</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td id="identifierID"></td>
                                <td id="supplierName"></td>
                                <td id="cashierID"></td>
                                <td id="datetimeID"></td>
                                <td id="Status"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="container">
                    <div class="textbox">
                        <div class="label">
                            <label for="listTable" id="listTableLabel"><u>LIST OF ITEMS</u></label>
                        </div>
                    </div>
                </div>

                <div class="container">
                    <table class="table table-sm" id="listTable">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Item Description</th>
                                <th scope="col">Lot No.</th>
                                <th scope="col">Expiry Date</th>
                                <th scope="col">Qty. Ordered</th>
                                <th scope="col">Qty. Served</th>
                                <th scope="col">Bonus</th>
                                <th scope="col">Net Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>FLUIMICIL 100MG/5ML SYR 100ML</td>
                                <td>10</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <br>
            </form>
        </div>
    </div>
    <!-- End of Overlay for View -->

    <div id="overlayAD" class="overlay">
        <div class="overlayAD-content">
            <span id="closeBtnAD" class="close-btn">&times;</span>
            <h3>Other Options</h3>
            <h4 id="overlayADtitle"></h4>
            <hr>
            <div style="position: relative; display: inline-block;">
                <button id="deleteDataBtn" type="button" data-bs-toggle="modal" data-bs-target="#disablebackdrop-AD">
                    <img src="../resources/img/delete.png" style="padding-bottom: 2px;"> Cancel Order
                </button>
                <span id="tooltip" class="tooltip-text">Orders can only be cancelled within 1 hour of
                    creation.</span>
            </div>
            <div class="modal" id="disablebackdrop-AD" tabindex="-1" data-bs-backdrop="false">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalVerifyTitle-AD">Confirm Cancellation</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                id="modalClose-AD"></button>
                        </div>
                        <div class="modal-body" id="modalVerifyText-AD">
                            Are you sure you want to cancel this order?
                        </div>
                        <div class="modal-footer" id="modal-footer-AD">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                            <button type="button" class="btn btn-primary" id="modalYes">Yes</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- End of Overlay for Options -->

    <div class="modal" id="disablebackdrop-Front" tabindex="-1">
        <div class="modal-dialog" data-bs-backdrop="false">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalVerifyTitle-Front">Title Text</h5>
                </div>
                <div class="modal-body" id="modalVerifyText-Front">
                    Text
                </div>
            </div>
        </div>
    </div>


    <!-- Template Main JS File -->
    <script src="../main.js"></script>
    <script src="JS-delivery.js"></script>

    <!-- Vendor JS Files -->
    <script src="../resources/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="../resources/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../resources/vendor/chart.js/chart.umd.js"></script>
    <script src="../resources/vendor/echarts/echarts.min.js"></script>
    <script src="../resources/vendor/quill/quill.js"></script>
    <script src="../resources/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="../resources/vendor/tinymce/tinymce.min.js"></script>
    <script src="../resources/vendor/php-email-form/validate.js"></script>

</body>

</html>