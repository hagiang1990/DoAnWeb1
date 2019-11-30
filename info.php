<?php
    require_once 'init.php';
    require_once 'functions.php';
    $msg = "";
    $errors= false;
    $newname = "";
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

        if(!empty($newname))
        {
            $errors = UpdateUser1($currentUser["UserID"],$FullName,$Email,$newname);
        }
        else
        {

            $errors = UpdateUser($currentUser["UserID"],$FullName,$Email);
        }
        if($errors)
        {
            $msg = "Cập nhập thông tin thành công";
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
<div class="wrapper">
        
        <?php include("menu.php") ?>
        <div class="main-wrapper">
            <div class="row">
                <div class="col-md-12">
                    <?php if($errors == 0) : ?>
                        <h2 class="text-center">Đổi thông tin thành công.</h2>
                    <?php elseif(!empty($msg) ):?>
                        <h2 class="text-danger text-center"> <?php echo $msg;?>  </h2>
                    <?php endif;?>
                    <h2 style="font-family:Georgia">Thông tin cá nhân</h2>
                    <form action="info.php" method="POST" enctype="multipart/form-data">
                        <div class="form-group text-center">
                           
                            <img class="profile img img-responsive img-thumbnail" width="200" height="200" src="img/<?php echo $currentUser["UrlImage"]; ?>" alt="<?php echo $currentUser["FullName"]; ?>" />
                           
                            <input type="file" class="form-control"  id="fImage" placeholder="Nhập FullName" name="fImage" value="<?php echo $currentUser["FullName"]?>" />
                            
                        </div>
                        <div class="form-group">
                            <label for="FullName">
                                <strong>FullName</strong>
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
                            <label for="UserName">
                                <strong>UserName</strong>
                            </label>
                            <input type="text" disable readonly class="form-control" id="UserName" placeholder="Nhập UserName" name="UserName" value="<?php echo $currentUser["UserName"]?>"  />
                        </div>
                        
                        <button type="Submit" class="btn btn-success" name="btnSave">
                            <b>Lưu</b>
                        </button>
                        
                    </form>
                </div>
            </div>
        </div><!--//main-body-->
    </div>
    <?php require_once("footer.php") ?>
</body>
</html>