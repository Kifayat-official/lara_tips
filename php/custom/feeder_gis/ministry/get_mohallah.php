<?php
 
include_once('db.php');
$dbConn = getDB();

$code=$_REQUEST['tehsil_name'];


?>
<option value="mohal"> Select Mohallas</option>
<?php

$stmtquery= "SELECT  area FROM `tbl_dis_teh_feed`  WHERE tehsil_code='$code'";
$stmt=$dbConn->prepare($stmtquery);
$stmt->execute();

if($stmt->rowCount() > 0){                                              
while($row=$stmt->FETCH(PDO::FETCH_ASSOC)){?>

<option  value="<?php echo trim($row['area']);?>"> <?php echo $row['area'];?> </option>

<?php } }?>
