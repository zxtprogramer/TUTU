<div class="MyNav">
	  <?php 
		if($ifLogin==1){
			$navHTML="
			  <button class=\"NavButton\" onclick=\"self.location='/Home/Home.php'\">
				<span class=\"glyphicon glyphicon-home\"></span> 首页
			  </button>

			  <button class=\"NavButton\" onclick=\"self.location='/Find/Find.php'\">
				<span class=\"glyphicon glyphicon-globe\"></span> 发现
			  </button>

			  <button class=\"NavButton\" data-toggle=\"modal\" data-target=\"#quickUploadModal\" onclick=\"initQuickUpload()\">
				<span style='color:#228A05;font-size:30px' class=\"glyphicon glyphicon-camera\"></span> 
			  </button>

			  <button class=\"NavButton\" onclick=\"self.location='/UserPage/UserPage.php?PageUserID=$userID'\">
				<span class=\"glyphicon glyphicon-picture\"></span> 相册
			  </button>

			  <button class=\"NavButton\" onclick=\"self.location='/User/User.php'\">
				<span class=\"glyphicon glyphicon-user\"> </span> 我 
			  </button>
			";
		}
		else{
			$navHTML="
			  <button class=\"NavButton\" onclick=\"self.location='/Home/Home.php'\">
				<span class=\"glyphicon glyphicon-home\"></span> 首页
			  </button>

			  <button class=\"NavButton\" onclick=\"self.location='/Find/Find.php'\">
				<span class=\"glyphicon glyphicon-globe\"></span> 发现
			  </button>

			  <button class=\"NavButton\" onclick=\"self.location='/About/About.php'\">
				<span class=\"glyphicon glyphicon-question-sign\"></span> 帮助
			  </button>

			  <button class=\"NavButton\" data-toggle=\"modal\" data-target=\"#loginModal\">
				<span class=\"glyphicon glyphicon-log-in\"></span> 登录
			  </button>

			  <button class=\"NavButton\" data-toggle=\"modal\" data-target=\"#registerModal\">
				<span class=\"glyphicon glyphicon-user\"></span> 注册
			  </button>
			";
		}

		   print($navHTML);
	  ?>
</div>
	  

