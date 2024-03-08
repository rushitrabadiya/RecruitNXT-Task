<?php
include 'dbconn.php';
session_start();
if(!isset($_SESSION['name']))
{
echo "you are logged out";
header('location: log.php');
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Main Page</title>
</head>

<body>

<?php

echo $var;

?>
    <h1>Welcome to my Main Page</h1>

    <h2> Hello Friends My Name is <?php echo $_SESSION['name']; ?></h2>
    <h3> My Email id is <?php echo $_SESSION['email']; ?> </h3>

    <p>This is a simple HTML code for a main page.</p>
    <ul>
        <li><a href="#">Link 1</a></li>
        <li><a href="#">Link 2</a></li>
        <li><a href="#">Link 3</a></li>
    </ul>

    <a href="logout.php">
        <button name="logout" value="logout" >logout</button>
    </a>
</body>

</html>