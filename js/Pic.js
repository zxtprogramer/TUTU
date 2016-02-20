var map;

function initMap(){
    map=new AMap.Map('MapContainer',{resizeEnable:true, zoom:12, center:[116.39,39.9]});
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

			listHTML=listHTML + "<li id=\"li_" +i + "\" class=\"list-group-item\">" + fName + "<br /><img class=\"img-responsive\" id=\"img_" + i + "\" /><br />" + processBarHTML + "</li>";
			
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
	
}


initMap();
initUpload();