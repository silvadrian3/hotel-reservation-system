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
            
            <table class="tbl_RecordList" cellpadding="0" cellspacing="0">
                <tr style="background: #fcfcfc">
                    <th width='5%'>ID</th>
                    <th width='20%'>Customer Name</th>
                    <th width='15%'>Room No.</th>
                    <th width='25%'>Date of Stay</th>
                    <th width='15%'>Status</th>
                    <th width='20%'>Action</th>
                </tr>
            
            <?php
            
            $getReservations = mysqli_query($connection, "SELECT a.id as reservation_id, a.start_date, a.end_date, a.status, b.firstname, b.lastname, b.email, c.room_number, c.description FROM `reservations` as a INNER JOIN `customers` as b ON (a.customer_id = b.id) INNER JOIN `rooms` as c ON (a.room_id = c.id) WHERE a.status <> 'Completed'");
                
                if(mysqli_num_rows($getReservations) != 0){
                    while($fetchReservations = mysqli_fetch_array($getReservations)){
                        echo "<tr>";
                        echo "<td align='center'>". $fetchReservations["reservation_id"] ."</td>";
                        echo "<td align='center'>". $fetchReservations["firstname"] . ' ' . $fetchReservations["lastname"] ."</td>";
                        echo "<td align='center'>". $fetchReservations["room_number"] ."</td>";
                        echo "<td align='center'>From ". date('Y-m-d', strtotime($fetchReservations["start_date"])) . ' To ' . date('Y-m-d', strtotime($fetchReservations["end_date"])) ."</td>";
                        echo "<td align='center'>". $fetchReservations["status"] ."</td>";
                        echo "<td align='center'>";
                            echo "<input type='button' class='action' onclick='view(". $fetchReservations["reservation_id"] .")' value='View'>";
                            
                        
                            if($fetchReservations["status"] == "Pending"){
                                echo "<input type='button' class='action' onclick='approve(". $fetchReservations["reservation_id"] .")' value='Approve'>";
                            }
                        
                            if($fetchReservations["status"] == "Approved"){
                                
                                echo "<input type='button' class='action' onclick='checkout(". $fetchReservations["reservation_id"] .")' value='Check Out'>";
                            }
                        
                            if($fetchReservations["status"] != "Cancelled" && $fetchReservations["status"] != "Approved"){
                                echo "<input type='button' class='action' onclick='cancel(". $fetchReservations["reservation_id"] .")' value='Cancel'>";    
                            }
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
            function view(id){
                window.location = "view_reservation.php?id=" + id;
            }
            
            function approve(id){
                window.location = "approve_reservation.php?id=" + id;
            }
            
            function cancel(id){
                if(confirm("Are you sure you want to cancel this reservation?")){
                    window.location = "cancel_reservation.php?id=" + id;
                }
            }
            
            function checkout(id){
                window.location = "checkout.php?id=" + id;
            }
            
            
        </script>
    </body>
</html>
           

