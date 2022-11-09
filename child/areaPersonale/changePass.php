<?php
    include 'configCredenziali.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChangePassword</title>
    
    <link rel="stylesheet" type="text/css" href="/bootstrap/css/bootstrap.css"/>
    <link rel="stylesheet" type="text/css" href="/style/styleForm.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <!--vue.js-->
    <script src="https://unpkg.com/vue@3"></script>
    <script>
        function testpass(){
            var condition = true;
            if (myformSub.InputPass.value != myformSub.InputPassR.value) {
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
        <h1 class="mb-3">Cambia Password</h1>
        <form name="myformSub" action="modifiche.php" method="post" onsubmit="return testpass(this)" class="form-signin">
            <div id="app">
                <label data-error="wrong" data-success="right" for="passwd" >Vecchia Password</label>
                <div class="pass">
                    <input v-if="showPassword" type="text"  v-model="passwordv" placeholder="Vecchia password" name="Inputvpass" id="pass1" class="form-control">
                    <input v-else type="password" v-model="passwordv" placeholder="Vecchia password" name="Inputvpass" id="pass1" class="form-control">
                    <button id="show" type="button" class="btn btn-dark" @click="toggleShow">
                    <i :class="{ 'bi bi-eye-slash-fill': showPassword, 'bi bi-eye-fill': !showPassword }"></i>
                    </button>
                </div>
                <label data-error="wrong" data-success="right" for="passwd" >Nuova Password</label>
                <input v-if="showPassword" type="text"  v-model="password" placeholder="Inserisci password" name="InputPass" id="pass2" class="form-control">
                <input v-else type="password" v-model="password" placeholder="Inserisci password" name="InputPass" id="pass2" class="form-control">
                <input v-if="showPassword" type="text"  v-model="password2" placeholder="Ripeti password" name="InputPassR" id="pass3" class="form-control">
                <input v-else type="password" v-model="password2" placeholder="Ripeti password" name="InputPassR" id="pass3" class="form-control">
            </div>
            <button type="submit" class="btn btn-success" name="registrationButton">Invia</button>
        </form>
    </div>
    <script src="/bootstrap/js/bootstrap.min.js"></script>
    <!--script per mostra/nascondi password-->
    <script type="application/javascript" src="/script/hidePass.js"></script>
        
</body>
</html>