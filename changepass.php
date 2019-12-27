<?php
    require_once 'init.php';
    require_once 'functions.php';
    $msg = "";
    $UserID = $currentUser["UserID"];
    $CountFriend = GetCountFriend($UserID);
    if(isset($_POST["oldPwd"]) && isset($_POST["newPwd"]))
    {
        $oldPwd = $_POST["oldPwd"];
        $newPwd = $_POST["newPwd"];
        if($oldPwd == $currentUser["Pwd"])
        {
            $isDone = change_password($newPwd,$currentUser["UserID"]);
            if($isDone)
                $msg = "Đổi mật khẩu thành công.";
            else
                $msg = "Đổi mật khẩu thất bại.";
        }
        else
            $msg = "Mật khẩu cũ không đúng.";
        
    }
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
                  <img src="img/<?php echo $currentUser["ImageUrl"]?>" alt="" class="img-responsive profile-photo" />
                  <h3><?php echo $currentUser["FullName"] ?></h3>
                  <p class="text-muted"><?php echo $currentUser["Phone"]; ?></p>
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
                  <!--<li><button class="btn-primary">Add Friend</button></li>-->
                </ul>
              </div>
            </div>
          </div><!--Timeline Menu for Large Screens End-->

          <!--Timeline Menu for Small Screens-->
          <div class="navbar-mobile hidden-lg hidden-md">
            <div class="profile-info">
              <img src="img/<?php echo $currentUser["ImageUrl"]?>" alt="" class="img-responsive profile-photo" />
              <h4><?php echo $currentUser["FullName"] ?></h4>
              <!--<p class="text-muted"><?php echo $currentUser["Email"]; ?></p>-->
            </div>
            <div class="mobile-menu">
              <ul class="list-inline">
                <li><a href="timeline.php">Dòng thời gian</a></li>
                <li><a href="info.php" class="active">Thông tin</a></li>
                 
                <li><a href="friends.php">Bạn bè</a></li>
              </ul>
              <<!--button class="btn-primary">Add Friend</button>-->
            </div>
          </div><!--Timeline Menu for Small Screens End-->

        </div>
        <div id="page-contents">
          <div class="row">
            <div class="col-md-3">
              
              <!--Edit Profile Menu-->
              <ul class="edit-menu">
              	<li ><i class="icon ion-ios-information-outline"></i><a href="edit-profile-basic.html">Thông tin cá nhân</a></li>
              <!--	<li><i class="icon ion-ios-briefcase-outline"></i><a href="edit-profile-work-edu.html">Education and Work</a></li>
              	<li><i class="icon ion-ios-heart-outline"></i><a href="edit-profile-interests.html">My Interests</a></li>
                <li><i class="icon ion-ios-settings"></i><a href="edit-profile-settings.html">Account Settings</a></li>-->
              	<li class="active"><i class="icon ion-ios-locked-outline"></i><a href="edit-profile-password.html">Đổi mật khẩu</a></li>
              </ul>
            </div>
            <div class="col-md-7">

              <!-- Basic Information
              ================================================= -->
              <div class="edit-profile-container">
                <div class="block-title">
                  <h4 class="grey"><i class="icon ion-android-checkmark-circle"></i>Đổi mật khẩu</h4>
                  <div class="line"></div>
                  
                </div>
                <div class="edit-block">
                    <div class="row">
                        <div class="col-md-12">
                           
                            <?php if(!empty($msg) ):?>
                                <h2 class="text-danger text-center"> <?php echo $msg;?>  </h2>
                            <?php endif;?>
                            <h2 style="font-family:Georgia"></h2>
                            <form  action="changepass.php" method="POST" class="form-inline">
                                <div class="row">
                                    <div class="form-group col-xs-12">
                                        <label for="oldPwd">Mật khẩu cũ</label>
                                        <input id="oldPwd" class="form-control input-group-lg" type="password" name="oldPwd" title="Mật Khẩu cũ" placeholder="Mật Khẩu cũ">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-xs-12">
                                        <label>Mật khẩu mới</label>
                                        <input class="form-control input-group-lg" type="password" name="newPwd" id="newPwd" title="Mật khẩu mới" placeholder="Mật khẩu mới">
                                    </div>
                                </div>
                                <button class="btn btn-primary">Đổi mật khẩu</button>
                            </form>
                        </div>
                    </div>
                </div>
              </div>
            </div>
            <?php require_once("Notify.php") ?>
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