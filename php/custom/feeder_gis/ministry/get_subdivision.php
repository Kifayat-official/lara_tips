<?php
 
include('../include/config.php');
 $dbConn=getDBConnection();

$code=$_REQUEST['code'];



?>
<option value="subdiv"> Select SubDivision</option>
<?php
  $subdivCode=substr($code,0,4);
    $where="sdiv_code like "."'".$subdivCode."%'";



$stmtquery= "SELECT * FROM `all_sdiv_distrticts`  WHERE ".$where;
$stmt=$dbConn->prepare($stmtquery);
$stmt->execute();

if($stmt->rowCount() > 0){			 									
while($row=$stmt->FETCH(PDO::FETCH_ASSOC)){?>
<option  value=<?php echo trim($row['sdiv_code']);?> > <?php echo $row['sdiv_code']." ---- ".$row['sdiv_name']; ?> </option>
<?php } }?>
