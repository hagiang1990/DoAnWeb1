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
                  <p class="text-muted"><?php echo $pUser["Phone"]; ?></p>
                </div>
              </div>
              <div class="col-md-9">
                <ul class="list-inline profile-menu">
                  <li><a href="timeline.php" class="active" >Dòng thời gian</a></li>
                 
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
                    <li><button class="btn-primary" id="btnAddFriend">Kết bạn</button></li>
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
</body>
</html>