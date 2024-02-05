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

?>

<html>
    <head>
        <title>Online Hotel Reservation</title>
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
                <td class="links title"><span onclick="window.location = 'index.php'">Yayadub Online Reservation</span></td>
                
                <td>
                    <table align="right" width="41%">
                    <tr>
                        <td class="links">
                            <a href="history.php"><b>Home</b></a>
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
            
            <table class="tbl_RecordList" cellpadding="0" cellspacing="0">
                <tr style="background: #fcfcfc">
                    <th width='5%'>ID</th>
                    <th width='20%'>Reservation Date</th>
                    <th width='15%'>Room No.</th>
                    <th width='25%'>Date of Stay</th>
                    <th width='15%'>Status</th>
                    <th width='20%'>Action</th>
                </tr>
        
			
            <?php
            
            $getReservations = mysqli_query($connection, "SELECT a.id as reservation_id, a.start_date, a.end_date, a.status, a.reservation_date, a.payment_term, a.receipt_image, b.firstname, b.lastname, b.email, c.room_number, c.description FROM `reservations` as a INNER JOIN `customers` as b ON (a.customer_id = b.id) INNER JOIN `rooms` as c ON (a.room_id = c.id) INNER JOIN `users` as d ON (b.user_id = d.id) WHERE d.id = '".$_SESSION["user_id"]."' AND (a.status <> 'Completed' AND a.status <> 'Cancelled')");
                
                if(mysqli_num_rows($getReservations) != 0){
                    while($fetchReservations = mysqli_fetch_array($getReservations)){
                        echo "<tr>";
                        echo "<td align='center'>". $fetchReservations["reservation_id"] ."</td>";
                        echo "<td align='center'>". $fetchReservations["reservation_date"] ."</td>";
                        echo "<td align='center'>". $fetchReservations["room_number"] ."</td>";
                        echo "<td align='center'>From ". date('Y-m-d', strtotime($fetchReservations["start_date"])) . ' To ' . date('Y-m-d', strtotime($fetchReservations["end_date"])) ."</td>";
                        echo "<td align='center'>". $fetchReservations["status"] ."</td>";
                        echo "<td align='center'>";
                            echo "<input type='button' class='action' onclick='cancel(". $fetchReservations["reservation_id"] .")' value='Cancel'>";
                            
                            if($fetchReservations["payment_term"] != "On-Site" && $fetchReservations["receipt_image"] == ''){
                                echo "<input type='button' class='action' onclick='uploadreceipt(". $fetchReservations["reservation_id"] .")' value='Upload Receipt'>";
                            }
                        
                        echo "</td>";
                        echo "</tr>";
                    }
                    
                } else {
                    echo "<tr><td colspan='6'>No record found.</td></tr>";
                }
            
            ?>
			
			<?php
                
                $getApprovedReservations = mysqli_query($connection, "SELECT a.start_date, a.end_date, b.room_number, b.description FROM `reservations` as a INNER JOIN `rooms` as b ON (a.room_id = b.id) WHERE a.customer_id = customer_id AND a.status = 'Approved'");
            
                if($getApprovedReservations){
                    if(mysqli_num_rows($getApprovedReservations) !=0){
                        while($fetchApprovedReservations = mysqli_fetch_array($getApprovedReservations)){
                            extract($fetchApprovedReservations);
                            echo '<div class="notification">
                                    Congratulations! Your reservation for Room <b>'.$room_number.'</b> from <b>'.date('d M y H:i a', strtotime($start_date)).'</b> to <b>'.date('d M y H:i a', strtotime($end_date)).'</b> has been approved.
                                </div>';
                        }
                    }    
                }
                
            
            ?>
            
            </table>
            <br/><br/><br/><br/><br/>
			
				 <tr>
                        <td>
                            <p>Bank Account no<font color="red">*</font>: 154-235-65 </p>
                        </td>
			
                            <p>Remittance Account no<font color="red">*</font>: 346-612-35 </p>
                        </td>
                      
                    </tr>
                        
            
        </form>
        
        <script type="text/javascript">
            function cancel(id){
                if(confirm("Are you sure you want to cancel this reservation?")){
                    window.location = "cancel_reservation.php?id=" + id;
                }
            }
            
            function uploadreceipt(id){
                window.location = "upload_receipt.php?id=" + id;
            }
        </script>
    </body>
</html>
           

