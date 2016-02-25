<?php
$dbVersion="V0";
$dbHost="localhost";
$dbUser="zxt";
$dbPwd="t";
$dbName="TUTU_" . $dbVersion;

$dbRoot="root";
$dbRootPwd="1qaz2wsx";

$dataPath="/var/www/html/Data/";
$rootPath="/var/www/html/";

function createDB(){
    global $dbHost, $dbUser, $dbPwd, $dbName, $dbRoot, $dbRootPwd;
    $con = connectDB($dbHost, $dbRoot, $dbRootPwd);

    $sql = "CREATE DATABASE $dbName";
    if(mysql_query($sql, $con)){
        mysql_query("GRANT ALL ON $dbName.* TO $dbUser@'%'", $con);
        mysql_query("GRANT create routine ON $dbName" . ".*" . "TO $dbUser@'%'", $con);

    }
    else{printf("Create Database Failed\n");}
    mysql_close($con);

}

function clearDB(){
    global $dbHost, $dbUser, $dbPwd, $dbName, $dbRoot, $dbRootPwd;
    $con = connectDB($dbHost, $dbRoot, $dbRootPwd);

    $sql = "DROP DATABASE $dbName";
    mysql_query($sql, $con);
    mysql_close($con);
}


function connectDB($host, $name, $pwd){
    $con = mysql_connect($host, $name, $pwd);
    if(!$con){
        print("connect error\n");
    }
    return $con;
}

function exeSQL($sql){
    global $dbHost, $dbUser, $dbPwd, $dbName;
    $con=connectDB($dbHost, $dbUser, $dbPwd);
    mysql_select_db($dbName, $con);
    $result=mysql_query($sql, $con);
    mysql_close($con);
    return $result;
}

function createTable($xmlFile){
    $xml=simplexml_load_file($xmlFile);

    foreach ($xml->children() as $table){
	$tableName=$table->getName();
	$itemArray=array();
	foreach ($table->children() as $tableItem){
	    $itemName=$tableItem->getName();
	    $item=$tableItem;
	    array_push($itemArray, $itemName . " " . $item);
	}
	$sql="CREATE TABLE $tableName (" . join(",", $itemArray) . ")";
	//echo $sql . "\n";
	if(!exeSQL($sql)){echo "Create table $tableName failed\n";}
		
    }
    $sql="ALTER TABLE LikeTable ADD UNIQUE KEY(UserID,PicID)";
	if(!exeSQL($sql)){echo "Alert LikeTable failed \n";}
}


function init(){
    clearDB();
    createDB();
    createTable("DbDesign.xml");
}

function addUser($userName, $password, $email){
	global $dataPath,$rootPath;
    if(checkUser($userName, $email)>0) return;
    $sql="INSERT INTO UserInfoTable (UserName,Password,Email) VALUES('$userName','$password','$email')";
    if(!exeSQL($sql)){return -1;}//printf("add user $userName failed\n");
    $sql="SELECT UserID from UserInfoTable WHERE UserName='$userName'";
    $res=exeSQL($sql);
    $row=mysql_fetch_array($res);
    $userID=$row[0];

    $dirPath=$dataPath . "User_" . $userID;
    if(!file_exists($dirPath)){
    	mkdir($dirPath);
    }
    copy($rootPath . "images/UserFace.jpg", $dirPath . '/UserFace.jpg');
    copy($rootPath . "images/PageFace.jpg", $dirPath . '/PageFace.jpg');
    return 0;
}

function getAlbumFace($albumID){
	global $dataPath;
    $sql="SELECT PicName,UserID FROM PicTable WHERE AlbumID='$albumID' LIMIT 0,1";
    $res=exeSQL($sql);
    $row=mysql_fetch_array($res);
    $picName=$row['PicName'];
    $userID=$row['UserID'];
    //$facePath="/Data/User_" . $userID . "/Album_" . $albumID . "/" . $picName;
    $facePath="/Data/User_" . $userID . "/AlbumSnapBig_" . $albumID . "/" . $picName;
    return $facePath;
}

function editAlbum($userID, $albumName, $des, $createTime,$ifShare,$albumID){
	global $dataPath;
    $userName=getUserName($userID);
    $sql="UPDATE AlbumTable SET AlbumName='$albumName',Description='$des',Share='$ifShare' WHERE UserID='$userID' AND AlbumID='$albumID'";
    if(!exeSQL($sql)){printf("edit album $albumName failed");}
    $sql="UPDATE PicTable SET Share='$ifShare' WHERE AlbumID='$albumID'";
    if(!exeSQL($sql)){printf("edit2 album $albumName failed");}
}



function addAlbum($userID, $albumName, $des, $createTime,$ifShare){
	global $dataPath;
    $userName=getUserName($userID);
    $sql="INSERT INTO AlbumTable (UserID,UserName,AlbumName,Description,CreateTime,Share) VALUES('$userID', '$userName', '$albumName', '$des', '$createTime', '$ifShare')";
    if(!exeSQL($sql)){printf("add album $albumName failed");}
    $sql="SELECT AlbumID FROM AlbumTable WHERE AlbumName='$albumName'";
    $res=exeSQL($sql);
    $row=mysql_fetch_array($res);
    $albumID=$row[0];
    $albumPath=$dataPath . "User_" . $userID . "/Album_" . $albumID;
    if(!file_exists($albumPath)){
    	mkdir($albumPath);
    }
    $snapBigPath=$dataPath . "User_" . $userID . "/AlbumSnapBig_" . $albumID;
    if(!file_exists($snapBigPath)){
    	mkdir($snapBigPath);
    }
    $snapSmallPath=$dataPath . "User_" . $userID . "/AlbumSnapSmall_" . $albumID;
    if(!file_exists($snapSmallPath)){
    	mkdir($snapSmallPath);
    }
}

