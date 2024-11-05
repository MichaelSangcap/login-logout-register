<?php
session_start();
require_once 'core/dbConfig.php'; 
require_once 'core/models.php'; 

// Handle login form submission
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query to check if user exists
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    // Verify password and log in user
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        header("Location: index.php"); // Refresh to display logged-in view
        exit();
    } else {
        echo "<p>Invalid username or password.</p>";
    }
}

// Handle registration form submission
if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Secure password hash
    $email = $_POST['email'];

    // Insert new user into database
    $stmt = $pdo->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
    if ($stmt->execute([$username, $password, $email])) {
        echo "<p>Registration successful. You can now log in.</p>";
    } else {
        echo "<p>Registration failed. Username or email may already exist.</p>";
    }
}

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php"); // Redirect to clear session data
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Motel Management System</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <!-- Display login, registration, or welcome message based on session status -->
    <?php if (isset($_SESSION['user_id'])): ?>
        <p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>! <a href="index.php?logout=true">Log Out</a></p>
    <?php else: ?>
        <h2>Login</h2>
        <form method="POST" action="">
            <label>Username:</label><input type="text" name="username" required><br>
            <label>Password:</label><input type="password" name="password" required><br>
            <button type="submit" name="login">Log In</button>
        </form>
        
        <h2>Register</h2>
        <form method="POST" action="">
            <label>Username:</label><input type="text" name="username" required><br>
            <label>Email:</label><input type="email" name="email" required><br>
            <label>Password:</label><input type="password" name="password" required><br>
            <button type="submit" name="register">Register</button>
        </form>
    <?php endif; ?>

    <h1>Motel Management System</h1>

    <?php if (isset($_SESSION['user_id'])): ?>
        <!-- Motel addition form, visible only to logged-in users -->
        <h2>Add a New Motel</h2>
        <form action="core/handleForms.php" method="POST">
            <label for="name">Motel Name</label> 
            <input type="text" name="name" required><br>
            <label for="location">Location</label> 
            <input type="text" name="location" required><br>
            <label for="contact">Contact Number</label> 
            <input type="text" name="contact" required><br>
            <label for="email">Email</label> 
            <input type="email" name="email" required><br>
            <button type="submit" name="insertMotelBtn">Add Motel</button>
        </form>
    <?php else: ?>
        <p>Please log in to add a new motel.</p>
    <?php endif; ?>

    <h2>All Motels</h2>
    <?php 
    $getAllMotels = getAllMotels($pdo); 
    foreach ($getAllMotels as $row): 
    ?>
    <div class="container" style="border: 1px solid; padding: 10px; margin-top: 20px; width: 50%;">
        <h3>Motel Name: <?php echo htmlspecialchars($row['name']); ?></h3>
        <h3>Location: <?php echo htmlspecialchars($row['location']); ?></h3>
        <h3>Contact Number: <?php echo htmlspecialchars($row['contact_number']); ?></h3>
        <h3>Email: <?php echo htmlspecialchars($row['email']); ?></h3>
        <h3>Date Added: <?php echo isset($row['date_added']) ? htmlspecialchars($row['date_added']) : 'Not available'; ?></h3>

        <div class="editAndDelete" style="float: right; margin-right: 20px;">
            <a href="viewBookings.php?motel_id=<?php echo $row['motel_id']; ?>">View Bookings</a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="editMotel.php?motel_id=<?php echo $row['motel_id']; ?>">Edit</a>
                <a href="deleteMotel.php?motel_id=<?php echo $row['motel_id']; ?>&deleteMotelBtn=1">Delete</a>
            <?php endif; ?>
        </div>
    </div> 
    <?php endforeach; ?>

</body>
</html>
