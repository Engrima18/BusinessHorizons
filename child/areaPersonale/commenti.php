<?php
    session_start();
    $dbconn = pg_connect("host=localhost dbname=markers port=5432 
        user=postgres password=sapienza");
    $nome = $_SESSION['nome'];
    $cognome = $_SESSION['cognome'];
    $user = $_SESSION['username'];
    $email=$_SESSION['email'];
    $id=$_SESSION['userID'];
    
    //recuperi commenti
    $query2 = "SELECT * from commenti where userid = '$id'";
    $result2 = pg_query($dbconn, $query2);

	//per eliminare il commento dal database se clicco sul tasto
	$clickedComment = 0 ;
	if (isset($_GET['delete'])) {
		$clickedComment = intval($_GET['comm']);
		$queryArray = "DELETE from commenti WHERE idcommento = '$clickedComment'";
		$resultArray = pg_query($dbconn,$queryArray);
		//ripetiamo la query per aggiornare immediatamente la lista di commenti dopo l'eliminazione
		$query2 = "SELECT * from commenti where userid = '$id'";
    	$result2 = pg_query($dbconn, $query2);
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commenti</title>
    <link rel="stylesheet" type="text/css" href="/bootstrap/css/bootstrap.css"/>
    <link rel="stylesheet" type="text/css" href="/style/styleForm.css"/>
    <link rel="stylesheet" type="text/css" href="/style/commentiStyle.css">
</head>
<body>
    <div class="contenitore">
        <div class="commenti">
        <a href="../../areaPrivata.php"><img src="/images/Business.png"></a>
        <h2 style="color:#7CD556">Il tuo punto di vista</h2>
        <hr>
		<?php 
			if (pg_num_rows($result2) > 0) {
				while ($tuple2 = pg_fetch_assoc($result2)) {
					?>
					<div class="single-comment">
						<h4 class="userComm" ><?php echo $tuple2['username']; ?></h4>
						<p class="aziendaComm"><?php echo "@".str_replace( "^","'",$tuple2['azienda']); ?></p>
						<hr>
						<p class="comm"><?php echo str_replace( "^","'",$tuple2['commento']); ?></p>
						<form method= "GET" >
							<input name="comm" type="text" value="<?php echo $tuple2['idcommento'] ?>" style="display:none">
							<div class="deleteSession">
								<button type="submit" name="delete" class="deleteButton">Elimina</button>
							</div>
						</form>
					</div>
					<?php
				}
			}
			else {
				?>	
				<p class="descr">Non hai ancora scritto alcun commento.</p>
				<?php	
			}
		?>
		</div>
    </div>
    <script src="/bootstrap/js/bootstrap.min.js"></script>    
</body>
</html>