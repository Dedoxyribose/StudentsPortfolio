
<?php if(file_exists('keys.php')) include 'keys.php'; 
session_start();

include ('auth.php');

$userstable = 'notes'; 

$field="";
$flist = array("notetitle", "notetext"); 
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
$query=sprintf("SELECT * FROM notes, prepods WHERE `notes`.id='%s' AND `notes`.author=`prepods`.username", mysql_real_escape_string($_GET['id']));
$res = mysql_query($query); 
if (!$res)
{
header('HTTP/1.1 500 Internal Server Error');
exit;	
} 
$number = mysql_num_rows($res);

if ($number==0)
{
$query=sprintf("SELECT * FROM notes, users WHERE `notes`.id=%s AND `users`.username=`notes`.author",
mysql_real_escape_string($_GET['id']));
$res = mysql_query($query); 
if (!$res)
{
header('HTTP/1.1 500 Internal Server Error');
exit;	
} 
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
$res = mysql_query($query) or die(mysql_error());	
}

?>