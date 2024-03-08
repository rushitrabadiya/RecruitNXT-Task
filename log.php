<?php
session_start();
include 'dbconn.php';

if (isset($_POST['log_in'])) {
$email = $_POST['email'];
$password = $_POST['password'];



$email_search = "select * from table1 where email = '$email'";

$query = mysqli_query($conn, $email_search);

$email_count = mysqli_num_rows($query);


if ($email_count) {
    
    $email_pass = mysqli_fetch_assoc($query);
    $db_pass = $email_pass['password'];
    $_SESSION['name'] = $email_pass['name'];
    $_SESSION['email'] = $email_pass['email'];

    
    if ($db_pass) {
        
        header("Location: mainpage.php")
        
        ?>

        <?php 
       
    } else {
        echo "login not done";
    }
} else
    echo "email not valid";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class="login">
				<form action="" name="loginform" method="POST" enctype="multipart/form-data">
					<label for="chk" aria-hidden="true">Login Page</label><br><br>
					<input type="email" name="email" placeholder="Email" required=""><br><br>
					<input type="password" name="password" placeholder="Password" required=""><br><br>
					<button type="submit" name="log_in">Login</button>

				</form>
			</div>
</body>
</html>

