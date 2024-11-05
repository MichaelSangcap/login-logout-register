<?php
// Enable error reporting to troubleshoot issues
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'dbConfig.php'; 
require_once 'models.php';

// Display all incoming POST data for debugging
echo '<pre>';
print_r($_POST);
echo '</pre>';

// Check for missing fields and ensure required data is present
foreach ($_POST as $key => $value) {
    if (empty($value)) {
        echo "Field '$key' is empty.<br>";
    }
}

// Add a new motel
if (isset($_POST['insertMotelBtn'])) {
    if (!empty($_POST['name']) && !empty($_POST['location']) && !empty($_POST['contact']) && !empty($_POST['email'])) {
        $query = insertMotel($pdo, $_POST['name'], $_POST['location'], $_POST['contact'], $_POST['email']);
        
        if ($query) {
            header("Location: ../index.php");
            exit();
        } else {
            echo "Insertion failed. Please try again.";
        }
    } else {
        echo "All fields are required for adding a motel.";
    }
}

// Edit a motel
// Edit a motel
if (isset($_POST['editMotelBtn'])) {
    $motel_id = $_GET['motel_id'] ?? null;
    
    if ($motel_id && !empty($_POST['name']) && !empty($_POST['location']) && !empty($_POST['contact_number']) && !empty($_POST['email'])) {
        $query = updateMotel($pdo, $_POST['name'], $_POST['location'], $_POST['contact_number'], $_POST['email'], $motel_id);

        if ($query) {
            header("Location: ../index.php"); // Redirect to index.php in the root directory
            exit();
        } else {
            echo "Failed to update motel. Please try again.";
        }
    } else {
        echo "All fields are required to edit a motel.";
    }
}


// Delete a motel
if (isset($_POST['deleteMotelBtn'])) {
    $query = deleteMotel($pdo, $_GET['motel_id']);

    if ($query) {
        header("Location: ../index.php");
        exit();
    } else {
        echo "Motel deletion failed. Please try again.";
    }
}

// Add a new booking for a motel
// Notice the change here from 'insertBookingBtn' to 'insertNewBookingBtn'
if (isset($_POST['insertNewBookingBtn'])) {
    if (!empty($_POST['motel_id']) && !empty($_POST['guest_name']) && !empty($_POST['room_number']) && !empty($_POST['check_in_date']) && !empty($_POST['check_out_date'])) {
        $query = insertBooking($pdo, $_POST['motel_id'], $_POST['guest_name'], $_POST['room_number'], $_POST['check_in_date'], $_POST['check_out_date']);

        if ($query) {
            header("Location: ../viewBookings.php?motel_id=" . $_POST['motel_id']);
            exit();
        } else {
            echo "Booking insertion failed. Please try again.";
        }
    } else {
        echo "All fields are required for adding a booking.";
    }
}

// Edit a booking
if (isset($_POST['editBookingBtn'])) {
    if (!empty($_POST['guestName']) && !empty($_POST['roomNumber']) && !empty($_POST['checkInDate']) && !empty($_POST['checkOutDate'])) {
        $query = updateBooking($pdo, $_POST['guestName'], $_POST['roomNumber'], $_POST['checkInDate'], $_POST['checkOutDate'], $_GET['booking_id']);

        if ($query) {
            header("Location: ../viewBookings.php?motel_id=" . $_GET['motel_id']);
            exit();
        } else {
            echo "Booking update failed. Please try again.";
        }
    } else {
        echo "All fields are required for editing a booking.";
    }
}


// Delete a booking
// Delete a booking
if (isset($_POST['deleteBookingBtn'])) {
    $booking_id = $_GET['booking_id'] ?? null;
    $motel_id = $_GET['motel_id'] ?? null;

    if ($booking_id && $motel_id) {
        $query = deleteBooking($pdo, $booking_id);

        if ($query) {
            header("Location: ../viewBookings.php?motel_id=" . urlencode($motel_id)); // Redirect to viewBookings.php with motel ID
            exit();
        } else {
            echo "Failed to delete booking. Please try again.";
        }
    } else {
        echo "Booking ID and Motel ID are required for deletion.";
    }
}

// If no action was taken, display this message for debugging purposes
echo "No action was performed. Ensure the form button names and action URL are correct.";
?>