var map;
var lngMax,lngMin,latMax,latMin;
var mouseLng, mouseLat;
var picArray=new Array();
var picMarker=new Array();
var nowPicIndex=0;
var ifMove=0;
var ifShowPicDiv=0;

var picNumOnce=500, groupNum=0, sortType="ShootTime DESC", selectType="AllRange", para="";

function setFind(){
    sortType=$("input[name='SortType']:checked").val() + " " + $("input[name='UpOrDown']:checked").val();
    picNumOnce=parseInt($("#PicNumOnce").val());
    fresh();
    $("#findSetModal").modal('hide');
}



function likeFun(){
    var xmlhttp;
    xmlhttp=new XMLHttpRequest();
    xmlhttp.onreadystatechange=function(){
        if(xmlhttp.readyState==4 && xmlhttp.status==200){
            para="lngMax=" + lngMax + "&lngMin=" + lngMin + "&latMax=" +  latMax + "&latMin=" + latMin;
            picArray=getPic(picNumOnce, groupNum, sortType, selectType, para);
            showPicDiv();
            freshPanel();
        }
    };

    xmlhttp.open("POST", "/Command.php",false);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    cmtContent=encodeURIComponent($("#CmtContentText").val());
    picID=picArray[nowPicIndex]["PicID"];
    xmlhttp.send("cmd=addLike&picID=" + picID);
}


//----------------------------comment panel-----------------------------------------
function sendComment(){
    var xmlhttp;
    xmlhttp=new XMLHttpRequest();
    xmlhttp.onreadystatechange=function(){
        if(xmlhttp.readyState==4 && xmlhttp.status==200){
            initCommentPanel();
            para="lngMax=" + lngMax + "&lngMin=" + lngMin + "&latMax=" +  latMax + "&latMin=" + latMin;
            picArray=getPic(picNumOnce, groupNum, sortType, selectType, para);
            showPicDiv();
            freshPanel();
        }
    };

    xmlhttp.open("POST", "/Command.php",false);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    cmtContent=encodeURIComponent($("#CommentInput").val());
    if(cmtContent.length<=0){
        return;
    }
    picID=picArray[nowPicIndex]["PicID"];
    xmlhttp.send("cmd=sendComment&picID=" + picID + "&cmt=" + cmtContent);
}

function initCommentPanel(){
  var cmtArray=getComment(picArray[nowPicIndex]['PicID']);
    cmt=[];
    str="";
    $("#CommentInput").val("");
    for(var i=0;i<cmtArray.length;i++){
        cmtUserName=cmtArray[i]['UserName'];
        cmtTime=getTimeStr(cmtArray[i]['CreateTime']);
        cmtStr=cmtArray[i]['Comment'];
        cmtUserID=cmtArray[i]['UserID'];
        str='<li onclick="replyFun(\''+cmtUserName+'\')" class="list-group-item"><span class="CmtUserName"><a href="/UserPage/UserPage.php?PageUserID='+ cmtUserID +'">' + cmtUserName + "</a></span>" + '<span class="CmtTime"> (' + cmtTime + "): </span><br />" + '<span class="CmtStr">' + cmtStr + '</span></li>';

        cmt.push(str);
    }       
    $("#CommentList").html(cmt.join(""));
}

