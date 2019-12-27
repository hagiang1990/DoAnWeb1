<?php
    require_once 'init.php';
    require_once 'functions.php';
    $UserID = $currentUser["UserID"];
    $CountFriend = GetCountFriend($UserID);
    $listMessger = array();
    $listMessger = LoadMessgerByUser($UserID);
    $listFriend = array();
    $listFriend = LoadFriend($UserID);
    if(isset($_POST["cboToUser"]))
    {
        $ToUserID = $_POST["cboToUser"];
       
        AddMsg($UserID,$ToUserID);
        header('Location: messager.php'); 
    }
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
                            <div class="row">
                                <div class="col-md-12">
                                    <form action="messager.php" method="POST" class="form-inline">
                                        <div class="form-group mb-2">
                                            <label for="staticEmail2" class="sr-only">Email</label>
                                            <select class="form-control" name="cboToUser">
                                            <?php foreach($listFriend as $item){
                                                if(!CheckExistsMsg($item["UserID"])) {   
                                            ?>
                                                <option value="<?php echo $item["UserID"]?>">
                                                    <?php echo $item["FullName"]?>
                                                </option>
                                            <?php } }?>
                                            </select>
                                        </div>
                                       
                                        <button class="btn btn-primary" name="btnAddNew" type="submmit">Tạo mới</button>
                                    </form>
                                   
                                </div>
                            </div>
                            <div class="chat-room">
                                <div clas="row">
                                    <div class="col-md-5">
                                        <ul class="nav nav-tabs contact-list scrollbar-wrapper scrollbar-outer">
                                            <?php foreach($listMessger as $item){?>
                                                <li>
                                                    <a onclick="LoadContent(<?php echo $item["MessegerID"]?>)" data-toggle="tab">
                                                        <div class="contact">
                                                            <img src="img/<?php echo $item["ImageUrl"]?>" alt="" class="profile-photo-sm pull-left"/>
                                                            <div class="msg-preview">
                                                                <h6><?php echo $item["FullName"]?></h6>
                                                                <p class="text-muted">SMS cuối lúc
                                                                    - <?php echo date_format(date_create($item["Lastime"]),"d/m/Y H:i:s");?>
                                                                </p>
                                                                
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li>
                                            <?php }?>
                                        </ul>
                                    </div>
                                    <div class="col-md-7">
                                        <div id="LoadContentMsg" data-id="0" class="tab-content scrollbar-wrapper wrapper scrollbar-outer">
                                                
                                        </div>
                                    </div>
                                    <div class="send-message">
                                        <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Nhập nội dung" id="txtMsg">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button" onclick="SendMsg()">Gửi</button>
                                        </span>
                                        </div>
                                    </div>
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
                function LoadContent(ID)
                {
                    $("#LoadContentMsg").empty();
                    $("#LoadContentMsg").attr("data-id",ID);
                    $.get("LoadMessger.php?ID="+ ID,function(data){
                        $("#LoadContentMsg").append(data);
                    });

                }
                function SendMsg()
                {
                    id = $("#LoadContentMsg").attr("data-id");
                    content = $("#txtMsg").val();
                    $.ajax({
                                url: 'newfeeds.php',
                                data: {"UserID": '<?php echo $currentUser["UserID"]; ?>',"ID": id,"Content": content,"Method":"ADDMSGD"},
                                type: 'POST',
                                success: function(data)
                                {
                                   console.log(data);
                                   $("#txtMsg").val("");
                                   LoadContent(id);
                                
                                },
                                error: function() {
                                   
                                }
                    });

                }
            </script>
    </body>

    </html>