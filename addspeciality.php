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

 <script>
var sID=<?php echo $_GET['id'];?>
</script>


<?php

define('ROOT_DIR', dirname(__FILE__));

if(file_exists('keys.php')) include 'keys.php';

if (!($_SESSION['moder']>0))
{
exit;	
}


mysql_connect($hostname,$username,$password) OR DIE("Не могу создать соединение "); 
mysql_select_db($dbName) or die(mysql_error());  



if (isset($_POST['fullname']))
{
	
$query=sprintf("INSERT INTO specialities (fullname, shortname, code, department) VALUES ('%s','%s','%s','%s')", mysql_real_escape_string($_POST['fullname']),mysql_real_escape_string($_POST['shortname']),mysql_real_escape_string($_POST['code']), mysql_real_escape_string($_GET['id']));
$res = mysql_query($query); 
if (!$res)
{
echo '500 Internal Server Error';
exit;	
}

$query="SELECT * FROM specialities ORDER BY id DESC";
$res = mysql_query($query); 
if (!$res)
{
echo '500 Internal Server Error';
exit;	
}
$number = mysql_num_rows($res);
$row=mysql_fetch_array($res);
	
	
	
	?>
	
	<table>
<tr>
<td style="vertical-align:top; text-align:center;" >
<img src="city3.png" style="max-width: 321px;"><br>
</td>
<td style="vertical-align:top;" >


<?php
	 
	 echo '<span class="bigtext">Направление создано!</span><br>';
	 echo '<a href="speciality.php?id='.$row[0].'" class="medtext" style="text-decoration:none; color: #303030;">Перейти к направлению</a>';
	 
?>

</td>
</tr>
</table>

<?php
	 
   
	
}
else
{

?>

<table>
<tr>
<td style="vertical-align:top; text-align:center;" >

<?php

//echo '<div style="float: left; width: 35%;">';

echo '<img src="city3.png" style="max-width: 321px;"><br>';

//echo '</div>';



?>

</td>

<td width="100%" style="vertical-align: top;">


<span class="bigtext">Добавить направление</span><br><br>
<form method="post" action="addspeciality.php?id=<?php echo $_GET['id']; ?>" class="medtext" enctype="multipart/form-data">
<table style="margin-top:10px; border-spacing: 15px" class="medtext">
  <tr>
    <td>Полное название: </td>
	<td> <input name="fullname" type="text" maxlength="20" size="25" value="" /></td>
  </tr>
  <tr>
	<td>Краткое название: </td>
	<td> <input name="shortname" type="text" maxlength="20" size="25" value="" /></td>
  </tr> 
   <tr>
	<td>Код: </td>
	<td> <input name="code" type="text" maxlength="20" size="25" value="" /></td>
  </tr> 
  <tr>
  <td>
  </td>
  <td class="medtext" style="text-align:right;">
  <input type="submit" name="log" value="Добавить" />
  </td>
  </tr>
</table>
</form>

</td>

</table>


<?php	
	
}

?>

</div>
 
</body>

</html>