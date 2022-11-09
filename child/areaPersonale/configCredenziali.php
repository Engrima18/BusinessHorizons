<?php
    session_start();
    $dbconn = pg_connect("host=localhost dbname=markers port=5432 
        user=postgres password=sapienza");
    $nome = $_SESSION['nome'];
    $cognome = $_SESSION['cognome'];
    $user = $_SESSION['username'];
    $email=$_SESSION['email'];
    $id=$_SESSION['userID'];
    //recupero password
    $query = "SELECT * from utenti where email = '$email'";
    $result = pg_query($dbconn, $query);
    $tuple = pg_fetch_array($result, null, PGSQL_BOTH);
    $pass = $tuple['passwd'];
    //recuperi commenti
    $query2 = "SELECT * from commenti where userid = '$id'";
    $result2 = pg_query($dbconn, $query2);

?>