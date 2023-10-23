<?php
 
include('../include/config.php');
 $dbConn=getDBConnection();

 $code=$_REQUEST['code'];


$row=array();
?>
 
<?php

$stmtquery= "SELECT DISTINCT LATITUDE,LONGITUDE,FDRNAME,FEEDER_CODE FROM `consumers_xy`  WHERE FEEDER_CODE='$code' ORDER BY LATITUDE,LONGITUDE LIMIT 1";
$stmt=$dbConn->prepare($stmtquery);
$stmt->execute();

if($stmt->rowCount() > 0){                                              
    $row_data=$stmt->FETCH(PDO::FETCH_ASSOC);
$row['lat']=$row_data['LATITUDE'];
$row['lon']=$row_data['LONGITUDE'];

}
echo json_encode($row);