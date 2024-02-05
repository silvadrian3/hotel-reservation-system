<?php
include "../connection.php";
include "../session.php";
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
                    Hi <?php echo $_SESSION["username"]; ?>, Welcome to Online Hotel Reservation!<br/><br/>
                    <a href="../logout.php">Log Out</a>
                </p>
            </div>
            
            <table class="nav">
                <tr>
                    <td class="links title">
                        <span onclick="window.location = 'index.php'">Online Hotel Reservation</span>
                    </td>
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
                <h2>Create Room</h2>
                <table>
                    <tr>
                        <td width="30%">
                            <p>Room Number <font color="red">*</font></p>
                        </td>
                        <td width="70%">
                            <input type="text" name="room_no" id="room_no" class="field" required>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>Room Type <font color="red">*</font></p>
                        </td>
                        <td>
                            <select name="room_type" id="room_type" class="field" required>
                                <option value=""> - - - Please Select - - - </option>
                                <option value="Single"> Single Bed </option>
                                <option value="Double"> Double Bed </option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top">
                            <p>Description</p>
                        </td>
                        <td>
                            <textarea name="description" id="description" class="field" rows="7"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Room Picture
                        </td>
                        <td>
                            <input type="file" name="room_picture" id="room_picture">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="submit" class="btn" name="submit" value="Save">
                        </td>
                    </tr>
                </table>
            </div>
        </form>
   
    </body>
</html>

<?php


if(isset($_POST["submit"])) {
    
    $room_no = $_POST['room_no'];
    $description = $_POST['description'];
    $room_type = $_POST['room_type'];
    $target_dir = "../images/rooms/";
    $filename = "";
    $state = true;
    
    if(basename($_FILES["room_picture"]["name"]) != ""){
        
        $filename = date('ymdHis') . basename($_FILES["room_picture"]["name"]);
        $target_file = $target_dir . $filename;
        
        if(!move_uploaded_file($_FILES["room_picture"]["tmp_name"], $target_file)){
            $state = false;
            echo "<script>";
            echo "alert('Sorry, there was an error uploading your file.');";
            echo "window.location = 'add_room.php';";
            echo "</script>";
        } else {
            
            $state = true;
        }
    }
    
    if($state == true){
        $room_no = mysqli_real_escape_string($connection, $room_no);
        $description = mysqli_real_escape_string($connection, $description);
        $room_type = mysqli_real_escape_string($connection, $room_type);
        $filename = mysqli_real_escape_string($connection, $filename);
        
        $insertRoom = mysqli_query($connection, "INSERT INTO `rooms` (room_number, description, type, status) VALUES ('" . $room_no . "', '" . $description . "', '".$room_type."', 'Available')");
        
        if($insertRoom){
            $room_id = mysqli_insert_id($connection);
            $insertRoomImage = mysqli_query($connection, "INSERT INTO `room_images` (room_id, url) VALUES ('" . $room_id . "', '" . $filename . "')");
            
            if($insertRoomImage){
                echo "<script>";
                echo "alert('Room successfully added.');";
                echo "window.location = 'rooms.php';";
                echo "</script>";
            } else {
                die(mysqli_error($connection));    
            }
            
        } else {
            die(mysqli_error($connection));
        }
    }
    
}

?>