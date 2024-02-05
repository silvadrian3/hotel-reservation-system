<?php
include "connection.php";

session_start();
$isLogged = false;

if(isset($_SESSION['email'])){
    $checkIfLogged = mysqli_query($connection, "SELECT id as user_id FROM `users` WHERE email = '".$_SESSION['email']."'");
    
    if(mysqli_num_rows($checkIfLogged) != 0){
        $isLogged = true;
    }
}
?>

<html>
    <head>
        <title>Yayadub Hotel Reservation</title>
        <link rel="stylesheet" href="style.css" type="text/css" />
    </head>
     <body background="y.jpg">
	
        <form method="POST">
            
            <?php if($isLogged == true) { ?>
            <div class="welcome">
                <p align="right">
                    <?php echo $_SESSION["username"]; ?>, Welcome to Online Hotel Reservation<br/><br/>
                    <a href="logout.php">Log Out</a>
                </p>
            </div>
            <?php } ?>
            
            <table class="nav">
            <tr>
                <td class="links title"><span onclick="window.location = 'Home.php'">Yayadub Online Reservation</span></td>
                
                <td>
                    <table align="right" width="43%">
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
			
			<br/><br/><br/><br/>
			         <tr>
                        <td>
                            <p>Yayadub Appartelle is a hotel like business inspired by the</p>
							<p>TV show "Eat Bulaga" that is loved by so many Filipino people.</p>
							<p>The Yayadub Appartelle offers a very affordable rooms and promos</p>
							<p>like a 3 Hour stay that cost 250 pesos,</p>
							<p>6 Hours of stay that cost 400 pesos, 12 Hours of stay that cost 700 pesos,</p>
							<p>Yayadub Appartelle is owned by Guevarra Family that opened along</p>
							<p>Lagro, Quezon City.</p>
							
							
						</td>
                      </tr>
            
        </form>
    </body>
</html>