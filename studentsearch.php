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

<table>
<tr>
<td style="vertical-align:top;">
<img src="city3.png" style="width: 316px;">
</td>
<td>
<div class="bigtext">
Поиск по фамилию
</div><br>

<div class="medtext">
Введите фамилию студента:
</div><br>

<form method="post" action="studentsearch.php" class="medtext">


<table style="margin-top:10px; border-spacing: 15px" class="medtext">
  
    <tr>
	 <td >Фамилия: </td>
	<td> <input name="surname" type="text" maxlength="20" size="25" value="" /></td>
  </tr> 
  
  
  <td>
  </td>
  <td class="medtext" style="text-align:right;">
  <input type="submit" name="search" value="Поиск" />
  </td>
  </tr>
</table>



</form>

<?php

if (isset($_POST['search']))
{
	
echo '<div class="bigtext">Результаты поиска</div><br>';

echo '<iframe id="idIframe" onload="iframeLoaded()" src="students.php?surname='.$_POST['surname'].'" style="width:120%; border: none;" ></iframe>';

	
}

?>

</td>
</tr>
</table>

</div>

<script type="text/javascript">
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