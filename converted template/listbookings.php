<?php
include "checksession.php";
checkUser();
loginStatus(); 
?>

<!DOCTYPE HTML>
<html><head><title>Current Bookings</title></head>
 <body>
<h1>Current bookings</h1>
<h2><a href='makebooking.php'>[Make a booking]</a><a href="/bnb/">[Return to main page]</a><a href="bookingsearch.php">[Search Current Booking]</a></h2>
<table border="1">
<thead><tr><th>Booking (Room, Dates)</th><th>Customer</th><th>Action</th></tr></thead>
<?php
include "config.php"; 
$DBC = mysqli_connect("127.0.0.1", DBUSER, DBPASSWORD, DBDATABASE);


if (mysqli_connect_errno()) {
    echo "Error: Unable to connect to MySQL. ".mysqli_connect_error() ;
    exit; 
}


$query = 'SELECT booking.bookingid, booking.checkin_date, booking.checkout_date, 
                 room.roomname, room.roomtype, room.beds, 
                 customer.firstname, customer.lastname 
          FROM booking 
          JOIN room ON booking.roomid = room.roomid
          JOIN customer ON booking.customerID = customer.customerID
          ORDER BY booking.bookingid';

$result = mysqli_query($DBC,$query);
$rowcount = mysqli_num_rows($result); 

if ($rowcount > 0) {  
    while ($row = mysqli_fetch_array($result)) {
	  $id = $row['bookingid'];	
	  $roomdetail = $row['roomname'].', '.$row['roomtype'].', '.$row['beds'].' beds';
	  echo '<tr><td>'.$roomdetail.', '.$row['checkin_date'].', '.$row['checkout_date'].'</td><td>'.$row['firstname'].' '.$row['lastname'].'</td>';
	  echo '<td><a href="viewbookingdetail.php?bookingid='.$id.'">[view]</a>';
	  echo '<a href="editbooking.php?bookingid='.$id.'">[edit]</a>';
	  echo '<a href="bookingpreview.php?bookingid='.$id.'">[manage reviews]</a>';
	  echo '<a href="deletebooking.php?bookingid='.$id.'">[delete]</a></td>';
      echo '</tr>'.PHP_EOL;
   }
} else {
    echo "<h2>No bookings found!</h2>";
}

mysqli_free_result($result); 
mysqli_close($DBC); 
?>
</table>
</body>
</html>
