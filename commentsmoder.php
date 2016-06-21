<html>
<head>
<title>site</title>
<META content="text/html; charset=utf-8" http-equiv="Content-Type">
<link href="style.css" rel="stylesheet" type="text/css" />

</head>

<body>




<div>
<span class="subtitle"> Список отзывов о работах </span> <br/> <br/>

<div class="list">

<?php if(file_exists('keys.php')) include 'keys.php'; 
session_start();

mysql_connect($hostname,$username,$password) OR DIE("Не могу создать соединение"); 
mysql_select_db($dbName) or die(mysql_error());  


$userstable = "comments"; 

$start=0;
$moder=false;
$styl="cursor: pointer; border: 3px solid #444343;";

if(isset($_GET['start']))
$start=(int)$_GET['start'];

$sqlcond="";
$getcond="";
if(isset($_GET['verif']))
{
$sqlcond=sprintf(" AND `papers`.verif='%s'", mysql_real_escape_string($_GET['verif']));
$getcond="verif=".$_GET['verif']."&&";
}
if(isset($_GET['moder']) && $_SESSION['moder']>0)
{
$moder=true;
$getcond=$getcond."moder=".$_GET['moder']."&&";
}




$query="SELECT COUNT(*) FROM comments,papers WHERE `papers`.id=`comments`.forpaper ORDER BY `comments`.id DESC";



$res = mysql_query($query); 
if (!$res)
{
echo '500 Internal Server Error';
exit;	
}
$row=mysql_fetch_array($res);
$count=$row[0];


if ($count<$start) $start=$count-20;
if ($start<0) $start=0;

$query="SELECT * FROM comments, papers WHERE `papers`.id=`comments`.forpaper  ORDER BY `comments`.id DESC";

//условие

$query=$query." LIMIT ".$start.", 20";

$res = mysql_query($query); 
if (!$res)
{
echo '500 Internal Server Error';
exit;	
}
$number = mysql_num_rows($res); 

if ($number!=0)
{
echo '<table width="100%" style="cursor: pointer;" rules="all">';
while ($row=mysql_fetch_array($res))
{
	
if ($row['commentverif']==1)
{
$styl="item";	
}
else $styl="newitem";	

?>
<tr class="<?php echo $styl;?>"  >
<?php 
if ($moder==true)
{
?>
	
<td width="10%"  onclick="window.top.location.href='comment.php?id=<?php echo $row[0];?>'; return false;"><div class="paddeditem" style="font-size: 16pt;"><?php echo htmlspecialchars($row[0]);?></div>
</td>	
	
<?php
}
?>
<td width="40%"  onclick="window.top.location.href='comment.php?id=<?php echo $row[0];?>'; return false;"><div class="paddeditem" style="font-size: 16pt;"><?php echo htmlspecialchars($row[3]);?></div>
</td>
<td width="40%"  onclick="window.top.location.href='comment.php?id=<?php echo $row[0];?>'; return false;"><div class="paddeditem" style="font-size: 16pt;"><?php echo htmlspecialchars($row['papertype']);?></div>
</td>


<?php 
/*
if ($moder==true)
{
?>
	
<td  class="lightitem" onclick="window.location.href='commentsmoder.php?id=<?php echo $row[0].'&&'.$getcond;?>'; return false;"><div class="paddeditem" style="font-size: 16pt; width:100px;">Подтвердить</div>
</td>	
	
<?php
}
*/
?>

</tr>
<?php
}

echo '</table>';
}
else
{
echo 'База данных пуста.';	
}

echo '<br/>';

if ($count>20)
{
$pagecount=floor($count/20);
if ($count%20>0) $pagecount++;	
if ($count<=140)
{

for ($i=1; $i<=$pagecount; $i++)
{
if ((($i-1)*20)!=$start)
{
echo '<a href="commentsmoder.php?start='.(($i-1)*20).'&&'.$getcond.'" style="text-decoration:none;"><div style="float:left;"><div class="lightitem" style="width:auto;">'.$i.'</div></div></a>';
}
else
{
echo '<div style="float:left;"><div class="paddeditem" style="width:auto;">'.$i.'</div></div>';	
}
}
	
}
else
{
	
if ($start<60)	
{
	
for ($i=1; $i<=$start/20+2 || $i<=3; $i++)
{
if ((($i-1)*20)!=$start)
{
echo '<a href="commentsmoder.php?start='.(($i-1)*20).'&&'.$getcond.'" style="text-decoration:none;"><div style="float:left;"><div class="lightitem" style="width:auto;">'.$i.'</div></div></a>';
}
else
{
echo '<div style="float:left;"><div class="paddeditem" style="width:auto;">'.$i.'</div></div>';	
}
}
echo '<div style="float:left;"><div class="paddeditem" style="width:auto;">...</div></div>';	

echo '<a href="commentsmoder.php?start='.(($pagecount-1)*20).'&&'.$getcond.'" style="text-decoration:none;"><div style="float:left;"><div class="lightitem" style="width:auto;">'.$pagecount.'</div></div></a>';	
	
}
else if ($count-$start<=60)	
{
	
echo '<a href="commentsmoder.php?start=0&&'.$getcond.'" style="text-decoration:none;"><div style="float:left;"><div class="lightitem" style="width:auto;">1</div></div></a>';	

echo '<div style="float:left;"><div class="paddeditem" style="width:auto;">...</div></div>';
	
for ($i=$start/20; $i<=$pagecount; $i++)
{
if ((($i-1)*20)!=$start)
{
echo '<a href="commentsmoder.php?start='.(($i-1)*20).'&&'.$getcond.'" style="text-decoration:none;"><div style="float:left;"><div class="lightitem" style="width:auto;">'.$i.'</div></div></a>';
}
else
{
echo '<div style="float:left;"><div class="paddeditem" style="width:auto;">'.$i.'</div></div>';	
}
}


	
}
else
{
	
echo '<a href="commentsmoder.php?start=0&&'.$getcond.'" style="text-decoration:none;"><div style="float:left;"><div class="lightitem" style="width:auto;">1</div></div></a>';	

echo '<div style="float:left;"><div class="paddeditem" style="width:auto;">...</div></div>';
	
for ($i=$start/20; $i<=$start/20+2; $i++)
{
if ((($i-1)*20)!=$start)
{
echo '<a href="commentsmoder.php?start='.(($i-1)*20).'&&'.$getcond.'" style="text-decoration:none;"><div style="float:left;"><div class="lightitem" style="width:auto;">'.$i.'</div></div></a>';
}
else
{
echo '<div style="float:left;"><div class="paddeditem" style="width:auto;">'.$i.'</div></div>';	
}
}	
	
echo '<div style="float:left;"><div class="paddeditem" style="width:auto;">...</div></div>';	

echo '<a href="commentsmoder.php?start='.(($pagecount-1)*20).'&&'.$getcond.'" style="text-decoration:none;"><div style="float:left;"><div class="lightitem" style="width:auto;">'.$pagecount.'</div></div></a>';	
	
	
	
}
	
}
	
}


?>

</div>

</div>





 
</body>

</html>