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
    <body background="y.jpg" center>
	
        <form method="POST">
            
            <?php if($isLogged == true) { ?>
            <div class="welcome">
                <p align="right">
                    <?php echo $_SESSION["username"]; ?>, Welcome to Yayadub Online Reservation<br/><br/>
                    <a href="logout.php">Log Out</a>
                </p>
            </div>
            <?php } ?>
            
            <table class="nav">
            <tr>
                <td class="links title"><span onclick="window.location = 'Home.php'">WELCOME TO YAYADUB ONLINE RESERVATION</span></td>
                
                <td>
                    <table align="right" width="58%">
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
			
<div class="w3-content w3-section" style="max-width:500px">
  <img class="mySlides" src="1.jpg" style="width:100%">
  <img class="mySlides" src="2.jpg" style="width:100%">
  <img class="mySlides" src="3.jpg" style="width:100%">
  <img class="mySlides" src="4.jpg" style="width:100%">
  <img class="mySlides" src="6.jpg" style="width:100%">
</div>

<script>
var myIndex = 0;
carousel();

function carousel() {
    var i;
    var x = document.getElementsByClassName("mySlides");
    for (i = 0; i < x.length; i++) {
       x[i].style.display = "none";  
    }
    myIndex++;
    if (myIndex > x.length) {myIndex = 1}    
    x[myIndex-1].style.display = "block";  
    setTimeout(carousel, 2000); // Change image every 2 seconds
}
</script>

        </form>
    </body>
</html>