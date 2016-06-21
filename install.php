<html>
<head>
<title>site</title>
<META content="text/html; charset=utf-8" http-equiv="Content-Type">
<link href="style.css" rel="stylesheet" type="text/css" />

</head>

<body>

<?php if(file_exists('header.php')) include 'header.php'; ?>

<?php if(file_exists('menu.php')) include 'menu.php'; ?>

 
<?php if(file_exists('footer.php')) include 'footer.php'; ?>
 
<div class="content">

<?php


if(file_exists('keys.php')) include 'keys.php';



mysql_connect($hostname,$username,$password) OR DIE("Не могу создать соединение "); 

$query="CREATE TABLE students "

$res = mysql_query($query); 
if (!$res)
{
echo 'HTTP/1.1 500 Internal Server Error';
exit;	
}

echo 'База успешно создана. Теперь удалите файл install.php и пользуйтесь системой. Войти можно под пользователем admin, пароль sonyxperia';

?>

</div>
 
</body>

</html>