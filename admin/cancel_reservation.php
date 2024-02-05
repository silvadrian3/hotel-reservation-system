<?php
include "../connection.php";
include "../session.php";

if(isset($_GET["id"]) && !empty($_GET["id"])){
    $reservation_id = $_GET["id"];
    $reservation_id = mysqli_real_escape_string($connection, $reservation_id);
        
    $updateReservation = mysqli_query($connection, "UPDATE `reservations` SET status = 'Cancelled' WHERE id = '" . $reservation_id . "'");
    
    if($updateReservation){
        
        $getReservationDetails = mysqli_query($connection, "SELECT customer_id, room_id FROM `reservations` WHERE id = '" . $reservation_id . "'");
            
        if(mysqli_num_rows($getReservationDetails) != 0) {
            $fetchReservationDetails = mysqli_fetch_array($getReservationDetails);
            $room_id = $fetchReservationDetails['room_id'];

            $updateRoom = mysqli_query($connection, "UPDATE `rooms` SET status = 'Available' WHERE id = '" . $room_id . "'");

            if($updateRoom){
                echo "<script>";
                echo "alert('Reservation successfully cancelled.');";
                echo "window.location = 'index.php';";
                echo "</script>";
            } else {
                die(mysqli_error($connection));    
            }
        }
        
    } else {
        die(mysqli_error($connection));
    }
}

?>
