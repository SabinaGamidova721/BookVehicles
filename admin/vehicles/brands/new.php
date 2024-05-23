<?php
	include "../../../blocks/connection.php";
	$title = "New brand";
	$profpic = "../../../back5.jpg";
	include "../../../blocks/header.php";
?>

<div class="container mb-5">
<div class="container mt-5">
<div class="container mt-5">
	<div class="container">
	<div class="content">
	<h1>Create new brand</h1>

	<div class="col text-center">
	
		<form method="post">
		<div class="form-floating">
		    <input type="text" name="title" class="form-control" id="title">
		    <label for="title">Title</label>
		</div>
		<input type="submit" value="Save" class="btn btn-warning mt-3" name="but_add">
		</form>

	</div>
<br>


<?php
	if (isset($_POST["but_add"]) && isset($_POST["title"])) {
	    $title = $_POST["title"];
		
		try {
		  $sql = "INSERT INTO brands (title) VALUES ('$title')";
		  $affectedRowsNumber = $conn->exec($sql);
		  if($affectedRowsNumber > 0 ){
		     echo "<br><h5 align='center'>" . "Data successfully added" . "</h5><br>";
		  }
		}
		catch (PDOException $e) {
		  echo "Database error: " . $e->getMessage();
		  $_POST = array();
		  header("Location: new.php");
		}
		 
	}
?>
	<div class="col text-center">
		<a href="brands.php" class="btn btn-primary">Return to brands</a>
		<a href="../vehicles.php" class="btn btn-primary">Return to vehicles</a>
	</div>

</div>
</div>
</div>
</div>
</div>

<?php
	require "../../../blocks/footer.php";
?>
<br><br>