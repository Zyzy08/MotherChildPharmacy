<?php include '../fetchUser.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Transactions - Mother & Child Pharmacy and Medical Supplies</title>
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
    <link rel="stylesheet" href="trans_styles.css">

    <!-- DataTables Imports -->
    <link rel="stylesheet" href="dataTablesTransactions/dataTablesT.css" />
    <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.1.6/js/dataTables.js"></script>

    <!-- DataTables Buttons Extension CSS and JavaScript -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.1.2/css/buttons.dataTables.min.css">
    <script src="https://cdn.datatables.net/buttons/3.1.2/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.dataTables.js"></script>

    <!-- Additional Libraries for Exporting -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.print.min.js"></script>

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
                    <a class="nav-link" href="../transactions/transactions.php">
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
            <h1>Transactions</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="../dashboard/dashboard.php">Home</a></li>
                    <li class="breadcrumb-item active">Transactions</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section users">
            <div class="row">
                <div class="col-xl-12">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="1-tab" data-bs-toggle="tab" data-bs-target="#home"
                                type="button" role="tab" aria-controls="home" aria-selected="true">Sales</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="2-tab" data-bs-toggle="tab" data-bs-target="#contact"
                                type="button" role="tab" aria-controls="contact" aria-selected="false"
                                tabindex="-1">Return/Exchange</button>
                        </li>
                        <!-- <li class="nav-item" role="presentation">
                            <button class="nav-link" id="3-tab" data-bs-toggle="tab" data-bs-target="#contact"
                                type="button" role="tab" aria-controls="contact" aria-selected="false"
                                tabindex="-1">Purchase Orders</button>
                        </li> -->
                    </ul>
                    <div class="card">
                        <div class="card-body profile-card transactionsTableSize flex-column align-items-center">
                            <table id="example" class="display">
                                <thead>
                                    <tr class="highlight-row">
                                        <th>Invoice ID</th>
                                        <th>Date (Time)</th>
                                        <th>No. of Items</th>
                                        <th>Total</th>
                                        <th>Payment</th>
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
            <h2>Transaction Details</h2>
            <hr>
            <form id="userFormEdit" action="updateAccount.php" method="post" enctype="multipart/form-data"
                onsubmit="handleFormSubmit()">
                <div class="container">
                    <div class="textbox">
                        <div class="label">
                            <label for="identifierID">Invoice ID</label><br>
                        </div>
                        <input type="text" id="identifierID" name="identifierID" disabled>
                    </div>
                    <div class="textbox">
                        <div class="label">
                            <label for="transactionType">Type of Transaction</label><br>
                        </div>
                        <input type="text" id="transactionType" name="transactionType" disabled>
                    </div>
                    <div class="textbox">
                        <div class="label">
                            <label for="cashierID">Cashier</label><br>
                        </div>
                        <input type="text" id="cashierID" name="cashierID" disabled>
                    </div>
                    <div class="textbox">
                        <div class="label">
                            <label for="datetimeID">Date (Time)</label><br>
                        </div>
                        <input type="text" id="datetimeID" name="datetimeID" disabled>
                    </div>
                </div>
                <div class="container">
                    <div class="textbox">
                        <div class="label">
                            <label for="listQTY">List of Items</label><br>
                        </div>
                        <textarea id="listQTY" name="listQTY" disabled></textarea>
                    </div>
                </div>
                <div class="textboxHidden">
                    <div class="label">
                        <label for="AccountID">AccountID</label><br>
                    </div>
                    <input type="text" id="AccountID" name="AccountID" required>
                </div>
                <div class="container">
                    <div class="textbox">
                        <div class="label">
                            <label for="VATable">VATable Sales</label><br>
                        </div>
                        <input type="text" id="VATable" name="VATable" disabled>
                    </div>
                    <div class="textbox">
                        <div class="label">
                            <label for="VATAmount">VAT Amount</label><br>
                        </div>
                        <input type="text" id="VATAmount" name="VATAmount" disabled>
                    </div>
                    <div class="textbox">
                        <div class="label">
                            <label for="Discount">Discount</label><br>
                        </div>
                        <input type="text" id="Discount" name="Discount" disabled>
                    </div>
                    <div class="textbox">
                        <div class="label">
                            <label for="NetAmount">Net Amount</label><br>
                        </div>
                        <input type="text" id="NetAmount" name="NetAmount" disabled>
                    </div>
                </div>
                <div class="container">
                    <div class="textbox">
                        <div class="label">
                            <label for="modePay">Mode of Payment</label><br>
                        </div>
                        <input type="text" id="modePay" name="modePay" disabled>
                    </div>
                    <div class="textbox">
                        <div class="label">
                            <label for="amtPaid">Amount Paid</label><br>
                        </div>
                        <input type="text" id="amtPaid" name="amtPaid" disabled>
                    </div>
                    <div class="textbox">
                        <div class="label">
                            <label for="amtChange">Amount Change</label><br>
                        </div>
                        <input type="text" id="amtChange" name="amtChange" disabled>
                    </div>
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
            <form id="userFormAD" action="deleteData.php" method="post" enctype="multipart/form-data"
                onsubmit="handleFormSubmit()">
                <button id="deleteDataBtn" type="button"><img src="../resources/img/delete.png"
                        style="padding-bottom: 2px;"> Void Transaction</button>
            </form>
        </div>
    </div>
    <!-- End of Overlay for Options -->


    <!-- Template Main JS File -->
    <script src="../main.js"></script>
    <script src="JS-transactions.js"></script>

    <!-- Vendor JS Files -->
    <script src="../resources/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="../resources/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../resources/vendor/chart.js/chart.umd.js"></script>
    <script src="../resources/vendor/echarts/echarts.min.js"></script>
    <script src="../resources/vendor/quill/quill.js"></script>
    <script src="../resources/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="../resources/vendor/tinymce/tinymce.min.js"></script>
    <script src="../resources/vendor/php-email-form/validate.js"></script>

    <script>
        const userRole = '<?php echo $role; ?>'; // Embed PHP role variable into JavaScript

        function setDataTables() {
            $(document).ready(function () {
                $('#example').DataTable({
                    "order": [], // Disable initial sorting
                    "pageLength": 5,
                    "columnDefs": [
                        {
                            "targets": 0, // InvoiceID
                            "width": "17.6%"
                        },
                        {
                            "targets": 1, // Date
                            "width": "23.6%"
                        },
                        {
                            "targets": 2, // Quantity
                            "width": "15.6%"
                        },
                        {
                            "targets": 3, // Total
                            "width": "16.6%"
                        },
                        {
                            "targets": 4, // Payment
                            "width": "15%"
                        },
                        {
                            "targets": 5, // Actions
                            "width": "11.6%"
                        },
                        {
                            "targets": 5, // Index of the column to disable sorting
                            "orderable": false // Disable sorting for column 5 - Actions
                        }
                    ],
                    "layout": {
                        "topStart": {
                            buttons: [
                                {
                                    extend: 'pdfHtml5',
                                    text: 'Export PDF',
                                    pageSize: 'A4', // Set the page size
                                    title: 'Sales of Mother and Child Pharmacy and Medical Supplies',
                                    exportOptions: {
                                        columns: ':not(:last-child)' // Exclude the last column
                                    },
                                    customize: function (doc) {
                                        // Set font size for the whole document
                                        doc.defaultStyle.fontSize = 10;

                                        // Add custom margins
                                        doc.pageMargins = [40, 60, 40, 60];

                                        // Set column widths to make them equal
                                        const columnCount = doc.content[1].table.body[0].length;
                                        doc.content[1].table.widths = Array(columnCount).fill('*');

                                        // Customize the table header
                                        doc.styles.tableHeader = {
                                            alignment: 'left',
                                            fontSize: 12,
                                        };

                                        // Add additional elements such as a footer
                                        doc['footer'] = (currentPage, pageCount) => {
                                            return {
                                                columns: [
                                                    {
                                                        text: `Page ${currentPage} of ${pageCount}`,
                                                        alignment: 'right',
                                                        fontSize: 8,
                                                        margin: [0, 10, 40, 0],
                                                    }
                                                ]
                                            };
                                        };
                                    }
                                }
                            ]
                        }
                    }
                });
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            fetch('getTransactions.php')
                .then(response => response.json())
                .then(data => updateTable(data))
                .catch(error => alert('Error fetching transactions data:', error));
            setDataTables();
        });

        function updateTable(data) {
            const table = $('#example').DataTable();

            table.clear();

            data.forEach(row => {
                const deleteIcon = (userRole === 'Admin')
                    ? `<img src="../resources/img/s-remove.png" 
                    alt="Delete" 
                    style="cursor:pointer;margin-left:10px;" 
                    onclick="showOptions('${row.InvoiceID}')"/>`
                    : '';

                table.row.add([
                    'IN-0' + row.InvoiceID,
                    row.SalesDate,
                    row.TotalItems,
                    "₱ " + row.NetAmount,
                    row.PaymentMethod,
                    `<img src="../resources/img/viewfile.png" 
                alt="View" 
                style="cursor:pointer;margin-left:10px;" 
                onclick="fetchDetails('${row.InvoiceID}')"/> 
            ${deleteIcon}`
                ]);
            });

            table.draw();
        }


        const overlayEdit = document.getElementById('overlayEdit');
        const closeBtnEdit = document.getElementById('closeBtnEdit');
        const identifierID = document.getElementById('identifierID');
        const cashierID = document.getElementById('cashierID');
        const datetimeID = document.getElementById('datetimeID');
        const listQTY = document.getElementById('listQTY');
        const VATable = document.getElementById('VATable');
        const VATAmount = document.getElementById('VATAmount');
        const Discount = document.getElementById('Discount');
        const NetAmount = document.getElementById('NetAmount');
        const modePay = document.getElementById('modePay');
        const amtPaid = document.getElementById('amtPaid');
        const amtChange = document.getElementById('amtChange');
        const transactionType = document.getElementById('transactionType');


        function fetchDetails(identifier) {
            fetch(`getData.php?InvoiceID=${encodeURIComponent(identifier)}`)
                .then(response => response.json())
                .then(data => {
                    if (data) {
                        // Populate the overlay form with details
                        identifierID.value = 'IN-0' + data.InvoiceID;
                        cashierID.value = data.employeeName + " " + data.employeeLName;
                        datetimeID.value = data.SalesDate;
                        VATable.value = "₱ " + data.Subtotal;
                        VATAmount.value = "₱ " + data.Tax;
                        Discount.value = "₱ " + data.Discount;
                        NetAmount.value = "₱ " + data.NetAmount;
                        modePay.value = data.PaymentMethod;
                        amtPaid.value = "₱ " + data.AmountPaid;
                        amtChange.value = "₱ " + data.AmountChange;
                        transactionType.value = data.Status;

                        // Set listQTY input value
                        listQTY.value = data.listQTY; // Update the listQTY input

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


        closeBtnEdit.addEventListener('click', function () {
            overlayEdit.style.display = 'none';
        })

        //Show Options Section

        const overlayAD = document.getElementById('overlayAD');
        const overlayADtitle = document.getElementById('overlayADtitle');

        let selectedID = '';
        function showOptions(identifier) {
            selectedID = identifier;
            overlayADtitle.textContent = "InvoiceID " + identifier;
            overlayAD.style.display = 'flex';
        };

        const closeBtnAD = document.getElementById('closeBtnAD');
        closeBtnAD.addEventListener('click', function () {
            overlayAD.style.display = 'none';
        })

        const deleteDataBtn = document.getElementById('deleteDataBtn');
        deleteDataBtn.addEventListener('click', function () {
            let confirmationUser = confirm("Are you sure you want to void this transaction?");
            if (confirmationUser === true) {
                if (!selectedID || selectedID.trim() === '') {
                    alert('No data selected.');
                    return;
                }

                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'deleteData.php', true);
                xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');

                // Handle the response
                xhr.onload = function () {
                    if (xhr.status >= 200 && xhr.status < 300) {
                        const response = JSON.parse(xhr.responseText);
                        document.getElementById('modalMessage').textContent = response.message;
                    } else {
                        alert('Error: ' + xhr.status);
                    }
                };

                xhr.send(JSON.stringify({ selectedID: selectedID }));
                alert("Transaction voided successfully!");
                setTimeout(() => {
                    window.location.href = 'transactions.php'; // Redirect on success
                }, 100);
            } else {

            }
        });

        //Tabs for Types
        const tab1 = document.getElementById('1-tab');
        const tab2 = document.getElementById('2-tab');
        // const tab3 = document.getElementById('3-tab');

        function fetchTransactions(tab) {
            fetch(`getTransactions.php?tab=${tab}`)
                .then(response => response.json())
                .then(data => updateTable(data))
                .catch(error => {
                    console.error('Error fetching transactions:', error);
                });
        }

        // Event listeners for tab clicks
        tab1.addEventListener('click', () => fetchTransactions('1'));
        tab2.addEventListener('click', () => fetchTransactions('2'));
        // tab3.addEventListener('click', () => fetchTransactions('3'));


    </script>

</body>

</html>