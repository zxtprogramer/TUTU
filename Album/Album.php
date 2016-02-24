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
    <link href="../css/Nav.css" rel='stylesheet' type='text/css' />
    <link href="../css/ToolBar.css" rel='stylesheet' type='text/css' />
    <title>相册</title>
  </head>

  <body>
  
  <?php 
    require("../Nav/Nav.php");
    require("../ToolBar/ToolBar.php");
  ?>
 

    <div class="container-fluid">

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
                $albumDes<br >
                <a href=\"/Pic/Pic.php?AlbumID=$albumID&AlbumUserID=$userID\"><img style=\"width:100%;\" class=\"img-responsive\" src=\"$facePath\" /></a>
                <br />
              </div>

              <div class=\"panel-footer\">
                <div class=\"btn-group\" role=\"group\">
				  <a type=\"button\" class=\"btn btn-default\" href=\"/Pic/Pic.php?AlbumID=$albumID&AlbumUserID=$userID\"><span class=\"glyphicon glyphicon-globe\"></span></a>
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
    
    
      <div class="row" style="height:50px;">
      </div>

    </div>
    
    
    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/Album.js"></script>
 
  </body>
</html>
