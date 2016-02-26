var albumList=new Array();
scrollNum=0;

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

function appendAlbum(album){
	albumName=album['AlbumName'];
	albumDes=album['Description'];
	albumFacePath=getAlbumFace(album['AlbumID']);
	albumNum=album['PicNum'];
	albumID=album['AlbumID'];
	albumUserName=album['UserName'];
	albumUserID=album['UserID'];
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

	var albumSpace1=document.createElement('div');
	albumSpace1.setAttribute("class","row AlbumSpace");
	var albumSpace2=document.createElement('div');
	albumSpace2.setAttribute("class","row AlbumSpace");

	document.getElementById("HomeMain").appendChild(albumUserTitle);
	document.getElementById("HomeMain").appendChild(albumFace);
	document.getElementById("HomeMain").appendChild(albumTitle);
	document.getElementById("HomeMain").appendChild(albumSpace1);
	
}

function getUserName(userID){

	
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
	        
			var albumSpace1=document.createElement('div');
         	albumSpace1.setAttribute("class","row AlbumSpace");

			document.getElementById("HomeMain").appendChild(albumSpace1);
	    }
    };

    xmlhttp.open("POST", "/Command.php",false);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("cmd=getAlbumList&scrollNum=" +scrollNum + "&onceNum=" + onceNum + "&albumUserID=" + albumUserID);
}

getAlbumList(0,5,0);

$(window).scroll(function(){
	var scrollTop=$(this).scrollTop();
	var scrollHeight=$(document).height();
	var windowHeight=$(this).height();
	if((scrollTop+windowHeight)==scrollHeight){
		scrollNum++;
		getAlbumList(scrollNum,5,0);
	}
	
})