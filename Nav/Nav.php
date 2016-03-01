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
				<span class=\"glyphicon glyphicon-camera\"></span> 上传
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
	  
 <!-- Register Modal -->
<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="registerModalLabel">注册</h4>
      </div>
      <div class="modal-body">

        <div class="input-group">
          <span class="input-group-addon">昵称</span>
          <input type="text" class="form-control" id="RegisterName"></input>
        </div>
        <br />
 
        <div class="input-group">
          <span class="input-group-addon">邮箱</span>
          <input type="text" class="form-control" id="RegisterEmail"></input>
        </div>
        <br />
        <div class="input-group">
          <span class="input-group-addon">密码</span>
          <input type="password" class="form-control" id="RegisterPassword"></input>
        </div>
        <br />
        <br />

        <img id="checkpic" onclick="changeCheckCode()" src="/CheckCode.php" />
        <div class="input-group">
          <span class="input-group-addon">验证码</span>
          <input type="text" class="form-control" id="CheckCode"></input>
        </div>
 

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <button type="button" class="btn btn-primary" onclick="quickRegister();">注册</button>
      </div>
    </div>
  </div>
</div>
  
  
<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="loginModalLabel">登录</h4>
      </div>
      <div class="modal-body">
        <div class="input-group">
          <span class="input-group-addon">邮箱</span>
          <input type="text" class="form-control" id="LoginEmail"></input>
        </div>
        <br />
        <div class="input-group">
          <span class="input-group-addon">密码</span>
          <input type="password" class="form-control" id="LoginPassword"></input>
        </div>
 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="quickLogin();">登录</button>
      </div>
    </div>
  </div>
</div>
  


<!-- QuickUpload Modal -->
<div class="modal fade" id="quickUploadModal" tabindex="-1" role="dialog" aria-labelledby="quickUploadModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="quickUploadModalLabel">快速上传</h4>
      </div>
      <div class="modal-body"> 
        选择相册
        <select onchange="selectChange()" class="form-control" id="AlbumList_QU">
           <option value="-1">新建相册</option>
        </select>
        <br />

        <div id="NewAlbum_QU">
        新建相册
            <div class="input-group">
              <span class="input-group-addon">名称</span>
              <input type="text" class="form-control" id="newAlbumName_QU"></input>
            </div>
            <br />
            <div class="input-group">
              <span class="input-group-addon">描述</span>
              <input type="text" class="form-control" id="newAlbumDes_QU"></input>
            </div>
            <br />
                
            <div class="checkbox">
              <label>
              <input id="NewIfShare_QU" type="checkbox" checked="checked"> 公开
              </label>
            </div>
        </div>

        <br />
        
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <button type="button" class="btn btn-primary" onclick="quickUpload();">确定</button>
      </div>
    </div>
  </div>
</div>


