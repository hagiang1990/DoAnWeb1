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
                                <h5><a href="#" class="text-white"><?php echo $currentUser["FullName"];?></a></h5>
                                <a href="#" class="text-white"><i class="ion ion-android-person-add"></i> <?php echo $CountFriend;?> bạn</a>
                            </div>
                            <!--profile card ends-->
                            <?php include("menu-left.php") ?>
                           
                        </div>

                        <div class="col-md-7">

                         

                            <!-- Post Content
            ================================================= -->
                            <!-- Friend List
            ================================================= -->
                            <div class="friend-list">
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                <div class="friend-card">
                                    <img src="http://placehold.it/1030x360" alt="profile-cover" class="img-responsive cover" />
                                    <div class="card-info">
                                    <img src="http://placehold.it/300x300" alt="user" class="profile-photo-lg" />
                                    <div class="friend-info">
                                        <a href="#" class="pull-right text-green">My Friend</a>
                                        <h5><a href="timeline.html" class="profile-link">Sophia Lee</a></h5>
                                        <p>Student at Harvard</p>
                                    </div>
                                    </div>
                                </div>
                                </div>
                                    <div class="col-md-6 col-sm-6">
                                <div class="friend-card">
                                    <img src="http://placehold.it/1030x360" alt="profile-cover" class="img-responsive cover" />
                                    <div class="card-info">
                                    <img src="http://placehold.it/300x300" alt="user" class="profile-photo-lg" />
                                    <div class="friend-info">
                                        <a href="#" class="pull-right text-green">My Friend</a>
                                        <h5><a href="timeline.html" class="profile-link">John Doe</a></h5>
                                        <p>Traveler</p>
                                    </div>
                                    </div>
                                </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                <div class="friend-card">
                                    <img src="http://placehold.it/1030x360" alt="profile-cover" class="img-responsive cover" />
                                    <div class="card-info">
                                    <img src="http://placehold.it/300x300" alt="user" class="profile-photo-lg" />
                                    <div class="friend-info">
                                        <a href="timeline.html" class="pull-right text-green">My Friend</a>
                                        <h5><a href="#" class="profile-link">Julia Cox</a></h5>
                                        <p>Art Designer</p>
                                    </div>
                                    </div>
                                </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                <div class="friend-card">
                                    <img src="http://placehold.it/1030x360" alt="profile-cover" class="img-responsive cover" />
                                    <div class="card-info">
                                    <img src="http://placehold.it/300x300" alt="user" class="profile-photo-lg" />
                                    <div class="friend-info">
                                        <a href="#" class="pull-right text-green">My Friend</a>
                                        <h5><a href="timelime.html" class="profile-link">Robert Cook</a></h5>
                                        <p>Photographer at Photography</p>
                                    </div>
                                    </div>
                                </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                <div class="friend-card">
                                    <img src="http://placehold.it/1030x360" alt="profile-cover" class="img-responsive cover" />
                                    <div class="card-info">
                                    <img src="http://placehold.it/300x300" alt="user" class="profile-photo-lg" />
                                    <div class="friend-info">
                                        <a href="#" class="pull-right text-green">My Friend</a>
                                        <h5><a href="timeline.html" class="profile-link">Richard Bell</a></h5>
                                        <p>Graphic Designer at Envato</p>
                                    </div>
                                    </div>
                                </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                <div class="friend-card">
                                    <img src="http://placehold.it/1030x360" alt="profile-cover" class="img-responsive cover" />
                                    <div class="card-info">
                                    <img src="http://placehold.it/300x300" alt="user" class="profile-photo-lg" />
                                    <div class="friend-info">
                                        <a href="#" class="pull-right text-green">My Friend</a>
                                        <h5><a href="timeline.html" class="profile-link">Linda Lohan</a></h5>
                                        <p>Software Engineer</p>
                                    </div>
                                    </div>
                                </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                <div class="friend-card">
                                    <img src="http://placehold.it/1030x360" alt="profile-cover" class="img-responsive cover" />
                                    <div class="card-info">
                                    <img src="http://placehold.it/300x300" alt="user" class="profile-photo-lg" />
                                    <div class="friend-info">
                                        <a href="#" class="pull-right text-green">My Friend</a>
                                        <h5><a href="timeline.html" class="profile-link">Anna Young</a></h5>
                                        <p>Musician</p>
                                    </div>
                                    </div>
                                </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                <div class="friend-card">
                                    <img src="http://placehold.it/1030x360" alt="profile-cover" class="img-responsive cover" />
                                    <div class="card-info">
                                    <img src="http://placehold.it/300x300" alt="user" class="profile-photo-lg" />
                                    <div class="friend-info">
                                        <a href="#" class="pull-right text-green">My Friend</a>
                                        <h5><a href="timeline.html" class="profile-link">James Carter</a></h5>
                                        <p>CEO at IT Farm</p>
                                    </div>
                                    </div>
                                </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                <div class="friend-card">
                                    <img src="http://placehold.it/1030x360" alt="profile-cover" class="img-responsive cover" />
                                    <div class="card-info">
                                    <img src="http://placehold.it/300x300" alt="user" class="profile-photo-lg" />
                                    <div class="friend-info">
                                        <a href="#" class="pull-right text-green">My Friend</a>
                                        <h5><a href="timeline.html" class="profile-link">Alexis Clark</a></h5>
                                        <p>Traveler</p>
                                    </div>
                                    </div>
                                </div>
                                </div>
                                </div>
                            </div>
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