<?php
 
include('../include/config.php');
 $dbConn=getDBConnection();

$code=$_REQUEST['code'];


 $stmtquery= "SELECT DISTINCT FEEDER_CODE as feeder_code,FDRNAME as feeder_name FROM `consumers_xy`  WHERE sdivcode='$code'"; 


?>
<option value="feeder_sdiv"> Select feeders</option>
<?php
$stmt=$dbConn->prepare($stmtquery);
$stmt->execute();

if($stmt->rowCount() > 0){                                              
while($row=$stmt->FETCH(PDO::FETCH_ASSOC)){?>

<option  value="<?php echo trim($row['feeder_code']);?>"> <?php echo $row['feeder_code'];?>- <?php echo $row['feeder_name'];?> </option>

<?php } }?>
