<?php
    require_once 'init.php';
    require_once 'functions.php';
    $msg = "";
    $errors= false;
    $newname = "";
    $UserID = $currentUser["UserID"];
    $CountFriend = GetCountFriend($UserID);
   
    if(isset($_POST["btnSave"]))
    {
        // lấy tên file upload
        $image=$_FILES['fImage']['name'];
        // Nếu nó không rỗng
        if ($image)
        {
            $filename = stripslashes($_FILES['fImage']['name']);
            //Lấy phần mở rộng của file
            $extension = getExtension($filename);
            $extension = strtolower($extension);
            if (($extension != "jpg") && ($extension != "jpeg") && ($extension !="png") && ($extension != "gif"))
                {
                // xuất lỗi ra màn hình
                $msg =  '<h1>File Hình Ảnh không đúng định dạng!</h1>';
                $errors=true;
                }
                else
                {
                    // đặt tên mới cho file hình up lên
                    $image_name=time().'.'.$extension;
                    // gán thêm cho file này đường dẫn
                    $newname= $image_name;
                    // kiểm tra xem file hình này đã upload lên trước đó chưa
                    $copied = move_uploaded_file($_FILES['fImage']['tmp_name'],"img/".$newname);
                }
        }
        // Update thông tin cá nhân
        $FullName = $_POST["FullName"];
        $Email = $_POST["Email"];
        $Phone = $_POST["Phone"];
        if(!empty($newname))
        {
            $errors = UpdateUser1($currentUser["UserID"],$FullName,$Email,$newname,$Phone);
        }
        else
        {

            $errors = UpdateUser($currentUser["UserID"],$FullName,$Email,$Phone);
        }
        if($errors)
        {
            $msg = "Cập nhập thông tin thành công";
            header('Location: info.php');
        }
        else
        {
            $msg = "Cập nhập thông tin thất bại";
        }

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
                  <li><a href="timeline.php?u=<?php echo $UserID?>">Dòng thời gian</a></li>
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
              	<li class="active"><i class="icon ion-ios-information-outline"></i><a href="edit-profile-basic.html">Thông tin cá nhân</a></li>
              <!--	<li><i class="icon ion-ios-briefcase-outline"></i><a href="edit-profile-work-edu.html">Education and Work</a></li>
              	<li><i class="icon ion-ios-heart-outline"></i><a href="edit-profile-interests.html">My Interests</a></li>
                <li><i class="icon ion-ios-settings"></i><a href="edit-profile-settings.html">Account Settings</a></li>-->
              	<li><i class="icon ion-ios-locked-outline"></i><a href="changepass.php">Đổi mật khẩu</a></li>
              </ul>
            </div>
            <div class="col-md-7">

              <!-- Basic Information
              ================================================= -->
              <div class="edit-profile-container">
                <div class="block-title">
                  <h4 class="grey"><i class="icon ion-android-checkmark-circle"></i>Thông tin cá nhân</h4>
                  <div class="line"></div>
                  
                </div>
                <div class="edit-block">
                    <div class="row">
                        <div class="col-md-12">
                           
                            <?php if(!empty($msg) ):?>
                                <h2 class="text-danger text-center"> <?php echo $msg;?>  </h2>
                            <?php endif;?>
                            <h2 style="font-family:Georgia"></h2>
                            <form action="info.php" method="POST" enctype="multipart/form-data">
                                <div class="form-group text-center">
                                
                                    <img class="profile img img-responsive img-thumbnail" width="200" height="200" src="img/<?php echo $currentUser["ImageUrl"]; ?>" alt="<?php echo $currentUser["FullName"]; ?>" />
                                
                                    <input type="file" class="form-control"  id="fImage" placeholder="Nhập FullName" name="fImage" value="<?php echo $currentUser["FullName"]?>" />
                                    
                                </div>
                                <div class="form-group">
                                    <label for="FullName">
                                        <strong>Họ và tên</strong>
                                    </label>
                                    <input type="text" class="form-control" id="FullName" placeholder="Nhập FullName" name="FullName" value="<?php echo $currentUser["FullName"]?>" />
                                </div>
                                <div class="form-group">
                                    <label for="Email">
                                        <strong>Email</strong>
                                    </label>
                                    <input type="text" class="form-control" id="Email" placeholder="Nhập Email" name="Email" value="<?php echo $currentUser["Email"]?>"  />
                                </div>
                                <div class="form-group">
                                    <label for="Phone">
                                        <strong>Số điện thoại</strong>
                                    </label>
                                    <input type="text" class="form-control" id="Phone" placeholder="Nhập số điện thoại" name="Phone" value="<?php echo $currentUser["Phone"]?>"  />
                                </div>
                                
                                <button type="Submit" class="btn btn-primary" name="btnSave">
                                    <b>Lưu</b>
                                </button>
                                
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