<?php
// Include the database connection file
include('../db/tdbconn.php');


// Check if the accept button is clicked and process accordingly
if (isset($_GET['accept'])) {
    // Get the bookingid from the form data
    $bookingid = $_GET['bookingid'];
    
    // Set the bookingid as a session variable
    $_SESSION['bookingid'] = $bookingid;
    
    // Redirect to accepted.php or perform other actions
    header('Location: tdisaccepted.php');
    exit; // Stop further execution of this script
}

// Query to select data from the "booking" table and join with the "commuters" table
$sql = "SELECT b.bookingid, b.toda, b.commuterid, c.firstname, b.passengercount, b.fare, b.Distance
FROM booking b
LEFT JOIN commuter c ON b.commuterid = c.commuterid
WHERE b.status = 'pending';";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data from each row
    while ($row = $result->fetch_assoc()) {
        echo "<div class='booking-info'>";
        echo "<p>Booking ID: " . $row["bookingid"] . "</p>";
        echo "<p>Commuter: " . $row["firstname"] . "</p>";
        echo "<p>Passenger Count: " . $row["passengercount"] . "</p>";
        echo "<p>Fare: ₱" . $row["fare"] . "</p>";
        echo "<p>Distance: " . number_format($row["Distance"], 3) . " km</p>";

        echo "<form action='' method='GET'>";
        // Add a hidden input field for bookingid
        echo "<input type='hidden' name='bookingid' value='" . $row["bookingid"] . "'>";
        echo "<button type='submit' name='accept' class='btn btn-default custom-btn'>
            Accept
        </button>";
        echo "</form>";

        echo "</div>";
    }
} else {
    echo "<h5 class = 'none'>There are currently no bookings to display.</h5>";
}

// Close the database connection
$conn->close();
?>