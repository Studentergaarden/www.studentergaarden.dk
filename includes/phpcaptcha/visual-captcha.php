<?php
/*
require('php-captcha.inc.php');
$aFonts = array('fonts/VeraBd.ttf', 'fonts/VeraIt.ttf', 'fonts/Vera.ttf');
$oVisualCaptcha = new PhpCaptcha($aFonts, 200, 60);
$oPhpCaptcha->UseColour(true);
$oVisualCaptcha->Create();
*/
// include captcha class
require('php-captcha.inc.php');
// define fonts
$aFonts = array('fonts/VeraBd.ttf', 'fonts/VeraIt.ttf', 'fonts/Vera.ttf');
// create new image
$oPhpCaptcha = new PhpCaptcha($aFonts, 200, 50);
$oPhpCaptcha->UseColour(true);
$oPhpCaptcha->Create();



?>
