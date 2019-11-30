<?php
    require_once 'init.php';
    require_once 'functions.php';
	$isLogin = false;
	$msg = "";
if(isset($_POST["username"]) && isset($_POST["pwd"]))
{
	$user=login($_POST["username"],$_POST["pwd"]);
    if($user){
       if((boolean)$user["IsActived"])
       {
            $_SESSION['USERID']=$user['UserID'];
            $_SESSION["FULLNAME"] = $user['FullName'];
            $isLogin = true;
            header('Location: index.php');
       }
       else
        $msg = "Tài khoản chưa được kích hoạt. Bạn hãy kiểm tra email.";
       
        
	}	
	else
		$msg = "Tài khoản hoặc mật khẩu không đúng";			
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
                        <h2>Đăng nhập</h2>
                        <form action="login.php" method="POST">
                                <div class="form-group">
                                    <label for="username">User name:</label>
                                    <input type="text" class="form-control" id="username" placeholder="Nhập username" name="username"  />
                                </div>
                                <div class="form-group">
                                    <label for="pwd">Password:</label>
                                    <input type="password" class="form-control" id="pwd" placeholder="Enter mật khẩu" name="pwd" />
                                </div>
                                <div class="form-group form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" name="remember" /> Ghi nhớ
                                    </label>
                                    |
                                    <label class="form-check-label">
                                        <a href="forget.php" >Quên mật khẩu </a>
                                    </label>
                                </div>
                                <button type="submit" class="btn btn-primary">Đăng nhập</button>
                        </form>
                    </div>
                </div>
            </div>
        </div><!--//main-body-->
    </div>
    <?php require_once("footer.php") ?>
</body>
</html>