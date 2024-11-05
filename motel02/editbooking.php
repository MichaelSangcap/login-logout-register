<?php
require_once 'core/models.php'; 
require_once 'core/dbConfig.php'; 

// Handle form submission for editing a booking
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editBookingBtn'])) {
    $booking_id = $_GET['booking_id'];
    $guest_name = $_POST['guestName'] ?? null;
    $room_number = $_POST['roomNumber'] ?? null;
    $check_in_date = $_POST['checkInDate'] ?? null;
    $check_out_date = $_POST['checkOutDate'] ?? null;

    // Check if all fields are provided
    if ($guest_name && $room_number && $check_in_date && $check_out_date) {
        $updateSuccess = updateBooking($pdo, $guest_name, $room_number, $check_in_date, $check_out_date, $booking_id);
        if ($updateSuccess) {
            // Redirect to viewBookings.php with the motel_id
            $motel_id = $_GET['motel_id'] ?? ''; // Ensure motel_id is available
            header("Location: viewBookings.php?motel_id=" . urlencode($motel_id));
            exit();
        } else {
            echo "Failed to update booking. Please try again.";
        }
    } else {
        echo "All fields are required for editing a booking. No action was performed.";
    }
}

// Fetch booking details to pre-fill the form
$booking = getBookingByID($pdo, $_GET['booking_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Booking</title>
</head>
<body>
    <h1>Edit Booking</h1>
    <form action="editbooking.php?booking_id=<?php echo htmlspecialchars($booking['booking_id']); ?>&motel_id=<?php echo htmlspecialchars($_GET['motel_id']); ?>" method="POST">
        <p>
            <label for="guestName">Guest Name</label> 
            <input type="text" name="guestName" value="<?php echo htmlspecialchars($booking['guest_name']); ?>" required>
        </p>
        <p>
            <label for="roomNumber">Room Number</label> 
            <input type="text" name="roomNumber" value="<?php echo htmlspecialchars($booking['room_number']); ?>" required>
        </p>
        <p>
            <label for="checkInDate">Check-in Date</label> 
            <input type="date" name="checkInDate" value="<?php echo htmlspecialchars($booking['check_in_date']); ?>" required>
        </p>
        <p>
            <label for="checkOutDate">Check-out Date</label> 
            <input type="date" name="checkOutDate" value="<?php echo htmlspecialchars($booking['check_out_date']); ?>" required>
        </p>
        <p>
            <input type="submit" name="editBookingBtn" value="Update Booking">
        </p>
    </form>
</body>
</html>
