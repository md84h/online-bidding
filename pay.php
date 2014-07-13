<?php 
session_start(); 
include 'connect.php';
$nid=$_GET['id'];
if($_SERVER["REQUEST_METHOD"]=="POST")
{
    $res=mysql_query("delete from item where item_id='$nid'");
    if($res)
    {
        header('location:success.php');
    }
    else
    {
        echo "Unbale to Proceed,Sorry!!!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Pay</title>
  <link href="sticky-footer.css" rel="stylesheet">
        <link href="bootstrap.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="signup.css"/>
    </head>
    <body>
        <div id="wrap">
        <?php
        if(isset($_SESSION['signed_in']) && $_SESSION['signed_in']==true)
        {
            include 'header_signin.php';
        }
        else
        {
          include 'header_signout.php';
        }
        ?>
            <h3 align="center">Delivery Details</h3>
            <div class="container">

      <form class="form-signin" role="form" action="" method="POST">
          <input type="text" class="form-control" name="name" placeholder="Name" required>
          <input type="text" class="form-control" name="contact" placeholder="Contact No" required>
          <textarea name="address" class="form-control" rows="3" cols="20" placeholder="Address" required></textarea>
          <h3 align="center">Payment</h3>
          <select name="p_mode" class="form-control">
              <option value>Payment Type</option>
              <option value="1">Credit Card</option>
              <option value="2">Debit card</option>
              <option value="3">Net Banking</option>
          </select>
          <input type="number" name="account" class="form-control" placeholder="Account No" required>
          <input type="password" name="pin" class="form-control" placeholder="Pin Number" required>
          <button class="btn btn-lg btn-primary btn-block" type="submit" style="background: #009999;">Proceed</button>
      </form>
        </div>
        </div>
         <div id="footer">
     <div class="container">
          <div id="list"> <ul>
              <li>About Us</li>
              <li>Contact Us</li>
              <li>Feedback</li>
          </ul>
          </div>
      </div>
        </div>
         <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
        <script src="bootstrap.min.js"></script>
    </body>
</html>
