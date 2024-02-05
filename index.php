<?php
include "connection.php";

session_start();
$isLogged = false;

if(isset($_SESSION['email'])){
    $checkIfLogged = mysqli_query($connection, "SELECT id as user_id FROM `users` WHERE email = '".$_SESSION['email']."' AND type = 'customer'");
    
    if(mysqli_num_rows($checkIfLogged) != 0){
        $isLogged = true;
        
        
        $fetchIfLogged = mysqli_fetch_array($checkIfLogged);
        
        $getCustomerID = mysqli_query($connection, "SELECT id as customer_id FROM `customers` WHERE user_id = '".$fetchIfLogged['user_id']."'");
        
        if($getCustomerID){
            if(mysqli_num_rows($getCustomerID) != 0){
                $fetchCustomerID = mysqli_fetch_array($getCustomerID);
                $customer_id = $fetchCustomerID['customer_id'];
            }
        }
        
        
    }
}

?>

<html>
    <head>
        <title>Yayadub</title>
        <link rel="stylesheet" href="style.css" type="text/css" />
    </head>
    <body>
        <form method="POST">
            <?php if($isLogged == true) { ?>
            <div class="welcome">
                <p align="right">
                    Hi <?php echo $_SESSION["username"]; ?>, Welcome to Yayadub Online Reservation!<br/><br/>
                    <a href="logout.php">Log Out</a>
                </p>
            </div>
            <?php } ?>
            
            <table class="nav">
            <tr>
                <td class="links title"><span onclick="window.location = 'Home.php'">Welcome to Yayadub Online Reservation</span></td>
                
                <td>
                    <table align="right" width="50%">
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
            
            
            <div class="bedroom_type">
                <section class="single_room">
                    <img src='images/rooms/4.jpg' width='400px' height='300px' />
                    <br/>
                    <h1>Single Bed</h1>
                    <input type='button' class='btn' onclick="pick('Single')" value='Book Now!' />
                </section>
                <section class="double_room">
                    <img src='images/rooms/5.jpg' width='400px' height='300px' />
                    <br/>
                    <h2>Double Bed</h2>
                    <input type='button' class='btn' onclick="pick('Double')" value='Book Now!' />
                </section>
            </div>
            
            <br/><br/>
            
            
        </form>
        
        <script type="text/javascript">
            function pick(type){
                window.location = "pick_room.php?type=" + type;
            }
        </script>
    </body>
</html>
           

