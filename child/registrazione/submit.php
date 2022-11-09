<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit</title>
    <link rel="stylesheet" type="text/css" href="/style/reindirizzoStyle.css">
</head>
<body>
<?php
if(!(isset($_POST["registrationButton"]))){
    header("Location:../index.php") ;
    }
    else{
    $dbconn = pg_connect("host=localhost dbname=markers port=5432 
        user=postgres password=sapienza");
    $email = $_POST['Inputemail'];
    $username = $_POST['Inputuser'];
    
    $q1="SELECT * from utenti where email='$email'";
    $q2="SELECT * from utenti where username='$username'";
    $result1=pg_query($dbconn,$q1);
    $result2=pg_query($dbconn,$q2);
    if ($line=pg_fetch_array($result1,null,PGSQL_ASSOC)) {
        echo "<h1> Esiste già un utente con questa email </h1>";
        echo "Clicca <a href=\"/index.php\"> qui </a>per loggarti";
    }
    else if ($line=pg_fetch_array($result2,null,PGSQL_ASSOC)) {
        echo "<h1> Esiste già un utente con questo username </h1>";
        echo "Clicca <a href=\"/index.php\"> qui </a>per loggarti";
    }
    else{ 
        $password = password_hash($_POST['Inputpass'], PASSWORD_DEFAULT);
        $nome = $_POST['Inputnome'];
        $cognome = $_POST['Inputcognome'];
        $q2 ="INSERT into utenti values('$email','$password','$nome','$cognome','$username')";
        $data = pg_query($dbconn,$q2);
    if($data){
            echo "<h1> Registrazione andata a buon fine.
                    Inizia subito a navigare nel sito <br/></h1>";
            echo "<a href=\"/index.php\">Premi qui </a>";
        }
    
    }
}
?>
</body>
</html>

