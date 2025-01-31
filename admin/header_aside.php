<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>NABRE GROUP LTD</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="../assets/img/logo.png" rel="icon">
    <link href="../assets/img/logo.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="../assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="../assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="../assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="../assets/css/style.css" rel="stylesheet">

    <style>
    .container {
        display: flex;
        flex-wrap: wrap;

    }

    .box {
        flex: 1 1 300px;
        margin: 10px;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-shadow: 0 0 5px #ccc;
    }

    hr {
        border: none;
        height: 3px;
        background-color: #ccc;
        font-weight: bold;
    }
    </style>

</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="dashboard.php" class="logo d-flex align-items-center">
                <img src="../assets/img/logo.png" alt="">
                <span class="d-none d-lg-block text-center my-3">NABRE<br>GROUP LIMITED</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->


        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">

                <li class="nav-item d-block d-lg-none">
                    <a class="nav-link nav-icon search-bar-toggle " href="#">
                        <i class="bi bi-search"></i>
                    </a>
                </li><!-- End Search Icon-->

                <li class="nav-item dropdown pe-3">

                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <img src="../assets/img/logo.png" alt="Profile" class="rounded-circle">
                        <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $_SESSION['username']; ?></span>
                    </a><!-- End Profile Iamge Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6><?php echo $_SESSION['username']; ?></h6>
                            <span>ADMINISTRATOR</span>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>


                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="logout.php">
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
                <a class="nav-link " href="dashboard.php">
                    <i class="bi bi-house-fill"></i>
                    <span>Dashboard</span>
                </a>
            </li><!-- End Dashboard Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-person-fill"></i><span>Borrowers</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">

                    <li>
                        <a href="view-borrowers.php">
                            <i class="bi bi-circle"></i><span>View Borrowers</span>
                        </a>
                    </li>
                    <li>
                        <a href="add-borrowers.php">
                            <i class="bi bi-circle"></i><span>Add Borrowers</span>
                        </a>
                    </li>
                    <li>
                        <a href="view-borrower-groups.php">
                            <i class="bi bi-circle"></i><span>View Borrower Groups</span>
                        </a>
                    </li>
                    <li>
                        <a href="add-borrower-group.php">
                            <i class="bi bi-circle"></i><span>Add Borrower Groups</span>
                        </a>
                    </li>

                </ul>
            </li><!-- End Borrowers Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-journal-text"></i><span>Loans</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="view-loans.php">
                            <i class="bi bi-circle"></i><span>View All Loans</span>
                        </a>
                    </li>
                    <li>
                        <a href="add-Loan.php">
                            <i class="bi bi-circle"></i><span>Add Loan</span>
                        </a>
                    </li>
                    <li>
                        <a href="due-loans.php">
                            <i class="bi bi-circle"></i><span>Due Loans</span>
                        </a>
                    </li>

                    <li>
                        <a href="view-edited-dueLoans.php">
                            <i class="bi bi-circle"></i><span>Edited Due Loans</span>
                        </a>
                    </li>

                </ul>
            </li><!-- End Loans Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#pannel-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-currency-dollar"></i><span>Recoveries</span><i
                        class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="pannel-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="view-repayments.php">
                            <i class="bi bi-circle"></i><span>View Recoveries</span>
                        </a>
                    </li>

                    <li>
                        <a href="add-repayments.php">
                            <i class="bi bi-circle"></i><span>Add Recoveries</span>
                        </a>
                    </li>
                    <!-- <li>

            <a href="approve-payment.php">
              <i class="bi bi-circle"></i><span>Approve Recoveries</span>
            </a>
          </li> -->
                </ul>
            </li><!-- End Payments Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-bank"></i><span>Savings</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="add-savings.php">
                            <i class="bi bi-circle"></i><span>Add Savings</span>
                        </a>
                    </li>
                    <li>
                        <a href="view-savings.php">
                            <i class="bi bi-circle"></i><span>View Savings</span>
                        </a>
                    </li>

                    <li>
                        <a href="withdraw.php">
                            <i class="bi bi-circle"></i><span>Withdraw</span>
                        </a>
                    </li>
                </ul>
            </li><!-- End Savings Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#panel-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-list-ul"></i><span>Collateral</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="panel-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="register-collateral.php">
                            <i class="bi bi-circle"></i><span>Register Collateral</span>
                        </a>
                    </li>
                    <li>
                        <a href="view-collaterals.php">
                            <i class="bi bi-circle"></i><span>View Collaterals</span>
                        </a>
                    </li>
                </ul>
            </li><!-- End Colllateral Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#expense-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-reply-fill"></i><span>Expenses</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="expense-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="view-expenses.php">
                            <i class="bi bi-circle"></i><span>View Expenses</span>
                        </a>
                    </li>
                    <li>
                        <a href="add-expenses.php">
                            <i class="bi bi-circle"></i><span>Add Expenses</span>
                        </a>
                    </li>
                </ul>
            </li><!-- End Expenses Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#monthly-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-justify"></i><span>Administrative</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="monthly-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="add-monthly-administration.php">
                            <i class="bi bi-circle"></i><span>Add Monthly Investments</span>
                        </a>
                    </li>

                    <li>
                        <a href="view-monthly-investments.php">
                            <i class="bi bi-circle"></i><span>View Monthly Investments</span>
                        </a>
                    </li>

                    <li>
                        <a href="view-monthly-administration.php">
                            <i class="bi bi-circle"></i><span>View Monthly Administrative</span>
                        </a>
                    </li>
                </ul>
            </li><!-- End Administrative Cost Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-bar-chart"></i><span>Reports</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="charts-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="view-reports.php">
                            <i class="bi bi-circle"></i><span>View Reports</span>
                        </a>
                    </li>
                    <!-- <li>
            <a href="generate-reports.php">
              <i class="bi bi-circle"></i><span>Generate Reports</span>
            </a>
          </li> -->
                </ul>
            </li><!-- End Reports Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#officers" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-people"></i><span>Officers</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="officers" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="officers-register.php">
                            <i class="bi bi-circle"></i><span>Register Officers</span>
                        </a>
                    </li>
                    <li>
                        <a href="view-officers.php">
                            <i class="bi bi-circle"></i><span>View officers</span>
                        </a>
                    </li>

                    <li>
                        <a href="register-household.php">
                            <i class="bi bi-circle"></i><span>Register HouseHold</span>
                        </a>
                    </li>

                    <li>
                        <a href="view-households.php">
                            <i class="bi bi-circle"></i><span>View HouseHolds</span>
                        </a>
                    </li>
                </ul>
            </li><!-- End Administrative Cost Nav -->

        </ul>

    </aside><!-- End Sidebar-->