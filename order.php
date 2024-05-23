<?php
    include "blocks/connection.php";
    $orderId = $_GET['order_id'];
    session_start();

    function get_comment_for_order($order_id) {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM comments WHERE order_id = :order_id");
        $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        $stmt->execute();
        $comment = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $comment;
    }

    try {
        $stmt = $conn->prepare("
            SELECT orders.id AS id, 
                   orders.status_id,
                   orders.total_price AS total_price,
                   orders.startdate AS startdate,
                   orders.enddate AS enddate,
                   brands.title AS brand, 
                   manufacturers.title AS manufacturer, 
                   types.title AS type,
                   vehicles.id as vehicle_id,
                   vehicles.manufacturer_year AS year, 
                   vehicles.minute_price AS min_price, 
                   userprofiles.firstname AS firstname, 
                   userprofiles.lastname AS lastname, 
                   userprofiles.email AS email,
                   s.location AS startpoint,
                   e.location AS endpoint
            FROM orders 
            JOIN vehicles ON orders.vehicle_id = vehicles.id
            JOIN brands ON vehicles.brand_id = brands.id 
            JOIN TYPES ON vehicles.type_id = types.id 
            JOIN manufacturers ON vehicles.manufacturer_id = manufacturers.id 
            JOIN userprofiles ON orders.userprofile_id = userprofiles.id
            JOIN points s ON orders.startpoint = s.id
            JOIN points e ON orders.endpoint = e.id
            WHERE orders.id = :orderId
        ");

        $stmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);
        $stmt->execute();
        $order = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt = $conn->prepare("SELECT title FROM statuses WHERE id = :statusId");
        $stmt->bindParam(':statusId', $order['status_id'], PDO::PARAM_INT);
        $stmt->execute();
        $status = $stmt->fetch(PDO::FETCH_ASSOC)['title'];

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['but_submit'])) {
            $comment = $_POST['comment'];

            $stmt = $conn->prepare("INSERT INTO comments (order_id, userprofile_id, content, created_at) VALUES (:orderId, :userId, :comment, NOW())");
            $stmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);
            $stmt->bindParam(':userId', $_SESSION["user_id"], PDO::PARAM_INT);
            $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
            $stmt->execute();
            $successMessage = "Comment added successfully!";
        }

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
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
        <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
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

<div class="container mt-5 mb-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="mt-5 mb-4 text-center">Order Details</h1>
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 ms-5">
                            <p class="card-text"><b>User:</b> <?= htmlspecialchars($order['firstname'] . ' ' . $order['lastname']) ?> (<?= htmlspecialchars($order['email']) ?>)</p>
                            <p class="card-text"><b>Vehicle Brand:</b> <?= htmlspecialchars($order['vehicle_id']) ?>: <?= htmlspecialchars($order['brand']) ?></p>
                            <p class="card-text"><b>Vehicle Type:</b> <?= htmlspecialchars($order['type']) ?></p>
                            <p class="card-text"><b>Manufacture Year:</b> <?= htmlspecialchars($order['year']) ?></p>
                        </div>
                        <div class="col-md-3 ms-5">
                            <p class="card-text"><b>Vehicle Manufacturer:</b> <?= htmlspecialchars($order['manufacturer']) ?></p>
                            <p class="card-text"><b>Minute Price:</b> $<?= htmlspecialchars($order['min_price']) ?></p>
                            <p class="card-text"><b>Start Point:</b> <?= htmlspecialchars($order['startpoint']) ?></p>
                            <p class="card-text"><b>End Point:</b> <?= htmlspecialchars($order['endpoint']) ?></p>
                        </div>
                        <div class="col-md-3 ms-5">
                            <p class="card-text"><b>Start Date:</b> <?= htmlspecialchars($order['startdate']) ?></p>
                            <p class="card-text"><b>End Date:</b> <?= htmlspecialchars($order['enddate']) ?></p>
                            <p class="card-text"><b>Total Price:</b> $<?= htmlspecialchars($order['total_price']) ?></p>
                            <p class="card-text"><b>Status:</b> <?= htmlspecialchars($status) ?></p>
                        </div>
                    </div>
                </div>
            </div>

