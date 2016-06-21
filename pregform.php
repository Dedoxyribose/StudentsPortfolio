<table>
<tr>
<td style="vertical-align: top;">

<img src="door.png"/>

</td>
<td style="vertical-align: top;">



<span class="bigtext">Регистрация преподавателя</span><br><br>

<?php
echo '<span class="medtext" style="color: red;">'.$_GLOBALS['msg'].'</span><br>';
?>

<form method="post" action="register.php?as=prepod" class="medtext">Введите ваши данные:<br>


<table style="margin-top:10px; border-spacing: 15px" class="medtext">
  <tr>
    <td>Логин*: </td>
	<td> <input name="username" type="text" maxlength="20" size="25" value="" /></td>
  </tr>
    <tr>
	 <td >Фамилия*: </td>
	<td> <input name="surname" type="text" maxlength="20" size="25" value="" /></td>
  </tr> 
  <tr>
	 <td>Имя*: </td>
	<td> <input name="name" type="text" maxlength="20" size="25" value="" /></td>
  </tr> 
  <tr>
	 <td>Отчество: </td>
	<td> <input name="lastname" type="text" maxlength="20" size="25" value="" /></td>
  </tr> 
  <tr>
	 <td>Пароль*: </td>
	<td> <input name="password" type="password" maxlength="20" size="25" value="" /></td>
  </tr> 
  <tr>
	 <td>Пароль ещё раз*: </td>
	<td> <input name="rpassword" type="password" maxlength="20" size="25" value="" /></td>
  </tr> 
  <tr>
	 <td>E-mail*: </td>
	<td> <input name="email" type="text" maxlength="80" size="25" value="" /></td>
  </tr>
  <tr>
  <td colspan="2">
  <?php
  require_once('recaptchalib.php');
  $publickey = "6LeP3CITAAAAAJoeuxHsiAM5N2O8aE8ue6uF-zM0"; // you got this from the signup page
  echo recaptcha_get_html($publickey);
	?>
  </td>
  </tr>
  <tr>
  <td>
  </td>
  <td class="medtext" style="text-align:right;">
  <input type="submit" name="log" value="Зарегистрироваться" />
  </td>
  </tr>
</table>



</form>
<br>



</td>
</tr>
</table>


