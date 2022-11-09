<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChangeUser</title>
    <link rel="stylesheet" type="text/css" href="/bootstrap/css/bootstrap.css"/>
    <link rel="stylesheet" type="text/css" href="/style/styleForm.css"/>
    <script>
        function testemail(modulo){
            var condition = true;
            if (myformSub.Inputvpass.value != "<?php echo $pass;?>") {
              alert("La password inserita non è corretta!");
              myformSub.Inputvpass.focus();
              myformSub.Inputvpass.select();
              condition = false;
            }
            else if (myformSub.InputPass.value != myformSub.InputPassR.value) {
              alert("La password inserita non coincide con la prima!");
              myformSub.InputPass.focus();
              myformSub.InputPass.select();
              condition = false;
            }
            return condition;
        }
    </script>
</head>

<body class="text-center">

    <div class="contenitore">
        <h1 class="mb-3">Cambia email</h1>
        <form name="myformSub" action="modifiche.php" method="post"  class="form-signin">
            <label data-error="wrong" data-success="right" for="email" >Nuova Email</label>
            <input type="email" name="Inputemail" class="form-control" 
                placeholder="Inserisci la nuova email" required autofocus/>
            <button type="submit" class="btn btn-success" name="registrationButton">Invia</button>
        </form>
        <h1 class="mb-3">Cambia username</h1>
        <form name="myformSub" action="modifiche.php" method="post"  class="form-signin">
            <label data-error="wrong" data-success="right" for="name" >Nuova username</label>
            <input type="name" name="Inputname" class="form-control" 
                placeholder="Inserisci il nuovo username" required autofocus/>
            <button type="submit" class="btn btn-success" name="registrationButton">Invia</button>
        </form>
    </div>
    <script src="/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>