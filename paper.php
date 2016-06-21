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

$userstable = "papers"; 




mysql_connect($hostname,$username,$password) OR DIE("Не могу создать соединение "); 
mysql_select_db($dbName) or die(mysql_error());  

if ($_SESSION['moder']>0)
{
$query=sprintf("UPDATE papers SET paperverif=1 WHERE `papers`.id='%s'",
mysql_real_escape_string($_GET['id']));
$res = mysql_query($query); 
if (!$res)
{
echo '500 Internal Server Error';
exit;	
}
	
}

$query=sprintf("SELECT * FROM papers, students WHERE `papers`.id='%s' AND `students`.id=`papers`.author",
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

if ($_GET['act']=='delfile')
{
if ($_SESSION['username']==$row['username'] || $_SESSION['moder']>0)
{

unlink(ROOT_DIR.$row['filename']);
$query2=sprintf("UPDATE papers SET filename='' WHERE `papers`.id='%s'",
mysql_real_escape_string($_GET['id']));
$res2 = mysql_query($query2); 
if (!$res2)
{
echo '500 Internal Server Error';
exit;	
}
}
}


if (isset($_FILES['filename']) && ($_SESSION['username']==$row['username'] || $_SESSION['moder']>0))
{

	
	
   if($_FILES["filename"]["size"] > 1024*3*1024)
   {
     echo ("Размер файла превышает три мегабайта");
     exit;
   }
   // Проверяем загружен ли файл
   if(is_uploaded_file($_FILES["filename"]["tmp_name"]))
   {
     // Если файл загружен успешно, перемещаем его
     // из временной директории в конечную
     move_uploaded_file($_FILES["filename"]["tmp_name"], ROOT_DIR."/papers/".$row[0].'____'.$_FILES["filename"]["name"]);
	 
	 $query=sprintf("UPDATE $userstable SET filename='%s' WHERE id='%s'", mysql_real_escape_string("/papers/".$row[0].'____'.$_FILES["filename"]["name"]), mysql_real_escape_string($_GET['id']));
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
else if ($_GET['act']=="deletefile"  && ($_SESSION['username']==$row['username'] || $_SESSION['moder']>0))
{
$query=sprintf("UPDATE $userstable SET filename='' WHERE id='%s'",mysql_real_escape_string($_GET['id']));
$res = mysql_query($query); 
if (!$res)
{
echo '500 Internal Server Error';
exit;	
} 	
}


	


$query=sprintf("SELECT * FROM papers, students WHERE `papers`.id='%s' AND `students`.id=`papers`.author",
mysql_real_escape_string($_GET['id']));
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




$pathtopict='paper.png';

//if (!file_exists(ROOT_DIR.$row['photo'])  || $row['photo']=="") $pathtopict='nophoto.png';

?>

<table>
<tr>
<td style="vertical-align:top; text-align:center;" >

<?php

//echo '<div style="float: left; width: 35%;">';

echo '<img src="'.$pathtopict.'" style="max-width: 321px;"><br>';

//echo '</div>';

if ($_SESSION['username']==$row['username'] || $_SESSION['moder']>0)
{
	
echo '<a href="deletepaper.php?id='.$row[0].'" style="text-decoration:none;"><div class="lightitem" style="text-align:center; width: 240px; margin:auto; cursor: pointer;">Удалить работу</div></a><br>';

/*echo '<div class="lightitem" onclick="FindFile();" style="text-align:center; width: 240px; margin:auto; cursor: pointer;">Загрузить фото</div><br>';	

if (file_exists(ROOT_DIR.$row['photo'])  && $row['photo']!="")
{
echo '<a href="student.php?act=deletephoto&&id='.$_GET['id'].'" style="text-decoration:none;"><div class="lightitem" style="text-align:center; width: 240px; margin:auto; cursor: pointer;">Удалить фото</div></a>';
}*/
	
}

?>

<form action="student.php?act=photo&&id=<?php echo $_GET['id']; ?>" method="post" enctype="multipart/form-data">
<div class="hiddenInput">
<input type="file"   id="my_hidden_file" accept="image/jpeg,image/png,image/gif" name="loadfile" onchange="LoadFile();"><input type="submit" id="my_hidden_load" style="display: none" value='Загрузить'>  
</div>
</form>


</td>

<td width="100%" style="vertical-align: top;">



<table >

	<tr>
	<td height="55"><?php echo '<span class="bigtext">Автор: </span>'; ?> </td>
	<td height="55"> 
	<?php echo '<a style="text-decoration:none;" a href="student.php?id='.htmlspecialchars($row[7]).'"><span id="nameT" class="medtext">'.htmlspecialchars($row['surname']).' '.htmlspecialchars($row['name']).'</span></a>';?>
	</td>
	<td height="55">
	</td>
	
  </tr>

   <tr onmouseover="showb('papernameC'); return false;" onmouseout="hideb('papernameC'); return false;">
	<td height="55"><?php echo '<span class="bigtext">Название, тема: </span>'; ?> </td>
	<td height="55"> 
	<?php echo '<span id="papernameT" class="medtext">'.$row['papername'].'</span>';?>
	<input id="papernameE" class="cedit" type="text" maxlength="25" size="12" value="" />
	</td>
	<td height="55">
	<div id="papernameC" class="bchange" style="display: none;" onclick="tochange('papername')">Изменить</div>
	<div id="papernameS" class="bchange" style="display: none; float: left;" onclick="send('papername')">Сохранить</div>
	<div id="papernameD" class="bchange" style="display: none; float: left; width: 20px; text-align: center;" onclick="cancel('papername')">X</div>
	</td>
	
  </tr>
   <tr   onmouseover="showb('papertypeC'); return false;" onmouseout="hideb('papertypeC'); return false;">
	<td height="55"><?php echo '<span class="bigtext">Тип работы: </span>';?></td>
	<td height="55"> <?php echo '<span id="papertypeT" class="medtext">'.htmlspecialchars($row['papertype']).'</span>';?>
	<input id="papertypeE" class="cedit" type="text" maxlength="25" size="12" value="" />
	</td>
	<td height="55">
	<div id="papertypeC" class="bchange" style="display: none;" onclick="tochange('papertype')">Изменить</div>
	<div id="papertypeS" class="bchange" style="display: none; float: left;" onclick="send('papertype')">Сохранить</div>
	<div id="papertypeD" class="bchange" style="display: none; float: left; width: 20px; text-align: center;" onclick="cancel('papertype')">X</div>
	</td>
  </tr> 
  
  <tr  onmouseover="showb('subjectC'); return false;" onmouseout="hideb('subjectC'); return false;">
	<td height="55"><?php echo '<span class="bigtext">Предмет: </span>';?></td>
	<td height="55"> <?php echo '<span id="subjectT" class="medtext">'.htmlspecialchars($row['subject']).'</span>';?>
	<input id="subjectE" class="cedit" type="text" maxlength="25" size="12" value="" />
	</td> 
  <td height="55">
	<div id="subjectC" class="bchange" style="display: none;" onclick="tochange('subject')">Изменить</div>
	<div id="subjectS" class="bchange" style="display: none; float: left;" onclick="send('subject')">Сохранить</div>
	<div id="subjectD" class="bchange" style="display: none; float: left; width: 20px; text-align: center;" onclick="cancel('subject')">X</div>
	</td>
</tr>


<?php

if ($row['filename']!="")
{

?>

<tr>
	<td height="55"><?php echo '<span class="bigtext">Файл работы: </span>';?></td>
  <td height="55">
	<a href="<?php echo $row['filename'];?>" style="text-decoration:none;"><div  class="bchange" style="display: block;" >Скачать</div></td></a>
	<td height="55"> 
	<?php


	if ($_SESSION['username']==$row['username'] || $_SESSION['moder']>0)
	{
	?>
	<a href="paper.php?id=<?php echo $_GET['id'];?>&&act=delfile" style="text-decoration:none;"><div  class="bchange" style="display: block;" >Удалить</div></a>
	<?php
	}
	?>
	</td> 
</tr>


<?php
}
else
{
if ($_SESSION['username']==$row['username'] || $_SESSION['moder']>0)
{
?>

<tr>
	<td height="55" style="vertical-align:top;"><?php echo '<span class="bigtext">Выберите файл: </span>';?></td>
  <td height="55">
	
	<form method="post" action="paper.php?id=<?php echo $_GET['id']; ?>" class="medtext" enctype="multipart/form-data">



	<input name="filename" type="file" maxlength="20" size="25" value="" />


  
	<br>
  <input type="submit" name="log" value="Загрузить работу" style="margin-top:10px;"/>
 


</form>
	
	</td> 
	
	
		
	
</tr>




<?php	
}
	
}
?>
 	 



</table>


		<br/>
  <span class="bigtext"> Список отзывов </span> <br/> <br/>
  <?php
  if ((($_SESSION['usertype']=='user' || $_SESSION['usertype']=='prepod') && $_SESSION['verif']==1) || $_SESSION['moder']>0)
{
echo '<a href="addcomment.php?forpaper='.$_GET['id'].'&&by='.$_SESSION['username'].'" style="text-decoration: none; "><div class="bchange" style="display: block; width: 250px;">Добавить отзыв</div></a>';	
}
  
  echo '<iframe id="idIframe" onload="iframeLoaded()" src="comments.php?forpaper='.$_GET['id'];
  echo '" style="width:100%; border: none;" ></iframe>';
  

  
  ?>
	

</td>
</tr> 
</table>


<?php

if ($_SESSION['username']==$row['username'])
{

/*echo '<a href="edits.php?id='.$row['id'].'" style="text-decoration:none;"><div style="float:none;"><div class="lightitem" style="width:220px;">Редактировать анкету</div></div></a>';	*/
	
}

?>





</div>

 
<?php if(file_exists('footer.php')) include 'footer.php'; ?>
 

 <script>
   function iframeLoaded() {
      var iFrameID = document.getElementById('idIframe');
      if(iFrameID) {
            // here you can make the height, I delete it first, then I make it again
            iFrameID.height = "";
            iFrameID.height = iFrameID.contentWindow.document.body.scrollHeight + "px";
      }   
  }
 
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
 
var d = document;

var changing=false;
var lol=15;

function FindFile() { document.getElementById('my_hidden_file').click(); }  
function LoadFile() { document.getElementById('my_hidden_load').click(); }  

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
	
	var quer='changepfield.php?table=papers&&id='+sID+'&&field='+whats+'&&val='+valu;
	

	req.open('GET', quer, true);  
	

	req.send(null);   
	
	


}





</script>
 
 
</body>

</html>