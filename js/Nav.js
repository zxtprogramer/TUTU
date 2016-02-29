
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
