<?php
$ipriceErr = $idaysErr =$inameErr= "";
$new_iprice=$new_idays=$new_iname="";
session_start();

include ('connect.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") 
    {
    if (empty($_POST["item_name"])) {
        $inameErr = "Please enter item name";
    } else {
        $new_iname = mysql_real_escape_string($_POST['item_name']);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(empty($_POST["item_price"]))
    {
        $ipriceErr="Please enter base price";
    }
    else
    {
        $new_iprice = mysql_real_escape_string($_POST['item_price']);
    }
}

if ($_SERVER["REQUEST_METHOD"]=="POST")
{
    if(empty($_POST["deadline"]))
    {
        $idaysErr="Please enter deadline";
    }
    else
    {
        $new_idays = mysql_real_escape_string($_POST['deadline']);
    }
        
}
if ($_SERVER["REQUEST_METHOD"]=="POST")
{
   $fileName=  mysql_real_escape_string($_FILES['userfile']['name']);
   $content=  mysql_real_escape_string(file_get_contents($_FILES['userfile']['tmp_name']));
   $type=  mysql_real_escape_string($_FILES['userfile']['type']);
   if(substr($type,0,5)=='image')
   {
       //echo "correct";
   }
   else
   {
       //echo "wrong";
   }
}

$date = date_default_timezone_set('Asia/Kolkata');    
$new_datetime = date('y/m/d h:i:s',time());


$new_item_by = $_SESSION['user_id'];
if(!$inameErr && !$ipriceErr && !$idaysErr)
{
if ($_SERVER['REQUEST_METHOD'] == 'POST')      //inserting into table
    {
    $ask = mysql_query("insert into item (item_name,item_price,deadline,date,file_name,image,user_id) values ('$new_iname','$new_iprice','$new_idays','$new_datetime','$fileName','$content','$new_item_by')");
    if (!$ask)
        echo "i will not allow you";
    else {
        header('location:home.php');
    }
}
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Add</title>
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
          header('location:home.php');
        }
        ?>
            <div class="container">
            <div class="row" style="margin-top:10px">
        <div class="col-sm-8 col-md-8">
            <div class="container">
       <form class="form-signin" role="form" action="" method="POST" enctype="multipart/form-data">
                <input type="text" name="item_name" class="form-control" value="<?php if(isset($new_iname) && !$inameErr) echo $new_iname;?>" maxlength="255" placeholder="Item Name" required><br>
                <?php
                            if($inameErr)
                            {
                                echo "<span class='help-block' style='color:red'>".$inameErr."</span>";
                                
                            }
                            ?>
                <input type="text" name="item_price" class="form-control" value="<?php if(isset($new_iprice) && !$ipriceErr) echo $new_iprice;?>" maxlength="255" placeholder="Base Price" required><br>
                
                <?php
                            if($ipriceErr)
                            {
                                echo "<span class='help-block' style='color:red'>".$ipriceErr."</span>";
                                
                            }
                            ?>
                            <input type="number" name="deadline" class="form-control" value="<?php if(isset($new_idays) && !$idaysErr) echo $new_idays;?>" placeholder="Deadline,in days" required><br>
                
                <?php
                            if($idaysErr)
                            {
                                echo "<span class='help-block' style='color:red'>".$idaysErr."</span>";
                                
                            }
                            ?>
                <input name="userfile" type="file" id="userfile" class="form-control" placeholder="Item pic" required><br>
                       <button class="btn btn-lg btn-primary btn-block" type="submit" style="background: #009999;">Add</button>
         
            </form>
            </div>
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