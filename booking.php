<?php
include "connection.php";

session_start();
$isLogged = false;

if(isset($_SESSION['email'])){
    $checkIfLogged = mysqli_query($connection, "SELECT id as user_id FROM `users` WHERE email = '".$_SESSION['email']."' AND type = 'customer'");
    
    if(mysqli_num_rows($checkIfLogged) != 0){
        $user_id = $_SESSION['user_id'];
        $isLogged = true;
    } else {
        header('Location: login.php');
    }
}

$room_id = '';
$room_number = '';
$description = '';

if(isset($_GET["room_id"]) && !empty($_GET["room_id"])){
    $room_id = $_GET["room_id"];
    $room_id = mysqli_real_escape_string($connection, $room_id);
    $getRoomDetails = mysqli_query($connection, "SELECT id as room_id, room_number, description, status, type FROM `rooms` WHERE id = '".$room_id."'");
    
    if(mysqli_num_rows($getRoomDetails)!=0){
        while($fetchRoomDetails = mysqli_fetch_array($getRoomDetails)){
            $room_number = stripslashes($fetchRoomDetails["room_number"]);
            $description = stripslashes($fetchRoomDetails["description"]);
            $type = stripslashes($fetchRoomDetails["type"]);
        }
    }
}

$getCustomer = mysqli_query($connection, "SELECT id FROM `customers` WHERE user_id = '".$user_id."'");

if(mysqli_num_rows($getCustomer)!=0){
    $fetchCustomer = mysqli_fetch_array($getCustomer);
    $customer_id = $fetchCustomer['id'];
}

$currentDateTime = date("Y-m-d") . 'T'. date("H:i:s");
?>


<html>
    <head>
        <title>Online Hotel Reservation</title>
        <link rel="stylesheet" href="style.css" type="text/css" />
    </head>
    <body>
        <form method="POST" enctype="multipart/form-data">
            
            <div class="view_table">
                <h2>Reservation Details</h2>
                <table>
                    <tr>
                        <td colspan="2">
                            <b>Room Details</b>
                        </td>
                    </tr>
                    
                    <tr>
                        
                        <td width="35%">
                            <p>Room Number</p>
                        </td>
                        <td width="65%">
                            <b><?php echo $room_number; ?></b>
                        </td>
                    </tr>
                    
                    
                    <tr>
                        <td valign="top">
                            <p>Description</p>
                        </td>
                        <td>
                            <b><?php echo $description; ?></b>
                        </td>
                    </tr>
                    
                    <tr>
                        <td valign="top">
                            <p>Room Type</p>
                        </td>
                        <td>
                            <b><?php echo $type; ?></b>
                        </td>
                    </tr>
                    
                    
                    
                    <tr>
                        <td colspan="2">
                            <b>Booking Details</b>
                        </td>
                    </tr>
                    
                    <tr>
                        <td colspan="2">
                            <b>Date of Stay</b>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>Start Date <font color="red">*</font></p>
                        </td>
                        <td>
                            <input type="datetime-local" class="field" name="start_date" id="start_date" value="<?php echo $currentDateTime; ?>" min="<?php echo $currentDateTime; ?>" required>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>End Date <font color="red">*</font></p>
                        </td>
                        <td>
                            <input type="datetime-local" class="field" name="end_date" id="end_date" value="<?php echo $currentDateTime; ?>" min="<?php echo $currentDateTime; ?>" required>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            <p>Room Rates</p>
                        </td>
                        
                    <?php
                    
                    if($type == "Single"){
                        
                    ?>
                        <td>
                            <select name="room_rates">
                                <option value=""> – - - Please Select - - - </option>
                                <option value="250 – 3hrs">250 – 3hrs</option>
                                <option value="400 – 6hrs">400 – 6hrs</option>
                            </select>
                        </td>
                    <?php
                    } else if($type == "Double"){
                    
                    ?>
                        <td>
                            <select name="room_rates">
                                <option value=""> – - - Please Select - - - </option>
                                <option value="350 – 3hrs">350 – 3hrs</option>
                                <option value="500 – 6hrs">500 – 6hrs</option>
                            </select>
                        </td>
                    <?php
                    }
                    ?>
                    </tr>
                    
                    <tr>
                        <td>
                            <p>Payment Method <font color="red">*</font></p>
                        </td>
                        <td>
                            <select name="payment_term" id="payment_term" class="field" onchange="change_paymentterm()" required>
                                <option value=""> - - - Please Select - - - </option>
                                <option value="On-Site">On-Site</option>
                                <option value="Bank">Bank</option>
                                <option value="Cebuana Lhuillier">Cebuana Lhuillier</option>
                                <option value="Palawan Express">Palawan Express</option>
                                <option value="ML Padala">ML Padala</option>
                                <option value="Smart Padala">Smart Padala</option>
                            </select>
                        </td>
                    </tr>
                    
                    <tr id="tr_bank_name" style="display:none">
                        <td>
                            <p>Bank Name<font color="red">*</font></p>
                        </td>
                        <td>
                            <select name="bank_name" id="bank_name" class="field">
                                <option value=""> - - - Please Select - - - </option>
                                <option value="Bank of the Philippine Islands">Bank of the Philippine Islands</option>
                                <option value="Banco de Oro">Banco de Oro</option>
                                <option value="Security Bank">Security Bank</option>
                                <option value="Philippine National Bank">Philippine National Bank</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="button" class="btn" name="back" style="width:110px" onclick="back_to_home()" value="Back">
                            <input type="submit" class="btn" name="submit" style="width:110px" value="Book Now!">
                        </td>
                    </tr>
                    
                </table>
            </div>
        </form>
        
        <script type="text/javascript">
            function change_paymentterm(){
                
                var payment_term = document.getElementById('payment_term').value;
                
                if (payment_term == "Bank"){
                    document.getElementById('tr_bank_name').style.display = '';
                    document.getElementById('tr_bank_name').setAttribute("required", true);
                } else {
                    document.getElementById('tr_bank_name').removeAttribute("required");
                }

            }
            
            function back_to_home(){
                window.location = "index.php";
            }
        </script>

            
