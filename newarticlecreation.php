<?php
    session_start();
    if(!$_SESSION['userid']||!$_SESSION['login']){
        header("Location: index.php");
    }
    require_once "db.php";
    $connection = @new mysqli($host,$dbuser,$dbpassword,$dbname);
    if($connection->connect_errno!=0)
    {
        echo "Coś poszło nie tak z łączeniem. Kod błędu:".$connection->connect_errno;
    }
    else
    {
        
        $result = $connection->query("SELECT * FROM articles WHERE creatorid =".$_SESSION['userid']);
        if($result){
            $amount = $result->num_rows;
            $isadmin = $_SESSION['isadmin'];
            $result = $connection->query("SELECT maxposts FROM users WHERE userid =".$_SESSION['userid']);
            $field = $result -> fetch_row();
            $maxposts = $field[0];
            $result->close();
        }
        else{
            echo("Coś poszło nie tak.");
        }
        $articlecontent = $_POST["articlecontent"];
        if(($isadmin || $amount<$maxposts)&& isset($articlecontent)){
            $userid = $_SESSION['userid'];
            $connection->query("INSERT INTO `articles`(`articleid`, `creatorid`, `content`) VALUES (NULL,'$userid','$articlecontent')");
        }
        echo $connection->error;
        $connection->close();
    }    
    header("Location: marketplace.php");
?>