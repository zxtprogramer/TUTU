<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<?php 
require("../dbase/dbFunction.php");
session_start();
$ifLogin=0;
$userName=""; $userID="";
$nowPage='Album';

if(isset($_SESSION['SessionID'])){
	$sessionID=$_SESSION['SessionID'];
	$res=getUserFromSessionID($sessionID);
	if(sizeof($res)>1){
		$userName=$res['UserName'];
		$userID=$res['UserID'];
		$ifLogin=1;
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
    <link href="../css/Nav.css" rel='stylesheet' type='text/css' />
    <link href="../css/ToolBar.css" rel='stylesheet' type='text/css' />
    <link href="../css/Home.css" rel='stylesheet' type='text/css' />
    <title>首页</title>
  </head>

  <body>
  
  <?php 
    require("../Nav/Nav.php");
    //require("../ToolBar/ToolBar.php");
  ?>
 

    <div class="container-fluid HomeMain" id="HomeMain"> </div>
    
    
    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/Nav.js"></script>
    <script src="../js/Home.js"></script>
 
  </body>
</html>
