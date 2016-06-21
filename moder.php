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
<span class="subtitle"> Панель модератора </span> <br/> <br/>

<a href="verify.php" style="text-decoration:none;"><div style="float:none;"><div class="lightitem" style="width:350px;">Подтверждение анкет</div></div></a>
<a href="watchpapers.php" style="text-decoration:none;"><div style="float:none;"><div class="lightitem" style="width:350px;">Просмотр работ</div></div></a>
<a href="watchcomments.php" style="text-decoration:none;"><div style="float:none;"><div class="lightitem" style="width:350px;">Просмотр отзывов о работах</div></div></a>
<a href="watchnotes.php" style="text-decoration:none;"><div style="float:none;"><div class="lightitem" style="width:350px;">Просмотр отзывов об учениках</div></div></a>

</td>
</tr>
</table>

<?php
}
else
{
echo 'Доступ запрещён, сожалею, сэр.';
}
	
	
?>


</div>
 

 
</body>

</html>