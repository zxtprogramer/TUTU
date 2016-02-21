<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<?php 
require("../dbase/dbFunction.php");
session_start();
$ifLogin=0;
$userName="0"; $userID="0";
$albumName="0"; $albumID="0";

if(isset($_SESSION['SessionID'])){
	$sessionID=$_SESSION['SessionID'];
	$res=getUserFromSessionID($sessionID);
	if(sizeof($res)>1){
		$userName=$res['UserName'];
		$userID=$res['UserID'];
		$ifLogin=1;
	}
}


if(isset($_GET['AlbumID'])){
	$albumID=$_GET['AlbumID'];
    $albumUserID=$_GET['AlbumUserID'];
}

if($albumID==""){
	header("Location: ../Album/Album.php");	
}

$gVarHTML="<script type=\"text/javascript\">
		  var albumID=$albumID;
		  var albumUserID=$albumUserID;
		  var userID=$userID;
		  var userName=$userName;
		</script>";
printf($gVarHTML);

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
    <title>图片</title>
  </head>

  <body>
  <?php 
    require('PicPanel.php');
    require('../Nav/Nav.php');
  ?>
  
  
  
  <!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="loginModalLabel">登录</h4>
      </div>
      <div class="modal-body">
        <div class="input-group">
          <span class="input-group-addon">邮箱</span>
          <input type="text" class="form-control" id="LoginEmail"></input>
        </div>
        <br />
        <div class="input-group">
          <span class="input-group-addon">密码</span>
          <input type="password" class="form-control" id="LoginPassword"></input>
        </div>
 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="quickLogin();">登录</button>
      </div>
    </div>
  </div>
</div>
  
  
<!-- Upload Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="uploadModalLabel">上传</h4>
      </div>
      <div class="modal-body"> 
        <input id="UploadFile" name="files" type="file" multiple accept="image/*, video/*"></input>
        <br />
        <ul id="UploadList" class="list-group">
        </ul>
        
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="upload();">上传</button>
      </div>
    </div>
  </div>
</div>
  
  
  
  
    <div id="MapContainer" tabindex="0" ></div>
    <div id="ToolBar" tabindex="1">
      <div class="btn-group" role="group">
        <button type="button" class="btn btn-default" onclick="javascript:beforePic();" id="BeforeBtn"><span class="glyphicon glyphicon-chevron-left"></span></button>
        <button type="button" class="btn btn-default" onclick="javascript:nextPic();" id="NextBtn"><span class="glyphicon glyphicon-chevron-right"></span></button>
      </div>
      
      <?php 
      if($ifLogin==1 && $albumUserID==$userID){
      	$editBar='
			<div class="btn-group" role="group">
			  <button type="button" class="btn btn-default" data-toggle="modal" data-target="#uploadModal" id="UploadBtn"><span class="glyphicon glyphicon-open"></span></button>
			  <button type="button" class="btn btn-default" onclick="javascript:movePic()" id="MoveBtn"><span class="glyphicon glyphicon-move"></span></button>
			  <button type="button" class="btn btn-danger" onclick="javascript:delPic()" id="DeleteBtn"><span class="glyphicon glyphicon-trash"></span></button>
		    </div>
		';
      	print($editBar);
      	

      }
      ?>
    </div>
    
    
 
    
    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script type="text/javascript" src="http://webapi.amap.com/maps?v=1.3&key=605574e6236d5b46cff5ddfe4ac9f437"></script>
    <script src="../js/Pic.js"></script>
    <script src="../js/PicPanel.js"></script>
 
  </body>
</html>
