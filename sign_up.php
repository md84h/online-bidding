<?php
include 'connect.php';
session_start();
        if(isset($_SESSION['signed_in']) && $_SESSION['signed_in']==true)
        {
            header('location:home.php');
        }

$nameErr=$lnameErr=$usernameErr=$emailErr=$genderErr=$passwordErr=$passwordcnErr="";   //define error variables and set to empty values
$new_name=$new_lname=$new_username=$new_email=$new_pass=$new_passcn=$new_gender=$new_passarea="";    //define variables for taking input
$query1=$query2=$query3="";

if($_SERVER["REQUEST_METHOD"]=="POST")        
{
    //firstname validation
    if(empty($_POST["name"]))     //check if the name area is empty then display name is required
    {
        $nameErr="Firstname is required";
    }
    else
    {
        $new_name=test_input($_POST["name"]);     //now take input as the name after checking using test_input() function
        if(!preg_match("/^[a-zA-Z ]{1,20}$/",$new_name))      //check name enterred with regular expression     
        {
            $nameErr="Only letter and white spaces allowed,range is 1 to 20";
        }
    }
    //lastname validation
    if(empty($_POST["lname"]))
    {
        $lnameErr="Lastname is required";
    }
    else
    {
        $new_lname=test_input($_POST["lname"]); 
        if(!preg_match("/^[a-zA-Z ]{1,20}$/",$new_lname))      //check name enterred with regular expression     
        {
            $lnameErr="Only letter and white spaces allowed,range is 1 to 20";
        }
        
    }
    //username validation
    if(empty($_POST["user_up"]))
    {
        $usernameErr="Username is required";
    }
    else
    {
        $new_username=test_input($_POST["user_up"]);
        $query1=mysql_query("SELECT user_name FROM users WHERE user_name='$new_username'");
        
        if(!preg_match("/^[a-zA-Z0-9]{6,12}$/",$new_username))
        {
           $usernameErr="6-12 characters and letters and numbers only";
        }
        else if(mysql_num_rows($query1)!=0)
        {
            $usernameErr="Username already exists";
        }
    }
 //password validation
  if(empty($_POST["pass_up"]))
    {
        $passwordErr="Password is required";
    }
 else 
 {
     $new_pass=test_input($_POST["pass_up"]);
     $new_passarea=$new_pass;
    if(!preg_match("/^[a-zA-Z0-9]{6,12}$/",$new_pass))
    {
       $passwordErr="Invalid password,lenght should be between 6 to 12"; 
    }
 }
 if(empty($_POST["pass_cn"]))
    {
        $passwordcnErr="Confirm Password is required";
    }
 else 
 {
     $new_passcn=test_input($_POST["pass_cn"]);
    if(!preg_match("/^[a-zA-Z0-9]{6,12}$/",$new_passcn))
    {
       $passwordcnErr="Invalid password"; 
    }
    if($new_passarea!=$new_passcn)
    {
        $passwordcnErr="Not same password";
    }
 }
 //email validation
 if(empty($_POST["email"]))
    {
       $emailErr="email is required"; 
    }
    else
    {
        $new_email=test_input($_POST["email"]);
        $query3=mysql_query("SELECT email FROM users WHERE email='$new_email'");
        if(!preg_match("/([\a-zA-z0-9\-\.\_]+\@[\a-zA-Z0-9\-\_]+\.[\a-zA-Z0-9\-\_]+)/",$new_email))
        {
            $emailErr="Invalid email";
        }
        else if(mysql_num_rows($query3)!=0)
        {
            $emailErr="This email already exists";
        }
    }
    //gender validation
     if(empty($_POST["gender"]))
    {
        $genderErr="Gender missing";
    }
    else 
    {
    $new_gender = $_POST["gender"]; 
    }
   //date
   $new_date=date("y/m/d");
   $salt="i_love_you";
   //inserting into database after all varification
   if(!$nameErr && !$lnameErr && !$usernameErr && !$emailErr && !$genderErr && !$passwordErr && !$passwordcnErr)
{
       $new_pass=md5($salt.$new_pass);
       $new_name=  mysql_real_escape_string($new_name);
       $new_lname=  mysql_real_escape_string($new_lname);
       $new_username=  mysql_real_escape_string($new_username);
       $new_email=  mysql_real_escape_string($new_email);
       $new_gender=  mysql_real_escape_string($new_gender);
       
    $ins=mysql_query("insert into users (fname,lname,user_name,password,email,gender,date) values ('$new_name','$new_lname','$new_username', '$new_pass','$new_email', '$new_gender','$new_date')");
    if(!$ins)
    {echo "I will not allow you,contact the admin";}
    else header('location:sign_in.php');
}
}
function test_input($data)     //test_input function
{
  $data=trim($data);                    //for trimming the spaces        
  return $data;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Sign up</title>
        <link rel="stylesheet" type="text/css" href="sticky-footer.css"/>
        <link rel="stylesheet" type="text/css" href="signup.css"/>
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
                    <p class="navbar-text navbar-right"><a href="sign_in.php" class="navbar-link">Sign In</a></p> 
              
                </div>
           </div>
  
</nav>
        <div class="container">
            <form class="form-signin" role="form" action="" method="POST">
                    <input type="text" class="form-control" name="name" value="<?php if(isset($new_name) && !$nameErr) echo $new_name;?>" placeholder="First Name" required autofocus>
                 <?php
                        if($nameErr)
                        {
                        echo "<span class='help-block' style='color:red'>".$nameErr."</span>";
                        }
                        ?>
                <input type="text" class="form-control" name="lname" value="<?php if(isset($new_lname) && !$lnameErr) echo $new_lname;?>" placeholder="Last Name" required>
                <?php
                        if($lnameErr)
                        {
                        echo "<span class='help-block' style='color:red'>".$lnameErr."</span>";
                        }
                        ?>
                <input type="text" class="form-control" name="user_up" value="<?php if(isset($new_username) && !$usernameErr) echo $new_username;?>" placeholder="User Name" required>
                 <?php
                        if($usernameErr)
                        {
                        echo "<span class='help-block' style='color:red'>".$usernameErr."</span>";
                        }
                        ?>
                <input type="password" class="form-control" name="pass_up" value="<?php if(isset($new_pass) && !$passwordErr) echo $new_passarea;?>" placeholder="Password" required>
                <?php
                        if($passwordErr)
                        {
                        echo "<span class='help-block' style='color:red'>".$passwordErr."</span>";
                        }
                        ?>
                <input type="password" class="form-control" name="pass_cn" value="<?php if(isset($new_passcn) && !$passwordcnErr) echo $new_passcn;?>" placeholder="Confirm Password" required>
                <?php
                        if($passwordcnErr)
                        {
                        echo "<span class='help-block' style='color:red'>".$passwordcnErr."</span>";
                        }
                        ?>
                <input type="email" class="form-control" name="email" value="<?php if(isset($new_email) && !$emailErr) echo $new_email;?>" placeholder="Email id" required>
                <?php
                        if($emailErr)
                        {
                        echo "<span class='help-block' style='color:red'>".$emailErr."</span>";
                        }
                        ?>
                <div class="form-inline-radio">
                    <div class="radio radio-container">
                        <label>
                            <input type="radio" name="gender" value="male" <?php if(isset($new_gender) && !$genderErr && $new_gender=='male') echo 'checked="checked"';?>>Male
                        </label>
                        <label style="float:right">
                        <input type="radio" name="gender" value="female" <?php if(isset($new_gender) && !$genderErr && $new_gender=='female') echo 'checked="checked"';?>>Female
                        </label>
                    </div>
                    <?php
                        if($genderErr)
                        {
                        echo "<span class='help-block' style='color:red'>".$genderErr."</span>";
                        }
                        ?>
                </div>
                                    <button class="btn btn-lg btn-primary btn-block" type="submit" style="background: #009999;">Sign Up</button>
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
