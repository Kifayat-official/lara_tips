<?php
 include('../include/config.php');
 $dbConn=getDBConnection();

$code=$_REQUEST['code'];

?>
<option value="dis"> Select District</option>
<?php


$stmt= $dbConn->prepare("SELECT * FROM lov_district WHERE company_code=:disco_code");
$stmt->execute(array(':disco_code' =>$code));
if($stmt->rowCount() > 0){	
			 									
while($row=$stmt->FETCH(PDO::FETCH_ASSOC)){?>
<option  value="<?php echo trim($row['district_code']);?>"> <?php echo $row['district_name']; ?> </option>
<?php } 
}?>
 