
<?php if(file_exists('keys.php')) include 'keys.php'; 
session_start();

include ('auth.php'); //обновление полей SESSION

$userstable="";
$tlist = array("users", "prepods", "students"); 
foreach ($tlist as $el)
{
	if ($el==$_GET['table'])
	{
	$userstable=$_GET['table'];
	break;
	}
}
if ($userstable=="")
{
header('HTTP/1.1 501 Not Implemented');
exit;
}

$field="";
$flist = array("surname", "name", "lastname", "groupid", "email", "department", "organisation", "position"); 
foreach ($flist as $el)
{
	if ($el==$_GET['field'])
	{
	$field=$_GET['field'];
	break;
	}
}
if ($field=="")
{
header('HTTP/1.1 501 Not Implemented');
exit;
}



mysql_connect($hostname,$username,$password) OR DIE("Не могу создать соединение"); 
mysql_select_db($dbName) or die(mysql_error());  
$query=sprintf("SELECT id, username FROM $userstable WHERE id='%s'", mysql_real_escape_string($_GET['id']));
$res = mysql_query($query); 
if (!$res)
{
header('HTTP/1.1 500 Internal Server Error');
exit;	
}
$number = mysql_num_rows($res); 

if ($number==0)
{	
header('HTTP/1.1 501 Not Implemented');
exit;
}


$row=mysql_fetch_array($res);


if ($row['username']!=$_SESSION['username'] && ($_SESSION['moder']!=1 && $_SESSION['moder']!=2))
{
header('HTTP/1.1 403 Forbidden');
exit;
}
else
{
$query=sprintf("UPDATE $userstable SET ".$field."='%s' WHERE id='%s';",
mysql_real_escape_string($_GET['val']), mysql_real_escape_string($_GET['id']));
$res = mysql_query($query); 
if (!$res)
{
header('HTTP/1.1 500 Internal Server Error');
exit;	
}	
}

?>