<?php
    require_once 'init.php';
    require_once 'functions.php';
    $isRegister = false ;
    $msg = "";
    if(isset($_POST["FullName"]) && isset($_POST["UserName"]) && isset($_POST["Email"]) &&  isset($_POST["pwd1"]) && isset($_POST["pwd2"])  )
    {
        $FullName =  $_POST["FullName"];
        $UserName = $_POST["UserName"];
        $Email = $_POST["Email"];
        $Pwd =  $_POST["pwd1"];
        $Pwd1 = $_POST["pwd2"];
        if(!empty($FullName) && !empty($UserName) && !empty($Email) && !empty($Pwd))
        {
            if($Pwd == $Pwd1)
            {
                $user  = findUserByEmail($Email);
                if(isset($user)){
                    $newID = register($UserName,$Pwd,$FullName,"noavatar.png",$Email);
                    if($newID > 0)
                        $isRegister = true;
                }
                else
                    $msg = "Email đã tồn tại!";
               
            }
            else
                $msg = "Nhập lại mật khẩu không trùng khớp!";
           

        }
        else
            $msg = "Không để trống thông tin!.";
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
                    <?php if($isRegister) : ?>
                        <h2 class="text-center">Đăng ký thành công. Hãy kiểm tra email để kích hoạt tài khoản.</h2>
                    <?php elseif(!empty($msg) ):?>
                        <h2 class="text-danger text-center"> <?php echo $msg;?>  </h2>
                    <?php endif;?>
                    <h2 style="font-family:Georgia">Đăng Ký</h2>
                    <form action="register.php" method="POST">
                        <div class="form-group">
                            <label for="FullName">
                                <strong>FullName</strong>
                            </label>
                            <input type="text" class="form-control" id="FullName" placeholder="Nhập FullName" name="FullName" />
                        </div>
                        <div class="form-group">
                            <label for="Email">
                                <strong>Email</strong>
                            </label>
                            <input type="text" class="form-control" id="Email" placeholder="Nhập Email" name="Email" />
                        </div>
                        <div class="form-group">
                            <label for="UserName">
                                <strong>UserName</strong>
                            </label>
                            <input type="text" class="form-control" id="UserName" placeholder="Nhập UserName" name="UserName" />
                        </div>
                        <div class="form-group">
                            <label for="pwd1">
                                <strong>Password</strong>
                            </label>
                            <input type="password" class="form-control" id="pwd1" placeholder="Nhập PassWord" name="pwd1" />
                        </div>
                        <div class="form-group">
                            <label for="pwd2">
                                <strong>Nhập lại Password</strong>
                            </label>
                            <input type="password" class="form-control" id="pwd2" placeholder="Nhập lại Password" name="pwd2" />
                        </div>
                        <button type="Submit" class="btn btn-success">
                            <b>Đăng ký</b>
                        </button>
                        
                    </form>
                </div>
            </div>
        </div><!--//main-body-->
    </div>
    <?php require_once("footer.php") ?>
</body>
</html>