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

$userstable = "comments"; 


mysql_connect($hostname,$username,$password) OR DIE("Не могу создать соединение "); 
mysql_select_db($dbName) or die(mysql_error());  

if ($_SESSION['moder']>0)
{
$query=sprintf("UPDATE comments SET commentverif=1 WHERE id='%s'",
mysql_real_escape_string($_GET['id']));
$res = mysql_query($query); 
if (!$res)
{
echo '500 Internal Server Error';
exit;	
}	
	
}

$query=sprintf("SELECT * FROM comments, prepods WHERE `comments`.id='%s' AND `prepods`.username=`comments`.author",
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
$query=sprintf("SELECT * FROM comments, users WHERE `comments`.id='%s' AND `users`.username=`comments`.author",
mysql_real_escape_string($_GET['id']));
$res = mysql_query($query); 
if (!$res)
{
echo '500 Internal Server Error';
exit;	
}
}

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
$query2=sprintf("UPDATE comments SET filename='' WHERE `comments`.id='%s'",
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
     move_uploaded_file($_FILES["filename"]["tmp_name"], ROOT_DIR."/comments/".$row[0].'____'.$_FILES["filename"]["name"]);
	 
	 $query=sprintf("UPDATE $userstable SET filename='%s' WHERE id='%s'", mysql_real_escape_string("/comments/".$row[0].'____'.$_FILES["filename"]["name"]), mysql_real_escape_string($_GET['id']));
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
$query=sprintf("UPDATE $userstable SET filename='' WHERE id='%s'", mysql_real_escape_string($_GET['id']));
$res = mysql_query($query); 
if (!$res)
{
echo '500 Internal Server Error';
exit;	
}	
}


	
$hesfrom="prepod";

$query=sprintf("SELECT * FROM comments, prepods WHERE `comments`.id='%s' AND `prepods`.username=`comments`.author",
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
$hesfrom="user";
$query=sprintf("SELECT * FROM comments, users WHERE `comments`.id='%s' AND `users`.username=`comments`.author",
mysql_real_escape_string($_GET['id']));
$res = mysql_query($query); 
if (!$res)
{
echo '500 Internal Server Error';
exit;	
}
}

$row=mysql_fetch_array($res);



$queryF="SELECT * FROM comments, papers WHERE `comments`.forpaper=`papers`.id";
$resF = mysql_query($queryF); 
if (!$resF)
{
echo '500 Internal Server Error';
exit;	
}
$numberF = mysql_num_rows($resF);
$rowF=mysql_fetch_array($resF);
 

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
	
echo '<a href="deletecomment.php?id='.$row[0].'" style="text-decoration:none;"><div class="lightitem" style="text-align:center; width: 240px; margin:auto; cursor: pointer;">Удалить отзыв</div></a><br>';

/*echo '<div class="lightitem" onclick="FindFile();" style="text-align:center; width: 240px; margin:auto; cursor: pointer;">Загрузить фото</div><br>';	

if (file_exists(ROOT_DIR.$row['photo'])  && $row['photo']!="")
{
echo '<a href="student.php?act=deletephoto&&id='.$_GET['id'].'" style="text-decoration:none;"><div class="lightitem" style="text-align:center; width: 240px; margin:auto; cursor: pointer;">Удалить фото</div></a>';
}*/
	
}

?>




</td>

<td width="100%" style="vertical-align: top;">



<table >
   <tr onmouseover="showb('commenttitleC'); return false;" onmouseout="hideb('commenttitleC'); return false;">
	<td height="55"><?php echo '<span class="bigtext">Заголовок: </span>'; ?> </td>
	<td height="55"> 
	<?php echo '<span id="commenttitleT" class="medtext">'.htmlspecialchars($row['commenttitle']).'</span>';?>
	<input id="commenttitleE" class="cedit" type="text" maxlength="25" size="12" value="" />
	</td>
	<td height="55">
	<div id="commenttitleC" class="bchange" style="display: none;" onclick="tochange('commenttitle')">Изменить</div>
	<div id="commenttitleS" class="bchange" style="display: none; float: left;" onclick="send('commenttitle')">Сохранить</div>
	<div id="commenttitleD" class="bchange" style="display: none; float: left; width: 20px; text-align: center;" onclick="cancel('commenttitle')">X</div>
	</td>
	
  </tr>
   <tr>
	<td height="55"><?php echo '<span class="bigtext">Работа: </span>';?></td>
	<td height="55"> <?php echo '<a href="paper.php?id='.$row['forpaper'].'" style="text-decoration:none;"><div id="papertypeT" class="medtext" style="text-overflow: ellipsis; width: 100px;">'.$rowF['papername'].'</div></a>';?>
	</td>
	<td height="55">
	</td>
  </tr> 
  
  <tr>
	<td height="55"><?php echo '<span class="bigtext">Автор отзыва: </span>'; ?> </td>
	<td height="55"> 
	<?php echo '<a style="text-decoration:none;" a href="'.$hesfrom.'.php?id='.htmlspecialchars($row[6]).'"><span id="nameT" class="medtext">'.htmlspecialchars($row['surname']).' '.htmlspecialchars($row['name']).'</span></a>';?>
	</td>
	<td height="55">
	</td>
	
  </tr>
  

<?php

if ($row['filename']!="")
{

?>

<tr>
	<td height="55"><?php echo '<span class="bigtext">Файл отзыва: </span>';?></td>
  <td height="55">
	<a href="<?php echo $row['filename'];?>" style="text-decoration:none;"><div  class="bchange" style="display: block;" >Скачать</div></td></a>
	<td height="55"> 
	<?php


	if ($_SESSION['username']==$row['username'] || $_SESSION['moder']>0)
	{
	?>
	<a href="comment.php?id=<?php echo $_GET['id'];?>&&act=delfile" style="text-decoration:none;"><div  class="bchange" style="display: block;" >Удалить</div></a>
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
	
	<form method="post" action="comment.php?id=<?php echo $_GET['id']; ?>" class="medtext" enctype="multipart/form-data">



	<input name="filename" type="file" maxlength="20" size="25" value="" />


  
	<br>
  <input type="submit" name="log" value="Загрузить текст отзыва" style="margin-top:10px;"/>
 


</form>
	
	</td> 
	
	

	
</tr>




<?php	
}
	
}
?>
 	 



</table>


	

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
	
	var quer='changecfield.php?table=comments&&id='+sID+'&&field='+whats+'&&val='+valu;
	

	req.open('GET', quer, true);  
	

	req.send(null);   
	
	


}





</script>
 
 
</body>

</html>