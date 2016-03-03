<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<?php 
require("../dbase/dbFunction.php");
session_start();
$ifLogin=0;
$userName="0"; $userID="0";
$albumName="0"; $albumID="0";
$albumUserID=0;
$nowPage="CheckShareCode";

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
    <title>分享码</title>
  </head>

  <body>
  <?php 
    require('../Modal/Modal.php');
  ?>
 
     
    
    <script src="../js/jquery.min.js"></script>
    <script src="../js/jquery.md5.js"></script>
    <script src="../js/bootstrap.min.js"></script>

  <script type="text/javascript">
    <?php
        $albumID=$_GET['AlbumID'];
        print "var albumID=" . $albumID .";";
    ?>

    $("#checkShareCodeModal").modal("show");

    function checkShareCode(){
        sCode=$("#CheckShareCodeInput").val();
        $.post("/Command.php",{"cmd":"checkShareCode", "AlbumID":albumID, "ShareCode":sCode},function(text,status){
            self.location.href="/Pic/Pic.php?AlbumID=" + albumID;
        });
    
    }
  </script>

 
 

 
  </body>
</html>
