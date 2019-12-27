<?php
    require_once 'init.php';
    require_once 'functions.php';
    $UserID = $currentUser["UserID"];
    $listNotify = array();
    $listNotify = GetNotifyByUser($UserID);
?>
<div class="col-md-2 static">
    <div class="suggestions" id="sticky-sidebar">
        <h4 class="grey">Hoạt động gần đây</h4>
        <?php foreach ($listNotify as $item) { ?>
            <div class="feed-item">
                <div class="live-activity">
                    <p><a href="#" class="profile-link"><?php echo $item["FullName"] ?></a> 
                        vừa mới
                        <?php echo $item["ShortDescription"]; ?>
                    </p>
                    <p class="text-muted"><?php echo date_format(date_create($item["CreatedDate"]),"d/m/Y H:i:s");?></p>
                    <?php if(intVal($item["NotificationType"]) == 0){?>
                        <div class="btn-group mr-2" role="group" aria-label="Basic example">
                                <button type="button" class="btn  btn-info" id="btnAccept" onclick="AcceptFriend(<?php echo $item["NotificationID"] ?>,<?php echo $item["ToUserID"] ?>,<?php echo $item["FromUserID"] ?>)"><i class="glyphicon glyphicon-ok-circle"></i></button>
                                <button type="button" class="btn btn-danger" id="btnNotAccept" onclick="UnAcceptFriend(<?php echo $item["NotificationID"] ?>,<?php echo $item["ToUserID"] ?>,<?php echo $item["FromUserID"] ?>)" ><i class="glyphicon glyphicon-remove-circle"></i></button>
                                                    
                        </div>
                        
                    <?php }?>
                </div>
            </div>
        <?php }?>                                
    </div>
</div>
<script>
function AcceptFriend(ID,UserID,FriendID)
                    {
                        $.ajax({
                            url: 'newfeeds.php',
                            data: {"ID":ID,"UserID": UserID,"FriendID":FriendID,"Method":"ACCEPTF"},
                            type: 'POST',
                            success: function(data)
                            {
                                 
                                 //if(data)
                                 //{
                                   //Notify("Thông báo: ","<strong>Gửi lời mời thành công</strong>","info","glyphicon glyphicon-bullhorn")
                                    location.reload();
                                 //}
                                 //else
                                 //   Notify("Thông báo: ","<strong>Gửi lời mời thất bại</strong>","info","glyphicon glyphicon-bullhorn")
                            },
                            error: function() {
                                Notify("Thông báo: ","<strong>Bạn không xóa bản tin này</strong>","info","glyphicon glyphicon-bullhorn")
                            }
                        });
                    }
</script>