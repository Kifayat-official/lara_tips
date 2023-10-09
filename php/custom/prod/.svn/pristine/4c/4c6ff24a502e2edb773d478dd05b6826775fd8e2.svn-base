<?php
 include('../include/config.php');
 $dbConn=getDBConnection();

$code=$_REQUEST['code'];

?>
<option value="tehsil"> Select Tehsils</option>
<?php


$stmt= $dbConn->prepare("SELECT * FROM `lov_tehsil` WHERE district_code=:district_code");
$stmt->execute(array(':district_code' =>$code));
if($stmt->rowCount() > 0){	
			 									
while($row=$stmt->FETCH(PDO::FETCH_ASSOC)){?>
<option  value="<?php echo strtoupper(trim($row['tehsil_name']));?>"> <?php echo $row['tehsil_name']; ?> </option>
<?php } 
}?>
 