function replyFun(uName){
oldVal=$("#CommentInput").val()
$("#CommentInput").val("回复"+uName+":"+oldVal);
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

//------------------------comment panel------------------------------------------------



function getBounds(){
    bounds=map.getBounds().toString();
    bArr=bounds.split(';');
    ws=bArr[0].split(',');
    en=bArr[1].split(',');
    lngMin=Math.min(parseFloat(ws[0]),parseFloat(en[0]));
    lngMax=Math.max(parseFloat(ws[0]),parseFloat(en[0]));
    latMin=Math.min(parseFloat(ws[1]),parseFloat(en[1]));
    latMax=Math.max(parseFloat(ws[1]),parseFloat(en[1]));
}

function delPic(){
	var picID=picArray[nowPicIndex]['PicID'];
	var xmlhttp;
	xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function(){
		if(xmlhttp.readyState==4 && xmlhttp.status==200){
			res=xmlhttp.responseText;
			fresh();
		}   
	};  

	xmlhttp.open("POST", "/Command.php",false);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send("cmd=delPic&picID=" + picID);
}

function movePic(){
	ifMove=1;
}

function _onClick(e){
    mouseLng=e.lnglat.getLng();
    mouseLat=e.lnglat.getLat();
    if(ifMove==1){
    	var picID=picArray[nowPicIndex]['PicID'];
		var xmlhttp;
		xmlhttp=new XMLHttpRequest();
		xmlhttp.onreadystatechange=function(){
			if(xmlhttp.readyState==4 && xmlhttp.status==200){
				res=xmlhttp.responseText;
				indexTmp=nowPicIndex;
				fresh();
				nowPicIndex=indexTmp;
				showPicDiv();
			}   
		};  

		xmlhttp.open("POST", "/Command.php",false);
		xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xmlhttp.send("cmd=movePic&picID=" + picID + "&lng=" + mouseLng + "&lat=" + mouseLat);
		
    	ifMove=0;
    }

	getBounds();
}

function _onMoveend(e){
	getBounds();
	fresh();
}
function _onDragend(e){
	getBounds();
	fresh();
}
function _onZoomend(e){
	getBounds();
	fresh();
}

function _ontouchend(e){
	getBounds();
	fresh();
}

function initMap(){
    map=new AMap.Map('MapContainer',{resizeEnable:true, zoom:12, center:[116.39,39.9]});
    AMap.event.addListener(map,"moveend",_onMoveend);
    AMap.event.addListener(map,"dragend",_onDragend);
    AMap.event.addListener(map,"zoomend",_onZoomend);
    AMap.event.addListener(map,"touchend",_ontouchend);
    AMap.event.addListener(map,"click",_onClick);
    /*
    AMap.plugin(['AMap.ToolBar','AMap.Scale','AMap.OverView'],
            function(){
                map.addControl(new AMap.ToolBar());
                map.addControl(new AMap.Scale());
        });
   */
}

var uploadFiles=document.getElementById("UploadFile");
var uploadList=document.getElementById("UploadList");
	
function initUpload(){
	uploadFiles.addEventListener("change", function(){
        num=uploadFiles.files.length;
	    var i=0;
		var listHTML="";
		for(i=0;i<num;i++){
		    file=uploadFiles.files[i];
		    fName=file.name;
		    processBarHTML=" <div class=\"progress\"> \
		    <div id=\"progress_" +i+ "\" class=\"progress-bar\" role=\"progressbar\" aria-valuenow=\"0\" aria-valuemin=\"0\" aria-valuemax=\"100\" style=\"width: 0%;\"> \
		    </div> </div>";
		    desInputHTML="\
		        <div class=\"input-group\"> \
	            <span class=\"input-group-addon\">描述</span> \
	            <input type=\"text\" class=\"form-control\" id=\"des_" + i + "\"></input> \
	        </div>";

			listHTML=listHTML + "<li id=\"li_" +i + "\" class=\"list-group-item\">" + fName + "<br /><img class=\"img-responsive\" id=\"img_" + i + "\" /><br />" + desInputHTML + "<br />" + processBarHTML + "</li>";
			
			var reader=new FileReader();
			reader.index=i;
			reader.onload=function(event){
				var img=document.getElementById("img_" + this.index);
				img.src=event.target.result;
			}
			reader.readAsDataURL(file);
			
		}
		uploadList.innerHTML=listHTML;
	},false);
	
}

function uploadProgress(event){
	var index=this.index;
	if (event.lengthComputable) {
       var percentComplete = Math.round(event.loaded * 100 / event.total);
       $("#progress_"+index).css("width",percentComplete +'%');
    }
}


function upload(){
	var url="/Command.php";
	num=uploadFiles.files.length;	
	var i=0;
	for(i=0;i<num;i++){
		var xhr=new XMLHttpRequest();
		xhr.open("POST", url, true);
		xhr.upload.index=i;
		xhr.upload.addEventListener("progress", uploadProgress, false); 
		xhr.onreadystatechange=function(){
			if(xhr.readyState==4 && xhr.status==200){
				fresh();
			}
		};
		
		var desInput=document.getElementById("des_" + i);

		var fd=new FormData();
		fd.append("cmd","uploadPic");
		fd.append("lngMax",lngMax);
		fd.append("lngMin",lngMin);
		fd.append("latMax",latMax);
		fd.append("latMin",latMin);
		fd.append("upAlbumID",albumID);
		fd.append("upPicDes",desInput.value);
		fd.append("file", uploadFiles.files[i]);
		
		xhr.send(fd);
	}
}

function getPic(picNumm, groupNumm, sortTypee, selectTypee,paraa){
    var xmlhttp;
    picATmp=new Array();
    xmlhttp=new XMLHttpRequest();
    xmlhttp.onreadystatechange=function(){
		if(xmlhttp.readyState==4 && xmlhttp.status==200){
			res=xmlhttp.responseText;
			if(res<=0){
			  picATmp="";return;
			}
			picList=res.split("#");
			for(var i=0;i<picList.length;i++){
				picATmp[i]=new Array();
				picInfo=picList[i].split(" ");
				for(var j=0;j<picInfo.length;j++){
					key=decodeURIComponent(picInfo[j].split("=")[0]);
					value=decodeURIComponent(picInfo[j].split("=")[1]);
					picATmp[i][key]=value;
				}
			}
		}   
    };  

    xmlhttp.open("POST", "/Command.php",false);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("cmd=getPic&picNum=" + picNumm + "&groupNum=" + groupNumm + "&sortType=" + sortTypee + "&selectType=" + selectTypee + "&" + paraa);
    
    return picATmp;
}

function addMarker(){
	var i=0;
	for(i=0;i<picArray.length;i++){
		var lng=parseFloat(picArray[i]['Longitude']);
		var lat=parseFloat(picArray[i]['Latitude']);
		var picName=picArray[i]['PicName'];
		var picUserID=picArray[i]['UserID'];
		var picAlbumID=picArray[i]['AlbumID'];
		var snapSmallPath="/Data/User_" + picUserID + "/AlbumSnapSmall_" + picAlbumID + "/" + picName;  
		var ext=snapSmallPath.substr(snapSmallPath.indexOf('.')+1).toLowerCase();
	    if(ext=="mp4"){
		    snapSmallPath=snapSmallPath + ".jpg";
	    }
	
		var markPos=[lng,lat];
		var marker=new AMap.Marker({
			map:map,
            position:markPos,
            icon:snapSmallPath,
            offset:{x:0,y:0}
		});
		marker.picIndex=i;
		marker.on('click',markerClick)
		picMarker.push(marker);
	}
	
	//map.setFitView();
	map.plugin(["AMap.MarkerClusterer"], function(){
		cluster.clearMarkers();
	});

	map.plugin(["AMap.MarkerClusterer"], function(){
		cluster=new AMap.MarkerClusterer(map, picMarker);
	});
}

function markerClick(e){
	nowPicIndex=this.picIndex;
	showPicDiv();
}

function fresh(){
    var picIDTmp=0;
    if(picArray.length>0){
        picIDTmp=picArray[nowPicIndex]['PicID'];
    }
    map.remove(picMarker);
    picMarker=new Array();
	getBounds();
	para="lngMax=" + lngMax + "&lngMin=" + lngMin + "&latMax=" +  latMax + "&latMin=" + latMin;
    picArray=new Array();
	picArray=getPic(picNumOnce, groupNum, sortType, selectType, para);
	addMarker();
    nowPicIndex=0;
    for(i=0;i<picArray.length;i++){
        if(picArray[i]['PicID']==picIDTmp){
            nowPicIndex=i;break
        }
    }
    if(picArray.length>0){
        //showPicDiv();
    }
}

function showPicDiv(){
    var picName=picArray[nowPicIndex]['PicName'];
    var picLikeNum=picArray[nowPicIndex]['LikeNum'];
    var picCommentNum=picArray[nowPicIndex]['CommentNum'];
    var picDes=picArray[nowPicIndex]['Description'];
    var picUserID=picArray[nowPicIndex]['UserID'];
    var picAlbumID=picArray[nowPicIndex]['AlbumID'];

    var picPath="/Data/User_" + picUserID + "/Album_" + picAlbumID + "/" + picName;
    var snapBigPath="/Data/User_" + picUserID + "/AlbumSnapBig_" + picAlbumID + "/" + picName;
    var ext=snapBigPath.substr(snapBigPath.indexOf('.')+1).toLowerCase();
    if(ext=="mp4"){
        snapBigPath=snapBigPath + ".jpg";
    }   
    var lng=picArray[nowPicIndex]['Longitude'];
    var lat=picArray[nowPicIndex]['Latitude'];
    var content=[];
    
    var picNum=picArray.length;
    var nowNum=nowPicIndex+1;
    
    if(ext=="mp4"){
       title="视频(" + nowNum + "/" + picNum + ")";
    }   
    else{
       title="图片(" + nowNum + "/" + picNum + ")";
    }   

    numInfo="<div><span class='badge'>赞:"+ picLikeNum + "</span> <span class='badge'>评论:" + picCommentNum + "</span></div>"

    content.push("<img onclick=\"javascript:showPanel()\" src=\""+ snapBigPath + "\" /><br />" +numInfo+ "<div id='PicDesDiv'>" + picDes + "</div>");

    infoWindow = new AMap.InfoWindow({
        isCustom:true,
        content: createInfoWindow(title,content.join("<br/>")),
        offset:new AMap.Pixel(16,-25)
    }); 
    infoWindow.open(map, [lng,lat]);
    //map.setCenter([lng,lat]);
	
}

function createInfoWindow(title, content) {
    var info = document.createElement("div");
    info.className = "info";

    //可以通过下面的方式修改自定义窗体的宽高
    //info.style.width = "400px";
    // 定义顶部标题
    var top = document.createElement("div");
    var titleD = document.createElement("div");
    var closeX = document.createElement("img");
    top.className = "info-top";
    titleD.innerHTML = title;
    closeX.src = "/images/close2.gif";
    closeX.onclick = closeInfoWindow;

    top.appendChild(titleD);
    top.appendChild(closeX);
    info.appendChild(top);

    // 定义中部内容
    var middle = document.createElement("div");
    middle.className = "info-middle";
    middle.style.backgroundColor = 'white';
    middle.innerHTML = content;
    info.appendChild(middle);

    // 定义底部内容
    var bottom = document.createElement("div");
    bottom.className = "info-bottom";
    bottom.style.position = 'relative';
    bottom.style.top = '0px';
    bottom.style.margin = '0 auto';
    var sharp = document.createElement("img");
    sharp.src = "/images/sharp.png";
    bottom.appendChild(sharp);
    info.appendChild(bottom);
    return info;
}

//关闭信息窗体
function closeInfoWindow() {
    map.clearInfoWindow();
}




function nextPic(){
	var picNum=picArray.length;
	nowPicIndex=(nowPicIndex+1)%picNum;
	showPicDiv();
    freshPanel();
}

function beforePic(){
	var picNum=picArray.length;
	nowPicIndex=(nowPicIndex + picNum -1)%picNum;
	showPicDiv();
    freshPanel();
}


initMap();
initUpload();
fresh();