function deleteAlbum($albumID){
	global $dataPath;
	$sql="SELECT UserID FROM AlbumTable WHERE AlbumID='$albumID'";
    $res=exeSQL($sql);
    $row=mysql_fetch_array($res);
    $userID=$row[0];
    $albumPath=$dataPath . "User_" . $userID . "/Album_" . $albumID;
    if(file_exists($albumPath)){
    	system("rm -rf $albumPath");
    }
    $snapBigPath=$dataPath . "User_" . $userID . "/AlbumSnapBig_" . $albumID;
    if(file_exists($snapBigPath)){
    	system("rm -rf $snapBigPath");
    }
    $snapSmallPath=$dataPath . "User_" . $userID . "/AlbumSnapSmall_" . $albumID;
    if(file_exists($snapSmallPath)){
    	system("rm -rf $snapSmallPath");
    }
	
    $sql="DELETE FROM AlbumTable WHERE AlbumID='$albumID'";
    if(!exeSQL($sql)){printf("delete album $albumName failed");}
    $sql="DELETE FROM PicTable WHERE AlbumID='$albumID'";
    if(!exeSQL($sql)){printf("delete album $albumName failed");}
}

function addComment($userID, $picID, $comment, $createTime){
    $userName=getUserName($userID);
    $sql="INSERT INTO CommentTable (UserID,UserName,PicID, Comment, CreateTime) VALUES('$userID', '$userName', '$picID', '$comment', '$createTime')";
    if(!exeSQL($sql)){printf("add comment failed");}
}

function addLike($userID, $picID, $createTime){
    $userName=getUserName($userID);
    $sql="INSERT INTO LikeTable (UserID,UserName,PicID,CreateTime) VALUES('$userID', '$userName', '$picID', '$createTime')";
    if(!exeSQL($sql)){printf("add Like failed");}
    else{
        $sql="UPDATE PicTable SET LikeNum=LikeNum+1 WHERE PicID=$picID";
        if(!exeSQL($sql)){printf("update LikeNum failed");}
    }
}



function addMessage($fromID, $toID, $sendTime, $msgType, $message){
    $sql="INSERT INTO MessageTable (FromID, ToID, SendTime, MsgType, Message) VALUES($fromID, $toID, $sendTime, '$msgType', '$message')";
    if(!exeSQL($sql)){printf("add message failed");}
}


function addPic($userID, $picName, $width, $height, $des, $picPath, $shootTime, $uploadTime, $longitude, $latitude, $likeNum, $albumID){
    $userName=getUserName($userID);
    
    $sql="SELECT Share FROM AlbumTable WHERE AlbumID='$albumID'";
    $res=exeSQL($sql);
    $ifShare=1;
    if($row=mysql_fetch_array($res)){
    	$ifShare=$row[0];
    }
    
    $sql="INSERT INTO PicTable (UserID, UserName,  PicName, Width, Height, Description, PicPath, ShootTime, UploadTime, Longitude, Latitude, LikeNum, AlbumID, Share) VALUES($userID, '$userName', '$picName', $width, $height, '$des', '$picPath', $shootTime, $uploadTime, $longitude, $latitude, $likeNum, $albumID,'$ifShare')";
    if(!exeSQL($sql)){printf("add pic error");}
    else{
        $sql="UPDATE AlbumTable SET PicNum=PicNum+1 WHERE AlbumID=$albumID";
        exeSQL($sql);
    }
 
}

function addFriend($fromID, $toID, $type, $createTime){
    $sql="INSERT INTO FriendTable (FromID, ToID, Type, CreateTime) VALUES($fromID, $toID, '$type', $createTime)";
    if(!exeSQL($sql)){printf("add message failed");}
}

function checkUser($userName, $email){
    $sql="SELECT UserID FROM UserInfoTable WHERE UserName='$userName' or Email='$email'";
    $result=exeSQL($sql);
    $row=mysql_fetch_array($result);
    if(empty($row))return 0;
    else return 1;
}

function checkLogin($email, $password){
    $sql="SELECT UserID FROM UserInfoTable WHERE Email='$email' AND Password='$password'";
    $result=exeSQL($sql);
    $row=mysql_fetch_array($result);
    if(empty($row))return 0;
    else return 1;
}

function getUserFromSessionID($sessionID){
	$sql="SELECT UserName,UserID,Email FROM UserInfoTable WHERE SessionID='$sessionID'";
	$res=exeSQL($sql);
	return mysql_fetch_array($res, MYSQL_ASSOC);
}

function getUserID($userName){
    $sql="SELECT UserID FROM UserInfoTable WHERE UserName='$userName'";
    $result=exeSQL($sql);
    $row=mysql_fetch_array($result);
    if(empty($row))return 0;
    else return $row[0];
}

function getUserName($userID){
    $sql="SELECT UserName FROM UserInfoTable WHERE UserID='$userID'";
    $result=exeSQL($sql);
    $row=mysql_fetch_array($result);
    if(empty($row))return 0;
    else return $row[0];
}




//init();
//addUser("zxt","t","zxt@pku.edu.cn","M");
//addPic(1,"a.jpg",300,300,"test1","/pic",time(),time(),0,0,1,1);
//addMessage(1,2,time(),'N',"hello");
//addFriend(1,2,'N',time());
//addAlbum(1,'al1','haha',time());
