<?php
header("content-type: none");
header('Content-Disposition: inline; filename="' . basename("districts.kml") . '"');
//$district_kml = file_get_contents("districts.kml");
$district_kml = file_get_contents('districts.kml');


$myVar = htmlspecialchars($district_kml, ENT_QUOTES);

echo $myVar;
?>