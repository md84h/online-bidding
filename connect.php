<?php

$con=mysql_connect("localhost", "root", "");
if(!$con)
        header("location:index.php");
if(!mysql_select_db("online_bidding"))
    header("location:index.php");
?>
