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

 <script>
var sID=<?php echo $_GET['id'];?>
</script>


<?php

define('ROOT_DIR', dirname(__FILE__));

if(file_exists('keys.php')) include 'keys.php';

$userstable = "users"; 


mysql_connect($hostname,$username,$password) OR DIE("Не могу создать соединение "); 
mysql_select_db($dbName) or die(mysql_error()); 
$query=sprintf("SELECT id, name, surname, lastname, username, password, verif, organisation, position, email, photo FROM $userstable WHERE id='%s'",
mysql_real_escape_string($_GET['id']));
$res = mysql_query($query); 
if (!$res)
{
echo '500 Internal Server Error';
exit;	
}
$number = mysql_num_rows($res);
$row=mysql_fetch_array($res);

?>

 <script>
var may=<?php 

if ($_SESSION['username']==$row['username'] || $_SESSION['moder']>0)
{
echo 'true'; 
}
else echo 'false';

?>;
</script>

<?php



if (isset($_FILES['loadfile']) && ($_SESSION['username']==$row['username'] || $_SESSION['moder']>0)) 
{

	
	
	if($_FILES["loadfile"]["size"] > 1024*3*1024)
   {
     echo ("Размер файла превышает три мегабайта");
     exit;
   }
   // Проверяем загружен ли файл
   if(is_uploaded_file($_FILES["loadfile"]["tmp_name"]))
   {
     // Если файл загружен успешно, перемещаем его
     // из временной директории в конечную
     move_uploaded_file($_FILES["loadfile"]["tmp_name"], ROOT_DIR."/album/".$_SESSION['username']);
	 
	 $query=sprintf("UPDATE $userstable SET photo='%s' WHERE id='%s'", mysql_real_escape_string("/album/".$_SESSION['username']), mysql_real_escape_string($_GET['id']));
	 $res = mysql_query($query); 
	if (!$res)
	{
	echo '500 Internal Server Error';
	exit;	
	} 
	 
   } else 
   {
      echo("Ошибка загрузки файла");
   }
	
	
}
else if ($_GET['act']=="deletephoto"  && ($_SESSION['username']==$row['username'] || $_SESSION['moder']>0))
{
$query=sprintf("UPDATE $userstable SET photo='' WHERE id='%s'", mysql_real_escape_string($_GET['id']));
$res = mysql_query($query); 
if (!$res)
{
echo '500 Internal Server Error';
exit;	
}	
}
else if ($_GET['act']=="deleteacc"  && ($_SESSION['username']==$row['username'] || $_SESSION['moder']>0))
{
$query=sprintf("DELETE FROM $userstable WHERE id='%s'", mysql_real_escape_string($_GET['id']));
$res = mysql_query($query); 
if (!$res)
{
echo '500 Internal Server Error';
exit;	
}
echo 'Аккаунт удалён.';
exit;
}
else if ($_GET['act']=="unverify"  && $_SESSION['moder']>0)
{
$query=sprintf("UPDATE $userstable SET verif=0 WHERE id='%s'", mysql_real_escape_string($_GET['id']));
$res = mysql_query($query); 
if (!$res)
{
echo '500 Internal Server Error';
exit;	
}
}
else if ($_GET['act']=="verify"  &&  $_SESSION['moder']>0)
{
$query=sprintf("UPDATE $userstable SET verif=1 WHERE id='%s'", mysql_real_escape_string($_GET['id']));
$res = mysql_query($query); 
if (!$res)
{
echo '500 Internal Server Error';
exit;	
}
}
else if ($_GET['act']=="makemoder"  && $_SESSION['moder']>0)
{
$query=sprintf("UPDATE $userstable SET moder=1 WHERE id='%s'", mysql_real_escape_string($_GET['id']));
$res = mysql_query($query); 
if (!$res)
{
echo '500 Internal Server Error';
exit;	
}
}
else if ($_GET['act']=="unmakemoder"  &&  $_SESSION['moder']>0)
{
$query=sprintf("UPDATE $userstable SET moder=0 WHERE id='%s'", mysql_real_escape_string($_GET['id']));
$res = mysql_query($query); 
if (!$res)
{
echo '500 Internal Server Error';
exit;	
}
}


	


