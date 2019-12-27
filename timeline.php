<?php
      require_once 'init.php';
      require_once 'functions.php';
      $UserID = $currentUser["UserID"];
      
      $pUserID = $_GET["u"];
      $pUser = findUserById($pUserID);
      $CountFriend = GetCountFriend($pUserID);
      $isFriend = GetFriend($UserID,$pUserID);
      if($pUser == null)
        header('Location: index.php'); 
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php require_once("header.php") ?>
    </head>
<body>
<?php include("menu-top.php") ?>
<div class="container-fluid">

      <!-- Timeline
      ================================================= -->
      <div class="timeline">
        <div class="timeline-cover">

          <!--Timeline Menu for Large Screens-->
          <div class="timeline-nav-bar hidden-sm hidden-xs">
            <div class="row">
              <div class="col-md-3">
                <div class="profile-info">
                  <img src="img/<?php echo $pUser["ImageUrl"]?>" alt="" class="img-responsive profile-photo" />
                  <h3><?php echo $pUser["FullName"] ?></h3>
                  <p class="text-muted"><?php echo $pUser["Email"]; ?></p>
                </div>
              </div>
              <div class="col-md-9">
                <ul class="list-inline profile-menu">
                  <li><a href="timeline.php?u=<?php echo $UserID?>">Dòng thời gian</a></li>
                  <li><a href="info.php" class="active">Thông tin</a></li>
                 
                  <li><a href="friends.php">Bạn bè</a></li>
                 
                </ul>
                <ul class="follow-me list-inline">
                  <li><?php echo $CountFriend;?> bạn bè</li>
                <?php if($UserID != $pUserID) { ?>
                  <?php if($isFriend != null) {
                          if($isFriend["IsFollow"] == 1) {   
                  ?>
                         <li><button class="btn-danger" id="btnUnFollow">Hủy theo dõi</button></li>
                  <?php } else{  
                            if($isFriend["IsAccept"] == 1) { ?>
                                <li><button class="btn-success" id="btnFollow">Theo dõi</button></li>
                  <?php } else { ?>
                                <li> <span class="text-green">Đã gửi lời mời kết bạn</span> </li>
                  <?php  } }
                }else { ?>
                    <li><button class="btn-primary" id="btnAddFriend" onclick="AddFriend(<?php echo $UserID; ?>,<?php echo $pUserID; ?>)" >Kết bạn</button></li>
                <?php } }?>
                </ul>
              </div>
            </div>
          </div><!--Timeline Menu for Large Screens End-->

          <!--Timeline Menu for Small Screens-->
          <div class="navbar-mobile hidden-lg hidden-md">
            <div class="profile-info">
              <img src="img/<?php echo $pUser["ImageUrl"]?>" alt="" class="img-responsive profile-photo" />
              <h4><?php echo $pUser["FullName"] ?></h4>
              <p class="text-muted"><?php echo $pUser["Phone"]; ?></p>
            </div>
            <div class="mobile-menu">
             
              <<!--button class="btn-primary">Add Friend</button>-->
            </div>
          </div><!--Timeline Menu for Small Screens End-->

        </div>
        <div id="page-contents">
          <div class="row">
            <div class="col-md-3">
              
             
            </div>
            <!-- Content timeline -->
            <div class="col-md-9">
                <div id="LoadNewFeed">
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button data-page="1" class="btn btn-info  btn-block" id="btnLoadMore">
                            <span id="text">Load thêm</span>
                            <i id="loading" class="fa "></i>
                        </button>
                    </div>
                </div>
              
              
            </div>
            <!--End Content TimeLine -->
           
           
          </div>
        </div>
      </div>
    </div>
