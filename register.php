<html>
<head>
<title>site</title>
<META content="text/html; charset=utf-8" http-equiv="Content-Type">
<link href="style.css" rel="stylesheet" type="text/css" />

</head>

<body>

<?php if(file_exists('header.php')) include 'header.php'; ?>

<?php if(file_exists('menu.php')) include 'menu.php'; ?>


<div class="content">


<?php

if (!isset($_SESSION['username']))
{
if (!isset($_GET['as']))
{

?>
<table>
<tr>
<td style="vertical-align: top;">

<img src="who.png"/>

</td>
<td style="vertical-align: top;">
<span class="subtitle"> Вы хотите зарегистрироваться как: </span> <br/> <br/>

<a href="register.php?as=student" style="text-decoration:none;"><div style="float:none;"><div class="lightitem" style="width:250px;">Студент</div></div></a>
<a href="register.php?as=prepod" style="text-decoration:none;"><div style="float:none;"><div class="lightitem" style="width:250px;">Преподаватель</div></div></a>
<a href="register.php?as=user" style="text-decoration:none;"><div style="float:none;"><div class="lightitem" style="width:250px;">Обычный пользователь</div></div></a>

</td>
</tr>
</table>



<?php
	
}
else
{	

if (!isset($_POST['username']))
{
if ($_GET['as']=='student')
{
include('sregform.php');		
}
else if ($_GET['as']=='prepod')
{
include('pregform.php');		
}
else if ($_GET['as']=='user')
{
include('uregform.php');		
}
}
else
{
	
require_once('recaptchalib.php');
$privatekey = "6LeP3CITAAAAAF5gRYbhMiGMxoCxj9UxaPYze-m9";
$resp = recaptcha_check_answer ($privatekey,
							$_SERVER["REMOTE_ADDR"],
							$_POST["recaptcha_challenge_field"],
							$_POST["recaptcha_response_field"]);

if (!$resp->is_valid) 
{

$_GLOBALS['msg']='Символы с картинки введены не верно. Попробуйте ещё раз. <br>';
if ($_GET['as']=='student') include("sregform.php");
else if ($_GET['as']=='prepod') include("pregform.php"); else if ($_GET['as']=='user') include("uregform.php");

exit;

} 	




$tabla='student';

if ($_GET['as']=='student')
{


$tabla='students';


}
else if ($_GET['as']=='prepod')
{

$tabla='prepods';


}
else if ($_GET['as']=='user')
{

$tabla='users';


}





if ((strlen($_POST['username'])<6) || (strlen($_POST['password'])<6) || (strlen($_POST['password'])<3))
{
	
$_GLOBALS['msg']='Введите корректные данные. Логин и пароль должны быть не менее 6 символов.<br>';

if ($tabla=='students') include('sregform.php');
else if ($tabla=='prepods') include('pregform.php');
else if ($tabla=='users') include('uregform.php');
	
}
else if ($_POST['password']!=$_POST['rpassword'])
{
$_GLOBALS['msg']='Пароли не совпадают!<br>';

if ($tabla=='students') include('sregform.php');
else if ($tabla=='prepods') include('pregform.php');
else if ($tabla=='users') include('uregform.php');	
}
else
{

	
	
mysql_connect($hostname,$username,$password) OR DIE("Не могу создать соединение "); 
mysql_select_db($dbName) or die(mysql_error());  

$query=sprintf("SELECT username FROM students WHERE username='%s'",
mysql_real_escape_string($_POST['username']));	
$res = mysql_query($query); 
if (!$res)
{
echo '500 Internal Server Error';
exit;	
}
$number1 = mysql_num_rows($res); 
$query=sprintf("SELECT username FROM prepods WHERE username='%s'",
mysql_real_escape_string($_POST['username']));	
$res = mysql_query($query); 
if (!$res)
{
echo '500 Internal Server Error';
exit;	
}
$number2 = mysql_num_rows($res); 
$query=sprintf("SELECT username FROM users WHERE username='%s'",
mysql_real_escape_string($_POST['username']));	
$res = mysql_query($query); 
if (!$res)
{
echo '500 Internal Server Error';
exit;	
}
$number3 = mysql_num_rows($res); 

$query=sprintf("SELECT email FROM students WHERE email='%s'",
mysql_real_escape_string($_POST['email']));	
$res = mysql_query($query); 
if (!$res)
{
echo '500 Internal Server Error';
exit;	
} 
$number4 = mysql_num_rows($res); 
$query=sprintf("SELECT email FROM prepods WHERE email='%s'",
mysql_real_escape_string($_POST['email']));	
$res = mysql_query($query); 
if (!$res)
{
echo '500 Internal Server Error';
exit;	
}
$number5 = mysql_num_rows($res); 
$query=sprintf("SELECT email FROM users WHERE email='%s'",
mysql_real_escape_string($_POST['email']));	
$res = mysql_query($query); 
if (!$res)
{
echo '500 Internal Server Error';
exit;	
}
$number6 = mysql_num_rows($res); 

if ($number1>0 || $number2>0 || $number3>0)
{
$_GLOBALS['msg']='Такой логин уже зарегистрирован, выберите другой<br>';
if ($_GET['as']=='student') include('sregform.php');
else if ($_GET['as']=='prepod') include('pregform.php'); else if ($_GET['as']=='user') include('uregform.php');
exit;
}

if ($number4>0 || $number5>0 || $number6>0)
{
$_GLOBALS['msg']='Такой Email уже зарегистрирован, выберите другой<br>';
if ($_GET['as']=='student') include('sregform.php');
else if ($_GET['as']=='prepod') include('pregform.php'); else if ($_GET['as']=='user') include('uregform.php');
exit;
}
	
$hsh=md5(microtime(true));

$userstable = $tabla;
$query = sprintf("INSERT INTO $userstable (username, name, surname, lastname, password, email, confirmation, regtime) VALUES('%s','%s', '%s','%s','%s','%s','%s','%s')", mysql_real_escape_string($_POST['username']), mysql_real_escape_string($_POST['name']), mysql_real_escape_string($_POST['surname']), mysql_real_escape_string($_POST['lastname']), mysql_real_escape_string(md5($_POST['password'])), mysql_real_escape_string($_POST['email']), $hsh, (int)microtime(true)); 
mysql_query($query) or die(mysql_error()); 


$query=sprintf("SELECT id, username, password FROM $userstable WHERE username='%s'",
mysql_real_escape_string($_POST['username']));
$res = mysql_query($query); 
if (!$res)
{
echo '500 Internal Server Error';
exit;	
} 
$number = mysql_num_rows($res); 
$row=mysql_fetch_array($res);	

echo 'Вы успешно зарегистрировались. Ваш номер '.$row['id'].'. Сообщите этот номер администратору системы в  университете, чтобы он подтвердил вашу личность. Сейчас вы можете пользоваться системой в ограниченном режиме.<br>';


echo 'На указанный email выслано письмо. Пожалуйста, перейдите по ссылке, указанной в письме для завершения регистрации.';

$mailmsg="Кто-то (возможно вы) зарегистрировался на сайте students-lysva.ru. И указал данный Email. Если вы этого не делали, просто проигнорируйте это письмо. Если же это были вы, то пройдите по ссылке ниже для завершения регистрации.  http://students-lysva.ru/confirm.php?hash=$hsh";

mail($_POST['email'], "Регистрация на сайте Портфолио Студентов", $mailmsg);




}	
	
}	
}
}
else echo 'Сначала необходимо выйти из текущего аккаунта.';


?>


</div>

 
<?php if(file_exists('footer.php')) include 'footer.php'; ?>
 

 
</body>

</html>