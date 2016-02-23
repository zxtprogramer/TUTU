function quickRegister(){
	var xmlhttp;
	xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function(){
		if(xmlhttp.readyState==4 && xmlhttp.status==200){
			res=xmlhttp.responseText;
			location.reload();
		}   
	};  
	
	userEmail=document.getElementById("RegisterEmail").value;
	userPassword=document.getElementById("RegisterPassword").value;
	userName=document.getElementById("RegisterName").value;

	xmlhttp.open("POST", "/Register/Register.php",false);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send("UserName=" + userName + "&Email=" + userEmail + "&Password=" + userPassword + "&submitRegister=Register");


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