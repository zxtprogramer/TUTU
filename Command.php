<?php
require("dbase/dbFunction.php");
session_start();

function getPicInfo($picFile, $lngMax, $lngMin, $latMax, $latMin){
	$shootTime=0;
	$lng=0; $lat=0;

	$exif=exif_read_data($picFile, 0, true);
	eval("\$du=" . $exif['GPS']['GPSLongitude'][0] . ".0;");
	eval("\$fen=" . $exif['GPS']['GPSLongitude'][1] . ".0;");
	eval("\$miao=" . $exif['GPS']['GPSLongitude'][2] . ".0;");
	$lng=$du + $fen/60.0 + $miao/60.0/60.0;
	eval("\$du=" . $exif['GPS']['GPSLatitude'][0] . ".0;");
	eval("\$fen=" . $exif['GPS']['GPSLatitude'][1] . ".0;");
	eval("\$miao=" . $exif['GPS']['GPSLatitude'][2] . ".0;");
	$lat=$du + $fen/60.0 + $miao/60.0/60.0;
	
	$timeStr=$exif['EXIF']['DateTimeOriginal'];
	if($timeStr.length>0){
		$sDate=split(':', split(' ', $timeStr)[0]);
		$year=$sDate[0];
		$month=$sDate[1];
		$day=$sDate[2];
		$sTime=split(':', split(' ', $timeStr)[1]);
		$hour=$sTime[0];
		$min=$sTime[1];
		$sec=$sTime[2];
		$shootTime=mktime($hour, $min, $sec, $month, $day, $year);
	}

	if($shootTime==0){$shootTime=time();}
	if($lng==0 || $lat==0){
		$lng=rand($lngMax*1e7, $lngMin*1e7)/1e7;
		$lat=rand($latMax*1e7, $latMin*1e7)/1e7;
	}
	return [$shootTime, $lng, $lat];
}

function uploadFace($upItem){
	global $userID,$dataPath;

	if ((($_FILES["file"]["type"] == "image/gif")
			|| ($_FILES["file"]["type"] == "image/jpeg")
			|| ($_FILES["file"]["type"] == "image/png")
			|| ($_FILES["file"]["type"] == "image/bmp")
			|| ($_FILES["file"]["type"] == "image/pjpeg"))){

				$filename=$_FILES["file"]["name"];
				$tmpfile=$_FILES["file"]["tmp_name"];
				
				if($upItem==0){
					$pathTmp=$dataPath . "User_" . $userID . "/" .$filename;
					$path=$dataPath . "User_" . $userID . "/UserFace.jpg";
					move_uploaded_file($tmpfile, $pathTmp);
					$cmd="convert -resize 100x100 $pathTmp " . $path;
					system($cmd);
				}
				if($upItem==1){
					$path=$dataPath . "User_" . $userID . "/PageFace.jpg";
					move_uploaded_file($tmpfile, $path);
				}
	}
}



