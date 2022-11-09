<!doctype html>
<html lang="en">
    <head>
      
       <meta charset="utf-8">
       <meta name="viewport" content="width=device-width, initial-scale=1">
    
       <!-- Bootstrap CSS -->
       <link rel="stylesheet" type="text/css" href="/bootstrap/css/bootstrap.min.css">
       <title>Mappa completa</title>
    
       <!--importa css map-->
       <link rel="stylesheet" href="/style/indexStyle.css">

       
    </head>
<body>

    <div id="tagPHP" >
        <?php
            //connessione al db postgreSQL 
            $dbconn = pg_connect("host=localhost dbname=markers password=sapienza user=postgres port=5432") or die(preg_last_error);
            $query = "SELECT * FROM aziende";
            $result = pg_query($dbconn, $query);

            $latitudes = array();
            $longitudes = array();
            $content = array();
            
            //creazione array dalla lettura della tabella dei markers
            while ($tuple = pg_fetch_array($result, null, PGSQL_BOTH)) {
                array_push($latitudes, $tuple[0]);
                array_push($longitudes, $tuple[1]);
                array_push($content, $tuple[2]);
            }

            //useremo il contatore per il loop nello script js creando gli array in js
            //per aggiungere i markers sulla mappa
            $count = count($latitudes);
        ?>
    </div>

    
    <!-- Boostrap js-->
    <script src="/bootstrap/js/bootstrap.min.js"></script>

    
    <div id="map"></div>

    <!--importa maps API-->
    <script defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDwqaemCV_HmZ2Y6N0PLiVM4Jn6_VIZ7Kc&callback=initMap">
    </script>
     
    <!--script mappa principale-->
    <script>
        //inizializza la mappa
        function initMap() {
            
            //proprieta' della mappa
            var options = {
                center: {lat: 41.9027835, lng: 12.4963655},
                zoom: 5
            }

            //crea la nuova mappa
            map = new google.maps.Map(document.getElementById("map"), options);

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
            
            //creo array markers
            var markers = [];
            for (var j=0; j < latitudini.length; j++) {
                markers.push({coordinate: {lat: latitudini[j], lng: longitudini[j]}, content: contents[j]});
            }

            //loop per aggiungere i markers alla mappa
            for(var i= 0 ; i < markers.length; i++){
                addMarker(markers[i]);
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
        }        
    </script>


</body>
</html>