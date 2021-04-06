<?php
    session_start();
    if(@$_SESSION['userid']&&@$_SESSION['login']){
        header("Location: marketplace.php");
    }
?>
<html>
    <!--wanna login, no account yet huh? !L!echu#6598 -->
    <head>
        <meta charset="utf-8">
        <title>common place - market</title>
        <link href="style.css" rel="stylesheet">
    </head>
    <body>
    <form class="loginpanel centerform" action="login.php" method="POST">
        Login:<input type="text" name="login"></br>
        Password:<input type="password" name="password"></br>
        <input class="button logout" type="submit" value="login"></br>
    <form>

    </body>
    
</html>
