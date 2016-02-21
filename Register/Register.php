<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
  require("../dbase/dbFunction.php");
  if(isset($_POST['submitRegister'])){
      $userName=$_POST['UserName'];
	  $password=$_POST['Password'];
	  $email=$_POST['Email'];
	  if(addUser($userName, $password, $email)==0){
          header("Location: ../Login/Login.php");
	  }
	  else{
	  	printf("注册失败<br>");
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
    <title>注册</title>
  </head>

  <body>
  
    <div class="container">
      <div class="row">
        <div class="col-xs-2"></div>

        <div class="col-xs-8">
          <form action="" method="post">
            <div class="form-group">
              <h2 class="text-center"><a href="/Register/Register.php">注册</a>/<a href="/Login/Login.php">登录</a></h2>
		      <label>用户名</label>
		      <input type="text" class="form-control" name="UserName" aria-label="用户名" placeholder="用户名">
		      <label>邮箱</label>
		      <input type="text" class="form-control" name="Email" aria-label="邮箱" placeholder="邮箱">
		      <label>密码</label>
		      <input type="password" class="form-control" name="Password" aria-label="密码" placeholder="密码">
		
		      <input type="hidden" name="submitRegister" value="Register">
		
		      <br />
		      <input type="submit" class="btn btn-primary btn-block" value="注册" >
            
            </div>
          </form>
        </div>

        <div class="col-xs-2"></div>
      </div>
    </div>


  </body>
</html>
