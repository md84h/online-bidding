<?php
session_start();
include 'connect.php';
if(isset($_SESSION['signed_in']) && $_SESSION['signed_in']==true)
{
    header('location:home.php');
}
$log_name=$pass="";
$userErr=$passErr="";
$salt="i_love_you";
if($_SERVER["REQUEST_METHOD"]=="POST")
{
    if(empty($_POST["user_in"]))
    {
        $userErr="Username is required";
    }
    else
    {
        $log_name=$_POST["user_in"];
        
    }
    if(empty($_POST["pass_in"]))
    {
        $passErr="Password required";
    }
    else
    {
        $pass=$_POST["pass_in"];
        
    }

                

if(!$passErr && !$userErr)
{
    $pass=md5($salt.$pass);
                $sel=  mysql_query("select password,user_id,fname from users where user_name='$log_name' or email='$log_name'");
                if(mysql_num_rows($sel)==0)
                    $userErr="Wrong User name";
                else
                    {
                    while($row=  mysql_fetch_array($sel))
                    {
                         if($row['password']==$pass)
                         {
                             $_SESSION['signed_in']=true;
                             $_SESSION['user_id']=$row['user_id'];
                             $_SESSION['user_name']=$row['fname'];
                             header('location:home.php');
                         }
                         else
                             $passErr="wrong password";
                    }
                    }
}
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Sign In</title>
         <link rel="stylesheet" type="text/css" href="sticky-footer.css"/>
        <link rel="stylesheet" type="text/css" href="signin.css"/>
        <link rel="stylesheet" type="text/css" href="bootstrap.css"/>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    </head>
    <body> 
        <div id="wrap">
      <nav class="navbar navbar-default" role="navigation">
           <div class="container-fluid">
               <div class="navbar-header">
                  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>

                   <a class="navbar-brand" href="index.php">O Bid</a>
               </div>
               <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <p class="navbar-text navbar-right"><a href="sign_up.php" class="navbar-link">Sign Up</a></p> 
              
                </div>
           </div>
  
</nav> 
      <div class="container">

      <form class="form-signin" role="form" action="" method="POST">     
  <input type="text" class="form-control" name="user_in" value="<?php if(isset($log_name) && !$userErr) echo $log_name;?>" placeholder="Username" required autofocus>
           <?php
                        if($userErr)
                        {
                        echo "<span class='help-block' style='color:red'>".$userErr."</span>";
                        }
                        ?>
        <input type="password" class="form-control" name="pass_in" placeholder="Password" required>
        <?php
                        if($passErr)
                        {
                        echo "<span class='help-block' style='color:red'>".$passErr."</span>";
                        }
                        ?>
        <button class="btn btn-lg btn-primary btn-block" type="submit" style="background: #009999;">Sign in</button>
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
