<?php
     require_once 'init.php';
     require_once 'functions.php';
     $UserID = $currentUser["UserID"];
     $listNewFeed = array();
     $pageNum = intVal($_GET["pagenum"]);
     $listNewFeed  = LoadNewFeed($UserID,$pageNum,5);
?>
    <?php foreach($listNewFeed as $item) { ?>
        <div class="post-content" data-id="<?php echo $item["NewFeedID"]?>">
            <?php if($UserID == $item["CreatedUser"]){?>
                <button onclick="DeleteNewFeed(<?php echo $item["NewFeedID"];?>)" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            <?php }?>
            <div class="post-container">
                
                <img src="img/<?php echo $item["UserImage"]?>" alt="user" class="profile-photo-md pull-left" />
                <div class="post-detail">
                    <div class="user-info">
                        <h5><a href="timeline.html" class="profile-link"><?php echo $item["FullName"]?></a> </h5>

                        <p class="text-muted">
                            <?php echo date_format(date_create($item["CreatedDate"]),"d/m/Y H:i:s");?>
                                <?php if (intVal($item["IsPrivate"]) == 0 ) {?>
                                    <a href="#" style="font-family: fontAwesome">&#xf0ac;</a>
                                    <?php }?>
                                        <?php if (intVal($item["IsPrivate"]) == 1 ) {?>
                                            <a href="#" style="font-family: fontAwesome">&#xf0c0;</a>
                                            <?php }?>
                                                <?php if (intVal($item["IsPrivate"]) == -1 ) {?>
                                                    <a href="#" style="font-family: fontAwesome">&#xf084;</a>
                                                    <?php }?>
                        </p>

                    </div>

                    <div class="line-divider"></div>
                    <?php if(isset($item["UrlImage"]) && !empty($item["UrlImage"] )){?>
                        <img src="img/<?php echo $item["UrlImage"]; ?>" alt="post-image" class="img-responsive post-image" />
                        <?php }?>

                            <div class="post-text">
                                <p>
                                    <?php echo $item["NewFeedContent"]?>
                                </p>
                            </div>
                            <div class="reaction">
                                <?php 
                                                $isLike = CheckLike($UserID,$item["NewFeedID"]);
                                           ?>
                                    <a data-idNewFeed="<?php echo $item["NewFeedID"] ?>" onclick="AddLike(<?php echo $UserID ?>,<?php echo $item["NewFeedID"] ?>,<?php echo (intVal($isLike["NumLike"]) > 0 ? "true":"false")?>)" class="btn <?php if(intVal($isLike["NumLike"]) >0){ echo "text-blue isLike";}else{echo  "text-muted";} ?>" data-num="<?php echo $item["NumLike"];?>">
                                        <i class="icon ion-thumbsup"></i> <span data-idNewFeed="<?php echo $item["NewFeedID"] ?>"> <?php echo $item["NumLike"];?> </span>
                                    </a>

                            </div>
                            <div class="line-divider"></div>
                            <?php 
                              
                                $ListComment = array();
                                $ListComment = GetCommentByNewFeed(intVal($item["NewFeedID"]));
                               
                            ?>
                            <?php foreach($ListComment as $c) {?>
                                <div class="post-comment" data-id="<?php echo $c["CommentID"] ?>">
                                    <img src="img/<?php echo $c["ImageUrl"]?>" alt="<?php echo $c["FullName"]?>" class="profile-photo-sm" />
                                    <p>
                                        <span class="text-muted">
                                            <?php echo date_format(date_create($c["CreatedDate"]),"d/m/Y H:i:s");?>
                                        </span>

                                        <br />
                                        <?php echo $c["CommentContent"]; ?>
                                       
                                    </p>

                                </div>
                                <div class="line-divider"></div>
                            <?php }?>
                            <div class="post-comment" data-idNewFeed="<?php echo $item["NewFeedID"] ?>">
                                <img src="img/<?php echo $currentUser["ImageUrl"]?>" alt="" class="profile-photo-sm" />
                                <div class="input-group" style="width:100%">
                                    <input type="text" class="form-control" data-id="<?php echo $item["NewFeedID"] ?>" onkeydown="" placeholder="Bình luận">
                                    <div class="input-group-btn">
                                        <button class="btn btn-default" onclick="AddComment(<?php echo $item["NewFeedID"] ?>,<?php echo $UserID ?>)">
                                            <i class="glyphicon glyphicon-share"></i>
                                        </button>
                                    </div>

                                </div>
                            </div>
                </div>
            </div>
        </div>
        <?php } ?>