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
    $getRoomDetails = mysqli_query($connection, "SELECT id as room_id, room_number, description, type, status FROM `rooms` WHERE id = '".$room_id."'");
    
    if(mysqli_num_rows($getRoomDetails)!=0){
        while($fetchRoomDetails = mysqli_fetch_array($getRoomDetails)){
            $room_id = stripslashes($fetchRoomDetails["room_id"]);
            $room_number = stripslashes($fetchRoomDetails["room_number"]);
            $description = stripslashes($fetchRoomDetails["description"]);
            $room_type = stripslashes($fetchRoomDetails["type"]);
            $status = stripslashes($fetchRoomDetails["status"]);
            
            
            $getRoomImage = mysqli_query($connection, "SELECT * FROM `room_images` WHERE room_id = '".$room_id."'");
                        
            if(mysqli_num_rows($getRoomImage) != 0){
                while($fetchRoomImage = mysqli_fetch_array($getRoomImage)){
                    
                    if($fetchRoomImage['url'] != ""){
                        $url = "<img src='../images/rooms/".$fetchRoomImage['url']."' width='600px' height='400px' />";    
                    }
                    
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
        <form method="POST" enctype="multipart/form-data">
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
                <h2>Update Room</h2>
                <table>
                    <tr>
                        <td width="30%">
                            <p>Room Number <font color="red">*</font></p>
                        </td>
                        <td width="70%">
                            <input type="text" name="room_no" id="room_no" class="field" value="<?php echo $room_number; ?>" required>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            <p>Room Type <font color="red">*</font></p>
                        </td>
                        <td>
                            <select name="room_type" id="room_type" class="field" required>
                                <option value=""> - - - Please Select - - - </option>
                                <option value="Single" <?php echo $room_type == 'Single' ? 'selected' : '' ?>> Single Bed </option>
                                <option value="Double" <?php echo $room_type == 'Double' ? 'selected' : '' ?>> Double Bed </option>
                            </select>
                        </td>
                    </tr>
                    
                    <tr>
                        <td valign="top">
                            <p>Description</p>
                        </td>
                        <td>
                            <textarea name="description" id="description" class="field" rows="7"><?php echo $description; ?></textarea>
                        </td>
                    </tr>
                    
                    
                    
                    <tr>
                        <td valign="top">
                            Room Picture
                        </td>
                        <td>
                            <div id="pictureviewer">
                            <?php 
                                
                                if($url == ""){
                                    echo '<i>No picture available.</i>';
                                } else {
                                    echo $url;
                                }
                            ?>
                            <br/>
                            <input type="button" name="changepicture" id="changepicture" value="Change Picture" onclick="changePicture()" class="btn">
                            </div>
                            <div id="pictureuploader" style="display:none">
                            <input type="file" name="room_picture" id="room_picture">
                            </div>
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

<script type="text/javascript">
    function changePicture(){
        document.getElementById('pictureuploader').style.display = 'block';
        document.getElementById('pictureviewer').style.display = 'none';
    }
</script>
            
<?php


if(isset($_POST["submit"])) {
    $state = false;
    $room_no = $_POST['room_no'];
    $description = $_POST['description'];
    $room_type = $_POST['room_type'];
    
    $room_no = mysqli_real_escape_string($connection, $room_no);
    $description = mysqli_real_escape_string($connection, $description);
    $room_type = mysqli_real_escape_string($connection, $room_type);
    
    $updateRoom = mysqli_query($connection, "UPDATE `rooms` SET room_number = '".$room_no."', description = '".$description."', type = '".$room_type."' WHERE id = '".$room_id."'");
        
    if($updateRoom){
        
        $state = true;
        if(basename($_FILES["room_picture"]["name"]) != "" && basename($_FILES["room_picture"]["name"]) != null){
            $target_dir = "../images/rooms/";
            $filename = date('ymdHis') . basename($_FILES["room_picture"]["name"]);
            $target_file = $target_dir . $filename;    
            
            if (move_uploaded_file($_FILES["room_picture"]["tmp_name"], $target_file)) {
                $filename = mysqli_real_escape_string($connection, $filename);
                $updateRoomImage = mysqli_query($connection, "UPDATE `room_images` SET url = '".$filename."' WHERE room_id = '".$room_id."'");    
                
                if(!$updateRoomImage){
                    $state = false;
                    die(mysqli_error($connection));
                } else {
                    $state = true;
                }

            } else {
                echo "<script>";
                echo "alert('Sorry, there was an error uploading your file.');";
                echo "window.location = 'rooms.php';";
                echo "</script>";
            }
        }
        
    } else {
        $state = false;
        die(mysqli_error($connection));
    }
    
    if($state){
        echo "<script>";
        echo "alert('Room successfully updated.');";
        echo "window.location = 'rooms.php';";
        echo "</script>";    
    }
}

?>
            
    </body>
</html>

