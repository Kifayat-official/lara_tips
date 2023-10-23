<?php
date_default_timezone_set("Asia/Karachi");
session_start();
include('../include/config.php');
$conn = getDBConnection();
$errorMsg='none';

if(isset($_POST['submit']))
{
    $user_name=$_POST['user_name'];
    $password=$_POST['password'];
	
	if(trim($user_name) =='' || trim($password)==''){
		$errorMsg='block';
	}else{
		
		  $check_query = "SELECT * 
						FROM `login_gis` 
						WHERE 
						user_id=:uname and 
						user_password = :upassword and 
						status=1 
					   ";
					
		  $check_query_fo = $conn->prepare($check_query);
		  $check_query_fo->bindParam(':uname', $user_name, PDO::PARAM_STR);
		  $check_query_fo->bindParam(':upassword', $password, PDO::PARAM_STR);
		  $result = $check_query_fo->execute();
		  $row = $check_query_fo->fetch();
		  
		  if ($row) {
			  $_SESSION['islogin']='1';
			   header('location:index2.php');
		  }else{
				$errorMsg='block';

		  }
	
	}
   
}




?>

 <!DOCTYPE html>
<html dir="ltr" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta
      name="keywords"
      content="wrappixel, admin dashboard, html css dashboard, web dashboard, bootstrap 5 admin, bootstrap 5, css3 dashboard, bootstrap 5 dashboard, Matrix lite admin bootstrap 5 dashboard, frontend, responsive bootstrap 5 admin template, Matrix admin lite design, Matrix admin lite dashboard bootstrap 5 dashboard template"
    />
    <meta
      name="GIS"
      content="Feeder Load Shedding"
    />
    <meta name="robots" content="noindex,nofollow" />
    <title>GIS</title>
    <!-- Favicon icon -->
    <link
      rel="icon"
      type="image/png"
      sizes="16x16"
      href="../assets/images/favicon_ministry.png"
    />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  </head>
<script type="text/javascript">
    $(document).ready( function(){
         $('#main_div').show('slow');
    })
       
    
</script>


<style type="text/css">
    body {
        height: 100vh;
        width: 100%;
        background-image: url("bg_login.png");
        background-repeat: no-repeat;
        background-size: cover;

    }
    
#main_div{
    
    margin-top: 10%;
    background: black;
    display: none;
    color: white;
    border-radius: 10px;
    box-shadow: 0px 1px 2px 0px rgba(204, 204, 179,0.7),
            1px 2px 4px 0px rgba(204, 204, 179,0.7),
            2px 4px 8px 0px rgba(204, 204, 179,0.7),
            2px 4px 16px 0px rgba(204, 204, 179,0.7);

}
#form_div{
    margin-top: 10px;
    text-align: center;
    padding: 10px;
    margin-bottom: 10px;
}
</style>
<body>
    <div class="container-fluid">
        
        <div class="row">       
              <div class="col-md-4 offset-md-4" id="main_div">
                <div id="form_div" >
                    <img src="../assets/images/ministry.png" style="height:60px; width:60px;margin-bottom:20px;" />
                    <form  method="post" action="#">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="font-size: 12px;display: <?php echo $errorMsg;?>;">
                           Error! Invalid Login ID or Password.
                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                      <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-4 col-form-label">Login ID:</label>
                        <div class="col-sm-8">
                          <input required type="text" class="form-control" name='user_name' id="user_name" placeholder="Enter Login ID">
                        </div>
                      </div>
                      <div class="row mb-3">
                        <label for="inputPassword3" class="col-sm-4 col-form-label">Password:</label>
                        <div class="col-sm-8">
                          <input required type="password" class="form-control"  name='password' id="password" placeholder="Enter Password">
                        </div>
                      </div>
                      <input type="submit" class="btn btn-success" name='submit' value="Login"/>
                    </form>
                </div>
              </div> 

                    
        </div>
                        

    </div>
    </body>

    </html>