CREATE TABLE Motel (
    motel_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    location VARCHAR(255),
    contact_number VARCHAR(20),
    email VARCHAR(100)
    ALTER TABLE motel ADD date_added DATETIME DEFAULT CURRENT_TIMESTAMP;

);                                                                                                                                                           CREATE TABLE Booking (
    booking_id INT AUTO_INCREMENT PRIMARY KEY,
    motel_id INT,
    guest_name VARCHAR(100),
    room_number VARCHAR(10),
    check_in_date DATE,
    check_out_date DATE,
    ALTER TABLE Booking ADD date_added DATETIME DEFAULT CURRENT_TIMESTAMP;
    FOREIGN KEY (motel_id) REFERENCES Motel(motel_id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL
);
