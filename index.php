<?php
$err = ''; // Initialize the error variable
$email = "taye123@gmail.com";
$password = "12345678";

// Fixing the issue in the mysqli_connect function
$conn = mysqli_connect("localhost", "root", "", "student");

// Check if the connection is successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['login'])) { // Corrected $_post to $_POST
    $email = mysqli_real_escape_string($conn, $_POST['Email']); // Corrected $_post to $_POST
    $password = mysqli_real_escape_string($conn, $_POST['password']); // Corrected $_post to $_POST
    $sql = "SELECT * FROM tablename WHERE firstname='$email' AND password='$password' LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if (empty($email)) {
        $err = "email  required!";
    } else if (empty($password)) {
        $err = "Password required!";
    } elseif ($result && mysqli_num_rows($result) == 1) { // Corrected the condition
        header('Location: home.php'); // Added proper space and capitalization
        exit; // Ensure the script stops after redirection
    } else {
        $err = "Unable to login!";
    }
}

// Close the connection (optional but good practice)
mysqli_close($conn);?> 





<?php
$err = ''; // Initialize the error variable

// Secure database connection
$conn = mysqli_connect("localhost", "root", "", "student");

// Check if the connection is successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle login request
if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['Email']);
    $password = $_POST['password']; // Do not escape password as it's not part of SQL query in prepared statements

    if (empty($email)) {
        $err = "Email is required!";
    } else if (empty($password)) {
        $err = "Password is required!";
    } else {
        // Using prepared statements to prevent SQL injection
        $sql = "SELECT password FROM tablename WHERE email = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $hashed_password);

        if (mysqli_stmt_fetch($stmt)) {
            // Verify the entered password against the hashed password
            if (password_verify($password, $hashed_password)) {
                // Redirect to home.php on successful login
                header('Location: home.php');
                exit;
            } else {
                $err = "Incorrect email or password!";
            }
        } else {
            $err = "User not found!";
        }

        mysqli_stmt_close($stmt);
    }
}

// Close the connection
mysqli_close($conn);
?>





 












<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>index.html</title>
  <link rel="stylesheet" href="index.css">
  <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="node_modules/bootswatch/dist/journal/bootstrap.min.css">
  
</head>
<body>
  

  <div class="head1">
    <h1>Learn from our Resources</h1>
  </div>
  <div class="err">
  <?php echo $err;?>
  </div>
  <!-- login form -->
  <form class="form-container" action="home.php" method="post">
    <img src="person.jpg" alt="">
    <div class="input">
      <label>Email:</label> <input type="email" placeholder="enter your Email" name="Email" required>
      <label> password</label> <input type="password" placeholder="Enter password" name="password" required>
      <input  class="submit" type="submit" value="login"
        name="login">
    </div>
  </form>
  <a class="link" href="home.html"></a>
  <p id="fillname"></p>
  <div class="ref">
   Have no account?
    <a class="anch" href="signup.php">create now.</a>
  </div>
  <!-- some scripting alerts here..... -->
  <script>
    function confirmation() {
      confirm("Are you sure you want to login?")
    }
    function mouseover() {
      alert("please enter correct email and password!!");
    }
  </script>
</body>
<div style="text-align: center;font-size: 40px; padding: 10px;position: fixed; background-color: #656d75;bottom: 0; width: 100%;">
  &COPY; All rights reserved.
</div>
</html>