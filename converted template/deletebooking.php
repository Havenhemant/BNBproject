<?php
include "checksession.php";
checkUser();
loginStatus(); 
?>

<?php
include "config.php"; 
$DBC = mysqli_connect("127.0.0.1", DBUSER, DBPASSWORD, DBDATABASE);


if (mysqli_connect_errno()) {
    echo "Error: Unable to connect to MySQL. ".mysqli_connect_error();
    exit; 
}


$id = intval($_GET['bookingid']); 


$query = '
    SELECT b.bookingid, b.checkin_date, b.checkout_date, b.contact, b.booking_extras, 
           r.roomname, r.roomtype, r.beds
    FROM booking b
    JOIN room r ON b.roomid = r.roomid
    WHERE b.bookingid = ?
';
$stmt = mysqli_prepare($DBC, $query);
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$rowcount = mysqli_num_rows($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $del_query = 'DELETE FROM booking WHERE bookingid = ?';
    $del_stmt = mysqli_prepare($DBC, $del_query);
    mysqli_stmt_bind_param($del_stmt, 'i', $id);
    if (mysqli_stmt_execute($del_stmt)) {
        echo "<p>Data Deleted Successfully</p>";
        
        header('Location: listbookings.php');
        exit;
    } else {
        echo "<p>Failed to delete booking.</p>";
    }
    mysqli_stmt_close($del_stmt);
}

mysqli_stmt_close($stmt);
mysqli_close($DBC); 
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Delete Booking</title> 
</head>
<body>
<h1>Booking Preview Before Deletion</h1>
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
    echo '</dl></fieldset>'.PHP_EOL;  
} else {
    echo "<h2>No booking found!</h2>"; 
}
?>

<form method="post" action="">
    <p>
        <button type="submit" name="delete">Delete</button>
        <a href="/bnb/">[Cancel]</a>
    </p>
</form>

</body>
</html>
