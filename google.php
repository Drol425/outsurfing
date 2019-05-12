<?php
include('dbcon.php');
$client_id = '1005797351768-ai04itde1hce5d8d3bksmt4oodlgisf1.apps.googleusercontent.com'; // Id приложения 18 40 
$client_secret = 'p6rTCJWdY8NDnEj-zS5XsG-Z'; 
$redirect_uri = 'http://looking.lk3.ru/google.php'; // Redirect URIs

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
 $link = '<p><a href="' . $url . '?' . urldecode(http_build_query($params)) . '">Аутентификация через Google</a></p>';
if (isset($_GET['code'])) {
    $result = false;

    $params = array(
        'client_id'     => $client_id,
        'client_secret' => $client_secret,
        'redirect_uri'  => $redirect_uri,
        'grant_type'    => 'authorization_code',
        'code'          => $_GET['code']
    );

    $url = 'https://accounts.google.com/o/oauth2/token';

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, urldecode(http_build_query($params)));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($curl);
    curl_close($curl);
    $tokenInfo = json_decode($result, true);

    if (isset($tokenInfo['access_token'])) {
        $params['access_token'] = $tokenInfo['access_token'];

        $userInfo = json_decode(file_get_contents('https://www.googleapis.com/oauth2/v1/userinfo' . '?' . urldecode(http_build_query($params))), true);
        if (isset($userInfo['id'])) {
            $userInfo = $userInfo;
            $result = true;
        }
    }

    if ($result) {
                $email_user = $userInfo['email'];
                $hash = md5(generateCode(10));
        $query =  $DB->query("SELECT COUNT(id) FROM users WHERE login=?", array($email_user));
        $login = $userInfo['email'];
        $name = $userInfo['name'];
        $password = generateCode();
        //print_r($query);
            if($query[0]['COUNT(id)'] == 0){
                //echo 'Insert';
                
                   //$DB->query("INSERT INTO users(id,login,password) VALUES(?,?,?)", array(null,$login, $userInfo['id']));
                 $DB->query("INSERT INTO users(id,login,password,name,`age`, `description`, `img`, `city`) VALUES(?,?,?,?,?,?,?,?)", array(null,$login,$password,$name,'','Дуже люблю подорожувати. Якщо хочете то заходбте до мене до дому','','Харков'));
                  $last = $DB->lastInsertId();
                            setcookie("id", $last, time()+60*60*24*30);
                            setcookie("hash", $hash, time()+60*60*24*30,null,null,null,true);
                            header("Location: profil.php");
                             exit();

            }else{
                //echo 'UPDATE';
                
                $query11 =  $DB->query("SELECT id FROM users WHERE login=?", array($email_user));
                            setcookie("id", $query11[0]['id'], time()+60*60*24*30);
                            setcookie("hash", $hash, time()+60*60*24*30,null,null,null,true);
                            header("Location: profil.php");
                             exit();
            }
       /* echo "Социальный ID пользователя: " . $userInfo['id'] . '<br />';
        echo "Имя пользователя: " . $userInfo['name'] . '<br />';
        echo "Email: " . $userInfo['email'] . '<br />';
        echo "Ссылка на профиль пользователя: " . $userInfo['link'] . '<br />';
        echo "Пол пользователя: " . $userInfo['gender'] . '<br />';
        echo '<img src="' . $userInfo['picture'] . '" />'; echo "<br />";*/
        //$insip = ", user_ip=INET_ATON('".$_SERVER['REMOTE_ADDR']."')";
        //$DB->query("UPDATE users SET user_hash=? ".$insip." WHERE user_login=?",array($hash, $login));
        // Ставим куки
        //$query_coc =  $DB->query("SELECT user_id FROM users WHERE user_login=?", array($email_user));
    }

}
echo $link;
?>
</body>
</html>