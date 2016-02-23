    <div id="PicPanelDiv" class="PicPanelDiv">
    
      <div id="PicPanelCloseDiv" class="PicPanelCloseDiv" onclick="closePicPanel()">
        <span style="font-size:40px" class="glyphicon glyphicon-remove-sign"></span>
      </div>
    
      <div id="PicPanelImgDiv" class="PicPanelImgDiv" onclick="hideCmt();">
        <a href="javascript:"><img id="PicPanelImg" class="PicPanelImg" src="" /></a>
        <a href="javascript:"><video id="PicPanelVideo" class="PicPanelVideo" src="" controls="controls"/></a>
      </div>

      <div id="PicPanelTool2Div" class="PicPanelTool2Div">
        <a href="javascript:befPic_Panel()"><span style="font-size:25px" class="glyphicon glyphicon-chevron-left"></span></a>
        <a href="javascript:nextPic_Panel()"><span style="font-size:25px"  class="glyphicon glyphicon-chevron-right"></span></a>

        <a href="javascript:likeFun()"><span style="font-size:25px" class="glyphicon glyphicon-thumbs-up"></span></a>
        <span style="font-size:25px" id="LikeNumLabel">0 </span>
        <a href="javascript:showComment()"> <span style="font-size:25px" class="glyphicon glyphicon-comment"></span> </a>
        <a href="javascript:showInfo()"> <span style="font-size:25px" class="glyphicon glyphicon-info-sign"></span> </a>
      </div>

      <div id="PicInfoDiv" class="PicInfoDiv">
      </div>


      <div id="PicPanelCmtDiv" class="PicPanelCmtDiv">
        <div id="PicCmtContentDiv" class="PicCmtContentDiv" > </div>
        <div id="PicCmtSendDiv" class="PicCmtSendDiv" >
          <div class="input-group">
            <span class="input-group-addon" onclick="sendCmtFun()">发送</span>
            <input id="CmtContentText" type="text" class="form-control" id="RegisterName"></input>
          </div>
        </div>
            
        </div>
      </div>

    </div>

