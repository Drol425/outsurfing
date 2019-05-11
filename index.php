<?php
include('dbcon.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <style>
      #pac-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 300px;
      }

      #pac-input:focus {
        border-color: #4d90fe;
      }
    </style>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
            <a class="navbar-brand" href="/">Navbar</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php" tabindex="-1" aria-disabled="true">Sign In</a>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="card bg-dark text-white">
            <img src="background1.jpg" class="card-img" alt="...">
            <div class="card-img-overlay d-flex justify-content-center">
                <form name="1234" method="POST" class="form-inline my-2 my-lg-0">
                    <input class="form-control mr-sm-2" id="pac-input" name="sub" type="text" placeholder="Search" aria-label="Search">
                    <input type="submit" class="btn btn-outline-success my-2 my-sm-0" type="submit">
                    <div style="display:none;" id="map"></div>
                </form>
            </div>
        </div>
    </header>
    <main class="d-flex justify-content-center flex-column align-items-center">
      <?php
      if(!isset($_POST['sub'])){
          $user = $DB->query("SELECT * FROM `users`");
          foreach ($user as $key => $value) {
            //print_r($value);
      
      ?>
        <div class="card mb-3" style="max-width: 800px">
            <div class="row no-gutters">
                <div class="col-md-4">
                    <img style="width: 100%;" src="<?php echo $value['img']; ?>" class="rounded-circle" alt="...">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <a href="user.php?name=<?php echo $value['name']; ?>"><h5 class="card-title"><?php echo $value['name']; ?></h5></a>
                        <p class="card-text"><?php echo $value['description']; ?></p>
                        <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                    </div>
                </div>
            </div>
        </div>
        <?php
            }
      }else{
          $user1 = $DB->query("SELECT * FROM `users` WHERE city=?",array($_POST['sub']));
          foreach ($user1 as $key => $value) {
            //print_r($value);
      
      ?>
        <div class="card mb-3" style="max-width: 800px">
            <div class="row no-gutters">
                <div class="col-md-4">
                    <img style="width: 100%;" src="<?php echo $value['img']; ?>" class="rounded-circle" alt="...">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $value['name']; ?></h5>
                        <p class="card-text"><?php echo $value['description']; ?></p>
                        <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                    </div>
                </div>
            </div>
        </div>
        <?php
            }
      }
      ?>

    </main>
    <footer class="d-flex justify-content-center bg-dark text-white">
        <p>Created by Web::chychka</p>
    </footer>
<script>
      // This example adds a search box to a map, using the Google Place Autocomplete
      // feature. People can enter geographical searches. The search box will return a
      // pick list containing a mix of places and predicted search terms.

      // This example requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:
      // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

      function initAutocomplete() {
          var styledMapType = new google.maps.StyledMapType(
            [
              {
                "featureType": "administrative",
                "elementType": "geometry",
                "stylers": [
                  {
                    "visibility": "off"
                  }
                ]
              },
              {
                "featureType": "poi",
                "stylers": [
                  {
                    "visibility": "off"
                  }
                ]
              },
              {
                "featureType": "road",
                "elementType": "labels.icon",
                "stylers": [
                  {
                    "visibility": "off"
                  }
                ]
              },
              {
                "featureType": "transit",
                "stylers": [
                  {
                    "visibility": "off"
                  }
                ]
              }
            ],
            {name: 'Styled Map'});
              
        var map = new google.maps.Map(document.getElementById('map'), {

          center: {lat: 48.945700, lng: 38.493964},
          zoom: 18,
          mapTypeControlOptions: {
            mapTypeIds: ['roadmap', 'satellite', 'hybrid', 'terrain',
                    'styled_map']
          }
        });
        map.mapTypes.set('styled_map', styledMapType);
        map.setMapTypeId('styled_map');
        
                var contentString = '<div id="content">'+
            '<div id="siteNotice">'+
            '</div>'+
            '<h1 id="firstHeading" class="firstHeading">Шиворот на Выворот</h1>'+
            '<div id="bodyContent">'+
            '<p>Представлена модная, стильная женская и мужская одежда известных итальянских, американских, немецких брендов.' +
            'Юбки, блузы, платья, брюки, куртки, пальто, джинсы, обувь – все для Вашего гардероба!'+
            '<b>Время работы:<b/> <ins>Пн - Вс с 10:00 - 19:00</ins>';
                var contentString1 = '<div id="content">'+
            '<div id="siteNotice">'+
            '</div>'+
            '<h1 id="firstHeading" class="firstHeading">Секонд ХЕНД Zig-Zag</h1>'+
            '<div id="bodyContent">'+
            '<p>Представлена модная, стильная женская и мужская одежда известных итальянских, американских, немецких брендов.' +
            'Юбки, блузы, платья, брюки, куртки, пальто, джинсы, обувь – все для Вашего гардероба!'+
            '<b>Время работы:<b/> <ins>Пн - Вс с 10:00 - 19:00</ins>';
            
            var infowindow = new google.maps.InfoWindow({
          content: contentString
        });
        var infowindow1 = new google.maps.InfoWindow({
          content: contentString1
        });
        var image = 'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png';
        var marker = new google.maps.Marker({
          position: {lat: 48.944696, lng: 38.493490},
          map: map,
          title: 'Стоковый магазин Шиворот на Выворот',
          animation: google.maps.Animation.DROP,
          icon: image
        });
        marker.addListener('click', function() {
          infowindow.open(map, marker);
        });
 
        var marker2 = new google.maps.Marker({
          position: {lat: 49.044527, lng: 38.224660},
          map: map,
          title: 'Секонд Zig-Zag',
          animation: google.maps.Animation.DROP
        });
        var marker1 = new google.maps.Marker({
          position: {lat: 48.945129, lng: 38.496289},
          map: map,
          title: 'Секонд Хенд Шкаф',
          animation: google.maps.Animation.DROP
        });
        // Create the search box and link it to the UI element.
        var input = document.getElementById('pac-input');
        var searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        // Bias the SearchBox results towards current map's viewport.
        map.addListener('bounds_changed', function() {
          searchBox.setBounds(map.getBounds());
        });

        var markers = [];
        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener('places_changed', function() {
          var places = searchBox.getPlaces();

          if (places.length == 0) {
            return;
          }

          // Clear out the old markers.
          markers.forEach(function(marker) {
            marker.setMap(null);
          });
          markers = [];

          // For each place, get the icon, name and location.
          var bounds = new google.maps.LatLngBounds();
          places.forEach(function(place) {
            if (!place.geometry) {
              console.log("Returned place contains no geometry");
              return;
            }
            var icon = {
              url: place.icon,
              size: new google.maps.Size(71, 71),
              origin: new google.maps.Point(0, 0),
              anchor: new google.maps.Point(17, 34),
              scaledSize: new google.maps.Size(25, 25)
            };

            // Create a marker for each place.
            markers.push(new google.maps.Marker({
              map: map,
              icon: icon,
              title: place.name,
              position: place.geometry.location
            }));

            if (place.geometry.viewport) {
              // Only geocodes have viewport.
              bounds.union(place.geometry.viewport);
            } else {
              bounds.extend(place.geometry.location);
            }
          });
          map.fitBounds(bounds);
        });
      }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBM6GyeLm7hzLGH3TRSEmUQTYWchvuiq7E&libraries=places&callback=initAutocomplete"
         async defer></script>
</body>

</html>
