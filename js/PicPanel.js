var startX,startY;
var endX,endY;

function touchStart(event){
	event.preventDefault();
	var touch = event.originalEvent.changedTouches[0]; 
	startX=touch.pageX;
	startY=touch.pageY;
}

function touchEnd(event){
	event.preventDefault();
	var touch = event.originalEvent.changedTouches[0]; 
	endX=touch.pageX;
	endY=touch.pageY;
	if((endX-startX)>50){
		beforePic();
	}
	if((startX-endX)>50){
		nextPic();
	}
}

function initTouch(){
	$("#PicPanelImg").bind("touchstart",touchStart);
	$("#PicPanelImg").bind("touchend",touchEnd);
}


function closePicPanel(){
  $("#PicPanelDiv").hide();
  $("#PicPanelImg").attr("src","");
  $("#PicPanelVideo").attr("src","");
	
}

function getTimeStr(sec){
    var d=new Date();
    d.setTime(parseInt(sec)*1000);
    year=d.getFullYear();
    month=d.getMonth()+1;
    if(month<10)month="0"+month;
    day=d.getDate();
    if(day<10)day="0"+day;
    hour=d.getHours();
    if(hour<10)hour="0"+hour;
    min=d.getMinutes();
    if(min<10)min="0"+min;
    sec=d.getSeconds();
    if(sec<10)sec="0"+sec;
    return year+"-"+month+"-"+day+" " + hour + ":" + min + ":" + sec;
}



function freshPanel(){
    if(picArray.length<=0)return;

    var picUserID=picArray[nowPicIndex]['UserID'];
    var picID=picArray[nowPicIndex]['PicID'];
    var picUserName=picArray[nowPicIndex]['UserName'];
    var picAlbumID=picArray[nowPicIndex]['AlbumID'];
    var picW=parseInt(picArray[nowPicIndex]['Width']);
    var picH=parseInt(picArray[nowPicIndex]['Height']);
    var picLng=parseFloat(picArray[nowPicIndex]['Longitude']);
    var picLat=parseFloat(picArray[nowPicIndex]['Latitude']);
    var picLikeNum=parseInt(picArray[nowPicIndex]['LikeNum']);
    var picCommentNum=parseInt(picArray[nowPicIndex]['CommentNum']);
    var picTime=parseInt(picArray[nowPicIndex]['ShootTime']);
    var picDes=picArray[nowPicIndex]['Description'];


    var fName=picArray[nowPicIndex]['PicName'];
    ext=fName.substr(fName.lastIndexOf(".")+1).toLowerCase();

    var picPanelCloseDiv=document.createElement('div');
    picPanelCloseDiv.setAttribute("class","row");
    picPanelCloseDiv.innerHTML='<div class="col-xs-12 text-right" style="padding:5px;background:#ccc"><a href="javascript:closePicPanel()"><span class="glyphicon glyphicon-remove" /></a></div>';

    var picUserTitleDiv=document.createElement('div');
    var picIndex=nowPicIndex+1;
    picUserTitleDiv.setAttribute("class","row PicUserTitle");
    picUserTitleDiv.innerHTML='<div class="col-xs-12"><a href="/UserPage/UserPage.php?PageUserID='+picUserID+'"><img src="/Data/User_' + picUserID + '/UserFace.jpg" class="UserFaceImg"></img></a> ' + 
    picUserName + ' (<a href="/Pic/Pic.php?AlbumID='+picAlbumID+'">前往相册</a>)' +' ('+picIndex+'/'+picArray.length+')'+ '<span class="PicTimeLabel">' + getTimeStr(picTime) + '</span><hr class="PicHr"  /></div>';

    var picTitleDiv=document.createElement('div');
    picTitleDiv.setAttribute("class","row PicTitle");
    picTitleDiv.innerHTML='<h5>'+ picDes + '</h5>';
        
    var picNumInfoDiv=document.createElement('div');
    picNumInfoDiv.setAttribute("class","row PicNumInfo");
    picNumInfoDiv.innerHTML="<hr class='PicHr'  /><span class='badge'>"+ picLikeNum + "个喜欢 </span> <span class='badge'>" + picCommentNum + "条评论</span>";    

    divH=parseFloat($("#PicPanelDiv").height());
    divW=parseFloat($("#PicPanelDiv").width());
    picW=parseFloat(picArray[nowPicIndex]['Width']);
    picH=parseFloat(picArray[nowPicIndex]['Height']);

    if((picH/picW) > (divH-150.0)/divW){
        imgH=parseInt(divH-150.0)+"px";
        imgW=parseInt(imgH/picH*picW)+"px";
    }
    else{
        imgH="auto";
        imgW=parseInt(divW)+"px";
    }

    var picImgDiv=document.createElement('div');
    picImgDiv.setAttribute("class","row");
    if(ext=="mp4"){
        picPath="/Data/User_" + picUserID + "/Album_" + picAlbumID + "/" + fName; 
        picImgDiv.innerHTML="<div class='row'><div class='col-xs-12 text-center'><video style='width:" +imgW+ ";height:"+imgH+";'"+
                            "controls='controls' src='"+picPath+"'></video></div></div>";
    }
    else{
        picPath="/Data/User_" + picUserID + "/AlbumSnapBig_" + picAlbumID + "/" + fName; 
        picImgDiv.innerHTML="<div class='row'><div class='col-xs-12 text-center'><img style='width:"+imgW+";height:"+imgH+";'"+
              "id='PicPanelImg' class='PicPanelImg' src='"+picPath+"'></img></div></div>";
    }


    var picCmtDiv=document.createElement('div');
    picImgDiv.setAttribute("class","row");

    var cmtArray=getComment(picID);
    var cmt=new Array();
    cmt.push("<ul id='PicPanelCmtList' class='list-group'>");
    for(var i=0;i<cmtArray.length;i++){
        cmtUserName=cmtArray[i]['UserName'];
        cmtTime=getTimeStr(cmtArray[i]['CreateTime']);
        cmtStr=cmtArray[i]['Comment'];
        cmtUserID=cmtArray[i]['UserID'];
        str='<li onclick="replyFun(\''+cmtUserName+'\')" class="list-group-item"><span class="PicPanelCmtUserName"><a href="/UserPage/UserPage.php?PageUserID='+ cmtUserID +'">' + cmtUserName + "</a></span>" + '<span class="PicPanelCmtTime"> (' + cmtTime + "): </span><br />" + '<span class="PicPanelCmtStr">' + cmtStr + '</span></li>';
        cmt.push(str);
    }
    cmt.push("</ul>");
    picCmtDiv.innerHTML=cmt.join("");

    document.getElementById("PicPanelDiv").innerHTML="";
    document.getElementById("PicPanelDiv").appendChild(picPanelCloseDiv);
    document.getElementById("PicPanelDiv").appendChild(picUserTitleDiv);
    document.getElementById("PicPanelDiv").appendChild(picImgDiv);
    document.getElementById("PicPanelDiv").appendChild(picTitleDiv);
    document.getElementById("PicPanelDiv").appendChild(picNumInfoDiv);
    document.getElementById("PicPanelDiv").appendChild(picCmtDiv);

    initTouch();
    
}


function hidePanel(){
    $("#PicPanelDiv").hide();
}

function showPanel(){
    $("#PicPanelDiv").show();
	freshPanel();
}

hidePanel();
