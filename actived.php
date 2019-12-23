<?php
    require_once 'init.php';
    require_once 'functions.php';
    $isActived = false ;
    $msg = "";
    if(isset($_GET["code"]) && isset($_GET["email"]))
    {
        $code =  $_GET["code"];
        
        $Email = $_GET["email"];
      
        if(!empty($code) && !empty($Email))
        { 
            $user  = findUserByEmail($Email);
            if(isset($user)){
                $isActived = ActivedUser($Email,$code);
                if($isActived)
                    $msg = "Kich hoạt thành công. Hãy click vào <a href='login.php'>đây</a> để đăng nhập";
                else
                    $msg = "Kích hoạt thất bại";
            }
            else
                $msg = "Email không tồn tại!";
        }
        else
            $msg = "Không thể kích hoạt!.";
    }
    
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php require_once("header.php") ?>
    </head>
<body>
<div class="row">
                <div class="col-md-12">
                    <div class="container bg-light">	
                        <?php if(!empty($msg) ):?>
                            <h2 class="text-success text-center"> <?php echo $msg;?>  </h2>
                        <?php endif;?>
                        
                    </div>
                </div>
            </div>
    <?php require_once("footer.php") ?>
</body>
</html>