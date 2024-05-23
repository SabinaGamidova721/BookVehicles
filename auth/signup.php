<?php
  ob_start();
  session_start(); 

  include "../blocks/connection.php";

  if (isset($_POST["but_create"]) && isset($_POST["firstname"]) && isset($_POST["lastname"]) && isset($_POST["phone"]) && isset($_POST["passport_number"]) && isset($_POST["gender"]) && isset($_POST["email"]) && isset($_POST["password"])) {

      $firstname = $_POST["firstname"];
      $lastname = $_POST["lastname"];
      $phone = $_POST["phone"];
      $passport_number = $_POST["passport_number"];
      $gender = $_POST["gender"];
      $email = $_POST["email"];
      $password = $_POST["password"];
      $is_admin = 0;
      $blacklist = 0;
      $is_deleted = 0;

      switch ($gender) {
          case "Man":
              $gender = 1;
              break;
          case "Woman":
              $gender = 2;
              break;
          case "Other":
              $gender = 3;
              break;
          default:
              $gender = 0;
              break;
      }

      $password = password_hash($password, PASSWORD_DEFAULT);

      try {
          $sql_check_existence = "SELECT COUNT(*) FROM userprofiles WHERE (email = :email OR passport_number = :passport_number) AND is_deleted = false";
          // $sql_check_existence = "SELECT COUNT(*) FROM userprofiles WHERE email = :email OR passport_number = :passport_number;";
          $stmt_check = $conn->prepare($sql_check_existence);
          $stmt_check->bindParam(':email', $email);
          $stmt_check->bindParam(':passport_number', $passport_number);
          $stmt_check->execute();
          $exists = $stmt_check->fetchColumn();

          if ($exists) {
              $error_message = "Email or passport number already exists, please enter another one";
          } else {
              $sql = "INSERT INTO userprofiles (firstname, lastname, phone, passport_number, gender, email, password, is_admin, blacklist, is_deleted) VALUES (:firstname, :lastname, :phone, :passport_number, :gender, :email, :password, :is_admin, :blacklist, :is_deleted)";
              $stmt = $conn->prepare($sql);
              $stmt->bindParam(':firstname', $firstname);
              $stmt->bindParam(':lastname', $lastname);
              $stmt->bindParam(':phone', $phone);
              $stmt->bindParam(':passport_number', $passport_number);
              $stmt->bindParam(':gender', $gender, PDO::PARAM_INT);
              $stmt->bindParam(':email', $email);
              $stmt->bindParam(':password', $password);
              $stmt->bindParam(':is_admin', $is_admin, PDO::PARAM_INT);
              $stmt->bindParam(':blacklist', $blacklist, PDO::PARAM_INT);
              $stmt->bindParam(':is_deleted', $is_deleted, PDO::PARAM_INT);

              $stmt->execute();

              $user_id = $conn->lastInsertId();

              $_SESSION['user_id'] = $user_id;
              $_SESSION['firstname'] = $firstname;
              $_SESSION['lastname'] = $lastname;
              $_SESSION['phone'] = $phone;
              $_SESSION['passport_number'] = $passport_number;
              $_SESSION['email'] = $email;
              $_SESSION['gender'] = $gender;

              header("Location: ../home.php");
              exit();
          }
      } catch (PDOException $e) {
          echo "Database error: " . $e->getMessage();
          $_POST = array();
      }
  }
?>


