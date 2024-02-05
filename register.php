<?php
include "connection.php";
?>


<html>
    <head>
        <title>Yayadub Online Reservation</title>
        <link rel="stylesheet" href="style.css" type="text/css" />
    </head>
    <body>
        <form method="POST" enctype="multipart/form-data">
				<table class="nav">
            <tr>
                <td class="links title"><span onclick="window.location = 'Home.php'">Yayadub Online Reservation</span></td>
                
                <td>
                    <table align="right" width="42%">
                    <tr>
					 <td class="links">
                            <a href="Home.php"><b>Home</b></a>
                        </td>
                        <td class="links">
                            <a href="index.php"><b>Rooms</b></a>
                        </td>
                        <td class="links">
                            <a href="history.php"><b>History</b></a>
                        </td>
						<td class="links">
                            <a href="login.php"><b>Log In</b></a>
                        </td>
                    </tr>
                    </table>
                </td>
                
            </tr>
            </table>
            
            <div class="view_table">
                <h2>Customer Details</h2>
                <table>
                    <tr>
                        <td>
                            <p>First Name <font color="red">*</font></p>
                        </td>
                        <td>
                            <input type="text" class="field" name="firstname" id="firstname" onkeypress="isValidText(event)" required />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>Last Name <font color="red">*</font></p>
                        </td>
                        <td>
                            <input type="text" class="field" name="lastname" id="lastname" onkeypress="isValidText(event)" required />
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            <p>Username/Email Address <font color="red">*</font></p>
                        </td>
                        <td>
                            <input type="email" class="field" name="email" id="email" required />
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            <p>Password <font color="red">*</font></p>
                        </td>
                        <td>
                            <input type="password" class="field" name="password" id="password" required />
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            <p>Contact Number <font color="red">*</font></p>
                        </td>
                        <td>
                            <input type="text" class="field" name="contactno" id="contactno" onkeypress="isValidNumber(event)" required />
                        </td>
                    </tr>
                    
                    <tr>
                        <td colspan="2">
                            <input type="button" class="btn" name="back" style="width:110px" onclick="back_to_home()" value="Back">
                            <input type="submit" class="btn" name="submit" style="width:110px" value="Register">
                        </td>
                    </tr>
                    
                </table>
            </div>
        </form>

        <script>
            function isValidText(evt) {
                var charCode = (evt.which) ? evt.which : event.keyCode;
                if ((charCode > 64 && charCode < 91) || (charCode > 96 && charCode < 123) || charCode == 32) {
                    return true;
                } else {
                    evt.preventDefault();
                }
            }
            
            function isValidNumber(evt) {
                evt = (evt) ? evt : window.event;
                var charCode = (evt.which) ? evt.which : evt.keyCode;
                if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                    evt.preventDefault();
                }
                return true;
            }
            
            function back_to_home(){
                window.location = "index.php";
            }
        </script>
            
<?php


if(isset($_POST["submit"])) {
    
    $firstname = mysqli_real_escape_string($connection, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($connection, $_POST['lastname']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);
    $contactno = mysqli_real_escape_string($connection, $_POST['contactno']);
    
    
    $checkUser = mysqli_query($connection, "SELECT id FROM `users` WHERE email = '".$email."'");
    
    if($checkUser){
        
        if(mysqli_num_rows($checkUser) == 0){
            $insertUser = mysqli_query($connection, "INSERT INTO `users` (type, firstname, lastname, email, password) VALUES ('customer', '". $firstname ."', '".$lastname."', '".$email."', '".$password."')");
    
            if($insertUser){
                $user_id = mysqli_insert_id($connection);

                $insertCustomer = mysqli_query($connection, "INSERT INTO `customers` (user_id, firstname, lastname, email, contact_no) VALUES ('". $user_id ."', '" . $firstname . "', '" . $lastname . "', '".$email."', '".$contactno."')");

                if($insertCustomer){
                    session_start();
                    $_SESSION["username"]=$firstname . ' ' .$lastname;
                    $_SESSION["type"]='customer';
                    $_SESSION["user_id"]=$user_id;
                    $_SESSION["email"]=$email;
                    $_SESSION["userpass"]=$password;
                    echo "<script>";
                    echo "alert('account successfully registered.');";
                    echo "window.location = 'index.php';";
                    echo "</script>";        
                } else {
                    die(mysqli_error($connection));
                }
            } else {
                die(mysqli_error($connection));
            }    
        } else {
            echo "<script>";
            echo "alert('Email Address already exists.');";
            echo "window.location = 'index.php';";
            echo "</script>";
        }
        
    } else {
        die(mysqli_error($connection));
    }
    
    
    
    
}

?>
            
    </body>
</html>

