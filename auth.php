<?php

if(file_exists('keys.php')) include 'keys.php'; 
session_start();



if(isset($_COOKIE['sessionid']) && $_COOKIE['sessionid']!="")
{
	


mysql_connect($hostname,$username,$password) OR DIE("Не могу создать соединение "); 
mysql_select_db($dbName) or die(mysql_error());  

$userstable = "students"; 
$type = "student"; 
$query=sprintf("SELECT * FROM $userstable WHERE sessionid='%s'",
mysql_real_escape_string($_COOKIE['sessionid']));
$res = mysql_query($query) or die(mysql_error()); 
$number = mysql_num_rows($res); 

if ($number==0)
{
	
$userstable = "prepods"; 
$type = "prepod"; 
$query=sprintf("SELECT * FROM $userstable WHERE sessionid='%s'",
mysql_real_escape_string($_COOKIE['sessionid']));
$res = mysql_query($query) or die(mysql_error()); 
$number = mysql_num_rows($res);

}

if ($number==0)
{
	
$userstable = "users"; 
$type = "user"; 
$query=sprintf("SELECT * FROM $userstable WHERE sessionid='%s'",
mysql_real_escape_string($_COOKIE['sessionid']));
$res = mysql_query($query) or die(mysql_error()); 
$number = mysql_num_rows($res);

}

$row=mysql_fetch_array($res);	

if ($number==0)
{
$aresult=2;
}
else if ($_SERVER['HTTP_USER_AGENT']==$row['useragent'] && $_SERVER['HTTP_USER_AGENT']!="")
{
$_SESSION['username']=$row['username'];
$_SESSION['moder']=$row['moder'];
$_SESSION['verif']=$row['verif'];
$_SESSION['usertype'] = $type;
$_SESSION['auth']=1;
}
else
{
$aresult=2;
}
}
else
{
$aresult=2;
}

if ($aresult==2)
{
$_SESSION['username']="";
unset($_SESSION['username']);
$_SESSION['auth']=0;
$_SESSION['moder']=0;
$_SESSION['verif']=0;	
}


?>