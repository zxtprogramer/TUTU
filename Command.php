<?php
require("dbase/dbFunction.php");
session_start();

function uploadPic(){
    global $userID;


    if ($_FILES["file"]["type"] == "video/mp4"){
        $filename=$_FILES["file"]["name"];
        $tmpfile=$_FILES["file"]["tmp_name"];
        $md5=md5_file($tmpfile);

        $dirPath="/var/www/html/Data/" . $userID;
        if(!file_exists($dirPath)){
            mkdir($dirPath);
        }

        $path="/var/www/html/Data/" . $userID . "/" . $md5 ."_". $filename;
        $path2="/Data/" . $userID . "/" . $md5 ."_". $filename;
        move_uploaded_file($tmpfile, $path);

        $snapTmp=$path . "_snapTmp.jpg";
        $cmd="ffmpeg -i $path -ss 00:00:02 -f image2 $snapTmp";
        system($cmd);

        $picSize=getimagesize($snapTmp);
        $picW=(float)($picSize[0]); $picH=(float)($picSize[1]);

        $snap2W=100; $snap2H=100;
        if($picW<$picH){
            $snap2W=100;
            $snap2H=(int)(100.0/$picW*$picH);
        }else{
            $snap2H=100;
            $snap2W=(int)(100.0/$picH*$picW);
        }

        $snap2Path=$path . "_snap2.jpg";
        $cmd="convert -resize " . $snap2W. "x" . $snap2H ." ". $snapTmp . " " . $snap2Path;
        system($cmd);
    
        $picDes=$_POST['upPicDes'];
        $picPos=$_POST['upPicPos'];
        $picAlbumID=$_POST['upAlbumID'];

        $longitude=split(",", $picPos)[0];
        $latitude=split(",", $picPos)[1];

        addPic($userID, $filename,$picSize[0],$picSize[1],$picDes,$path2,time(),time(),$longitude,$latitude,0,$picAlbumID);
    }
 

    if ((($_FILES["file"]["type"] == "image/gif")
    || ($_FILES["file"]["type"] == "image/jpeg")
    || ($_FILES["file"]["type"] == "image/png")
    || ($_FILES["file"]["type"] == "image/bmp")
    || ($_FILES["file"]["type"] == "image/pjpeg"))){
    
        $filename=$_FILES["file"]["name"];
        $tmpfile=$_FILES["file"]["tmp_name"];
        $md5=md5_file($tmpfile);

        $dirPath="/var/www/html/Data/" . $userID;
        if(!file_exists($dirPath)){
            mkdir($dirPath);
        }
        $path="/var/www/html/Data/" . $userID . "/" . $md5 ."_". $filename;
        $path2="/Data/" . $userID . "/" . $md5 ."_". $filename;
        move_uploaded_file($tmpfile, $path);

        $picSize=getimagesize($path);
        $picW=(float)($picSize[0]); $picH=(float)($picSize[1]);

        $snap2W=100; $snap2H=100;
        if($picW<$picH){
            $snap2W=100;
            $snap2H=(int)(100.0/$picW*$picH);
        }else{
            $snap2H=100;
            $snap2W=(int)(100.0/$picH*$picW);
        }

        $pInfo=pathinfo($path);
        $ext=strtolower($pInfo['extension']);

        
    
        $snapPath=$path . "_snap." . $ext;
        $snap2Path=$path . "_snap2." . $ext;
        $cmd="convert -resize 400x300 " . $path . " " . $snapPath;
        system($cmd);
        $cmd="convert -resize " . $snap2W. "x" . $snap2H ." ". $path . " " . $snap2Path;
        system($cmd);
    
        $picDes=$_POST['upPicDes'];
        $picPos=$_POST['upPicPos'];
        $picAlbumID=$_POST['upAlbumID'];

        $longitude=split(",", $picPos)[0];
        $latitude=split(",", $picPos)[1];

        addPic($userID, $filename,$picSize[0],$picSize[1],$picDes,$path2,time(),time(),$longitude,$latitude,0,$picAlbumID);
    }
    header("Location: /upload.php");
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

if(isset($_SESSION['SessionID'])){
	$sessionID=$_SESSION['SessionID'];
	$res=getUserFromSessionID($sessionID);
	if(sizeof($res)>1){
        $userName=$res['UserName'];
		$userID=$res['UserID'];
		$ifLogin=1;
	}
}

if(isset($_POST['cmd'])){

    $cmd=$_POST['cmd'];
    switch($cmd){
        case 'newAlbum':
	    if($ifLogin){
            $albumName=$_POST['AlbumName'];
		    $albumDes=$_POST['AlbumDes'];
		    addAlbum($userID, $albumName, $albumDes, time());
	    }
        break;

        case 'deleteAlbum':
	    if($ifLogin){
            $albumID=$_POST['AlbumID'];
		    deleteAlbum($albumID);
	    }
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
		    $sql="SELECT * FROM PicTable WHERE Longitude<$lngMax AND Longitude>$lngMin AND Latitude<$latMax AND Latitude>$latMin ORDER BY $sortType LIMIT $index,$picNum";
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
            $picAlbumName=$_POST['upAlbumName'];
            $sql="SELECT * FROM AlbumTable WHERE AlbumID=$picAlbumID AND UserID=$userID";
            $res=exeSQL($sql);
            $row=mysql_fetch_array($res);
            if(empty($row)){
                $sql="SELECT AlbumID FROM AlbumTable WHERE UserID=$userID AND AlbumName='Default'";
                $res=exeSQL($sql);
                $row=mysql_fetch_array($res);
                $_POST['upAlbumID']=$row[0];
            }
		    uploadPic();
        }
        break;

	default:
	    print("Error");
	    break;
    }
}

?>
