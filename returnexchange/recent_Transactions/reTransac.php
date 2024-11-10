<?php include '../../fetchUser.php'; ?>
<?php include '../fetchProductData.php'; ?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Select Order - Mother & Child Pharmacy and Medical Supplies</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="../../resources/img/favicon.png" rel="icon">
  <link href="../../resources/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link
    href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
    rel="stylesheet">

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

  <!-- DataTables Imports -->
  <link rel="stylesheet" href="../../transactions/dataTablesTransactions/dataTablesT.css" />
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
            <img src="../../users/uploads/<?php echo htmlspecialchars($picture); ?>" alt="Profile"
              class="rounded-circle">
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
          <li class="breadcrumb-item active">Select Order</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section users">
      <div class="row">
        <div class="col-xl-12">
          <div class="card">
            <div class="card-body profile-card transactionsTableSize flex-column align-items-center">
              <table id="example" class="display">
                <thead>
                  <tr class="highlight-row">
                    <th>Invoice ID</th>
                    <th>Date (Time)</th>
                    <th>No. of Items</th>
                    <th>Total</th>
                    <th>Staff</th>
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
      &copy; Copyright <strong><span>Mother & Child Pharmacy and Medical Supplies</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
      Designed by <a href="https://www.sti.edu/campuses-details.asp?campus_id=QU5H">STI College Angeles - BSIT4-A S.Y
        2024-2025 </a>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
      class="bi bi-arrow-up-short"></i></a>

  <div id="overlayEdit" class="overlay">
    <div class="overlay-content">
      <span id="closeBtnEdit" class="close-btn">&times;</span>
      <h2>Transaction Details</h2>
      <hr>
      <form id="userFormEdit" action="../../transactions/updateAccount.php" method="post" enctype="multipart/form-data"
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
      <form id="userFormAD" action="../../transactions/deleteData.php" method="post" enctype="multipart/form-data"
        onsubmit="handleFormSubmit()">
        <button id="deleteDataBtn" type="button"><img src="../resources/img/delete.png" style="padding-bottom: 2px;">
          Void Transaction</button>
      </form>
    </div>
  </div>
  <!-- End of Overlay for Options -->

  <!-- Receipt Modal -->
  <div class="modal" id="largeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog modal-lg" id="receipt-modal-dialog">
      <div class="modal-content" id="receipt-modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Receipt</h5>
          <span id="closeBtnReceipt" class="close-btn">&times;</span>
        </div>
        <h5 style="font-weight: bold; text-align: center; padding-top: 10px">Mother & Child</h5>
        <h5 style="font-weight: bold; text-align: center;">Pharmacy and Medical Supplies</h5>
        <h6 style="text-align: center;">Gen. Luna Street, Babo Sacan</h6>
        <h6 style="text-align: center;">Porac, Pampanga</h6>
        <h6 style="text-align: center;">
          --------------------------------------------------------
        </h6>
        <div class="modal-body" style="padding-inline: 40px; padding-top: 0px;">
          <div id="receiptItems"></div> <!-- Container for receipt items -->
        </div>

        <div class="row text-center justify-content-between">
          <div class="col-xl-5 firstxl5">
            <small>Total Items:</small>
          </div>
          <div class="col-xl-5 secondxl5">
            <small id="total-items">0</small>
          </div>
        </div>

        <div class="row text-center justify-content-between">
          <div class="col-xl-5 firstxl5">
            <small>Subtotal:</small>
          </div>
          <div class="col-xl-5 secondxl5">
            <small id="sub-total">₱0.00</small>
          </div>
        </div>

        <div class="row text-center justify-content-between">
          <div class="col-xl-5 firstxl5">
            <small>VAT (12%):</small>
          </div>
          <div class="col-xl-5 secondxl5">
            <small id="tax">₱0.00</small>
          </div>
        </div>

        <div class="row text-center justify-content-between" id="receiptModal-discountRow" style="display: none;">
          <div class="col-xl-5 firstxl5">
            <small>Discount:</small>
          </div>
          <div class="col-xl-5 secondxl5">
            <small id="discount">₱-0.00</small>
          </div>
        </div>

        <div class="row text-center justify-content-between" style="font-weight: bold;">
          <div class="col-xl-5 firstxl5">
            <small>Amount Due:</small>
          </div>
          <div class="col-xl-5 secondxl5">
            <small id="amount-due">₱0.00</small>
          </div>
        </div>

        <div class="row text-center justify-content-between" id="receiptModal-refundRow">
          <div class="col-xl-5 firstxl5">
            <small>Refund Amount:</small>
          </div>
          <div class="col-xl-5 secondxl5">
            <small id="refund-amount">₱0.00</small>
          </div>
        </div>

        <div class="row text-center justify-content-between">
          <div class="col-xl-5 firstxl5">
            <small>Payment:</small>
          </div>
          <div class="col-xl-5 secondxl5">
            <small id="payment">₱0.00</small>
          </div>
        </div>

        <div class="row text-center justify-content-between">
          <div class="col-xl-5 firstxl5">
            <small>Change:</small>
          </div>
          <div class="col-xl-5 secondxl5">
            <small id="change">₱0.00</small>
          </div>
        </div>

        <h6 style="text-align: center;">
          --------------------------------------------------------
        </h6>

        <div class="row text-center justify-content-between">
          <div class="col-xl-5 firstxl5">
            <small>Order No.:</small>
          </div>
          <div class="col-xl-5 secondxl5">
            <small id="order-num">#0000000</small>
          </div>
        </div>

        <div class="row text-center justify-content-between">
          <div class="col-xl-5 firstxl5">
            <small>Date:
            </small>
          </div>
          <div class="col-xl-5 secondxl5">
            <small id="date-time">
            </small>
          </div>
        </div>

        <div class="row text-center justify-content-between">
          <div class="col-xl-5 firstxl5">
            <small>Status:</small>
          </div>
          <div class="col-xl-5 secondxl5">
            <small id="status">Sales</small>
          </div>
        </div>

        <div class="row text-center justify-content-between">
          <div class="col-xl-5 firstxl5">
            <small id="stafflabel">Staff:</small>
          </div>
          <div class="col-xl-5 secondxl5">
            <small id="staff"></small>
          </div>
        </div>
        <br>

        <div class="modal-footer">
          <div class="d-grid gap-2">
            <button id="select-order-button" type="button" class="btn btn-primary">
              Select
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

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

  <script>
    const userRole = '<?php echo $role; ?>'; // Embed PHP role variable into JavaScript

    function setDataTables() {
      $(document).ready(function () {
        $('#example').DataTable({
          "order": [[0, 'desc']], // Sort by the first column (OrderID) in descending order
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
              "width": "14.6%"
            },
            {
              "targets": 4, // Staff
              "width": "17%"
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

            }
          }
        });
      });
    }

    document.addEventListener('DOMContentLoaded', () => {
      fetch('../../transactions/getTransactions.php')
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
          ? `<img src="../../resources/img/s-remove.png" 
                    alt="Delete" 
                    style="cursor:pointer;margin-left:10px;" 
                    onclick="showOptions('${row.InvoiceID}')"/>`
          : '';

        table.row.add([
          'IN-0' + row.InvoiceID,
          row.SalesDate,
          row.TotalItems,
          "₱ " + row.NetAmount,
          row.employeeName + ' ' + row.employeeLName,
          `<img src="../../resources/img/viewfile.png" 
                alt="View" 
                style="cursor:pointer;margin-left:20px;" 
                onclick="fetchDetails('${row.InvoiceID}')"/>`
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

    // Receipt Elements
    const largeModal = document.getElementById('largeModal');
    const closeBtnReceipt = document.getElementById('closeBtnReceipt');
    const change = document.getElementById('change');
    const payment = document.getElementById('payment');
    const refundamount = document.getElementById('refund-amount');
    const amountdue = document.getElementById('amount-due');
    const discount = document.getElementById('discount');
    const tax = document.getElementById('tax');
    const totalitems = document.getElementById('total-items');
    const subtotal = document.getElementById('sub-total');
    // const paymentmethod = document.getElementById('payment-method');
    const staff = document.getElementById('staff');
    const datetime = document.getElementById('date-time');
    const ordernum = document.getElementById('order-num');
    const status = document.getElementById('status');

    function fetchDetails(identifier) {
      fetch(`../../transactions/getData.php?InvoiceID=${encodeURIComponent(identifier)}`)
        .then(response => response.json())
        .then(data => {
          if (data) {
            displayReceiptItems(data.listItems);
            totalitems.textContent = data.TotalItems;
            tax.textContent = '₱' + data.Tax;
            discount.textContent = '₱' + data.Discount;
            subtotal.textContent = '₱' + data.Subtotal;
            amountdue.textContent = '₱' + data.NetAmount;
            refundamount.textContent = '₱' + data.RefundAmount;
            // paymentmethod.textContent = data.PaymentMethod;
            payment.textContent = '₱' + data.AmountPaid;
            change.textContent = '₱' + data.AmountChange;
            ordernum.textContent = '#' + data.InvoiceID;
            datetime.textContent = 'Date: ' + data.SalesDate;
            staff.textContent = 'Staff: ' + data.employeeName + ' ' + data.employeeLName;

            // Conditionally show or hide the Refund row
            const refundRow = document.getElementById('receiptModal-refundRow');
            if (parseFloat(data.RefundAmount) === 0) {
              refundRow.style.display = 'none';
            } else {
              refundRow.style.display = 'flex';
              refundamount.textContent = '₱' + data.RefundAmount;
            }

            // Conditionally show or hide the Discount row
            const discountRow = document.getElementById('receiptModal-discountRow');
            if (parseFloat(data.Discount) === 0) {
              discountRow.style.display = 'none';
            } else {
              discountRow.style.display = 'flex';
              discount.textContent = '₱' + data.Discount;
            }

            // Show the overlay
            largeModal.style.display = 'block';
          } else {
            console.error('No data found for the given id.');
          }
        })
        .catch(error => {
          console.error('Error fetching details:', error);
        });
    }

    closeBtnReceipt.addEventListener('click', function () {
      largeModal.style.display = 'none';
    })

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

      // Fetch invoice details (including SaleDate)
      fetch(`../../transactions/getData.php?InvoiceID=${identifier}`)
        .then(response => response.json())
        .then(data => {
          if (data && data.SalesDateTime) {
            const invoiceDate = new Date(data.SalesDateTime);
            const currentDate = new Date();
            const timeDiff = currentDate - invoiceDate;
            const oneDayInMs = 24 * 60 * 60 * 1000;

            // Enable/disable the button based on the time difference
            if (timeDiff < oneDayInMs) {
              deleteDataBtn.disabled = false;
              deleteDataBtn.classList.remove('disabled-button');
              deleteDataBtn.removeAttribute('title');  // Remove any previous tooltip
              deleteDataBtn.style.cursor = 'pointer';  // Set cursor to pointer
            } else {
              deleteDataBtn.disabled = true;
              deleteDataBtn.classList.add('disabled-button');
              deleteDataBtn.setAttribute('title', 'This transaction can only be voided within 24 hours.');
              deleteDataBtn.style.cursor = 'not-allowed';  // Set cursor to not-allowed
            }
          }
        })
        .catch(error => console.error('Error fetching invoice data:', error));

      overlayAD.style.display = 'flex';
    };

    const closeBtnAD = document.getElementById('closeBtnAD');
    closeBtnAD.addEventListener('click', function () {
      overlayAD.style.display = 'none';
    })

    const deleteDataBtn = document.getElementById('deleteDataBtn');
    deleteDataBtn.addEventListener('click', function () {

    });

    function displayReceiptItems(orderDetails) {
      const receiptContainer = document.getElementById('receiptItems');
      receiptContainer.innerHTML = '';

      const headerHTML = `
        <div class="row mb-2">
            <div class="col-2"><small><strong>Qty</strong></small></div>
            <div class="col-4" style="text-align: right;"><small><strong>Item Description</strong></small></div>
        </div>`;
      receiptContainer.insertAdjacentHTML('beforeend', headerHTML);

      orderDetails.forEach(item => {
        const itemHTML = `
            <div class="row">
                <div class="col-2"><small>${item.qty}</small></div>
                <div class="col-4" style="text-align: right;"><small>${item.description}</small></div>
            </div>`;
        receiptContainer.insertAdjacentHTML('beforeend', itemHTML);
      });
    }

    function fetchTransactions(tab) {
      fetch(`../../transactions/getTransactions.php?tab=${tab}`)
        .then(response => response.json())
        .then(data => updateTable(data))
        .catch(error => {
          console.error('Error fetching transactions:', error);
        });
    }

  </script>

</body>

</html>