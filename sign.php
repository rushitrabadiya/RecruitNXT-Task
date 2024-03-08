<?php
error_reporting(0);
session_start();
include 'dbconn.php';

if (isset($_POST['SignUp'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);
    $c_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    $errors = array();

    // // Validate the name field
    if (empty($name)) {
        $errors[] = "Name is required.";
    } else if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
        $errors[] = "Name can only contain letters and spaces.";
    }

    // // Validate the email field
    if (empty($email)) {
        $errors[] = "Email is required.";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email is invalid.";
    }

    // // Validate the password field
    if (empty($password)) {
        $errors[] = "Password is required.";
    } else if (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters long.";
    } else if (!preg_match("/[A-Z]/", $password)) {
        $errors[] = "Password must contain at least one uppercase letter.";
    } else if (!preg_match("/[a-z]/", $password)) {
        $errors[] = "Password must contain at least one lowercase letter.";
    } else if (!preg_match("/[0-9]/", $password)) {
        $errors[] = "Password must contain at least one number.";
    }

    // // Validate the confirm password field
    if (empty($c_password)) {
        $errors[] = "Confirm Password is required.";
    } else if ($c_password !== $password) {
            $errors[] = 'Passwords do not match';
    }

    // // If there are errors, return them to the client
    if (!empty($errors)) {
        header("HTTP/1.1 400 Bad Request");
        header("Content-type: application/json");
        echo json_encode(array("errors" => $errors));
        exit;
    }
 else {
    $check_email = "select * from table1 where email = '$email'";
    $data = mysqli_query($conn, $check_email);
    $q = mysqli_fetch_array($data);
    if ($q > 0) {
        $errors = "Email already exits";
    } else {
       
        $stmt = $conn->prepare("INSERT INTO table1 (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $password);

        if ($stmt->execute()) {
            // If the SQL statement was successful, return a success message to the client
            $success = "Your Data successfully Registration";
            echo json_encode(array("success" => "User registration successful!"));
        } else {
            // If the SQL statement failed, return an error message to the client
            echo json_encode(array("errors" => array("Failed to insert user data into database.")));
        }
        $stmt->close();
        $conn->close();
    }
}

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

    <h1>Registration Form</h1>
    <p style="color:red">
        <?php
        if (isset($errors)) {
                echo $errors;
        }
        ?>
    </p>
    <p style="color:green">
        <?php
        if (isset($success)) {
            echo $success;
        }
        ?>
    </p>
    <form action="" method="post">

        <div>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php
                                                            if (isset($errors))
                                                                echo $name;
                                                            ?>">
            <span id="name_error" class="error"></span>
        </div>
        <div>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php
                                                                if (isset($errors))
                                                                    echo $email;
                                                                ?>">
            <span id="email_error" class="error"></span>
        </div>
        <div>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <span id="password_error" class="error"></span>
        </div>
        <div>
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
            <span id="confirm_password_error" class="error"></span>
        </div>
        <button type="submit" class="submit" id="submit" name="SignUp">SignUp</button>

        
             <button class="login" id="login"> <a href="log.php" class="login" id="login">Login</a></button>
        </div>
</body>

</html>