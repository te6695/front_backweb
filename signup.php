<?php
$fname = "";
$lname = "";
$email = "";
$pass = "";
$pass2 = "";
$sex = "";
$err = array();
$congra = "";

// Connection
$conn = mysqli_connect("localhost", "root", "", "student");

if (isset($_POST['signup'])) {
    $fname = mysqli_real_escape_string($conn, $_POST['Fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $email = mysqli_real_escape_string($conn, $_POST['Email']);
    $pass = mysqli_real_escape_string($conn, $_POST['password']);
    $pass2 = mysqli_real_escape_string($conn, $_POST['password2']);
    $sex = mysqli_real_escape_string($conn, $_POST['sex']);

    // Check if passwords match
    if ($pass != $pass2) {
        array_push($err, "The passwords do not match!");
    }

    // Check if username or email already exists
    $user_check_query = "SELECT * FROM studentinfo WHERE Fname='$fname' OR Email='$email' LIMIT 1";
    $result = mysqli_query($conn, $user_check_query);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        if ($user['Fname'] === $fname) {
            array_push($err, "Username already exists!");
        }
        if ($user['Email'] === $email) {
            array_push($err, "Email already exists!");
        }
    }

    // Insert data if no errors
    if (count($err) === 0) {
        $query = "INSERT INTO studentinfo (Fname, lname, Email, password, sex) 
                  VALUES ('$fname', '$lname', '$email', '$pass', '$sex')";
        mysqli_query($conn, $query);
        $congra = "You registered successfully!";
    }
}
?>

<html>
<html lang="en">
<head>
    <link rel="stylesheet" href="signup.css">
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
     <style>       
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>signup</title>
</head>
<body>
<script>
function sayhello(){    
confirm("Are you sure you want to submit? ");
}
</script>

<div class="err" >
    <?php
    include "err.php";
    ?>
</div>
<?php
echo $congra;
?>
    <div class="auth" >
    <form action="signup.php" method="post">
    Fname: <input  type="text"      name="Fname" placeholder="enter your name"  required> <br>
    lname: <input type="text"       name="lname" placeholder="optional"  > <br>
    Email : <input type="email"     name="Email" placeholder="enter email"  required> <br>
    password:<input type="password" name="password" placeholder="enter password" required>
            <input type="password"  name="password2" placeholder="confiirm password" required> 
    <label for="">sex</label>
    <input class="sex" type="radio" name="sex" value="male" id="male" required> Male
    <input class="sex" type="radio" name="sex" value="female" id="female" required> Female

   <input onclick="sayhello()" class="btn btn-success" type="submit" name="signup" id="submit"  >
   </form>   
</div>
<p style="padding-top:450px; font-size:30px ; font-style: bold;">I have account !</p>
<a style="padding-top: 450px; color: #0d1013; font-size: 30px;" href="index.php">login</a>
</body>
</html>