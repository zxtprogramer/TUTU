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
        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="upload();">上传</button>
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
  if($nowPage=="Pic"){
  	$bar="
	  <button type=\"button\" class=\"btn btn-default\" onclick=\"javascript:beforePic();\" id=\"BeforeBtn\"><span class=\"glyphicon glyphicon-chevron-left\"></span></button>
	  <button type=\"button\" class=\"btn btn-default\" onclick=\"javascript:nextPic();\" id=\"NextBtn\"><span class=\"glyphicon glyphicon-chevron-right\"></span></button>
	  ";
  	print($bar);
  }
  
   if($nowPage=="Album"){
  	$bar="
	  <button type=\"button\" class=\"btn btn-default\" onclick=\"javascript:beforeAlbum();\" id=\"BeforeAlbumBtn\"><span class=\"glyphicon glyphicon-chevron-left\"></span></button>
	  <button type=\"button\" class=\"btn btn-default\" onclick=\"javascript:nextAlbum();\" id=\"NextAlbumBtn\"><span class=\"glyphicon glyphicon-chevron-right\"></span></button>
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
			  <button type="button" class="btn btn-danger" onclick="javascript:delPic()" id="DeleteBtn"><span class="glyphicon glyphicon-trash"></span></button>
			</div>
		';
		  print($editBar);
	  }
  }
  
  
   if($nowPage=="Album"){
	  if($ifLogin==1){
		  $editBar='
			<div class="btn-group" role="group">
			  <button type="button" class="btn btn-default" data-toggle="modal" data-target="#newAlbumModal" id="NewAlbumBtn"><span class="glyphicon glyphicon-plus">新建</span></button>
			</div>
		';
		  print($editBar);
	  }
  }
 

  ?>
</div>
