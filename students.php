<html>
<head>
<title>site</title>
<META content="text/html; charset=utf-8" http-equiv="Content-Type">
<link href="style.css" rel="stylesheet" type="text/css" />

</head>

<body>




<div>
<span class="subtitle"> Список студентов </span> <br/> <br/>

<div class="list">

<?php if(file_exists('keys.php')) include 'keys.php'; 

include('auth.php');

session_start();

mysql_connect($hostname,$username,$password) OR DIE("Не могу создать соединение"); 
mysql_select_db($dbName) or die(mysql_error());  


$userstable = "departments"; 

$start=0;
$moder=false;
$styl="cursor: pointer; border: 3px solid #444343;";

if(isset($_GET['start']))
$start=(int)$_GET['start'];

$sqlcond="";
$getcond="";
if(isset($_GET['groupid']))
{
$sqlcond=sprintf(" AND `groups`.id='%s'", mysql_real_escape_string($_GET['groupid']));
$getcond="groupid=".$_GET['groupid']."&&";
}
if(isset($_GET['speciality']))
{
$sqlcond=sprintf(" AND `specialities`.id='%s'", mysql_real_escape_string($_GET['speciality']));
$getcond="speciality=".$_GET['speciality']."&&";
}
if(isset($_GET['department']))
{
$sqlcond=sprintf(" AND `departments`.id='%s'", mysql_real_escape_string($_GET['department']));
$getcond="department=".$_GET['department']."&&";
}
if(isset($_GET['faculty']))
{
$sqlcond=sprintf(" AND `faculties`.id='%s'", mysql_real_escape_string($_GET['faculty']));
$getcond="faculty=".$_GET['faculty']."&&";
}
if(isset($_GET['univer']))
{
$sqlcond=sprintf(" AND `univers`.id='%s'", mysql_real_escape_string($_GET['univer']));
$getcond="univer=".$_GET['univer']."&&";
}
if(isset($_GET['verif']))
{
$sqlcond=sprintf(" AND `students`.verif='%s'", mysql_real_escape_string($_GET['verif']));
$getcond="verif=".$_GET['verif']."&&";
}
else
{
$sqlcond=" AND `students`.verif=1";
$getcond="verif=1&&";	
}
if(isset($_GET['surname']))
{
$sqlcond=sprintf(" AND `students`.surname='%s'", mysql_real_escape_string($_GET['surname']));
$getcond="surname=".$_GET['surname']."&&";
}
if(isset($_GET['moder']) && $_SESSION['moder']>0)
{
$styl="cursor: pointer;";
$moder=true;
$getcond=$getcond."moder=".$_GET['moder']."&&";
}
if(isset($_GET['id']) && $moder)
{


$query=sprintf("UPDATE students SET verif=1 WHERE id='%s'", mysql_real_escape_string($_GET['id']));

$res = mysql_query($query) or die(mysql_error()); 
}



$query="SELECT COUNT(*) FROM `students`, `groups`,`specialities`, `departments`, `faculties`, `univers` WHERE 
`students`.groupid=`groups`.id AND 
`groups`.speciality=`specialities`.id AND `specialities`.department=`departments`.id AND `departments`.faculty=`faculties`.id AND `faculties`.univer=`univers`.id".$sqlcond." ORDER BY `univers`.id";

if ($moder) 
{
$query="SELECT COUNT(*) FROM `students` WHERE `students`.id>0 ".$sqlcond." ORDER BY id";
}



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


$query="SELECT `students`.id as s_id, `students`.surname as s_sn, `students`.name as s_n, `students`.lastname s_ln, `groups`.code as g_c, `students`.verif as s_ver FROM `students`, `groups`,`specialities`, `departments`, `faculties`, `univers` WHERE 
`students`.groupid=`groups`.id AND 
`groups`.speciality=`specialities`.id AND `specialities`.department=`departments`.id AND `departments`.faculty=`faculties`.id AND `faculties`.univer=`univers`.id".$sqlcond." ORDER BY `univers`.id";


