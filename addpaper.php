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


mysql_connect($hostname,$username,$password) OR DIE("Не могу создать соединение "); 
mysql_select_db($dbName) or die(mysql_error());  
$query=sprintf("SELECT * FROM students WHERE id='%s'", mysql_real_escape_string($_GET['by']));
$res = mysql_query($query); 
if (!$res)
{
echo '500 Internal Server Error';
exit;	
}
$number = mysql_num_rows($res);
$row=mysql_fetch_array($res);

$userstable = "papers"; 

if ($row['username']!=$_SESSION['username'])
{
$userstable = "fuckyourself"; 	
}


if (isset($_FILES['filename']['tmp_name']))
{
	
$query=sprintf("INSERT INTO papers (papername, papertype, subject, author) VALUES ('%s', '%s', '%s', '%s')", mysql_real_escape_string($_POST['papername']),mysql_real_escape_string($_POST['papertype']),mysql_real_escape_string($_POST['subject']), mysql_real_escape_string($_GET['by']));
$res = mysql_query($query); 
if (!$res)
{
echo '500 Internal Server Error';
exit;	
}

$query="SELECT * FROM papers ORDER BY id DESC";
$res = mysql_query($query); 
if (!$res)
{
echo '500 Internal Server Error';
exit;	
}
$number = mysql_num_rows($res);
$row=mysql_fetch_array($res);
	
	
	if($_FILES["filename"]["size"] > 1024*20*1024)
   {
     echo ("Размер файла превышает 20 мегабайт");
     exit;
   }
   // Проверяем загружен ли файл
   if(is_uploaded_file($_FILES["filename"]["tmp_name"]))
   {
     // Если файл загружен успешно, перемещаем его
     // из временной директории в конечную
     move_uploaded_file($_FILES["filename"]["tmp_name"], ROOT_DIR."/papers/".$row[0].'____'.$_FILES["filename"]["name"]);
	 
	 $query=sprintf("UPDATE papers SET filename='%s' WHERE id=".$row[0], mysql_real_escape_string("/papers/".$row[0].'____'.$_FILES["filename"]["name"]));
	 $res = mysql_query($query) or die(mysql_error()); 
	 
	
	?>
	
	<table>
<tr>
<td style="vertical-align:top; text-align:center;" >
<img src="paper.png" style="max-width: 321px;"><br>
</td>
<td style="vertical-align:top;" >


<?php
	 
	 echo '<span class="bigtext">Работа успешно загружена!</span><br>';
	 echo '<a href="paper.php?id='.$row[0].'" class="medtext" style="text-decoration:none; color: #303030;">Перейти к работе</a>';
	 
?>

</td>
</tr>
</table>

<?php
	 
   } else 
   {
      echo("Ошибка загрузки файла");
   }
	
}
else
{

?>

<table>
<tr>
<td style="vertical-align:top; text-align:center;" >

<?php

//echo '<div style="float: left; width: 35%;">';

echo '<img src="paper.png" style="max-width: 321px;"><br>';

//echo '</div>';

if ($_SESSION['username']==$row['username'])
{

/*echo '<div class="lightitem" onclick="FindFile();" style="text-align:center; width: 240px; margin:auto; cursor: pointer;">Загрузить фото</div><br>';	

if (file_exists(ROOT_DIR.$row['photo'])  && $row['photo']!="")
{
echo '<a href="student.php?act=deletephoto&&id='.$_GET['id'].'" style="text-decoration:none;"><div class="lightitem" style="text-align:center; width: 240px; margin:auto; cursor: pointer;">Удалить фото</div></a>';
}*/
	
}

?>

</td>

<td width="100%" style="vertical-align: top;">


<span class="bigtext">Добавить работу</span><br><br>
<form method="post" action="addpaper.php?by=<?php echo $_GET['by']; ?>" class="medtext" enctype="multipart/form-data">
<table style="margin-top:10px; border-spacing: 15px" class="medtext">
  <tr>
    <td>Название работы, тема: </td>
	<td> <input name="papername" type="text" maxlength="50" size="25" value="" /></td>
  </tr>
    <tr>
	 <td >Тип работы: </td>
	<td> <input name="papertype" type="text" maxlength="50" size="25" value="" /></td>
  </tr> 
  <tr>
	 <td>Предмет: </td>
	<td> <input name="subject" type="text" maxlength="70" size="25" value="" /></td>
  </tr> 
  <tr>
	 <td>Выберите файл: </td>
	<td> <input name="filename" type="file"  value="" /></td>
  </tr> 
  <tr>
  <td>
  </td>
  <td class="medtext" style="text-align:right;">
  <input type="submit" name="log" value="Загрузить работу" />
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