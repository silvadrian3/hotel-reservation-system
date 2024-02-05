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
        <form method="POST">
            <div class="welcome">
                <p align="right">
                    Hi <?php echo $_SESSION["username"]; ?>, Welcome to Yayadub Online Reservation<br/><br/>
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
            
            <div class="add_item" align="right">
                <input type='button' onclick='add_room()' class="btn" value='Add Room'>
            </div>
            
            <br/>
            
            <table class="tbl_RecordList" cellpadding="0" cellspacing="0">
                <tr style="background: #fcfcfc">
                    <th width='5%'>ID</th>
                    <th width='15%'>Room Number</th>
                    <th width='30%'>Description</th>
                    <th width='23%'>Picture</th>
                    <th width='10%'>Status</th>
                    <th width='17%'>Action</th>
                </tr>
            
            <?php
            
            $getRooms = mysqli_query($connection, "SELECT id as room_id, room_number, description, status FROM `rooms`");
                
                if(mysqli_num_rows($getRooms) != 0){
                    while($fetchRooms = mysqli_fetch_array($getRooms)){
                        
                        echo "<tr>";
                        echo "<td align='center'>". $fetchRooms["room_id"] ."</td>";
                        echo "<td align='center'>". $fetchRooms["room_number"] ."</td>";
                        echo "<td align='center'>". $fetchRooms["description"] ."</td>";
                        echo "<td align='center'>";
                        
                        $getRoomImage = mysqli_query($connection, "SELECT * FROM `room_images` WHERE room_id = '".$fetchRooms["room_id"]."'");
                        
                        if(mysqli_num_rows($getRoomImage) != 0){
                            while($fetchRoomImage = mysqli_fetch_array($getRoomImage)){
                                
                                if($fetchRoomImage['url'] != ""){
                                    echo "<img src='../images/rooms/".$fetchRoomImage['url']."' width='200px' height='100px' />";    
                                }
                                
                            }
                        }
                        
                        echo "</td>";
                        echo "<td align='center'>". $fetchRooms["status"] ."</td>";
                        
                        echo "<td align='center'>";
                            echo "<input type='button' class='action' onclick='view(". $fetchRooms["room_id"] .")' value='View'>";       
                            echo "<input type='button' class='action' onclick='edit(". $fetchRooms["room_id"] .")' value='Edit'>";
                            //*echo "<input type='button' class='action' onclick='remove(". $fetchRooms["room_id"] .")' value='Delete'>";*//
                        echo "</td>";
                        
                        echo "</tr>";
                    }
                    
                } else {
                    echo "<tr><td colspan='6'>No record found.</td></tr>";
                }
            
            ?>
            </table>
            
            <br/><br/>
            
        </form>
        
        <script type="text/javascript">
            function add_room(){
                window.location = "add_room.php";
            }
            
            function view(id){
                window.location = "view_room.php?id=" + id;
            }
            
            function edit(id){
                window.location = "edit_room.php?id=" + id;
            }
            
            
            function remove(id){
                if(confirm("Are you sure you want to delete this room?")){
                    window.location = "delete_room.php?id=" + id;
                }
            }
            
            
        </script>
    </body>
</html>
           

