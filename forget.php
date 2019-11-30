<?php
    require_once 'init.php';
    require_once 'functions.php';
	$isLogin = false;
	$msg = "";
if(isset($_POST["txtEmail"]))
{
	$isDone=ResetPassword($_POST["txtEmail"]);
	if($isDone)
		$msg = "Reset password thành công. Bạn hãy kiểm tra email.";
	else
		$msg = "Reset password thất bại. Bạn hãy kiểm tra lại email đăng ký.";
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
                <div class="container bg-light">	
                        <?php if(!empty($msg) ):?>
                            <h2 class="text-danger text-center"> <?php echo $msg;?>  </h2>
                        <?php endif;?>
                    <h2>Lấy lại mật khầu</h2>
                    <form action="forget.php" method="POST">
                            <div class="form-group">
                                <label for="txtEmail">Email:</label>
                                <input type="text" class="form-control" id="txtEmail" placeholder="Nhập Email khôi phục" name="txtEmail"  />
                            </div>
                            
                            <button type="submit" class="btn btn-primary">Reset Password</button>
                        </form>
                </div>
                
                    
                </div>
            </div>
        </div><!--//main-body-->
    </div>
    <?php require_once("footer.php") ?>
</body>
</html>