<?php


if(isset($_POST["submit"])) {
    $customer_id = $customer_id;
    
    $startdate = date('Y-m-d H:i:s', strtotime($_POST['start_date']));
    $enddate = date('Y-m-d H:i:s', strtotime($_POST['end_date']));
    $payment_term = mysqli_real_escape_string($connection, $_POST['payment_term']);
    $bank_name = mysqli_real_escape_string($connection, $_POST['bank_name']);
    $room_rates = mysqli_real_escape_string($connection, $_POST['room_rates']);
    $room_id = mysqli_real_escape_string($connection, $room_id);

        $insertReservation = mysqli_query($connection, "INSERT INTO `reservations` (customer_id, room_id, start_date, end_date, room_rates, reservation_date, payment_term, bank_name, status) VALUES ('" . $customer_id . "', '" . $room_id . "', '".$startdate."', '".$enddate."', '".$room_rates."', '".date('Y-m-d')."', '".$payment_term."', '".$bank_name."', 'Pending')");

        if($insertReservation){
            $reservation_id = mysqli_insert_id($connection);

            $insertTransaction = mysqli_query($connection, "INSERT INTO `transactions` (reservation_id, status) VALUES ('" . $reservation_id . "', 'Not Paid')");

            if($insertTransaction){
                $updateRoom = mysqli_query($connection, "UPDATE `rooms` SET status = 'Reserved' WHERE id = '".$room_id."'");

                if($updateRoom){
                    echo "<script>";
                    echo "alert('Room successfully booked.');";
                    echo "window.location = 'summary.php?id=".$reservation_id."';";
                    echo "</script>";        
                }

            } else {
                die(mysqli_error($connection));    
            }

        } else {
            die(mysqli_error($connection));
        }

    
    
    
    
    
    
}

?>
            
    </body>
</html>



