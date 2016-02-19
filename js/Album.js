function newAlbum(){
    var xmlhttp;
    xmlhttp=new XMLHttpRequest();
    var albumName=$("#newAlbumName").val();
    var albumDes=$("#newAlbumDes").val()

    xmlhttp.onreadystatechange=function(){
        if(xmlhttp.readyState==4 && xmlhttp.status==200){
            newAlbumHide();
        }
    };  

    xmlhttp.open("POST", "/Command.php",true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("cmd=newAlbum&AlbumName=" + albumName + "&AlbumDes=" + albumDes);

}


function deleteAlbum(albumID){
	if(confirm("确定删除相册?")==false)return;
    var xmlhttp;
    xmlhttp=new XMLHttpRequest();

    xmlhttp.onreadystatechange=function(){
        if(xmlhttp.readyState==4 && xmlhttp.status==200){
            newAlbumHide();
        }
    };  

    xmlhttp.open("POST", "/Command.php",true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("cmd=deleteAlbum&AlbumID=" + albumID);

}
