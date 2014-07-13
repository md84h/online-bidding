<?php

include 'connect.php';
session_start();
$_SESSION['signed_in']=false;
session_destroy();
header('location:index.php');
?>
