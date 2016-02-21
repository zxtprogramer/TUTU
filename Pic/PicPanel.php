    <div id="PicPanelDiv" class="PicPanelDiv">
      <div id="PicPanelToolDiv" class="PicPanelToolDiv">
        <a href="javascript:befPic_Panel()"><span style="font-size:20px" class="glyphicon glyphicon-chevron-left"></span></a>
        <a href="javascript:nextPic_Panel()"><span style="font-size:20px"  class="glyphicon glyphicon-chevron-right"></span></a>
        <a id="ClosePicPanelButton" href="javascript:closePicPanel()"><span style="font-size:20px"  class="glyphicon glyphicon-remove"></span></a>
      </div>

      <div id="PicPanelImgDiv" class="PicPanelImgDiv">
        <a href="javascript:nextPic_Panel()"><img id="PicPanelImg" class="PicPanelImg" src="" /></a>
        <a href="javascript:nextPic_Panel()"><video id="PicPanelVideo" class="PicPanelVideo" src="" controls="controls"/></a>
      </div>

      <div id="PicPanelTool2Div" class="PicPanelTool2Div">
        <a href="javascript:likeFun()"><span style="font-size:20px" class="glyphicon glyphicon-thumbs-up"></span></a>
        <span style="font-size:20px" id="LikeNumLabel">0</span>
        <a href="javascript:showComment()"> <span style="font-size:20px" class="glyphicon glyphicon-comment"></span> </a>
        <a href="javascript:showInfo()"> <span style="font-size:20px" class="glyphicon glyphicon-info-sign"></span> </a>
      </div>

      <div id="PicInfoDiv" class="PicInfoDiv">
      </div>


      <div id="PicPanelCmtDiv" class="PicPanelCmtDiv">
        <div id="PicCmtContentDiv" class="PicCmtContentDiv" >
        </div>
        <div id="PicCmtSendDiv" class="PicCmtSendDiv" >
          <input id="CmtContentText" type="text" />
          <button class="btn btn-primary" id="CmtSendButton" onclick="sendCmtFun()">发送</button>
        </div>
      </div>

    </div>

