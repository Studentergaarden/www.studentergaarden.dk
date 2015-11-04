<?php
session_start();
require_once("db.php");
require_once("styler.php");


$mysqli = DB::getMysqli();

$curPage     = DB::getGetValues("page", $mysqli, 0); 
$curLanguage = DB::getGetValues("lan", $mysqli, "da"); 
$altLanguage = ($curLanguage == "da") ? "en"  : "da";
$altLanLabel = ($curLanguage == "da") ? "Eng" : "Dansk";

$query = "select $curLanguage as content from sites where id=$curPage";
$result = $mysqli->query($query);
$resultArr = $result->fetch_array(MYSQLI_ASSOC);
createSite($resultArr['content'], $curPage,$curLanguage,$altLanguage, $altLanLabel);

?>
