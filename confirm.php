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


if(file_exists('keys.php')) include 'keys.php';

 
mysql_connect($hostname,$username,$password) OR DIE("Не могу создать соединение "); 
mysql_select_db($dbName) or die(mysql_error());  

$userstable = "students";
$query=sprintf("SELECT * FROM $userstable WHERE confirmation='%s'",
mysql_real_escape_string($_GET['hash']));
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
$query=sprintf("SELECT * FROM $userstable WHERE confirmation='%s'",
mysql_real_escape_string($_GET['hash']));
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
$query=sprintf("SELECT * FROM $userstable WHERE confirmation='%s'",
mysql_real_escape_string($_GET['hash']));
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
echo 'Ссылка недействительна';
exit;
}


$query=sprintf("UPDATE $userstable SET confirmation=1 WHERE confirmation='%s'",
mysql_real_escape_string($_GET['hash']));
$res = mysql_query($query); 
if (!$res)
{
echo '500 Internal Server Error';
exit;	
}

echo 'Аккаунт подтверждён! Теперь вы можете войти в систему.';


?>



<?php





?>

</div>

 
 
</body>

</html>