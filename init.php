<?php
    session_start();
    require_once ('functions.php');
    $currentUser=null;
    $vHost = "http://localhost/webcanhan";
    
    $db=new PDO('mysql:host=localhost;dbname=qlnd;', 'root', '');
    
    if(isset($_SESSION['USERID'])) {
        $currentUser=findUserById($_SESSION['USERID']);
    }
?>