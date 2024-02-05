<?php
include "connection.php";

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
        
    $getReservationDetails = mysqli_query($connection, "SELECT a.id as reservation_id, a.start_date, a.end_date, a.room_rates, a.payment_term, a.bank_name, a.status, b.firstname, b.lastname, b.email, b.contact_no, c.room_number, c.description, c.type FROM `reservations` as a INNER JOIN `customers` as b ON (a.customer_id = b.id) INNER JOIN `rooms` as c ON (a.room_id = c.id) WHERE a.id = '".$reservation_id."'");
    
    if(mysqli_num_rows($getReservationDetails)!=0){
        while($fetchUserDetails = mysqli_fetch_array($getReservationDetails)){
            $reservation_id = stripslashes($fetchUserDetails["reservation_id"]);
            $start_date = stripslashes($fetchUserDetails["start_date"]);
            $end_date = stripslashes($fetchUserDetails["end_date"]);
            $status = stripslashes($fetchUserDetails["status"]);
            $firstname = stripslashes($fetchUserDetails["firstname"]);
            $lastname = stripslashes($fetchUserDetails["lastname"]);
            $email = stripslashes($fetchUserDetails["email"]);
            $contact_no = stripslashes($fetchUserDetails["contact_no"]);
            $room_number = stripslashes($fetchUserDetails["room_number"]);
            $description = stripslashes($fetchUserDetails["description"]);
            $payment_term = stripslashes($fetchUserDetails["payment_term"]);
            $bank_name = stripslashes($fetchUserDetails["bank_name"]);
            $room_rates = stripslashes($fetchUserDetails["room_rates"]);
            $room_type = stripslashes($fetchUserDetails["type"]);
        }
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
            
            <div class="view_table">
                <h2>Reservation Details</h2>
                <table>
                    
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
                            <p><?php echo date('Y-m-d', strtotime($start_date)); ?> </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>End Date</p>
                        </td>
                        <td>
                            <p><?php echo date('Y-m-d', strtotime($end_date)); ?> </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>Room Rate</p>
                        </td>
                        <td>
                            <p><?php echo $room_rates; ?></p>
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
                        <td>
                            <p>Room Type</p>
                        </td>
                        <td>
                            <p><?php echo $room_type; ?></p>
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
                    
                    <tr>
                        <td colspan="2">
                            <input type="button" class="btn" onclick="back()" value="Back">
                        </td>
                    </tr>
                    
                    
                </table>
            </div>
        </form>
            
    <script>
        function back(){
            window.location = "index.php";
        }
    </script>
        
    </body>
</html>

            
