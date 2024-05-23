<?php
    $title = "Delete vehicle";
    $profpic = "../../back5.jpg";
    include "../../blocks/header.php";
?>

<div class="container">
    <div class="content">
        <div class="col text-center">
            <form action="delete_conf.php" method="post">
                <?php if(isset($_POST['id'])): ?>
                <input type="hidden" name="id" value="<?php echo $_POST['id']; ?>">
                <?php endif; ?>
                <h3>Are you sure you want to remove this vehicle?<br></h3>
                <button type="submit" name="delete" class="btn btn-danger">Yes, delete</button>
                <a href="vehicles.php" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>

<?php
    include "../../blocks/footer.php";
?>