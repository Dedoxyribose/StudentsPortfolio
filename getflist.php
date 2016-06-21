
<?php if(file_exists('keys.php')) include 'keys.php'; 
session_start();

$userstable = $_GET['table'];
$field="";
$whatto="";



if ($userstable=='speciality') 
{
$userstable="groups";	
$field="speciality";
$whatto="code";
}
else if ($userstable=='department') 
{
$userstable="specialities";	
$field="department";
$whatto="shortname";
}
else if ($userstable=='faculty') 
{
$userstable="departments";	
$field="faculty";
$whatto="shortname";
}
else if ($userstable=='univer') 
{
$userstable="faculties";	
$field="univer";
$whatto="shortname";
}
else
{

echo '500 Internal Server Error';
exit;	

}


mysql_connect($hostname,$username,$password) OR DIE("Не могу создать соединение"); 
mysql_select_db($dbName) or die(mysql_error());  
$query=sprintf("SELECT id, $whatto FROM $userstable WHERE $field='%s'",
mysql_real_escape_string($_GET['val']));
$res = mysql_query($query); 
if (!$res)
{
echo '500 Internal Server Error';
exit;	
}
$number = mysql_num_rows($res); 

if ($number==0)
{	
//error
}


while ($row=mysql_fetch_array($res))
{

	echo '<option value="'.$row['id'].'" ';
	echo '>'.htmlspecialchars($row[$whatto]).'</option>';
	
	
}


?>