<?php
include "checksession.php";
checkUser();
loginStatus(); 
?>

<!DOCTYPE HTML>
<html>
<head>
  <style>
      body {
          font-weight: bold;
      }
  </style>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Edit a booking</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
  <script>
  $(function() {
    $("#datepicker").datepicker({ dateFormat: 'yy-mm-dd' });
    $("#datepicker1").datepicker({ dateFormat: 'yy-mm-dd' });
  });
  </script>
</head>
<body>
  <h1>Edit a booking</h1>
  <h2>
    <a href='listbookings.php'>[Return to the Bookings listing]</a>
    <a href='/bnb/'>[Return to the main page]</a>
  </h2>

  <?php
  include "config.php"; 
  $DBC = mysqli_connect("127.0.0.1", DBUSER, DBPASSWORD, DBDATABASE);

  if (mysqli_connect_errno()) {
    echo "Error: Unable to connect to MySQL. " . mysqli_connect_error();
    exit; 
  }

  $id = $_GET['bookingid'];

  
  $query = "SELECT * FROM booking WHERE bookingid=?";
  $stmt = mysqli_prepare($DBC, $query);
  mysqli_stmt_bind_param($stmt, 'i', $id);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $booking = mysqli_fetch_assoc($result);

  if (!$booking) {
    echo "<p>Booking not found!</p>";
    exit;
  }

  
  $query1 = "SELECT * FROM room";
  $result1 = mysqli_query($DBC, $query1);
  $options = "";
  while ($row2 = mysqli_fetch_array($result1)) {
    $selected = ($row2['roomID'] == $booking['roomID']) ? ' selected' : '';
    $options .= "<option value='{$row2['roomID']}'{$selected}>{$row2['roomname']}, {$row2['roomtype']}, {$row2['beds']} beds</option>";
  }

  // Update booking details
  if (isset($_POST['submit'])) {
    $roomdetail = $_POST['roomdetail'];
    $checkin_date = $_POST['checkin_date'];
    $checkout_date = $_POST['checkout_date'];
    $contact = $_POST['contact'];
    $booking_extras = $_POST['booking_extras'];
    $booking_review = $_POST['booking_review'];

    $query1 = "UPDATE booking SET roomID=?, checkin_date=?, checkout_date=?, contact=?, booking_extras=?, booking_review=? WHERE bookingid=?";
    $stmt = mysqli_prepare($DBC, $query1);
    mysqli_stmt_bind_param($stmt, 'isssssi', $roomdetail, $checkin_date, $checkout_date, $contact, $booking_extras, $booking_review, $id);

    if (mysqli_stmt_execute($stmt)) {
      header('Location: listbookings.php');
      exit;
    } else {
      echo "<p>Error updating booking: " . mysqli_error($DBC) . "</p>";
    }
  }
  ?>

  <form method="POST" action="">
    <p>
      <label for="roomdetail">Room (name, type, beds): </label>
      <select name="roomdetail">
        <?php echo $options; ?>
      </select>
    </p>
    <p>
      <label for="Checkin date">Checkin date: </label>
      <input type="text" id="datepicker" name="checkin_date" placeholder="yyyy-mm-dd" value="<?php echo $booking['checkin_date']; ?>" required>
    </p>
    <p>
      <label for="Checkout date">Checkout date: </label>
      <input type="text" id="datepicker1" name="checkout_date" placeholder="yyyy-mm-dd" value="<?php echo $booking['checkout_date']; ?>" required>
    </p>
    <p>
      <label for="Contact number">Contact number: </label>
      <input type="text" id="phonenumber" name="contact" placeholder="(###) ### ####" minlength="5" maxlength="50" pattern="^(\+\d{1,2}\s)?\(?\d{3}\)?[\s.-]\d{3}[\s.-]\d{4}$" value="<?php echo $booking['contact']; ?>" required>
    </p>
    <p>
      <label for="Booking extras">Booking extras: </label>
      <textarea cols="22" rows="8" name="booking_extras"><?php echo $booking['booking_extras']; ?></textarea>
    </p>
    <p>
      <label for="Room review">Room review: </label>
      <textarea cols="22" rows="8" name="booking_review"><?php echo $booking['booking_review']; ?></textarea>
    </p>
    <input type="submit" name="submit" value="Update">
    <a href="/bnb/">[Cancel]</a>
  </form>

</body>
</html>
