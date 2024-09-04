<?php
include "checksession.php";
checkUser();
loginStatus(); 
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>View Booking</title> 
</head>
<body>
<?php
include "config.php"; 
$DBC = mysqli_connect("127.0.0.1", DBUSER, DBPASSWORD, DBDATABASE);


if (mysqli_connect_errno()) {
    echo "Error: Unable to connect to MySQL. ".mysqli_connect_error();
    exit; 

}
$id = intval($_GET['bookingid']);


$query = "
    SELECT b.bookingid, b.checkin_date, b.checkout_date, b.contact, b.booking_extras, b.booking_review,
           r.roomname, r.beds, r.roomtype
    FROM booking b
    INNER JOIN room r ON b.roomid = r.roomid
    WHERE b.bookingid='$id'
";
$result = mysqli_query($DBC, $query);
$rowcount = mysqli_num_rows($result); 
?>
<h1>Booking Details View</h1>
<h2><a href='listbookings.php'>[Return to the Booking listing]</a><a href='/bnb/'>[Return to the main page]</a></h2>
<?php


if ($rowcount > 0) {  
    echo "<fieldset><legend>Booking Detail #$id</legend><dl>"; 
    $row = mysqli_fetch_assoc($result);
    echo "<dt>Room Name:</dt><dd>".$row['roomname']."</dd>".PHP_EOL;
    echo "<dt>Room Type:</dt><dd>".$row['roomtype']."</dd>".PHP_EOL;
    echo "<dt>Beds:</dt><dd>".$row['beds']."</dd>".PHP_EOL;
    echo "<dt>Check-in Date:</dt><dd>".$row['checkin_date']."</dd>".PHP_EOL;
    echo "<dt>Checkout Date:</dt><dd>".$row['checkout_date']."</dd>".PHP_EOL;
    echo "<dt>Contact Number:</dt><dd>".$row['contact']."</dd>".PHP_EOL; 
    echo "<dt>Extras:</dt><dd>".$row['booking_extras']."</dd>".PHP_EOL; 
    echo "<dt>Room Review:</dt><dd>".$row['booking_review']."</dd>".PHP_EOL; 
    echo '</dl></fieldset>'.PHP_EOL;  
} else {
    echo "<h2>No booking found!</h2>"; 
}

mysqli_free_result($result); 
mysqli_close($DBC); 
?>
</body>
</html>
