<?php

session_start();
if(isset($_SESSION['name']))
{
    session_destroy();

    header('location:log.php');
}


session_destroy();

header('location:log.php');
?>