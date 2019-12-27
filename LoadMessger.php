<?php
       require_once 'init.php';
       require_once 'functions.php';
       $UserID = $currentUser["UserID"];
       $id = $_GET["ID"];
       $ListContent = LoadMessgerDetail($id)
?>
<div class="tab-pane active" id="contact-1">
    <div class="chat-body">
        <ul class="chat-message">
        <?php foreach($ListContent as $item){?>
                      
                      		<li class="<?php echo ($UserID != $item["UserID"] ? "right": "left" ) ?>">
                      			<img src="img/<?php echo $item["ImageUrl"]; ?>" alt="" class="profile-photo-sm <?php echo ($UserID != $item["UserID"] ? "pull-right": "pull-left" ) ?> " />
                      			<div class="chat-item">
                                    <div class="chat-item-header">
                                        <h5><?php echo $item["FullName"]; ?></h5>
                                        <small class="text-muted"><?php echo date_format(date_create($item["CreatedDate"]),"d/m/Y H:i:s");?></small>
                                    </div>
                                    <p>
                                        <?php echo $item["Content"]; ?>
                                    </p>
                                </div>
                      		</li>
                         
                      
        <?php  }?>
        </ul>
    </div>
</div>