<?php
include "../connection.php";
include "../session.php";

if(isset($_GET["id"]) && !empty($_GET["id"])){
    $room_id = $_GET["id"];
    $room_id = mysqli_real_escape_string($connection, $room_id);
        
    $deleteRoom = mysqli_query($connection, "DELETE FROM `rooms` WHERE id = '" . $room_id . "'");
    
    if($deleteRoom){   
        $deleteRoomImage = mysqli_query($connection, "DELETE FROM `room_images` WHERE room_id = '" . $room_id . "'");
    
        if($deleteRoomImage){
            echo "<script>";
            echo "alert('Room successfully deleted.');";
            echo "window.location = 'rooms.php';";
            echo "</script>";    
        } else {
            die(mysqli_error($connection));
        }
        
    } else {
        die(mysqli_error($connection));
    }
}

?>
