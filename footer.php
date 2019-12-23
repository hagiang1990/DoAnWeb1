 <!-- Footer
    ================================================= -->
    <footer id="footer">
      <div class="container">
      	<div class="row">
          <div class="footer-wrapper">
            <div class="col-md-2 col-sm-2">
              
              <ul class="list-inline social-icons">
              	<li><a href="#"><i class="icon ion-social-facebook"></i></a></li>
              	<li><a href="#"><i class="icon ion-social-twitter"></i></a></li>
              	<li><a href="#"><i class="icon ion-social-googleplus"></i></a></li>
              
              </ul>
            </div>
           
            <div class="col-md-5 col-sm-5">
              <h5>Thông tin trang</h5>
              <p>



              </p>
            </div>
            <div class="col-md-5 col-sm-5">
              <h5>Liên hệ</h5>
              <ul class="contact">
                <li><i class="icon ion-ios-telephone-outline"></i>090000000</li>
                <li><i class="icon ion-ios-email-outline"></i>info@abc.com</li>
                <li><i class="icon ion-ios-location-outline"></i>227 Nguyễn Văn Cừ,Quận 5, TP HCM</li>
              </ul>
            </div>
          </div>
      	</div>
      </div>
      <div class="copyright">
        <p>Copyright @Lê Hà Giang</p>
      </div>
		</footer>
    
    <!--preloader-->
    <div id="spinner-wrapper">
      <div class="spinner"></div>
    </div>
    
    <!-- Scripts
    ================================================= -->
  
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.sticky-kit.min.js"></script>
    <script src="js/jquery.scrollbar.min.js"></script>
    <script src="js/script.js"></script>
    <script src="js/bootstrap-datetimepicker.min.js"></script>
    <script src="js/bootstrap-notify.min.js"></script>
    <script type="text/javascript">
        $(".form_datetime").datetimepicker({
                format: "dd MM yyyy"
        });
        function Notify(title,msg,type,icon)
        {
          $.notify({
            // options
            message: msg,
            icon: icon,
	          title: title,
          },{
            // settings
            type: type,
            delay: 3000,
	          timer: 2000,
            animate: {
              enter: 'animated fadeInDown',
              exit: 'animated fadeOutUp'
            },
          });

        }
    </script> 