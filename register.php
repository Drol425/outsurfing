<?php
	//exit();
    header('Content-Type: text/html; charset=utf-8');
// Страница регистрации нового пользователя
print_r($_POST);
// Соединямся с БД
include('dbcon.php');
function incrementalHash($len = 8){
  $charset = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
  $base = strlen($charset);
  $result = '';

  $now = explode(' ', microtime())[1];
  while ($now >= $base){
    $i = $now % $base;
    $result = $charset[$i] . $result;
    $now /= $base;
  }
  return substr($result, -5);
}

if(isset($_POST['submit']))
{
    $err = [];

    // проверям логин


    if(strlen($_POST['login']) < 3 or strlen($_POST['login']) > 30)
    {
        $err[] = "Логин должен быть не меньше 3-х символов и не больше 30";
    }

    // проверяем, не сущестует ли пользователя с таким именем
    //$query = mysqli_query($db, "SELECT user_id FROM users WHERE user_login='".mysqli_real_escape_string($db, $_POST['login'])."'");
     $query =  $DB->query("SELECT COUNT(id) FROM users WHERE login=?", array($_POST['login']));
   // print_r($query[0]['COUNT(user_id)']);
    if($query[0]['COUNT(id)'] > 0)
    {
        $err[] = "Пользователь с таким логином уже существует в базе данных";
    }

    // Если нет ошибок, то добавляем в БД нового пользователя
    if(count($err) == 0)
    {

        $login = $_POST['login'];

        // Убераем лишние пробелы и делаем двойное хеширование
        $password = md5(md5(trim($_POST['password'])));

        $name = $_POST['name'];

        $city =  $_POST['city'];

       //mysqli_query($db,"INSERT INTO users SET user_login='".$login."', user_password='".$password."'");
                                                                        //INSERT INTO users(id,login,password,name,`age`, `description`, `img`, `city`) VALUES(?,?,?)
        $DB->query("INSERT INTO users(id,login,password,name,`age`, `description`, `img`, `city`) VALUES(?,?,?,?,?,?,?,?)", array(null,$login,$password,$name,'','Дуже люблю подорожувати. Якщо хочете то заходбте до мене до дому','',$city));
       //$user_id = $DB->lastInsertId();
       
        //$api_key =  incrementalHash();
       
       //$DB->query("INSERT INTO api_key(id,api_key,site,id_user) VALUES(?,?,?,?)", array(null,$api_key,"",$user_id));
       //
      //$id_api_key = $DB->lastInsertId();
       
       //$DB->query("UPDATE users SET apikey_id = ? WHERE user_login = ?", array($id_api_key, $login));
       
       //$DB->query("INSERT INTO limit_user(`id`, `id_user`, `limit_key`, `limit_post`) VALUES(?,?,?,?)", array(NULL, $user_id, '1000', '400'));
       
        //mysqli_query($db,"INSERT INTO `limit_user` (`id`, `id_user`, `limit_key`, `limit_post`) VALUES (NULL, '$user_id', '1000', '400')");
        
        //mysqli_query($db,"INSERT INTO `setting` (`id`, `id_user`, `name`, `value`) VALUES (NULL, '$user_id', 'links', '5')");
        //$DB->query("INSERT INTO setting(`id`, `id_user`, `name`, `value`) VALUES(?,?,?,?)", array(NULL, $user_id, 'links', '5'));
       // mysqli_query($db,"IINSERT INTO `setting` (`id`, `id_user`, `name`, `value`) VALUES (NULL, '$user_id', 'links', '5')");
        
        header("Location: login.php"); exit();
    }
    else
    {
        print "<b>При регистрации произошли следующие ошибки:</b><br>";
        foreach($err AS $error)
        {
            print $error."<br>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>Document</title>
   <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> -->
   <link rel="stylesheet" href="signup.css"/>
   <link href="https://fonts.googleapis.com/css?family=Josefin+Sans" rel="stylesheet">
   <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
   </head>
<body>

   <p>
       <a href="#"><span style="font-size:20px">&larr;</span> Back to Home</a>
   </p>
       <form method="POST">
           <img src="logo.png" alt=""/>
           <div id="inputs">
               <input type="text" name="name" placeholder="First name" required/>
               <input type="text" name="surname" placeholder="Last name" required/><br/>
               <input type="email" name="login" placeholder="Email" required/><br/>
               <input type="password" name="password" placeholder="Password" required/><br/>
               <input type="password" name="password" placeholder="Confirm password" required/><br/>
               <input class="form-control mr-sm-2" id="pac-input" type="text" placeholder="Search" name="city" aria-label="Search">
               <div style="display:none;" id="map"></div>
               <div id="helper_sub">
                   <div id="help_info">
                        Sign up with
                        <a href=""><i class="fab fa-facebook"></i></a>
                        <a href=""><i class="fab fa-google-plus"></i></a>
                   </div>
                   <input type="submit" name="submit" placeholder="Submit" required/><br/>
               </div>
           </div>
       </form><br><br><br>

       

   <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
   <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script> -->
   <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script> -->
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