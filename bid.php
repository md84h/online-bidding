<?php 
session_start();
$biddingErr="";
$new_bidding="";
include 'connect.php';
if($_SERVER["REQUEST_METHOD"]=="POST")
{
    $new_bidding=$_POST['bidding'];
    if(!preg_match("/^[0-9]*$/",$new_bidding))
    {
        $biddingErr="Wrong";
    }
    if(!$biddingErr)
    {
        $iid=$_GET['id'];
        $res=mysql_query("select current_price,item_price from item where item_id='$iid'");
        while($row=  mysql_fetch_array($res))
        {
            if($new_bidding>$row['current_price'] && $new_bidding>=$row['item_price'])
            {
                $b_id=$_SESSION['user_id'];
                mysql_query("update item set current_price='$new_bidding',b_user_id='$b_id' where item_id='$iid'");
            }
            else
            {
                $biddingErr="Please Bid greater than Base and Current";
            }
        }
    }
    
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Bid</title>
  <link href="sticky-footer.css" rel="stylesheet">
        <link href="bootstrap.css" rel="stylesheet">
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
        include 'connect.php';
        $name=$_GET['id'];
        $res=mysql_query("select item_id,item_name,item_price,current_price,deadline,date from item where item_id='$name'");
        while($row=mysql_fetch_array($res))
            {
                $i_id=$row['item_id'];
                $dead=$row['date'];
                $add=$row['deadline'];
                $dead=  strtotime($dead);
                $dead= strtotime("+$add day",$dead);
                $datecmp=date('y/m/d h:i:s',$dead);
                $date = date_default_timezone_set('Asia/Kolkata');    
$datecrn = date('y/m/d h:i:s',time());
                if($datecrn<$datecmp)
                {
                echo '<div class="thumbnail">';
                echo "<img src='show.php?id=$i_id'/>";
                echo ' <div class="caption">';
                echo '<h3 align="center">'.$row["item_name"].'</h3>';
                echo '<p align="center">Base Price:'.$row['item_price'].'</p>';
                echo '<p align="center">Deadline:'.date('d-m-y h:i',$dead).'</p>';
                echo '<p align="center">Current Bid:'.$row['current_price'].'</p>';
                echo '<form class="form-signin" role="form" action="" method="POST">     
  <input type="text" class="form-control" style="width:100px;margin-left:46%" name="bidding" placeholder="Your bid" required autofocus>';
              
                        if($biddingErr)
                        {
                        echo '<span class="help-block" align="center" style="color:red">'.$biddingErr.'</span>';
                        }
                        
           echo '<br><button class="btn btn-lg btn-primary btn-block" type="submit" style="background: #009999;width:80px;margin-left:46.5%">Bid</button>
      </form>';
                echo '</div></div>';
            }
 else {
     echo "<h2 align='center' style='margin-top:17%'>Bidding Deadline is over<br>Visit Home!!!</h2>";
 }
            }
                ?>
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