<?php require_once 'core/models.php'; ?>
<?php require_once 'core/dbConfig.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Delete Motel</title>
	<link rel="stylesheet" href="styles.css">
</head>
<body>
	<h1>Are you sure you want to delete this motel?</h1>
	<?php $getMotelByID = getMotelByID($pdo, $_GET['motel_id']); ?>
	<div class="container" style="border-style: solid; height: 400px;">
		<h2>Motel Name: <?php echo htmlspecialchars($getMotelByID['name']); ?></h2>
		<h2>Location: <?php echo htmlspecialchars($getMotelByID['location']); ?></h2>
		<h2>Contact Number: <?php echo htmlspecialchars($getMotelByID['contact_number']); ?></h2>
		<h2>Email: <?php echo htmlspecialchars($getMotelByID['email']); ?></h2>
		<h2>Date Added: <?php echo htmlspecialchars($getMotelByID['date_added']); ?></h2>

		<div class="deleteBtn" style="float: right; margin-right: 10px;">
			<form action="core/handleForms.php?motel_id=<?php echo $_GET['motel_id']; ?>" method="POST">
				<input type="submit" name="deleteMotelBtn" value="Delete">
			</form>			
		</div>	
	</div>
</body>
</html>
