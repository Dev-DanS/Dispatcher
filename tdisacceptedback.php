<?php
session_start();
require_once "../db/tdbconn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input_platenumber = $_POST["platenumber"];
    $bookingid = $_SESSION["bookingid"];
    $status = 'accepted';

    // Assuming your table name is 'booking'
    $sql = "UPDATE booking SET status = ? , platenumber = ? WHERE bookingid = ?";

    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters
        $stmt->bind_param("ssi", $status, $input_platenumber, $bookingid);

        // Execute the statement
        if ($stmt->execute()) {
            // The update was successful
            echo "Update successful.";
            // Redirect to tdispending.php
            header("Location: tdispending.php");
            exit; // Ensure that no further code is executed after the redirect
        } else {
            // Handle the update error
            echo "Update failed: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        // Handle the statement preparation error
        echo "Statement preparation error: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>