<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="de">
<!--<![endif]-->

<body style=" height:600px;">
<script type="text/javascript" src="js/libs/fancybox/jquery.fancybox.js?v=2.1.3"></script>
<script type="text/javascript" src="js/libs/jquery-1.8.2.min.js"></script>
<script type="text/javascript" src="js/libs/fancybox/jquery.fancybox.js?v=2.1.3"></script>

<script type="text/javascript" src="js/libs/jquery.masonry.min.js"></script>
<script type="text/javascript" src="js/libs/modernizr-transitions.js"></script>

<?php 

include "php/config.php" ;

if(!empty($_GET['pwcode']) && !empty($_GET['userid']))
{
	$pwcode = $_GET['pwcode'];
	
	$userid = $_GET['userid'];
	
	$result = mysql_query("SELECT * FROM user WHERE user_id = '".$userid."'");
			if ($row = mysql_fetch_object($result))
			{
			$email = $row->email;
			$passwort = $row->password;
	
		
			$str = $email.$passwort.$userid;
			$hashcode =  md5($str);
			
			
			if($hashcode == $pwcode)
			{
				echo $str;
				echo "passwort ändern formular";
			
			
			//neues Passwort genieren
				
   			mt_srand ((double) microtime() * 1000000);
   			$passwd = "";
  			$chars = "0123456789ABCDEFGHabcdefghijklmnopqrstuvwxyz";
  			for ($k = 0; $k < 8; $k += 1)
   			{
    			$num = mt_rand(0, strlen($chars)-1);
    		 	$passwd .= $chars[$num];
   			}
			
			
			$newpw = md5($passwd);
				$sql = "UPDATE user SET password = '$newpw'  WHERE user_id = '$userid';" ;
 				$result = mysql_query($sql);
			
			// hier wird mail versand
			
			$empfaenger = $email;
			$betreff = "Neues Passwort paperly.de";
			$from = "From: Paperly <mail@paperly.de>";
			$text = "Dein neues Passwort lautet: ".$passwd ." Logge Dich mit dem neuen Passwort auf  http://paperly.de ein und passe es Unter Mein Profil-> Einstellungen an";

	mail($empfaenger, $betreff, $text, $from);
  				
	
			}
		
		 	
			}
}
else
{








if(!empty($_POST['EMail']))
{
	
	//echo "Dir wurde ein bestäätigungslink geschickt!!";
	
	
	
	//Prüfen ob die mail adresse bei uns im system ist
	$email = $_POST['EMail'];
	$result = mysql_query("SELECT * FROM user WHERE email = '$email'");
	
	if ($row = mysql_fetch_object($result))
	{
		$userid = $row->user_id;
		
		$passwort = $row->password;
		echo "Du hast soeben eine E-Mail mit Deinem neuen Passwort geschickt bekommen.<br/>";
		
		$str= $email.$passwort.$userid;
		
		$hashcode =  md5($str);
		
		
		
	
	
	$empfaenger = $email;
	$betreff = "Passwortvergessen paperly.de";
	$from = "From: Paperly <mail@paperly.de>";
	$text = "Du hast anscheinend Dein Passwort vergessen. Hier kannst du Dein Passwort ändern: http://prebeta.paperly.de/index.php?pwcode=".$hashcode."&userid=".$userid;

	mail($empfaenger, $betreff, $text, $from);

	echo "<script type='text/javascript'>
	$(document).ready(function(){
		setInterval(function(){parent.jQuery.fancybox.close()},3000);
 	
	 })</script>";
	}
	
	else
	{
		echo "Die angegebene E-Mail Adresse ist nicht in unserem System vorhanden.";
	}
	
	
	
	
	
	
	
	
	
	}
	else
	{




?>




            <div id="" style="">
                 <form class="login-form" method="post" action="passwortvergessen.php" enctype="multipart/form-data">
                <p>Du hast Dein Passwort vergessen? Trage hier Deine E-Mail Adresse ein:</p>
                <fieldset class="login-fieldset">
                  <legend class="login-legend"></legend>
                  
                    <label class="login-label" for="loginEMail" >Email-Adresse:</label></br>
                    <input id="loginEMail" class="login-field" type="email" required value="" name="EMail" style=" width:200px;"> <input class="" type="submit" name="" value="Abschicken" style=" width: 100px; height:30px;">
                
                </fieldset>
              </form>

    </div>
    
    <?php }} ?>

</body>
</html>
