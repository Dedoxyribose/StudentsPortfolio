﻿<html>
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
<span class="title"> Список кафедр </span> <br/> <br/>

<div class="list">

<?php if(file_exists('keys.php')) include 'keys.php'; 


$userstable = "departments"; 

mysql_connect($hostname,$username,$password) OR DIE("Не могу создать соединение"); 
mysql_select_db($dbName) or die(mysql_error());  
$query="SELECT `departments`.id as dep_id, `departments`.shortname as dep_sn, `univers`.shortname as u_sn FROM `departments`, `faculties`, `univers` WHERE `departments`.faculty=`faculties`.id AND `faculties`.univer=`univers`.id ORDER BY `univers`.id";
$res = mysql_query($query); 
if (!$res)
{
echo '500 Internal Server Error';
exit;	
}
$number = mysql_num_rows($res); 

if ($number!=0)
{	
echo '<table width="95%" style="border: 3px solid #444343;" rules="all">';
while ($row=mysql_fetch_array($res))
{
?>
<tr class="item" style="cursor: pointer; border: 3px solid #444343;" onclick="window.location.href='department.php?id=<?php echo $row['dep_id'];?>'; return false;"><td width="50%" style="cursor: pointer; border: 3px solid #444343;"><div class="paddeditem"><?php echo htmlspecialchars($row['dep_sn']);?></div></td><td style="cursor: pointer; border: 3px solid #444343;"><div  class="paddeditem"><?php echo htmlspecialchars($row['u_sn']);?></div></td></tr>
<?php
}

echo '</table>';
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