<div id="page-contents">
        
        
        <div class="container">
            
        </div><!--//main-body-->
    </div>
    <?php require_once("footer.php") ?>
    <script>
      function AddFriend(UserID,FriendID)
                    {
                        $.ajax({
                            url: 'newfeeds.php',
                            data: {"UserID": UserID,"FriendID":FriendID,"Method":"AF"},
                            type: 'POST',
                            success: function(data)
                            {
                                 
                                 //if(data)
                                 //{
                                   Notify("Thông báo: ","<strong>Gửi lời mời thành công</strong>","info","glyphicon glyphicon-bullhorn")
                                    location.reload();
                                 //}
                                 //else
                                 //   Notify("Thông báo: ","<strong>Gửi lời mời thất bại</strong>","info","glyphicon glyphicon-bullhorn")
                            },
                            error: function() {
                                Notify("Thông báo: ","<strong>Bạn không xóa bản tin này</strong>","info","glyphicon glyphicon-bullhorn")
                            }
                        });
                    }

                    
                    LoadNewFeed(1);
                    function filePreview(input) {
                        if (input.files && input.files[0]) {
                            var reader = new FileReader();
                            reader.onload = function(e) {
                                $('#review').empty();
                                $('#review').append('<img src="' + e.target.result + '" width="100%" max-height="300"/>');
                            };
                            reader.readAsDataURL(input.files[0]);
                        }
                    }
                    $("#txtImage").change(function() {
                        filePreview(this);
                    });
                    $("#btnAddNewFeed").on("click", function() {
                        var newFeedContent = $("#txtNewFeeds").val();
                        if(newFeedContent !="")
                        {
                            
                            var newFeedType = $("#isPrivate").val();
                            var formData = new FormData();
                            formData.append("NewFeedContent",newFeedContent);
                            formData.append("NewFeedType",newFeedType);
                            formData.append('fImage',  $('#txtImage')[0].files[0]); 
                            formData.append("Method","ADD");
                            formData.append("UserID","<?php echo $UserID;?>")
                            $.ajax({
                                url: 'newfeeds.php',
                                data: formData,
                                type: 'POST',
                                contentType: false, 
                                processData: false,
                                success: function(data)
                                {
                                    if(data != "")
                                    {
                                        LoadNewFeed(-1);
                                        $("#txtImage").val("").change();
                                        $('#review').empty();
                                        $("#txtNewFeeds").val("");
                                        Notify("Thông báo: ","<strong>Đăng tin thành công</strong>","info","glyphicon glyphicon-bullhorn")
                                    }

                                },
                                error: function() {
                                    alert("Đăng tin lỗi");
                                }
                            });
                       
                        }
                        else
                        {
                            Notify("Thông báo: ","<strong>Bạn không thể để trống thông tin</strong>","info","glyphicon glyphicon-bullhorn")
                        }
                    });
                    var loading;
                    function LoadNewFeed(pageNum)
                    {
                        if(pageNum == -1) // trường hợp reload trang
                        {
                            $("#LoadNewFeed").empty(); 
                            pageNum = 1;
                            $("#btnLoadMore").attr("data-page" ,1);
                        }
                      
                       
                        $("#LoadNewFeed").append($('<div id="btnLoading" class="spinner-border text-primary"></div>'));
                        $.get("LoadTimeLine.php?pagenum="+ pageNum+ "&UserView=<?php echo $pUserID;?>",function(data){
                            if( data != "    ")
                            {
                                $("#LoadNewFeed").append(data);
                                var PageNum = parseInt($("#btnLoadMore").attr("data-page"));
                                $("#btnLoadMore").attr("data-page" ,PageNum + 1);
                                $("#btnLoading").remove();
                            }
                            else
                                $("#btnLoadMore").hide();
                            $("#text").html("Load thêm");
                            $("#loading").removeClass("fa-spinner");
                            $("#loading").removeClass("fa-spin");
                            clearTimeout(loading);
                           
                        });
                    }
                    
                    $("#btnLoadMore").on("click",function(){
                        $("#loading").addClass("fa-spinner fa-spin");
                        $("#text").html("Đang tải...");
                        
                        var PageNum = parseInt($(this).attr("data-page"));
                        var loading = setTimeout(function(){
                            LoadNewFeed(PageNum);
                        },1000);
                        
                        
                    });

                    function AddLike(userID,newFeedID,isLike)
                    {
                        $.ajax({
                                url: 'newfeeds.php',
                                data: {"UserID": userID,"NewFeedID": newFeedID,"Method":"LIKE"},
                                type: 'POST',
                                
                                success: function(data)
                                {
                                  var result = JSON.parse(data);
                                  $("a[data-idNewFeed='"+ newFeedID +"']").attr("data-num",result.NumLike);
                                  $("span[data-idNewFeed='"+ newFeedID +"']").text(result.NumLike);
                                  if(isLike)
                                  {
                                    $("a[data-idNewFeed='"+ newFeedID +"']").removeClass("text-blue");
                                    $("a[data-idNewFeed='"+ newFeedID +"']").addClass("text-muted");
                                  }
                                  else
                                  {
                                    $("a[data-idNewFeed='"+ newFeedID +"']").addClass("text-blue");
                                    $("a[data-idNewFeed='"+ newFeedID +"']").removeClass("text-muted");
                                  } 
                                  $("a[data-idNewFeed='"+ newFeedID +"']").attr("onclick","AddLike("+ userID +","+ newFeedID +","+ !isLike +")")
                                },
                                error: function() {
                                   
                                }
                            });
                    }
                    function DeleteNewFeed(newFeedID)
                    {
                        $.ajax({
                            url: 'newfeeds.php',
                            data: {"NewFeedID": newFeedID,"Method":"DEL"},
                            type: 'POST',
                            success: function(data)
                            {
                                 if(data == 1)
                                 {
                                     $(".post-content[data-id='"+newFeedID+"']").remove();
                                 }
                                 else
                                    Notify("Thông báo: ","<strong>Bạn không xóa bản tin này</strong>","info","glyphicon glyphicon-bullhorn")
                            },
                            error: function() {
                                Notify("Thông báo: ","<strong>Bạn không xóa bản tin này</strong>","info","glyphicon glyphicon-bullhorn")
                            }
                        });
                    }

                    function AddComment(newFeedID, UserID)
                    {
                        var content = $("input[data-id='"+ newFeedID +"']").val();
                        if(content != "")
                        {
                            $.ajax({
                                url: 'newfeeds.php',
                                data: {"UserID": UserID,"NewFeedID": newFeedID,"Method":"CM" , "CommentContent": content},
                                type: 'POST',
                                success: function(data)
                                {
                                    console.log(data);
                                    if(data > 0)
                                    {
                                        $("input[data-id='"+ newFeedID +"']").val("");
                                        var htmlGet = $.get("LoadComment.php?id=" + data,function(d){
                                            
                                            $(d).insertBefore($(".post-comment[data-idNewFeed='"+ newFeedID +"']"));

                                        });
                                       
                                    }
                                    else
                                        Notify("Thông báo: ","<strong>Đã xảy ra lỗi</strong>","info","glyphicon glyphicon-bullhorn")
                                },
                                error: function() {
                                    Notify("Thông báo: ","<strong>Đã xảy ra lỗi</strong>","info","glyphicon glyphicon-bullhorn")
                                }
                            });
                        }
                        
                    }
    </script>
</body>
</html>