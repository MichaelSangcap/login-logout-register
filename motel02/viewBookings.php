<?php 
require_once 'core/models.php'; 
require_once 'core/dbConfig.php'; 

// Get motel information
$motel_id = $_GET['motel_id']; 
$getMotelInfoByID = getMotelByID($pdo, $motel_id); 

// Check if motel information was retrieved successfully
if ($getMotelInfoByID === false) {
    echo "<h2>Motel not found! Please check the motel ID.</h2>";
    exit(); // Stop further processing if the motel is not found
}

// Handle form submission for adding a new booking
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['insertNewBookingBtn'])) {
    $guestName = $_POST['guestName'];
    $roomNumber = $_POST['roomNumber'];
    $checkInDate = $_POST['checkInDate'];
    $checkOutDate = $_POST['checkOutDate'];

    // Validate input
    if (!empty($guestName) && !empty($roomNumber) && !empty($checkInDate) && !empty($checkOutDate)) {
        // Insert the new booking into the database
        $stmt = $pdo->prepare("INSERT INTO Booking (motel_id, guest_name, room_number, check_in_date, check_out_date) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$motel_id, $guestName, $roomNumber, $checkInDate, $checkOutDate]);

        // Redirect to the same page to avoid resubmission
        header("Location: viewBookings.php?motel_id=" . $motel_id);
        exit();
    } else {
        echo "<h2>All fields are required for adding a booking. No action was performed.</h2>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Motel Management - View Bookings</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <a href="index.php">Return to home</a>
    <h1>Motel Name: <?php echo htmlspecialchars($getMotelInfoByID['name']); ?></h1>
    
    <h1>Add New Booking</h1>
    <form action="viewBookings.php?motel_id=<?php echo $motel_id; ?>" method="POST">
        <p>
            <label for="guestName">Guest Name</label> 
            <input type="text" name="guestName" required>
        </p>
        <p>
            <label for="roomNumber">Room Number</label> 
            <input type="text" name="roomNumber" required>
        </p>
        <p>
            <label for="checkInDate">Check-in Date</label> 
            <input type="date" name="checkInDate" required>
        </p>
        <p>
            <label for="checkOutDate">Check-out Date</label> 
            <input type="date" name="checkOutDate" required>
            <input type="submit" name="insertNewBookingBtn" value="Add Booking">
        </p>
    </form>

    <table style="width:100%; margin-top: 50px;">
      <tr>
        <th>Booking ID</th>
        <th>Guest Name</th>
        <th>Room Number</th>
        <th>Check-in Date</th>
        <th>Check-out Date</th>
        <th>Action</th>
      </tr>
      <?php $getBookingsByMotel = getBookingsByMotel($pdo, $motel_id); ?>
      <?php if (!empty($getBookingsByMotel)) { ?>
          <?php foreach ($getBookingsByMotel as $row) { ?>
          <tr>
            <td><?php echo htmlspecialchars($row['booking_id']); ?></td>        
            <td><?php echo htmlspecialchars($row['guest_name']); ?></td>        
            <td><?php echo htmlspecialchars($row['room_number']); ?></td>        
            <td><?php echo htmlspecialchars($row['check_in_date']); ?></td>        
            <td><?php echo htmlspecialchars($row['check_out_date']); ?></td>
            <td>
                <a href="editbooking.php?booking_id=<?php echo $row['booking_id']; ?>&motel_id=<?php echo $motel_id; ?>">Edit</a>
                <a href="deletebooking.php?booking_id=<?php echo $row['booking_id']; ?>&motel_id=<?php echo $motel_id; ?>">Delete</a>
            </td>        
          </tr>
          <?php } ?>
      <?php } else { ?>
          <tr>
            <td colspan="6">No bookings found for this motel.</td>
          </tr>
      <?php } ?>
    </table>
</body>
</html>