<html lang="en" data-bs-theme="light"><head>
    <meta charset="utf-8">
    <title>Sign Up</title>

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
      .larger-text {
          font-size: 1em;
      }

      .custom-margin-left {
          margin-left: 100px; 
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
    


    <!-- Page wrapper for sticky footer -->
    <!-- Wraps everything except footer to push footer to the bottom of the page if there is little content -->
  <main class="page-wrapper">
        <!-- Navbar -->
        <!-- Remove "fixed-top" class to make navigation bar scrollable with the page -->
       <!--  <header class="header navbar navbar-expand-lg bg-light border-bottom border-light shadow-sm fixed-top">
            <div class="container px-3">
                <a href="#" class="navbar-brand pe-3">
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
            </div>
        </header>
 -->

      <!-- Page content -->
      <section class="position-relative h-100 pt-5 pb-4">

        <!-- Sign up form -->
        <div class="container d-flex flex-wrap justify-content-center justify-content-xl-start h-100 pt-5">
          <div class="w-100 align-self-end pt-1 pt-md-4 pb-4" style="max-width: 526px;">
            <h1 class="text-center text-xl-start">Create Account</h1>
            <p class="text-center text-xl-start pb-3 mb-3">Already have an account? <a href="login.php">Sign in here.</a></p>

            <?php if (!empty($error_message)): ?>
                <div class="alert alert-danger text-center" role="alert">
                    <?php echo htmlspecialchars($error_message); ?>
                </div>
            <?php endif; ?>
            
            <form method="post" class="needs-validation" novalidate="">
              <div class="row">
                
                <div class="col-sm-6">
                  <div class="position-relative mb-4">
                    <label for="name" class="form-label fs-base">First name</label>
                    <input type="text" name="firstname" id="name" class="form-control form-control-lg" required="">
                    <div class="invalid-feedback position-absolute start-0 top-100">Please enter your first name!</div>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="position-relative mb-4">
                    <label for="name" class="form-label fs-base">Last name</label>
                    <input type="text" name="lastname" id="name" class="form-control form-control-lg" required="">
                    <div class="invalid-feedback position-absolute start-0 top-100">Please enter your last name!</div>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="position-relative mb-4">
                    <label for="phone" class="form-label fs-base">Phone</label>
                    <input type="text" name="phone" id="phone" class="form-control form-control-lg" required="">
                    <div class="invalid-feedback position-absolute start-0 top-100">Please enter your phone!</div>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="position-relative mb-4">
                    <label for="passport_number" class="form-label fs-base">Passport number</label>
                    <input type="text" name="passport_number" id="passport_number" class="form-control form-control-lg" required="">
                    <div class="invalid-feedback position-absolute start-0 top-100">Please enter your passport number!</div>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="position-relative mb-4">
                        <label class="form-label d-block" style="font-size: 1em;">Gender</label>
                        <div class="d-flex align-items-center">
                            <div class="form-check me-3 custom-margin-left">
                                <input class="form-check-input" type="radio" name="gender" id="male" value="Man" checked>
                                <label class="form-check-label larger-text" for="male">Man</label>
                            </div>
                            <div class="form-check me-3 ms-5">
                                <input class="form-check-input" type="radio" name="gender" id="female" value="Woman">
                                <label class="form-check-label larger-text" for="female">Woman</label>
                            </div>
                            <div class="form-check ms-5">
                                <input class="form-check-input" type="radio" name="gender" id="other" value="Other">
                                <label class="form-check-label larger-text" for="other">Other</label>
                            </div>
                        </div>
                    </div>
                  </div>

                <div class="col-12 mb-4">
                    <label for="email" class="form-label fs-base">Email</label>
                    <input type="email" name="email" id="email" class="form-control form-control-lg" required="">
                    <div class="invalid-feedback position-absolute start-0 top-100">Please enter a valid email address!</div>
                </div>

                <div class="col-12 mb-4">
                  <label for="password" class="form-label fs-base">Password</label>
                  <div class="password-toggle">
                    <input type="password" name="password" id="password" class="form-control form-control-lg" required="">
                    <label class="password-toggle-btn" aria-label="Show/hide password">
                      <input class="password-toggle-check" type="checkbox">
                      <span class="password-toggle-indicator"></span>
                    </label>
                    <div class="invalid-feedback position-absolute start-0 top-100">Please enter a password!</div>
                  </div>
                </div>

              </div>
              <div class="mb-4">
                <div class="form-check">
                  <input type="checkbox" id="terms" class="form-check-input">
                  <label for="terms" class="form-check-label fs-base">I agree to <a href="#">Terms &amp; Conditions</a></label>
                </div>
              </div>

              <input type="submit" value="Sign up" class="btn btn-primary shadow-primary btn-lg w-100" name="but_create">
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
  
</body></html>