<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'module/phpmailer/Exception.php';
require 'module/phpmailer/PHPMailer.php';
require 'module/phpmailer/SMTP.php';

$EMAIL_FROM     = 'zenkiben@gmail.com';
$EMAIL_NAME     = 'Admin';
$EMAIL_PASSWORD = 'trungtan1991,./';
$vHost = "http://localhost/doanweb1/";

function login($username,$pwd)
{
	global $db;
    $stmt=$db->prepare("SELECT * FROM users WHERE Email  = ? AND Pwd = ?");
    $stmt->execute(array($username,$pwd));
    return  $stmt->fetch(PDO::FETCH_ASSOC);
}
function findUserById($id)
{
    global $db;
    $stmt=$db->prepare("SELECT * FROM users WHERE UserID  = ?");
    $stmt->execute(array($id));
    return  $stmt->fetch(PDO::FETCH_ASSOC);
}
function findUserByEmail($email)
{
    global $db;
    $stmt=$db->prepare("SELECT * FROM Users WHERE Email  = ?");
    $stmt->execute(array($email));
    return  $stmt->fetch(PDO::FETCH_ASSOC);
}
function ResetPassword($email)
{
    $user = findUserByEmail($email);
    if(isset($user))
    {
        $newPass = generateRandomString();
        change_password($newPass,$user["UserID"]);
        sendEmail($email,$user["FullName"],'Reset mật khẩu','Mật khẩu mới của bạn là: <strong>' .$newPass .'</strong> ');
        return true;
    }
    return false;

}
function ActivedUser($email,$code)
{
    $user = findUserByEmail($email);
    if(isset($user))
    {
        if($user["ActivedCode"] == $code)
        {
            global $db;
            $stmt=$db->prepare("UPDATE users SET IsActived = 1 WHERE UserID=? " );
            $stmt->execute(array($user["UserID"]));
            return true;
        }
        else
            return false;
        
    }
    return false;

}
function getPage()
{
    $uri=$_SERVER['REQUEST_URI'];
    $parts=explode('/',$uri);
    $fileName=$parts[2];
    $parts=explode('.',$fileName);
    $page=$parts[0];
    return $page;
}
function register($Phone,$Pwd,$FullName,$UrlImage,$Email)
{
    global $db;
    $code = generateRandomString(5);
    $stmt=$db->prepare("INSERT INTO users (FullName,Pwd,Phone,ImageUrl,Email,IsActived,ActivedCode) VALUES(?,?,?,?,?,?,?)");
    $stmt->execute(array($FullName,$Pwd,$Phone,$UrlImage,$Email,"false",$code));
    sendEmail($Email,$FullName,'Kích hoạt tài khoản','Click vào: <strong><a href="http://localhost/doanweb1/'  .'actived.php?code=' .$code .'&email=' .$Email .'"> đây </a> để kích hoạt</strong> ');
    return $newUserId=$db->lastInsertId();
}
function change_password($newPassword,$id)
{
    global $db;
    $hashPassword=$newPassword;
    $stmt=$db->prepare("UPDATE Users SET Pwd=? WHERE UserID=?");
    return $stmt->execute(array($hashPassword,$id));
}

function UpdateUser($UserID,$FullName, $Email,$Phone)
{
    global $db;
    $stmt=$db->prepare("UPDATE Users SET FullName=? , Email = ? , Phone=? WHERE UserID=?");
    return $stmt->execute(array($FullName, $Email,$Phone,$UserID));
}
function UpdateUser1($UserID,$FullName, $Email, $ImgUrl,$Phone)
{
    global $db;
    $stmt=$db->prepare("UPDATE Users SET FullName=? , Email = ? , ImageUrl= ? , Phone=? WHERE UserID=?");
    return $stmt->execute(array($FullName, $Email, $ImgUrl,$Phone,$UserID));
}

function resizeImage($filename, $max_width, $max_height)
{
  list($orig_width, $orig_height) = getimagesize($filename);

  $width = $orig_width;
  $height = $orig_height;

  # taller
  if ($height > $max_height) {
      $width = ($max_height / $height) * $width;
      $height = $max_height;
  }

  # wider
  if ($width > $max_width) {
      $height = ($max_width / $width) * $height;
      $width = $max_width;
  }

  $image_p = imagecreatetruecolor($width, $height);

  $image = imagecreatefromjpeg($filename);

  imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $orig_width, $orig_height);

  return $image_p;
}
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
  }
