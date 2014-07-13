<?php 
session_start(); 
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Home</title>
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
        ?>
    <div class="container">
            <div class="row" style="margin-top:10px">
        
            
            <?php
                
                if(isset($_SESSION['signed_in']) && $_SESSION['signed_in']==true)
                echo '<a  class="btn btn-success" href="add.php" style="font-size:20px; width:200px;">Add an Item</a>';
                echo '<br><br>';
                ?>
            <?php
            include 'connect.php';
            $i=0;
            $ck=mysql_query("select item_id,item_name,current_price,date_e,b_user_id from item");
            while($rw=  mysql_fetch_array($ck))
            {
                $date = date_default_timezone_set('Asia/Kolkata');    
                $dateck = date('y/m/d h:i:s',time());
                if($dateck>$rw['date_e'] && $rw['b_user_id']==$_SESSION['user_id'])
                {
                    $ibd=$rw['item_id'];
                    echo "<h2 align='center'>Congrats!!!<br>You won the Bidding</h2>";
                echo '<div class="thumbnail">';
                echo "<img src='show.php?id=$ibd'/>";
                echo ' <div class="caption">';
                echo '<h3 align="center">'.$rw["item_name"].'</h3>';
                echo '<h4 align="center">You have to pay: '.$rw["current_price"].'</h4>';
                echo "<p align='center'><a href='pay.php?id=$ibd' class='btn btn-primary' role='button'>Pay</a></p>";
                echo '</div></div>';  
                $i++;
                }
              }
              if($i==0)
              {
              $res=mysql_query("select item_id,item_name,item_price,deadline,date from item order by date desc");
            //fetching the items and displaying them in most recent first
            while($row=mysql_fetch_array($res))
            {
                $i_id=$row['item_id'];
                $dead=$row['date'];
                $add=$row['deadline'];
                $dead=  strtotime($dead);
                $dead= strtotime("+$add day",$dead);
                $c_date=date('y/m/d h:i:s',$dead);
                $result=mysql_query("update item set date_e='$c_date' where item_id='$i_id'");
               $date = date_default_timezone_set('Asia/Kolkata');    
                $datecrn = date('y/m/d h:i:s',time());
                if($datecrn<$c_date)
                    {
                echo '<div class="col-sm-6 col-md-4">';
                echo '<div class="thumbnail">';
                echo "<img src='show.php?id=$i_id'/>";
                echo ' <div class="caption">';
                echo '<h3 align="center">'.$row["item_name"].'</h3>';
                echo '<p align="center">Base Price:'.$row['item_price'].'</p>';
                echo '<p align="center">Deadline:'.date('d-m-y h:i',$dead).'</p>';
                echo "<p align='center'><a href='bid.php?id=$i_id' class='btn btn-primary' role='button'>Bid</a></p>";
                echo '</div></div></div>';
                    }
 else {
     echo '</div>';
 }
            }
              }           
            ?>  
        </div>
            </div>
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