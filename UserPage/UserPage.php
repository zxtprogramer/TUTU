<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<?php 
require("../dbase/dbFunction.php");
session_start();
$ifLogin=0;
$userName=""; $userID=0;
$nowPage='UserPage';
$pageUserID="0"; $pageUserName="0";
$ifUserOwn=0;

if(isset($_SESSION['UserID'])){
    $userName=$_SESSION['UserName'];
    $userID=$_SESSION['UserID'];
    $userEmail=$_SESSION['UserEmail'];
    $ifLogin=1;
}

if(isset($_GET['PageUserID'])){
	$pageUserID=$_GET['PageUserID'];
    $pageUserName=getUserName($pageUserID);
}
else{
	if($ifLogin==1){
		$pageUserID=$userID;
	}
}


if($pageUserID==$userID){
	$ifUserOwn=1;
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
    <link href="../css/Modal.css" rel='stylesheet' type='text/css' />
    <link href="../css/UserPage.css" rel='stylesheet' type='text/css' />
    <title>相册</title>
  </head>

  <body>
  
  <?php 
    require("../Modal/Modal.php");
    require("../Nav/Nav.php");

    global $albumID, $albumName, $albumUserID, $userName, $userID,$pageUserName,$pageUserID;
    $gVarHTML="<script type=\"text/javascript\">
    var userID=$userID;
    var userName='$userName';
    var pageUserID=$pageUserID;
    var pageUserName='$pageUserName';
    var ifUserOwn=$ifUserOwn;
    </script>";
    print($gVarHTML);
  ?>
  

    <div class="container-fluid UserPageMain" id="UserPageMain"> 
      <div class="row PageFace">
      <?php 
        $str="<div class=\"PageFaceDiv\"><img class=\"PageFaceImg\" src=\"/Data/User_$pageUserID/PageFace.jpg\" ></img></div>" .
              "<div class=\"PageUserTitleDiv\">" ;
        if($ifUserOwn==1){
        	$str=$str . "<a href=\"/User/User.php\"><img class=\"PageUserFaceImg\" src=\"/Data/User_$pageUserID/UserFace.jpg\" ></img></a>";
        }
        else{
        	$str=$str . "<img class=\"PageUserFaceImg\" src=\"/Data/User_$pageUserID/UserFace.jpg\" ></img>";
        }
        $str=$str . "<div class=\"PageUserInfoDiv\" style=\"font-size:20px;color:white\"> $pageUserName</div></div>";  
        if($ifUserOwn==1){
        	$str=$str . '
			     <div id="NewAlbumDiv" style="font-size:50px"><span class="glyphicon glyphicon-camera" data-toggle="modal" data-target="#newAlbumModal" id="NewAlbumBtn" ></span></div>';
        }
        print($str);
      ?>
      </div>

    </div>
    
    
    <script src="../js/jquery.min.js"></script>
    <script src="../js/jquery.md5.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/Nav.js"></script>
    <script src="../js/UserPage.js"></script>
 
  </body>
</html>