$query=sprintf("SELECT id, name, surname, lastname, username, password, verif, organisation, position, email, photo FROM $userstable WHERE id='%s'", mysql_real_escape_string($_GET['id']));
$res = mysql_query($query); 
if (!$res)
{
echo '500 Internal Server Error';
exit;	
}
$number = mysql_num_rows($res);
$row=mysql_fetch_array($res); 

//echo '<div class="subtitle">'.$row['surname'].' '.$row['name'].' '.$row['lastname'].'.</div>';

/*if ($row['verif']==0)
{
echo 'Ваш аккаунт не подтверждён. Обратитесь к администратору системы в своём университете';
}
else if ($row['verif']==2)
{
echo 'Ваш аккаунт был отклонён модератором.';
}
else
{
echo $row['surname'].' '.$row['name'].' '.$row['lastname'];
echo '<br>';
echo '<a href="student.php?id='.$row['id'].'">Перейти к анкете.</a>';
}*/




$pathtopict=$row['photo'];

if (!file_exists(ROOT_DIR.$row['photo']) || $row['photo']=="") $pathtopict='nophoto.png';

?>

<table>
<tr>
<td style="vertical-align:top; text-align:center;" >

<?php

//echo '<div style="float: left; width: 35%;">';

echo '<img src="'.$pathtopict.'" style="max-width: 321px;"><br>';

//echo '</div>';

if ($_SESSION['username']==$row['username'])
{

echo '<div class="lightitem" onclick="FindFile();" style="text-align:center; width: 240px; margin:auto; cursor: pointer;">Загрузить фото</div><br>';	
if (file_exists(ROOT_DIR.$row['photo'])  && $row['photo']!="")
{
echo '<a href="theuser.php?act=deletephoto&&id='.$_GET['id'].'" style="text-decoration:none;"><div class="lightitem" style="text-align:center; width: 240px; margin:auto; cursor: pointer;">Удалить фото</div></a><br>';
}
	
}





if ($_SESSION['moder']>0)
{
if ($row['verif']==1)
{
echo '<a href="theuser.php?act=unverify&&id='.$_GET['id'].'" style="text-decoration:none;"><div class="lightitem" style="text-align:center; width: 240px; margin:auto; cursor: pointer;">Отменить подтверждение</div></a><br>';
}
else
{
echo '<a href="theuser.php?act=verify&&id='.$_GET['id'].'" style="text-decoration:none;"><div class="lightitem" style="text-align:center; width: 240px; margin:auto; cursor: pointer;">Подтвердить анкету</div></a><br>';	
}


}

if ($_SESSION['moder']>0)
{
if ($row['moder']==1)
{
echo '<a href="theuser.php?act=unmakemoder&&id='.$_GET['id'].'" style="text-decoration:none;"><div class="lightitem" style="text-align:center; width: 240px; margin:auto; cursor: pointer;">Убрать права модератора</div></a><br>';
}
else
{
echo '<a href="theuser.php?act=makemoder&&id='.$_GET['id'].'" style="text-decoration:none;"><div class="lightitem" style="text-align:center; width: 240px; margin:auto; cursor: pointer;">Сделать модератором</div></a><br>';	
}


}

if ($_SESSION['moder']>0 || ($_SESSION['username']==$row['username'] && $row['username']!=""))
{
echo '<a href="prepod.php?act=deleteacc&&id='.$_GET['id'].'" style="text-decoration:none;"><div class="lightitem" style="text-align:center; width: 240px; margin:auto; cursor: pointer;">Удалить аккаунт</div></a><br>';
}

?>

<form action="theuser.php?act=photo&&id=<?php echo $_GET['id']; ?>" method="post" enctype="multipart/form-data">
<div class="hiddenInput">
<input type="file"   id="my_hidden_file" accept="image/jpeg,image/png,image/gif" name="loadfile" onchange="LoadFile();"><input type="submit" id="my_hidden_load" style="display: none" value='Загрузить'>  
</div>
</form>
<iframe id="rFrame" name="rFrame" style="display: none"> </iframe> 

</td>

<td>



