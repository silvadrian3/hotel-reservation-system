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
            
            <br/><br/>
            
            <table class="tbl_RecordList" cellpadding="0" cellspacing="0">
                <tr style="background: #fcfcfc">
                    <th>Room Number</th>
                    <th>End Time</th>
                    <th>Status</th>
                </tr>
            
            <?php
            
                
            $room_type = $_GET['type'];
                
            if(isset($room_type)){
                if($room_type == "Single" || $room_type == "Double"){
                    $room_type = mysqli_real_escape_string($connection, $room_type);
                    
                    $getRooms = mysqli_query($connection, "SELECT id as room_id, room_number, description, status FROM `rooms` WHERE type = '".$room_type."'");
                    
                    if(mysqli_num_rows($getRooms) != 0){
                        while($fetchRooms = mysqli_fetch_array($getRooms)){
                            $room_id = $fetchRooms["room_id"];
                            $room_no = $fetchRooms["room_number"];
                            $end_date = "";

                            if($fetchRooms["status"] == "Available"){
                                if($isLogged){
                                    $status = "<a href='booking.php?room_id=".$room_id."'>".$fetchRooms["status"]."</a>";    
                                } else {
                                    $status = "<a href='login.php?room_id=".$room_id."'>".$fetchRooms["status"]."</a>";    
                                }
                                
                            } else {
                                $status = $fetchRooms["status"];
                                
                                $getEndDate = mysqli_query($connection, "SELECT end_date FROM `reservations` WHERE room_id = '".$room_id."' AND status <> 'Completed' AND status <> 'Cancelled'");
                                
                                if(mysqli_num_rows($getEndDate) != 0){
                                    $fetchEndDate = mysqli_fetch_array($getEndDate);
                                    if($fetchEndDate["end_date"] != "" && $fetchEndDate["end_date"] != "0000-00-00 00:00:00"){
                                        $end_date = date("H:i A", strtotime($fetchEndDate["end_date"]));
                                    }
                                }
                                
                                
                            }
                            
                            
                            echo "<tr>";
                            echo "<td align='center'>". $room_no ."</td>";
                            echo "<td align='center'>". $end_date ."</td>";
                            echo "<td align='center'>". $status ."</td>";
                            echo "</tr>";
                        }

                    } else {
                        echo "<tr><td colspan='3'>No record found.</td></tr>";
                    }
                }
            }
            
            ?>
            </table>
            
            <br/><br/>
            
            
        </form>
        
        <script type="text/javascript">
            function reserve(id, isLogged){
                
                if(isLogged == true){
                    window.location = "booking.php?id=" + id;    
                } else {
                    window.location = "register.php";
                }
                
            }
        </script>
    </body>
</html>
           

