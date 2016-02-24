var uploadFiles=document.getElementById("UploadFace");
var uploadList=document.getElementById("UploadList");
var upItem=0;//0 is UserFace; 1 is PageFace;

function initUploadFace(){
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

			listHTML=listHTML + "<li id=\"li_" +i + "\" class=\"list-group-item\">" + fName + "<br /><img class=\"img-responsive\" id=\"img_" + i + "\" /></li>";
			
			var reader=new FileReader();
			reader.index=i;
			reader.onload=function(event){
				var img=document.getElementById("img_" + this.index);
				img.src=event.target.result;
			}
			reader.readAsDataURL(file);
			
		}
		uploadList.innerHTML=listHTML+"<br />"+processBarHTML;
	},false);
	
}

function uploadProgress(event){
	var index=this.index;
	if (event.lengthComputable) {
       var percentComplete = Math.round(event.loaded * 100 / event.total);
       $("#progress_"+index).css("width",percentComplete +'%');
    }
}


function uploadFace(){
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
				res=xhr.responseText;
			}
		};
		
		var fd=new FormData();
		fd.append("cmd","uploadFace");
		fd.append("upItem",upItem);
		fd.append("file", uploadFiles.files[i]);
		
		xhr.send(fd);
	}
}

initUploadFace();