<table >
   <tr onmouseover="showb('surnameC'); return false;" onmouseout="hideb('surnameC'); return false;">
	<td height="55"><?php echo '<span class="bigtext">Фамилия: </span>'; ?> </td>
	<td height="55"> 
	<?php echo '<span id="surnameT" class="medtext">'.htmlspecialchars($row['surname']).'</span>';?>
	<input id="surnameE" class="cedit" type="text" maxlength="25" size="12" value="" />
	</td>
	<td height="55">
	<div id="surnameC" class="bchange" style="display: none;" onclick="tochange('surname')">Изменить</div>
	<div id="surnameS" class="bchange" style="display: none; float: left;" onclick="send('surname')">Сохранить</div>
	<div id="surnameD" class="bchange" style="display: none; float: left; width: 20px; text-align: center;" onclick="cancel('surname')">X</div>
	</td>
	
  </tr>
   <tr   onmouseover="showb('nameC'); return false;" onmouseout="hideb('nameC'); return false;">
	<td height="55"><?php echo '<span class="bigtext">Имя: </span>';?></td>
	<td height="55"> <?php echo '<span id="nameT" class="medtext">'.htmlspecialchars($row['name']).'</span>';?>
	<input id="nameE" class="cedit" type="text" maxlength="25" size="12" value="" />
	</td>
	<td height="55">
	<div id="nameC" class="bchange" style="display: none;" onclick="tochange('name')">Изменить</div>
	<div id="nameS" class="bchange" style="display: none; float: left;" onclick="send('name')">Сохранить</div>
	<div id="nameD" class="bchange" style="display: none; float: left; width: 20px; text-align: center;" onclick="cancel('name')">X</div>
	</td>
  </tr> 
  
  <tr  onmouseover="showb('lastnameC'); return false;" onmouseout="hideb('lastnameC'); return false;">
	<td height="55"><?php echo '<span class="bigtext">Отчество: </span>';?></td>
	<td height="55"> <?php echo '<span id="lastnameT" class="medtext">'.htmlspecialchars($row['lastname']).'</span>';?>
	<input id="lastnameE" class="cedit" type="text" maxlength="25" size="12" value="" />
	</td> 
  <td height="55">
	<div id="lastnameC" class="bchange" style="display: none;" onclick="tochange('lastname')">Изменить</div>
	<div id="lastnameS" class="bchange" style="display: none; float: left;" onclick="send('lastname')">Сохранить</div>
	<div id="lastnameD" class="bchange" style="display: none; float: left; width: 20px; text-align: center;" onclick="cancel('lastname')">X</div>
	</td>
</tr>


  <tr  onmouseover="showb('organisationC'); return false;" onmouseout="hideb('organisationC'); return false;">
	<td height="55"><?php echo '<span class="bigtext">Организация: </span>';?></td>
	<td height="55"> <?php echo '<span id="organisationT" class="medtext">'.htmlspecialchars($row['organisation']).'</span>';?>
	<input id="organisationE" class="cedit" type="text" maxlength="25" size="12" value="" />
	</td> 
  <td height="55">
	<div id="organisationC" class="bchange" style="display: none;" onclick="tochange('organisation')">Изменить</div>
	<div id="organisationS" class="bchange" style="display: none; float: left;" onclick="send('organisation')">Сохранить</div>
	<div id="organisationD" class="bchange" style="display: none; float: left; width: 20px; text-align: center;" onclick="cancel('organisation')">X</div>
	</td>
</tr>


  <tr  onmouseover="showb('positionC'); return false;" onmouseout="hideb('positionC'); return false;">
	<td height="55"><?php echo '<span class="bigtext">Должность: </span>';?></td>
	<td height="55"> <?php echo '<span id="positionT" class="medtext">'.htmlspecialchars($row['position']).'</span>';?>
	<input id="positionE" class="cedit" type="text" maxlength="25" size="12" value="" />
	</td> 
  <td height="55">
	<div id="positionC" class="bchange" style="display: none;" onclick="tochange('position')">Изменить</div>
	<div id="positionS" class="bchange" style="display: none; float: left;" onclick="send('position')">Сохранить</div>
	<div id="positionD" class="bchange" style="display: none; float: left; width: 20px; text-align: center;" onclick="cancel('position')">X</div>
	</td>
