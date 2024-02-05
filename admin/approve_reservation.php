<?php
include "../connection.php";
include "../session.php";

if(isset($_GET["id"]) && !empty($_GET["id"])){
    $reservation_id = $_GET["id"];
    $reservation_id = mysqli_real_escape_string($connection, $reservation_id);
    $url = '';
    
    $getReservationDetails = mysqli_query($connection, "SELECT a.id as reservation_id, a.start_date, a.end_date, a.payment_term, a.bank_name, a.control_number, a.receipt_image, a.status, b.firstname, b.lastname, b.email, b.contact_no, c.room_number, c.description FROM `reservations` as a INNER JOIN `customers` as b ON (a.customer_id = b.id) INNER JOIN `rooms` as c ON (a.room_id = c.id) WHERE a.id = '".$reservation_id."'");
    
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
            $control_number = stripslashes($fetchReservationDetails["control_number"]);
            
            if($fetchReservationDetails['receipt_image'] != ""){
                $url = "<img src='../images/receipts/".$fetchReservationDetails['receipt_image']."' width='600px' height='400px' />";    
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
        <form method="POST" enctype="multipart/form-data">
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
                <h2>Approve Reservation</h2>
                <table>
                    
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
                    
                        if($control_number != ''){
                    ?>
                    <tr>
                        <td valign="top">
                            <p>Control No.</p>
                        </td>
                        <td>
                            <p><?php echo $control_number; ?></p>
                        </td>
                    </tr>
                    <?php
                        }
                    
                        if($url != ''){
                    ?>
                    <tr>
                        <td colspan="2">
                            <p>Receipt</p>
                            <br/>
                            <?php echo $url; ?>
                        </td>
                    </tr>
                    <?php
                        }
                    ?>
                    
                    
                    <tr>
                        <td valign="top">
                            <p>Total Amount</p>
                        </td>
                        <td>
                            <input type="number" name="total_amount" id="total_amount" class="field" required>
                        </td>
                    </tr>
                    
                    <tr>
                        <td colspan="2">
						    <input type="button" class="btn" name="back" style="width:80px" onclick="window.location = 'index.php'"()" value="Back">
                            <input type="submit" class="btn" name="submit" value="Submit">
                        </td>
                    </tr>
                    
                </table>
            </div>
        </form>
        
    </body>

</html>

<?php

if(isset($_POST['submit'])){
        
        $total_amount = mysqli_real_escape_string($connection, $_POST['total_amount']);
        
        $updateReservation = mysqli_query($connection, "UPDATE `reservations` SET status = 'Approved' WHERE id = '" . $reservation_id . "'");
    
        if($updateReservation){

            $updateTransaction = mysqli_query($connection, "UPDATE `transactions` SET check_in_date = '". date('Y-m-d') ."', total_amount = '". $total_amount ."', status = 'Paid' WHERE reservation_id = '" . $reservation_id . "'");

            if($updateTransaction){
                echo "<script>";
                echo "alert('Reservation successfully approved.');";
                echo "window.location = 'index.php';";
                echo "</script>";
            } else {
                die(mysqli_error($connection));    
            }

        } else {
            die(mysqli_error($connection));
        }
    
}
?>