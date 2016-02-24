<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<?php 
require("../dbase/dbFunction.php");
session_start();
$ifLogin=0;
$userName=""; $userID="";$userEmail="";
$nowPage='Album';

if(isset($_SESSION['SessionID'])){
	$sessionID=$_SESSION['SessionID'];
	$res=getUserFromSessionID($sessionID);
	if(sizeof($res)>1){
		$userName=$res['UserName'];
		$userID=$res['UserID'];
		$userEmail=$res['Email'];
		$ifLogin=1;
	}
}

if($ifLogin==0){
	header("Location: /index.php");
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
    <link href="../css/User.css" rel='stylesheet' type='text/css' />
    <title>相册</title>
  </head>

  <body>
  
  <?php 
    require("../Nav/Nav.php");
    //require("../ToolBar/ToolBar.php");
  ?>
 

    <div class="container-fluid HomeMain" id="UserMain"> 
      <div class="row UserSpaceWhite"></div>

      <div class="row UserItemBig">
        <div class="col-xs-12">
          <?php 
            $str='<img onclick="upItem=0" data-toggle="modal" data-target="#uploadFaceModal" class="UserFaceImg" src="/Data/User_' . $userID . '/UserFace.jpg"></img>';
            print($str);
          ?>

          <div class="UserInfoItem">
            <?php 
            $str="<h4> $userName</h4><h6> $userEmail</h6>";
            print($str);
            ?>
          </div>

        </div>
      </div>

      <div class="row UserItem" onclick="upItem=1;" data-toggle="modal" data-target="#uploadFaceModal">
        <div class="col-xs-12">
          <span class="glyphicon glyphicon-picture"></span>  封面
        </div>
      </div>

      <div class="row UserSpaceBlack"></div>

      
      <div class="row UserItem" onclick="self.location='/UserPage/UserPage.php'">
        <div class="col-xs-12">
          <span class="glyphicon glyphicon-th"></span>  相册 
        </div>
      </div>

      <div class="row UserItem">
        <div class="col-xs-12">
          <span class="glyphicon glyphicon-star"></span>  收藏 
        </div>
      </div>

       <div class="row UserItem">
        <div class="col-xs-12">
          <span class="glyphicon glyphicon-info-sign"></span>  消息 
        </div>
       </div>
      
      
      <div class="row UserSpaceBlack"></div>

      <div class="row UserItem" onclick="self.location='/Login/Logout.php'">
        <div class="col-xs-12">
          <span class="glyphicon glyphicon-log-out"></span>  注销
        </div>
      </div>
    </div>
    
    
<!-- UploadFace -->
<div class="modal fade" id="uploadFaceModal" tabindex="-1" role="dialog" aria-labelledby="uploadFaceModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="uploadFaceModalLabel">上传</h4>
      </div>
      <div class="modal-body"> 
        <input id="UploadFace" name="files" type="file" multiple accept="image/*"></input>
        <br />
		<ul id="UploadList" class="list-group">
        </ul>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <button type="button" class="btn btn-primary" onclick="uploadFace();">上传</button>
      </div>
    </div>
  </div>
</div>
    
    
    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/Nav.js"></script>
    <script src="../js/User.js"></script>
 
  </body>
</html>
