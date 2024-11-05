<?php  

// Insert a new motel
function insertMotel($pdo, $name, $location, $contact_number, $email) {
    $sql = "INSERT INTO Motel (name, location, contact_number, email) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$name, $location, $contact_number, $email]);

    return $executeQuery; // Return the result of the query
}

// Update an existing motel
function updateMotel($pdo, $name, $location, $contact_number, $email, $motel_id) {
	$sql = "UPDATE Motel SET name = ?, location = ?, contact_number = ?, email = ? WHERE motel_id = ?";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$name, $location, $contact_number, $email, $motel_id]);
	
	if ($executeQuery) {
		return true;
	}
}

// Delete a motel and its associated bookings
function deleteMotel($pdo, $motel_id) {
	$deleteBookings = "DELETE FROM Booking WHERE motel_id = ?";
	$deleteStmt = $pdo->prepare($deleteBookings);
	$executeDeleteQuery = $deleteStmt->execute([$motel_id]);

	if ($executeDeleteQuery) {
		$sql = "DELETE FROM Motel WHERE motel_id = ?";
		$stmt = $pdo->prepare($sql);
		$executeQuery = $stmt->execute([$motel_id]);

		if ($executeQuery) {
			return true;
		}
	}
}

// Get all motels
function getAllMotels($pdo) {
    $sql = "SELECT * FROM Motel";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC); // Ensure it returns associative array with column names as keys
}


// Get a motel by ID
function getMotelByID($pdo, $motel_id) {
	$sql = "SELECT * FROM Motel WHERE motel_id = ?";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$motel_id]);

	if ($executeQuery) {
		return $stmt->fetch();
	}
}

function getMotelInfoByID($pdo, $motel_id) {
    $sql = "SELECT * FROM Motel WHERE motel_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$motel_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


// Get bookings by motel ID
function getBookingsByMotel($pdo, $motel_id) {
    try {
        $sql = "SELECT 
                    Booking.booking_id AS booking_id,
                    Booking.guest_name AS guest_name,
                    Booking.room_number AS room_number,
                    Booking.check_in_date AS check_in_date,
                    Booking.check_out_date AS check_out_date,
                    Motel.name AS motel_name
                FROM Booking
                JOIN Motel ON Booking.motel_id = Motel.motel_id
                WHERE Booking.motel_id = ?";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$motel_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error retrieving bookings: " . $e->getMessage();
        return [];
    }
}


// Insert a new booking for a motel
function insertBooking($pdo, $motel_id, $guest_name, $room_number, $check_in_date, $check_out_date) {
	$sql = "INSERT INTO Booking (motel_id, guest_name, room_number, check_in_date, check_out_date) VALUES (?, ?, ?, ?, ?)";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$motel_id, $guest_name, $room_number, $check_in_date, $check_out_date]);

	if ($executeQuery) {
		return true;
	}
}

// Get a booking by ID
function getBookingByID($pdo, $booking_id) {
    $sql = "SELECT 
                Booking.booking_id AS booking_id,
                Booking.guest_name AS guest_name,
                Booking.room_number AS room_number,
                Booking.check_in_date AS check_in_date,
                Booking.check_out_date AS check_out_date,
                Motel.name AS motel_name,
                Booking.date_added AS date_added  -- Ensure this line is included
            FROM Booking
            JOIN Motel ON Booking.motel_id = Motel.motel_id
            WHERE Booking.booking_id = ?";

    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$booking_id]);
    if ($executeQuery) {
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}


// Update an existing booking
function updateBooking($pdo, $guest_name, $room_number, $check_in_date, $check_out_date, $booking_id) {
	$sql = "UPDATE Booking SET guest_name = ?, room_number = ?, check_in_date = ?, check_out_date = ? WHERE booking_id = ?";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$guest_name, $room_number, $check_in_date, $check_out_date, $booking_id]);

	if ($executeQuery) {
		return true;
	}
}

// Delete a booking
function deleteBooking($pdo, $booking_id) {
	$sql = "DELETE FROM Booking WHERE booking_id = ?";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$booking_id]);
	if ($executeQuery) {
		return true;
	}
}

?>
