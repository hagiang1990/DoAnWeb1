<?php
    session_start();
    require_once ('functions.php');
   
    $currentUser=null;
    $vHost = "http://localhost/doanweb1";
    
    $db=new PDO('mysql:host=localhost;dbname=socialnetwork_db;', 'root', '');
    $db->exec("set names utf8");
    $page = getPage();
    if($page != "login" && $page != "actived" && $page != "forgetpass")
    {
        if(isset($_SESSION['USERID'])) {
            $currentUser=findUserById($_SESSION['USERID']);
        }
        else
            header('Location: login.php'); 
    }
    
?>