<?php
    require_once 'init.php';
    require_once 'functions.php';
    $UserID = $currentUser["UserID"];
    $CountFriend = GetCountFriend($UserID);
    $listResult = array();
    $listResult = LoadFriend($UserID);

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

                         

                         
                            <!-- Friend List
            ================================================= -->
                            <div class="friend-list">
                                <div class="row">
                            <?php foreach( $listResult as $item){?>
                                <div class="col-md-6 col-sm-6">
                                        <div class="friend-card">
                                            <img src="img/background-login.jpg" alt="profile-cover" class="img-responsive cover" />
                                            <div class="card-info">
                                                <img src="img/<?php echo $item["ImageUrl"]?>" alt="user" class="profile-photo-lg" />
                                                <div class="friend-info">
                                                    <a href="#" class="pull-right text-green">
                                                        Bạn bè
                                                    </a>
                                                    <h5><a href="timeline.php?u=<?php echo $item["UserID"]?>" target="_blank" class="profile-link"><?php echo $item["FullName"]?></a></h5>
                                                    <p><?php echo $item["Email"]?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            <?php }?>
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
               
    </body>

    </html>