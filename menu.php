<div class="menu"> 



<div class="menustyle">
    <span class="menuitem"><a href="about.php" class="menuitemlink" style="width: 150px;">Об университете</a></span>
	<span class="menuitem"><a href="search.php" class="menuitemlink" style="width: 150px;">Поиск по сайту</a></span>
    <span style="
    display: inline-block; /* Строчно-блочные элементы */
    //background: #CA181A; /* Цвет фона */
    margin-right: 3px; /* Расстояние между пунктами меню */
   width: 140px;

"><a  id="menubutton1" href="#" onclick="this_div=document.getElementById('subm');
 this_div2=document.getElementById('menubutton1');
 this_div2.className=(this_div.style.display=='table-cell')?'menuitemlink':'menuitemlinkdown';  
 this_div.style.display=(this_div.style.display=='table-cell')?'none':'table-cell';
return false;" class="menuitemlink">Студенты</a>
<div class="submenu" id="subm" style="display:none; width: 140px;">
        <span class="menuitem2"><a href="studentsearch.php" class="menuitemlink2">Поиск по фамилии</a></span>
        <span class="menuitem2"><a href="univers.php" class="menuitemlink2">Университеты</a></span>
		<span class="menuitem2"><a href="faculties.php" class="menuitemlink2">Факультеты</a></span>
		<span class="menuitem2"><a href="departments.php" class="menuitemlink2">Кафедры</a></span>
		<span class="menuitem2"><a href="specialities.php" class="menuitemlink2">Направления</a></span>
		<span class="menuitem2"><a href="groups.php" class="menuitemlink2">Группы</a></span>
		
		
      </div>

</span>
   
	<?php
	
	session_start();
	include('auth.php');
	
	 if ($_SESSION['moder']>0)
		  {
		
		  echo '<span class="menuitem" style="float: left;"><a href="moder.php" class="menuitemlink" >Панель модератора</a></span>';
		  
		  }
		
		  if ($_SESSION['auth']==0)
		  {
		
		  echo '<span class="menuitem" style="float: right;"><a href="login.php" class="menuitemlink" >Вход</a></span>';
		  
		  }
		  else if ($_SESSION['auth']==1)
		  {
		  echo '<span class="menuitem" style="float: right;"><a href="user.php" class="menuitemlink" >'.htmlspecialchars($_SESSION['username']).'</a></span>'; 
		  }

		
		?>
</div>

  </div>