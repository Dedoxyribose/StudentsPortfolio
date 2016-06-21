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

<div style="float: left; width: 35%;">

<img src="city3.png" style="width: 100%;">

</div>

<div style="float: left; width: 65%;">
<span class="title"> Список университетов </span> <br/> <br/>

<?php
if ($_SESSION['moder']>0)
{


echo '<a href="adduniver.php" style="text-decoration:none;"><div class="lightitem" style="text-align:center; width: 240px; margin:auto; cursor: pointer;">Добавить университет</div></a>';


	
}
?>

<div class="list">

<?php if(file_exists('keys.php')) include 'keys.php'; 


$userstable = "univers"; 

mysql_connect($hostname,$username,$password) OR DIE("Не могу создать соединение"); 
mysql_select_db($dbName) or die(mysql_error());  
$query="SELECT id, fullname, shortname FROM $userstable";
$res = mysql_query($query); 
if (!$res)
{
echo '500 Internal Server Error';
exit;	
}
$number = mysql_num_rows($res); 

if ($number!=0)
{	
while ($row=mysql_fetch_array($res))
{
echo '<a href="univer.php?id='.$row['id'].'" style="text-decoration:none;"><div class="item">'.htmlspecialchars($row['shortname']).'</div></a>';
}
}
else
{
echo 'База данных пуста.';	
}


?>

</div>

</div>



</div>

 
<?php if(file_exists('footer.php')) include 'footer.php'; ?>
 

 
</body>

</html>