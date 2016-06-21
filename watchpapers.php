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


?>
		
<iframe id="idIframe" onload="iframeLoaded()" src="papersmoder.php?moder=1" style="width:120%; min-width:450px; border: none;"></iframe>


<?


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
  </script>
 
</body>

</html>