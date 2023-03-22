<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="style.css">
	<title>Blog Registration</title>
</head>
<body>
<header>
		<div class="banner"></div>
	</header>
	<main class="container">
		<h1>Welcome to your blog!</h1>
		<p>you are free to create</p>
		<div class="form-wrapper">
			<form action="register.php" method="post">
				<fieldset>
					<legend>let's sign up!</legend>
					<div>
						<label for="username">Username:</label>
						<input type="text" id="username" name="username" required minlength="4" maxlength="20" pattern="[a-z0-9]+">
					</div>
					<div>
						<label for="email">Email:</label>
						<input type="email" id="email" name="email" required>
					  </div>
					  
					<div>
						<label for="password">Password:</label>
						<input type="password" id="password" name="password" required minlength="6" maxlength="100" pattern="^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9\W]).+$">
					</div>
					<div>
						<label for="confirm-password">Confirm Password:</label>
						<input type="password" id="confirm-password" name="confirm-password" required minlength="6" maxlength="100" pattern="^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9\W]).+$">
					</div>
					<div>
						<input type="submit" value="Register">
					</div>
				</fieldset>
			</form>
		</div>
	</main>
</body>

<?php
// Establishing connection to the database
require_once('db.php');

// Retrieving form data
$username = $_POST["username"];
$password = $_POST["password"];
$confirm_password = $_POST["confirm_password"];

// Checking if username already exists
$sql = "SELECT * FROM users WHERE username='$username'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
	echo "Username already exists. Please choose a different username.";
	exit();
}

// Checking if username meets the requirements
if (!preg_match("/^[a-z0-9]{4,20}$/", $username)) {
	echo "Username must be at least 4 characters long and no longer than 20 characters. It must only consist of lower case letters and numbers.";
	exit();
}

// Checking if password meets the requirements
if (strlen($password) < 6 || strlen($password) > 100 || !preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_])[A-Za-z\d\W_]{6,100}$/", $password)) {
	echo "Password must be at least 6 characters long and must contain at least one uppercase letter, one lower case letter, and one number or special character. It must not be longer than 100 characters.";
	exit();
}

// Checking if passwords match
if ($password != $confirm_password) {
	echo "Passwords do not match.";
	exit();
}

// Inserting new user into the database
$sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
if (mysqli_query($conn, $sql)) {
	echo "User created successfully. <a href='login.php'>Click here</a> to login.";
} else {
	echo "Error creating user: " . mysqli_error($conn);
}

// Closing database connection
mysqli_close($conn);
?>

</body>
</html>
