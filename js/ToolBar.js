//----------------------------comment panel-----------------------------------------
function sendComment(){
    var xmlhttp;
    xmlhttp=new XMLHttpRequest();
    xmlhttp.onreadystatechange=function(){
        if(xmlhttp.readyState==4 && xmlhttp.status==200){
            initCommentPanel();
            picArray=getAlbumPic(albumID);
            showPicDiv();
        }
    };

    xmlhttp.open("POST", "/Command.php",false);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    cmtContent=encodeURIComponent($("#CommentInput").val());
    if(cmtContent.length<=0){
        return;
    }
    picID=picArray[nowPicIndex]["PicID"];
    xmlhttp.send("cmd=sendComment&picID=" + picID + "&cmt=" + cmtContent);
}

function initCommentPanel(){
    var cmtArray=getComment(picArray[nowPicIndex]['PicID']);
    cmt=[];
    str="";
    $("#CommentInput").val("");
    for(var i=0;i<cmtArray.length;i++){
        cmtUserName=cmtArray[i]['UserName'];
        cmtTime=getTimeStr(cmtArray[i]['CreateTime']);
        cmtStr=cmtArray[i]['Comment'];
        cmtUserID=cmtArray[i]['UserID'];
        str='<li onclick="replyFun(\''+cmtUserName+'\')" class="list-group-item"><span class="CmtUserName"><a href="/UserPage/UserPage.php?PageUserID='+ cmtUserID +'">' + cmtUserName + "</a></span>" + '<span class="CmtTime"> (' + cmtTime + "): </span><br />" + '<span class="CmtStr">' + cmtStr + '</span></li>';

        cmt.push(str);
    }
    $("#CommentList").html(cmt.join("<br />"));
}

function replyFun(uName){
oldVal=$("#CommentInput").val()
$("#CommentInput").val("回复"+uName+":"+oldVal);
}


function getComment(picID){
    var xmlhttp;
    cmtATmp=new Array();
    xmlhttp=new XMLHttpRequest();
    xmlhttp.onreadystatechange=function(){
        if(xmlhttp.readyState==4 && xmlhttp.status==200){
            res=xmlhttp.responseText;
            if(res.length<=0)return;
            cmtList=res.split("#");
            for(var i=0;i<cmtList.length;i++){
                cmtATmp[i]=new Array();
                cmtInfo=cmtList[i].split(" ");
                for(var j=0;j<cmtInfo.length;j++){
                    key=decodeURIComponent(cmtInfo[j].split("=")[0]);
                    value=decodeURIComponent(cmtInfo[j].split("=")[1]);
                    cmtATmp[i][key]=value;
                }
            }
        }
    };

    xmlhttp.open("POST", "/Command.php",false);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("cmd=getComment&picID=" + picID);
    return cmtATmp;
}

//------------------------comment panel------------------------------------------------
                                                                                                                                                          
