<?php
include('../include/config.php');
$dbConn=getDBConnection();

$code=$_REQUEST['code'];

?>

<option value="cir"> Select Circle</option>
<?php
$stmt= $dbConn->prepare("SELECT * FROM lov_circle WHERE company_code=:company_code");
$stmt->execute(array(':company_code' =>$code));
if($stmt->rowCount() > 0){				 									
while($row=$stmt->FETCH(PDO::FETCH_ASSOC)){?>
<option  value="<?php  echo trim($row['circle_code']);?>"> <?php echo $row['circle_code']." ---- ".$row['circle_name']; ?> </option>
<?php } ?>
<?php }?>
