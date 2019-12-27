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
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-primary">Đồng ý</button>
                            <button type="button" class="btn btn-secondary">Từ chối</button>
                                                  
                        </div>
                    <?php }?>
                </div>
            </div>
        <?php }?>                                
    </div>
</div>