<html>
    <head>
        <meta charset="utf-8">
        <title>common place - market</title>
        <link href="style.css" rel="stylesheet">
    </head>
    <body>
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
                $result->close();
            }
            else{
                echo("Coś poszło nie tak.");
            }
           
            $result = $connection->query("SELECT maxposts FROM users WHERE userid =".$_SESSION['userid']);
            $field = $result -> fetch_row();
            $maxposts = $field[0];
            $connection->close();
        }        
    ?>
    <form class="loginpanel" action="newarticlecreation.php" method="POST">
        <a class="logout" href="marketplace.php">Wstecz</a>
        <textarea id="articlecontent" name="articlecontent" rows="5" cols="50"></textarea></br>
        <input class="button logout" type="submit" value="create"></br>
    <form>
    <script> 
        numrows= <?php echo json_encode($amount, JSON_HEX_TAG); ?>;
        isadmin = <?php echo json_encode($isadmin, JSON_HEX_TAG); ?>;
        maxposts = <?php echo json_encode($maxposts, JSON_HEX_TAG); ?>;
        form = document.getElementsByTagName("form")[0];
        span = document.createElement("span"); 
        
        if(numrows>=maxposts && !isadmin){
            document.getElementsByTagName("input")[0].remove();
            text = document.createTextNode("Wyczerpałeś aktywnych limit ogłoszeń."+"Aktywne ogłoszenia:"+numrows); 
        }
        else{
            text = document.createTextNode("Aktywne ogłoszenia:"+numrows+" Maksymalna ilość:"+maxposts); 
        }
        
        span.appendChild(text); 
        form.appendChild(span);  
    </script>


    </body>
</html>