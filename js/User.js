var uploadFiles=document.getElementById("UploadFace");
var uploadList=document.getElementById("UploadList");

function initUploadFace(){
	uploadFiles.addEventListener("change", function(){
        num=uploadFiles.files.length;
	    var i=0;
		var listHTML="";
		for(i=0;i<num;i++){
		    file=uploadFiles.files[i];
		    fName=file.name;
			listHTML=listHTML + "<li id=\"li_" +i + "\" class=\"list-group-item\">" + fName + "<br /><img class=\"img-responsive\" id=\"img_" + i + "\" /></li>";
			
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


function uploadFace(){
	var url="/Command.php";
	num=uploadFiles.files.length;	
	var i=0;
	for(i=0;i<num;i++){
		var xhr=new XMLHttpRequest();
		xhr.open("POST", url, true);
		xhr.onreadystatechange=function(){
			if(xhr.readyState==4 && xhr.status==200){
				res=xhr.responseText;
			}
		};
		
		var fd=new FormData();
		fd.append("cmd","uploadFace");
		fd.append("file", uploadFiles.files[i]);
		
		xhr.send(fd);
	}
}

initUploadFace();