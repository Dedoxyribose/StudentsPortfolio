<html>
<head>
<title>site</title>
<META content="text/html; charset=utf-8" http-equiv="Content-Type">
<link href="style.css" rel="stylesheet" type="text/css" />

</head>

<body>




<div>


<div class="list">

<?php if(file_exists('keys.php')) include 'keys.php'; 

include('auth.php');

mysql_connect($hostname,$username,$password) OR DIE("Не могу создать соединение"); 
mysql_select_db($dbName) or die(mysql_error());  

$userstable = "departments"; 

$start=0;

if(isset($_GET['start']))
$start=(int)$_GET['start'];

$sqlcond="";
$getcond="";
if(isset($_GET['by']))
{
$sqlcond=sprintf(" AND `papers`.author='%s'", mysql_real_escape_string($_GET['by']));
$getcond="by=".$_GET['by'];
}
if(isset($_GET['paperverif']))
{
$sqlcond=sprintf(" AND `papers`.paperverif='%s'", mysql_real_escape_string($_GET['paperverif']));
$getcond="paperverif=".$_GET['paperverif'];
}


$query="SELECT COUNT(*) FROM `papers`, `students` WHERE `students`.id=`papers`.author".$sqlcond." ORDER BY `students`.id";



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

$query="SELECT * FROM `papers`, `students` WHERE `students`.id=`papers`.author".$sqlcond." ORDER BY `students`.id";

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
echo '<table width="100%" style="border: 3px solid #444343;" rules="all">';
while ($row=mysql_fetch_array($res))
{
?>
<tr class="item" style="cursor: pointer; border: 3px solid #444343;" onclick="window.top.location.href='paper.php?id=<?php echo $row[0];?>'; return false;">
<td width="150px" style="cursor: pointer; border: 3px solid #444343;"><div class="paddeditem" style="font-size: 16pt;"><?php echo htmlspecialchars($row['papertype']);?></div></td>
<td width="150px" style="cursor: pointer; border: 3px solid #444343;"><div class="paddeditem" style="font-size: 16pt;"><?php echo htmlspecialchars($row['papername']);?></div></td>
<?php 
if (!isset($_GET['by']))
{
?>
<td width="150px" style="cursor: pointer; border: 3px solid #444343;"><div class="paddeditem" style="font-size: 16pt;"><?php echo htmlspecialchars($row['surname'])." ".htmlspecialchars($row['name'])." ".htmlspecialchars($row['lastname']);?></div></td>
<?php
}
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
echo '<a href="papers.php?start='.(($i-1)*20).'&&'.$getcond.'" style="text-decoration:none;"><div style="float:left;"><div class="lightitem" style="width:auto;">'.$i.'</div></div></a>';
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
echo '<a href="papers.php?start='.(($i-1)*20).'&&'.$getcond.'" style="text-decoration:none;"><div style="float:left;"><div class="lightitem" style="width:auto;">'.$i.'</div></div></a>';
}
else
{
echo '<div style="float:left;"><div class="paddeditem" style="width:auto;">'.$i.'</div></div>';	
}
}
echo '<div style="float:left;"><div class="paddeditem" style="width:auto;">...</div></div>';	

echo '<a href="papers.php?start='.(($pagecount-1)*20).'&&'.$getcond.'" style="text-decoration:none;"><div style="float:left;"><div class="lightitem" style="width:auto;">'.$pagecount.'</div></div></a>';	
	
}
else if ($count-$start<=60)	
{
	
echo '<a href="papers.php?start=0&&'.$getcond.'" style="text-decoration:none;"><div style="float:left;"><div class="lightitem" style="width:auto;">1</div></div></a>';	

echo '<div style="float:left;"><div class="paddeditem" style="width:auto;">...</div></div>';
	
for ($i=$start/20; $i<=$pagecount; $i++)
{
if ((($i-1)*20)!=$start)
{
echo '<a href="papers.php?start='.(($i-1)*20).'&&'.$getcond.'" style="text-decoration:none;"><div style="float:left;"><div class="lightitem" style="width:auto;">'.$i.'</div></div></a>';
}
else
{
echo '<div style="float:left;"><div class="paddeditem" style="width:auto;">'.$i.'</div></div>';	
}
}


	
}
else
{
	
echo '<a href="papers.php?start=0&&'.$getcond.'" style="text-decoration:none;"><div style="float:left;"><div class="lightitem" style="width:auto;">1</div></div></a>';	

echo '<div style="float:left;"><div class="paddeditem" style="width:auto;">...</div></div>';
	
for ($i=$start/20; $i<=$start/20+2; $i++)
{
if ((($i-1)*20)!=$start)
{
echo '<a href="papers.php?start='.(($i-1)*20).'&&'.$getcond.'" style="text-decoration:none;"><div style="float:left;"><div class="lightitem" style="width:auto;">'.$i.'</div></div></a>';
}
else
{
echo '<div style="float:left;"><div class="paddeditem" style="width:auto;">'.$i.'</div></div>';	
}
}	
	
echo '<div style="float:left;"><div class="paddeditem" style="width:auto;">...</div></div>';	

echo '<a href="papers.php?start='.(($pagecount-1)*20).'&&'.$getcond.'" style="text-decoration:none;"><div style="float:left;"><div class="lightitem" style="width:auto;">'.$pagecount.'</div></div></a>';	
	
	
	
}
	
}
	
}


?>

</div>

</div>





 
</body>

</html>