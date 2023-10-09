<?php
 include('../include/config.php');
 $dbConn=getDBConnection();

$code=$_REQUEST['code'];


?>
<option value="div"> Select Division</option>
<?php


$stmt4 = $dbConn->prepare("SELECT * FROM lov_division WHERE circle_code=:circle_code");
$stmt4->execute(array(':circle_code' =>$code));
if($stmt4->rowCount() > 0){	
			 									
while($row4=$stmt4->FETCH(PDO::FETCH_ASSOC)){?>
<option  value="<?php echo trim($row4['division_code']);?>"> <?php echo $row4['division_code']." ---- ".$row4['division_name']; ?> </option>
<?php } 
}?>
 