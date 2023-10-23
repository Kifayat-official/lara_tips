<?php

include('../include/config.php');
 $dbConn=getDBConnection();

$mohallah=$_REQUEST['address'];


?>
<option value="feeder"> Select feeders</option>
<?php

$stmtquery= "SELECT DISTINCT feeder_code,feeder_name FROM `tbl_dis_teh_feed` WHERE  area='$mohallah'";
$stmt=$dbConn->prepare($stmtquery);
$stmt->execute();

if($stmt->rowCount() > 0){                                              
while($row=$stmt->FETCH(PDO::FETCH_ASSOC)){?>

<option  value="<?php echo trim($row['feeder_code']);?>"> <?php echo $row['feeder_code'];?>- <?php echo $row['feeder_name'];?> </option>

<?php } }?>