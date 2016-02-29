<?php 
require("../dbase/dbFunction.php");
session_start();
$ifLogin=0;
$userName=""; $userID="";
$nowPage='Album';

if(isset($_SESSION['SessionID'])){
    $userName=$_SESSION['UserName'];
    $userID=$_SESSION['UserID'];
    $userEmail=$_SESSION['UserEmail'];
    $ifLogin=1;
}

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html  xmlns="http://www.w3.org/1999/xhtml" lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../css/bootstrap.min.css" rel='stylesheet' type='text/css' />
    <link href="../css/bootstrap-theme.min.css" rel='stylesheet' type='text/css' />
    <link href="../css/Nav.css" rel='stylesheet' type='text/css' />
    <title></title>
  </head>

  <body>
  
  <?php 
    require("../Nav/Nav.php");
  ?>
   
  
    <div class="container">
      <div class="row">
        <div class="col-xs-1"></div>
        <div class="col-xs-10">
        <h3>帮助文档</h3>
         1. 打开手机相机的GPS定位功能，拍摄照片，这样，照片中就会存放当时的定位信息。上传后，就可自动在地图上定位。 若没有定位信息，只能自己手动定位。视频文件，只能自己手动定位。<br />
         <br />
         2. 目前只有网页版，没有客户端。网页主要针对手机端，在电脑上显示比较难看, 可以把宽度调小。<br />
         <br />
         3. 电脑上一次可以上传多张图片，手机每次只能传一张。<br />
         <br />
         4. 若显示或者某些功能有问题，建议使用chrome等对HTML5支持较好的浏览器。<br /> 
         <br />
         5. 网站还没有起名字，初步打算叫 “途图”、“22网”。。。欢迎提供好的建议。
         <br />
         
         Tong Email:zxt@pku.edu.cn
        
        </div>

        <div class="col-xs-1"></div>
      </div>
    </div>

    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/Nav.js"></script>
  </body>
</html>
