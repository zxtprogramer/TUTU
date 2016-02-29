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
		befPic_Panel();
	}
	if((startX-endX)>50){
		nextPic_Panel();
	}
}

function initTouch(){
	$(".PicPanelImg").bind("touchstart",touchStart);
	$(".PicPanelImg").bind("touchend",touchEnd);
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


function befPic_Panel(){
    nums=picArray.length;
    nowPicIndex=(nowPicIndex-1+nums)%nums;
    freshPanel();
    befPic();
}



function nextPic_Panel(){
    nums=picArray.length;
    nowPicIndex=(nowPicIndex+1)%nums;
    freshPanel();
    nextPic();
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


function freshPanel(){
    if(picArray.length<=0)return;
    
    
    fName=picArray[nowPicIndex]['PicName'];
    ext=fName.substr(fName.lastIndexOf(".")+1).toLowerCase();

    var picUserID=picArray[nowPicIndex]['UserID'];
    var picAlbumID=picArray[nowPicIndex]['AlbumID'];

    if(ext=="mp4"){
        picPath="/Data/User_" + picUserID + "/Album_" + picAlbumID + "/" + fName; 
    }
    else{
        picPath="/Data/User_" + picUserID + "/AlbumSnapBig_" + picAlbumID + "/" + fName; 
    }
    
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
    freshComment();

}


function hidePanel(){
    $("#PicPanelDiv").hide();
}

function showPanel(){
    $("#PicPanelDiv").show();
	freshPanel();
}

hidePanel();
initTouch();
