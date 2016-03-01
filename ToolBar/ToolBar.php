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
 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="newAlbum();">新建</button>
      </div>
    </div>
  </div>
</div>




<div id="ToolBar" tabindex="1">
  <div class="btn-group" role="group">
  <?php 
  if($nowPage=="Pic" || $nowPage=="Find"){
  	$bar="
	  <button type=\"button\" class=\"btn btn-default\" onclick=\"javascript:beforePic();\" id=\"BeforeBtn\"><span class=\"glyphicon glyphicon-chevron-left\"></span></button>
	  <button type=\"button\" class=\"btn btn-default\" onclick=\"javascript:nextPic();\" id=\"NextBtn\"><span class=\"glyphicon glyphicon-chevron-right\"></span></button>
	  <button type=\"button\" class=\"btn btn-default\" onclick=\"javascript:likeFun();\" id=\"LikeBtn\"><span class=\"glyphicon glyphicon-thumbs-up\"></span></button>
	  <button type=\"button\" class=\"btn btn-default\" onclick=\"javascript:initCommentPanel();\" data-toggle=\"modal\" data-target=\"#commentModal\" id=\"CmtBtn\"><span class=\"glyphicon glyphicon-comment\"></span></button>
	  ";
  	print($bar);
  }
 
  ?>
  </div>
  
  <?php 
  if($nowPage=="Pic"){
	  if($ifLogin==1 && $albumUserID==$userID){
		  $editBar='
			<div class="btn-group" role="group">
			  <button type="button" class="btn btn-default" data-toggle="modal" data-target="#uploadModal" id="UploadBtn"><span class="glyphicon glyphicon-open"></span></button>
			  <button type="button" class="btn btn-default" onclick="javascript:movePic()" id="MoveBtn"><span class="glyphicon glyphicon-move"></span></button>
			  <button type="button" class="btn btn-default" onclick="javascript:initEditPic()" data-toggle="modal" data-target="#editPicModal" id="EditBtn"><span class="glyphicon glyphicon-pencil"></span></button>
			  <button type="button" class="btn btn-danger" onclick="javascript:delPic()" id="DeleteBtn"><span class="glyphicon glyphicon-trash"></span></button>
			</div>
		';
		  print($editBar);
	  }
      
  }
  if($nowPage=="Find"){
      $editBar='
        <div class="btn-group" role="group">
          <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#findSetModal" onclick="javascript:" id="SetFindBtn"><span class="glyphicon glyphicon-cog"></span></button>
        </div>
    ';
      print($editBar);





  }
  
  
  ?>
</div>
