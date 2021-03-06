<?php
    require_once 'init.php';
    require_once 'functions.php';
    $UserID = $currentUser["UserID"];
    $CountFriend = GetCountFriend($UserID);
  
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <?php require_once("header.php") ?>

    </head>

    <body>
        <?php include("menu-top.php") ?>
            <div id="page-contents">
                <div class="container-fluid">
                    <div class="row">

                        <!-- Newsfeed Common Side Bar Left
          ================================================= -->
                        <div class="col-md-3 static">
                            <div class="profile-card">
                                <img src="img/<?php echo $currentUser["ImageUrl"]?>" alt="user" class="profile-photo" />
                                <h5><a href="info.php" class="text-white"><?php echo $currentUser["FullName"];?></a></h5>
                                <a href="#" class="text-white"><i class="ion ion-android-person-add"></i> <?php echo $CountFriend;?> bạn</a>
                            </div>
                            <!--profile card ends-->
                            <?php include("menu-left.php") ?>
                            
                        </div>

                        <div class="col-md-7">

                            <!-- Post Create Box
            ================================================= -->
                            <div class="create-post">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <img src="img/<?php echo $currentUser["ImageUrl"]?>" alt="" class="profile-photo-md" />
                                            <textarea data-emojiable="true" name="txtNewFeeds" id="txtNewFeeds" cols="100" rows="5" class="form-control" placeholder="Hôm nay bạn cảm thấy thế nào"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12">
                                        <div class="tools  pull-right">
                                            <ul class="publishing-tools list-inline">
                                                <!--<li><a href="#"><i class="ion-compose"></i></a></li>-->
                                                <li><a onclick="javascript: $('#txtImage').click();"><i class="ion-images"></i></a>
                                                    <input type="file" id="txtImage" name="txtImage" style="display:none;" />

                                                </li>
                                                <li>
                                                    <select class="form-control" name="isPrivate"  id="isPrivate" style="font-family: fontAwesome">
                                                        <option value="0" selected>&#xf0ac;</option>
                                                        <option value='1'>&#xf0c0;</option>
                                                        <option value="-1">&#xf084;</option>
                                                        
                                                    </select>
                                                </li>
                                          
                                            </ul>
                                            <button class="btn btn-primary pull-right" id="btnAddNewFeed">Đăng tin</button>

                                        </div>
                                    </div>
                                    <div class="col-md-12 col-xs-12">
                                        <div id="review" style="display:table-cell; vertical-align:middle; text-align:center"></div>
                                    </div>
                                </div>
                            </div>
                            <!-- Post Create Box End-->

                            <!-- Post Content
            ================================================= -->
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

                        <!-- Newsfeed Common Side Bar Right
          ================================================= -->
                        <?php require_once("Notify.php") ?>
                    </div>
                </div>
            </div>
            <?php require_once("footer.php") ?>
                <script>
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
                        $.get("LoadNewFeed.php?pagenum="+ pageNum,function(data){
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