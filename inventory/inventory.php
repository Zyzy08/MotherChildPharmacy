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

  <!-- Template Main CSS File -->
  <link href="../style.css" rel="stylesheet">
  <link href="../inventory/invent_style.css" rel="stylesheet">

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
              <h6><?php echo htmlspecialchars($employeeName); ?></h6>
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

      <li class="nav-item">
        <a class="nav-link collapsed" href="../suppliers/suppliers.html">
          <i class="bi bi-truck"></i>
          <span>Suppliers</span>
        </a>
      </li><!-- End Suppliers Page Nav -->

      <li class="nav-item"></li>
      <a class="nav-link collapsed" href="../transactions/transactions.html">
        <i class="bi bi-cash-coin"></i>
        <span>Transactions</span>
      </a>
      </li><!-- End Transactions Page Nav -->

      <li class="nav-item"></li>
      <a class="nav-link collapsed" href="../inventory/inventory.php">
        <i class="bi bi-box-seam"></i>
        <span>Inventory</span>
      </a>
      </li><!-- End Inventory Page Nav -->

      <li class="nav-item"></li>
      <a class="nav-link collapsed" href="../returnexchange/return.html">
        <i class="bi bi-cart-dash"></i>
        <span>Return & Exchange</span>
      </a>
      </li><!-- End Return & Exchange Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="../users/users.html">
          <i class="bi bi-person"></i>
          <span>Users</span>
        </a>
      </li><!-- End Users Page Nav -->

      <li class="nav-heading"></li>

      <li class="nav-item"></li>
      <a class="nav-link collapsed" href="../pos/pos.html">
        <i class="bi bi-printer"></i>
        <span>POS</span>
      </a>
      </li><!-- End POS Page Nav -->

    </ul>

  </aside><!-- End Sidebar-->

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Inventory</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
          <li class="breadcrumb-item active">Inventory</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <button class="Create_PO">Create Purchase Order</button>
    <button class="deleteProduct">Delete Product</button>
    <button id="updateProduct">Update Product</button>

    <form id="PurchaseForm" class="modal" enctype="multipart/form-data" action="../inventory/getInventory.php"
      method="POST">
      <div class="modal-content">
        <h2>Create New Purchase Order</h2>
        <button class="close" id="closeBtn">&times;</button>
        <hr style="margin-top: 30px;">

        <div class="form-section">
          <h3 class="h3">Supplier Information</h3>

          <div>
            <label style="margin-right: 150px;" for="itemName">Item Name</label>
            <label for="itemType">Item Type</label>

          </div>

          <div class="textbox">
            <input style="margin-right: 30px;" type="text" id="itemName" name="itemName" required>
            <input type="text" id="itemType" name="itemType" required>
          </div>

          <div class="textbox">
            <label style="margin-right: 135px;" for="brandName">Brand Name</label>
            <label for="genericName">Generic Name</label>
          </div>
          <div class="textbox">
            <input style="margin-right: 30px;" type="text" id="brandName" name="brandName" required>
            <input type="text" id="genericName" name="genericName" required>
          </div>
          <!--<div class="textbox">
                    <label style="margin-right: 195px;" for="productCode">Product Code</label>
                    <label for="barcode">Barcode</label>
                </div>
                <div class="textbox">
                    <input style="margin-right: 30px;" type="text" id="productCode" name="productCode">
                    <input type="text" id="barcode" name="Barcode">
                </div>-->
          <div>
            <label style="margin-right: 110px;" for="unitOfMeasure">Unit of Measure</label>
            <label for="mass">Mass</label>
          </div>
          <div class="textbox">
            <input style="margin-right: 30px;" type="text" id="unitOfMeasure" name="unitOfMeasure" required>
            <input type="text" id="mass" name="mass" required>
          </div>
        </div>

        <hr style="margin-top: 15px;">
        <div class="form-section">

          <h3 class="h3">Sale Information</h3>

          <div class="textbox">
            <label style="margin-right: 130px;" for="pricePerUnit">Price Per Unit</label>
            <label for="InStock">Instock</label>
          </div>
          <div class="textbox">
            <input style="margin-right: 30px;" type="text" id="pricePerUnit" name="pricePerUnit" placeholder="₱"
              required>
            <input type="text" id="InStock" name="InStock" required>
          </div>
          <div class="textbox">
            <label style="margin-right: 185px;" for="notes">Notes</label>
            <label for="status">Status</label>
          </div>
          <div class="textbox">
            <input style="margin-right: 30px;" type="text" id="notes" name="notes" required>
            <input type="text" id="status" name="status" required>
          </div>
        </div>

        <div style="margin-top: 30px;" class="form-button">
          <button type="button" id="Clear">Clear</button>
          <button type="submit" id="saveBtn">Save</button>
        </div>
      </div>
    </form>

    <div class="searchbox">
      <svg class="left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 18">
        <title>magnifier</title>
        <g stroke-width="1.5" fill="none" stroke="#212121" class="nc-icon-wrapper">
          <line x1="15.25" y1="15.25" x2="11.285" y2="11.285" stroke-linecap="round" stroke-linejoin="round"
            stroke="#212121">
          </line>
          <circle cx="7.75" cy="7.75" r="5" stroke-linecap="round" stroke-linejoin="round"></circle>
        </g>
      </svg>
      <input type="text" placeholder="Search Product....." id="searchInput">
    </div>


    <div class="table_product">
      <div id="errorContainer"></div> <!-- Error message container -->
      <table>
        <thead>
          <tr class="highlight-row">
            <th class="col7">Item Name</th>
            <th class="col7">Brand Name</th>
            <th class="col7">Generic Name</th>
            <th class="col7">Item Type</th>
            <th class="col7">Mass</th>
            <th class="col7">Price Per Unit</th>
            <th class="col7">Instock</th>
          </tr>
        </thead>
        <tbody id="tableBody">
          <!-- Data rows will be inserted here by JavaScript -->
        </tbody>
      </table>


      <!-- Notification Container -->
      <div id="notification" class="notification">
        <p id="notificationMessage">Double-click the row that you want to edit.</p>
        <button id="closeNotification" class="btn btn-secondary">Close</button>
      </div>
      <!-- Delete Modal -->
      <div id="deleteModal" class="deleteModal">
        <div class="modal-content">
          <span id="closeDeleteBtn" class="closeBtn">&times;</span>
          <h2>Delete Confirmation</h2>
          <p>Are you sure you want to delete this item?</p>
          <button id="confirmDeleteBtn">Confirm</button>
          <button id="cancelDeleteBtn">Cancel</button>
        </div>
      </div>

      <!-- Notification -->
      <div id="notification" class="notification">
        <span id="closeNotification" class="closeNotification">&times;</span>
        <p id="notificationMessage">Notification message goes here.</p>
      </div>



















  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>Mother & Child Pharmacy and Medical Supplies</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
      Designed by <a href="https://www.sti.edu/campuses-details.asp?campus_id=QU5H">STI College Angeles - BSIT4-A s.y
        2024-2025 </a>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
      class="bi bi-arrow-up-short"></i></a>

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
  <script src="../inventory/invent_Js.js"></script>

</body>

</html>