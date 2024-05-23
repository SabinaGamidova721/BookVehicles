<style>
    .form-control, .form-select {
        max-width: 300px;
    }
    .form-check-label {
        margin-left: 5px;
    }
</style>

<?php
    include "../../blocks/connection.php";
    $title = "Update check point";
    $profpic = "../../back5.jpg";
    include "../../blocks/header.php";

    if($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["id"])) {
        $adminid = $_GET["id"];
        
        $sql = "SELECT * FROM userprofiles WHERE id = :adminid AND is_admin = true";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(":adminid", $adminid);
        $stmt->execute();

        if($stmt->rowCount() > 0){
            foreach ($stmt as $row) {
                $firstname = $row["firstname"];
                $lastname = $row["lastname"];
                $phone = $row["phone"];
                $gender = $row["gender"];
                $email = $row["email"];
            }

        $manbox = (strval($gender) == '1') ? 'checked' : '';
        $womanbox = (strval($gender) == '2') ? 'checked' : '';
        $otherbox = (strval($gender) == '3') ? 'checked' : '';

        echo "<br><br><br>
        <div class=\"container\">
            <div class=\"content\">
                <h3>Update admin</h3>
                <form method='post'>
                    <input type='hidden' name='id' value='$adminid' />
                    <p>First Name:
                        <input type='text' name='firstname' value='$firstname' class='form-control'/>
                    </p>
                    <p>Last Name:
                        <input type='text' name='lastname' value='$lastname' class='form-control'/>
                    </p>
                    <p>Phone:
                        <input type='text' name='phone' value='$phone' class='form-control'/>
                    </p>
                    <p>Gender:
                        <div class=\"d-flex align-items-center\">
                            <input class=\"form-check-input\" type=\"radio\" name=\"gender\" id=\"male\" value=\"1\" <?php echo $manbox ?>
                            <label class=\"form-check-label\" for=\"male\">Man</label>

                            <input class=\"form-check-input\" type=\"radio\" name=\"gender\" id=\"female\" value=\"2\" 
                            <?php echo $womanbox ?>
                            <label class=\"form-check-label\" for=\"female\">Woman</label>

                            <input class=\"form-check-input\" type=\"radio\" name=\"gender\" id=\"other\" value=\"3\" 
                            <?php echo $otherbox ?>
                            <label class=\"form-check-label\" for=\"other\">Other</label>
                        </div>
                    </p>
                    <p>Email:
                        <input type='text' name='email' value='$email' class='form-control'/>
                    </p>
                    <div class=\"col text-center\">
                        <input type='submit' value='Save' class='btn btn-warning'>
                    </div>
                </form>
            </div>
        </div>";
        }
        else{
            echo "Admin was not found";
        }
    }
    // elseif (isset($_POST["location"])) {

    //     $sql = "UPDATE points SET location = :location WHERE id = :pointid";
    //     $stmt = $conn->prepare($sql);
    //     $stmt->bindValue(":pointid", $_POST["id"]);
    //     $stmt->bindValue(":location", $_POST["location"]);

    //     $stmt->execute();
    //     header("Location: points.php");
    // }
    // else{
    //     echo "Invalid data";
    // }
    // include "../../blocks/footer.php";
    // echo "<br><br><br>";


    elseif (isset($_POST["firstname"]) && isset($_POST["lastname"]) && isset($_POST["phone"]) && isset($_POST["gender"]) && isset($_POST["email"])) {

        $sql = "UPDATE userprofiles SET firstname = :firstname, lastname = :lastname, phone = :phone, gender = :gender, email = :email WHERE id = :adminid";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(":adminid", $_POST["id"]);
        $stmt->bindValue(":firstname", $_POST["firstname"]);
        $stmt->bindValue(":lastname", $_POST["lastname"]);
        $stmt->bindValue(":phone", $_POST["phone"]);
        $stmt->bindValue(":gender", $_POST["gender"]);
        $stmt->bindValue(":email", $_POST["email"]);

        $stmt->execute();
        header("Location: admins.php");
    } else {
        echo "Invalid data";
    }

include "../../blocks/footer.php";
echo "<br><br><br>";




