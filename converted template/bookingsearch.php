<?php

include "config.php"; 
$DBC = mysqli_connect("127.0.0.1", DBUSER, DBPASSWORD, DBDATABASE);

if (mysqli_connect_errno()) {
    echo "Error: Unable to connect to MySQL. ".mysqli_connect_error();
    exit; 
}


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
    <title>Date Range Search</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script>
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
    <div class="container">
        <h1>Current Bookings</h1>
        <h2>
            <a href='makebooking.php'>[Make a booking]</a>
            <a href="/bnb/">[Return to main page]</a>
        </h2>
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
