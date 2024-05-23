<?php
	include "../../blocks/connection.php";
	$title = "New Admin";
	$profpic = "../../back5.jpg";
	include "../../blocks/header.php";
?>

<div class="container mb-5">
<div class="container mt-5">
<div class="container mt-5">
	<div class="container">
	<div class="content">
	<h1>Create new admin</h1>

	<div class="col text-center">
	
		<form method="post">
			   <div class="form-floating mt-3">
			       <input type="text" name="firstname" class="form-control" id="firstname">
			       <label for="firstname">First name</label>
			   </div>
			   <div class="form-floating mt-3">
			       <input type="text" name="lastname" class="form-control" id="lastname">
			       <label for="lastname">Last name</label>
			   </div>
			   <div class="form-floating mt-3">
			       <input type="text" name="phone" class="form-control" id="phone">
			       <label for="phone">Phone</label>
			   </div>

            <label class="form-label d-block">Gender</label>
            <div class="d-flex align-items-center">
                <div class="form-check me-3">
                    <input class="form-check-input" type="radio" name="gender" id="male" value="Man" checked>
                    <label class="form-check-label" for="male">Man</label>
                </div>
                <div class="form-check me-3">
                    <input class="form-check-input" type="radio" name="gender" id="female" value="Woman">
                    <label class="form-check-label" for="female">Woman</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="gender" id="other" value="Other">
                    <label class="form-check-label" for="other">Other</label>
                </div>
            </div>

           <div class="form-floating mt-3">
               <input type="email" name="email" class="form-control" id="email">
               <label for="email">Email</label>
           </div>
           <div class="form-floating mt-3">
               <input type="password" name="password" class="form-control" id="password">
               <label for="password">Password</label>
           </div>

		<input type="submit" value="Create" class="btn btn-warning mt-3" name="but_add">
		</form>

		<div class="col text-center">
			<a href="admins.php" class="btn btn-primary mt-3">Return to admins</a>
			<a href="../index.php" class="btn btn-primary mt-3">Return to main</a>
		</div>

	</div>
<br>


<?php
	if (isset($_POST["but_add"]) && isset($_POST["firstname"]) && isset($_POST["lastname"]) && isset($_POST["phone"]) && isset($_POST["email"]) && isset($_POST["password"])) {
	    
		$firstname = $_POST["firstname"];
		$lastname = $_POST["lastname"];
		$phone = $_POST["phone"];
		$email = $_POST["email"];
		$password = password_hash($_POST["password"], PASSWORD_DEFAULT);
		$is_admin = 1;
        $blacklist = 0;
        $is_deleted = 0;
		$gender = $_POST["gender"];

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
                break;
        }

		try {

		  $sql = "INSERT INTO userprofiles (firstname, lastname, phone, gender, email, password, is_admin, blacklist, is_deleted) VALUES ('$firstname', '$lastname', '$phone', $gender, '$email', '$password', $is_admin, $blacklist, $is_deleted)";

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

</div>
</div>
</div>
</div>
</div>

<?php
	require "../../blocks/footer.php";
?>
<br><br>