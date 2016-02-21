<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<?php 
require("../dbase/dbFunction.php");
session_start();
$ifLogin=0;
$userName=""; $userID="";

if(isset($_SESSION['SessionID'])){
	$sessionID=$_SESSION['SessionID'];
	$res=getUserFromSessionID($sessionID);
	if(sizeof($res)>1){
		$userName=$res['UserName'];
		$userID=$res['UserID'];
		$ifLogin=1;
	}
}

if($ifLogin==0){
	header("Location: ../Login/Login.php");	
}

?>

<html  xmlns="http://www.w3.org/1999/xhtml" lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../css/bootstrap.min.css" rel='stylesheet' type='text/css' />
    <link href="../css/bootstrap-theme.min.css" rel='stylesheet' type='text/css' />
    <title>相册</title>
  </head>

  <body>
  
  <?php 
    require("AlbumNav.php");
  ?>
 
<!-- New Album Modal -->
<div class="modal fade" id="newAlbumModal" tabindex="-1" role="dialog" aria-labelledby="newAlbumModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">新建相册</h4>
      </div>
      <div class="modal-body">
        <div class="input-group">
          <span class="input-group-addon">名称</span>
          <input type="text" class="form-control" id="newAlbumName"></input>
        </div>
        <br />
        <div class="input-group">
          <span class="input-group-addon">描述</span>
          <input type="text" class="form-control" id="newAlbumDes"></input>
        </div>
 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="newAlbum();">新建</button>
      </div>
    </div>
  </div>
</div>

    <div class="container-fluid">
   
      <div class="row" style="height:50px;">
      </div>


     <?php 
    $sql="SELECT * FROM AlbumTable WHERE UserID='$userID'";
    $res=exeSQL($sql);
    while($row=mysql_fetch_array($res,MYSQL_ASSOC)){
    	$picNum=intval($row['PicNum']);
    	$albumName=$row['AlbumName'];
    	$albumID=$row['AlbumID'];
    	$albumDes=$row['Description'];
    	$createTime=intval($row['CreateTime']);
    	$timeStr=date("Y-m-d H:m:s", $createTime);
    	$facePath="";
    	if($picNum>0){
    		$facePath=getAlbumFace($albumID);
    	}

    	$albumOutStr="
		<div class=\"row\">
          <div class=\"col-xs-12\">

            <div class=\"panel panel-primary\">
              <div class=\"panel-heading\">$albumName ($timeStr) <span class=\"badge\">$picNum</span></div>

              <div class=\"panel-body\">
                <a href=\"/Pic/Pic.php?AlbumID=$albumID&albumUserID=$userID\"><img style=\"width:100%;\" class=\"img-responsive\" src=\"$facePath\" /></a>
                <br />
                $albumDes
              </div>

              <div class=\"panel-footer\">
                <div class=\"btn-group\" role=\"group\">
				  <button type=\"button\" class=\"btn btn-default\"><a href=\"/Pic/Pic.php?AlbumID=$albumID&albumUserID=$userID\"><span class=\"glyphicon glyphicon-globe\"></span></a></button>
				  <button type=\"button\" class=\"btn btn-default\"><span class=\"glyphicon glyphicon-download-alt\"></span></button>
				  <button type=\"button\" class=\"btn btn-default\"><span class=\"glyphicon glyphicon-pencil\"></span></button>
				  <button type=\"button\" class=\"btn btn-default\"><span class=\"glyphicon glyphicon-trash\" onclick=\"deleteAlbum($albumID)\"></span></button>
			    </div>
              </div>
            </div>

          </div>
        </div> ";
    	
       print($albumOutStr);
    	
    }
    
    ?>
    
    </div>
    
    
    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/Album.js"></script>
 
  </body>
</html>
