<?php include '../fetchUser.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>New Purchase Order - Mother & Child Pharmacy and Medical Supplies</title>
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
    <link rel="stylesheet" href="po_styles.css">

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
                    <a class="nav-link" href="../purchaseorders/purchaseorders.php">
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
            <h1>Purchase Orders</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="../dashboard/dashboard.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="../purchaseorders/purchaseorders.php">Purchase Orders</a></li>
                    <li class="breadcrumb-item active">New Purchase Order</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section users">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body profile-card transactionsTableSize flex-column align-items-center">
                            <br>
                            <form id="userForm" method="post" enctype="multipart/form-data">
                                <div class="container">
                                    <div class="textbox">
                                        <div class="label">
                                            <label for="newID">Order ID</label><br>
                                        </div>
                                        <input type="text" id="newID" name="newID" disabled>
                                    </div>
                                    <div class="textbox">
                                        <div class="label">
                                            <label for="supplierSelect">Supplier Name</label><br>
                                        </div>
                                        <select id="supplierSelect" name="supplierSelect">
                                            <!-- Default is now empty -->
                                            <!-- Options will be populated here -->
                                        </select>
                                    </div>
                                </div>
                                <div class="container">
                                    <table class="table table-sm table-bordered" id="listTableNew">
                                        <thead>
                                            <tr>
                                                <th scope="col" id="numCol">#</th>
                                                <th scope="col" id="itemCol">Item Description</th>
                                                <th scope="col" id="qtyCol">Quantity Order</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="3" id="addNewRow"
                                                    style="font-size: 13px; text-align: center; vertical-align: middle;">
                                                    <div id="addNewRowClick"
                                                        style="cursor:pointer; display: inline-block;"
                                                        onclick="triggerAddProducts()">
                                                        <i class="bi bi-plus-square"></i> Add Product
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <br>
                                <div class="line"></div>
                                <div class="button-container">
                                    <button id="cancelBtn" type="button" onclick="goBack()">Cancel</button>
                                    <button id="sendButton" type="submit" disabled>Send</button>
                                </div>
                            </form>
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

    <div id="overlay" class="overlay">
        <div class="overlay-content">
            <span id="closeBtn" class="close-btn" onclick="closeOverlay()">&times;</span>
            <h3>Select Product</h3>
            <hr>
            <form id="productSelectForm" method="post" enctype="multipart/form-data">
                <div class="container">
                    <div class="textbox">
                        <div class="label">
                            <label for="productSelect">Item Description</label><br>
                        </div>
                        <select id="productSelect" name="productSelect" required>
                            <!-- Options will be populated here -->
                        </select>
                    </div>
                </div>
                <br>
                <div class="container">
                    <div class="textbox">
                        <div class="label">
                            <label for="qtySelect">Quantity</label><br>
                        </div>
                        <input type="number" id="qtySelect" name="qtySelect" required step="1" min="0"
                            onkeydown="return event.key >= '0' && event.key <= '9' || event.key === 'Backspace' || event.key === 'Tab';">
                    </div>
                </div>
                <br>
                <div class="line"></div>
                <div class="button-container">
                    <button id="cancelBtn" type="button" onclick="closeOverlay()">Cancel</button>
                    <button type="submit" id="addProductToListBtn">Add</button>
                </div>
            </form>
        </div>
    </div>
    <!-- End of Overlay for Add -->

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
    <script src="JS-newPO.js"></script>

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