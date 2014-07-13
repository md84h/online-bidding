<?php
include 'connect.php';
if(isset($_GET['id']))
{
$id=  mysql_real_escape_string($_GET['id']);
$res=mysql_query("select image from item where item_id='$id'");
while($row=mysql_fetch_array($res))
{
    $img=$row['image'];
}
header("content-type: image/jpeg");
echo $img;
}
?>