<style>
    div.stars {
      width: 270px;
      display: inline-block;
    }

    .mt-200{
        margin-top:10px;  
    }

    input.star { display: none; }

    label.star {
      float: right;
      padding: 10px;
      font-size: 26px;
      color: #4A148C;
      transition: all .2s;
    }

    input.star:checked ~ label.star:before {
      content: '\f005';
      color: #FD4;
      transition: all .25s;
    }

    input.star-5:checked ~ label.star:before {
      color: #FE7;
      text-shadow: 0 0 20px #952;
    }

    input.star-1:checked ~ label.star:before { color: #F62; }

    label.star:hover { transform: rotate(-15deg) scale(1.3); }

    label.star:before {
      content: '\f006';
      font-family: FontAwesome;
    }
</style>

<!-- ////////////////////////////////////// -->

        <?php if (isset($successMessage)) { echo "<p style='color: green;'>$successMessage</p>"; } ?>

         <?php
            if (isset($_POST['but_submit'])) {
                $newComment = $_POST['comment'];
            }

            if (isset($_POST['delete_comment'])) {
                $commentId = $_POST['comment_id'];
                $stmt = $conn->prepare("DELETE FROM comments WHERE id = :commentId");
                $stmt->bindParam(':commentId', $commentId, PDO::PARAM_INT);
                $stmt->execute();
            }

            if (isset($_POST['edit_comment'])) {
                $commentId = $_POST['comment_id'];
                $stmt = $conn->prepare("SELECT * FROM comments WHERE id = :commentId");
                $stmt->bindParam(':commentId', $commentId, PDO::PARAM_INT);
                $stmt->execute();
                $commentData = $stmt->fetch(PDO::FETCH_ASSOC);
            }

            if (isset($_POST['submit_edit'])) {
                $editedComment = $_POST['edited_comment'];
                $commentId = $_POST['comment_id'];
                $stmt = $conn->prepare("UPDATE comments SET content = :content WHERE id = :commentId");
                $stmt->bindParam(':content', $editedComment, PDO::PARAM_STR);
                $stmt->bindParam(':commentId', $commentId, PDO::PARAM_INT);
                $stmt->execute();
            }

            $stmt = $conn->prepare("SELECT comments.*, userprofiles.firstname AS firstname, userprofiles.lastname AS lastname, userprofiles.email AS email FROM comments JOIN userprofiles ON userprofiles.id = comments.userprofile_id WHERE order_id = :orderId");
            $stmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);
            $stmt->execute();
            $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $commentExist = false;
            foreach ($comments as $comment) {
                if ($comment['userprofile_id'] == $_SESSION["user_id"]) {
                    $commentExist = true;
                    break;
                }
            }
        ?>

        <?php if (!$commentExist): ?>
            <form method="post" action="">
                <div class="form-group">
                    <label for="comment">Add a Comment:</label>
                    <textarea class="form-control" id="comment" name="comment" rows="4" required></textarea>
                </div>
                <button type="submit" name="but_submit" class="btn btn-primary">Submit</button>
            </form>
        <?php endif; ?>

        <?php foreach ($comments as $comment): ?>
            <div class="card mt-3">
                <div class="card-body">
                    <p class="card-text"><b>Created At:</b> <?= htmlspecialchars($comment['created_at']) ?></p>
                    <?php if (isset($commentData) && $commentData['id'] == $comment['id']): ?>
                        <form method="post" action="">
                            <input type="hidden" name="comment_id" value="<?= htmlspecialchars($comment['id']) ?>">
                            <textarea class="form-control mb-2" name="edited_comment" rows="3" required><?= htmlspecialchars($commentData['content']) ?></textarea>
                            <button type="submit" name="submit_edit" class="btn btn-primary mr-2">Save Changes</button>
                            <!-- <a href="" class="btn btn-secondary" onclick="location.reload();">Cancel</a> -->
                            <a href="javascript:void(0);" class="btn btn-secondary" onclick="window.location.href = window.location.href;">Cancel</a>
                        </form>
                    <?php else: ?>
                        <p class="card-text"><?= htmlspecialchars($comment['content']) ?></p>
                        <?php if ($comment['userprofile_id'] == $_SESSION["user_id"]): ?>
                            <form method="post" action="">
                                <input type="hidden" name="comment_id" value="<?= htmlspecialchars($comment['id']) ?>">
                                <button type="submit" name="edit_comment" class="btn btn-primary mr-2">Edit</button>
                                <button type="submit" name="delete_comment" class="btn btn-danger">Delete</button>
                            </form>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>


<!-- <div class="container mt-200">
    <h2 class="text-center mb-4 mt-4">Rate your trip</h2>
    <div class="stars d-flex justify-content-center">
        <form action="">
            <?php 
                $rating = $comment['rating'];
                for ($i = 5; $i >= 1; $i--) {
                    $checked = ($i == $rating) ? 'checked' : '';
                    echo '<input class="star star-' . $i . '" id="star-' . $i . '" type="radio" name="star" value="' . $i . '" data-comment-id="' . htmlspecialchars($comment['id']) . '" ' . $checked . '/>';
                    echo '<label class="star star-' . $i . '" for="star-' . $i . '"></label>';
                }
            ?>
        </form>
    </div>
