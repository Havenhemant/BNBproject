<?php

include "config.php"; 
$DBC = mysqli_connect("127.0.0.1", DBUSER, DBPASSWORD, DBDATABASE);

if (mysqli_connect_errno()) {
    echo "Error: Unable to connect to MySQL. ".mysqli_connect_error();
    exit; 
}

if (isset($_POST["from_date"], $_POST["to_date"])) {
    $orderData = "";

 
    $from_date = mysqli_real_escape_string($DBC, $_POST["from_date"]);
    $to_date = mysqli_real_escape_string($DBC, $_POST["to_date"]);

   
    $query = "
        SELECT b.bookingid, r.roomname, r.roomtype, r.beds
        FROM booking b
        JOIN room r ON b.roomid = r.roomid
        WHERE b.checkin_date BETWEEN '$from_date' AND '$to_date'
    ";
    $result = mysqli_query($DBC, $query);

    $orderData .= '
    <table class="table table-bordered">
    <tr>
    <th width="20%">Booking Detail</th>
    <th width="80%">Room Name, Room Type, Beds</th>
    </tr>';

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $orderData .= '
            <tr>
            <td>' . htmlspecialchars($row["bookingid"]) . '</td>
            <td>' . htmlspecialchars($row["roomname"] . ', ' . $row["roomtype"] . ', ' . $row["beds"]) . '</td>
            </tr>';
        }
    } else {
        $orderData .= '
        <tr>
        <td colspan="2">No bookings found</td>
        </tr>';
    }
    $orderData .= '</table>';
    echo $orderData;
}
?>
