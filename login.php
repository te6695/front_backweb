<?php
$err = ''; // Initialize error message

// Secure database connection
$conn = mysqli_connect("localhost", "root", "", "student");

// Check connection success
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['Email']);
    $password = $_POST['password']; // No escaping needed for passwords

    if (empty($email)) {
        $err = "Email is required!";
    } else if (empty($password)) {
        $err = "Password is required!";
    } else {
        // Using prepared statements for security
        $sql = "SELECT password FROM studentinfo WHERE Email = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $stored_password);

        if (mysqli_stmt_fetch($stmt)) {
            // Direct string comparison since passwords in your table are **not hashed**
            if ($password === $stored_password) {
                header('Location: home.php'); // Successful login
                exit;
            } else if($password != $stored_password) {
                $err = "Incorrect  password!";
            }
        } else {
            $err = "User not found!";
        }

        mysqli_stmt_close($stmt);
    }
}

// Close connection
mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>index.html</title>
  <link rel="stylesheet" href="login.css">
  <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="node_modules/bootswatch/dist/journal/bootstrap.min.css">
  
</head>
<body>
  

  <div class="head1">
  
  </div>
  <div class="err">
  <?php echo $err;?>
  </div>
  <!-- login form -->
  <form class="form-container" action="login.php" method="post">
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