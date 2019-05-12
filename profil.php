<?php
    include('dbcon.php');
    
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
if (isset($_COOKIE['id']) and isset($_COOKIE['hash']))
{
    //$query = mysqli_query($db, "SELECT *,INET_NTOA(user_ip) AS user_ip FROM users WHERE user_id = '".intval($_COOKIE['id'])."' LIMIT 1");
   // $userdata = mysqli_fetch_assoc($query);
$query =  $DB->query("SELECT id FROM users WHERE id =?", array($_COOKIE['id']));
    if($query[0]['id'] !== $_COOKIE['id'])
    {
        setcookie("id", "", time() - 3600*24*30*12, "/");
        setcookie("hash", "", time() - 3600*24*30*12, "/");
        print "Хм, что-то не получилось";
    }
    else
    {
$user_ids = $query[0]['id'];
      if(isset($_POST['name']) AND isset($_POST['from']) AND isset($_POST['to'])){
      $name = $_POST['name'];
      $from = $_POST['from'];
      $to = $_POST['to'];


      $check = $DB->query("SELECT COUNT(*) FROM `track` WHERE user_id =? AND name=?", array($user_ids,$name));

        if($check[0]['COUNT(*)'] == 0){
                              $pieces1 = explode("/", $from);
              $pieces2 = explode("/", $to);

              $from = $pieces1[1].'-'.$pieces1[0].'-'.$pieces1[2];

              $to = $pieces2[1].'-'.$pieces2[0].'-'.$pieces2[2];

      $DB->query("INSERT INTO `track` (`id`, `user_id`, `name`, `fromT`, `toT`) VALUES (NULL, ?, ?, ?, ?)", array($user_ids,$name,$from,$to));
        }
      }
    ?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>OutSurfing</title>
    <link rel="stylesheet" href="profile.css" type="text/css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="MainStyles.css"/>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>

<body>
    <header style="height: auto; margin-top: 10px; background: none;">
        <ul style="margin-top: 35px;" id="navbar">
            <a href="login.php"><li>Login</li></a>
            <a href="register.php"><li>Register</li></a>
            <li><img src="logo.png" height="55px" width="55px"></li>
            <a href="#"><li>Account</li></a>
            <a href=""><li>Contact</li></a>
            <div id="line"></div>
        </ul>
    </header>
    <main>
        <div class="container">
            <div style="padding: 20px; background-color: rgba(0,0,0, 0.5);" class="card d-flex" style="max-width: 1200px;">
                <div class="row no-gutters">
                    <div class="col-md-4">
                        <img style="width: 100%" src="img/avatar.jpg" class="rounded-circle" alt="...">
                    </div>
                    <div class="col-md-8 d-flex align-items-center">
                        <div class="card-body d-flex flex-column align-items-center">
                            <?php
                                $user1 = $DB->query("SELECT * FROM `users` WHERE id=?",array($user_ids));
                               // print_r($user1[0]['name']);
                            ?>
                            <h5 class="card-title text-white"><?php echo $user1[0]['name']; ?></h5>
                            <p class="card-text text-white"><?php echo $user1[0]['city']; ?></p>
                            <p class="card-text"><small class="text-white">В мережі 3 хвилини тому</small></p>
                            <div>
                                <a class="text-white" style="font-size: 2em;" href=""><i class="fab fa-facebook-square"></i></a>
                                <a class="text-white" style="font-size: 2em;" href=""><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div style=" padding: 5px; margin-top: 20px; background-color: rgba(0,0,0, 0.5);" class="comments">
                <h3 class="title-comments text-white">Відгуки (0)</h3>


               
    </main>
    <footer class="d-flex justify-content-center bg-dark text-white">
        <p>Created by Web::chychka</p>
    </footer>
    <script>
        $(document).ready(function(){
            $("ul a:nth-child(1)").hover(function(){
               $("#line").css("margin-left", "3px"); 
            });
            $("ul a:nth-child(2)").hover(function(){
               $("#line").css("margin-left", "113px"); 
            });
            $("ul li:nth-child(3)").hover(function(){
               $("#line").css("margin-left", "223px"); 
            });
            $("ul a:nth-child(4)").hover(function(){
               $("#line").css("margin-left", "333px"); 
            });
            $("ul a:nth-child(5)").hover(function(){
               $("#line").css("margin-left", "443px"); 
            });
        });
    </script>

</body>

</html>

<?php
    }}
?>