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
          <input type="hidden" id="LoginRnd" value="<?php session_start();$rnd=rand(0,9999);$_SESSION['LoginRnd']=$rnd;print $rnd; ?>" ></input>
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


<!-- Find Setting Modal -->
<div class="modal fade" id="findSetModal" tabindex="-1" role="dialog" aria-labelledby="findSetModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="findSetModalLabel">设置</h4>
      </div>

      <div class="modal-body"> 
        <form class="form-inline">
          <label>排序方式</label>
          <div class="radio">
            <label> <input type="radio" name="SortType" value="ShootTime" checked> 时间 </label>
            <label> <input type="radio" name="SortType" value="LikeNum" > 点赞 </label>
            <label> <input type="radio" name="SortType" value="CommentNum" > 评论 </label>
          </div>
          <div class="radio">
            <label> <input type="radio" name="UpOrDown" value="DESC" checked> 降序 </label>
            <label> <input type="radio" name="UpOrDown" value="ASC" > 升序 </label>
          </div>

          <div class="form-group">
              <label>单次最大数目</label>
              <input type="text" class="form-control" id="PicNumOnce" value="500">
          </div>
        </form>


      </div>

      <div class="modal-footer">
        <div class="input-group">
          <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
          <button type="button" class="btn btn-primary" onclick="setFind();">确定</button>
        </div>

      </div>

    </div>
  </div>
</div>


<!-- Comment Modal -->
<div class="modal fade" id="commentModal" tabindex="-1" role="dialog" aria-labelledby="commentModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="commentModalLabel">评论</h4>
      </div>

      <div class="modal-body"> 
        <ul class="list-group" id="CommentList">
        </ul>
      
      </div>

      <div class="modal-footer">
        <div class="input-group">
          <span class="input-group-addon" onclick="sendComment()">发布</span>
          <input type="text" class="form-control" id="CommentInput"></input>
        </div>

      </div>

    </div>
  </div>
</div>


<!-- Modify Pic Modal -->
<div class="modal fade" id="editPicModal" tabindex="-1" role="dialog" aria-labelledby="editPicModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="editPicModalLabel">修改</h4>
      </div>

      <div class="modal-body"> 
      
        <div class="input-group">
          <span class="input-group-addon">描述</span>
          <input type="text" class="form-control" id="EditPicDes"></input>
        </div>

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <button type="button" class="btn btn-primary" onclick="editPic();">确定</button>
      </div>
    </div>
  </div>
</div>


<!-- Upload Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="uploadModalLabel">上传</h4>
      </div>
      <div class="modal-body"> 
        <input id="UploadFile" name="files" type="file" multiple accept="image/*, video/*"></input>
        <br />
        <ul id="UploadList" class="list-group">
        </ul>
        
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <button type="button" class="btn btn-primary" onclick="upload();">上传</button>
      </div>
    </div>
  </div>
</div>


    <!-- Edit Album Modal -->
<div class="modal fade" id="editAlbumModal" tabindex="-1" role="dialog" aria-labelledby="editAlbumModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="editAlbumModalLabel">修改相册</h4>
      </div>
      <div class="modal-body">
        <div class="input-group">
          <span class="input-group-addon">名称</span>
          <input type="text" class="form-control" id="EditAlbumName"></input>
        </div>
        <br />
        <div class="input-group">
          <span class="input-group-addon">描述</span>
          <input type="text" class="form-control" id="EditAlbumDes"></input>
        </div>
        <br />
        
        <div class="checkbox">
          <label>
          <input id="EditIfShare" type="checkbox" checked="checked"></input> 公开
          </label>
        </div>
 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="editAlbum();">确定</button>
      </div>
    </div>
  </div>
</div>
 
  
  
  <!-- New Album Modal -->
<div class="modal fade" id="newAlbumModal" tabindex="-1" role="dialog" aria-labelledby="newAlbumModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="newAlbumModalLabel">新建相册</h4>
      </div>
      <div class="modal-body">
        <div class="input-group">
          <span class="input-group-addon">名称</span>
          <input type="text" class="form-control" id="newAlbumName"></input>
        </div>
        <br />
        <div class="input-group">
          <span class="input-group-addon">描述</span>
          <input type="text" class="form-control" id="newAlbumDes"></input>
        </div>
        <br />
        
        <div class="checkbox">
          <label>
          <input id="NewIfShare" type="checkbox" checked="checked"> 公开
          </label>
        </div>
 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="newAlbum();">新建</button>
      </div>
    </div>
  </div>
</div>
<!-- --------------------------------------------------------------------------------------------------------- --> 

  <!-- Edit ShareCode Modal -->
<div class="modal fade" id="editShareCodeModal" tabindex="-1" role="dialog" aria-labelledby="editShareCodeModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="editShareCodeModalLabel">设置分享码</h4>
      </div>

      <div class="modal-body">
        <div class="input-group">
          <span class="input-group-addon">分享地址</span>
          <input type="text" class="form-control" id="ShareURLInput"></input>
        </div>
        <br />
 
        <div class="input-group">
          <span class="input-group-addon">分享码</span>
          <input type="text" class="form-control" id="ShareCodeInput"></input>
          <input type="hidden" class="form-control" id="AlbumIDInput"></input>
        </div>
        <br />
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="setShareCode();">确定</button>
      </div>
    </div>
  </div>
</div>
<!-- --------------------------------------------------------------------------------------------------------- --> 


<!---Check ShareCode Modal-->
<div class="modal fade" id="checkShareCodeModal" tabindex="-1" role="dialog" aria-labelledby="checkShareCodeModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="checkShareCodeModalLabel">输入分享码</h4>
      </div>

      <div class="modal-body">
        <div class="input-group">
          <span class="input-group-addon">分享码</span>
          <input type="text" class="form-control" id="CheckShareCodeInput"></input>
        </div>
        <br />
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="checkShareCode();">确定</button>
      </div>
    </div>
  </div>
</div>
<!----------------------------------------------------------------------------------------------------------- -->




