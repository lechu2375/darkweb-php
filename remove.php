<?php

    session_start();
    

    $toremove = $_POST["toremove"];
    if(!$_SESSION['userid']||!$_SESSION['login']||!isset($toremove)){
        header("Location: index.php");
    }
    require_once "db.php";
    $isadmin = $_SESSION['isadmin'];
    $userid = $_SESSION['userid'];
    $connection = @new mysqli($host,$dbuser,$dbpassword,$dbname);
    if($connection->connect_errno!=0)
    {
        echo "Coś poszło nie tak. Kod błędu:".$connection->connect_errno;
    }
    else{
        if($isadmin){
            $connection->query("DELETE FROM articles WHERE articleid='$toremove'");
        }
        else{
            $result = $connection->query("SELECT * FROM articles WHERE articleid='$toremove' AND creatorid='$userid'");
            $row = $result->fetch_assoc();
            if($row){
                $articleuid = $row['creatorid'];
                $articleid = $row['articleid'];
                $connection->query("DELETE FROM articles WHERE articleid='$toremove'");
            }
        }
        $connection->close();
        header("Location: index.php");
    }

        
?>