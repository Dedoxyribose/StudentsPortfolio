<script type="text/javascript" src="blowfish.js"></script>
<script type="text/javascript" src="md5.js"></script>


<?php
session_start();

?>





<table>
<tr>
<td>

<img src="door.png"/>

</td>
<td style="vertical-align: top;">

<span class="bigtext">Вход</span><br><br>
<form method="post" action="login.php" class="medtext">Введите ваши данные:<br>


<table style="margin-top:10px;">
  <tr>
    <td class="medtext">Логин: </td>
	<td> <input name="username" id="login" type="text" maxlength="20" size="25" value="" class="medtext"/></td>
  </tr>
  <tr>
	 <td class="medtext">Пароль: </td>
	<td> <input name="password" id="fpassword" type="password" maxlength="20" size="25" value="" class="medtext"/></td>
	<td> <input name="fpassword" id="password" style="display:none;" type="password" maxlength="60" size="25" value="" class="medtext"/></td>
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
<td style="text-align:right;">
<input name="log" id="subm1" type="submit" style="display:none;" value="Войти" class="medtext"/>
<div class="lightitem" onclick="send()" style="text-align:center; width: 240px; margin:auto; cursor: pointer;">Войти</div>
</td>
</tr> 

</table>


  
</form>
<br>

Если у вас ещё нет своего аккаунта, необходимо <a href="register.php" style="color: #000000;"> зарегистрироваться</a>.

</td>
</tr>
</table>

<script>


<?php

$_SESSION['salt']=md5(microtime());

?>

var salt='<?php echo $_SESSION['salt']; ?>';


function send()
{
	

	
var login=document.getElementById('login').value;	
var password=document.getElementById('fpassword').value;







document.getElementById('password').value=blowfish.encrypt(MD5(password), salt, {cipherMode: 0, outputType: 1});





document.getElementById('subm1').click();


	
}

</script>