if ($moder) 
{
$query="SELECT `students`.id as s_id, `students`.surname as s_sn, `students`.name as s_n, `students`.lastname s_ln FROM `students` WHERE `students`.id>0 ".$sqlcond." ORDER BY id";
}
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
echo '<table width="100%" style=$moder rules="all">';
while ($row=mysql_fetch_array($res))
{
?>
<tr class="item" style="<?php echo $styl;?>"  >
<?php 
if ($moder==true)
{
?>
	
<td width="10%" style="<?php echo $styl;?>" onclick="window.top.location.href='student.php?id=<?php echo $row['s_id'];?>'; return false;"><div class="paddeditem" style="font-size: 16pt;"><?php echo $row['s_id'];?></div>
</td>	
	
<?php
}
?>
<td width="75%" style="<?php echo $styl;?>" onclick="window.top.location.href='student.php?id=<?php echo $row['s_id'];?>'; return false;"><div class="paddeditem" style="font-size: 16pt;"><?php echo htmlspecialchars($row['s_sn'])." ".htmlspecialchars($row['s_n'])." ".htmlspecialchars($row['s_ln']);?></div>
</td>
<?php 
if ($moder!=true)
{
?>
<td style="<?php echo $styl;?>">
<div  class="paddeditem"  style="font-size: 16pt;" onclick="window.top.location.href='student.php?id=<?php echo $row[0];?>'; return false;"><?php echo htmlspecialchars($row['g_c']);?></div>
</td>

<?php
}
?>

<?php 
if ($moder==true)
{
?>
	
<td  class="lightitem" onclick="window.location.href='students.php?id=<?php echo $row['s_id'].'&&'.$getcond;?>'; return false;"><div class="paddeditem" style="font-size: 16pt; width:100px;">Подтвердить</div>
</td>	
	
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
echo '<a href="students.php?start='.(($i-1)*20).'&&'.$getcond.'" style="text-decoration:none;"><div style="float:left;"><div class="lightitem" style="width:auto;">'.$i.'</div></div></a>';
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
echo '<a href="students.php?start='.(($i-1)*20).'&&'.$getcond.'" style="text-decoration:none;"><div style="float:left;"><div class="lightitem" style="width:auto;">'.$i.'</div></div></a>';
}
else
{
echo '<div style="float:left;"><div class="paddeditem" style="width:auto;">'.$i.'</div></div>';	
}
}
echo '<div style="float:left;"><div class="paddeditem" style="width:auto;">...</div></div>';	

echo '<a href="students.php?start='.(($pagecount-1)*20).'&&'.$getcond.'" style="text-decoration:none;"><div style="float:left;"><div class="lightitem" style="width:auto;">'.$pagecount.'</div></div></a>';	
	
}
else if ($count-$start<=60)	
{
	
echo '<a href="students.php?start=0&&'.$getcond.'" style="text-decoration:none;"><div style="float:left;"><div class="lightitem" style="width:auto;">1</div></div></a>';	

echo '<div style="float:left;"><div class="paddeditem" style="width:auto;">...</div></div>';
	
for ($i=$start/20; $i<=$pagecount; $i++)
{
if ((($i-1)*20)!=$start)
{
echo '<a href="students.php?start='.(($i-1)*20).'&&'.$getcond.'" style="text-decoration:none;"><div style="float:left;"><div class="lightitem" style="width:auto;">'.$i.'</div></div></a>';
}
else
{
echo '<div style="float:left;"><div class="paddeditem" style="width:auto;">'.$i.'</div></div>';	
}
}


	
}
else
{
	
echo '<a href="students.php?start=0&&'.$getcond.'" style="text-decoration:none;"><div style="float:left;"><div class="lightitem" style="width:auto;">1</div></div></a>';	

echo '<div style="float:left;"><div class="paddeditem" style="width:auto;">...</div></div>';
	
for ($i=$start/20; $i<=$start/20+2; $i++)
{
if ((($i-1)*20)!=$start)
{
echo '<a href="students.php?start='.(($i-1)*20).'&&'.$getcond.'" style="text-decoration:none;"><div style="float:left;"><div class="lightitem" style="width:auto;">'.$i.'</div></div></a>';
}
else
{
echo '<div style="float:left;"><div class="paddeditem" style="width:auto;">'.$i.'</div></div>';	
}
}	
	
echo '<div style="float:left;"><div class="paddeditem" style="width:auto;">...</div></div>';	

echo '<a href="students.php?start='.(($pagecount-1)*20).'&&'.$getcond.'" style="text-decoration:none;"><div style="float:left;"><div class="lightitem" style="width:auto;">'.$pagecount.'</div></div></a>';	
	
	
	
}
	
}
	
}


?>

</div>

</div>





 
</body>

</html>