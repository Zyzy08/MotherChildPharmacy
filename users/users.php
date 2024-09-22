<?php include '../fetchUser.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Users - Mother & Child Pharmacy and Medical Supplies</title>
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
    <link rel="stylesheet" href="acc_styles.css">

    <!-- DataTables Imports -->
    <link rel="stylesheet" href="dataTablesUsers/dataTables.css" />
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
                        <img src="../users/uploads/<?php echo htmlspecialchars($picture); ?>" alt="Profile"
                            class="rounded-circle">
                        <span
                            class="d-none d-md-block dropdown-toggle ps-2"><?php echo htmlspecialchars($formattedName); ?></span>
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
                            <a class="dropdown-item d-flex align-items-center"
                                href="users-profile/users-profile.php">
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
                <a class="nav-link collapsed" href="../suppliers/suppliers.html">
                    <i class="bi bi-truck"></i>
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
                <a class="nav-link" href="../users/users.php">
                    <i class="bi bi-person"></i>
                    <span>Users</span>
                </a>
            </li><!-- End Users Page Nav -->

            <li class="nav-heading"></li>

            <li class="nav-item"></li>
            <a class="nav-link collapsed" href="../pos/pos.php">
                <i class="bi bi-printer"></i>
                <span>POS</span>
            </a>
            </li><!-- End POS Page Nav -->

        </ul>

    </aside><!-- End Sidebar-->

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Users</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="../dashboard/dashboard.php">Home</a></li>
                    <li class="breadcrumb-item active">Users</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section users">
            <div class="row">
                <div class="containerAddArchive">
                    <div class="button" id="addUser">
                        <img src="../resources/img/add.png" alt="Add User"> Add User
                    </div>
                    <div class="archived-users" id="toArchivedUsers">
                        Archived Users<img src="../resources/img/right-arrow-3.png" alt="Archive Button">
                    </div>
                </div>
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
                                        <th>Employee Name</th>
                                        <th>Role</th>
                                        <th>Account Name</th>
                                        <th>Date Created</th>
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

    <div id="overlay" class="overlay">
        <div class="overlay-content">
            <span id="closeBtn" class="close-btn">&times;</span>
            <h2>Add New User</h2>
            <hr>
            <h3>Basic Information</h3>
            <form id="userForm" action="addAccount.php" method="post" enctype="multipart/form-data"
                onsubmit="handleFormSubmit()">
                <div class="container">
                    <div class="textbox">
                        <div class="label">
                            <label for="newEmployeeID">Employee ID</label><br>
                        </div>
                        <input type="text" id="newEmployeeID" name="newEmployeeID" disabled>
                    </div>
                </div>
                <div class="container">
                    <div class="textbox">
                        <div class="label">
                            <label for="employeeName">Employee First Name</label><br>
                        </div>
                        <input type="text" id="employeeName" name="employeeName" required>
                    </div>
                    <div class="textbox">
                        <div class="label">
                            <label for="employeeLName">Employee Last Name</label><br>
                        </div>
                        <input type="text" id="employeeLName" name="employeeLName" required>
                    </div>
                </div>
                <div class="container">
                    <div class="textbox">
                        <div class="label">
                            <label for="accountName">Account Name</label><br>
                        </div>
                        <input type="text" id="accountName" name="accountName" required disabled>
                    </div>
                    <div class="textbox">
                        <div class="label">
                            <label for="password">Password</label><br>
                        </div>
                        <input id="password" name="password" required disabled>
                    </div>
                </div>
                <div class="container">
                    <div class="textbox">
                        <div class="label">
                            <label for="profilePicture">Profile Picture</label><br>
                        </div>
                        <input type="file" id="profilePicture" name="profilePicture" accept="image/*">
                    </div>
                    <div class="textbox">
                        <div class="label">
                            <label for="preview">Image Preview</label><br>
                        </div>
                        <img id="preview" src="" alt="Image Preview" style="display: none;">
                    </div>
                </div>
                <div class="container">
                    <div class="textbox">
                        <div class="label">
                            <label for="role">Role</label><br>
                        </div>
                        <select name="role" id="role">
                            <option value="Pharmacy Assistant">Pharmacy Assistant</option>
                            <option value="Purchaser">Purchaser</option>
                            <option value="Admin">Admin</option>
                        </select>
                    </div>
                    <!-- Modify Permissions -->
                    <div class="permissionsBox">
                        <div class="label">
                            <label for="permsSelect">Permissions</label>
                            <img src="../resources/img/toggle-off.png" id="permsToggle">
                            <br>
                        </div>
                        <div class="permissionsSelect">
                            <input type="checkbox" id="SuppliersPerms" disabled> Suppliers
                            <input type="checkbox" id="TransactionsPerms" disabled> Sales
                            <input type="checkbox" id="InventoryPerms" disabled> Inventory
                            <input type="checkbox" id="POSPerms" disabled> POS
                            <input type="checkbox" id="REPerms" disabled> Return & Exchange
                            <input type="checkbox" id="POPerms" disabled> Purchase Orders
                            <input type="checkbox" id="UsersPerms" disabled> Users
                        </div>
                    </div>
                </div>
                <br>
                <div class="line"></div>
                <div class="button-container">
                    <button id="cancelBtn" type="button" onclick="closeOverlay()">Cancel</button>
                    <button type="submit">Add</button>
                </div>
            </form>
        </div>
    </div>
    <!-- End of Overlay for Add -->

    <div id="overlayEdit" class="overlay">
        <div class="overlay-content">
            <span id="closeBtnEdit" class="close-btn">&times;</span>
            <h2>Edit User</h2>
            <hr>
            <h3>Basic Information</h3>
            <form id="userFormEdit" action="updateAccount.php" method="post" enctype="multipart/form-data"
                onsubmit="handleFormSubmit()">
                <div class="container">
                    <div class="textbox">
                        <div class="label">
                            <label for="currentEmployeeID">Employee ID</label><br>
                        </div>
                        <input type="text" id="currentEmployeeID" name="currentEmployeeID" disabled>
                    </div>
                </div>
                <div class="container">
                    <div class="textbox">
                        <div class="label">
                            <label for="employeeNameEdit">Employee First Name</label><br>
                        </div>
                        <input type="text" id="employeeNameEdit" name="employeeNameEdit" required>
                    </div>
                    <div class="textbox">
                        <div class="label">
                            <label for="employeeLName">Employee Last Name</label><br>
                        </div>
                        <input type="text" id="employeeLNameEdit" name="employeeLNameEdit" required>
                    </div>
                </div>
                <div class="container">
                    <div class="textbox">
                        <div class="label">
                            <label for="accountNameEdit">Account Name</label><br>
                        </div>
                        <input type="text" id="accountNameEdit" name="accountNameEdit" required disabled>
                    </div>
                    <div class="textbox">
                        <div class="label">
                            <label for="passwordEdit">Password</label><br>
                        </div>
                        <input type="password" id="passwordEdit" name="passwordEdit" required disabled>
                    </div>
                </div>
                <div class="container">
                    <div class="textbox">
                        <div class="label">
                            <label for="profilePictureEdit">Profile Picture</label><br>
                        </div>
                        <input type="file" id="profilePictureEdit" name="profilePictureEdit" accept="image/*">
                    </div>
                    <div class="textbox">
                        <div class="label">
                            <label for="previewEdit">Image Preview</label><br>
                        </div>
                        <img id="previewEdit" src="" alt="Image Preview" style="display: none;">
                    </div>
                </div>
                <div class="container">
                    <div class="textbox">
                        <div class="label">
                            <label for="roleEdit">Role</label><br>
                        </div>
                        <select name="roleEdit" id="roleEdit">
                            <option value="Pharmacy Assistant">Pharmacy Assistant</option>
                            <option value="Purchaser">Purchaser</option>
                            <option value="Admin">Admin</option>
                        </select>
                    </div>
                    <!-- Modify Permissions -->
                    <div class="permissionsBox">
                        <div class="label">
                            <label for="permsSelectEdit">Permissions</label>
                            <img src="../resources/img/toggle-off.png" id="permsToggleEdit">
                            <br>
                        </div>
                        <div class="permissionsSelectEdit">
                            <input type="checkbox" id="SuppliersPermsEdit" disabled> Suppliers
                            <input type="checkbox" id="TransactionsPermsEdit" disabled> Sales
                            <input type="checkbox" id="InventoryPermsEdit" disabled> Inventory
                            <input type="checkbox" id="POSPermsEdit" disabled> POS
                            <input type="checkbox" id="REPermsEdit" disabled> Return & Exchange
                            <input type="checkbox" id="POPermsEdit" disabled> Purchase Orders
                            <input type="checkbox" id="UsersPermsEdit" disabled> Users
                        </div>
                    </div>
                </div>
                <div class="textboxHidden">
                    <div class="label">
                        <label for="AccountID">AccountID</label><br>
                    </div>
                    <input type="text" id="AccountID" name="AccountID" required>
                </div>
                <br>
                <div class="line"></div>
                <div class="button-container">
                    <button id="cancelBtn" type="button" onclick="closeEditOverlay()">Cancel</button>
                    <button type="submit">Update</button>
                </div>
            </form>
        </div>
    </div>
    <!-- End of Overlay for Edit -->

    <div id="overlayAD" class="overlay">
        <div class="overlayAD-content">
            <span id="closeBtnAD" class="close-btn">&times;</span>
            <h2>Other Options</h2>
            <hr>
            <form id="userFormAD" action="archiveAccount.php" method="post" enctype="multipart/form-data"
                onsubmit="handleFormSubmit()">
                <button id="archiveUserBtn" type="button"><img src="../resources/img/archive.png"> Archive User
                    Account</button>
                <button id="deleteUserBtn" type="button"><img src="../resources/img/delete.png"> Delete User
                    Permanently</button>
                <button id="resetPasswordBtn" type="button"><img src="../resources/img/resetPass.png"> Reset
                    Password</button>
            </form>
        </div>
    </div>
    <!-- End of Overlay for Archive/Delete -->


    <!-- Template Main JS File -->
    <script src="../main.js"></script>
    <script src="Users.js"></script>

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