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
<!-- Landing Page Contents
    ================================================= -->
    
    <div id="lp-register">
    	<div class="container wrapper">
        <div class="row">
        	<div class="col-sm-5">
            <div class="intro-texts">
            	<h1 class="text-white">Kết nối bạn bè !!!</h1>
            	<p>
                    Kết nối bạn bè
                  
                </p>
              
            </div>
          </div>
        	<div class="col-sm-6 col-sm-offset-1">
            <div class="reg-form-container"> 
                <!--Login-->
                <div class="tab-pane active" id="login">
                  <h3>Lấy lại mật khẩu</h3>
                 
                  <p class="text-muted"><?php echo $msg; ?></p>
                  <!--Login Form-->
                  <form action="forgetpass.php" method="POST">
                        <div class="form-group">
                                <label for="txtEmail">Email:</label>
                                <input type="text" class="form-control" id="txtEmail" placeholder="Nhập Email khôi phục" name="txtEmail"  />
                        </div>
                        <p><a href="login.php" >Đăng nhập</a></p>   
                        <button type="submit" class="btn btn-primary">Reset Password</button>
                  </form><!--Login Form Ends--> 
                 
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6 col-sm-offset-6">
          
            <!--Social Icons-->
            <ul class="list-inline social-icons">
              <li><a href="#"><i class="icon ion-social-facebook"></i></a></li>
              <li><a href="#"><i class="icon ion-social-twitter"></i></a></li>
              <li><a href="#"><i class="icon ion-social-googleplus"></i></a></li>
              <li><a href="#"><i class="icon ion-social-pinterest"></i></a></li>
              <li><a href="#"><i class="icon ion-social-linkedin"></i></a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <!--preloader-->
    <div id="spinner-wrapper">
      <div class="spinner"></div>
    </div>

    <!-- Scripts
    ================================================= -->
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.appear.min.js"></script>
	<script src="js/jquery.incremental-counter.js"></script>
    <script src="js/script.js"></script>
    
</body>
</html>