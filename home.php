<?php
  session_start();
  //$_SESSION = array();
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
  <head>
    <meta charset="utf-8">
    <title>Home</title>

    <!-- SEO Meta Tags -->
    <meta name="description" content="Silicon - Multipurpose Technology Bootstrap Template">
    <meta name="keywords" content="bootstrap, business, creative agency, mobile app showcase, saas, fintech, finance, online courses, software, medical, conference landing, services, e-commerce, shopping cart, multipurpose, shop, ui kit, marketing, seo, landing, blog, portfolio, html5, css3, javascript, gallery, slider, touch, creative">
    <meta name="author" content="Createx Studio">

    <!-- Viewport -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Theme switcher (color modes) -->
    <script type="text/javascript" async="" src="https://www.google-analytics.com/analytics.js"></script>
    <script type="text/javascript" async="" src="https://www.googletagmanager.com/gtag/js?id=G-TXTBFKF5EW&amp;l=dataLayer&amp;cx=c"></script>
    <script async="" src="https://www.googletagmanager.com/gtm.js?id=GTM-WKV3GT5"></script>
    <script src="https://silicon.createx.studio/assets/js/theme-switcher.js"></script>

    <!-- Favicon and Touch Icons -->
    <!-- <link rel="shortcut icon" href="https://silicon.createx.studio/assets/favicon/favicon.ico"> -->
    <link rel="shortcut icon" href="https://img.freepik.com/premium-vector/bike-sharing-rental-service-line-icon_116137-6023.jpg?">
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
      .hover-image {
            width: 100%;
            transition: transform 0.3s ease;
      }
      .hover-image:hover {
            transform: scale(1.2);
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

    <!-- Page wrapper for sticky footer -->
    <!-- Wraps everything except footer to push footer to the bottom of the page if there is little content -->
    <main class="page-wrapper">

      <!-- Navbar -->
      <!-- Remove "navbar-sticky" class to make navigation bar scrollable with the page -->
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
                    <!-- <li class="nav-item dropdown">
                      <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-current="page">Account</a>
                      <ul class="dropdown-menu">
                        <li><a href="account-details.php" class="dropdown-item">Account Details</a></li>
                        <li><a href="favorite-transports.php" class="dropdown-item">Favorite transports</a></li>
                        <li><a href="all-user-orders.php" class="dropdown-item">All my orders</a></li>
                      </ul>
                    </li> -->
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

      <!-- Hero -->
      <section class="overflow-hidden pt-2 pt-md-4 pt-lg-5">
        <div class="container pt-1 pt-sm-0">
          <div class="row align-items-center">

            <!-- Cursor parallax -->
            <div class="col-md-7 order-md-2 mb-3 mb-sm-2 mb-md-0">
              <div class="parallax" style="max-width: 746px; transform: translate3d(0px, 0px, 0px) rotate(0.0001deg); transform-style: preserve-3d; backface-visibility: hidden; pointer-events: none;">
                <div class="parallax-layer" data-depth="0.1" style="transform: translate3d(2.7px, -6.8px, 0px); transform-style: preserve-3d; backface-visibility: hidden; position: relative; display: block; left: 0px; top: 0px;">
                  <img src="https://silicon.createx.studio/assets/img/landing/startup/hero/phone.png" alt="Phone">
                </div>
                <div class="parallax-layer" data-depth="0.2" style="transform: translate3d(5.4px, -13.7px, 0px); transform-style: preserve-3d; backface-visibility: hidden; position: absolute; display: block; left: 0px; top: 0px;">
                  <img src="https://silicon.createx.studio/assets/img/landing/startup/hero/scooters.png" alt="Scooters">
                </div>
              </div>
            </div>

            <!-- Text + button -->
            <div class="col-md-5 order-md-1">
              <h1 class="display-4 mb-ms-4">We ride. We care. We share.</h1>
              <p class="fs-xl pb-2 mb-4 mb-xl-5" style="max-width: 450px;">Empower citizens to move with ease and style by sharing sustainable vehicles.</p>

              <a href="make-order-start.php" class="btn btn-lg btn-primary w-100 w-sm-auto">
                Start your trip
                <i class="bx bx-right-arrow-alt lead ms-2 me-n1"></i>
              </a>
            </div>
          </div>
        </div>
      </section>

      <!-- Features -->
      <section class="container pt-1 py-sm-2 py-md-4 py-lg-5">
        <div class="row row-cols-1 row-cols-md-3 g-4 py-5 mb-2 mb-sm-3">

          <!-- Item -->
          <div class="col pt-2 pt-md-0">
            <div class="text-center px-xl-4">
              <img src="https://silicon.createx.studio/assets/img/landing/startup/icons/riding-scooter.svg" class="d-inline-block mb-4" width="70" alt="Icon">
              <h3 class="h4 mb-2">Freedom of movement</h3>
              <p class="fs-lg mb-0">Feel the freedom of movement with our alternative transportation. Forget about traffic jams and let yourself move freely around the city.</p>
            </div>
          </div>

          <!-- Item -->
          <div class="col pt-2 pt-md-0">
            <div class="text-center px-xl-4">
              <img src="https://silicon.createx.studio/assets/img/landing/startup/icons/diamond.svg" class="d-inline-block mb-4" width="70" alt="Icon">
              <h3 class="h4 mb-2">Quality &amp; style</h3>
              <p class="fs-lg mb-0">Our alternative transportation combines quality and style. Each vehicle meets the highest standards and has an elegant design that will impress you.</p>
            </div>
          </div>

          <!-- Item -->
          <div class="col pt-2 pt-md-0">
            <div class="text-center px-xl-4">
              <img src="https://silicon.createx.studio/assets/img/landing/startup/icons/planet.svg" class="d-inline-block mb-4" width="70" alt="Icon">
              <h3 class="h4 mb-2">Cities made for living</h3>
              <p class="fs-lg mb-0">Cities are made for living, and our transportation helps you enjoy every moment of it. Integrate into city life and discover new opportunities.</p>
            </div>
          </div>
        </div>
      </section>

      <!-- Hotspots -->
      <section class="position-relative pt-sm-2 pt-md-4 pt-lg-5">
        <div class="bg-gradient-primary position-absolute top-0 start-0 w-100 opacity-15" style="height: calc(100% - 7rem);"></div>
        <div class="container position-relative zindex-2 pt-5">
            <div class="row row-cols-1 row-cols-md-3 pt-2 pt-md-3 pb-5 mb-md-2 mb-lg-4">

                <!-- First column -->
                <div class="col mb-4 text-center">
                    <h2 class="h1 mb-3">Bicycles</h2>
                    <div class="position-relative bg-dark rounded-3 overflow-hidden px-5" style="padding-top: 36.25%; padding-bottom: 20%">
                        <div class="position-absolute top-0 start-0 w-100 h-100" style="background-color: rgba(255,255,255, .04);"></div>
                        <div class="position-relative zindex-2 mx-auto" style="max-width: 1200px;">
                            <a href="vehicle-list.php?type=bike">
                                <img src="img/bike.png" class="d-block w-200 hover-image" alt="Bike">
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Second column -->
                <div class="col mb-4 text-center">
                    <h2 class="h1 mb-3">Scooters</h2>
                    <div class="position-relative bg-dark rounded-3 overflow-hidden px-5" style="padding-top: 20.50%; padding-bottom: 16%">
                        <div class="position-absolute top-0 start-0 w-100 h-100" style="background-color: rgba(255,255,255, .04);"></div>
                        <div class="position-relative zindex-2 mx-auto" style="max-width: 852px;">
                            <a href="vehicle-list.php?type=scooter">
                                <img src="img/scooter.png" class="d-block w-100 hover-image" alt="Scooter">
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Third column -->
                <div class="col mb-4 text-center">
                    <h2 class="h1 mb-3">Hoverboards</h2>
                    <div class="position-relative bg-dark rounded-3 overflow-hidden px-5" style="padding-top: 38.25%; padding-bottom: 10%">
                        <div class="position-absolute top-0 start-0 w-100 h-100" style="background-color: rgba(255,255,255, .04);"></div>
                        <div class="position-relative zindex-2 mx-auto" style="max-width: 852px;">
                            <a href="vehicle-list.php?type=hoverboard">
                                <img src="img/hoverboard.png" class="d-block w-100 hover-image" alt="Hoverboard">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </section>

      <!-- Steps (How it works) -->
      <section class="container pb-md-3 pb-lg-4 pb-xl-0 pt-sm-2 pt-md-3 pt-lg-5 mt-2 mt-md-3">
        <h2 class="display-5 text-center pt-5 pb-3 pb-md-4 pb-lg-5 mb-xl-4">So, how does it work?</h2>

        <!-- Step -->
        <div class="row align-items-center pb-5 mb-2 mb-md-3 mb-lg-4 mb-xl-5">
          <div class="col-md-6 pb-2 pb-md-0 mb-4 mb-md-0">
            <div class="position-relative rounded-3 overflow-hidden">
              <div class="bg-gradient-primary position-absolute top-0 start-0 w-100 h-100"></div>
              <img src="https://silicon.createx.studio/assets/img/landing/startup/steps/01.svg" class="d-block position-relative zindex-2 mx-auto" width="636" alt="Image">
            </div>
          </div>
          <div class="col-md-6 col-lg-5 offset-lg-1">
            <div class="ps-md-4 ps-lg-0">
              <div class="text-primary fs-xl fw-bold pb-1 mb-2">Step 1</div>
              <h3 class="h1 mb-lg-4">Find a scooter nearby</h3>
              <p class="fs-xl mb-0">Use the map in the app to find your closest vehicle.</p>
            </div>
          </div>
        </div>

        <!-- Step -->
        <div class="row align-items-center pb-5 mb-2 mb-md-3 mb-lg-4 mb-xl-5">
          <div class="col-md-6 pb-2 pb-md-0 mb-4 mb-md-0">
            <div class="position-relative rounded-3 overflow-hidden">
              <div class="bg-gradient-primary position-absolute top-0 start-0 w-100 h-100"></div>
              <img src="img/step_02.svg" class="d-block position-relative zindex-2 mx-auto" width="636" alt="Image">
            </div>
          </div>
          <div class="col-md-6 col-lg-5 offset-lg-1">
            <div class="ps-md-4 ps-lg-0">
              <div class="text-primary fs-xl fw-bold pb-1 mb-2">Step 2</div>
              <h3 class="h1 mb-lg-4">Start the ride</h3>
              <p class="fs-xl mb-0">To start a ride, select a vehicle, fill out the form, and tap "Start ride". Press the gas to move and the brakes to stop.</p>
            </div>
          </div>
        </div>

        <!-- Step -->
        <div class="row align-items-center pb-5 mb-2 mb-md-3 mb-lg-4 mb-xl-5">
          <div class="col-md-6 pb-2 pb-md-0 mb-4 mb-md-0">
            <div class="position-relative rounded-3 overflow-hidden">
              <div class="bg-gradient-primary position-absolute top-0 start-0 w-100 h-100"></div>
              <img src="https://silicon.createx.studio/assets/img/landing/startup/steps/03.svg" class="d-block position-relative zindex-2 mx-auto" width="636" alt="Image">
            </div>
          </div>
          <div class="col-md-6 col-lg-5 offset-lg-1">
            <div class="ps-md-4 ps-lg-0">
              <div class="text-primary fs-xl fw-bold pb-1 mb-2">Step 3</div>
              <h3 class="h1 mb-lg-4">Enjoy your ride!</h3>
              <p class="fs-xl mb-0">When you're riding past traffic, be sure to follow all street signs and laws. Please ride safely and be mindful of where you park. Make sure you're wearing a helmet.</p>
            </div>
          </div>
        </div>

        <!-- Step -->
        <div class="row align-items-center pb-5 mb-2 mb-md-3 mb-lg-4 mb-xl-5">
          <div class="col-md-6 pb-2 pb-md-0 mb-4 mb-md-0">
            <div class="position-relative rounded-3 overflow-hidden">
              <div class="bg-gradient-primary position-absolute top-0 start-0 w-100 h-100"></div>
              <img src="https://silicon.createx.studio/assets/img/landing/startup/steps/04.svg" class="d-block position-relative zindex-2 mx-auto" width="636" alt="Image">
            </div>
          </div>
          <div class="col-md-6 col-lg-5 offset-lg-1">
            <div class="ps-md-4 ps-lg-0">
              <div class="text-primary fs-xl fw-bold pb-1 mb-2">Step 4</div>
              <h3 class="h1 mb-lg-4">Park carefully</h3>
              <p class="fs-xl mb-0">After the trip, park your vehicle safely in a designated parking space. Finally, lock it by clicking on “End trip”.</p>
            </div>
          </div>
        </div>
      </section>


      <!-- Mobile App CTA -->
      <section class="bg-secondary overflow-hidden py-2 py-sm-3 py-md-4 py-lg-5">
        <div class="container py-5 pb-lg-4">
            <div class="row">

                <!-- Cursor parallax -->
                <div class="col-md-7 offset-xl-1 order-md-2">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2986.061018735262!2d36.244543884569765!3d50.017167008510796!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4127a1000e0da5b9%3A0x7bc3ddab9336dd55!2z0KbQtdC90YLRgNCw0LvRjNC90LjQuSDQv9Cw0YDQuiDQutGD0LvRjNGC0YPRgNC4INGC0LAg0LLRltC00L_QvtGH0LjQvdC60YM!5e0!3m2!1suk!2sua!4v1716245884559!5m2!1suk!2sua" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    <!-- <iframe src="[your unique google URL] " width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe> -->
                </div>

                <!-- Text + Action buttons -->
                <div class="col-md-5 col-xl-4 order-md-1 text-center text-md-start pt-lg-3">
                    <h2 class="display-5 mb-4">Easy way to find us</h2>
                    <p class="fs-xl pb-2 mb-4 mb-xl-5">Vehicle stations can be found by locating them on the App available for smartphones or other devices.</p>
                    <h3 class="pb-3 mb-lg-4">Coming soon on</h3>
                    <div class="d-flex justify-content-center justify-content-md-start">
                        <a href="#" class="position-relative me-4" aria-label="App Store">
                            <div class="bg-white rounded-3 shadow position-absolute top-0 start-0 w-100 h-100 d-dark-mode-none"></div>
                            <div class="rounded-3 position-absolute top-0 start-0 w-100 h-100 d-none d-dark-mode-block" style="background-color: rgba(255,255,255, .06);"></div>
                            <svg class="position-relative zindex-2 text-dark" width="80" height="80" viewBox="0 0 80 80" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path d="M48.5788 40.5996C48.5424 36.6562 51.8905 34.7377 52.0436 34.6484C50.1475 31.9529 47.2085 31.5847 46.1757 31.5553C43.7073 31.302 41.3129 32.9954 40.0555 32.9954C38.773 32.9954 36.8367 31.5798 34.7498 31.6214C32.0643 31.6617 29.552 33.1777 28.1741 35.5318C25.3305 40.3317 27.4513 47.3853 30.1757 51.2651C31.5385 53.1653 33.131 55.2869 35.2154 55.2122C37.2546 55.1303 38.0163 53.9447 40.4772 53.9447C42.9155 53.9447 43.6308 55.2122 45.7566 55.1645C47.9451 55.1303 49.323 53.2558 50.6381 51.3385C52.213 49.1607 52.8455 47.0158 52.8706 46.9057C52.8191 46.8886 48.6202 45.3261 48.5788 40.5996Z"></path>
                                <path d="M44.5631 29.003C45.6599 27.6657 46.4104 25.8463 46.202 24C44.6146 24.0685 42.6293 25.0706 41.4861 26.3785C40.4747 27.5311 39.5711 29.4202 39.8046 31.1968C41.5878 31.3265 43.4187 30.3195 44.5631 29.003Z"></path>
                            </svg>
                        </a>
                        <a href="#" class="position-relative" aria-label="Google Play">
                            <div class="bg-white rounded-3 shadow position-absolute top-0 start-0 w-100 h-100 d-dark-mode-none"></div>
                            <div class="rounded-3 position-absolute top-0 start-0 w-100 h-100 d-none d-dark-mode-block" style="background-color: rgba(255,255,255, .06);"></div>
                            <svg class="position-relative zindex-2" xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="none"><path d="M26.464 24.486c-.368.376-.581.962-.581 1.721v27.058c0 .759.213 1.344.581 1.721l.091.083 15.53-15.157v-.358l-15.53-15.157-.091.089z" fill="url(#A)"></path><path d="M47.255 44.966l-5.171-5.055v-.358l5.177-5.055.116.066 6.131 3.406c1.75.967 1.75 2.557 0 3.53l-6.131 3.4-.122.066z" fill="url(#B)"></path><path d="M47.377 44.9l-5.293-5.168-15.621 15.253c.581.596 1.529.668 2.607.072L47.377 44.9z" fill="url(#C)"></path><path d="M47.377 34.565L29.07 24.408c-1.078-.59-2.026-.518-2.607.078l15.621 15.247 5.293-5.168z" fill="url(#D)"></path><defs><linearGradient id="A" x1="40.706" y1="53.547" x2="20.178" y2="32.521" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#00a0ff"></stop><stop offset=".007" stop-color="#00a1ff"></stop><stop offset=".26" stop-color="#00beff"></stop><stop offset=".512" stop-color="#00d2ff"></stop><stop offset=".76" stop-color="#00dfff"></stop><stop offset="1" stop-color="#00e3ff"></stop></linearGradient><linearGradient id="B" x1="55.787" y1="39.731" x2="25.464" y2="39.731" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#ffe000"></stop><stop offset=".409" stop-color="#ffbd00"></stop><stop offset=".775" stop-color="orange"></stop><stop offset="1" stop-color="#ff9c00"></stop></linearGradient><linearGradient id="C" x1="44.499" y1="36.923" x2="16.662" y2="8.411" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#ff3a44"></stop><stop offset="1" stop-color="#c31162"></stop></linearGradient><linearGradient id="D" x1="22.531" y1="63.987" x2="34.962" y2="51.256" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#32a071"></stop><stop offset=".069" stop-color="#2da771"></stop><stop offset=".476" stop-color="#15cf74"></stop><stop offset=".801" stop-color="#06e775"></stop><stop offset="1" stop-color="#00f076"></stop></linearGradient></defs></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
      </section>


      <!-- Backer benefits -->
      <section class="container py-2 py-sm-3 py-md-4 py-lg-5">
        <div class="row py-5 my-md-2 my-lg-3">
          <div class="col-lg-5 col-xl-4 mb-5 mb-lg-0">
            <div class="text-center text-lg-start pe-lg-5 pe-xl-0">
              <h2 class="h1 pb-3 pb-lg-5">We need your <span class="text-primary">support!</span> Place your order now and enjoy exclusive <span class="text-primary">benefits</span></h2>
              <a href="make-order-start.php" class="btn btn-lg btn-primary w-100 w-sm-auto">
                Start your trip
                <i class="bx bx-right-arrow-alt lead ms-2 me-n1"></i>
              </a>
            </div>
          </div>
          <div class="col-lg-7 col-xl-6 offset-xl-2">
            <div class="row row-cols-1 row-cols-sm-2 gy-5">
              <div class="col pt-md-2">
                <div class="text-center text-sm-start pe-sm-3 pe-xl-4">
                  <img src="https://silicon.createx.studio/assets/img/landing/startup/icons/mobile.svg" class="d-inline-block mb-4" width="60" alt="Icon">
                  <h3 class="h4 mb-2">Trial app</h3>
                  <p class="fs-lg mb-0">Experience our innovative transport solutions firsthand. Download our trial app today!</p>
                </div>
              </div>
              <div class="col pt-md-2">
                <div class="text-center text-sm-start pe-sm-3 pe-xl-4">
                  <img src="https://silicon.createx.studio/assets/img/landing/startup/icons/scooter.svg" class="d-inline-block mb-4" width="60" alt="Icon">
                  <h3 class="h4 mb-2">High-end scooters</h3>
                  <p class="fs-lg mb-0">Ride in style with our premium vehicles, designed for comfort and efficiency.</p>
                </div>
              </div>
              <div class="col pt-md-2">
                <div class="text-center text-sm-start pe-sm-3 pe-xl-4">
                  <img src="https://silicon.createx.studio/assets/img/landing/startup/icons/hand.svg" class="d-inline-block mb-4" width="60" alt="Icon">
                  <h3 class="h4 mb-2">Lowest price for riding</h3>
                  <p class="fs-lg mb-0">Enjoy competitive rates for all your rides. Affordable and convenient for everyone.</p>
                </div>
              </div>
              <div class="col pt-md-2">
                <div class="text-center text-sm-start pe-sm-3 pe-xl-4">
                  <img src="https://silicon.createx.studio/assets/img/landing/startup/icons/smiley.svg" class="d-inline-block mb-4" width="60" alt="Icon">
                  <h3 class="h4 mb-2">Happiness guarantee</h3>
                  <p class="fs-lg mb-0">We prioritize your satisfaction. Our services are designed to ensure a delightful experience every time.</p>
                </div>
              </div>
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


    <!-- Back to top button -->
    <a href="#top" class="btn-scroll-top" data-scroll>
      <span class="btn-scroll-top-tooltip text-muted fs-sm me-2">Top</span>
      <i class="btn-scroll-top-icon bx bx-chevron-up"></i>
    </a>

    <!-- Vendor Scripts -->
    <script src="https://silicon.createx.studio/assets/vendor/parallax-js/dist/parallax.min.js"></script>

    <!-- Main Theme Script -->
    <script src="https://silicon.createx.studio/assets/js/theme.min.js"></script>
  </body>
</html>
