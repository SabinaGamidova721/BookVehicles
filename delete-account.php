<?php
session_start();
$title = "Delete Account";
include "blocks/connection.php";
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <title>GoodTrip | Account - Details</title>

    <!-- SEO Meta Tags -->
    <meta name="description" content="Silicon - Multipurpose Technology Bootstrap Template">
    <meta name="keywords" content="bootstrap, business, creative agency, mobile app showcase, saas, fintech, finance, online courses, software, medical, conference landing, services, e-commerce, shopping cart, multipurpose, shop, ui kit, marketing, seo, landing, blog, portfolio, html5, css3, javascript, gallery, slider, touch, creative">
    <meta name="author" content="Createx Studio">

    <!-- Viewport -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicon and Touch Icons -->
    <meta name="msapplication-TileColor" content="#080032">
    <meta name="msapplication-config" content="https://silicon.createx.studio/assets/favicon/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">

    <!-- Vendor Styles -->
    <link rel="stylesheet" media="screen" href="https://silicon.createx.studio/assets/vendor/boxicons/css/boxicons.min.css">

    <!-- Main Theme Styles + Bootstrap -->
    <link rel="stylesheet" media="screen" href="https://silicon.createx.studio/assets/css/theme.min.css">

    <!-- Page loading styles -->
    <style>
        .custom-margin-left {
            margin-left: 600px;
        }

        .profile-image-container img {
            border-radius: 50%;
            border-width: 3px;
        }
        .page-loading {
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100%;
            -webkit-transition: all .4s .2s ease-in-out;
            transition: all .4s .2s ease-in-out;
            background-color: #fff;
            opacity: 0;
            visibility: hidden;
            z-index: 9999;
        }
        [data-bs-theme="dark"] .page-loading {
            background-color: #0b0f19;
        }
        .page-loading.active {
            opacity: 1;
            visibility: visible;
        }
        .page-loading-inner {
            position: absolute;
            top: 50%;
            left: 0;
            width: 100%;
            text-align: center;
            -webkit-transform: translateY(-50%);
            transform: translateY(-50%);
            -webkit-transition: opacity .2s ease-in-out;
            transition: opacity .2s ease-in-out;
            opacity: 0;
        }
        .page-loading.active > .page-loading-inner {
            opacity: 1;
        }
        .page-loading-inner > span {
            display: block;
            font-size: 1rem;
            font-weight: normal;
            color: #9397ad;
        }
        [data-bs-theme="dark"] .page-loading-inner > span {
            color: #fff;
            opacity: .6;
        }
        .page-spinner {
            display: inline-block;
            width: 2.75rem;
            height: 2.75rem;
            margin-bottom: .75rem;
            vertical-align: text-bottom;
            border: .15em solid #b4b7c9;
            border-right-color: transparent;
            border-radius: 50%;
            -webkit-animation: spinner .75s linear infinite;
            animation: spinner .75s linear infinite;
        }
        [data-bs-theme="dark"] .page-spinner {
            border-color: rgba(255,255,255,.4);
            border-right-color: transparent;
        }
        @-webkit-keyframes spinner {
            100% {
                -webkit-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }
        @keyframes spinner {
            100% {
                -webkit-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }
    </style>

    <!-- Page loading scripts -->
    <script>
        (function () {
            window.onload = function () {
                const preloader = document.querySelector('.page-loading');
                preloader.classList.remove('active');
                setTimeout(function () {
                    preloader.remove();
                }, 1000);
            };
        })();
    </script>

    <!-- Google Tag Manager -->
    <script>
        (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-WKV3GT5');
    </script>
</head>

<!-- Body -->
<body>
<!-- Google Tag Manager (noscript)-->
<noscript>
    <iframe src="//www.googletagmanager.com/ns.html?id=GTM-WKV3GT5" height="0" width="0" style="display: none; visibility: hidden;" title="Google Tag Manager"></iframe>
</noscript>

<!-- Page loading spinner -->
<div class="page-loading active">
    <div class="page-loading-inner">
        <div class="page-spinner"></div><span>Loading...</span>
    </div>
</div>

<!-- Page wrapper for sticky footer -->
<!-- Wraps everything except footer to push footer to the bottom of the page if there is little content -->
<main class="page-wrapper">
    <!-- Navbar -->
    <!-- Remove "fixed-top" class to make navigation bar scrollable with the page -->
    <header class="header navbar navbar-expand-lg bg-light border-bottom border-light shadow-sm fixed-top">
        <div class="container px-3">
            <a href="home.php" class="navbar-brand pe-3">
                <img src="https://img.freepik.com/premium-vector/bike-sharing-rental-service-line-icon_116137-6023.jpg?w=740" width="50" alt="Logo">
                GoodTrip
            </a>
            <div id="navbarNav" class="offcanvas offcanvas-end">
                <div class="offcanvas-header border-bottom">
                    <h5 class="offcanvas-title">Menu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Landings</a>
                            <div class="dropdown-menu">
                                <div class="d-lg-flex pt-lg-3">
                                    <ul class="list-unstyled mb-3">
                                        <li><a href="#" class="dropdown-item py-1">Something</a></li>
                                        <li><a href="#" class="dropdown-item py-1">Somewhere</a></li>
                                        <li><a href="#" class="dropdown-item py-1">Anywhere</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Some pages</a>
                            <div class="dropdown-menu">
                                <div class="d-lg-flex pt-lg-3">
                                    <ul class="list-unstyled mb-3">
                                        <li><a href="#" class="dropdown-item py-1">Something</a></li>
                                        <li><a href="#" class="dropdown-item py-1">Somewhere</a></li>
                                        <li><a href="#" class="dropdown-item py-1">Anywhere</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle active" data-bs-toggle="dropdown" aria-current="page">Account</a>
                            <ul class="dropdown-menu">
                                <li><a href="account-details.php" class="dropdown-item">Account Details</a></li>
                                <li><a href="favorite-transports.php" class="dropdown-item">Favorite transports</a></li>
                                <li><a href="all-user-orders.php" class="dropdown-item">All my orders</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
                <div>
                    <div class="collapse navbar-collapse" id="navbar-list-4">
                      <ul class="navbar-nav custom-margin-left"> 
                        <li class="nav-item dropdown">
                          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="profile-image-container">
                              <span style="pointer-events: none; margin-left: -140px"><?php echo htmlspecialchars($_SESSION['email']); ?></span>
                              <img src="https://i.pinimg.com/564x/17/5b/20/175b20ba7ee61e9fd476b18a5609c802.jpg" width="45" height="45" style="margin-right: 40px; margin-left: 20px;" class="rounded-circle border border-dark border-2 border-3">
                            </div>
                          </a>
                          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="account-details.php">Account details</a>
                            <a class="dropdown-item" href="make-order-start.php">Create order</a>
                            <a class="dropdown-item" href="favorite-transports.php">Favourite transport</a>
                            <a class="dropdown-item" href="all-user-orders.php">All my orders</a>
                            <a class="dropdown-item" href="auth/signout.php">Sign out</a>
                          </div>
                        </li>   
                      </ul>
                    </div>
                  </div>
        </div>
    </header>

    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["Delete"])) {
            try {
                //$sql = "DELETE FROM userprofiles WHERE id = :user_id AND is_admin = false";

                $sqlUpdate = "UPDATE userprofiles SET is_deleted = 1 WHERE id = :userid AND is_admin = false";
                $stmtUpdate = $conn->prepare($sqlUpdate);
                $stmtUpdate->bindValue(":userid", $_SESSION['user_id']);
                $stmtUpdate->execute();
                header("Location: index.php");
                exit();
                // $stmt = $conn->prepare($sql);
                // $stmt->bindParam(':user_id', $_SESSION['user_id']);
                /* перевіряємо виконання запиту */

                // if ($stmt->execute() && $stmt->rowCount() > 0) {
                //     exit("<meta http-equiv='refresh' content='0; url= /index.php'>");
                // } else {
                //     echo "Error delete values.";
                // }
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }
    ?>

    <!-- Page content -->
    <section class="container pt-5">
        <div class="row">

            <!-- Sidebar (User info + Account menu) -->
            <aside class="col-lg-3 col-md-4 border-end pb-5 mt-n5">
                <div class="position-sticky top-0">
                    <div class="text-center pt-5">
                        <div class="d-table position-relative mx-auto mt-2 mt-lg-4 pt-5 mb-3">
                            <img src="https://cdn-icons-png.flaticon.com/512/4123/4123763.png" class="d-block rounded-circle" width="120" alt="User`s avatar">
                        </div>
                        <h2 class="h5 mb-1"><?php echo $_SESSION['firstname']; ?></h2>
                        <p class="mb-3 pb-3"><?php echo $_SESSION['email']; ?></p>
                        <button type="button" class="btn btn-secondary w-100 d-md-none mt-n2 mb-3" data-bs-toggle="collapse" data-bs-target="#account-menu">
                            <i class="bx bxs-user-detail fs-xl me-2"></i>
                            Account menu
                            <i class="bx bx-chevron-down fs-lg ms-1"></i>
                        </button>
                        <div id="account-menu" class="list-group list-group-flush collapse d-md-block">
                            <a href="account-details.php" class="list-group-item list-group-item-action d-flex align-items-center active">
                                Accountt Details
                            </a>
                            <a href="favorite-transports.php" class="list-group-item list-group-item-action d-flex align-items-center">
                                Favorite transports
                            </a>
                            <a href="all-user-orders.php" class="list-group-item list-group-item-action d-flex align-items-center">
                                All my orders
                            </a>
                            <a href="auth/signout.php" class="list-group-item list-group-item-action d-flex align-items-center">
                                Sign Out
                            </a>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- Delete account -->
            <div class="col-md-8 offset-lg-1 pb-5 mb-2 mb-lg-4 pt-md-5 mt-n3 mt-md-0">
                <div class="ps-md-3 ps-lg-0 mt-md-2 py-md-4">
                    <h1 class="h2 pt-xl-1 pb-3" style='text-align: center''>Delete Account</h1>

                    <!-- Basic info -->
                    <h2 class="h5 text-primary mb-4" style='text-align: center'>Attention:</h2>
                    <p style='text-align: center'>Are you sure you want to delete your account data?</p>
                    <form style='text-align: center' method="post" action="">
                        <input type="submit" class="btn btn-danger" name="Delete" value="Yes, I am sure!">
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>


<!-- Footer -->
<footer class="footer bg-dark border-top border-light py-5" data-bs-theme="dark">
    <div class="container pt-2 pt-sm-4">
        <div class="row">
            <div class="col-md-3 col-lg-5 col-xl-4 pb-2 pb-sm-3 pb-md-0 mb-4 mb-md-0">
                <div class="navbar-brand text-dark p-0 me-2 mb-3 mb-lg-4">
                    <img src="https://img.freepik.com/premium-vector/bike-sharing-rental-service-line-icon_116137-6023.jpg?w=740" width="50" alt="Logo">
                    GoodTrip
                </div>
                <p class="text-body mb-0">Download our app for convenient and fast alternative transportation rental. You can easily find available vehicles even in the busiest areas of the city. Manage your bookings, share your experiences, and get special offers - all in our app, available for iOS and Android.</p>
            </div>
            <div class="col-md-6 col-xxl-5 offset-lg-1 offset-xl-2 offset-xxl-3">
                <div class="row row-cols-1 row-cols-sm-2">
                    <div class="col ps-sm-4 ps-md-5">
                        <h3 class="h5 pb-1 pb-sm-2 pb-lg-3">Useful Links</h3>
                        <ul class="nav flex-column mb-3">
                            <li class="nav-item"><a href="#" class="nav-link d-inline-block px-0 pt-1 pb-2">FAQ</a></li>
                            <li class="nav-item"><a href="#" class="nav-link d-inline-block px-0 pt-1 pb-2">About Us</a></li>
                            <li class="nav-item"><a href="#" class="nav-link d-inline-block px-0 pt-1 pb-2">Privace & Policy</a></li>
                            <li class="nav-item"><a href="#" class="nav-link d-inline-block px-0 pt-1 pb-2">Other data</a></li>
                        </ul>
                    </div>

                    <div class="col ps-sm-4 ps-md-5">
                        <h3 class="h5 pb-1 pb-sm-2 pb-lg-3">Contact us</h3>
                        <ul class="nav flex-column mb-3">
                            <li>
                                <a href="mailto:borovyk2021ks12@student.karazin.ua" class="nav-link d-inline-block px-0 pt-1 pb-2">Oleksandra Borovyk</a><br>
                                <a href="mailto:hamidova2021ks11@student.karazin.ua" class="nav-link d-inline-block px-0 pt-1 pb-2">Sabina Hamidova</a><br>
                                <a href="mailto:koshovyi2021ks11@student.karazin.ua" class="nav-link d-inline-block px-0 pt-1 pb-2">Maxim Koshovyi</a><br>
                                <a href="mailto:litvinenko2021ks11@student.karazin.ua" class="nav-link d-inline-block px-0 pt-1 pb-2">Dmytro Litvinenko</a><br>
                            </li>
                        </ul>
                        <div class="d-flex pt-2 pt-sm-3 pt-md-4">
                            <a href="https://de-de.facebook.com/" class="btn btn-icon btn-secondary btn-facebook rounded-circle me-3" aria-label="Facebook">
                                <i class="bx bxl-facebook"></i>
                            </a>
                            <a href="https://www.linkedin.com/" class="btn btn-icon btn-secondary btn-linkedin rounded-circle me-3" aria-label="LinkedIn">
                                <i class="bx bxl-linkedin"></i>
                            </a>
                            <a href="https://web.telegram.org/k/" class="btn btn-icon btn-secondary btn-telegram rounded-circle me-3" aria-label="Telegram">
                                <i class="bx bxl-telegram"></i>
                            </a>
                            <a href="https://www.youtube.com/" class="btn btn-icon btn-secondary btn-youtube rounded-circle me-3" aria-label="YouTube">
                                <i class="bx bxl-youtube"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <p class="nav d-block fs-sm pt-3 mb-0">
            <span class="text-light opacity-60">&copy; All rights reserved. Made by </span>
            <a class="nav-link d-inline-block p-0" href="#" target="_blank" rel="noopener">InnoCoders</a>
        </p>
    </div>
</footer>


<!-- Vendor Scripts -->
<script src="https://silicon.createx.studio/assets/vendor/cleave.js/dist/cleave.min.js"></script>

</body>
</html>

