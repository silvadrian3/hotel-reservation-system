<?php
include "../connection.php";
include "../session.php";

$room_id = '';
$room_number = '';
$description = '';
$status = '';
$url = '';

if(isset($_GET["id"]) && !empty($_GET["id"])){
    $room_id = $_GET["id"];
    $room_id = mysqli_real_escape_string($connection, $room_id);
    $getRoomDetails = mysqli_query($connection, "SELECT id as room_id, room_number, description, status FROM `rooms` WHERE id = '".$room_id."'");
    
    if(mysqli_num_rows($getRoomDetails)!=0){
        while($fetchRoomDetails = mysqli_fetch_array($getRoomDetails)){
            $room_id = stripslashes($fetchRoomDetails["room_id"]);
            $room_number = stripslashes($fetchRoomDetails["room_number"]);
            $description = stripslashes($fetchRoomDetails["description"]);
            $status = stripslashes($fetchRoomDetails["status"]);
            
            $getRoomImage = mysqli_query($connection, "SELECT * FROM `room_images` WHERE room_id = '".$room_id."'");
                        
            if(mysqli_num_rows($getRoomImage) != 0){
                while($fetchRoomImage = mysqli_fetch_array($getRoomImage)){
                    $url = "<img src='../images/rooms/".$fetchRoomImage['url']."' width='600px' height='400px' />";
                }
            }
        }
    }   
}

?>


<html>
    <head>
        <title>Online Hotel Reservation</title>
        <link rel="stylesheet" href="../style.css" type="text/css" />
    </head>
    <body>
        <form method="POST">
            <div class="welcome">
                <p align="right">
                    Hi <?php echo $_SESSION["username"]; ?>, Welcome to Online Hotel Reservation!<br/><br/>
                    <a href="../logout.php">Log Out</a>
                </p>
            </div>
            
            <table class="nav">
            <tr>
                <td class="links title"><span onclick="window.location = 'index.php'">Online Hotel Reservation</span></td>
                
                <td>
                    <table align="right" width="50%">
                    <tr>
                        <td class="links">
                            <a href="index.php">Reservations</a>
                        </td>
                        <td class="links">
                            <a href="rooms.php"><b>Rooms</b></a>
                        </td>
                        <td class="links">
                            <a href="transactions.php">Transactions</a>
                        </td>
                    </tr>
                    </table>
                </td>
                
            </tr>
            </table>
            
            <div class="view_table">
                <h2>Room Details</h2>
                <table>
                    <tr>
                        <td>
                            <p>Room ID</p>
                        </td>
                        <td>
                            <p><?php echo $room_id; ?></p>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            <p>Room Number</p>
                        </td>
                        <td>
                            <p><?php echo $room_number; ?></p>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            <p>Description</p>
                        </td>
                        <td>
                            <p><?php echo $description; ?></p>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            <p>Status</p>
                        </td>
                        <td>
                            <p><?php echo $status; ?></p>
                        </td>
                    </tr>
                    
                    <tr>
                        <td colspan="2">
                            <?php echo $url; ?>
                        </td>
                        
                    </tr>
                    
                    
                    
                    
                    
                </table>
            </div>
            
        </form>
        
    </body>
</html>

            