function sendEmail($to, $name, $subject, $content) {
    global $EMAIL_FROM, $EMAIL_NAME, $EMAIL_PASSWORD;
    // Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);
    //Server settings
    $mail->isSMTP();                                            // Send using SMTP
    $mail->CharSet    = 'UTF-8';
    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = $EMAIL_FROM;                     // SMTP username
    $mail->Password   = $EMAIL_PASSWORD;                               // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
    $mail->Port       = 587;                                    // TCP port to connect to
    //Recipients
    $mail->setFrom($EMAIL_FROM, $EMAIL_NAME);
    $mail->addAddress($to, $name);     // Add a recipient
    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body    = $content;
    // $mail->AltBody = $content;
    $mail->send();
  }
  function activateUser($code) {
    global $db;
    $stmt = $db->prepare("SELECT * FROM Users WHERE CodeActived = ? AND IsActived = ?");
    $stmt->execute(array($code, 0));
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user && $user['CodeActived'] == $code) {
      $stmt = $db->prepare("UPDATE Users SET CodeActived = ?, IsActived = ? WHERE UserID = ?");
      $stmt->execute(array('', 1, $user['UserID']));
      return true;
    }
    return false;
  }
  // hàm này đọc phần mở rộng của file. Nó được dùng để kiểm tra nếu
