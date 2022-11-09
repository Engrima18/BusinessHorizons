<!doctype html>
<html lang="en">
    <head>
      
       <meta charset="utf-8">
       <meta name="viewport" content="width=device-width, initial-scale=1">
    
       <!-- Bootstrap CSS -->
       <link rel="stylesheet" type="text/css" href="/bootstrap/css/bootstrap.min.css">
       <title>Mappa vuota</title>
    
       <!--importa css map-->
       <link rel="stylesheet" href="/style/indexStyle.css">

       
    </head>
<body>

    
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

        }
    </script>


</body>
</html>