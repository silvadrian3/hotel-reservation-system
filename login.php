<?php
include "connection.php";
?>


<html>
    <head>
        <title>Yayadub Online Reservation</title>
        <link rel="stylesheet" href="style.css" type="text/css" />
    </head>
    <body>
		
        <form method="POST">
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
        <div class="c-li-container">
            <div class="c-li-inner-container"> 

                <div class="c-li-form">
                    <div class="c-li-header">
                        <h3>Log In</h3>
                    </div>

                    <div>
                        <input type="email" class="c-li-textfield" name="email" id="email" placeholder="Email" autofocus required>
                    </div>

                    <div>
                        <input type="password" class="c-li-textfield" name="password" id="password" placeholder="Password" required>
                    </div>

                    <div>
                        <input type="submit" class="c-li-btn" name="login" id="login" value="LOG IN">
                    </div>

                    

                    <?php
                    if(isset($_POST["login"])){
                        $email = $_POST["email"];
                        $password = $_POST["password"];

                        $email = mysqli_real_escape_string($connection, $email);
                        $password = mysqli_real_escape_string($connection, $password);

                        $checklogin = mysqli_query($connection, "SELECT id, type, firstname, lastname FROM `users` WHERE email = '". $email . "' AND password = '" . $password. "'");

                        if(mysqli_num_rows($checklogin) != 0){

                            $fetchUser = mysqli_fetch_array($checklogin);
                            $type = $fetchUser['type'];
                            $user_id = $fetchUser['id'];
                            $user_name = $fetchUser['firstname'] .' '.$fetchUser['lastname'];
                            
                            session_start();
                            $_SESSION["username"]=$user_name;
                            $_SESSION["type"]=$type;
                            $_SESSION["user_id"]=$user_id;
                            $_SESSION["email"]=$email;
                            $_SESSION["userpass"]=$password;
                        
                            
                        
						if($type == 'admin'){
                            header("Location: admin/index.php");
                        } elseif($type =='customer') {
                            
                            if(isset($_GET['room_id'])){
                                header("Location: booking.php?room_id=" . $_GET['room_id']);
                            } else {
                                header("Location: index.php");
                            }
                        }
                        

                        } else {
                            echo "<p style='color:#FF0000'>Invalid Username or Password!</p>";
                        }
                    }
                    ?>
                    
                    <div class="forgot_password">
                        <a href="forgot_password.php">Forgot Password?</a>
                    </div>
                        
                    <div class="signup">
                        <a href="register.php">Sign Up</a>
                    </div>
                        
                    
                    <div><br/><br/></div>
                        
                    
                </div>

            </div>
        </div>
            
        </form>
    </body>
	
</html>

