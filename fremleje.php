<?php
header('Content-Type: text/html; charset=utf-8');
require_once("styler.php");
require_once("includes/phpcaptcha/php-captcha.inc.php");

$action = array_key_exists("action", $_GET) ? $_GET["action"] : "";
$value = array_key_exists("page", $_GET) ? $_GET["page"] : 0;
$curLanguage = array_key_exists("lan", $_GET) ? $_GET["lan"] : "da";
$altLanguage = ($curLanguage == "da") ? "en"  : "da";
$altLanLabel = ($curLanguage == "da") ? "Eng" : "Dansk";

$content = "";

if($action){

	
	if (!PhpCaptcha::Validate(strtoupper($_POST['user_code']))) {
	  die("You have not the five control letters correctly. Try again<br><br><a href=fremleje.php?language=english>back</a>");
	}

	require_once("includes/phpmailer/class.phpmailer.php"); //Extern funktion PHPmailer
	$subject    = $_POST["subject"]; //Brevets subject
	$content    = $_POST["content"]; //Brevets indhold
	$name       = $_POST["name"];    //Afsenders navn
	$email      = $_POST["email"];   //Afsenders e-mail adresse
	$mobil	    = $_POST["mobil"];	//Afsenders mobilnummer

	$phpmail = new PHPMailer();
	$phpmail->CharSet = 'UTF-8';

	$phpmail->isHTML(false);
	$phpmail->Subject  =  stripslashes($subject).'';
	// convert to html.
	//$phpmail->Body  =  stripslashes(str_replace("\n","<br />",$content));
	$phpmail->Body  =  stripslashes($content);
	$phpmail->Body  .= "\n\nØnske om fremleje skrevet på www.studentergaarden.dk af: $name, $mobil, $email";
	$phpmail->Body  .= "\nHusk at $name ikke kan læse dette forum. Kontakt vedkommende på mail eller mobil.";
	$phpmail->From     = $email;
	$phpmail->FromName = $name;
	//$phpmail->AddReplyTo($email,$name);
	   	
	$phpmail->AddAddress('fremlejer@studentergaarden.dk','fremlejer@studentergaarden.dk');
	//$phpmail->AddAddress('pawsen@gmail.com','pawsen@gmail.com');


	if(!$phpmail->Send())
	{
		$content .= "Mailer Error: " . $phpmail->ErrorInfo;
	}else{
		$content .= "Your application has been emailed to Studentergårdens mailingslist for subletting <br>";
	}
}

$content .= '<h2>Write an application to Studentergården mailing list for subletting</h2>
<form action="?action=opret" name="writeForm" method="post">
<table>
<tr><td width="500px">
Name
</td>
 <td><input type=text name="name" size=20 class="entry">
 </td></tr>  
 <tr><td>
Email adress
</td>
 <td><input type=text name="email" size=40 class="entry">
 </td></tr>
 <tr><td>
Cellphone
</td>
 <td><input type=text name="mobil" size=40 class="entry">
 </td></tr>
 <tr><td>
Subject
</td>
 <td><input type=text name="subject" size=20  class="entry">
 </td></tr>
 <tr><td>
Text
</td>
 <td><textarea name="content" cols=50 rows=8 wrap=virtual class="entry"></textarea> 
 </td></tr>
<tr><td></td><td><img src="includes/phpcaptcha/visual-captcha.php" width="200" height="60" alt="Visual CAPTCHA" /></td></tr>
	<tr><td>
</td>
 <td><input type=text name="user_code" size=20  class="entry">
 </td></tr>
<tr><td colspan="2">
</td></tr>

<script language="javascript">
var updated=0;
function submitOnce()
{
  if (!updated) document.writeForm.submit();
  updated=1;
} 
</script>

<tr><td colspan=2>
<input type="submit" value="Send Email" class="entry">

</td></tr> 
</table></form>';

createSite($content, 0, $curLanguage, $altLanguage, $altLanLabel);

?>
