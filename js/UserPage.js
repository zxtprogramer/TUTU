var albumArray=new Array();
scrollNum=0;
nowIndex=0;

function editAlbum(){
    var xmlhttp;
    xmlhttp=new XMLHttpRequest();
    var albumName=$("#EditAlbumName").val();
    var albumDes=$("#EditAlbumDes").val();
    var albumShare=0;
    var albumID=albumArray[nowIndex]['AlbumID'];

    if(document.getElementById("EditIfShare").checked){
    	albumShare=1;
    }
    else{
    	albumShare=0;
    }

    xmlhttp.onreadystatechange=function(){
        if(xmlhttp.readyState==4 && xmlhttp.status==200){
            window.location.reload();
        }
    };  
    xmlhttp.open("POST", "/Command.php",true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("cmd=editAlbum&AlbumName=" + albumName + "&AlbumDes=" + albumDes + "&AlbumShare=" + albumShare + "&AlbumID=" + albumID);
}

function newAlbum(){
    var xmlhttp;
    xmlhttp=new XMLHttpRequest();
    var albumName=$("#newAlbumName").val();
    var albumDes=$("#newAlbumDes").val()
    var albumShare=0;
    if(document.getElementById("NewIfShare").checked){
    	albumShare=1;
    }
    else{
    	albumShare=0;
    }

    xmlhttp.onreadystatechange=function(){
        if(xmlhttp.readyState==4 && xmlhttp.status==200){
            window.location.reload();
        }
    };  

    xmlhttp.open("POST", "/Command.php",true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("cmd=newAlbum&AlbumName=" + albumName + "&AlbumDes=" + albumDes + "&AlbumShare=" + albumShare);
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
	return y + "年"+m+"月"+d+"日 ";
//	return y + "年"+m+"月"+d+"日 "+h+":"+min+":"+sec;
}

function appendAlbum(nowIndex){
	album=albumArray[nowIndex];
	albumName=album['AlbumName'];
	albumDes=album['Description'];
	albumFacePath=getAlbumFace(album['AlbumID']);
	albumNum=album['PicNum'];
	albumID=album['AlbumID'];
	albumUserName=album['UserName'];
	albumUserID=album['UserID'];
	albumLikeNum=album['LikeNum'];
	albumCommentNum=album['CommentNum'];
	albumTime=parseInt(album['CreateTime'])*1000;

	var albumUserTitle=document.createElement('div');
	albumUserTitle.setAttribute("class","row UserTitle");
	albumUserTitle.innerHTML='<a href="/UserPage/UserPage.php?PageUserID='+albumUserID+'"><img src="/Data/User_' + albumUserID + '/UserFace.jpg" class="UserFaceImg"></img></a> ' + 
	albumUserName + ' <span class="AlbumTimeLabel">' + myGetTime(albumTime) + '</span>' + ' <span class="badge">'+albumNum+'</span>';

	var albumTitle=document.createElement('div');
	albumTitle.setAttribute("class","row AlbumTitle");
	albumTitle.setAttribute("albumID",albumID);
	albumTitle.innerHTML='<h5>'+albumName +'<br /><br /> <small> '  + albumDes + '</small></h5>';
	
	var albumFace=document.createElement('div');
	albumFace.setAttribute("class","row");
	albumFace.innerHTML='<a href="/Pic/Pic.php?AlbumID='+albumID+'&AlbumUserID='+albumUserID+'"><img style="width:100%;" src="' + albumFacePath +'"/></a>' ;

   var albumNumInfo=document.createElement('div');
    albumNumInfo.setAttribute("class","row AlbumNumInfo");
    albumNumInfo.innerHTML="<hr class='AlbumHr'  /><span class='badge'>"+ albumLikeNum + "人喜欢 </span> <span class='badge'>" + albumCommentNum + "条评论</span>";


	var albumSpace1=document.createElement('div');
	albumSpace1.setAttribute("class","row AlbumSpace");
	var albumSpace2=document.createElement('div');
	albumSpace2.setAttribute("class","row AlbumSpace");

	document.getElementById("UserPageMain").appendChild(albumUserTitle);
	document.getElementById("UserPageMain").appendChild(albumFace);
	document.getElementById("UserPageMain").appendChild(albumTitle);
	document.getElementById("UserPageMain").appendChild(albumNumInfo);
	
	
	if(ifUserOwn==1){
	    var albumEdit=document.createElement('div')
	    albumEdit.setAttribute("class","row");
     	albumEdit.innerHTML=' \
            <div class=\"btn-group\" role=\"group\"> \
			  <a type=\"button\" class=\"btn btn-default\" href=\"/Pic/Pic.php?AlbumID=' + albumID + '&AlbumUserID=' + albumUserID + '\"><span class=\"glyphicon glyphicon-globe\"></span></a> \
			  <button type=\"button\" class=\"btn btn-default\"><span class=\"glyphicon glyphicon-download-alt\"></span></button> \
			  <button onclick="initEditAlbum('+nowIndex+')" data-toggle="modal" data-target="#editAlbumModal" type=\"button\" class=\"btn btn-default\"><span class=\"glyphicon glyphicon-pencil\"></span></button> \
			  <button type=\"button\" class=\"btn btn-danger\"><span class=\"glyphicon glyphicon-trash\" onclick=\"deleteAlbum('+albumID+')\"></span></button> \
		    </div> ' ;
    	document.getElementById("UserPageMain").appendChild(albumEdit);
	}
	else{
	    var albumSpace1=document.createElement('div')
		albumSpace1.setAttribute("class","row AlbumSpace");
    	document.getElementById("UserPageMain").appendChild(albumSpace1);
		
	}

	document.getElementById("UserPageMain").appendChild(albumSpace1);
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

function initEditAlbum(index){
	nowIndex=index;
	$("#EditAlbumName").val(albumArray[index]['AlbumName']);
	$("#EditAlbumDes").val(albumArray[index]['Description']);
	if(albumArray[index]['Share']=='1'){
    	document.getElementById("EditIfShare").checked=true;
	}
	else{
	    document.getElementById("EditIfShare").checked=false;
	}
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
	    	    albumArray.push(albumATmp[i]);
	    	    appendAlbum(albumArray.length-1);

	        }

			var albumSpace1=document.createElement('div')
			albumSpace1.setAttribute("class","row AlbumSpace");
			document.getElementById("UserPageMain").appendChild(albumSpace1);
	
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
