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

$userstable = "prepods"; 


mysql_connect($hostname,$username,$password) OR DIE("Не могу создать соединение "); 
mysql_select_db($dbName) or die(mysql_error()); 
$query=sprintf("SELECT id, name, surname, lastname, username, password, verif, department, email, photo FROM $userstable WHERE id='%s'",
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
$querysprintf("DELETE FROM $userstable WHERE id='%s'", mysql_real_escape_string($_GET['id']));
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

	


$query=sprintf("SELECT * FROM $userstable WHERE id='%s'",
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
echo '<a href="prepod.php?act=deletephoto&&id='.$_GET['id'].'" style="text-decoration:none;"><div class="lightitem" style="text-align:center; width: 240px; margin:auto; cursor: pointer;">Удалить фото</div></a><br>';
}	
	
}



if ($_SESSION['moder']>0)
{
if ($row['verif']==1)
{
echo '<a href="prepod.php?act=unverify&&id='.$_GET['id'].'" style="text-decoration:none;"><div class="lightitem" style="text-align:center; width: 240px; margin:auto; cursor: pointer;">Отменить подтверждение</div></a><br>';
}
else
{
echo '<a href="prepod.php?act=verify&&id='.$_GET['id'].'" style="text-decoration:none;"><div class="lightitem" style="text-align:center; width: 240px; margin:auto; cursor: pointer;">Подтвердить анкету</div></a><br>';	
}


}

if ($_SESSION['moder']>0)
{
if ($row['moder']==1)
{
echo '<a href="prepod.php?act=unmakemoder&&id='.$_GET['id'].'" style="text-decoration:none;"><div class="lightitem" style="text-align:center; width: 240px; margin:auto; cursor: pointer;">Убрать права модератора</div></a><br>';
}
else
{
echo '<a href="prepod.php?act=makemoder&&id='.$_GET['id'].'" style="text-decoration:none;"><div class="lightitem" style="text-align:center; width: 240px; margin:auto; cursor: pointer;">Сделать модератором</div></a><br>';	
}


}

if ($_SESSION['moder']>0 || ($_SESSION['username']==$row['username'] && $row['username']!=""))
{
echo '<a href="prepod.php?act=deleteacc&&id='.$_GET['id'].'" style="text-decoration:none;"><div class="lightitem" style="text-align:center; width: 240px; margin:auto; cursor: pointer;">Удалить аккаунт</div></a><br>';
}

?>

<form action="prepod.php?act=photo&&id=<?php echo $_GET['id']; ?>" method="post" enctype="multipart/form-data">
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


<?php


if ($row['department']!=0)
{
	
$query="SELECT * FROM `departments`, `faculties`, `univers` WHERE `departments`.id=".$row['department']." AND `departments`.faculty=`faculties`.id AND `faculties`.univer=`univers`.id ORDER BY `univers`.id";
$res2 = mysql_query($query); 
if (!$res2)
{
echo '500 Internal Server Error';
exit;	
}
$number = mysql_num_rows($res2); 
$row2=mysql_fetch_array($res2);


	
}

$numberD=0;
$numberF=0;
$numberU=0;

if ($row['department']!=0)
{
	

$query="SELECT * FROM `departments` WHERE `departments`.faculty=".$row2[3];
$resD = mysql_query($query); 
if (!$resD)
{
echo '500 Internal Server Error';
exit;	
} 
$numberD = mysql_num_rows($resD); 
//$rowD=mysql_fetch_array($resD); 	

$query="SELECT * FROM `faculties` WHERE `faculties`.univer=".$row2[7];
$resF = mysql_query($query); 
if (!$resF)
{
echo '500 Internal Server Error';
exit;	
}
$numberF = mysql_num_rows($resF); 
//$rowF=mysql_fetch_array($resF); 
	
}

$query="SELECT * FROM `univers`";
$resU = mysql_query($query); 
if (!$resU)
{
echo '500 Internal Server Error';
exit;	
}
$numberU = mysql_num_rows($resU); 
//$rowU=mysql_fetch_array($resU); 




