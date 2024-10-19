<?php include '../fetchUser.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Inventory - Mother & Child Pharmacy and Medical Supplies</title>
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

  <!-- DataTables Imports -->
  <link rel="stylesheet" href="../users/dataTablesUsers/dataTables.css" />
  <!--<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css" /-->
  <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <script src="https://cdn.datatables.net/2.1.6/js/dataTables.js"></script>

  <!-- Template Main CSS File -->
  <link href="../style.css" rel="stylesheet">
  <link href="../inventory/invent_style.css" rel="stylesheet">
  
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
        <a class="nav-link collapsed" href="../dashboard/dashboard.php">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-heading"></li>

      <li class="nav-item">
                    <a class="nav-link collapsed" href="../suppliers/suppliers.php">
                        <i class="bi bi-shop"></i>
                        <span>Suppliers</span>
                    </a>
                </li><!-- End Suppliers Page Nav -->

      <li class="nav-item"></li>
      <a class="nav-link collapsed" href="../transactions/transactions.php">
        <i class="bi bi-cash-coin"></i>
        <span>Transactions</span>
      </a>
      </li><!-- End Transactions Page Nav -->

      <li class="nav-item"></li>
          <a class="nav-link collapsed" href="../purchaseorders/purchaseorders.php">
              <i class="bi bi-mailbox"></i>
              <span>Purchase Orders</span>
          </a>
      </li><!-- End Purchase Order Page Nav -->

      <li class="nav-item">
            <a class="nav-link collapsed" href="../delivery/delivery.php">
                <i class="bi bi-truck"></i>
                <span>Delivery</span>
            </a>
        </li><!-- End Delivery Page Nav -->


      <li class="nav-item"></li>
      <a class="nav-link" href="../inventory/inventory.php">
        <i class="bi bi-box-seam"></i>
        <span>Inventory</span>
      </a>
      </li><!-- End Inventory Page Nav -->


      <li class="nav-heading"></li>

      <li class="nav-item"></li>
      <a class="nav-link collapsed" href="../pos/pos.php">
        <i class="bi bi-printer"></i>
        <span>POS</span>
      </a>
      </li><!-- End POS Page Nav -->

      <li class="nav-item"></li>
      <a class="nav-link collapsed" href="../returnexchange/return.html">
        <i class="bi bi-cart-dash"></i>
        <span>Return & Exchange</span>
      </a>
      </li><!-- End Return & Exchange Page Nav -->

      <li class="nav-heading"></li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="../users/users.php">
          <i class="bi bi-person"></i>
          <span>Users</span>
        </a>
      </li><!-- End Users Page Nav -->

      <li class="nav-item">
            <a class="nav-link collapsed" href="../audittrail/audittrail.php">
                <i class="bi bi-clipboard-data"></i>
                <span>Audit Trail</span>
            </a>
        </li><!-- End Audit Trail Page Nav -->


        <li class="nav-item">
            <a class="nav-link collapsed" href="../backuprestore/backuprestore.php">
                <i class="bi bi-cloud-check"></i>
                <span>Backup & Restore</span>
            </a>
        </li><!-- End B&R Page Nav -->


    </ul>

  </aside><!-- End Sidebar-->

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Inventory</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="../dashboard/dashboard.php">Home</a></li>
          <li class="breadcrumb-item active">Inventory</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <!--<button class="Create_PO"><img src="../resources/img/add.png" alt="Add"> New Product</button>
    <div class="archived-users" id="toArchivedUsers">
                        Archived Users<img src="../resources/img/right-arrow-3.png" alt="Archive Button">
    </div>-->
    <div class="row">
          <div class="containerAddArchive">

          <div class="button" id="addUser">
              <button class="Create_PO" id="addProductButton">
                  <img src="../resources/img/add.png" alt="Add"> New Product
              </button>
          </div>
                    


            <div class="button" id="checkLowStockButton">
                <img src="../resources/img/ALERT.png" alt="Status Button">
                Status
            </div>

              <div class="archived-users" id="toArchivedUsers">
                  Archived Product<img src="../resources/img/right-arrow-3.png" alt="Archive Button">
              </div>
        </div>

    <!--<button class="deleteProduct">Delete Product</button>
    <button id="updateProduct">Update Product</button>-->

  
    
    <form id="PurchaseForm" class="modal" enctype="multipart/form-data" action="../inventory/insertInventory.php"
      method="POST">
      <div class="modal-content">

        <div class="form-section">
          <h3 class="h3">Product Information & Sale Information</h3>
          

          <button class="close" id="closeBtn">&times;</button>
          <hr style="margin-top: 5px">
          <div>
            <label style="margin-right: 200px;" for="ItemID">Item ID</label>
            <label style="margin-right: 180px;" for="itemType">Item Type</label>
            
            <label for="pricePerUnit">Price Per Unit</label>
          </div>

          <div class="textbox">
            <input style="margin-right: 30px;" type="text" id="itemID" name="itemID" readonly>
            <select style="margin-right: 30px;" class="itemType" id="itemType" name="itemType">
              <option value=""></option>
              <option value="Medicine">Medicine</option>
              <option value="Milk">Milk</option>
              <option value="Supplement">Supplement</option>
              <option value="Vitamin">Vitamins</option>
              <option value="Skincar">Skincare</option>
              <option value="Cosmetic">Cosmetic</option>
            </select>
            
            <!--<input type="text" id="pricePerUnit" name="pricePerUnit" placeholder="₱" onfocus="addPesoSign()" oninput="addPesoSign()" /> -->
            <input type="number" id="pricePerUnit" name="pricePerUnit" placeholder="₱ " onfocus="addPesoSign()" oninput="updatePrice()" />
          </div>

          <div class="textbox">
            <label style="margin-right: 160px;" for="brandName">Brand Name</label>
            <label style="margin-right: 148px;" for="genericName">Generic Name</label>
            <label for="Discount">Discount</label>
          </div>

          <div class="textbox">
            <input style="margin-right: 30px;" type="text" id="brandName" name="brandName">
            <input style="margin-right: 30px;" type="text" id="genericName" name="genericName">

            <select name="Discount" id="Discount" onchange="updateValue()">
            <option value=""></option>
                <option value="1">Available</option>
                <option value="0">Unavailable</option>
                
            </select>
            
          </div>

          <div>
            <label style="margin-right: 215px;" for="mass">Mass</label>
            <label style="margin-right: 137px;" for="unitOfMeasure">Unit of Measure</label>
            <label  for="VAT_exempted">VAT Exempted</label>
            
          </div>
          <div class="textbox">
            <input style="margin-right: 30px;" type="number" id="mass" name="mass">
            <!--<input type="text" id="unitOfMeasure" name="unitOfMeasure">-->
            <select style="margin-right: 35px;" class="unitOfMeasure" id="unitOfMeasure" name="unitOfMeasure">
              <option value=""></option>
              <option value="kg">kg</option>
              <option value="g">g</option>
              <option value="Mg">Mg</option>
              <option value="mcg">mcg/µg</option>
              <option value="ng">ng</option>
              <option value="L">L</option>
              <option value="mL">mL</option>
              <option value="mol">mol</option>
              <option value="	mmol">mmol</option>
            </select>

            <select name="VAT_exempted" id="VAT_exempted" onchange="updateValue()">
            <option value=""></option>
                <option value="1">Available</option>
                <option value="0">Unavailable</option>
                
            </select>
   
         

            
          </div>
        </div>
        <div>
          <label style="margin-right: 152px;" for="ProductCode">Product Code</label>
          <label  for="InStock">Instock</label>
        </div>
        <div class="textbox">
          <input style="margin-right: 30px;" type="text" id="productCode" name="ProductCode">
          <input type="number" id="inStockInput" name="InStock" placeholder="">
          
          
        </div>
        <div class=""></div>


        <div class="textbox">
          <label for="iconFile">Picture</label>
          <div class="icon-upload">
            <label for="iconFile">
              <img id="iconPreview" src="../resources/img/add_icon.png" alt="+" class="icon-preview"
                style="cursor: pointer;">
            </label>
            <input type="file" id="iconFile" name="ProductIcon" accept="image/*" style="display: none;">
          </div>
        </div>
        <hr style="margin-top: 15px;">

        <div style="margin-top: 10px;" class="form-button">
          <button type="button" id="Clear">Clear</button>
          <button type="submit" id="saveBtn">Save</button>
        </div>
      </div>
    </form>

    <section class="section users">
      <div class="row">
        <br>
        <!-- <div id="usersNum" class="usercount">
                    0 users
                </div> -->
        <div class="col-xl-12">
          <div class="card">
            <div class="card-body profile-card usersTableSize flex-column align-items-center">
              <table id="example" class="display">
                <thead>
                  <tr class="highlight-row">
                      <th style="text-align: center; font-size: 12px;">Item ID</th>
                      <th style="text-align: center; font-size: 12px;">Picture</th>
                      <th style="text-align: center; font-size: 12px;">Generic Name</th>
                      <th style="text-align: center; font-size: 12px;">Brand Name</th>
                      <th style="text-align: center; font-size: 12px;">Item Type</th>
                      <th style="text-align: center; font-size: 12px;">Measurement</th>
                      <th style="text-align: center; font-size: 12px;">Price</th>
                      <!--<th style="text-align: center; font-size: 12px;">Status</th>-->
                      <th style="text-align: center; font-size: 12px;">InStock</th>
                      <th style="text-align: center; font-size: 12px;">Ordered</th>
                      <th style="text-align: center; font-size: 12px;">Actions</th>
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

    <!-- Notification, Delete Modal, etc. -->
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


                <!-- Archive Modal (overlayAD) -->
                <div id="overlayAD" class="overlay" style="display: none;"> <!-- Initially hidden -->
                  <div class="overlayAD-content">
                      <span id="closeBtnAD" class="close-btn">&times;</span>
                      <h2>Other Options</h2>
                      <hr>
                      <button id="archiveUserBtn" type="button" data-bs-toggle="modal" data-bs-target="#disablebackdrop-AD">
                          <img src="../resources/img/box-archive.png"> Archive Product
                      </button>
                      <br>
                      <div class="modal" id="disablebackdrop-AD" tabindex="-1" data-bs-backdrop="false">
                          <div class="modal-dialog">
                              <div class="modal-content">
                                  <div class="modal-header">
                                      <h5 class="modal-title" id="modalVerifyTitle-AD">Confirmation</h5>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="modalClose-AD"></button>
                                  </div>
                                  <div class="modal-body" id="modalVerifyText-AD">
                                      Are you sure you want to do this?
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

    <!-- LOW STOCK MODAL -->
    <div id="lowStockModal" class="modal" role="dialog" aria-modal="true">
        <div class="modal-content">
            <span class="closeAlert">&times;</span>
            <h2 style="text-align: left;">Low Stock Items</h2>
            <hr>
            <div id="lowStockMessage" style="margin-top: 10px; overflow-y: auto; max-height: 300px;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background-color: #f2f2f2;">
                            <th style="text-align: left; padding: 8px;">Brand Name</th>
                            <th style="text-align: left; padding: 8px;">Generic Name</th>
                            <th style="text-align: left; padding: 8px;">In Stock</th>
                            <th style="text-align: left; padding: 8px;">Ordered</th>
                        </tr>
                    </thead>
                    <tbody id="lowStockItemsBody">
                        <!-- Low stock messages will be appended here -->
                    </tbody>
                </table>
            </div>
            <hr>
        </div>
    </div>




          <div class="modal" id="disablebackdrop" tabindex="-1" data-bs-backdrop="false">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="modalVerifyTitle">Success</h5>
                  </div>
                  <div class="modal-body" id="modalVerifyText">
                      Supplier data has been updated successfully.
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

<!--<hr style="margin-top: 15px;">-->

<!--<div>
        <label for="icon">Icon</label>
              <div class="icon-upload">
                  <img  id="iconPreview" src="../resources/default_icon.png" alt="Icon Preview" class="icon-preview">
                  <label for="iconFile" class="icon-label">+</label>
                  <input  type="file" id="iconFile" accept="image/*" style="display: none;">
              </div>
        </div>-->