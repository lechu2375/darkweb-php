<html>
    <head>
        <meta charset="utf-8">
        <title>common place - market</title>
        <link href="style.css" rel="stylesheet">
        <script>
            function show(element){
                span = element.getElementsByClassName("show")[0];
                span.style.display="inline";
            }
            function hide(element){
                span = element.getElementsByClassName("show")[0];
                span.style.display="none";
            }
        </script>
    </head>
    <body>
        <div id="notka" onmouseover="show(this)" onmouseout="hide(this)">Notka ooc
            <span class="show">Proszę wszystkich o odgrywanie tego darkweba jak już macie tu konto, 1 ogłoszenie 1 typ rzeczy(np. ogloszenie jedno z desert egagle, drugie z opium), ->>Kategoryczny zakaz OOC w ogłoszeniach<<- </span>
        </div>
        
        <?php
            session_start();

            if(!$_SESSION['userid']||!$_SESSION['login']){
                header("Location: index.php");
            }
            echo("Logged as:".$_SESSION['login']."</br>Admin privileges:".$_SESSION['isadmin']);
            echo("<form action='logout.php' method='post'> <input type='submit' class='logout' type='submit'value='logout'/></form>");
        ?>
            <a class="logout" href="newarticle.php">Nowe ogłoszenie</a>
            <h3>common place</h3>
        <?php
            require_once "db.php";
            $connection = @new mysqli($host,$dbuser,$dbpassword,$dbname);
            if($connection->connect_errno!=0)
            {
                echo "Coś poszło nie tak z łączeniem. Kod błędu:".$connection->connect_errno;
                echo "error:".$mysqli->connect_error;
            }
            else
            {
                
                $result = $connection->query("SELECT * FROM articles");
                if($result){
                    $article = $result->fetch_assoc();
                    while($article){
                        $article['content'] = strip_tags($article['content']);
                        $articleuid = $article['creatorid'];
                        $articleid = $article['articleid'];
                        if($_SESSION['isadmin']||$_SESSION['userid']==$articleuid){
                            echo "<div class='articleholder'>".$article['content']."</br>CID:$articleuid AID: $articleid";
                            echo "<form action='remove.php' method='post'> <input type='hidden' value='$articleid' name='toremove'> <input type='submit' class='logout' type='submit' value='REMOVE'/></form>";
                            echo "</div>";
                        }
                        else{
                            echo "<div class='articleholder'>".$article['content']."</div>";
                        }
                        $article = $result->fetch_assoc();
                    }
                    
                    $result->close();
                }
                else{
                    echo("Coś poszło nie tak.");
                }
                $connection->close();
            }
        ?>
        
    </body>
</html>