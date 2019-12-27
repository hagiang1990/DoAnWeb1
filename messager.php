<?php
    require_once 'init.php';
    require_once 'functions.php';
    $UserID = $currentUser["UserID"];
    $CountFriend = GetCountFriend($UserID);
    $listNotify = array();
    $listNotify = GetNotifyByUser($UserID);
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

                           

                            
                            
                        </div>

                        <!-- Newsfeed Common Side Bar Right
          ================================================= -->
                        <div class="col-md-2 static">
                            <div class="suggestions" id="sticky-sidebar">
                                <h4 class="grey">Hoạt động gần đây</h4>
                                <?php foreach ($listNotify as $item) { ?>
                                    <div class="feed-item">
                                        <div class="live-activity">
                                            <p><a href="#" class="profile-link"><?php echo $item["FullName"] ?></a> 
                                                vừa mới
                                                <?php echo $item["ShortDescription"]; ?>
                                            </p>
                                            <p class="text-muted"><?php echo date_format(date_create($item["CreatedDate"]),"d/m/Y H:i:s");?></p>
                                            <?php if(intVal($item["NotificationType"]) == 0){?>
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    <button type="button" class="btn btn-primary">Đồng ý</button>
                                                    <button type="button" class="btn btn-secondary">Từ chối</button>
                                                  
                                                </div>
                                            <?php }?>
                                        </div>
                                    </div>
                                <?php }?>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php require_once("footer.php") ?>
                
    </body>

    </html>