<?php
session_start();
include "blocks/connection.php";
//echo $_SESSION["user_id"];

$id = isset($_GET['id']) ? $_GET['id'] : 0;

$query = "SELECT vehicles.*, 
               brands.title AS brand_title, 
               manufacturers.title AS manufacturer_title, 
               types.title AS type_title, 
               points.location AS point_location 
        FROM vehicles 
        JOIN brands ON vehicles.brand_id = brands.id 
        JOIN manufacturers ON vehicles.manufacturer_id = manufacturers.id 
        JOIN types ON vehicles.type_id = types.id 
        JOIN points ON vehicles.current_point = points.id 
        WHERE vehicles.id = :id";

$stmt = $conn->prepare($query);

$stmt->execute(['id' => $id]);
$vehicle = $stmt->fetch();

if (!$vehicle) {
    echo "Vehicle not found";
    exit;
}

// Check if the vehicle is already in the user's favorites
$fav_stmt = $conn->prepare('SELECT * FROM favourites WHERE userprofile_id = :user_id AND vehicle_id = :vehicle_id');
$fav_stmt->execute(['user_id' => $_SESSION["user_id"], 'vehicle_id' => $id]);
$is_favorite = $fav_stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$is_favorite) {
    // Add to favorites
    $insert_stmt = $conn->prepare('INSERT INTO favourites (userprofile_id, vehicle_id) VALUES (:user_id, :vehicle_id)');
    $insert_stmt->execute(['user_id' => $_SESSION["user_id"], 'vehicle_id' => $id]);

    // Refresh the page to reflect the change
    header('Location: vehicle-info.php?id=' . $id);
    exit;
}

// Fetch comments related to the vehicle
$comments_stmt = $conn->prepare('
    SELECT comments.content, comments.rating, userprofiles.email 
    FROM comments 
    INNER JOIN orders ON comments.order_id = orders.id 
    INNER JOIN userprofiles ON comments.userprofile_id = userprofiles.id 
    WHERE orders.vehicle_id = :vehicle_id
');

$comments_stmt->execute(['vehicle_id' => $id]);
$comments = $comments_stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Vehicle Details</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
            .card-img-top {
                width: 100%;
                height: 200px;
                object-fit: contain;
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
            .vehicle-card img {
                max-width: 100%;
                max-height: 300px;
                width: auto;
                height: auto;
                margin: auto;
                display: block;
                padding: 10px;
            }
            .stars {
                color: gold;
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

    <body>
    <!-- Google Tag Manager (noscript)-->
    <noscript>
        <iframe src="//www.googletagmanager.com/ns.html?id=GTM-WKV3GT5" height="0" width="0" style="display: none; visibility: hidden;" title="Google Tag Manager"></iframe>
    </noscript>
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
<!--                            <li class="nav-item dropdown">-->
<!--                                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-current="page">Account</a>-->
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

<div class="container overflow-hidden pt-2 pt-md-4 pt-lg-1 mb-4">
    <div class="row justify-content-center">
        <div class="container mt-5">
            <h1 class="mt-5"><?php echo htmlspecialchars($vehicle['id']); ?>: <?= htmlspecialchars($vehicle['brand_title']) ?> Details</h1>
            <div class="card mt-3 vehicle-card">
                <img src="img/<?= htmlspecialchars($vehicle['type_title']) ?>.png" class="card-img-top" alt="<?= htmlspecialchars($vehicle['type_title']) ?>">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($vehicle['brand_title']) ?></h5>
                    <p class="card-text">Manufacture: <?= htmlspecialchars($vehicle['manufacturer_title']) ?></p>
                    <p class="card-text">Year: <?= htmlspecialchars($vehicle['manufacturer_year']) ?></p>
                    <p class="card-text">Minute Price: $<?= htmlspecialchars($vehicle['minute_price']) ?></p>
                    <p class="card-text">Available: <?= ($vehicle["is_available"] ? 'Yes' : 'No') ?></p>
                    <?php if ($vehicle["is_available"]): ?>
                        <p class="card-text">Current location: <?= htmlspecialchars($vehicle['point_location']) ?></p>
                    <?php endif; ?>
                    <?php if (!$is_favorite): ?>
                        <form method="post">
                            <button type="submit" class="btn btn-primary">Add to Favorite</button>
                        </form>
                    <?php else: ?>
                        <button class="btn btn-secondary" disabled>Already in Favorites</button>
                    <?php endif; ?>
                </div>
            </div>
            <a href="vehicle-list.php" class="btn btn-primary mt-3">Back to List</a>

            <h2 class="mt-5 text-center">Comments</h2>
            <div class="comments-section">
                <?php if (count($comments) > 0): ?>
                    <?php foreach ($comments as $comment): ?>
                        <div class="card mt-3">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($comment['email']) ?></h5>
                                <p class="card-text text-center"><?= htmlspecialchars($comment['content']) ?></p>
                                <div class="stars">
                                    <?php for ($i = 0; $i < $comment['rating']; $i++): ?>
                                        <span>&#9733;</span> <!-- Star symbol -->
                                    <?php endfor; ?>
                                    <?php for ($i = $comment['rating']; $i < 5; $i++): ?>
                                        <span>&#9734;</span> <!-- Empty star symbol -->
                                    <?php endfor; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No comments available for this vehicle.</p>
                <?php endif; ?>
            </div>
        </div>
        </div>
        </div>
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
