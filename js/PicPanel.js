function closePicPanel(){
  $("#PicPanelDiv").hide();
}


function likeFun(){
    var xmlhttp;
    xmlhttp=new XMLHttpRequest();
    xmlhttp.onreadystatechange=function(){
	    if(xmlhttp.readyState==4 && xmlhttp.status==200){
	    }
    };

    xmlhttp.open("POST", "/Command.php",false);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    cmtContent=encodeURIComponent($("#CmtContentText").val());
    picID=picArray[nowPicIndex]["PicID"];
    xmlhttp.send("cmd=addLike&picID=" + picID);
    //num=parseInt($("#LikeNumLabel").text())+1;
    //$("#LikeNumLabel").text(num);
    //alert();
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

function showInfo(){
    info=[];
    info.push("文件名:" + picArray[nowPicIndex]['PicName']);
    info.push("文件ID:" + picArray[nowPicIndex]['PicID']);
    info.push("LikeNum:" + picArray[nowPicIndex]['LikeNum']);
    info.push("宽度(px):" + picArray[nowPicIndex]['Width']);
    info.push("高度(px):" + picArray[nowPicIndex]['Height']);
    info.push("时间:" + picArray[nowPicIndex]['ShootTime']);
    info.push("位置:" + picArray[nowPicIndex]['Longitude'] + " " + picArray[nowPicIndex]['Latitude']);
    info.push("描述:" + picArray[nowPicIndex]['Description']);
    $("#PicInfoDiv").html(info.join("<br />"));
    $("#PicInfoDiv").show();
    $("#PicPanelCmtDiv").hide();
}

function sendCmtFun(){
    var xmlhttp;
    xmlhttp=new XMLHttpRequest();
    xmlhttp.onreadystatechange=function(){
	    if(xmlhttp.readyState==4 && xmlhttp.status==200){
            showComment();
	    }
    };

    xmlhttp.open("POST", "/Command.php",false);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    cmtContent=encodeURIComponent($("#CmtContentText").val());
    picID=picArray[nowPicIndex]["PicID"];
    xmlhttp.send("cmd=sendComment&picID=" + picID + "&cmt=" + cmtContent);
    return cmtATmp;

}

function showComment(){
    var cmtArray=getComment(picArray[nowPicIndex]['PicID']);
    cmt=[];
    for(var i=0;i<cmtArray.length;i++){
        cmtUserName=cmtArray[i]['UserName'];
        cmtTime=getTimeStr(cmtArray[i]['CreateTime']);
        cmtStr=cmtArray[i]['Comment'];
        str='<span class="CmtUserName">' + cmtUserName + "</span>" + '<span class="CmtTime"> (' + cmtTime + "): </span>" + '<span class="CmtStr">' + cmtStr + '</span>';
     
        cmt.push(str);
    }
    $("#PicCmtContentDiv").html(cmt.join("<br />"));
    $("#PicInfoDiv").hide();
    $("#PicPanelCmtDiv").show();
}

function getComment(picID){
    var xmlhttp;
    cmtATmp=new Array();
    xmlhttp=new XMLHttpRequest();
    xmlhttp.onreadystatechange=function(){
	    if(xmlhttp.readyState==4 && xmlhttp.status==200){
	        res=xmlhttp.responseText;
            if(res.length<=0)return;
	        cmtList=res.split("#");
	        for(var i=0;i<cmtList.length;i++){
	    	    cmtATmp[i]=new Array();
	    	    cmtInfo=cmtList[i].split(" ");
	    	    for(var j=0;j<cmtInfo.length;j++){
	    	        key=decodeURIComponent(cmtInfo[j].split("=")[0]);
	    	        value=decodeURIComponent(cmtInfo[j].split("=")[1]);
	    	        cmtATmp[i][key]=value;
	    	    }
	        }
	    }
    };

    xmlhttp.open("POST", "/Command.php",false);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("cmd=getComment&picID=" + picID);
    
    return cmtATmp;
}


function befPic_Panel(){
    nums=picArray.length;
    nowPicIndex=(nowPicIndex-1);
    if(nowPicIndex<0){nowPicIndex=nums-1;}
    freshPanel();
}

function nextPic_Panel(){
    nums=picArray.length;
    nowPicIndex=(nowPicIndex+1)%nums;
    freshPanel();
}

function nextGroup(){
    groupNum=groupNum + 1;
    fresh();
}

function applyFun(){
    picNum=$("#PicNumText").val();
    sortType=$("#SortTypeSel").val();
    fresh();
}

function arrangePanel(){
    panelH=parseInt($("#PicPanelDiv").height());
    panelW=parseInt($("#PicPanelDiv").width());
    toolDivH=30;
    tool2DivH=30;
    imgDivH=parseInt((panelH-60)/3*2);
    cmtDivH=parseInt((panelH-60)/3);
    
    
    $("#PicPanelToolDiv").css("height", toolDivH);
    $("#PicPanelToolDiv").css("top", 0);

    $("#PicPanelImgDiv").css("height", imgDivH);
    $("#PicPanelImgDiv").css("top", toolDivH);

    $("#PicPanelTool2Div").css("height", tool2DivH);
    $("#PicPanelTool2Div").css("top", imgDivH+toolDivH);

    $("#PicPanelCmtDiv").css("height", cmtDivH);
    $("#PicPanelCmtDiv").css("top", imgDivH+toolDivH+tool2DivH);
    $("#PicInfoDiv").css("height", cmtDivH);
    $("#PicInfoDiv").css("top", imgDivH+toolDivH+tool2DivH);

    $("#PicCmtContentDiv").css("height", cmtDivH-40);
    $("#PicCmtContentDiv").css("top", 0);

    $("#PicCmtSendDiv").css("height", 30);
    $("#PicCmtSendDiv").css("top", cmtDivH-40);

}

function freshPanel(){
	arrangePanel();
    if(picArray.length<=0)return;
    
    
    fName=picArray[nowPicIndex]['PicName'];

    picPath="/Data/User_" + albumUserID + "/Album_" + albumID + "/" + fName; 

    ext=picPath.substr(picPath.lastIndexOf(".")+1).toLowerCase();
    
    picW=parseInt(picArray[nowPicIndex]['Width']);
    
    picH=parseInt(picArray[nowPicIndex]['Height']);
    
    picLng=parseFloat(picArray[nowPicIndex]['Longitude']);
    picLat=parseFloat(picArray[nowPicIndex]['Latitude']);
    
    picLikeNum=parseInt(picArray[nowPicIndex]['LikeNum']);

    picUserID=picArray[nowPicIndex]['UserID'];

    if(picW>0 && picH>0 && ext=="mp4"){
	    $("#PicPanelImg").attr("src","");
	    $("#PicPanelVideo").attr("src",picPath);
	    $("#PicPanelImg").hide();
	    $("#PicPanelVideo").show();
    }

    if(picW>0 && picH>0 && ext!="mp4"){

	    $("#LikeNumLabel").text(picLikeNum);
	    $("#PicPanelImg").attr("src",picPath);

	    divH=parseInt($("#PicPanelImgDiv").height());
	    divW=parseInt($("#PicPanelImgDiv").width());

	    rH=divH/picH;  rW=divW/picW;

        if(rH>=rW){
            imgH=divW*picH/picW;
            imgW=divW;
        }
        else{
            imgW=divH*picW/picH;
            imgH=divH;
        }

        topPx=(divH - imgH)/2;
        leftPx=(divW - imgW)/2;
	    $("#PicPanelImg").css("height",imgH+"px");
	    $("#PicPanelImg").css("width",imgW+"px");
	    $("#PicPanelImg").css("top",topPx+"px");
	    $("#PicPanelImg").css("left",leftPx+"px");

	    $("#PicPanelVideo").attr("src","");
	    $("#PicPanelVideo").hide();
	    $("#PicPanelImg").show();
    }

    showComment();

}



function hidePanel(){
    $("#PicPanelDiv").hide();
}

function showPanel(){
    $("#PicPanelDiv").show();
	freshPanel();
}

hidePanel();
