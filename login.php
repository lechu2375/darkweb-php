<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    session_start();
    $login = @$_POST["login"];
    $password = @$_POST["password"];
    if(!isset($login)||!isset($password)){
        header("Location: index.php");
    }
    require_once "db.php";
    $connection = @new mysqli($host,$dbuser,$dbpassword,$dbname);
    if ($connection->connect_errno) {
        echo "Failed to connect to MySQL: (" . $connection->connect_errno . ") ";
    }
    else
    {   


        $result = $connection->query("SELECT * FROM users WHERE login = '$login' AND password = '$password'");

        if($result){
            $useramount = $result->num_rows;

            if($useramount==1){
                $userdata = $result->fetch_assoc();
                echo("Pomyślnie zalogowano.");
                $_SESSION['login'] = $userdata['login'];
                $_SESSION['userid'] = $userdata['userid'];
                $_SESSION['charuid'] = $userdata['charuid'];
                $_SESSION['isadmin'] = $userdata['admin'];
                $uidtemp = $userdata['userid'];
                $result = $connection->query("SELECT counter FROM counter WHERE userid=$uidtemp");   
                $counter = $result -> fetch_row();
                $couternum = $counter[0]; 
                echo($couternum);
                if($couternum){
                    $couternum+=1;
                    $connection->query("UPDATE counter SET counter=$couternum WHERE userid=$uidtemp");
                }
                else{
                    $connection->query("INSERT INTO counter (userid,counter) VALUES($uidtemp,1)");
                }

                header("Location: marketplace.php");
                $result->close();
            }
            elseif($useramount>1){
                echo("Coś poszło nie tak, zgłoś to administratorowi sysemu.");
                echo $useramount;
            }
            else{
                echo("Błędne dane logowania 2.");
                //header("Location: index.php");
            }
        }
        else{
            echo('Invalid query: ' . $connection->error);
            echo("Błędne dane logowania1.");
            //header("Location: index.php");
        }
        $connection->close();
    }
?>