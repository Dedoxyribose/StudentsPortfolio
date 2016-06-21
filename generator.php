<html>
<head>
<title>site</title>
<META content="text/html; charset=utf-8" http-equiv="Content-Type">
<link href="style.css" rel="stylesheet" type="text/css" />

</head>

<body>




<div>


<?php if(file_exists('keys.php')) include 'keys.php'; 



mysql_connect($hostname,$username,$password) OR DIE("Не могу создать соединение"); 
mysql_select_db($dbName) or die(mysql_error());  
$query = sprintf("INSERT INTO `students` (surname, name, lastname, groupid) VALUES ('%s','%s','%s',1)", mysql_real_escape_string('Рыданных'), mysql_real_escape_string('Егорушка'), mysql_real_escape_string('Драсьте')); 

for ($i=0; $i<50; $i++) $res = mysql_query($query) or die(mysql_error()); 




?>



</div>





 
</body>

</html>