</tr>




     
  </tr> 
    <tr  onmouseover="showb('emailC'); return false;" onmouseout="hideb('emailC'); return false;">
	 <td height="55"><?php echo '<span class="bigtext">E-mail: </span>';?></td>
	<td height="55"> <?php echo '<span id="emailT" class="medtext">'.htmlspecialchars($row['email']).'</span>';?>
	<input id="emailE" class="cedit" type="text" maxlength="25" size="12" value="" />
	</td>
	 <td height="55">
	<div id="emailC" class="bchange" style="display: none;" onclick="tochange('email')">Изменить</div>
	<div id="emailS" class="bchange" style="display: none; float: left;" onclick="send('email')">Сохранить</div>
	<div id="emailD" class="bchange" style="display: none; float: left; width: 20px; text-align: center;" onclick="cancel('email')">X</div>
	</td>
  </tr>




</table>


<?php

if ($_SESSION['username']==$row['username'])
{

/*echo '<a href="edits.php?id='.$row['id'].'" style="text-decoration:none;"><div style="float:none;"><div class="lightitem" style="width:220px;">Редактировать анкету</div></div></a>';	*/
	
}

?>


</td>


</div>

 
<?php if(file_exists('footer.php')) include 'footer.php'; ?>
 

 <script>
var d = document;

var changing=false;
var lol=15;

function FindFile() { document.getElementById('my_hidden_file').click(); }  
function LoadFile() { document.getElementById('my_hidden_load').click(); }  

function escapeHtml(text) {
  var map = {
    '&': '&amp;',
    '<': '&lt;',
    '>': '&gt;',
    '"': '&quot;',
    "'": '&#039;'
  };

  return text.replace(/[&<>"']/g, function(m) { return map[m]; });
}

function showb(whats)
{
	if (!changing && may)
	{
	var obj=d.getElementById(whats);
	obj.style.display='block';
	}
}

function hideb(whats)
{
	var obj=d.getElementById(whats);
	obj.style.display='none';
}

function tochange(whats)
{
	hideb(whats+'C');
	showb(whats+'S');
	hideb(whats+'T');
	showb(whats+'E');
	showb(whats+'D');
	d.getElementById(whats+'E').value=d.getElementById(whats+'T').innerHTML;
	changing=true;
}


function tochangeO(whats)
{
	hideb(whats+'C');
	showb(whats+'S');
	hideb(whats+'T');
	showb(whats+'E');
	showb(whats+'D');
	changing=true;
}

function getXmlHttp(){
  var xmlhttp;
  try {
    xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
  } catch (e) {
    try {
      xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    } catch (E) {
      xmlhttp = false;
    }
  }
  if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
    xmlhttp = new XMLHttpRequest();
  }
  return xmlhttp;
}

function cancel(whats)
{
	
var tex=d.getElementById(whats+'T');
var inp=d.getElementById(whats+'E');
tex.style.display='block';
inp.style.display='none';
hideb(whats+'S');
hideb(whats+'D');
changing=false;	
	
}

function cancelO(whats)
{
	
var tex=d.getElementById(whats+'T');
var inp=d.getElementById(whats+'E');
tex.style.display='block';
inp.style.display='none';
hideb(whats+'S');
hideb(whats+'D');
changing=false;	
	
}


function send(whats)
{
	var inp=d.getElementById(whats+'E');
	var valu=inp.value;

	
	var req = getXmlHttp();

       
	req.onreadystatechange = function() {  
  

		if (req.readyState == 4) 
		{ 
          

			if (req.status == 200) 
			{ 
                
				var tex=d.getElementById(whats+'T');
				tex.innerHTML=escapeHtml(valu);
				tex.style.display='block';
				inp.style.display='none';
				hideb(whats+'S');
				hideb(whats+'D');
				changing=false;
				
			}
			
		}

	}
	
	var quer='changefield.php?table=users&&id='+sID+'&&field='+whats+'&&val='+valu;
	

	req.open('GET', quer, true);  
	

	req.send(null);   
	
	


}





</script>
 
 
</body>

</html>