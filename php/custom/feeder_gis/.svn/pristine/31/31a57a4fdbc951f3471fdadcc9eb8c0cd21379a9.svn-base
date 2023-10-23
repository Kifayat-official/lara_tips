<?php
/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/
include('include/config.php');
$dbC=getDBConnection();

date_default_timezone_set("Asia/Karachi");

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header('Content-Type: application/json');

$sdiv_cd = (isset($_GET['sdiv_cd']) ? $_GET['sdiv_cd'] : 0);
$lat = (isset($_GET['lat']) ? $_GET['lat'] : 0);
$lng = (isset($_GET['lng']) ? $_GET['lng'] : 0);

if($sdiv_cd>0 && $lat>0 && $lng>0){
	

			/*$dbh='localhost';
			$dbu='root';
			$dbp='';
			$dbn='gis_disco';

			$dbG = "";

			try {
				$dbC = new PDO("mysql:host=$dbh;dbname=$dbn", $dbu, $dbp);	
				$dbC->exec("set names utf8");
				$dbC->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
				

			}
			catch (PDOException $e) {
				$dbG = null;
				echo 'Connection failed: ' . $e->getMessage(); exit();
			}	*/


		$dbG=$dbC;

		//$dbtbl = "electricity_db";
		
		try { 

		 $fdr_query = "SELECT FEEDER_CODE,FDRNAME,SDIVCODE, SDIVNAME,LATITUDE,LONGITUDE,dist as distance from (SELECT FEEDER_CODE,FDRNAME,SDIVCODE, SDIVNAME,LATITUDE,LONGITUDE,round(distance,2) as dist FROM ( SELECT *, ( ( ( acos( sin(('$lat' * pi() / 180)) * sin(( `LATITUDE` * pi() / 180)) + cos(('$lat' * pi() /180 )) * cos(( `LATITUDE` * pi() / 180)) * cos((('$lng' - `LONGITUDE`) * pi()/180))) ) * 180/pi() ) * 60 * 1.1515 * 1.609344 ) as distance FROM `vw_consumers_xy` WHERE SDIVCODE='$sdiv_cd') vw_consumers_xy where distance <100 ORDER BY distance ) vw_consumers_xy group by feeder_code ORDER BY distance";	//radius 100. get 10 most nearest records
 
					  

		
		$out_row = array();

		$stmtFDR 	= $dbG->prepare($fdr_query);

		$stmtFDR->execute();

		if($stmtFDR->rowCount() > 0){
			 
			while($row=$stmtFDR->FETCH(PDO::FETCH_ASSOC)){

						array_push($out_row, array(	
										"SDIVCODE" => $row['SDIVCODE'],
										"SDIVNAME" => $row['SDIVNAME'],
										"MIN_LATITUDE" => $row['LATITUDE'],
										"MIN_LONGITUDE" => $row['LONGITUDE'],
										"MAX_LATITUDE" => $row['LATITUDE'],
										"MAX_LONGITUDE" => $row['LONGITUDE'],
										"FEEDER_CODE" => $row['FEEDER_CODE'],
										"FDRNAME" => $row['FDRNAME']
									)
						 );
					}
				}	
			

		echo json_encode( array('date' => date("d/m/Y"), 'data' => $out_row) ); 

	}catch(Exception $e) {
	  $err = 'Message: ' .$e->getMessage();
	  echo json_encode( array('date' => date("d/m/Y"), 'data' => array("INVALID_QUERY_PARAM")) ); 
	}
}else{
	echo json_encode( array('date' => date("d/m/Y"), 'data' => array("INVALID_SDIV_CODE")) ); 
}

?>