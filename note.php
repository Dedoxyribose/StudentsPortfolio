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

$userstable = "notes"; 


mysql_connect($hostname,$username,$password) OR DIE("Не могу создать соединение "); 
mysql_select_db($dbName) or die(mysql_error());  

if ($_SESSION['moder']>0)
{
$query=sprintf("UPDATE notes SET noteverif=1 WHERE id='%s'",
mysql_real_escape_string($_GET['id']));
$res = mysql_query($query) or die(mysql_error());	
	
}

$query=sprintf("SELECT * FROM notes, prepods WHERE `notes`.id='%s' AND `prepods`.username=`notes`.author",
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
$query=sprintf("SELECT * FROM notes, users WHERE `notes`.id='%s' AND `users`.username=`notes`.author",
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



$hesfrom="prepod";

$query=sprintf("SELECT * FROM notes, prepods WHERE `notes`.id='%s' AND `prepods`.username=`notes`.author",
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
$query=sprintf("SELECT * FROM notes, users WHERE `notes`.id='%s' AND `users`.username=`notes`.author",
mysql_real_escape_string($_GET['id']));
$res = mysql_query($query); 
if (!$res)
{
echo '500 Internal Server Error';
exit;	
}	
}

$row=mysql_fetch_array($res);



$queryF="SELECT * FROM notes, students WHERE `notes`.forstudent=`students`.id";
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
	
echo '<a href="deletenote.php?id='.$row[0].'" style="text-decoration:none;"><div class="lightitem" style="text-align:center; width: 240px; margin:auto; cursor: pointer;">Удалить отзыв</div></a><br>';

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
   <tr onmouseover="showb('notetitleC'); return false;" onmouseout="hideb('notetitleC'); return false;">
	<td height="55"><?php echo '<span class="bigtext">Заголовок: </span>'; ?> </td>
	<td height="55"> 
	<?php echo '<span id="notetitleT" class="medtext">'.htmlspecialchars($row['notetitle']).'</span>';?>
	<input id="notetitleE" class="cedit" type="text" maxlength="25" size="12" value="" />
	</td>
	<td height="55">
	<div id="notetitleC" class="bchange" style="display: none;" onclick="tochange('notetitle')">Изменить</div>
	<div id="notetitleS" class="bchange" style="display: none; float: left;" onclick="send('notetitle')">Сохранить</div>
	<div id="notetitleD" class="bchange" style="display: none; float: left; width: 20px; text-align: center;" onclick="cancel('notetitle')">X</div>
	</td>
	
  </tr>
   <tr>
	<td height="55"><?php echo '<span class="bigtext">Касательно: </span>';?></td>
	<td height="55"> <?php echo '<a href="student.php?id='.$row['forstudent'].'" style="text-decoration:none;"><div id="papertypeT" class="medtext" style="text-overflow: ellipsis; width: 100px;">'.$rowF['surname'].' '.$rowF['name'].'</div></a>';?>
	</td>
	<td height="55">
	</td>
  </tr> 
  
  <tr>
	<td height="55"><?php echo '<span class="bigtext">Автор отзыва: </span>'; ?> </td>
	<td height="55"> 
	<?php echo '<a style="text-decoration:none;" a href="'.$hesfrom.'.php?id='.$row[6].'"><span id="nameT" class="medtext">'.$row['surname'].' '.$row['name'].'</span></a>';?>
	</td>
	<td height="55">
	</td>
	
  </tr>
  
     <tr onmouseover="showb('notetextC'); return false;" onmouseout="hideb('notetextC'); return false;">
	<td height="55"><?php echo '<span class="bigtext">Текст отзыва: </span>'; ?> </td>
	<td height="55"> 
	<?php echo '<span id="notetextT" class="medtext">'.htmlspecialchars($row['notetext']).'</span>';?>
	<textarea rows="10" id="notetextE" class="cedit" cols="18" size="12" name="text"></textarea>
	</td>
	<td height="55">
	<div id="notetextC" class="bchange" style="display: none;" onclick="tochange('notetext')">Изменить</div>
	<div id="notetextS" class="bchange" style="display: none; float: left;" onclick="send('notetext')">Сохранить</div>
	<div id="notetextD" class="bchange" style="display: none; float: left; width: 20px; text-align: center;" onclick="cancel('notetext')">X</div>
	</td>
	
  </tr>
  



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
	
	var quer='changenfield.php?table=notes&&id='+sID+'&&field='+whats+'&&val='+valu;
	

	req.open('GET', quer, true);  
	

	req.send(null);   
	
	


}





</script>
 
 
</body>

</html>