</div>
 -->

<style>
    .stars {
        display: flex;
        justify-content: center;
    }
</style>

<!-- <div class="container mt-200">
    <h2 class="text-center mb-4 mt-4">Rate your trip</h2>
    <div class="text-center">
        <form action="" class="d-inline-block">
            <?php 
                $rating = $comment['rating'];
                for ($i = 5; $i >= 1; $i--) {
                    $checked = ($i == $rating) ? 'checked' : '';
                    echo '<input class="star star-' . $i . '" id="star-' . $i . '" type="radio" name="star" value="' . $i . '" data-comment-id="' . htmlspecialchars($comment['id']) . '" ' . $checked . '/>';
                    echo '<label class="star star-' . $i . '" for="star-' . $i . '"></label>';
                }
            ?>
        </form>
    </div>
</div> -->


<!-- <div class="container mt-200">
  <?php if(isset($comment['rating'])): ?>
    <h2 class="text-center mb-4 mt-4">Rate your trip</h2>
    <div class="text-center">
            <form action="" class="d-inline-block">
                <?php 
                    $rating = $comment['rating'];
                    for ($i = 5; $i >= 1; $i--) {
                        $checked = ($i == $rating) ? 'checked' : '';
                        echo '<input class="star star-' . $i . '" id="star-' . $i . '" type="radio" name="star" value="' . $i . '" data-comment-id="' . htmlspecialchars($comment['id']) . '" ' . $checked . '/>';
                        echo '<label class="star star-' . $i . '" for="star-' . $i . '"></label>';
                    }
                ?>
            </form>
        <?php endif; ?>
    </div>
</div> -->


<?php
if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];
    $comment = get_comment_for_order($order_id);
    if ($comment !== false) {
?>
<div class="container mt-200">
    <h2 class="text-center mb-4 mt-4">Rate your trip</h2>
    <div class="text-center">
        <form action="" class="d-inline-block">
            <?php 
                $rating = $comment['rating'];
                for ($i = 5; $i >= 1; $i--) {
                    $checked = ($i == $rating) ? 'checked' : '';
                    echo '<input class="star star-' . $i . '" id="star-' . $i . '" type="radio" name="star" value="' . $i . '" data-comment-id="' . htmlspecialchars($comment['id']) . '" ' . $checked . '/>';
                    echo '<label class="star star-' . $i . '" for="star-' . $i . '"></label>';
                }
            ?>
        </form>
    </div>
</div>
<?php 
    }
} 
?>

<!-- <div class="container d-flex justify-content-center mt-200">
    <div class="row">
        <div class="col-md-12">
            <div class="stars">
                  <form action="">
                    <input class="star star-5" id="star-5" type="radio" name="star" value="5" data-comment-id="<?= htmlspecialchars($comment['id']) ?>"/>
                    <label class="star star-5" for="star-5"></label>

                    <input class="star star-4" id="star-4" type="radio" name="star" value="4" data-comment-id="<?= htmlspecialchars($comment['id']) ?>"/>
                    <label class="star star-4" for="star-4"></label>

                    <input class="star star-3" id="star-3" type="radio" name="star" value="3" data-comment-id="<?= htmlspecialchars($comment['id']) ?>"/>
                    <label class="star star-3" for="star-3"></label>

                    <input class="star star-2" id="star-2" type="radio" name="star" value="2" data-comment-id="<?= htmlspecialchars($comment['id']) ?>"/>
                    <label class="star star-2" for="star-2"></label>

                    <input class="star star-1" id="star-1" type="radio" name="star" value="1" data-comment-id="<?= htmlspecialchars($comment['id']) ?>"/>
                    <label class="star star-1" for="star-1"></label>
                  </form>
            </div>
        </div>
    </div>
</div> -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script> 
$(document).ready(function() {
    $('.star').on('change', function() {
        var rating = $(this).val(); 
        var commentId = $(this).attr('data-comment-id'); 
        console.log('New rating:', rating); 
        console.log('Comment id:', commentId); 
        $.ajax({
            type: 'POST',
            url: 'update_rating.php', 
            data: { rating: rating, commentId: commentId },
            success: function(response) {
                console.log('Rating updated successfully');
            },
            error: function(xhr, status, error) {
                console.error('Error updating rating:', error);
            }
        });
    });
});
</script>


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
