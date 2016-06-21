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
<?php
if ($_SESSION['moder']>0)
{
	
	
?>


<table>
<tr>
<td style="vertical-align: top;">

<img src="city3.png"/>

</td>
<td style="vertical-align: top;">

<?php
if (!isset($_GET['like']))
{
?>

<span class="subtitle"> Подтверждение анкет </span> <br/> <br/>

<a href="verify.php?like=students" style="text-decoration:none;"><div style="float:none;"><div class="lightitem" style="width:250px;">Студенты</div></div></a>
<a href="verify.php?like=prepods" style="text-decoration:none;"><div style="float:none;"><div class="lightitem" style="width:250px;">Преподаватели</div></div></a>
<a href="verify.php?like=users" style="text-decoration:none;"><div style="float:none;"><div class="lightitem" style="width:250px;">Пользователи</div></div></a>

<?php
}
else if ($_GET['like']=='students')
{
	
?>
	

<span class="subtitle"> Подтверждение анкет </span> <br/> <br/>
		
<iframe id="idIframe" onload="iframeLoaded()" src="students.php?verif=0&&moder=1" style="width:120%; min-width:450px; border: none;"></iframe>
	
<?php
	
}
else if ($_GET['like']=='prepods')
{
	
?>
	

<span class="subtitle"> Подтверждение анкет </span> <br/> <br/>
		
<iframe id="idIframe2" onload="iframeLoaded2()" src="prepods.php?verif=0&&moder=1" style="width:120%; min-width:450px; border: none;"></iframe>
	
<?php
	
}
else if ($_GET['like']=='users')
{
	
?>
	

<span class="subtitle"> Подтверждение анкет </span> <br/> <br/>
		
<iframe id="idIframe3" onload="iframeLoaded3()" src="users.php?verif=0&&moder=1" style="width:120%; min-width:450px; border: none;"></iframe>
	
<?php
	
}



?>




</td>
</tr>
</table>

<?php
}
else
{
echo 'Доступ запрещён.';
}
	
	
?>


</div>
 
 <script>
   function iframeLoaded() {
      var iFrameID = document.getElementById('idIframe');
      if(iFrameID) {
            // here you can make the height, I delete it first, then I make it again
            iFrameID.height = "";
            iFrameID.height = iFrameID.contentWindow.document.body.scrollHeight + "px";
      }   
  }
  function iframeLoaded2() {
      var iFrameID = document.getElementById('idIframe2');
      if(iFrameID) {
            // here you can make the height, I delete it first, then I make it again
            iFrameID.height = "";
            iFrameID.height = iFrameID.contentWindow.document.body.scrollHeight + "px";
      }   
  }
  function iframeLoaded3() {
      var iFrameID = document.getElementById('idIframe3');
      if(iFrameID) {
            // here you can make the height, I delete it first, then I make it again
            iFrameID.height = "";
            iFrameID.height = iFrameID.contentWindow.document.body.scrollHeight + "px";
      }   
  }
  </script>
 
</body>

</html>