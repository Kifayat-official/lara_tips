<?php
header('Content-Disposition: inline; filename="' . basename("districts.kml") . '"');
header('Content-type: none');
header('alt-svc: h3=":443"; ma=2592000,h3-29=":443"; ma=2592000,h3-Q050=":443"; ma=2592000,h3-Q046=":443"; ma=2592000,h3-Q043=":443"; ma=2592000,quic=":443"; ma=2592000; v="46,43"');
//$district_kml = file_get_contents("districts.kml");
$district_kml = file_get_contents('districts.kml');


$myVar = htmlspecialchars($district_kml, ENT_QUOTES);

echo htmlspecialchars_decode($myVar);
?>