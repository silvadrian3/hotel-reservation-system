<?php
include "connection.php";
?>


<html>
    <head>
        <title>Online Hotel Reservation</title>
        <link rel="stylesheet" href="style.css" type="text/css" />
    </head>
    <body>
		
        <form method="POST">
        <div class="c-li-container">
            <div class="c-li-inner-container"> 

                <div class="c-li-form">
                    <div class="c-li-header">
                        <h3>Forgot Password</h3>
                    </div>

                    <div>
                        <input type="email" class="c-li-textfield" name="email" id="email" placeholder="User Name" autofocus required>
                    </div>

                    <div>
                        <input type="submit" class="c-li-btn" name="forgotpassword" id="forgotpassword" value="SUBMIT">
                    </div>

                    

                    <?php
                    if(isset($_POST["forgotpassword"])){
                        $email = $_POST["email"];
                        
                        $email = mysqli_real_escape_string($connection, $email);
                        

                        $checkpassword = mysqli_query($connection, "SELECT id, password FROM `users` WHERE email = '". $email . "'");

                        if(mysqli_num_rows($checkpassword) != 0){

                            $fetchUser = mysqli_fetch_array($checkpassword);
                            $password = $fetchUser['password'];
                            echo "<p style='color:#4CAF50'>Your password is: <b>".$password."</b></p>";
                        } else {
                            echo "<p style='color:#FF0000'>Username doesn't exists on the database.</p>";
                        }
                    }
                    ?>
                    
                    <div class="forgot_password">
                        <a href="login.php">Back to Log In</a>
                    </div>
                </div>

            </div>
        </div>
            
        </form>
    </body>
	
</html>

