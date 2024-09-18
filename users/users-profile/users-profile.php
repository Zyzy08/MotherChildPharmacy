<?php include '../../fetchUser.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Profile - Mother & Child Pharmacy and Medical Supplies</title>
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

  <!-- Template Main CSS File -->
  <link href="../../style.css" rel="stylesheet">

</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <i class="bi bi-list toggle-sidebar-btn"></i>
      <a href="users-profile.php" class="logo d-flex align-items-center">
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
              <h6><?php echo htmlspecialchars($employeeName); ?></h6>
              <span><?php echo htmlspecialchars($role); ?></span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.php">
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

      <li class="nav-item">
        <a class="nav-link collapsed" href="../../suppliers/suppliers.html">
          <i class="bi bi-truck"></i>
          <span>Suppliers</span>
        </a>
      </li><!-- End Suppliers Page Nav -->

      <li class="nav-item"></li>
      <a class="nav-link collapsed" href="../../transactions/transactions.html">
        <i class="bi bi-cash-coin"></i>
        <span>Transactions</span>
      </a>
      </li><!-- End Transactions Page Nav -->

      <li class="nav-item"></li>
      <a class="nav-link collapsed" href="../../inventory/inventory.php">
        <i class="bi bi-box-seam"></i>
        <span>Inventory</span>
      </a>
      </li><!-- End Inventory Page Nav -->

      <li class="nav-item"></li>
      <a class="nav-link collapsed" href="../../returnexchange/return.html">
        <i class="bi bi-cart-dash"></i>
        <span>Return & Exchange</span>
      </a>
      </li><!-- End Return & Exchange Page Nav -->

      <li class="nav-item">
        <a class="nav-link" href="../users.php">
          <i class="bi bi-person"></i>
          <span>Users</span>
        </a>
      </li><!-- End Users Page Nav -->

      <li class="nav-heading"></li>

      <li class="nav-item"></li>
      <a class="nav-link collapsed" href="../../pos/pos.php">
        <i class="bi bi-printer"></i>
        <span>POS</span>
      </a>
      </li><!-- End POS Page Nav -->

    </ul>

  </aside><!-- End Sidebar-->

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Profile</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="../../dashboard/dashboard.php">Home</a></li>
          <li class="breadcrumb-item"><a href="../users.php">Users</a></li>
          <li class="breadcrumb-item active">Profile</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
      <div class="row">
        <div class="col-xl-4">

          <div class="card">
            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

              <img src="../../users/uploads/<?php echo htmlspecialchars($picture); ?>" alt="Profile"
                class="rounded-circle">
              <h2><?php echo htmlspecialchars($employeeName); ?></h2>
              <h3><?php echo htmlspecialchars($role); ?></h3>

            </div>
          </div>

        </div>

        <div class="col-xl-8">

          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered">

                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab"
                    data-bs-target="#profile-overview">Overview</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change
                    Password</button>
                </li>

              </ul>
              <div class="tab-content pt-2">

                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                  <h5 class="card-title">Profile Details</h5>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Full Name</div>
                    <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($employeeName); ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Role</div>
                    <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($role); ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Account Name</div>
                    <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($accountName); ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Password</div>
                    <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars(string: $password); ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Date Created</div>
                    <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($dateCreatedFormatted); ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Status</div>
                    <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($status); ?></div>
                  </div>

                </div>

                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                  <!-- Profile Edit Form -->
                  <form action="upload.php" method="post" enctype="multipart/form-data">
                    <div class="row mb-3">
                      <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                      <div class="col-md-8 col-lg-9">
                        <img src="../../users/uploads/<?php echo htmlspecialchars($picture); ?>" alt="Profile">
                        <div class="pt-2">
                          <a href="#" id="upload-button" class="btn btn-primary btn-sm"
                            title="Upload new profile image">
                            <i class="bi bi-upload"></i>
                          </a>
                          <input type="file" id="upload-input" name="profileImage" style="display:none;">
                          <a href="#" class="btn btn-danger btn-sm" title="Remove my profile image">
                            <i class="bi bi-trash"></i>
                          </a>
                        </div>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Full Name</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="fullName" type="text" class="form-control" id="fullName"
                          value="<?php echo htmlspecialchars($employeeName); ?>">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="role" class="col-md-4 col-lg-3 col-form-label">Role</label>
                      <div class="col-md-8 col-lg-9">
                        <a class="form-control d-flex align-items-center collapsed" data-bs-toggle="collapse"
                          href="#role-dropdown" aria-expanded="false">
                          <span id="role-text"><?php echo htmlspecialchars($role); ?></span>
                          <i class="bi bi-chevron-down ms-auto"></i>
                        </a>
                        <ul id="role-dropdown" class="collapse nav-content list-unstyled mt-2">
                          <li>
                            <a href="#" onclick="setRole('Admin')">
                              <i class="bi bi-circle"></i>
                              <span>Admin</span>
                            </a>
                          </li>
                          <li>
                            <a href="#" onclick="setRole('Pharmacy Assistant')">
                              <i class="bi bi-circle"></i>
                              <span>Pharmacy Assistant</span>
                            </a>
                          </li>
                          <li>
                            <a href="#" onclick="setRole('Purchaser / Pharmacy Assistant')">
                              <i class="bi bi-circle"></i>
                              <span>Purchaser / Pharmacy Assistant</span>
                            </a>
                          </li>
                        </ul>
                        <input type="hidden" id="role" name="role" value="<?php echo htmlspecialchars($role); ?>">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="accountName" class="col-md-4 col-lg-3 col-form-label">Account Name</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="accountName" type="text" class="form-control" id="accountName"
                          value="<?php echo htmlspecialchars($accountName); ?>">
                      </div>
                    </div>

                    <div class="text-center">
                      <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                  </form><!-- End Profile Edit Form -->

                </div>

                <div class="tab-pane fade pt-3" id="profile-settings">

                  <!-- Settings Form -->
                  <form>

                    <div class="row mb-3">
                      <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Email Notifications</label>
                      <div class="col-md-8 col-lg-9">
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" id="changesMade" checked>
                          <label class="form-check-label" for="changesMade">
                            Changes made to your account
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" id="newProducts" checked>
                          <label class="form-check-label" for="newProducts">
                            Information on new products and services
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" id="proOffers">
                          <label class="form-check-label" for="proOffers">
                            Marketing and promo offers
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" id="securityNotify" checked disabled>
                          <label class="form-check-label" for="securityNotify">
                            Security alerts
                          </label>
                        </div>
                      </div>
                    </div>

                    <div class="text-center">
                      <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                  </form><!-- End settings Form -->

                </div>

                <div class="tab-pane fade pt-3" id="profile-change-password">
                  <!-- Change Password Form -->
                  <form id="passForm" method="post" enctype="multipart/form-data">

                    <div class="row mb-3">
                      <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="password" type="password" class="form-control" id="currentPassword">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="newpassword" type="password" class="form-control" id="newPassword">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="renewpassword" type="password" class="form-control" id="renewPassword">
                      </div>
                    </div>

                    <div class="text-center">
                      <button type="submit" class="btn btn-primary">Change Password</button>
                    </div>
                  </form><!-- End Change Password Form -->

                </div>

              </div><!-- End Bordered Tabs -->

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
      Designed by <a href="https://www.sti.edu/campuses-details.asp?campus_id=QU5H">STI College Angeles - BSIT4-A s.y
        2024-2025 </a>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
      class="bi bi-arrow-up-short"></i></a>

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
  <script src="profile.js"></script>

</body>

</html>