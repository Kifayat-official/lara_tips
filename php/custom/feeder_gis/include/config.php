<?php

define("BASE_URL", "http://FeederWise_gis/");

define('TITLE', 'GIS');





function getDBConnection()

{

	$dbhost = 'localhost';

	$dbuser = 'feeder_user';

	$dbpass = 'fiKerPRL6zJXtOZ#1';

	$dbname = 'gis_disco';

	try {

		$dbConnection = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);

		$dbConnection->exec("set names utf8");

		$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		return $dbConnection;
	} catch (PDOException $e) {

		echo 'Connection failed: ' . $e->getMessage();
	}
}
