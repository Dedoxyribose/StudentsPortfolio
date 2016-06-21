<html>
<head>
<title>site</title>
<META content="text/html; charset=utf-8" http-equiv="Content-Type">
<link href="style.css" rel="stylesheet" type="text/css" />

</head>

<body>

<?php if(file_exists('header.php')) include 'header.php'; ?>

<?php if(file_exists('menu.php')) include 'menu.php'; ?>

<div class="content">

<div style="font-size: 16pt;float: left; width: 31%; margin-right: 4%">

<?php if(file_exists('keys.php')) include 'keys.php'; 


$userstable = "specialities"; 

mysql_connect($hostname,$username,$password) OR DIE("Не могу создать соединение"); 
mysql_select_db($dbName) or die(mysql_error());  

if (isset($_POST['fullname']) && $_SESSION['moder']>0)
{
$query=sprintf("UPDATE $userstable SET fullname='%s', shortname='%s', code='%s' WHERE id='%s'",
mysql_real_escape_string($_POST['fullname']), mysql_real_escape_string($_POST['shortname']), mysql_real_escape_string($_POST['code']), mysql_real_escape_string($_GET['id']));
$res = mysql_query($query); 
if (!$res)
{
echo '500 Internal Server Error';
exit;	
}
}


$query=sprintf("SELECT id, fullname, shortname, code, department FROM $userstable WHERE id='%s'",
mysql_real_escape_string($_GET['id']));
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
$row=mysql_fetch_array($res);



$userstable = "departments"; 


$query=sprintf("SELECT id, fullname, shortname, faculty FROM $userstable WHERE id='%s'",
mysql_real_escape_string($row['department']));
$dres = mysql_query($query); 
if (!$dres)
{
echo '500 Internal Server Error';
exit;	
}
$dnumber = mysql_num_rows($dres); 

if ($dnumber==0)
{	
//error
}
$drow=mysql_fetch_array($dres);


$userstable = "faculties"; 

mysql_connect($hostname,$username,$password) OR DIE("Не могу создать соединение"); 
mysql_select_db($dbName) or die(mysql_error());  
$query="SELECT id, fullname, shortname, univer FROM $userstable WHERE id=".$drow['faculty'];
$fres = mysql_query($query); 
if (!$fres)
{
echo '500 Internal Server Error';
exit;	
}
$fnumber = mysql_num_rows($fres); 

if ($fnumber==0)
{	
//error
}





$frow=mysql_fetch_array($fres);

$userstable = "univers";  
$query="SELECT id, fullname, shortname FROM $userstable WHERE id=".$frow['univer'];
$ures = mysql_query($query); 
if (!$ures)
{
echo '500 Internal Server Error';
exit;	
} 
$unumber = mysql_num_rows($ures); 

$urow=mysql_fetch_array($ures);


echo '<div style="float:none; width:67%; margin-bottom:5px;"><a href="univer.php?id='.$urow['id'].'" style="text-decoration:none;"><div class="lightitem">'.$urow['shortname'].'</div></a></div>';

echo '<table><tr><td width="5%" valign="top"><img src="arrow.png" style="width: 100%;"></td><td width="70%"><div><a href="faculty.php?id='.$frow['id'].'" style="text-decoration:none;"><div class="lightitem">'.$frow['shortname'].'</div></a></div></td><td width="35%"><td></tr></table>';


echo '<table style="margin-left:5%;"><tr><td width="5%" valign="top"><img src="arrow.png" style="width: 100%;"></td><td width="72%"><div><a href="department.php?id='.$drow['id'].'" style="text-decoration:none;"><div class="lightitem">'.$drow['shortname'].'</div></a></div></td><td width="20%"><td></tr></table>';

echo '<table style="margin-left:10%;"><tr><td width="5%" valign="top"><img src="arrow.png" style="width: 100%;"></td><td width="74%"><div><a href="speciality.php?id='.$row['id'].'" style="text-decoration:none;"><div class="lightitem">'.$row['shortname'].'</div></a></div></td><td width="20%"><td></tr></table>';






?>

</div>

<div style="float: left; width: 63%; margin-left: 2%;">

<div class="title"> <?php 

echo $row['fullname'];

if ($_SESSION['moder'])
{
echo '<br><div class="lightitem" style="text-align:center; width: 180px; margin:auto; cursor: pointer;" onclick="showpanel(); return false;">Редактировать</div><br>';
}



?> </div> <br/>


<form method="post" id="panel" style="display:none;" action="speciality.php?id=<?php echo $_GET['id']; ?>" class="medtext" enctype="multipart/form-data">
<table style="margin-top:10px; border-spacing: 15px" class="medtext">
  <tr>
    <td>Полное название: </td>
	<td> <input name="fullname" type="text" maxlength="300" size="40" value="<?php echo htmlspecialchars($row['fullname']); ?>" /></td>
  </tr>
  <tr>
	<td>Краткое название: </td>
	<td> <input name="shortname" type="text" maxlength="20" size="25" value="<?php echo htmlspecialchars($row['shortname']); ?>" /></td>
  </tr> 
  <tr>
	<td>Код: </td>
	<td> <input name="code" type="text" maxlength="15" size="25" value="<?php echo htmlspecialchars($row['code']); ?>" /></td>
  </tr> 
  <tr>
  <td>
  </td>
  <td class="medtext" style="text-align:right;">
  <input type="submit" name="log" value="Сохранить" />
  </td>
  </tr>
</table>
</form>

<div class="subtitle"> Список групп </div> <br/> 

<?php
if ($_SESSION['moder']>0)
{


echo '<a href="addgroup.php?id='.$row['id'].'" style="text-decoration:none;"><div class="lightitem" style="text-align:center; width: 240px; margin:auto; cursor: pointer;">Добавить группу</div></a>';


	
}
?>
<br/>
<br/>

<div class="list">


<?php if(file_exists('keys.php')) include 'keys.php'; 


$userstable = "groups"; 

$query=sprintf("SELECT id, code FROM $userstable WHERE speciality='%s'",
mysql_real_escape_string($_GET['id']));

$res = mysql_query($query) or die(mysql_error()); 
$number = mysql_num_rows($res); 

if ($number!=0)
{	
while ($row=mysql_fetch_array($res))
{
echo '<a href="group.php?id='.$row['id'].'" style="text-decoration:none;"><div class="item">'.$row['code'].'</div></a>';
}
}
else
{
echo 'База данных пуста.';	
}

echo '<br/><iframe id="idIframe" onload="iframeLoaded()" src="students.php?speciality='.$_GET['id'].'" style="width:120%; border: none;" ></iframe>';

?>


</div>

</div>



</div>

 
<?php if(file_exists('footer.php')) include 'footer.php'; ?>
 
 <script type="text/javascript">
  function iframeLoaded() {
      var iFrameID = document.getElementById('idIframe');
      if(iFrameID) {
            // here you can make the height, I delete it first, then I make it again
            iFrameID.height = "";
            iFrameID.height = iFrameID.contentWindow.document.body.scrollHeight + "px";
      }   
  }
  
    function showpanel()
  {
	document.getElementById('panel').style.display="block";
  }
  
</script>

 
</body>

</html>