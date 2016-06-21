<html>
<head>
<title>site</title>
<META content="text/html; charset=utf-8" http-equiv="Content-Type">
<link href="style.css" rel="stylesheet" type="text/css" />

</head>

<body>


<?php

$result=-1;

if(file_exists('keys.php')) include 'keys.php'; 

session_start();
if((!isset($_POST['log'])) && (!isset($_GET['exit'])))
{
	


if(file_exists('logform.php') && (!isset($_SESSION['username']) || $_SESSION['username']=="")) $result=0;
	
}
else if (isset($_POST['log']) && (!isset($_SESSION['username'])))
{

require_once('recaptchalib.php');
$privatekey = "6LeP3CITAAAAAF5gRYbhMiGMxoCxj9UxaPYze-m9";
$resp = recaptcha_check_answer ($privatekey,
							$_SERVER["REMOTE_ADDR"],
							$_POST["recaptcha_challenge_field"],
							$_POST["recaptcha_response_field"]);

if (!$resp->is_valid) 
{

echo '<span style="color:red;">Символы с картинки введены не верно. Попробуйте ещё раз.</span>';
include('logform.php');
exit;

} 

function encrypt_blowfish($data,$key){
    $crypttext = mcrypt_encrypt(MCRYPT_BLOWFISH, $key, $data, MCRYPT_MODE_ECB);
    return bin2hex($crypttext);
}




mysql_connect($hostname,$username,$password) OR DIE("Не могу создать соединение "); 
mysql_select_db($dbName) or die(mysql_error());  

$userstable = "students"; 
$usertype = "student"; 
$query=sprintf("SELECT * FROM $userstable WHERE username='%s'",
mysql_real_escape_string($_POST['username']));
$res = mysql_query($query); 
if (!$res)
{
echo '500 Internal Server Error';
exit;	
}
$number = mysql_num_rows($res); 



if ($number==0)
{
$userstable = "prepods"; 
$usertype = "prepod"; 
$query=sprintf("SELECT * FROM $userstable WHERE username='%s'",
mysql_real_escape_string($_POST['username']));
$res = mysql_query($query); 
if (!$res)
{
echo '500 Internal Server Error';
exit;	
}
$number = mysql_num_rows($res); 
}

if ($number==0)
{
$userstable = "users"; 
$usertype = "user"; 
$query=sprintf("SELECT * FROM $userstable WHERE username='%s'",
mysql_real_escape_string($_POST['username']));
$res = mysql_query($query); 
if (!$res)
{
echo '500 Internal Server Error';
exit;	
}
$number = mysql_num_rows($res); 
}

if ($number==0)
{
$result=1;
}
else
{
	
	$row=mysql_fetch_array($res);

		
	$got=substr($_POST['fpassword'],0,64);
	
	$encrpass=encrypt_blowfish($row['password'], $_SESSION['salt']);
	
	/*echo 'Пришло: '.$got.'<br>';
	echo 'Зашифровали: '.$encrpass.'<br>';
	//echo 'Зашифровали md5: '.md5($row['password']).'<br>';
	echo 'Соль: '.$_SESSION['salt'].'<br>';*/
	
	$hsh=md5(microtime(true));
	
	$query=sprintf("UPDATE $userstable SET sessionid='%s', useragent='%s' WHERE username='%s'",
	mysql_real_escape_string($hsh), mysql_real_escape_string($_SERVER['HTTP_USER_AGENT']), mysql_real_escape_string($_POST['username']));
	$res = mysql_query($query) or die(mysql_error()); 
	
	
	if ($got==$encrpass)
	{
	
	$_SESSION['username'] = $row['username'];
	$_SESSION['name'] = $row['surname'].' '.$row['name'];
	$_SESSION['moder'] = 0;
	$_SESSION['usertype'] = $usertype;
	$_SESSION['verif'] = $row['verif'];
	setcookie("sessionid", $hsh, time() + 60000);
	$result=3;

	
	}
	else $result=2;
	
}





mysql_close(); 


}
else if (($_GET['exit']==1) && (isset($_SESSION['username'])))
{
	
unset($_SESSION['username']);
unset($_SESSION['moder']);
unset($_SESSION['verif']);
setcookie("sessionid");
session_destroy();
$_COOKIE['sessionid']="";
unset($_COOKIE['sessionid']);
$result=7;
	
}


?>

<?php if(file_exists('header.php')) include 'header.php'; ?>

<?php if(file_exists('menu.php')) include 'menu.php'; ?>
 

<div class="content">


<div style="font-size: 16pt;float: left; width: 31%; margin-right: 4%">

<?php 

if ($result==0)
{
 if(file_exists('logform.php')) include 'logform.php'; 
}
else if ($result==1)
{
echo '<div class="utext">Такого пользователя не зарегистрировано</div> <br><br>';
 if(file_exists('logform.php')) include 'logform.php'; 
}
else if ($result==2)
{
echo '<div class="utext">Неверный пароль </div><br><br>';
 if(file_exists('logform.php')) include 'logform.php';
}
else if ($result==3)
{
echo '<div class="utext">Вы успешно вошли в систему.</div>';
}
else if ($result==4)
{
echo '<div class="utext">Имя пользователя и пароль должны быть не менее 3 символов. </div><br><br>';
 if(file_exists('logform.php')) include 'logform.php'; 
}
else if ($result==7)
{
echo '<div class="utext">Вы вышли из системы.</div>';
}


?>

</div>
 
 
 
<?php if(file_exists('footer.php')) include 'footer.php'; ?>
</body>

</html>