function uploadPic(){
    global $userID,$dataPath;
    
    $sql="SELECT PicNum,PicLimitNum FROM UserInfoTable WHERE UserID='$userID'";
    $res=exeSQL($sql);
    $row=mysql_fetch_array($res);
    $picLimitNum=(int)$row['PicLimitNum'];
    $picNum=(int)$row['PicNum'];
    if($picNum >= $picLimitNum){
    	return;
    }
   
    
    if ($_FILES["file"]["type"] == "video/mp4"){
        $filename=$_FILES["file"]["name"];
        $tmpfile=$_FILES["file"]["tmp_name"];

        $picAlbumID=$_POST['upAlbumID'];

        $path=$dataPath . "User_" . $userID . "/Album_" . $picAlbumID . "/". $filename;
        $wwwPath="/Data/User_" . $userID . "/Album_" . $picAlbumID . "/". $filename;
        move_uploaded_file($tmpfile, $path);

        $snapTmp=$path . "_snapTmp.jpg";
        $cmd="ffmpeg -i $path -ss 00:00:02 -f image2 $snapTmp";
        system($cmd);

        $picSize=getimagesize($snapTmp);

        $snapBigPath=$dataPath . "User_" . $userID . "/AlbumSnapBig_" . $picAlbumID . "/". $filename . ".jpg";
        $snapSmallPath=$dataPath . "User_" . $userID . "/AlbumSnapSmall_" . $picAlbumID . "/". $filename . ".jpg";
        $cmd="convert -resize 200x200 " . $snapTmp . " " . $snapBigPath;
        system($cmd);
        $cmd="convert -resize 60x60 " . $snapTmp . " " . $snapSmallPath;
        system($cmd);
        
        $lngMax=(float)$_POST['lngMax'];
        $lngMin=(float)$_POST['lngMin'];
        $latMax=(float)$_POST['latMax'];
        $latMin=(float)$_POST['latMin'];

        $picInfo=getPicInfo($snapTmp, $lngMax, $lngMin, $latMax, $latMin);

        $shootTime=$picInfo[0];
        $lng=$picInfo[1];
        $lat=$picInfo[2];

        $picDes=$_POST['upPicDes'];
        
        addPic($userID, $filename,$picSize[0],$picSize[1],$picDes,$path,$shootTime,time(),$lng,$lat,0,$picAlbumID);

        $sql="UPDATE UserInfoTable SET PicNum=PicNum+1 WHERE UserID='$userID'";
        exeSQL($sql);
 
    }
 

    if ((($_FILES["file"]["type"] == "image/gif")
    || ($_FILES["file"]["type"] == "image/jpeg")
    || ($_FILES["file"]["type"] == "image/png")
    || ($_FILES["file"]["type"] == "image/bmp")
    || ($_FILES["file"]["type"] == "image/pjpeg"))){
    
        $filename=$_FILES["file"]["name"];
        $tmpfile=$_FILES["file"]["tmp_name"];

        $picAlbumID=$_POST['upAlbumID'];

        $path=$dataPath . "User_" . $userID . "/Album_" . $picAlbumID . "/". $filename;
        $wwwPath="/Data/User_" . $userID . "/Album_" . $picAlbumID . "/". $filename;
        move_uploaded_file($tmpfile, $path);

        $picSize=getimagesize($path);
        $picW=(float)($picSize[0]); $picH=(float)($picSize[1]);

        $pInfo=pathinfo($path);
        $ext=strtolower($pInfo['extension']);

        $snapBigPath=$dataPath . "User_" . $userID . "/AlbumSnapBig_" . $picAlbumID . "/". $filename;
        $snapSmallPath=$dataPath . "User_" . $userID . "/AlbumSnapSmall_" . $picAlbumID . "/". $filename;
        $cmd="convert -resize 1024x1024 " . $path . " " . $snapBigPath;
        system($cmd);
        $cmd="convert -resize 60x60 " . $path . " " . $snapSmallPath;
        system($cmd);
        
        $lngMax=(float)$_POST['lngMax'];
        $lngMin=(float)$_POST['lngMin'];
        $latMax=(float)$_POST['latMax'];
        $latMin=(float)$_POST['latMin'];

        $picInfo=getPicInfo($path, $lngMax, $lngMin, $latMax, $latMin);

        $shootTime=$picInfo[0];
        $lng=$picInfo[1];
        $lat=$picInfo[2];

        $picDes=$_POST['upPicDes'];
        
        addPic($userID, $filename,$picSize[0],$picSize[1],$picDes,$path,$shootTime,time(),$lng,$lat,0,$picAlbumID);

        $sql="UPDATE UserInfoTable SET PicNum=PicNum+1 WHERE UserID='$userID'";
        exeSQL($sql);
        
    }
}


function getData($sql){
    $res=exeSQL($sql);
    $data="";
    while($row=mysql_fetch_array($res,MYSQL_ASSOC)){
	    $item="";
        foreach($row as $key=>$value){
            $keyEn=rawurlencode($key);
            $valueEn=rawurlencode($value);
            $item=$item . $keyEn . "=" . $valueEn . " ";
        }
        if($data=="")$data=trim($item);
        else $data=$data . "#" . trim($item);
    }
    return $data;
}



$ifLogin=0;
$userName=""; $userID="";

if(isset($_SESSION['UserID'])){
    $userName=$_SESSION['UserName'];
    $userID=$_SESSION['UserID'];
    $userEmail=$_SESSION['UserEmail'];
    $ifLogin=1;
}

