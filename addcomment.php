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

if (!isset($_SESSION['username']) || $_SESSION['username']=="")
{
echo '403 Forbidden';
exit;	
}


mysql_connect($hostname,$username,$password) OR DIE("Не могу создать соединение "); 
mysql_select_db($dbName) or die(mysql_error());  
$query=sprintf("SELECT * FROM prepods WHERE username='%s'", mysql_real_escape_string($_SESSION['username']));
$res = mysql_query($query); 
if (!$res)
{
echo '500 Internal Server Error';
exit;	
}
$number = mysql_num_rows($res);

if ($number==0)
{
$query=sprintf("SELECT * FROM users WHERE username='%s'", mysql_real_escape_string($_SESSION['username']));
$res = mysql_query($query); 
if (!$res)
{
echo '500 Internal Server Error';
exit;	
}
$number = mysql_num_rows($res);	
}

$row=mysql_fetch_array($res);

if ($row['verif']!=1)
{
exit;	
}

$userstable = "comments"; 

if (isset($_FILES['filename']['tmp_name']))
{
	
$query=sprintf("INSERT INTO comments (commenttitle, forpaper, author) VALUES ('%s', %s, '%s')", mysql_real_escape_string($_POST['commenttitle']),mysql_real_escape_string($_GET['forpaper']),mysql_real_escape_string($row['username']));
$res = mysql_query($query); 
if (!$res)
{
echo '500 Internal Server Error';
exit;	
}

$query="SELECT * FROM comments ORDER BY id DESC";
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
     move_uploaded_file($_FILES["filename"]["tmp_name"], ROOT_DIR."/comments/".$row[0].'____'.$_FILES["filename"]["name"]);
	 
	 $query=sprintf("UPDATE comments SET filename='%s' WHERE id='%s'", mysql_real_escape_string("/comments/".$row[0].'____'.$_FILES["filename"]["name"]), mysql_real_escape_string($row[0]));
	 $res = mysql_query($query); 
	if (!$res)
	{
	echo '500 Internal Server Error';
	exit;	
	}
	 
	
	?>
	
	<table>
<tr>
<td style="vertical-align:top; text-align:center;" >
<img src="paper.png" style="max-width: 321px;"><br>
</td>
<td style="vertical-align:top;" >


<?php
	 
	 echo '<span class="bigtext">Отзыв успешно загружен!</span><br>';
	 echo '<a href="comment.php?id='.$row[0].'" class="medtext" style="text-decoration:none; color: #303030;">Перейти к отзыву</a>';
	 
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


<span class="bigtext">Добавить отзыв</span><br><br>
<form method="post" action="addcomment.php?forpaper=<?php echo $_GET['forpaper']; ?>" class="medtext" enctype="multipart/form-data">
<table style="margin-top:10px; border-spacing: 15px" class="medtext">
  <tr>
    <td>Заголовок: </td>
	<td> <input name="commenttitle" type="text" maxlength="20" size="25" value="" /></td>
  </tr>
  <tr>
	 <td>Выберите файл: </td>
	<td> <input name="filename" type="file" maxlength="20" size="25" value="" /></td>
  </tr> 
  <tr>
  <td>
  </td>
  <td class="medtext" style="text-align:right;">
  <input type="submit" name="log" value="Загрузить отзыв" />
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