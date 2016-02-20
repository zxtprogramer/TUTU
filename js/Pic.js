var map;
var lngMax,lngMin,latMax,latMin;
var picArray=new Array();
var picMarker=new Array();
var nowPicIndex=0;


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

function _onClick(e){
	getBounds();
}
function _onMoveend(e){
	getBounds();
}
function _onDragend(e){
	getBounds();
}
function _onZoomend(e){
	getBounds();
}

function _ontouchend(e){
	getBounds();
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

function upload(){
	var url="/Command.php";
	num=uploadFiles.files.length;	
	var i=0;
	for(i=0;i<num;i++){
		var xhr=new XMLHttpRequest();
		xhr.open("POST", url, true);
		xhr.onreadystatechange=function(){
			if(xhr.readyState==4 && xhr.status==200){
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

function getAlbumPic(albumID){
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
    xmlhttp.send("cmd=getAlbumPic&albumID=" + albumID);
    
    return picATmp;
}

function addMarker(){
	var i=0;
	for(i=0;i<picArray.length;i++){
		var lng=parseFloat(picArray[i]['Longitude']);
		var lat=parseFloat(picArray[i]['Latitude']);
		var picName=picArray[i]['PicName'];
		var snapSmallPath="/Data/User_" + userID + "/AlbumSnapSmall_" + albumID + "/" + picName;  
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
	/*
	map.plugin(["AMap.MarkerClusterer"], function(){
		cluster=new AMap.MarkerClusterer(map, picMarker);
	});
	*/
}

function markerClick(e){
	nowPicIndex=this.picIndex;
	showPicDiv();
}

function fresh(){
    nowPicIndex=0;
	getBounds();
	picArray=getAlbumPic(albumID);
	addMarker();
	showPicDiv();
}

function showPicDiv(){
	var picName=picArray[nowPicIndex]['PicName'];
	var snapBigPath="/Data/User_" + userID + "/AlbumSnapBig_" + albumID + "/" + picName;
	var lng=picArray[nowPicIndex]['Longitude'];
	var lat=picArray[nowPicIndex]['Latitude'];
	var content=[];
	var title="TUTU";

    content.push("<img src=\""+ snapBigPath + "\" />");

    infoWindow = new AMap.InfoWindow({
    	isCustom:true,
        content: createInfoWindow(title,content.join("<br/>")),
        offset:new AMap.Pixel(16,-25)
    });
    infoWindow.open(map, [lng,lat]);
    map.setCenter([lng,lat]);
	
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
}

function beforePic(){
	var picNum=picArray.length;
	nowPicIndex=(nowPicIndex + picNum -1)%picNum;
	showPicDiv();
}


initMap();
initUpload();
fresh();