if(isset($_POST['cmd'])){

    $cmd=$_POST['cmd'];
    switch($cmd){
    	case 'checkUser':
    		$uName=$_POST['checkUserName'];
    		$uEmail=$_POST['checkUserEmail'];
    		$status="";
    		$status=$status . checkUserEmail($uEmail);
			$status=$status . checkUserName($uName);
    		print $status;
    		
    		break;

        case 'editAlbum':
	    if($ifLogin){
            $albumName=$_POST['AlbumName'];
		    $albumDes=$_POST['AlbumDes'];
		    $albumShare=$_POST['AlbumShare'];
		    $albumID=$_POST['AlbumID'];
		    editAlbum($userID, $albumName, $albumDes, time(),$albumShare, $albumID);
	    }
        break;

        case 'newAlbum':
	    if($ifLogin){
            $albumName=$_POST['AlbumName'];
		    $albumDes=$_POST['AlbumDes'];
		    $albumShare=$_POST['AlbumShare'];
		    $sql="SELECT AlbumNum,AlbumLimitNum FROM UserInfoTable WHERE UserID='$userID'";
		    $res=exeSQL($sql);
		    $row=mysql_fetch_array($res);
		    $albumLimitNum=(int)$row['AlbumLimitNum'];
		    $albumNum=(int)$row['AlbumNum'];
		    if($albumNum<$albumLimitNum){
				addAlbum($userID, $albumName, $albumDes, time(),$albumShare);
				$sql="UPDATE UserInfoTable SET AlbumNum=AlbumNum+1 WHERE UserID=$userID";
				exeSQL($sql);
		    }
	    }
        break;

        case 'deleteAlbum':
	    if($ifLogin){
            $albumID=$_POST['AlbumID'];
        	$sql="SELECT PicNum FROM AlbumTable WHERE AlbumID=$albumID";
        	$res=exeSQL($sql);
        	$row=mysql_fetch_array($res);
        	$picNum=(int)$row['PicNum'];
        	$sql="UPDATE UserInfoTable SET PicNum=PicNum-$picNum WHERE UserID=$userID";
        	exeSQL($sql);
        	$sql="UPDATE UserInfoTable SET AlbumNum=AlbumNum-1 WHERE UserID=$userID";
        	exeSQL($sql);
		    deleteAlbum($albumID);
	    }
        break;
        
        case 'delPic':
        	$picID=(int)($_POST['picID']);
        	$sql="SELECT AlbumID FROM PicTable WHERE PicID=$picID AND UserID=$userID";
        	$res=exeSQL($sql);
        	$row=mysql_fetch_array($res);
        	$albumID=$row[0];
        	$sql="DELETE FROM PicTable WHERE PicID=$picID AND UserID=$userID";
        	exeSQL($sql);
        	$sql="UPDATE AlbumTable SET PicNum=PicNum-1 WHERE AlbumID=$albumID AND UserID=$userID";
        	exeSQL($sql);
        	$sql="UPDATE UserInfoTable SET PicNum=PicNum-1 WHERE UserID=$userID";
        	exeSQL($sql);
        	break;
        
        case 'movePic':
        	$picID=(int)($_POST['picID']);
        	$lng=(float)($_POST['lng']);
        	$lat=(float)($_POST['lat']);
        	$sql="UPDATE PicTable SET Longitude=$lng, Latitude=$lat WHERE PicID=$picID AND UserID=$userID";
        	exeSQL($sql);
        	break;
        
        case 'getAlbumPic':
        	$albumID=(int)($_POST['albumID']);
        	$sql="SELECT UserID FROM AlbumTable WHERE AlbumID='$albumID'";
        	$res=exeSQL($sql);
        	$albumUserID=0;
        	if($row=mysql_fetch_array($res)){
        		$albumUserID=$row[0];
        	}
        	else{return;}
        	if((int)$albumUserID==(int)$userID){
		        $sql="SELECT * FROM PicTable WHERE AlbumID=$albumID ORDER BY ShootTime";
        	}
        	else{
		        $sql="SELECT * FROM PicTable WHERE Share='1' AND AlbumID=$albumID ORDER BY ShootTime";
        	}
			print(getData($sql));
        	break;

        case 'getAlbumFace':
        	$albumID=(int)($_POST['albumID']);
        	print(getAlbumFace($albumID));
        	break;

        case 'getAlbumList':
        	$albumUserID=(int)($_POST['albumUserID']);
        	$scrollNum=(int)($_POST['scrollNum']);
        	$onceNum=(int)($_POST['onceNum']);
        	$bgn=$scrollNum*$onceNum;

        	if($albumUserID==0){
    		    $sql="SELECT * FROM AlbumTable WHERE Share='1' AND PicNum>0 ORDER BY CreateTime DESC LIMIT $bgn,$onceNum";
        	}
        	else{
        		if($albumUserID==$userID){
    		        $sql="SELECT * FROM AlbumTable WHERE UserID=$albumUserID ORDER BY CreateTime DESC LIMIT $bgn,$onceNum";
        		}
        		else{
    		        $sql="SELECT * FROM AlbumTable WHERE Share='1' AND UserID=$albumUserID ORDER BY CreateTime DESC LIMIT $bgn,$onceNum";
        		}
        	}
			print(getData($sql));
        	break;
	
	    
		case 'getPic':
			$picNum=(int)($_POST['picNum']);
			$groupNum=(int)($_POST['groupNum']);
			$sortType=$_POST['sortType'];
			$selectType=$_POST['selectType'];
			
			$index=$picNum*$groupNum;
			$sql="";
			switch($selectType){

     		case "All":
				$sql="SELECT * FROM PicTable ORDER BY $sortType desc LIMIT $index,$picNum";
				break;
			case "AllRange":
				$latMax=(double)($_POST['latMax']);
				$latMin=(double)($_POST['latMin']);
				$lngMax=(double)($_POST['lngMax']);
				$lngMin=(double)($_POST['lngMin']);
				$sql="SELECT * FROM PicTable WHERE Share='1' AND Longitude<$lngMax AND Longitude>$lngMin AND Latitude<$latMax AND Latitude>$latMin ORDER BY $sortType LIMIT $index,$picNum";
				break;

			case "UserRange":
				$latMax=(double)($_POST['latMax']);
				$latMin=(double)($_POST['latMin']);
				$lngMax=(double)($_POST['lngMax']);
				$lngMin=(double)($_POST['lngMin']);
				$userID=$_POST['userID'];
				$sql="SELECT * FROM PicTable WHERE UserID=$userID AND Longitude<$lngMax AND Longitude>$lngMin AND Latitude<$latMax AND Latitude>$latMin ORDER BY $sortType LIMIT $index,$picNum";
				break;

			case "AlbumRange":
				$latMax=(double)($_POST['latMax']);
				$latMin=(double)($_POST['latMin']);
				$lngMax=(double)($_POST['lngMax']);
				$lngMin=(double)($_POST['lngMin']);
				$albumID=$_POST['albumID'];
				$sql="SELECT * FROM PicTable WHERE AlbumID=$albumID AND Longitude<$lngMax AND Longitude>$lngMin AND Latitude<$latMax AND Latitude>$latMin ORDER BY $sortType LIMIT $index,$picNum";
				break;
			}
			
			print(getData($sql));
			break;

		case 'getComment':
			$picID=$_POST['picID'];
			$sql="SELECT * FROM CommentTable WHERE PicID=$picID";
			print(getData($sql));
			break;

		case 'getAlbum':
			$albumUserID=intval($_POST['albumUserID']);
			if($albumUserID<=0){
				$sql="SELECT * FROM AlbumTable WHERE AlbumName!='Face' and AlbumName!='Default'";
			}
			else{
				$sql="SELECT * FROM AlbumTable WHERE UserID=$albumUserID";
			}
			print(getData($sql));
			break;



		case 'sendComment':
			if($ifLogin==1){
				$cmt=$_POST['cmt'];
				$picID=$_POST['picID'];
				addComment($userID, $picID, $cmt, time());
			}
			else{
			}
			break;

		case 'addLike':
			if($ifLogin==1){
				$picID=$_POST['picID'];
				addLike($userID, $picID,time());
			}
			else{
			}
			break;

		case 'uploadPic':
			if($ifLogin==1){
				$picAlbumID=$_POST['upAlbumID'];
				$sql="SELECT * FROM AlbumTable WHERE AlbumID=$picAlbumID AND UserID=$userID";
				$res=exeSQL($sql);
				$row=mysql_fetch_array($res);
				if(!empty($row)){
				    uploadPic();
				}
			}
			break;
			
		case 'uploadFace':
			if($ifLogin==1){
				$upItem=(int)$_POST['upItem'];
				uploadFace($upItem);
			}
			break;

		default:
			print("Error");
			break;
    }
}

?>
