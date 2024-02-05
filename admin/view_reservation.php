<?php
include "../connection.php";
include "../session.php";

$reservation_id = '';
$start_date = '';
$end_date = '';
$start_time = '';
$end_time = '';
$status = '';
$firstname = '';
$lastname = '';
$email = '';
$contact_no = '';
$room_number = '';
$description = '';
    
if(isset($_GET["id"]) && !empty($_GET["id"])){
    $reservation_id = $_GET["id"];
    $reservation_id = mysqli_real_escape_string($connection, $reservation_id);
        
    $getReservationDetails = mysqli_query($connection, "SELECT a.id as reservation_id, a.start_date, a.end_date, a.room_rates, a.payment_term, a.bank_name, a.status, b.firstname, b.lastname, b.email, b.contact_no, c.room_number, c.description FROM `reservations` as a INNER JOIN `customers` as b ON (a.customer_id = b.id) INNER JOIN `rooms` as c ON (a.room_id = c.id) WHERE a.id = '".$reservation_id."'");
    
    if(mysqli_num_rows($getReservationDetails)!=0){
        while($fetchReservationDetails = mysqli_fetch_array($getReservationDetails)){
            $reservation_id = stripslashes($fetchReservationDetails["reservation_id"]);
            $start_date = stripslashes($fetchReservationDetails["start_date"]);
            $end_date = stripslashes($fetchReservationDetails["end_date"]);
            $status = stripslashes($fetchReservationDetails["status"]);
            $firstname = stripslashes($fetchReservationDetails["firstname"]);
            $lastname = stripslashes($fetchReservationDetails["lastname"]);
            $email = stripslashes($fetchReservationDetails["email"]);
            $contact_no = stripslashes($fetchReservationDetails["contact_no"]);
            $room_number = stripslashes($fetchReservationDetails["room_number"]);
            $description = stripslashes($fetchReservationDetails["description"]);
            $payment_term = stripslashes($fetchReservationDetails["payment_term"]);
            $bank_name = stripslashes($fetchReservationDetails["bank_name"]);
            $room_rates = stripslashes($fetchReservationDetails["room_rates"]);
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
                    Hi <?php echo $_SESSION["username"]; ?>, Welcome to Yayadub Online Reservation!<br/><br/>
                    <a href="../logout.php">Log Out</a>
                </p>
            </div>
            
            <table class="nav">
            <tr>
                <td class="links title"><span onclick="window.location = 'index.php'">Yayadub Online Reservation</span></td>
                
                <td>
                    <table align="right" width="50%">
                    <tr>
                        <td class="links">
                            <a href="index.php"><b>Reservations</b></a>
                        </td>
                        <td class="links">
                            <a href="rooms.php">Rooms</a>
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
                <h2>Reservation Details</h2>
                <table>
                    <tr>
                        <td>
                            <p>Reservation ID</p>
                        </td>
                        <td>
                            <p><?php echo $reservation_id; ?></p>
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
                            <b>Customer Details</b>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>Name</p>
                        </td>
                        <td>
                            <p><?php echo $firstname . ' ' . $lastname; ?></p>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            <p>Email Address</p>
                        </td>
                        <td>
                            <p><?php echo $email; ?></p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>Contact Number</p>
                        </td>
                        <td>
                            <p><?php echo $contact_no; ?></p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <b>Date of Stay</b>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>Start Date</p>
                        </td>
                        <td>
                            <p><?php echo date('Y-m-d H:i a', strtotime($start_date)); ?> </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>End Date</p>
                        </td>
                        <td>
                            <p><?php echo date('Y-m-d H:i a', strtotime($end_date)); ?> </p>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            <p>Room Rate</p>
                        </td>
                        <td>
                            <p><?php echo $room_rates; ?> </p>
                        </td>
                    </tr>
                    
                    
                    
                    <tr>
                        <td colspan="2">
                            <b>Room Details</b>
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
                        <td colspan="2">
                            <b>Payment Details</b>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            <p>Payment Method</p>
                        </td>
                        <td>
                            <p><?php echo $payment_term; ?></p>
                        </td>
                    </tr>
                    
                    <?php 
                        if($payment_term == 'Bank') {
                    ?>
                    <tr>
                        <td>
                            <p>Bank Name</p>
                        </td>
                        <td>
                            <p><?php echo $bank_name; ?></p>
                        </td>
                    </tr>
        
                    <?php
                        }
                    ?>
                    
                    
                </table>
            </div>
        </form>
        
    </body>
</html>

            
