
function changeCheckCode(){
    document.getElementById('checkpic').src="/CheckCode.php";
}


function quickRegister(){
	userEmail=document.getElementById("RegisterEmail").value;
	userPassword=document.getElementById("RegisterPassword").value;
	userName=document.getElementById("RegisterName").value;
	checkCode=document.getElementById("CheckCode").value;

    var regEmail=/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/;

    if(!regEmail.test(userEmail)){
        alert("邮箱格式错误");
    }
    else if(userPassword.length<6){
        alert("密码必须大于6位");
    }
    else if(userName.length<=0){
        alert("昵称不能为空");
    }
    else{
        $.post("/Command.php",{"cmd":"checkUser","checkUserName":userName, "checkUserEmail":userEmail}, 
            function(text,status){
                switch(text){
                case "10":
                    alert("邮箱已被注册");
                    break;
                case "01":
                    alert("昵称已被注册");
                    break;
                case "11":
                    alert("用户已存在");
                    break;
                case "00":
                    $.post("/Register/Register.php",{"UserName":userName, "Email":userEmail, "Password":userPassword,"submitRegister":"Register","CheckCode":checkCode },
					function(Rtext,Rstatus){
                    	res=parseInt(Rtext);
                        if(res==0){
                            alert("注册失败");
                        }
                        else{
                            alert("注册成功");
                            location.reload();
                        }
                    });
                    break;
                default:break;

                }
        });
    }

}


function quickLogin(){
	var xmlhttp;
	xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function(){
		if(xmlhttp.readyState==4 && xmlhttp.status==200){
			res=xmlhttp.responseText;
			location.reload();
		}   
	};  
	
	userEmail=document.getElementById("LoginEmail").value;
	userPassword=document.getElementById("LoginPassword").value;

	xmlhttp.open("POST", "/Login/Login.php",false);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send("Email=" + userEmail + "&Password=" + userPassword + "&submitLogin=Register");

}


//------------for quick upload---------------------

var albumArray_QU=new Array();

function gotoPicUpload(aID){
    self.location.href="/Pic/Pic.php?cmd=QuickUpLoad&AlbumID="+aID;
}


function quickUpload(){
    var selVal=parseInt($("#AlbumList_QU").val());
    if(selVal==-1){
        var xmlhttp;
        xmlhttp=new XMLHttpRequest();
        var albumName=$("#newAlbumName_QU").val();
        var albumDes=$("#newAlbumDes_QU").val()
        var albumShare=0;
        if(document.getElementById("NewIfShare_QU").checked){
            albumShare=1;
        }   
        else{
            albumShare=0;
        }   

        xmlhttp.onreadystatechange=function(){
            if(xmlhttp.readyState==4 && xmlhttp.status==200){
                res=xmlhttp.responseText;
                var albumID=parseInt(res);
                gotoPicUpload(albumID);
               
            }   
        };  

        xmlhttp.open("POST", "/Command.php",true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send("cmd=newAlbum&AlbumName=" + albumName + "&AlbumDes=" + albumDes + "&AlbumShare=" + albumShare);

    }
    else{
        gotoPicUpload(selVal);
    }

}

function selectChange(){
    var selVal=parseInt($("#AlbumList_QU").val());
    if(selVal!=-1){
        $("#NewAlbum_QU").hide();
    }
    else{
        $("#NewAlbum_QU").show();
    }
}

function initQuickUpload(){
    var xmlhttp;
    var albumArray_QU=new Array();
    xmlhttp=new XMLHttpRequest();
    xmlhttp.onreadystatechange=function(){
        if(xmlhttp.readyState==4 && xmlhttp.status==200){
            res=xmlhttp.responseText;
            if(res.length<=0)return;
            albumList=res.split("#");
            for(var i=0;i<albumList.length;i++){
                albumArray_QU[i]=new Array();
                albumInfo=albumList[i].split(" ");
                for(var j=0;j<albumInfo.length;j++){
                    key=decodeURIComponent(albumInfo[j].split("=")[0]);
                    value=decodeURIComponent(albumInfo[j].split("=")[1]);
                    albumArray_QU[i][key]=value;
                }
            }
            for(i=0;i<albumArray_QU.length;i++){
                var albumName=albumArray_QU[i]['AlbumName'];
                var albumID=albumArray_QU[i]['AlbumID'];
                $("#AlbumList_QU").append("<option value='" + albumID +"'>" + albumName + "</option>");
            }

        }
    };  

    xmlhttp.open("POST", "/Command.php",false);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("cmd=getAlbumList&scrollNum=0&onceNum=500&albumUserID=-1");


}
///////////////////////////////////////////////////
