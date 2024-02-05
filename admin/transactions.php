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
                            <a href="index.php">Reservations</a>
                        </td>
                        <td class="links">
                            <a href="rooms.php">Rooms</a>
                        </td>
                        <td class="links">
                            <a href="transactions.php"><b>Transactions</b></a>
                        </td>
                    </tr>
                    </table>
                </td>
                
            </tr>
            </table>
            
            <table class="tbl_RecordList" cellpadding="0" cellspacing="0">
                <tr style="background: #fcfcfc">
                    <th width='5%'>ID</th>
                    <th width='25%'>Customer Name</th>
                    <th width='10%'>Room No.</th>
                    <th width='15%'>Check-in</th>
                    <th width='15%'>Check-out</th>
                    <th width='15%'>Amount Paid</th>
                    <th width='15%'>Status</th>
                </tr>
            
            <?php
            
            $getTransactions = mysqli_query($connection, "SELECT a.id as reservation_id, b.firstname, b.lastname, b.email, c.room_number, c.description, d.total_amount, d.check_in_date, d.check_out_date, d.status FROM `reservations` as a INNER JOIN `customers` as b ON (a.customer_id = b.id) INNER JOIN `rooms` as c ON (a.room_id = c.id) INNER JOIN `transactions` as d ON (a.id = d.reservation_id) WHERE a.status <> 'Cancelled'");
                
                if(mysqli_num_rows($getTransactions) != 0){
                    while($fetchTransactions = mysqli_fetch_array($getTransactions)){
                        echo "<tr>";
                        echo "<td align='center'>". $fetchTransactions["reservation_id"] ."</td>";
                        echo "<td align='center'>". $fetchTransactions["firstname"] . ' ' . $fetchTransactions["lastname"] ."</td>";
                        echo "<td align='center'>". $fetchTransactions["room_number"] ."</td>";
                        echo "<td align='center'>";
                            if($fetchTransactions["check_in_date"] != "" && $fetchTransactions["check_in_date"] != "0000-00-00"){
                                echo date('Y-m-d', strtotime($fetchTransactions["check_in_date"]));
                            }
                        echo "</td>";
                        
                        echo "<td align='center'>";
                            if($fetchTransactions["check_out_date"] != "" && $fetchTransactions["check_out_date"] != "0000-00-00"){
                                echo date('Y-m-d', strtotime($fetchTransactions["check_out_date"]));
                            }
                        echo "</td>";
                        
                        echo "<td align='center'>P ". number_format($fetchTransactions["total_amount"], 2,'.', ',') ."</td>";
                        echo "<td align='center'>". $fetchTransactions["status"] ."</td>";
                        echo "</tr>";
                    }
                    
                } else {
                    echo "<tr><td colspan='7'>No record found.</td></tr>";
                }
            
            ?>
            
            
            <br/><br/>
            </table>
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
           

