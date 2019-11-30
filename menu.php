<div class="sidebar-wrapper">
    <div class="profile-container">
        <a href="index.php"><i class="fas fa-2x fa-home"></i> Trang chủ</a>
        <br />
        <br />
        <?php if(!empty($_SESSION["USERID"])) :?>
               
                <img class="profile img img-responsive img-thumbnail" width="200" height="200" src="img/<?php echo $currentUser["UrlImage"]; ?>" alt="<?php echo $currentUser["FullName"]; ?>" />
                <h1 class="name"><?php echo $currentUser["FullName"]; ?></h1>
                <h3 class="tagline"><?php echo $currentUser["Email"]; ?></h3>
                <br />
                <button onclick="location.href='logout.php'" type="button" class="btn btn-default"><i class="fas sign-out-alt"></i> Đăng Xuất</button>
        <?php else:?>  
            <button onclick="location.href='login.php'" type="button" id="btnLogin" class="btn btn-default"><i class="fas sign-in-alt"></i> Đăng nhập</button>
            <br />
            <br />
            <button  type="button" id="btnRegister" class="btn btn-default" onclick="location.href='register.php'"><i class="fas fa-key"></i> Đăng ký</button>
        <?php endif;?>	
    </div><!--//profile-container--> 
    <?php if(!empty($_SESSION["USERID"])) :?>
        <div class="contact-container container-block">
            <ul class="list-unstyled contact-list">
                <li class="email"><i class="fas fa-edit"></i><a href="info.php">Chỉnh sửa thông tin</a></li>
                <li class="website"><i class="fas fa-globe"></i><a href="newfeed.php" target="_blank">Đăng bài</a></li>
            </ul>
        </div><!--//contact-container"-->
     <?php endif;?>	
        
         <div class="carousel slide education-container container-block text-center"  data-ride="carousel">
                <h2 class="container-block-title">Hình ảnh</h2>
                 <!-- The slideshow -->
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img class="img img-thumbnail" src="img/background.jpg" alt="" height="150" width="100%">
                    </div>
                    <div class="carousel-item">
                        <img class="img img-thumbnail" src="img/hagiang1.jpg" alt="" height="150" width="100%" >
                    </div>

                </div>
            </div>
            
           <!-- <div class="languages-container container-block">
                <h2 class="container-block-title">Languages</h2>
                <ul class="list-unstyled interests-list">
                    <li>English <span class="lang-desc">(Native)</span></li>
                    <li>French <span class="lang-desc">(Professional)</span></li>
                    <li>Spanish <span class="lang-desc">(Professional)</span></li>
                </ul>
            </div>
            
            <div class="interests-container container-block">
                <h2 class="container-block-title">Interests</h2>
                <ul class="list-unstyled interests-list">
                    <li>Climbing</li>
                    <li>Snowboarding</li>
                    <li>Cooking</li>
                </ul>
            </div> -->
            
</div><!--//sidebar-wrapper-->
