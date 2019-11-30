<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'module/phpmailer/Exception.php';
require 'module/phpmailer/PHPMailer.php';
require 'module/phpmailer/SMTP.php';

$EMAIL_FROM     = 'zenkiben@gmail.com';
$EMAIL_NAME     = 'Admin';
$EMAIL_PASSWORD = 'trungtan1991,./';
$vHost = "http://localhost/webcanhan/";

function login($username,$pwd)
{
	global $db;
    $stmt=$db->prepare("SELECT * FROM users WHERE UserName  = ? AND Pwd = ?");
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
function register($UserName,$Pwd,$FullName,$UrlImage,$Email)
{
    global $db;
    $code = generateRandomString(5);
    $stmt=$db->prepare("INSERT INTO users (UserName,Pwd,FullName,UrlImage,Email,IsActived,ActivedCode) VALUES(?,?,?,?,?,?,?)");
    $stmt->execute(array($UserName,$Pwd,$FullName,$UrlImage,$Email,"false",$code));
    sendEmail($Email,$FullName,'Kích hoạt tài khoản','Click vào: <strong><a href="http://localhost/webcanhan/'  .'actived.php?code=' .$code .'&email=' .$Email .'"> đây </a> để kích hoạt</strong> ');
    return $newUserId=$db->lastInsertId();
}
function change_password($newPassword,$id)
{
    global $db;
    $hashPassword=$newPassword;
    $stmt=$db->prepare("UPDATE Users SET Pwd=? WHERE UserID=?");
    return $stmt->execute(array($hashPassword,$id));
}

function UpdateUser($UserID,$FullName, $Email)
{
    global $db;
    $stmt=$db->prepare("UPDATE Users SET FullName=? , Email = ?  WHERE UserID=?");
    return $stmt->execute(array($FullName, $Email,$UserID));
}
function UpdateUser1($UserID,$FullName, $Email, $ImgUrl)
{
    global $db;
    $stmt=$db->prepare("UPDATE Users SET FullName=? , Email = ? , UrlImage= ? WHERE UserID=?");
    return $stmt->execute(array($FullName, $Email, $ImgUrl,$UserID));
}
function getNewFeed()
{
    global $db;
    $stmt=$db->query("SELECT p.*,u.displayName FROM newfeed p,user u WHERE p.idUser=u.id ORDER BY p.time DESC");
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
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
