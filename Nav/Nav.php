<div class="MyNav" style="width:100%;height:50px;top:-2px;left:-2px;z-index:10;position:absolute">
	<div class="btn-group" role="group" aria-label="...">
	  <?php 
		if($ifLogin==1){
			$navHTML="
			  <a type=\"button\" class=\"btn btn-info\" href=\"\"><span class=\"glyphicon glyphicon-home\"></span> 首页</a>
			  <a type=\"button\" class=\"btn btn-info\" href=\"/Album/Album.php\"><span class=\"glyphicon glyphicon-picture\"></span> 相册</a>
			  <a type=\"button\" class=\"btn btn-info\" href=\"/About/About.php\"><span class=\"glyphicon glyphicon-question-sign\"></span> 关于</a>
			  <a type=\"button\" class=\"btn btn-info\" href=\"/Login/Logout.php\"><span class=\"glyphicon glyphicon-log-out\"></span> $userName 注销</a>
			";
		}
		else{
			$navHTML="
			  <a type=\"button\" class=\"btn btn-info\" href=\"\"><span class=\"glyphicon glyphicon-home\"></span> 首页</a>
			  <a type=\"button\" class=\"btn btn-info\" href=\"/About/About.php\"><span class=\"glyphicon glyphicon-question-sign\"></span> 关于</a>
			  <a type=\"button\" class=\"btn btn-info\" href=\"/Login/Login.php\"><span class=\"glyphicon glyphicon-log-in\"></span> 登录</a>
			  <a type=\"button\" class=\"btn btn-info\" href=\"/Register/Register.php\"><span class=\"glyphicon glyphicon-user\"></span> 注册</a>
			";
		}

		   print($navHTML);
	  ?>
	</div>
</div>