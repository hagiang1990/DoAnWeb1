<?php
    require_once 'init.php';
    require_once 'functions.php';
	$isLogin = false;
    $msg = "";
if(isset($_POST["btnLogin"]))
{
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

}
else
{
    if(isset($_POST["FullName"]) && isset($_POST["Phone"]) && isset($_POST["Email"]) &&  isset($_POST["pwd1"]) && isset($_POST["pwd2"])  )
    {
        $FullName =  $_POST["FullName"];
        $Phone = $_POST["Phone"];
        $Email = $_POST["Email"];
        $Pwd =  $_POST["pwd1"];
        $Pwd1 = $_POST["pwd2"];
        if(!empty($FullName) && !empty($Email) && !empty($Pwd))
        {
            if($Pwd == $Pwd1)
            {
                $user  = findUserByEmail($Email);
                if(isset($user)){
                    $newID = register($Phone,$Pwd,$FullName,"noavatar.png",$Email);
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
            
              <!-- Register/Login Tabs-->
              <div class="reg-options">
                <ul class="nav nav-tabs">
                  <li><a href="#register" data-toggle="tab">Đăng ký</a></li>
                  <li  class="active"><a href="#login" data-toggle="tab">Đăng nhập</a></li>
                </ul><!--Tabs End-->
              </div>
              
              <!--Registration Form Contents-->
              <div class="tab-content">
                <div class="tab-pane " id="register">
                  <h3>Đăng ký</h3>
                  <p class="text-muted">Đăng ký tài khoản. Kết nối bạn bè</p>
                  
                  <!--Register Form-->
                  <form action="login.php" method="POST" class="form-inline">
                    <div class="row">
                      <div class="form-group col-xs-6">
                        <label for="FullName" class="sr-only">Họ và tên</label>
                        <input id="FullName" class="form-control input-group-lg" type="text" name="FullName" title="Nhập họ tên" placeholder="Họ và tên"/>
                      </div>
                      <div class="form-group col-xs-6">
                       
                        
                        <label for="Phone" class="sr-only">Số điện thoại</label>
                        <input id="Phone" class="form-control input-group-lg" type="text" name="Phone" title="Số điện thoại" placeholder="Số điện thoại"/>
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group col-xs-12">
                      <label for="Email" class="sr-only">Email</label>
                        <input id="Email" class="form-control input-group-lg" type="text" name="Email" title="Nhập Email" placeholder="Email"/>
                      </div>
                    </div>
                   <!-- <div class="row">
                        <div class="form-group col-xs-12">
                            
                            <div class="input-append date form_datetime">
                                <input size="16" class="form-control input-group-lg" type="text" value="" readonly name="DOB">
                                <span class="add-on"><i class="icon-th"></i></span>
                            </div>
                        </div>
                      
                    
                    </div> -->
                    <div class="row">
                      <div class="form-group col-xs-12">
                        <label for="pwd1" class="sr-only">Mật khẩu</label>
                        <input id="pwd1" class="form-control input-group-lg" type="password" name="pwd1" title="Nhập mật khẩu" placeholder="Nhập mật khẩu"/>
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group col-xs-12">
                        <label for="pwd2" class="sr-only">Nhập lại mật khẩu</label>
                        <input id="pwd2" class="form-control input-group-lg" type="password" name="pwd2" title="Nhập lại mật khẩu" placeholder="Nhập lại mật khẩu"/>
                      </div>
                    </div>
                    
                    <br />
                    <button class="btn btn-primary" name="btnRegister">Đăng ký ngay</button>
                  </form><!--Register Now Form Ends-->
                  
                  
                </div><!--Registration Form Contents Ends-->
                
                <!--Login-->
                <div class="tab-pane active" id="login">
                  <h3>Đăng nhập</h3>
                  <p class="text-muted">Đăng nhập vào tài khoản của bạn</p>
                  <p class="text-muted"><?php echo $msg; ?></p>
                  <!--Login Form-->
                  <form action="login.php" method="POST">
                     <div class="row">
                      <div class="form-group col-xs-12">
                        <label for="username" class="sr-only">Email</label>
                        <input id="username" class="form-control input-group-lg" type="text" name="username" title="Nhập Email" placeholder="Nhập Email"/>
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group col-xs-12">
                        <label for="pwd" class="sr-only">Password</label>
                        <input id="pwd" class="form-control input-group-lg" type="password" name="pwd" title="Nhập mật khẩu" placeholder="Nhập mật khẩu"/>
                      </div>
                    </div>
                    <p><a href="#">Quên mật khẩu</a></p>
                    <button class="btn btn-primary" name="btnLogin">Đăng nhập</button>
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