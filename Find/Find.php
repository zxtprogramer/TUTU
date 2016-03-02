<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<?php 
require("../dbase/dbFunction.php");
session_start();
$ifLogin=0;
$userName="0"; $userID="0";
$albumName="0"; $albumID="0";
$albumUserID=0;
$nowPage="Find";

if(isset($_SESSION['UserID'])){
	$userName=$_SESSION['UserName'];
	$userID=$_SESSION['UserID'];
	$ifLogin=1;
}


if(isset($_GET['AlbumID'])){
	$albumID=$_GET['AlbumID'];
    $albumUserID=$_GET['AlbumUserID'];
    $sql="SELECT AlbumName FROM AlbumTable WHERE AlbumID='$albumID'";
    $res=exeSQL($sql);
    $row=mysql_fetch_array($res);
    $albumName=$row[0];
}
else{
	$albumID=0;
	$albumUserID=0;
	$albumName='';
}

?>

<html  xmlns="http://www.w3.org/1999/xhtml" lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../css/bootstrap.min.css" rel='stylesheet' type='text/css' />
    <link href="../css/bootstrap-theme.min.css" rel='stylesheet' type='text/css' />
    <link href="../css/Pic.css" rel='stylesheet' type='text/css' />
    <link href="../css/PicPanel.css" rel='stylesheet' type='text/css' />
    <link href="../css/Nav.css" rel='stylesheet' type='text/css' />
    <link href="../css/ToolBar.css" rel='stylesheet' type='text/css' />
    <link href="../css/Modal.css" rel='stylesheet' type='text/css' />
    <title>发现</title>
  </head>

  <body>

<?php 
global $albumID, $albumName, $albumUserID, $userName, $userID;
$gVarHTML="<script type=\"text/javascript\">
		  var albumID=$albumID;
		  var albumUserID=$albumUserID;
		  var userID=$userID;
		  var userName='$userName';
		  var albumName='$albumName';
		</script>";
printf($gVarHTML);

?>
  
   <div id="MapContainer" tabindex="0" ></div>
  <?php 
    require('../Modal/Modal.php');
    require('../Pic/PicPanel.php');
    require('../Nav/Nav.php');
    require('../ToolBar/ToolBar.php');
  ?>
  
      
    
    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script type="text/javascript" src="http://webapi.amap.com/maps?v=1.3&key=605574e6236d5b46cff5ddfe4ac9f437"></script>
    <script src="../js/Find.js"></script>
    <script src="../js/PicPanel.js"></script>
    <script src="../js/Nav.js"></script>
    <script src="../js/ToolBar.js"></script>
 
  </body>
</html>
