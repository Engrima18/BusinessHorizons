<?php 
session_start();
include 'config.php';

if (isset($_GET['RicercaComm'])) {
	$ricerca = ucfirst(strtolower($_GET['RicercaComm']));
}
else{
	$ricerca="";
}

if (isset($_POST['inviaComm'])) { // check sul Comment Button
	$azienda = ucfirst(strtolower($_POST['azienda']));
	$azienda = str_replace( "'","^",$azienda); // nome azienda da form
	$id = intval($_SESSION['userID']); // id utente
    if  (isset($_POST['anonimo'])){ //check sul bottone per l'anonimo
		$username = "anonimo";
		}
	else{
		$username = $_SESSION['username'];
	}
	$comment = str_replace( "'","^",$_POST['comment']); // prendi il commento da form

	$query = "INSERT INTO commenti (azienda, username, commento, userID)
			VALUES ('$azienda', '$username', '$comment', $id)";
	$result = pg_query($conn, $query);
	if ($result) {
		echo "<script>alert('Commento aggiunto.')</script>";
	} else {
		echo "<script>alert('C'è stato un errore, commento non aggiunto!')</script>";
	}
}
$id= $_SESSION['userID'];
$likedComment = 0 ;
$likeList = array();
if (isset($_POST['like'])) {
	$likedComment = intval($_POST['comm']);
	$queryArray = "SELECT listalike from commenti WHERE idcommento = '$likedComment'";
	$resultArray = pg_query($conn,$queryArray);
	$line=pg_fetch_array($resultArray,null,PGSQL_ASSOC);
	$stringalike = str_replace("{","",$line['listalike']);
	$stringalike = str_replace("}","",$stringalike);		
	$likeList = explode(",",$stringalike);
	if(!(in_array($id,$likeList))){
		$queryMod = "UPDATE commenti SET listalike = array_append(listalike,'$id' ) WHERE idcommento = '$likedComment'";
		$resultMod= pg_query($conn, $queryMod);
		$queryComm="UPDATE commenti SET likes = likes + 1  WHERE idcommento = '$likedComment'";
		$resultComm= pg_query($conn, $queryComm);
	}
	else{
		$queryMod = "UPDATE commenti SET listalike = array_remove(listalike,'$id' ) WHERE idcommento = '$likedComment'";
		$resultMod= pg_query($conn, $queryMod);
		$queryComm="UPDATE commenti SET likes = likes - 1  WHERE idcommento = '$likedComment'";
		$resultComm= pg_query($conn, $queryComm);
	}	
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="/bootstrap/css/bootstrap.min.css">
    <title>NNDA</title>
    <!--bootstrap icone-->
	<link rel="stylesheet" type="text/css" href="/style/commentiStyle.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
</head>	
<body>

	<div class="container-fluid bg-dark">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark justify-content-between">
            <a href="../../areaPrivata.php"><img src="/images/Business.png"></a>
            <h2>NoN-NoN-Disclosure-Agreement</h2>
			<img class="nnda-logo" src="/images/nnda.png">
        </nav>
    </div>    	
	<p class="descr">In questa sezione,gli utenti registrati,possono riportare le loro esperienze personali,
	    pareri professionali e valutazioni generiche inerenti a una specifica azienda.
	</p>
	<hr class="lineasup">
	<div class="contenitore">
		<div class="cerca">
    		<h4 class="descr">Valuta i commenti dei nostri utenti rigurado le aziende che ti interessano.</h4>
			
		</div>	
		<div class="invia">
			<h4 class="descr">Aggiungi il tuo commento</h4>
			<button class="commentButton" data-bs-toggle="modal" data-bs-target="#modalCommentForm">Scrivi <i class="bi bi-pencil-fill"></i></button>
		</div>
	</div>
	<hr class="lineasup">
	<form class="d-flex" id="searchForm" action="nnda.php" method="get">
                  <input class="form-control form-control-lg me-2" name="RicercaComm" type="search" placeholder="Inserisci azienda" id="Ricerca">
                  <button class="btn btn-outline-success" type="submit" id="btn-ricerca"><img src="/images/find.png"></button>
    </form>

	<div class="modal fade" id="modalCommentForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"aria-hidden="true">
    	    <div class="modal-dialog" role="document">
    	        <div class="modal-content bg-dark text-white">
    	            <!--parte alta modal-->
    	            <div class="modal-header text-center">
    	                <!--titolo login-->
    	                <h2 class="modal-title w-100 font-weight-bold">Scrivi commento</h2>
    	                <!--bottone di chiusura-->
    	                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    	            </div>
    	            <!--parte centrale modal-->
    	            <div class="modal-body mx-3">
    	                <!--form di login-->
    	                <form name="myformComm" action="" method="POST">
							<div class="md-form mb-5">
								<label data-error="wrong" data-success="right" for="azienda" >Azienda <i class="bi bi-piggy-bank-fill"></i></label>
								<input type="text" name="azienda" id="azienda" placeholder="Inserisci azienda" class="form-control validate" required>
							</div>
							<div class="imd-form mb-5">
								<label for="comment" data-error="wrong" data-success="right">Commento <i class="bi bi-people-fill"></i></label>
								<textarea id="comment" name="comment" placeholder="Inserisci commento" class="form-control validate" required></textarea>
							</div>
							<div>
								<button name="inviaComm" class="btn btn-success">Invia Commento</button>
							</div>
						</form>
	
    	            </div>
	
    	        </div>
    	    </div>
    	</div>

		<div class="commenti">
		<?php 
			
			if ($ricerca == ""){
				$query2 = "SELECT * FROM commenti order by likes desc";
			}
			else{
				$query2 = "SELECT * FROM commenti where azienda = '$ricerca' order by likes desc";
			}
			$result = pg_query($conn, $query2);
			if (pg_num_rows($result) > 0) {
				while ($tuple = pg_fetch_assoc($result)) {
					?>
					<div class="single-comment">
						<h4 class="userComm" ><?php echo $tuple['username']; ?></h4>
						<p class="aziendaComm"><?php echo "@".str_replace( "^","'",$tuple['azienda']); ?></p>
						<hr>
						<p class="comm"><?php echo str_replace( "^","'",$tuple['commento']); ?></p>
						<hr>
						<form method= "POST" >
							<input name="comm" type="text" value="<?php echo $tuple['idcommento'] ?>" style="display:none">
							<div class="likeSession">
								<button type="submit" name="like" class="likeButton">
								<?php
									$likeString = str_replace("{","",$tuple['listalike']);
									$likeString = str_replace("}","",$likeString);		
									$likeLista = explode(",",$likeString);
									if (!in_array($_SESSION['userID'],$likeLista)){
								?>
									<i class="bi bi-heart"></i>
								<?php 
									}
									else{
								?>
									<i class="bi bi-heart-fill"></i>
								<?php
								}
								?>
								</button>
								<p class="likes"><?php echo $tuple['likes']; ?></p>
							</div>
						</form>
					</div>
					<?php
				}
			}
			else {
				?>	
				<p class="descr">Nessun commento su <?php echo $ricerca ?></p>
				<?php	
			}
		?>
		</div>
		
	<script src="/bootstrap/js/bootstrap.min.js"></script>
</body>
