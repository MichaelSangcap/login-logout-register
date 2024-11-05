<?php 
require_once 'core/models.php';
require_once 'core/dbConfig.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Motel</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Edit Motel Details</h1>
    <?php 
        $motel_id = $_GET['motel_id'] ?? null;
        $motel = getMotelByID($pdo, $motel_id);
        
        if (!$motel) {
            echo "<p>Motel not found.</p>";
            exit;
        }
    ?>
    <div class="container" style="border-style: solid; padding: 20px;">
        <form action="core/handleForms.php?motel_id=<?php echo urlencode($motel_id); ?>" method="POST">
            <label for="name">Motel Name:</label><br>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($motel['name']); ?>" required><br><br>

            <label for="location">Location:</label><br>
            <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($motel['location']); ?>" required><br><br>

            <label for="contact_number">Contact Number:</label><br>
            <input type="text" id="contact_number" name="contact_number" value="<?php echo htmlspecialchars($motel['contact_number']); ?>" required><br><br>

            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($motel['email']); ?>" required><br><br>

            <input type="submit" name="editMotelBtn" value="Update Motel">
        </form>
    </div>
</body>
</html>
