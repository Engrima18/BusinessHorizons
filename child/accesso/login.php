<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="/style/reindirizzoStyle.css">
</head>
<body>
    <?php
if(!(isset($_POST["loginButton"]))){
    header("Location:../index.php") ;
    }
else{
    $dbconn = pg_connect("host=localhost dbname=markers port=5432 user=postgres password=sapienza");
    $email = $_POST['Inputemail'];
    $password = $_POST['Inputpassword'];
    $q1 = "SELECT * from utenti where email = $1";
    $result = pg_query_params($dbconn,$q1,array($email));
    if (!($line=pg_fetch_array($result,null,PGSQL_ASSOC))) {
        echo "<h1> Il login non è andato a buon fine, nel sistema non è presente
                 nessun account con queste crerdenziali  </h1>";
        echo "Clicca <a href=\"../registrazione/registrazione.html\"> qui </a>
            per registrarti o torna alla<a href=\"../../index.php\"> pagina iniziale </a>";
    }
    else{
        $password =$_POST['Inputpassword'];
        $result = pg_query_params($dbconn,$q1,array($email));
        if ($tuple=pg_fetch_array($result,null,PGSQL_ASSOC)) {
            if(password_verify($password, $tuple['passwd'])){
                session_start();
                $_SESSION['nome']= $tuple['nome'];
                $_SESSION['cognome'] = $tuple['cognome'];
                $_SESSION['username']= $tuple['username'];
                $_SESSION['email']= $tuple['email'];
                $_SESSION['loggato']= true;
                $_SESSION['userID']= $tuple['userid'];
                header("Location: /areaPrivata.php");
            }
        
    
            else{
                echo "Password non corretta ! Riprova ";
                echo "<a href=\"/index.php\">Premi qui </a>";
            }
        }      
    }
}?>
</body>
</html>

