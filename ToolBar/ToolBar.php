
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