?>


   
   
   
    <tr onmouseover="showb('departmentC'); return false;" onmouseout="hideb('departmentC'); return false;">
	 <td height="55"><?php echo '<span class="bigtext">Кафедра: </span>'; ?> </td>
	<td height="55"> <?php echo '<span  id="departmentT" class="medtext">'.$row2[2].'</span>';?>
	
	<select class="cedit" id="departmentE">
	<?php
	if ($numberD>0)
	{
	while ($rowD=mysql_fetch_array($resD))
	{
	echo '<option value="'.$rowD['id'].'" ';
	if ($rowD['id']==$row2[0]) echo 'selected="selected" ';
	echo '>'.$rowD['shortname'].'</option>';
	}
	}
	
	?>
	</select>	
	
	</td>	
	 <td height="55">
	<div id="departmentC" class="bchange" style="display: none;" onclick="tochangeO('department')">Изменить</div>
	<div id="departmentS" class="bchange" style="display: none; float: left;" onclick="sendO('department')">Сохранить</div>
	<div id="departmentD" class="bchange" style="display: none; float: left; width: 20px; text-align: center;" onclick="cancelO('department')">X</div>
	</td>
  </tr>
  
  
 
     <tr onmouseover="showb('facultyC'); return false;" onmouseout="hideb('facultyC'); return false;">
	 <td height="55"><?php echo '<span class="bigtext">Факультет: </span>'; ?> </td>
	<td height="55"> <?php echo '<span  id="facultyT" class="medtext">'.$row2[6].'</span>';?>
	
	<select class="cedit" id="facultyE">
	<?php
	if ($numberF>0)
	{
	while ($rowF=mysql_fetch_array($resF))
	{
	echo '<option value="'.$rowF['id'].'" ';
	if ($rowF['id']==$row2[4]) echo 'selected="selected" ';
	echo '>'.$rowF['shortname'].'</option>';
	}
	}
	
	?>
	</select>	
	
	</td>	
	 <td height="55">
	<div id="facultyC" class="bchange" style="display: none;" onclick="tochangeO('faculty')">Изменить</div>
	<div id="facultyS" class="bchange" style="display: none; float: left;" onclick="sendO('faculty')">Сохранить</div>
	<div id="facultyD" class="bchange" style="display: none; float: left; width: 20px; text-align: center;" onclick="cancelO('faculty')">X</div>
	</td>
  </tr>
 
 
    <tr onmouseover="showb('univerC'); return false;" onmouseout="hideb('univerC'); return false;">
	<td height="55"><?php echo '<span class="bigtext">Университет: </span>'; ?> </td>
	<td height="55"> <?php echo '<span  id="univerT" class="medtext">'.$row2[10].'</span>';?>
	
	<select class="cedit" id="univerE">
	<?php
	if ($numberU>0)
	{
	while ($rowU=mysql_fetch_array($resU))
	{
	echo '<option value="'.$rowU['id'].'" ';
	if ($rowU['id']==$row2[8]) echo 'selected="selected" ';
	echo '>'.$rowU['shortname'].'</option>';
	}
	}
	
	?>
	</select>	
	
	</td>	
	 <td height="55">
	<div id="univerC" class="bchange" style="display: none;" onclick="tochangeO('univer')">Изменить</div>
	<div id="univerS" class="bchange" style="display: none; float: left;" onclick="sendO('univer')">Сохранить</div>
	<div id="univerD" class="bchange" style="display: none; float: left; width: 20px; text-align: center;" onclick="cancelO('univer')">X</div>
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
	
	var quer='changefield.php?table=prepods&&id='+sID+'&&field='+whats+'&&val='+valu;
	

	req.open('GET', quer, true);  
	

	req.send(null);   
	
	


}



function sendO(whats)
{
	
	
	var inp=d.getElementById(whats+'E');
	if (inp.selectedIndex==-1)
	{
		
		var tex=d.getElementById(whats+'T');
		var inp=d.getElementById(whats+'E');
		tex.innerHTML="";
		tex.style.display='block';
		inp.style.display='none';
		hideb(whats+'S');
		changing=false;
	
	return;	
	}
	
	if (whats=="department")
	{
	var inp=d.getElementById(whats+'E');
	var valu=inp.options[inp.selectedIndex].value;

	
	var req = getXmlHttp();

       
	req.onreadystatechange = function() {  
  

		if (req.readyState == 4) 
		{ 
          

			if (req.status == 200) 
			{ 
                
				var tex=d.getElementById(whats+'T');
				var inp=d.getElementById(whats+'E');
				tex.innerHTML=escapeHtml(inp.options[inp.selectedIndex].text);
				tex.style.display='block';
				inp.style.display='none';
				hideb(whats+'S');
				hideb(whats+'D');
				changing=false;
				
			}
			
		}

	}
	
	var quer='changefield.php?table=prepods&&id='+sID+'&&field=department&&val='+valu;
	
	//alert(quer);
	

	req.open('GET', quer, true);  
	

	req.send(null);   
	
	}
	else
	{
		
	
		
		
	var level=0;
	var downt;
		
	if (whats=="faculty")
	{
		level=1;	
		downt="departments";
	}
	else if (whats=="univer")
	{
		level=2;	
		downt="faculties";
	}
	
	if (level>0)
	{
		var inp=d.getElementById('departmentT');
		inp.innerHTML="";
		var inp=d.getElementById('departmentE');
		inp.innerHTML="";		
	}
	if (level>1)
	{
		var inp=d.getElementById('facultyT');
		inp.innerHTML="";
		var inp=d.getElementById('facultyE');
		inp.innerHTML="";		
	}
	

		
		
	
	var inp=d.getElementById(whats+'E');
	var valu=inp.options[inp.selectedIndex].value;

	
	var req = getXmlHttp();

       
	req.onreadystatechange = function() 
	{  
  

		if (req.readyState == 4) 
		{ 
          

			if (req.status == 200) 
			{ 
                
				var tex=d.getElementById(whats+'T');
				var inp=d.getElementById(whats+'E');
				tex.innerHTML=inp.options[inp.selectedIndex].text;
				tex.style.display='block';
				inp.style.display='none';
				hideb(whats+'S');
				hideb(whats+'D');
				changing=false;
				
				
				
				if (whats=="faculty")
				{
					level=1;	

				}
				else if (whats=="univer")
				{
					level=2;	

				}
				
	
				
				
				if (level>0)
				{

					var inp=d.getElementById('departmentE');
					inp.innerHTML=req.responseText;		
				}
				if (level>1)
				{

					var inp=d.getElementById('facultyE');
					inp.innerHTML=req.responseText;		
				}
				
				
	
				
				
				
				
			}
			
		}

	}
	
	var quer='getflist.php?table='+whats+'&&val='+valu;
	
		

	req.open('GET', quer, true);  
	

	req.send(null);   

	
		
	}


}

</script>
 
 
</body>

</html>