Habits tracker

	 Google oauth - API 

	 Category: трекер (трекер звичок);

Install:

download this repository. 

Create database MySql and import sql file - h6072_diplo.sql

change file dbcon.php 

	define('DBHost', 'localhost');
	define('DBName', '');
	define('DBUser', '');
	define('DBPassword', '');


change variable in file google.php and login.php

$client_id = ''; 
$client_secret = ''; 
$redirect_uri = ''; 

