<?php
include 'configCredenziali.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Area personale</title>
    <link rel="stylesheet" type="text/css" href="/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/style/privataStyle.css">
</head>

<body>
    <div class="container-fluid bg-dark">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark justify-content-between">
            <a href="../../areaPrivata.php"><img src="/images/Business.png"></a>
            <h1>Area personale</h1>
        </nav>
    </div>    

    <div class="contenitore">
        <a href="/child/areaPersonale/changePass.php" class="card w-25 text-white bg-success mb-3">
            <div class="card-header"><img src="/images/key.png"></div>
            <div class="card-body">
              <h5 class="card-title">Nuova password</h5>
              <p class="card-text">Reimposta la tua password d'accesso.</p>
            </div>
        </a>
        
        <a href="/child/areaPersonale/changeUsername.php" class="card w-25 bg-light mb-3">
            <div class="card-header"><img src="/images/cambia-utente.png"></div>
            <div class="card-body">
              <h5 class="card-title">Impostazioni utente</h5>
              <p class="card-text">Cambia la tua email o il tuo username.</p>
            </div>
        </a>
        <a href="/child/areaPersonale/commenti.php" class="card w-25 text-white bg-dark mb-3">
            <div class="card-header"><img src="/images/chat-balloon.png"></div>
            <div class="card-body">
              <h5 class="card-title">I tuoi commenti</h5>
              <p class="card-text">Visualizza lo storico dei tuoi commenti.</p>
            </div>
        </a>
        <div class="card w-25 text-white bg-secondary mb-3">
            <div class="card-header"><img src="/images/cartella-utente.png"></div>
            <div class="card-body">
              <h5 class="card-title">Le tue credenziali</h5>
              <p class="card-text">Username: <?php echo $user;?> </p>
              <p class="card-text">Nome: <?php echo $nome;?> </p>
              <p class="card-text">Cognome: <?php echo $cognome;?> </p>
              <p class="card-text">Email: <?php echo $email;?> </p>
            </div>
        </div>
    <script src="/bootstrap/js/bootstrap.min.js"></script>
    <!--importa JQUERY-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

</body>
</html>