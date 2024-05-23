<?php
    include "blocks/connection.php";
    session_start();

    $stmt = $conn->prepare("SELECT id, location FROM points");
    $stmt->execute();
    $locations = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["but_submit"])) {
        $userId = $_SESSION["user_id"];
        $vehicleId = $_GET["id"];
        $endPoint = $_POST["endPoint"];
        $startDate = date('Y-m-d H:i:s');

        $stmt = $conn->prepare("SELECT current_point FROM vehicles WHERE id = :vehicleId");
        $stmt->bindParam(':vehicleId', $vehicleId, PDO::PARAM_INT);
        $stmt->execute();
        $currentPoint = $stmt->fetch(PDO::FETCH_ASSOC)['current_point'];

        $stmt = $conn->prepare("SELECT id FROM statuses WHERE title = 'active'");
        $stmt->execute();
        $statusId = $stmt->fetch(PDO::FETCH_ASSOC)['id'];

        $stmt = $conn->prepare("INSERT INTO orders (userprofile_id, vehicle_id, startdate, enddate, total_price, status_id, startpoint, endpoint) VALUES (:userId, :vehicleId, :startDate, NULL, NULL, :statusId, :startPoint, :endPoint)");
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':vehicleId', $vehicleId, PDO::PARAM_INT);
        $stmt->bindParam(':startDate', $startDate, PDO::PARAM_STR);
        $stmt->bindParam(':statusId', $statusId, PDO::PARAM_INT);
        $stmt->bindParam(':startPoint', $currentPoint, PDO::PARAM_INT);
        $stmt->bindParam(':endPoint', $endPoint, PDO::PARAM_INT);
        $stmt->execute();

        $stmt = $conn->prepare("UPDATE vehicles SET is_available = 0 WHERE id = :vehicleId");
        $stmt->bindParam(':vehicleId', $vehicleId, PDO::PARAM_INT);
        $stmt->execute();

        header("Location: all-user-orders.php");
    } 
?>


<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <title>Login</title>

    <!-- SEO Meta Tags -->
    <meta name="description" content="Silicon - Multipurpose Technology Bootstrap Template">
    <meta name="keywords" content="bootstrap, business, creative agency, mobile app showcase, saas, fintech, finance, online courses, software, medical, conference landing, services, e-commerce, shopping cart, multipurpose, shop, ui kit, marketing, seo, landing, blog, portfolio, html5, css3, javascript, gallery, slider, touch, creative">
    <meta name="author" content="Createx Studio">

    <!-- Viewport -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Theme switcher (color modes) -->
    <script type="text/javascript" async="" src="https://www.google-analytics.com/analytics.js"></script><script type="text/javascript" async="" src="https://www.googletagmanager.com/gtag/js?id=G-TXTBFKF5EW&amp;l=dataLayer&amp;cx=c"></script><script async="" src="https://www.googletagmanager.com/gtm.js?id=GTM-WKV3GT5"></script><script src="https://silicon.createx.studio/assets/js/theme-switcher.js"></script>

    <!-- Favicon and Touch Icons -->
    <link rel="apple-touch-icon" sizes="180x180" href="https://silicon.createx.studio/assets/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="https://silicon.createx.studio/assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="https://silicon.createx.studio/assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="https://silicon.createx.studio/assets/favicon/site.webmanifest">
    <link rel="mask-icon" href="https://silicon.createx.studio/assets/favicon/safari-pinned-tab.svg" color="#6366f1">
    <link rel="shortcut icon" href="https://silicon.createx.studio/assets/favicon/favicon.ico">
    <meta name="msapplication-TileColor" content="#080032">
    <meta name="msapplication-config" content="https://silicon.createx.studio/assets/favicon/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">

    <!-- Vendor Styles -->
    <link rel="stylesheet" media="screen" href="https://silicon.createx.studio/assets/vendor/boxicons/css/boxicons.min.css">

    <!-- Main Theme Styles + Bootstrap -->
    <link rel="stylesheet" media="screen" href="https://silicon.createx.studio/assets/css/theme.min.css">

    <!-- Page loading styles -->
    <style>
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
    

    <!-- Page wrapper for sticky footer -->
    <!-- Wraps everything except footer to push footer to the bottom of the page if there is little content -->
   <main class="page-wrapper">
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
                            <li class="nav-item">
                                <a href="vehicle-list.php" class="nav-link">Vehicles</a>
                            </li>
<!--                            <li class="nav-item dropdown">-->
<!--                                <a href="#" class="nav-link dropdown-toggle active" data-bs-toggle="dropdown" aria-current="page">Account</a>-->
<!--                                <ul class="dropdown-menu">-->
<!--                                    <li><a href="account-details.php" class="dropdown-item">Account Details</a></li>-->
<!--                                    <li><a href="favorite-transports.php" class="dropdown-item">Favorite transports</a></li>-->
<!--                                    <li><a href="all-user-orders.php" class="dropdown-item">All my orders</a></li>-->
<!--                                </ul>-->
<!--                            </li>-->
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


      <!-- Page content -->
      <section class="position-relative h-100 pt-5 pb-4">

        <!-- Sign in form -->
        <div class="container d-flex flex-wrap justify-content-center justify-content-xl-start h-100 pt-5">
          <div class="w-100 align-self-end pt-1 pt-md-4 pb-4" style="max-width: 526px;">
            <h1 class="text-center text-xl-start">Order Vehicle</h1>

            <form class="needs-validation mb-2" method="post" novalidate="">
              
              <div class="position-relative mb-4">
                <label for="endPoint" class="form-label fs-base">Choose End Point</label>

                <select class="form-control form-control-lg" id="endPoint" name="endPoint">
                    <?php foreach ($locations as $location): ?>
                        <option value="<?= htmlspecialchars($location['id']) ?>"><?= htmlspecialchars($location['location']) ?></option>
                    <?php endforeach; ?>
                </select>

                <div class="invalid-feedback position-absolute start-0 top-100">Please choose a valid end point!</div>

              </div>

              <input name="but_submit" type="submit" class="btn btn-primary shadow-primary btn-lg w-100" value="Start trip">

            </form>

          </div>
          <div class="w-100 align-self-end">
            <p class="nav d-block fs-xs text-center text-xl-start pb-2 mb-0">
            </p>    
          </div>
        </div>
        
        <!-- Background -->
        <div class="position-absolute top-0 end-0 w-50 h-100 bg-position-center bg-repeat-0 bg-size-cover d-none d-xl-block" style="background-image: url(https://silicon.createx.studio/assets/img/account/signin-bg.jpg);"></div>
      </section>
    </main>

    <!-- Back to top button -->
    <a href="#top" class="btn-scroll-top" data-scroll="">
      <span class="btn-scroll-top-tooltip text-muted fs-sm me-2">Top</span>
      <i class="btn-scroll-top-icon bx bx-chevron-up"></i>
    </a>

    
    <!-- Main Theme Script -->
    <script src="https://silicon.createx.studio/assets/js/theme.min.js"></script>
  
</body>
</html>