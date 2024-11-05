<?php 
require_once 'core/dbConfig.php'; 
require_once 'core/models.php'; 

// Enable error reporting to troubleshoot issues
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if booking_id is set in the URL
$booking_id = $_GET['booking_id'] ?? null;
$motel_id = $_GET['motel_id'] ?? null;

if (!$booking_id || !$motel_id) {
    echo "Booking ID or Motel ID is missing.";
    exit();
}

// Get the booking information by ID
$booking = getBookingByID($pdo, $booking_id); 

// Check if booking information is retrieved successfully
if (!$booking) {
    echo "<h2>Booking not found!</h2>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Booking</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Are you sure you want to delete this booking?</h1>
    <div class="container" style="border-style: solid; padding: 20px;">
        <h2>Guest Name: <?php echo htmlspecialchars($booking['guest_name']); ?></h2>
        <h2>Room Number: <?php echo htmlspecialchars($booking['room_number']); ?></h2>
        <h2>Motel Name: <?php echo htmlspecialchars($booking['motel_name']); ?></h2>
        <h2>Check-in Date: <?php echo htmlspecialchars($booking['check_in_date']); ?></h2>
        <h2>Check-out Date: <?php echo htmlspecialchars($booking['check_out_date']); ?></h2>
        <h2>Date Added: <?php echo isset($booking['date_added']) ? htmlspecialchars($booking['date_added']) : 'N/A'; ?></h2>

        <div class="deleteBtn" style="float: right; margin-right: 10px;">
            <form action="core/handleForms.php?booking_id=<?php echo urlencode($booking_id); ?>&motel_id=<?php echo urlencode($motel_id); ?>" method="POST">
                <input type="submit" name="deleteBookingBtn" value="Delete">
            </form>            
        </div>  
    </div>
</body>
</html>
