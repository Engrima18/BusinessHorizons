<?php
    if(isset($_GET["Ricerca"])){
        $ricerca = str_replace( "'","^",ucfirst(strtolower($_GET["Ricerca"])));
    }
    else{
        $ricerca="";
    }
    $dbconn = pg_connect("host=localhost dbname=markers password=sapienza user=postgres port=5432") or die(preg_last_error);
?>

<!doctype html>
<html lang="en">
    <head>
      
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" type="text/css" href="/bootstrap/css/bootstrap.min.css">
        <title>Business Horizons</title>
        <!--importa css map-->
        <link rel="stylesheet" href="/style/indexStyle.css">
        <!--bootstrap icone-->
	    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
        <!--vue.js-->
        <script src="https://unpkg.com/vue@3"></script>

    </head>
<body>
    <!--php per lettura markers da db-->
    <?php
        $query = array();
        //connessione al db postgreSQL 
        if ($ricerca == "TUTTI"){
            $query = "SELECT * FROM aziende";
        }
        elseif ($ricerca != "") {
            $query = "SELECT * from aziende where title = '$ricerca'";
        }

        $latitudes = array();
        $longitudes = array();
        $content = array();
        
        //creazione array dalla lettura della tabella dei markers
        if ($ricerca != ""){
            $result = pg_query($dbconn, $query);
            while ($tuple = pg_fetch_array($result, null, PGSQL_BOTH)) {
                array_push($latitudes, $tuple[0]);
                array_push($longitudes, $tuple[1]);
                array_push($content, $tuple[3]);
            }
        }
        //useremo il contatore per il loop nello script js creando gli array in js
        //per aggiungere i markers sulla mappa
        $count = count($latitudes);
    ?>

    <!--navbar-->
    <div class="container-fluid bg-dark">
           <nav class="navbar navbar-expand-md navbar-dark bg-dark justify-content-between">
               <!--logo-->
               <img src="/images/Business.png">
               <!--searchbar-->
                <form class="d-flex" id="searchForm" action="index.php" method="get">
                  <input class="form-control form-control-lg me-2" name="Ricerca" type="search" placeholder="Search" id="Ricerca">
                  <button class="btn btn-outline-success" type="submit" id="btn-ricerca">Search</button>
                </form>
                <div class="d-flex">
                    <button class="navbar-toggler"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#toggleMobileMenu"
                        aria-controls="toggleMobileMenu"
                        aria-expanded="false"
                        aria-label="Toggle navigation"
                    >
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="toggleMobileMenu" >

                        <ul class="navbar-nav">
                        
                            <li class="nav-item active" id="sezNascosta1">
                                <a class="nav-link" href="/child/nnda/nnda.php">NNDA</a>
                            </li>
                            <li class="nav-item active" id="sezNascosta2">
                                <a class="nav-link" href="#">Scrivici</a>
                            </li>
                            <li class="nav-item active">
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalLoginForm" > <i class="bi bi-person"></i></button>
                            </li>

                        </ul>
                    
                    </div>
                </div>
           </nav>
    </div>

    <!-- Login Modal -->
    <div class="modal fade" id="modalLoginForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content bg-dark text-white">
                <!--parte alta modal-->
                <div class="modal-header text-center">
                    <!--titolo login-->
                    <h2 class="modal-title w-100 font-weight-bold">Accedi</h2>
                    <!--bottone di chiusura-->
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!--parte centrale modal-->
                <div class="modal-body mx-3">
                    <!--form di login-->
                    <form name="myformLog" action="/child/accesso/login.php" method="post">
                        <div class="md-form mb-5">
                            <label data-error="wrong" data-success="right" for="defaultForm-email">Email</label>
                            <input type="email" name="Inputemail" placeholder="Inserisci email" id="defaultForm-email" class="form-control validate">
                        </div>

                        <div class="md-form mb-4">
                            <label data-error="wrong" data-success="right" for="defaultForm-pass">Password <i class="bi bi-key"></i></label>
                            <!--parte con vue.js per nascondi/mostra password-->
                            <div id="app" style="display:flex">
                                <input v-if="showPassword" type="text"  v-model="password" placeholder="Inserisci password" name="Inputpassword" id="defaultForm-pass" class="form-control validate">
                                <input v-else type="password" v-model="password" placeholder="Inserisci password" name="Inputpassword" id="defaultForm-pass" class="form-control validate">
                                <button type="button" class="btn btn-dark" @click="toggleShow">
                                <i :class="{ 'bi bi-eye-slash-fill': showPassword, 'bi bi-eye-fill': !showPassword }"></i>
                                </button>
                            </div>
                        </div>
                        <!--login button-->
                        <button type="submit" name="loginButton" class="btn btn-success">Login</button>

                    </form>
                    
                </div>
                <!--parte bassa modal-->
                <div class="modal-footer d-flex justify-content-center">
                    
                    <!--link di registrazone-->
                    <div>
                        <p class="mb-0 ">Non hai un account? <a href="/child/registrazione/registrazione.html" class="text-white-50 fw-bold">Registrati</a>
                        </p>
                    </div>
                </div>
                    
            </div>
        </div>
    </div>
    
    <!-- Boostrap js-->
    <script src="/bootstrap/js/bootstrap.min.js"></script>

    <!-- CONTAINER CENTRALE CON MAPPA-->
    <div class=containerBody>
        <div id="map"></div>
        <div class="imgItem">
            <button type="submit" class="btn btn-success" id="showAll">SHOW ALL</button>
            <button type="submit" class="btn btn-light" id="cleanAll">CLEAN ALL</button>
            <button type="submit" class="btn btn-danger" id="info">INFO</button>
            <p class="descrizione">
                Cerca un'azienda digitando il suo nome o esplora la mappa: 
                le icone rosse indicano dov'è nata l'azienda che ti interessa!
            </p>
            <hr>
            <div id="divDinamico"></div>
        </div>
    </div>

    <!--importa maps API-->
    <script defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDwqaemCV_HmZ2Y6N0PLiVM4Jn6_VIZ7Kc&callback=initMap">
    </script> 

    <!--importa JQUERY-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    
    <!--script per impedire accesso a nnda e scrivi-->
    <script src="/script/accessBlock.js"></script>
     
    <!--script per mostra/nascondi password-->
    <script type="application/javascript" src="/script/hidePass.js"></script>
    
    <!--script mappa principale-->
    <script>

        let map;
        let markers = [];
        //inizializza la mappa
        function initMap() {

            //creo uno 'stringone' per ogni array creato in codice php con elementi separati dalla ,
            var stringaLat = "<?php
                                $latString = "";
                                for($i=0; $i < $count; $i++) {
                                    $latString .= strval($latitudes[$i]).",";
                                }
                                $latString = substr_replace($latString, "", -1);
                                echo $latString;
                                ?>";
            var stringaLng = "<?php
                                $lngString = "";
                                for($i=0; $i < $count; $i++){
                                    $lngString .= strval($longitudes[$i]).",";
                                }
                                //devo levare la virgola finale
                                $lngString = substr_replace($lngString, "", -1);
                                echo $lngString;
                                ?>";
            var stringaContent = "<?php
                                $contentString = "";
                                for($i=0; $i < $count; $i++){
                                    $contentString .= strval($content[$i]).",";
                                }
                                $contentString = substr_replace($contentString, "", -1);
                                echo $contentString;
                                ?>";
            
            //creo un array per ogni stringone 
            var latitudini = stringaLat.split(",");
            var longitudini = stringaLng.split(",");
            var contents = stringaContent.split(",");

            //cambio tipo degli elementi degli array per lat e lng (servono di tipo Number)
            for (var k=0; k < latitudini.length; k++){
                latitudini[k] = Number(latitudini[k]);
                longitudini[k] = Number(longitudini[k]);
            }

            //impostazioni centro e zoom
            var centro = {lat: 41.9027835, lng: 12.4963655};
            var zoomMap = 5;
            if (("<?php echo $ricerca;?>" != "") && ("<?php echo $ricerca;?>" != "TUTTI")){
                centro = {lat: latitudini[0], lng: longitudini[0]};
                zoomMap = 8;
            }

            //proprieta' della mappa
            var options = {
                center: centro,
                zoom: zoomMap
            }

            //crea la nuova mappa
            map = new google.maps.Map(document.getElementById("map"), options);

            //controllo esistenza di azienda nel db
            if (("<?php echo $ricerca;?>" != "") & (latitudini[0] == 0)){
                alert("Azienda non presente nella mappa!");
            }
            else {
                  //creo array markers
                for (var j=0; j < latitudini.length; j++) {
                    markers.push({coordinate: {lat: latitudini[j], lng: longitudini[j]}, content: contents[j]});
                }
                //loop per aggiungere i markers alla mappa
                for(var i= 0 ; i < markers.length; i++){
                    addMarker(markers[i]);
                }
            }
          
            
            // funzione per aggiungere markers 
            function addMarker(props){
                var marker = new google.maps.Marker({
                    position: props.coordinate,
                    map: map,      
                });
                //controllo del content per infoWindow
                if (props.content) {
                    var infoWindow = new google.maps.InfoWindow({
                        content: props.content, 
                    });
                
                    marker.addListener ('click', function(){
                        infoWindow.open(map, marker);
                    });
                
                }
            }

            $(document).ready(function(){
                var ricerca = "<?php echo $ricerca ?>";
                $("#info").click(function(){ 
                   $("#divDinamico").load("/child/gestioneDinamica/info.html #"+ ricerca);
                });
                $("#showAll").click(function(){
                   $("#map").load("/child/gestioneDinamica/showAll.php" );
                   $("#divDinamico").load("/child/gestioneDinamica/info.html #vuota");
                });
                $("#cleanAll").click(function(){
                   $("#map").load("/child/gestioneDinamica/cleanAll.php" );
                   $("#divDinamico").load("/child/gestioneDinamica/info.html #vuota");
                });
                $("#info").dblclick(function(){
                   $("#divDinamico").load("/child/gestioneDinamica/info.html #vuota");
                });
            });

        }
      
    </script>


</body>
</html>