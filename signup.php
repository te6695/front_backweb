<?php
// Database connection details
$servername = "localhost"; // Replace with your server name
$username = "dbu"; // Replace with your database username
$password = "dbu1234@$"; // Replace with your database password
$dbname = "student"; // Using the database name you provided

// Initialize variables for messages and errors
$congra = "";
$err = [];

// Check if the signup form is submitted
if (isset($_POST['signup'])) {
    // Retrieve form data
    $Fname = $_POST['Fname'];
    $lname = $_POST['lname'];
    $Email = $_POST['Email'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];

    // Perform basic input validation
    if (empty($Fname)) {
        $err[] = "First Name is required.";
    }
    if (empty($Email)) {
        $err[] = "Email is required.";
    } elseif (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
        $err[] = "Invalid email format.";
    }
    if (empty($password)) {
        $err[] = "Password is required.";
    }
    if ($password !== $password2) {
        $err[] = "Passwords do not match.";
    }

    // If there are no validation errors, proceed to save data
    if (empty($err)) {
        // Create a database connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Hash the password for security
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Prepare the SQL query to insert data into the studentinfo table
        $sql = "INSERT INTO studentinfo (Fname, lname, Email, password) VALUES (?, ?, ?, ?)";

        // Create a prepared statement
        $stmt = $conn->prepare($sql);

        // Bind the parameters to the prepared statement
        $stmt->bind_param("ssss", $Fname, $lname, $Email, $hashedPassword);

        // Execute the prepared statement
        if ($stmt->execute()) {
            $congra = "Registration successful!";
            // Optionally, you can redirect the user to a login page here
            // header("Location: login.php");
            // exit();
        } else {
            $err[] = "Error saving data: " . $stmt->error;
        }

        // Close the prepared statement and the database connection
        $stmt->close();
        $conn->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Signup</title>
    <link rel="stylesheet" href="signup.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <div class="card">
        <?php if (!empty($err)): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach ($err as $e): ?>
                        <li><?php echo $e; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if (!empty($congra)): ?>
            <div class="alert alert-success">
                <?php echo $congra; ?>
            </div>
        <?php endif; ?>

        <form action="signup.php" method="post" onsubmit="return sayhello()">
            <div class="mb-3">
                <label for="Fname">First Name</label>
                <input type="text" name="Fname" class="form-control" placeholder="Enter your name" required>
            </div>

            <div class="mb-3">
                <label for="lname">Last Name</label>
                <input type="text" name="lname" class="form-control" placeholder="Optional">
            </div>

            <div class="mb-3">
                <label for="Email">Email</label>
                <input type="email" name="Email" class="form-control" placeholder="Enter email" required>
            </div>

            <div class="mb-3">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Enter password" required>
            </div>

            <div class="mb-3">
                <label for="password2">Confirm Password</label>
                <input type="password" name="password2" class="form-control" placeholder="Confirm password" required>
            </div>

            <div class="mb-3">
                <label>Sex</label><br>
                <input type="radio" name="sex" value="male" required> Male
                <input type="radio" name="sex" value="female" required> Female
            </div>

            <button type="submit" name="signup" class="btn btn-success">Sign Up</button>
        </form>

        <div class="text-center mt-3">
            <p>I have an account!</p>
            <a class="btn-link" href="login.php">Login</a>
        </div>
    </div>
</div>

<script>
function sayhello() {
    return confirm("Are you sure you want to submit?");
}
</script>
</body>
</html>
