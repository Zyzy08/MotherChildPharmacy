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
  <link href="../inventory/invent_style.css" rel="stylesheet">

</head>
<body class="page">
    <div class="sidebar">
        <div class="sidebar-1"></div>
        <div class="sidebar-2"></div>
        <div class="sidebar-3"></div>
        <img src="../resources/img/mnc_logo.png" alt="Mother & Child Logo" class="logo">
        <span class="main-text">Mother & Child</span>
        <small class="sub-text">Pharmacy & Medical Supplies</small>
        <ul class="sidebar-menu">
            <li class="sidebar-menu-item">
                <a href="../dashboard/dashboard.php">
                    <img src="../resources/dashboard_icon.png" alt="Dashboard Icon" class="sidebar-icon">
                    Dashboard
                    <img src="../resources/rectangle.png" alt="Indicator" class="indicator">
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="#">
                    <img src="../resources/products.png" alt="Products Icon" class="sidebar-icon">
                    Products
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="#">
                    <img src="../resources/suppliers.png" alt="Suppliers Icon" class="sidebar-icon">
                    Suppliers
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="#">
                    <img src="../resources/transactions.png" alt="Transactions Icon" class="sidebar-icon">
                    Transactions
                </a>
            </li>
            <li class="sidebar-menu-item selected">
                <a href="#">
                    <img src="../resources/inventory_active.png" alt="Inventory Icon" class="sidebar-icon">
                    Inventory
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="#">
                    <img src="../resources/pos.png" alt="POS Icon" class="sidebar-icon">
                    POS
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="#">
                    <img src="../resources/return.png" alt="Return / Exchange Icon" class="sidebar-icon">
                    Return / Exchange
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="../users/users.php">
                    <img src="../resources/accounts.png" alt="Accounts Icon" class="sidebar-icon">
                    Accounts
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="#">
                    <img src="../resources/logout.png" alt="Logout Icon" class="sidebar-icon">
                    Logout
                </a>
            </li>
        </ul>
    </div>
    <div class="dash-info">
        <h1 class="dash_text">Inventory</h1>

        <button class="Create_PO">Create Purchase Order</button>
        <button id="deleteProduct" class="deleteProduct">Delete</button>
        <button id="updateProduct">Update</button>
        <span class="user-name">Aileen Castro (Admin)</span>
        <img src="../resources/profile_icon.png" alt="Aileen Castro" class="avatar">
    </div>
    
    <form id="PurchaseForm" class="modal" enctype="multipart/form-data" action="getInventory.php" method="POST">
        <div class="modal-content">
            <h2>Create New Purchase Order</h2>
            <button class="close" id="closeBtn">&times;</button>
            <hr style="margin-top: 30px;">
            
            <div class="form-section">
                <h3 class="h3">Supplier Information</h3>

                <div>
                    <label style="margin-right: 180px;" for="itemName">Item Name</label>
                    <label for="itemType">Item Type</label>
                    
                </div>

                <div class="textbox">
                    <input style="margin-right: 30px;" type="text" id="itemName" name="itemName" required>
                    <input type="text" id="itemType" name="itemType" required>
                </div>

                <div class="textbox">
                    <label style="margin-right: 170px;" for="brandName">Brand Name</label>
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
                    <label style="margin-right: 150px;" for="unitOfMeasure">Unit of Measure</label>
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
                    <label style="margin-right: 165px;" for="pricePerUnit">Price Per Unit</label>
                    <label for="InStock">Instock</label>
                </div>
                <div class="textbox">
                    <input style="margin-right: 30px;" type="text" id="pricePerUnit" name="pricePerUnit" placeholder="₱" required>
                    <input type="text" id="InStock" name="InStock" required>
                </div>
                <div class="textbox">
                    <label style="margin-right: 215px;" for="notes">Notes</label>
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



</body>
<script src="invent_Js.js"></script>
</html>