// file này có phải là file hình hay không .
function getExtension($str) {
    $i = strrpos($str,".");
    if (!$i) { return ""; }
    $l = strlen($str) - $i;
    $ext = substr($str,$i+1,$l);
    return $ext;
}
function LoadNewFeed($UserID,$pageNum,$limit)
{
    global $db;
    $start=($pageNum-1)*$limit;
    $stmt=$db->prepare("CALL sp_LoadNewFeed(?,?,?)");
    $stmt->execute(array($UserID,$start,$limit));
    return  $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function GetNewFeedByID($NewFeedID) {
    global $db;
    $stmt = $db->prepare("SELECT * FROM NewFeeds WHERE NewFeedID = ?");
    $stmt->execute(array($NewFeedID));
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
function AddNewFeed($UserID, $content, $ImageUrl,$NewFeedType)
{
    global $db;
    $stmt=$db->prepare("INSERT INTO NewFeeds (NewFeedContent,UrlImage,IsPrivate,CreatedUser) VALUES(?,?,?,?)");
    $stmt->execute(array($content, $ImageUrl,$NewFeedType,$UserID));
    $newNewFeedID=$db->lastInsertId();
    return GetNewFeedByID($newNewFeedID);
}
function DelNewFeed($NewFeedID)
{
    global $db;
    $stmt=$db->prepare("UPDATE NewFeeds SET IsDeleted = 1 WHERE NewFeedID = ? ");
    return $stmt->execute(array($NewFeedID));
}
function AddLike($NewFeedID,$UserID)
{
    global $db;
    $isLike = CheckLike($UserID,$NewFeedID);
   
    if(intVal($isLike["NumLike"]) > 0)
    {
        DeleteLike($NewFeedID,$UserID);
    }
    else
    {
        $stmt=$db->prepare("INSERT INTO newfeed_like (NewFeedID,UserID) VALUES(?,?)");
        $stmt->execute(array($NewFeedID,$UserID));

        $newFeed = GetNewFeedByID($NewFeedID);
        if(intVal($newFeed["CreatedUser"]) != $UserID)
        {
            $content = "thích nội dung bài viết của bạn.";
            AddNotify($UserID,intVal($newFeed["CreatedUser"]),2,$content);
        }
    }
    return GetCountLikeNewFeed($NewFeedID);
}
function DeleteLike($NewFeedID,$UserID)
{
    global $db;
    $stmt=$db->prepare("DELETE FROM newfeed_like WHERE NewFeedID = ? AND UserID  = ? ");
    return $stmt->execute(array($NewFeedID,$UserID));

}
function CheckLike($UserID,$NewFeedID)
{
    global $db;
    $stmt=$db->prepare("SELECT COUNT(*) as NumLike FROM newfeed_like WHERE UserID  = ? AND NewFeedID = ?");
    $stmt->execute(array($UserID,$NewFeedID));
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
function GetCountLikeNewFeed($NewFeedID)
{
    global $db;
    $stmt=$db->prepare("SELECT COUNT(*) as NumLike FROM newfeed_like WHERE NewFeedID = ?");
    $stmt->execute(array($NewFeedID));
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
function GetCountFriend($UserID)
{
    global $db;
    $stmt=$db->prepare("SELECT COUNT(*) as NumFriend FROM users_friends WHERE (UserID = ? OR FriendID = ? ) AND IsAccept = 1 ");
    $stmt->execute(array($UserID,$UserID));
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return intVal($result["NumFriend"]);
}
function ValidateFriend($UserID,$FriendID)
{
    global $db;
    $stmt=$db->prepare("SELECT COUNT(*) as NumFriend FROM users_friends WHERE ((UserID = ? AND FriendID = ? ) OR (UserID = ? AND FriendID = ?)) AND IsAccept = 1 ");
    $stmt->execute(array($UserID,$FriendID,$FriendID,$UserID));
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return intVal($result["NumFriend"]);
}
function GetFriend($UserID,$FriendID)
{
    global $db;
    $stmt=$db->prepare("SELECT * FROM users_friends WHERE ((UserID = ? AND FriendID = ? ) OR (UserID = ? AND FriendID = ?))");
    $stmt->execute(array($UserID,$FriendID,$FriendID,$UserID));
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;

}
//Các hàm xử lý của bảng comment
function GetCommentByNewFeed($NewFeedID)
{
    global $db;
    $stmt=$db->prepare("SELECT n.*, s.FullName , s.ImageUrl FROM comments as n join users as s on n.CreatedUser = s.UserID  WHERE n.NewFeedID = ? AND n.IsDeleted = 0 ORDER BY n.CreatedDate");
    $stmt->execute(array($NewFeedID));
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function GetCommentByID($CommentID)
{

    global $db;
    $stmt=$db->prepare("SELECT n.*, s.FullName , s.ImageUrl FROM comments as n join users as s on n.CreatedUser = s.UserID  WHERE n.CommentID = ?");
    $stmt->execute(array($CommentID));
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
function AddComment($NewFeedID, $UserID, $CommentContent)
{
    global $db;
    $stmt=$db->prepare("INSERT INTO comments (CommentContent,NewFeedID,CreatedUser) VALUES(?,?,?)");
    $stmt->execute(array( $CommentContent,$NewFeedID,$UserID));
    $newFeed = GetNewFeedByID($NewFeedID);
    if(intVal($newFeed["CreatedUser"]) != $UserID)
    {
        $content = "Bình Luận nội dung bài viết của bạn.";
        AddNotify($UserID,intVal($newFeed["CreatedUser"]),2,$content);
    }
    
    return $db->lastInsertId();
}
function DelComment($CommentID)
{
    global $db;
    $stmt=$db->prepare("UPDATE comments SET IsDeleted = 1 WHERE CommentID = ? ");
    return $stmt->execute(array($CommentID));
}

// Function xử lý thông báo
function AddNotify($fromUserID, $ToUserID, $Type, $Content)
{
    global $db;
    $stmt=$db->prepare("INSERT INTO users_notifications (FromUserID,ToUserID,NotificationType,ShortDescription) VALUES(?,?,?,?)");
    $stmt->execute(array($fromUserID, $ToUserID, $Type, $Content));
    return $db->lastInsertId();
}
function GetNotifyByUser($UserID)
{
    global $db;
    $stmt=$db->prepare("SELECT un.*,u.FullName,u.ImageUrl FROM users_notifications as un join users u on un.FromUserID = u.UserID WHERE un.ToUserID = ? ORDER BY un.CreatedDate DESC");
    $stmt->execute(array($UserID));
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function Search($keySearch)
{
    $data = "%" .$keySearch ."%";
    global $db;
    $stmt=$db->prepare("SELECT * FROM Users WHERE Email like ? OR FullName like ? OR Phone = ?");
    $stmt->execute(array($data,$data,$data));
    return  $stmt->fetchAll(PDO::FETCH_ASSOC);

}