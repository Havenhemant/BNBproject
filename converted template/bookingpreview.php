<?php
include "config.php"; //load in any variables
$DBC = mysqli_connect("127.0.0.1", DBUSER, DBPASSWORD, DBDATABASE);
if (mysqli_connect_errno()) {
    echo "Error: Unable to connect to MySQL. ".mysqli_connect_error();
    exit; //stop processing the page further
}





if(isset($_POST['submit'])){
    $booking_review=$_POST['booking_review'];
    $id = $_GET['bookingid'];

    $query1 = "UPDATE booking SET booking_review='$booking_review' WHERE bookingid='$id'";
    if(mysqli_query( $DBC, $query1 )){
        header('location:bookingpreview.php');
        echo "Data Updated Successfully";
    } else {
        echo mysqli_error ($conn);
    }
}
?>



<!DOCTYPE HTML>

<html>
<head>
<title>Booking preview</title> 
</head>
 <body>
<h1>Edit/add room review</h1>
<h2><a href='listbookings.php'>[Return to the Booking listing]</a><a href='/bnb/'>[Return to the main page]</a></h2>
<h2>Review made by Test</h2>

 
<form method="POST" action="">
  <p>
    <label for="Room review">Room review: </label>
    <textarea cols="22" rows="8" name="booking_review" required></textarea>
  </p> 
  
   <input type="submit" name="submit" value="Update">
  </form>

</body>
</html>
  