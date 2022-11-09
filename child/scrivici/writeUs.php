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
    session_start();
    if(!(isset($_POST["loginButton"]))){
        header("Location:../areaPrivata.php") ;
    }
    else{
        $dbconn = pg_connect("host=localhost dbname=markers port=5432 user=postgres password=sapienza");
        $messaggio = $_POST['message'];
        $id = $_SESSION('userID');
        $query = "INSERT INTO messaggi (messaggio, user)
			VALUES ('$messaggio', '$id')";
	    $result = pg_query($dbconn, $query);
	    if ($result) {
		    echo "<script>alert('Ti ringraziamo per il tuo aiuto!.')</script>";
	    } 
        else {
		    echo "<script>alert('C'è stato un errore, messaggio non inoltrato!')</script>";
	    }
    }
    ?>
</body>
</html>

