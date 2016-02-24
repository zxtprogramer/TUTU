var albumList=new Array();
scrollNum=0;

function newAlbum(){
    var xmlhttp;
    xmlhttp=new XMLHttpRequest();
    var albumName=$("#newAlbumName").val();
    var albumDes=$("#newAlbumDes").val()

    xmlhttp.onreadystatechange=function(){
        if(xmlhttp.readyState==4 && xmlhttp.status==200){
            window.location.reload();
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
        	window.location.reload();
        }
    };  

    xmlhttp.open("POST", "/Command.php",true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("cmd=deleteAlbum&AlbumID=" + albumID);

}

function myGetTime(ms){
	var myD=new Date();
	myD.setTime(ms);
	y=myD.getFullYear();
	m=myD.getMonth()+1;
	d=myD.getDate();
	h=myD.getHours();
	min=myD.getMinutes();
	sec=myD.getSeconds();
	return y + "年"+m+"月"+d+"日 "+h+":"+min+":"+sec;
}

function appendAlbum(album){
	albumName=album['AlbumName'];
	albumDes=album['Description'];
	albumFacePath=getAlbumFace(album['AlbumID']);
	albumNum=album['PicNum'];
	albumID=album['AlbumID'];
	albumUserName=album['UserName'];
	albumUserID=album['UserID'];
	albumTime=parseInt(album['CreateTime'])*1000;

	var albumTitle=document.createElement('div')
	albumTitle.setAttribute("class","row WhiteBK");
	albumTitle.setAttribute("albumID",albumID);
	albumTitle.innerHTML= myGetTime(albumTime) + ' <span class="badge">'+albumNum+'</span><br />' +
	                      '<h5>'+albumName +' <small> '  + albumDes + '</small></h1>';
	
	var albumFace=document.createElement('div')
	albumFace.setAttribute("class","row");
	albumFace.innerHTML='<a href="/Pic/Pic.php?AlbumID='+albumID+'&AlbumUserID='+albumUserID+'"><img style="width:100%;" src="' + albumFacePath +'"/></a>' ;

	var albumSpace=document.createElement('div')
	albumSpace.setAttribute("class","row ItemSpace");
	
	document.getElementById("UserPageMain").appendChild(albumTitle);
	document.getElementById("UserPageMain").appendChild(albumFace);
	
	if(ifUserOwn==1){
	    var albumEdit=document.createElement('div')
	    albumEdit.setAttribute("class","row WhiteBK");
     	albumEdit.innerHTML=' \
            <div class=\"btn-group\" role=\"group\"> \
			  <a type=\"button\" class=\"btn btn-default\" href=\"/Pic/Pic.php?AlbumID=' + albumID + '&AlbumUserID=' + albumUserID + '\"><span class=\"glyphicon glyphicon-globe\"></span></a> \
			  <button type=\"button\" class=\"btn btn-default\"><span class=\"glyphicon glyphicon-download-alt\"></span></button> \
			  <button type=\"button\" class=\"btn btn-default\"><span class=\"glyphicon glyphicon-pencil\"></span></button> \
			  <button type=\"button\" class=\"btn btn-danger\"><span class=\"glyphicon glyphicon-trash\" onclick=\"deleteAlbum('+albumID+')\"></span></button> \
		    </div> ' ;
    	document.getElementById("UserPageMain").appendChild(albumEdit);
	}

	document.getElementById("UserPageMain").appendChild(albumSpace);
}

function getAlbumFace(albumID){
    var xmlhttp;
    albumATmp=new Array();
    var res="";

    xmlhttp=new XMLHttpRequest();
    xmlhttp.onreadystatechange=function(){
	    if(xmlhttp.readyState==4 && xmlhttp.status==200){
	        res=xmlhttp.responseText;
            if(res.length<=0)return;
	    }
    };

    xmlhttp.open("POST", "/Command.php",false);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("cmd=getAlbumFace&albumID=" + albumID);
    return res;
}


function getAlbumList(scrollNum,onceNum,albumUserID){
    var xmlhttp;
    albumATmp=new Array();
    xmlhttp=new XMLHttpRequest();
    xmlhttp.onreadystatechange=function(){
	    if(xmlhttp.readyState==4 && xmlhttp.status==200){
	        res=xmlhttp.responseText;
            if(res.length<=0)return;
	        albumList=res.split("#");
	        for(var i=0;i<albumList.length;i++){
	    	    albumATmp[i]=new Array();
	    	    albumInfo=albumList[i].split(" ");
	    	    for(var j=0;j<albumInfo.length;j++){
	    	        key=decodeURIComponent(albumInfo[j].split("=")[0]);
	    	        value=decodeURIComponent(albumInfo[j].split("=")[1]);
	    	        albumATmp[i][key]=value;
	    	    }
	    	    appendAlbum(albumATmp[i]);
	        }

	        albumList=albumList.concat(albumATmp);
	    }
    };

    xmlhttp.open("POST", "/Command.php",false);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("cmd=getAlbumList&scrollNum=" +scrollNum + "&onceNum=" + onceNum + "&albumUserID=" + albumUserID);
}

getAlbumList(0,5,pageUserID);

$(window).scroll(function(){
	var scrollTop=$(this).scrollTop();
	var scrollHeight=$(document).height();
	var windowHeight=$(this).height();
	if((scrollTop+windowHeight)==scrollHeight){
		scrollNum++;
		getAlbumList(scrollNum,5,0);
	}
	
})