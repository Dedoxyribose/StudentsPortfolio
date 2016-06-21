<div class="header">

<?php

if(file_exists('keys.php')) include 'keys.php'; 
session_start();

include('auth.php');
  
  ?>



<img src="logo.png" style="float: left;">


<div class="sitetitle">

Портфолио студентов

</div>


<?php 


$userstable = "params"; 

mysql_connect($hostname,$username,$password) OR DIE("Не могу создать соединение "); 
mysql_select_db($dbName) or die(mysql_error());  
$query=sprintf("SELECT stringval FROM $userstable WHERE name='%s'",
mysql_real_escape_string('univerlogo'));
$res = mysql_query($query); 
if (!$res)
{
echo '500 Internal Server Error';
exit;	
}
$number = mysql_num_rows($res); 

$number = mysql_num_rows($res); 

if ($number!=0)
{	
$row=mysql_fetch_array($res);
//echo 's'.$row['stringval'];
echo '<img src="'.$row['stringval'].'" style="float:right;">';
}





?>

</div>