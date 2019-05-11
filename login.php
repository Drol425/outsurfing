<?
header('Content-Type: text/html; charset=utf-8');
// Страница авторизации
//print_r($_POST);
// Функция для генерации случайной строки
// Соединямся с БД
include('dbcon.php');
$client_id = '948483935886-upovbebo5k0e7jvr8f4n30qv9rhf3len.apps.googleusercontent.com'; // Id приложения 18 40 
$client_secret = 'oQEL1F_k_ARYWNCVQexpXzzE'; 
$redirect_uri = 'http://diplom.lk3.ru/google.php'; // Redirect URIs

$url = 'https://accounts.google.com/o/oauth2/auth';

$params = array(
    'redirect_uri'  => $redirect_uri,
    'response_type' => 'code',
    'client_id'     => $client_id,
    'scope'         => 'https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile'
);
function generateCode($length=6) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";
    $code = "";
    $clen = strlen($chars) - 1;
    while (strlen($code) < $length) {
            $code .= $chars[mt_rand(0,$clen)];
    }
    return $code;
}

if(isset($_POST['submit']))
{
    // Вытаскиваем из БД запись, у которой логин равняеться введенному
    //$query = mysqli_query($db,"SELECT user_id, user_password FROM users WHERE user_login='".mysqli_real_escape_string($db,$_POST['login'])."' LIMIT 1");
    //$data = mysqli_fetch_assoc($query);
    $query = $DB->query("SELECT id,password FROM users WHERE login=?", array($_POST['login']));

    // Сравниваем пароли
    if($query[0]['password'] === md5(md5($_POST['password'])))
    {
        // Генерируем случайное число и шифруем его
        $hash = md5(generateCode(10));

        if(!empty($_POST['not_attach_ip']))
        {
            // Если пользователя выбрал привязку к IP
            // Переводим IP в строку
            $insip = ", user_ip=INET_ATON('".$_SERVER['REMOTE_ADDR']."')";
        }

        // Записываем в БД новый хеш авторизации и IP
        //mysqli_query($db, "UPDATE users SET user_hash='".$hash."' ".$insip." WHERE user_id='".$data['user_id']."'");

        // Ставим куки
        setcookie("id", $query[0]['id'], time()+60*60*24*30);
        setcookie("hash", $hash, time()+60*60*24*30,null,null,null,true); // httponly !!!

        // Переадресовываем браузер на страницу проверки нашего скрипта
        header("Location: profil.php"); exit();
    }
    else
    {
        print "Вы ввели неправильный логин/пароль";
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
   <link rel="stylesheet" href="login--signup.css"/>
   <link href="https://fonts.googleapis.com/css?family=Josefin+Sans" rel="stylesheet">
   <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
   </head>
<body>

   <p>
       <a href="/"><span style="font-size:20px">&larr;</span> Back to Home</a>
   </p>
       <form method="POST">
           <img src="logo.png" alt=""/>
           <div id="inputs">
               <input type="email" name="login" placeholder="Email" required/><br/>
               <input type="password" name="password" placeholder="Password" required/><br/>
               <div style="display:none;" id="map"></div>
               <div id="helper_sub">
                    <div id="help_info">
                            <a href="">Lost your password?</a><br/>
                            <a href="signup.html">Don't have account?</a>
                            </div>
                   <input type="submit" name="submit" placeholder="Submit" required/><br/>
               </div>
           </div>
       </form><br><br><br>

   <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
</body>
</html>
