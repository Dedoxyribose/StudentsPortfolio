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

if(!isset($_SESSION['username']))
{
echo 'Вы не <a href="login.php" style="color: #000000;">вошли</a> в систему.';	
}
else
{
	
mysql_connect($hostname,$username,$password) OR DIE("Не могу создать соединение "); 
mysql_select_db($dbName) or die(mysql_error());  
	
if ($_SESSION['usertype']=='student')
{
$userstable = "students"; 



$query=sprintf("SELECT id, name, surname, lastname, username, password, verif FROM $userstable WHERE username='%s'",
mysql_real_escape_string($_SESSION['username']));
$res = mysql_query($query); 
if (!$res)
{
echo '500 Internal Server Error';
exit;	
} 
$number = mysql_num_rows($res);
$row=mysql_fetch_array($res); 



/*if ($row['verif']==0)
{
echo 'Ваш аккаунт не подтверждён. Обратитесь к администратору системы в своём университете';
}
else if ($row['verif']==2)
{
echo 'Ваш аккаунт был отклонён модератором.';
}
else
{
echo $row['surname'].' '.$row['name'].' '.$row['lastname'];
echo '<br>';
echo '<a href="student.php?id='.$row['id'].'">Перейти к анкете.</a>';
}*/





}
else if ($_SESSION['usertype']=='prepod')
{
	
$userstable = "prepods"; 



$query=sprintf("SELECT id, name, surname, lastname, username, password, verif FROM $userstable WHERE username='%s'",
mysql_real_escape_string($_SESSION['username']));
$res = mysql_query($query); 
if (!$res)
{
echo '500 Internal Server Error';
exit;	
}
$number = mysql_num_rows($res);
$row=mysql_fetch_array($res); 


	
}
else if ($_SESSION['usertype']=='user')
{
	
$userstable = "users"; 



$query=sprintf("SELECT id, name, surname, lastname, username, password, verif FROM $userstable WHERE username='%s'",
mysql_real_escape_string($_SESSION['username']));
$res = mysql_query($query); 
if (!$res)
{
echo '500 Internal Server Error';
exit;	
}
$number = mysql_num_rows($res);
$row=mysql_fetch_array($res); 


	
}


?>

<table>
<tr>
<td style="vertical-align: top;">

<?php



if ($_SESSION['usertype']=="prepod") echo '<img src="prepod.png"/>';
else echo '<img src="user.png"/>';


?>

</td>
<td style="vertical-align: top;">


<?php


echo '<div class="subtitle">'.htmlspecialchars($row['surname']).' '.htmlspecialchars($row['name']).' '.htmlspecialchars($row['lastname']).'.</div>';



echo '<a href="login.php?exit=1" style="text-decoration:none;"><div style="float:none;"><div class="lightitem" style="width:250px;">Выйти из аккаунта</div></div></a>';

if ($_SESSION['usertype']=='student')
{
echo '<a href="student.php?id='.$row['id'].'" style="text-decoration:none;"><div style="float:none;"><div class="lightitem" style="width:250px;">Перейти к моей анкете</div></div></a>';
}
else if ($_SESSION['usertype']=='prepod')
{
echo '<a href="prepod.php?id='.$row['id'].'" style="text-decoration:none;"><div style="float:none;"><div class="lightitem" style="width:250px;">Перейти к моей анкете</div></div></a>';
}
else if ($_SESSION['usertype']=='user')
{
echo '<a href="theuser.php?id='.$row['id'].'" style="text-decoration:none;"><div style="float:none;"><div class="lightitem" style="width:250px;">Перейти к моей анкете</div></div></a>';
}

}

?>

</td>
</tr>
</table>



</div>

 
<?php if(file_exists('footer.php')) include 'footer.php'; ?>
 

 
</body>

</html>