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
    <link rel="stylesheet" href="deli_receive_styles.css">

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
            <h1>Select Order to Receive</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="../dashboard/dashboard.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="delivery.php">Deliveries</a></li>
                    <li class="breadcrumb-item active">Receive Delivery</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section users">
            <div class="row">
                <br>
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body profile-card transactionsTableSize flex-column align-items-center">
                            <table id="example" class="display">
                                <thead>
                                    <tr class="highlight-row">
                                        <th>Order ID</th>
                                        <th>Date</th>
                                        <th>Supplier</th>
                                        <th>No. of Items</th>
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
                                <th scope="col">Order ID</th>
                                <th scope="col">Supplier Name</th>
                                <th scope="col">Purchaser</th>
                                <th scope="col">Date (Time)</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td id="identifierID">12345</td> <!-- Replace with dynamic value -->
                                <td id="supplierName">Supplier ABC</td> <!-- Replace with dynamic value -->
                                <td id="cashierID">John Doe</td> <!-- Replace with dynamic value -->
                                <td id="datetimeID">10/10/2024 (12:30 PM)</td> <!-- Replace with dynamic value -->
                                <td id="Status">Completed</td> <!-- Replace with dynamic value -->
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
                                <th scope="col">Qty. Pending</th>
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
                <div class="line"></div>
                <div class="button-container-2">
                    <button type="submit" id="confirmButton">Receive Delivery</button>
                </div>
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
    <script>
        function setDataTables() {
            $(document).ready(function () {
                $('#example').DataTable({
                    "order": [[1, 'desc']], // Sort by the first column (OrderID) in descending order
                    "columnDefs": [
                        {
                            "targets": 0, // OrderID
                            "width": "17.6%"
                        },
                        {
                            "targets": 1, // Date
                            "width": "17.6%"
                        },
                        {
                            "targets": 2, // Supplier
                            "width": "18.6%"
                        },
                        {
                            "targets": 3, // Qty
                            "width": "16.6%"
                        },
                        {
                            "targets": 4, // Status
                            "width": "18%"
                        },
                        {
                            "targets": 5, // Actions
                            "width": "11.6%"
                        },
                        {
                            "targets": 5, // Index of the column to disable sorting
                            "orderable": false // Disable sorting for column 5 - Actions
                        }
                    ]
                });
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            fetch('../purchaseorders/getPendingPOs.php')
                .then(response => response.json())
                .then(data => updateTable(data))
                .catch(error => alert('Error fetching transactions data:', error));
            setDataTables();
        });

        function updateTable(data) {
            const table = $('#example').DataTable();

            // Clear existing data
            table.clear();

            data.forEach(row => {
                let statusColor;
                if (row.Status === "Pending") {
                    statusColor = '#B8860B';
                } else if (row.Status === "Cancelled") {
                    statusColor = 'red';
                } else if (row.Status === "Partially Received") {
                    statusColor = 'blue';
                } else if (row.Status === "Received") {
                    statusColor = 'green';
                } else {
                    statusColor = 'black';
                }

                // Add the row to the table
                table.row.add([
                    "PO-0" + row.PurchaseOrderID,
                    row.OrderDate,
                    row.SupplierName,
                    row.TotalItems,
                    `<span style="color: ${statusColor};">${row.Status}</span>`, // Apply the color to the Status
                    `<img src="../resources/img/viewfile.png" alt="View" style="cursor:pointer;margin-left:20px;" onclick="fetchDetails('${row.PurchaseOrderID}')"/>`
                ]);
            });


            // Draw the updated table
            table.draw();

        }
        const overlayEdit = document.getElementById('overlayEdit');
        const closeBtnEdit = document.getElementById('closeBtnEdit');
        const identifierID = document.getElementById('identifierID');
        const cashierID = document.getElementById('cashierID');
        const datetimeID = document.getElementById('datetimeID');
        const Status = document.getElementById('Status');
        const Discount = document.getElementById('Discount');
        const NetAmount = document.getElementById('NetAmount');
        const modePay = document.getElementById('modePay');
        const amtPaid = document.getElementById('amtPaid');
        const amtChange = document.getElementById('amtChange');
        const supplierName = document.getElementById('supplierName');

        function resetFields() {
            confirmButton.textContent = "Receive Delivery";
        }

        function fetchDetails(identifier) {
            resetFields();
            fetch(`../purchaseorders/getData.php?InvoiceID=${encodeURIComponent(identifier)}`)
                .then(response => response.json())
                .then(data => {
                    if (data) {
                        // Populate the overlay form with details
                        identifierID.textContent = "PO-0" + data.PurchaseOrderID;
                        supplierName.textContent = data.SupplierName;
                        cashierID.textContent = data.employeeName + " " + data.employeeLName;
                        datetimeID.textContent = data.OrderDate;
                        Status.textContent = data.Status;

                        if (data.Status === "Pending") {
                            Status.style.color = '#B8860B'; // Yellow
                        } else if (data.Status === "Partially Received") {
                            Status.style.color = 'blue';
                        } else if (data.Status === "Cancelled") {
                            Status.style.color = 'red'; // Red
                        } else if (data.Status === "Received") {
                            Status.style.color = 'green'; // Green
                        } else {
                            Status.style.color = 'black'; // Default
                        }

                        // Populate table rows
                        if (data && data.listItems) {
                            const tableBody = document.querySelector('#listTable tbody');
                            tableBody.innerHTML = ''; // Clear existing rows

                            data.listItems.forEach((item, index) => {
                                const row = document.createElement('tr');
                                row.innerHTML = `
                            <th scope="row">${index + 1}</th>
                            <td>${item.description}</td>
                            <td class="editable" data-key="lotNo" id="lotNo"></td>
                            <td class="editable" data-key="expiryDate" id="expiryDate"></td>
                            <td>${item.pending}</td>
                            <td class="editable" data-key="qtyServed" id="qtyServed">0</td>
                            <td class="editable" data-key="bonus" id="bonus">0</td>
                            <td class="editable" data-key="netAmt" id="netAmt">₱0.00</td>
                        `;
                                tableBody.appendChild(row);
                            });

                            // Add event listener to make cells editable
                            enableInlineEditing();
                        }

                        // Show the overlay
                        overlayEdit.style.display = 'flex';
                    } else {
                        console.error('No data found for the given id.');
                    }
                })
                .catch(error => {
                    console.error('Error fetching details:', error);
                });
        }

        // Function to enable inline editing for specific cells
        function enableInlineEditing() {
            document.querySelectorAll('.editable').forEach(cell => {
                cell.addEventListener('click', function () {
                    if (this.querySelector('input')) return; // Prevent duplicate input

                    const originalValue = this.textContent.trim();
                    const input = document.createElement('input');
                    input.type = 'text';
                    input.value = originalValue;
                    if (cell.id === 'expiryDate') {
                        input.placeholder = 'MM/DD/YYYY';
                    } else if (cell.id === 'lotNo') {
                        input.placeholder = 'Ex: 1HT7359';
                    }
                    input.style.width = '120px';

                    this.textContent = ''; // Clear the cell content
                    this.appendChild(input);
                    input.focus();

                    // Save value on blur or Enter key press
                    input.addEventListener('blur', () => saveValue(input, this));
                    input.addEventListener('keydown', function (e) {
                        if (e.key === 'Enter') saveValue(input, cell);
                    });
                });
            });

            // Helper function to save and format value
            function saveValue(input, cell) {
                let newValue = input.value.trim() || cell.dataset.originalValue; // Save or revert

                if (cell.id === 'netAmt') {
                    // Format net amount as currency (₱ + value)
                    const formattedValue = formatCurrency(newValue);
                    cell.textContent = formattedValue;
                } else if (cell.id === 'qtyServed' || cell.id === 'bonus') {
                    const parsedValue = parseInt(newValue, 10);

                    if (!isNaN(parsedValue) && parsedValue >= 0) {
                        newValue = parsedValue; // Save valid value
                    } else {
                        newValue = 0; // Revert if invalid
                    }
                    cell.textContent = newValue;
                } else if (cell.id === 'expiryDate') {
                    const dateRegex = /^(0[1-9]|1[0-2])\/(0[1-9]|[12]\d|3[01])\/\d{4}$/;

                    if (dateRegex.test(newValue)) {
                        const [month, day, year] = newValue.split('/').map(Number);
                        const inputDate = new Date(year, month - 1, day);
                        const currentDate = new Date();

                        // Check if input date is greater than today
                        newValue = inputDate > currentDate ? newValue : '';
                    } else {
                        newValue = ''; // Revert if format is invalid
                    }
                    cell.textContent = newValue;
                }
                else if (cell.id === 'lotNo') {
                    try {
                        const lotNoRegex = /^[A-Za-z0-9]+$/;
                        newValue = lotNoRegex.test(newValue) ? newValue.toUpperCase() : '';
                        cell.textContent = newValue;
                    } catch (error) {
                        cell.textContent = '';
                    }

                } else {
                    cell.textContent = newValue;
                }
            }

            // Function to format value as currency (₱)
            function formatCurrency(value) {
                const numberValue = parseFloat(value.replace(/[^0-9.]+/g, '')); // Remove non-numeric chars
                return isNaN(numberValue) ? '₱0.00' : `₱${numberValue.toFixed(2)}`;
            }
        }


        closeBtnEdit.addEventListener('click', function () {
            overlayEdit.style.display = 'none';
        })
    </script>
    <script src="JS-delivery-receive.js"></script>

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