<?php
include "connection.php";

session_start();
$isLogged = false;

if(isset($_SESSION['email'])){
    $checkIfLogged = mysqli_query($connection, "SELECT id as user_id FROM `users` WHERE email = '".$_SESSION['email']."' AND type = 'customer'");
    
    if(mysqli_num_rows($checkIfLogged) != 0){
        $isLogged = true;
    }
}

if(isset($_GET["id"]) && !empty($_GET["id"])){
    $reservation_id = $_GET["id"];
    $reservation_id = mysqli_real_escape_string($connection, $reservation_id);
}

?>



<html>
    <head>
        <title>Online Hotel Reservation</title>
        <link rel="stylesheet" href="style.css" type="text/css" />
    </head>
    <body>
        <form method="POST" enctype="multipart/form-data">
            <?php if($isLogged == true) { ?>
            <div class="welcome">
                <p align="right">
                    Hi <?php echo $_SESSION["username"]; ?>, Welcome to Online Hotel Reservation!<br/><br/>
                    <a href="logout.php">Log Out</a>
                </p>
            </div>
            <?php } ?>
            
            <table class="nav">
            <tr>
                <td class="links title"><span onclick="window.location = 'index.php'">Yayadub Hotel Reservation</span></td>
                
                <td>
                    <table align="right" width="40%">
                    <tr>
                        <td class="links">
                            <a href="index.php"><b>Home</b></a>
                        </td>
                        
                        <td class="links">
                            <a href="history.php"><b>History</b></a>
                        </td>
						
                        <?php if($isLogged == false) { ?>
                        
                        <td class="links">
                            <a href="login.php"><b>Log In</b></a>
                        </td>
                        
                        <?php } else { ?>
                        
                        <td class="links">
                            <a href="myreservation.php"><b>My Reservation</b></a>
                        </td>
                        
                        <?php } ?>
                        
                    </tr>
                    </table>
                </td>
                
            </tr>
            </table>
            
            <div class="view_table">
                <table>
                    
                    <tr id="tr_reciept">
                        <td>
                            Receipt
                        </td>
                        <td>
                            <input type="file" name="receipt" id="receipt" required>
                        </td>
                    </tr>
                    
                    <tr id="tr_controlno">
                        <td valign="top">
                            <p>Control No.</p>
                        </td>
                        <td>
                            <input type="text" name="control_no" id="control_no" class="field" required>
                        </td>
                    </tr>
                    
                    
                    <tr>
                        <td colspan="2">
                            <input type="submit" class="btn" name="submit" value="Submit">
                        </td>
                    </tr>
                    
                </table>
            </div>
        </form>
        
    </body>

</html>

<?php

if(isset($_POST['submit'])){
    $control_number = mysqli_real_escape_string($connection, $_POST['control_no']);
    $target_dir = "images/receipts/";
    $filename = "";
    
    $state = true;
    
    if(basename($_FILES["receipt"]["name"]) != ""){
        $filename = date('ymdHis') . basename($_FILES["receipt"]["name"]);
        $target_file = $target_dir . $filename;
        if(!move_uploaded_file($_FILES["receipt"]["tmp_name"], $target_file)){
            $state = false;
            echo "<script>";
            echo "alert('Sorry, there was an error uploading your file.');";
            echo "window.location = 'myreservation.php';";
            echo "</script>";
        } else {
            $state = true;
        }
    }
    
    if($state == true){
        $updateReservation = mysqli_query($connection, "UPDATE `reservations` SET control_number = '".$control_number."', receipt_image = '".$filename."' WHERE id = '" . $reservation_id . "'");
    
        if($updateReservation){
            echo "<script>";
            echo "alert('Receipt successfully uploaded.');";
            echo "window.location = 'myreservation.php';";
            echo "</script>";
        } else {
            die(mysqli_error($connection));
        }
    }
}
?>