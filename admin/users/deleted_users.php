<?php
	include "../../blocks/connection.php";
	$title = "All Deleted Users";
	$profpic = "../../back5.jpg";
	include "../../blocks/header.php";

	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	$notes_on_page = 4;
	$from = ($page - 1) * $notes_on_page;

	$sql = "SELECT * FROM userprofiles WHERE is_admin = false AND is_deleted = true ORDER BY firstname LIMIT $from,$notes_on_page";
	$result = $conn->query($sql);
?>

<div class="col text-center">
	<div class="container">
		  <div class="content">
		  	<h1>Users</h1>
		    <table class="table table-hover table-sm">
		    	<tr>
		    		<th>Id</th>
		    		<th>First name</th>
		    		<th>Last name</th>
		    		<th>Email</th>
		    		<th>In Black List?</th>
		    		<th></th>
		    	</tr>
		    	<?php
				    $id = $from + 1;
				    while($row = $result->fetch()){
				    	echo "<tr>";
					    	echo "<td>" . $id++ . "</td>";
					    	echo "<td>" . $row["firstname"] . "</td>";
					    	echo "<td>" . $row["lastname"] . "</td>";
					    	echo "<td>" . $row["email"] . "</td>";
					    	echo "<td>
					    		<form method='post' action=''>
					    			<input type='hidden' name='id' value='" . $row["id"] . "' />
					    			<input type='checkbox' name='blacklist' value='1' " . ($row["blacklist"] ? "checked" : "") . " onchange='this.form.submit()' />
					    		</form>
					    	</td>";
					    	echo "<td>
					    		<form action='delete.php' method='post'>
					    			<input type='hidden' name='id' value='" . $row["id"] . "' />
					    			<input type='submit' value='Delete' class='btn btn-outline-danger'>
					    		</form>
					    	</td>";
				    	echo "</tr>";
				    }
			    ?>
		    </table>
		    <?php
			    $sql = "SELECT COUNT(*) as count FROM userprofiles WHERE is_admin = false AND is_deleted = true";
			    $stmt = $conn->prepare($sql);
			    $stmt->execute();
			    $count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
			    if($count == 0) {
		            echo "<br><b>No records found</b><br>";
				} else {
					$pages_count = ceil($count / $notes_on_page);

					if($page != 1) {
						$prev = $page - 1;
						echo "<a href=\"?page=$prev\" class=\"pages arrow\"><<</a>";
					}

					for($i = 1; $i <= $pages_count; $i++) {
						if($page == $i) {
							echo "<a href=\"?page=$i\" class=\"pages active\">$i</a> ";
						} else {
							echo "<a href=\"?page=$i\" class=\"pages\">$i</a> ";
						}
					}

					if($page != $pages_count) {
						$next = $page + 1;
						echo "<a href=\"?page=$next\" class=\"pages arrow\">>></a> ";
					}
				}
			?>
			<br><br>

			<a href="users.php" class="btn btn-warning">Return to users</a>
			<a href="../index.php" class="btn btn-warning">Return to main</a>
		  </div>
	</div>
</div>

<?php
	include "../../blocks/footer.php";
?>
