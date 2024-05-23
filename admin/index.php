<?php
	$title = "Main Admin Panel";
	$profpic = "../back5.jpg";
	include "../blocks/header.php";
?>

<div class="container">
    <div class="content">
        <div class="col text-center">
            <h1>Admin panel</h1>
            <a href="vehicles/vehicles.php" class="btn btn-primary">Block for working with vehicles</a>
            <a href="admins/admins.php" class="btn btn-primary">Block for working with admins</a>
            <a href="users/users.php" class="btn btn-primary">Block for working with users</a>
            <a href="orders/orders.php" class="btn btn-primary">Block for working with orders</a>
        </div>
    </div>
</div>

<?php
	include "../blocks/footer.php";
?>