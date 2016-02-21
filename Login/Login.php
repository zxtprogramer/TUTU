<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
  require("../dbase/dbFunction.php");
  if(isset($_POST['submitLogin'])){
      $email=$_POST['Email'];
      $password=$_POST['Password'];
      if(checkLogin($email, $password)){
	      session_start();
	      $sessionID=md5(time());
		  $_SESSION['SessionID']=$sessionID;
		  $sql="UPDATE UserInfoTable SET SessionID='$sessionID' WHERE Email='$email'";
		  exeSQL($sql);
		  echo "<script type=text/javascript>window.location=\"/Album/Album.php\";</script>";
	  }
  }
?>

<html  xmlns="http://www.w3.org/1999/xhtml" lang="en">
  <head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../css/bootstrap.min.css" rel='stylesheet' type='text/css' />
    <link href="../css/bootstrap-theme.min.css" rel='stylesheet' type='text/css' />
    <title>登录</title>
  </head>

  <body>
    <div class="container">
      <div class="row">
        <div class="col-xs-2"></div>

        <div class="col-xs-8">
          <form action="" method="post">
            <div class="form-group">
              <h2 class="text-center"><a href="/Login/Login.php">登录</a>/<a href="/Register/Register.php">注册</a></h2>
		      <label>邮箱</label>
		      <input type="text" class="form-control" name="Email" aria-label="邮箱" placeholder="邮箱">
		      <label>密码</label>
		      <input type="password" class="form-control" name="Password" aria-label="密码" placeholder="密码">
		
		      <input type="hidden" name="submitLogin" value="Register">
		
		      <br />
		      <input type="submit" class="btn btn-primary btn-block" value="登录" >
            
            </div>
          </form>
        </div>

        <div class="col-xs-2"></div>
      </div>
    </div>


  </body>
</html>
