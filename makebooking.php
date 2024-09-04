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


$query = "
    SELECT room.roomID, room.roomname, room.roomtype, room.beds 
    FROM room 
    LEFT JOIN booking ON room.roomID = booking.roomID 
    WHERE booking.roomID IS NULL
";
$result = mysqli_query($DBC, $query);

$options = "";
while ($row2 = mysqli_fetch_array($result)) {
    $options .= "<option value='{$row2['roomID']}'>{$row2['roomname']}, {$row2['roomtype']}, {$row2['beds']} beds</option>";
}


$query_cust = "SELECT customerID, firstname, lastname FROM customer";
$result_cust = mysqli_query($DBC, $query_cust);
$customer_options = "";
while ($row_cust = mysqli_fetch_array($result_cust)) {
    $customer_options .= "<option value='{$row_cust['customerID']}'>{$row_cust['firstname']} {$row_cust['lastname']}</option>";
}

if (isset($_POST['submit'])) {
    $roomID = $_POST['select1'];  // Room ID selected from the dropdown
    $customerID = $_POST['customer']; // Customer ID selected from the dropdown
    $checkin_date = $_POST['datepicker'];
    $checkout_date = $_POST['datepicker1'];
    $contact = $_POST['contact'];
    $booking_extras = $_POST['booking_extras'];

    // Inserting the booking details into the database
    $sql1 = "INSERT INTO booking (roomID, customerID, checkin_date, checkout_date, contact, booking_extras) 
             VALUES ('$roomID', '$customerID', '$checkin_date', '$checkout_date', '$contact', '$booking_extras')";
    $resu = mysqli_query($DBC, $sql1);

    if (!$resu) {
        echo "Error: " . mysqli_error($DBC);
    } else {
        echo "Booking successfully added!";
    }
}
?>
<?php


$query = "
    SELECT b.bookingid, r.roomname, r.roomtype, r.beds
    FROM booking b
    JOIN room r ON b.roomid = r.roomid
    ORDER BY b.bookingid DESC
";
$result = mysqli_query($DBC, $query);
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
    <title>Make a Booking</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script>
        $(function() {
            $("#datepicker").datepicker({ dateFormat: 'yy-mm-dd' });
            $("#datepicker1").datepicker({ dateFormat: 'yy-mm-dd' });
        });
        $(document).ready(function () {
        $('.dateFilter').datepicker({
            dateFormat: "yy-mm-dd"
        });

        $('#btn_search').click(function () {
            var from_date = $('#from_date').val();
            var to_date = $('#to_date').val();
            if (from_date != '' && to_date != '') {
                $.ajax({
                    url: "action.php",
                    method: "POST",
                    data: { from_date: from_date, to_date: to_date },
                    success: function (data) {
                        $('#purchase_order').html(data);
                    }
                });
            } else {
                alert("Please Select the Date");
            }
        });
    });
    </script>
</head>
<body>
    <h1>Make a booking</h1>
    <h2><a href='listbookings.php'>[Return to the Bookings listing]</a><a href='/bnb/'>[Return to the main page]</a></h2>

    <form action="makebooking.php" method="post">
        <p>
            <label for="roomdetail">Room (name, type, beds): </label>
            <select name="select1">
                <?php echo $options; ?>
            </select>
        </p>

        <p>
            <label for="customer">Customer: </label>
            <select name="customer">
                <?php echo $customer_options; ?>
            </select>
        </p>
        
        <p><label for="Checkin date">Checkin date: </label>
        <input type="text" name="datepicker" id="datepicker" placeholder="yyyy-mm-dd" required></p>

        <p><label for="Checkout date">Checkout date: </label>
        <input type="text" name="datepicker1" id="datepicker1" placeholder="yyyy-mm-dd" required></p>

        <p>
            <label for="Contact number">Contact number: </label>
            <input type="text" placeholder="(###) ### ####" id="contact" name="contact" 
                   pattern="^(\+\d{1,2}\s)?\(?\d{3}\)?[\s.-]\d{3}[\s.-]\d{4}$" required>
        </p>

        <p>
            <label for="Booking extras">Booking extras: </label>
            <textarea cols="22" rows="8" id="booking_extras" name="booking_extras" required></textarea>
        </p>

        <input type="submit" name="submit" value="Add">
        <a href="listbookings.php">[Cancel]</a>
    </form>
    <div class="container">
        <h1>Current Bookings</h1>

        <h4>Search for Booking Room</h4>
        <br>
        <div class="row">
            <div class="col-md-2">
                <input type="text" name="from_date" id="from_date" class="form-control dateFilter" placeholder="From Date" />
            </div>
            <div class="col-md-2">
                <input type="text" name="to_date" id="to_date" class="form-control dateFilter" placeholder="To Date" />
            </div>
            <div class="col-md-2">
                <input type="button" name="search" id="btn_search" value="Search" class="btn btn-primary" />
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-8">
                <div id="purchase_order">
                    <table class="table table-bordered">
                        <tr>
                            <th width="20%">Booking ID</th>
                            <th width="80%">Room Name, Room Type, Beds</th>
                        </tr>
                        <?php
                        while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row["bookingid"]); ?></td>
                                <td><?php echo htmlspecialchars($row["roomname"] . ', ' . $row["roomtype"] . ', ' . $row["beds"]); ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

