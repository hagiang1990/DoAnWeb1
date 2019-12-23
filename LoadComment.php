<?php 
    require_once 'init.php';
    require_once 'functions.php';
    $CommentID = $_GET["id"];
    $c = GetCommentByID($CommentID);
    
?>

<?php if(isset($c)) {?>
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