<?php
    require_once 'init.php';
    require_once 'functions.php';
    $function =$_POST["Method"];
    if($function == "ADD")
    {
        $msg = "";
        $errors= false;
        $newname = "";
      
        // Nếu nó không rỗng
        if (isset($_FILES['fImage']) && $_FILES['fImage']["error"] == 0)
        {
            // lấy tên file upload
            $image=$_FILES['fImage']['name'];
            $filename = stripslashes($_FILES['fImage']['name']);
            //Lấy phần mở rộng của file
            $extension = getExtension($filename);
            $extension = strtolower($extension);
            if (($extension != "jpg") && ($extension != "jpeg") && ($extension !="png") && ($extension != "gif"))
                {
                // xuất lỗi ra màn hình
                $msg =  '<h1>File Hình Ảnh không đúng định dạng!</h1>';
                $errors=true;
                }
                else
                {
                    // đặt tên mới cho file hình up lên
                    $image_name=time().'.'.$extension;
                    // gán thêm cho file này đường dẫn
                    $newname= $image_name;
                    // kiểm tra xem file hình này đã upload lên trước đó chưa
                    $copied = move_uploaded_file($_FILES['fImage']['tmp_name'],"img/".$newname);
                }
        }
        $NewFeedContent = $_POST["NewFeedContent"];
        $NewFeedType = intval($_POST["NewFeedType"]);
        $UserID = $_POST["UserID"];
        $result = Add($UserID,$NewFeedContent,$newname,$NewFeedType);
        echo json_encode($result); 
        
    }
    if($function == "LIKE")
    {
        $UserID = $_POST["UserID"];
        $NewFeedID = $_POST["NewFeedID"];
        echo json_encode(Like($NewFeedID,$UserID));
    }
    if($function == "DEL")
    {
        $NewFeedID = $_POST["NewFeedID"];
        $result = Del($NewFeedID);
        echo $result;
    }
    if($function == "CM")
    {
        $NewFeedID = $_POST["NewFeedID"];
        $UserID = $_POST["UserID"];
        $CommentContent = $_POST["CommentContent"];
        $result = AddComment($NewFeedID, $UserID, $CommentContent);
        echo $result;
    }
    if($function == "AF")
    {
        $UserID = $_POST["UserID"];
        $FriendID = $_POST["FriendID"];
        $result =AddFriend($UserID, $FriendID);
        return $result;
    }
    if($function == "ACCEPTF")
    {
        $UserID = $_POST["UserID"];
        $FriendID = $_POST["FriendID"];
        $NotificationID = $_POST["ID"];
        $result =AcceptFriend($NotificationID,$UserID, $FriendID);
        return $result;
    }
    if($function == "ADDMSGD")
    {
        $UserID = $_POST["UserID"];
        $Content = $_POST["Content"];
        $MsgID = $_POST["ID"];
        $newID = AddMsgDetail($UserID,$MsgID,$Content);
        return $newID;
    }



    function Add($UserID,$content, $ImageUrl,$NewFeedType)
    {
        $result = AddNewFeed($UserID, $content, $ImageUrl,$NewFeedType);
        return $result;
    }

    function Like($NewFeedID,$UserID)
    {
        return AddLike($NewFeedID,$UserID);
    }
    
    function Del($NewFeedID)
    {
        return DelNewFeed($NewFeedID);
    }

    
   

?>