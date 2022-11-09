<?php
    include 'configCredenziali.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="/style/reindirizzoStyle.css">
</head>
<body>
<?php
    $email=$_SESSION['email'];
    $dbconn = pg_connect("host=localhost dbname=markers port=5432 
        user=postgres password=sapienza");
    if (isset($_POST['InputPass'])){
        if(password_verify($_POST['Inputvpass'],$pass)){
            $newpass=password_hash($_POST['InputPass'], PASSWORD_DEFAULT);
            $q1="UPDATE utenti SET passwd = '$newpass' where email = '$email' ";
            $result=pg_query($dbconn,$q1);
            if($result){
                echo "<h1> Password cambiata con successo!
                Rieffettua l'accesso per continuarea navigare sul sito.<br/></h1>";
                session_destroy();
                echo "<a href=\"../../index.php\">Premi qui </a>";
            }
        }
        else{
            echo "<h1> La password inserita non è corretta</h1>";
            echo "<a href=\"changePass.php\"> Ritenta reinserendo la vecchia password </a>";
        }
    }
    else if (isset($_POST['Inputemail'])){
        $newemail= $_POST['Inputemail'];
        $control=pg_query($dbconn,"SELECT * from utenti where email='$newemail'");
        if($line=pg_fetch_array($control,null,PGSQL_ASSOC)) {
            echo "<h1> Esiste già un utente con queste credenziali </h1>";
            echo "<a href=\"changeUsername.php\"> Ritenta </a>con un'altra email";
        }
        else{ 
            $q2="UPDATE utenti SET email = '$newemail' where email = '$email' ";
            $result2=pg_query($dbconn,$q2);
            if($result2){
                echo "<h1> Email cambiata con successo!
                Rieffettua l'accesso per continuarea navigare sul sito.<br/></h1>";
                session_destroy();
                echo "<a href=\"../../index.php\">Premi qui </a>";
            }
        }
    }
    else if (isset($_POST['Inputname'])){
        $newusername= $_POST['Inputname'];
        $control2=pg_query($dbconn,"SELECT * from utenti where username='$newusername'");
        if($line=pg_fetch_array($control2,null,PGSQL_ASSOC)) {
            echo "<h1> Esiste già un utente con queste credenziali </h1>";
            echo "<a href=\"changeUsername.php\"> Ritenta </a>con un altro username";
        }
        else{         
            $q3="UPDATE utenti SET username = '$newusername' where email = '$email' ";
            $result3=pg_query($dbconn,$q3);
            if($result3){
                echo "<h1> Username cambiato con successo!
                        Rieffettua l'accesso per continuarea navigare sul sito. <br/></h1>";
                session_destroy();
                echo "<a href=\"../../index.php\">Premi qui </a>";
            }
        }
    }
?>
    
</body>
</html>