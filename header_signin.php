<?php
include 'connect.php';
echo '<nav class="navbar navbar-default" role="navigation">
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
                   <ul class="nav navbar-nav navbar-right">
        <li><a class="btn btn-success btn-sm" href="#">'.$_SESSION["user_name"].'</a></li>
        <li><a class="btn btn-success btn-sm" href="home.php">Home</a></li>
        <li><a class="btn btn-success btn-sm" href="sign_out.php">Sign Out</a></li>
        </ul>
              </div>
           </div>
  
</nav>';
?>
