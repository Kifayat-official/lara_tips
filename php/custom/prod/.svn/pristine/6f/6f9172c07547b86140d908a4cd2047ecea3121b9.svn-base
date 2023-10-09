<?php
session_start();
if (isset($_SESSION['islogin'])) {
    if ($_SESSION['islogin'] == '1') {
        $login = $_SESSION['islogin'];
    } else {
        header("Location: login.php");
    }
} else {
    header("Location: login.php");
}

include('../include/config.php');
$dbConn = getDBConnection();
$stmtComp = $dbConn->prepare("SELECT * FROM `lov_company` ORDER BY `company_code` ASC ");
$stmtComp->execute();
$i = 1;
$options = "";
if ($stmtComp->rowCount() > 0) {

    while ($row4 = $stmtComp->FETCH(PDO::FETCH_ASSOC)) {
        $options .= '<option value="' . $row4['company_code'] . '">' . $row4['company_code'] . " --- " . $row4['company_value'] . '</option>';
    }
}

include('header.php');
?>

<link rel="stylesheet" href="rSlider.min.css">
<style type="text/css">
    body {
        height: 100vh;
    }

    .info-window {
        height: auto;
        padding: 2px;
    }

    #mohallah_txt_field {
        width: 100%;
        margin-bottom: 3px;
    }

    #mdh {
        cursor: pointer;
    }

    #mohallah_txt_field.found {
        border: 1px solid green;
        background: #85fb85;
        font-size: 16px;
        font-weight: bold;
    }

    #mohallah_txt_field.notfound {
        border: 1px solid #fddcdc;
        background: #f7e2e2;
    }

    #mohallah_msg {
        color: red;
        border: 1px solid;
        padding: 5px;
        height: 30px;
    }

    #gis_tabs a {
        color: black;
    }

    #overlay_search {
        position: absolute;
        display: none;
        width: 30%;
        height: 100%;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 2;
        cursor: pointer;
    }

    #overlay_mohallah {
        position: absolute;
        display: none;
        width: 30%;
        height: 100%;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #1c7940;
        z-index: 2;
        cursor: pointer;
    }

    #overlay_mohallah .list-group-item {
        background: #338640 !important;
        color: #fff;
        cursor: default;
    }

    #overlay_tab {
        position: absolute;
        display: none;
        width: 80%;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 2;
        cursor: pointer;
    }

    #overlay_grid_tab {
        position: absolute;
        display: none;
        width: 95%;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: #fff;
        z-index: 2;
        cursor: pointer;
    }

    div#profile {
        margin-top: -1px;
        font-size: 12px;
        border: 1px solid #eee;
        padding: 5px;
        background: #fff;
    }

    #overlay_grid_tab .nav-link,
    .nav-link active {
        color: #444;
        background: #eee;
        border: 0;
    }

    .card_overlay {
        color: white;
        background: transparent;
    }

    #search_icon {
        position: absolute;
        top: 15%;
        left: 96.5%;
        z-index: 2;
        color: white;
    }

    #tabs_icon {
        position: absolute;
        top: 25%;
        left: 96.5%;
        z-index: 2;
        color: white;
    }

    #grid_icon {
        position: absolute;
        top: 35%;
        left: 96.5%;
        z-index: 2;
        color: white;
    }


    /* width */
    ::-webkit-scrollbar {
        width: 2px;
    }

    /* Track */
    ::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    /* Handle */
    ::-webkit-scrollbar-thumb {
        background: #888;
    }

    /* Handle on hover */
    ::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    .map_div {
        height: calc(100vh - 64px)
    }

    @media(max-width:700px) {

        #overlay_search,
        #overlay_mohallah {
            width: 50%;
        }

        #search_icon {
            left: 90%;
        }

        #grid_icon {
            left: 90%;
        }

        #tabs_icon {
            left: 90%;
        }
    }
    .info-window{ font-weight: normal; color:#000; font-size: 14px; }
    .info-window .grid_name{
        color: #7f0707;
        font-size: 15px;
        font-weight: bold;
    }
    .info-window span.atc{ padding-left: 20px; color: #d8740a; }
    .info-window span.units, .info-window span.recovery{ 
        display: block;
        /*background: #fff3c4;*/
        margin: 5px;
        padding: 5px;
        border: 1px solid #ccc;
        margin-left: 0;
        margin-right: 0;
    }
    .info-window span.units{ background: #ddf3f8; }
    .info-window span.recovery{ background: #b3f6d7; }
    .info-window span.units b, .info-window span.recovery b{
        display: block;
        border-bottom: 1px solid;
        margin-bottom: 5px;
        font-style: italic;
        color: #666;
        font-weight: normal;
        font-size: 12px;
    }
    div.dt-buttons{ float: left; }
    .title_pop{
        text-align: center;
        font-weight: bold;
        font-size: 16px;
        margin-bottom: 0px;
        background: #2a6fac;
        margin-bottom: 10px;
        color: #fff;
    }

    #tbl-fdr-stats tr td.feeders{
        background: #ffe4c7;
        font-weight: bold;
    }

    #tbl-fdr-stats tr td.left{
        text-align: left;
    }
    #tbl-fdr-stats tr td.center{
        text-align: center;
    }
    #tbl-fdr-stats tr td.right{
        text-align: right;
    }
    text.highcharts-credits{ display: none !important; }
    .modall {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 2; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 60%;
  
}

/* The Close Button */
.closex {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.closex:hover,
.closex:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}
#myModal label{
    color: black !important;
}
</style>

<div class="page-wrapper" style="padding:0;margin: 0;">
    <!-- <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex justify-content-end no-block"> <span class="badge rounded-pill bg-warning " id="clock"
             style="font-size:14px;font-weight:bold"></span> </div>
        </div>
    </div>-->
    <div class="container-fluid" style="padding:0;margin: 0;">
        <div class="row">
            <div class="col-md-12">
                <!-- <ul class="nav nav-tabs" id='gis_tabs' >
                      <li class="nav-item" >
                        <a class="nav-link active" data-bs-toggle="tab" href="#gis_map">GIS</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#search_by_mohallah">Search By Mohallah</a>
                      </li>
                    </ul>
             -->
                <div class="card" id="nav-tabContent" style="margin-bottom:0px">

                    <div class="col-lg-12" id="gis_map">
                        <!--Map Div Here-->
                        <div class="row" style="position:relative;">
                            <!--overlay div here-->

                            <div id="overlay_search">
                                <div class="row" style="margin-top:10px">
                                    <div class="col-12">
                                        <i class="fas fa-times" style="float: right;color: white;" onclick="off()"></i>
                                        <div class="card card_overlay">
                                            <div class="card-body" style="background-color:transparent;">
                                                <h6 style="color:white"> Select Disco </h6>
                                                <select id="company_select" class="form-select mb-3">
                                                    <option value="0" selected>Select Company</option>
                                                    <option value="11">LESCO</option>
                                                    <option value="12">GEPCO</option>
                                                    <option value="13">FESCO</option>
                                                    <option value="14">IESCO</option>
                                                    <option value="15">MEPCO</option>
                                                    <option value="26">PESCO</option>
                                                    <option value="37">HESCO</option>
                                                    <option value="38">SEPCO</option>
                                                    <option value="48">QESCO</option>
                                                    <option value="59">TESCO</option>
                                                </select>

                                                <!-- Radio Buttons -->
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input scoped_rbtn" type="radio" name="mapScopeRbtn" id="fdr-rbtn" value="fdr-rbtn">
                                                    <label class="form-check-label" for="fdr-rbtn">Select Company Feeders (for Map Search)</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input scoped_rbtn" type="radio" name="mapScopeRbtn" id="grid-rbtn" value="grid-rbtn">
                                                    <label class="form-check-label" for="grid-rbtn">Show Grids (for Performance)</label>
                                                   
                                                
                                        
                                                </div>

                                                <div id="select-company-map-search-err" class="alert alert-danger"> Please select a company first!
                                                </div>
                                                <div id="fdr_list_container">
                                                    <div class="alert" style="background-color:green" type="button" role="alert">
                                                        Subdivison:
                                                        <span id="selected_sdiv"></span>
                                                    </div>
                                                    <div id="toggle_fdr_wrapper" class="form-check form-switch" title='Toggle'>
                                                        <input type="checkbox" class="form-check-input" id="toggle_fdr_list_on_map_checkbox" />
                                                        <label class="form-check-label" for='toggle_fdr_list_on_map_checkbox'>
                                                            Draw all feeders on map
                                                        </label>
                                                    </div>
                                                    <div class="overflow-auto" style="height:380px;">
                                                        <button class="btn btn-info loader" type="button" disabled style="display:none;margin-bottom: 5px;">
                                                            <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                                                            Loading Feeder List ...
                                                            <span id="loaded_fdr_counter"></span>
                                                        </button>

                                                        <div>Feeder List</div>
                                                        <div id="fdr_via_map_search_error" class="alert alert-danger" role="alert">
                                                            No Feeder Found
                                                        </div>
                                                        <ul id="nearest_feeder" class="list-group" style="width:100%; overflow: auto;">
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--overlay div endhere-->
                            <!--overlay mohallah div-->
                            <div id="overlay_mohallah">
                                <div class="row" style="margin-top:10px">
                                    <div class="col-12">
                                        <i class="fas fa-home" style="float: right;color: white;" onclick="back()"></i>
                                        <div class="card card_overlay">
                                            <div class="card-body" style="background-color:transparent; padding-right:0;">
                                                <div id="mohala_detail_model_title"></div>
                                                <div id="mohala_detail_model_body" class="overflow-auto" style="height:400px;margin-top: 10px;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--overlay mohallah div ends here-->
                            <div id="overlay_tab">

                                <i class="fas fa-times" style="margin-top: 5px;float: right;color: white;" onclick="hide_tab()"></i>
                                <div class="col-lg-12">
                                    <div class="row">
                                        <?php include("modal.php"); ?>
                                    </div>
                                </div>
                            </div>

                            <!--overlay Grid div ends here-->
                            <div id="overlay_grid_tab">
                                <style>
                                    i.icon1{
                                        margin-top: 5px;
                                        color: black;
                                        position: absolute;
                                        right: 10px;
                                        top: 0px;
                                    }
                                    
                                    i.icon2{
                                        margin-top: 5px;
                                        color: black;
                                        position: absolute;
                                        right: 30px;
                                        top: 0px;
                                    }
                                </style>

                                <i class="fas fa-times icon1" title="Close" onclick="hide_grid_tab()"></i>
                                
                                <i class="fa fa-expand icon2" title="Resize" id="i_show_hide" onclick="show_hide()"></i>

                                <div class="col-lg-12">
                                    <div class="row">
                                        <?php include("grid.php"); ?>
                                    </div>
                                </div>
                            </div>
                            <i class="fa-sharp fa-solid fa-magnifying-glass fa-xl" id='search_icon' onclick="on()"></i>
                            <i class="fa-solid fa-bars fa-xl" id='tabs_icon' onclick="show_tab()"></i>
                            <i class="fas fa-th-large fa-xl" id='grid_icon' onclick="show_grid_tab()"></i>

                            <div id="map" style="width: 100%;" class="map_div"></div>
                            <div class="loader">
                                <div style="position: absolute; left: 50%; top: 50%; margin-left: -32px; margin-top: -32px; width: 3rem; height: 3rem;" class="spinner-grow text-danger" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        </div>

                        <!--Map div end-->
                        <!--filter Modal-->
                       <div id="myModal" class="modall">

                          <!-- Modal content -->
                          <div class="modal-content">
                            <i class="fas fa-times" style="text-align: right;color: black;" onclick="hide_modal()"></i>
                            <span class="badge rounded-pill bg-warning" style="font-size:16px;font-weight:bold;display: block;margin-bottom: 10px;">
                                Selection Criteria
                            </span>
							<small style="text-align: center;">Use Checkbox to include column in Selection Criteria (OR is optional)</small>
                            <form class="mt-5">
								<div style="padding:10px; padding-top:0px;">
							
                                  <div class="row">
                                    <div class="col-sm-1">
                                    <input class="form-check-input" type="checkbox" value="length" name='filter_basis' id="length_checkbox">
									</div>
                                    <label for="inputEmail3" class="col-sm-3">Length (in KM)</label>
                                    <div class="col-sm-8">
                                     <input type="text" id="length" class="slider" />
                                    </div>
                                  </div>

                                  <div class="row">
                                    <div class="col-sm-4 mb-2" style="text-align:center;">  
                                         <div class="form-check form-check-inline">
                                          <input class="form-check-input" type="radio" name="length_rd" id="LengthRadio2" value="OR">
                                          <label class="form-check-label" for="LengthRadio2">OR</label>
                                        </div>
                                       
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-sm-1">
                                     <input class="form-check-input col-sm-1" type="checkbox" value="cons" name='filter_basis' id="cons_checkbox">
									</div>
                                    <label for="inputEmail3" class="col-sm-3">No. of Consumers</label>
                                    <div class="col-sm-8">
                                     <input type="text" id="consumers" class="slider" />
                                    </div>
                                  </div>

                                  <div class="row">
                                    <div class="col-sm-4 mb-2" style="text-align:center;">  
                                         <div class="form-check form-check-inline">
                                          <input class="form-check-input" type="radio" name="cons_rd" id="consRadio2" value="OR">
                                          <label class="form-check-label" for="consRadio2">OR</label>
                                        </div>
                                       
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-sm-1">
                                     <input class="form-check-input col-sm-1" type="checkbox" value="load" name='filter_basis' id="load_checkbox" >
									</div>
                                    <label for="inputEmail3" class="col-sm-3">Load</label>
                                    <div class="col-sm-8">
                                     <input type="text" id="load" class="slider" />
                                    </div>
                                  </div>

                                  <div class="row">
                                    <div class="col-sm-4 mb-2" style="text-align:center">  
                                        <div class="form-check form-check-inline">
                                          <input class="form-check-input" type="radio" name="load_rd" id="loadRadio2" value="OR">
                                          <label class="form-check-label" for="loadRadio2">OR</label>
                                        </div>
                                        
                                    </div>
                                  </div>
                                 <div class="row"> 
                                    <div class="col-sm-1">
                                     <input class="form-check-input col-sm-1" type="checkbox" value="loss" name='filter_basis' id="cons_checkbox" >
									</div>
                                    <label for="inputEmail3" class="col-sm-3">Loss%</label>
                                    <div class="col-sm-8">
                                     <input type="text" id="loss" class="slider" />
                                    </div>
                                  </div>
	
								</div>
								
                                  <div class="row">
                                    <div style="text-align:center; text-align:center;padding: 10px;background: #dbdbdb;margin-top: 10px;border-top: 2px solid #ccc;">  
                                       <input type="hidden" id="iQString" value="" style="display:none;" />
                                        <a href="#" class="btn btn-info" style="text-align:center; float: right;" onclick="process_filter_data()">Set Criteria</a>
                                        <a href="#" class="btn btn-danger" style="text-align:center; float: left;" onclick="reset_fields()">Reset</a>
                                    </div>

                                  </div>
                                 
                                </form>
                              
                          </div>

                        </div>
                        <!--filter Modal Ends here-->


                    </div>



                </div>

                <!-- Modal -->
                <!-- <div class="modal fade" id="mohala_detail_model" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                       
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                   
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div> -->

            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <!--   <?php
                    //include ('footer.php');
                    ?> -->
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="rSlider.min.js"></script>
    <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="../assets/extra-libs/sparkline/sparkline.js"></script>
    <!--Wave Effects -->
    <script src="../dist/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="../dist/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="../dist/js/custom.min.js"></script>
    
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB4llhGXc9x34qijPofHcSsF7j39iXa0sA&region=Pk&language=en&callback=initMap" defer>
    </script>
    <!--<script src="//code.jquery.com/jquery-1.12.4.min.js"></script>-->
    <script src="https://kit.fontawesome.com/de0813ab6b.js" crossorigin="anonymous"></script>
    <script src="../dist/js/jquery-editable-select.min.js"></script>
    <link href="../dist/css/jquery-editable-select.min.css" rel="stylesheet">
    <!--Data tables-->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <link href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet">
<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>

 <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
 <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
 <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
    <script type="text/javascript" src="filter_2.js"></script>
    <script type="text/javascript" src="nearest-fdr.js"></script>
    
       
           
    <script>

        let length,length_min,length_max,amp_length='';
        let load,load_min,load_max,amp_load='';
        let consumer,consumer_min,consumer_max,amp_cons='';
        let loss,loss_min,loss_max,amp_loss='';
        let length_op,consumer_op,load_op;
        let slider_length,slider_consumers,slider_load,slider_loss;
        let query_string='';
        let selectedfilters=[];
        let selectedfilters_length;
        function slide()

        {
           
             slider_length = new rSlider({
                    target: '#length',
                    values: {min: 0, max: 100},
                    step: 1,
                    range: true,
                    set: [10, 40],
                    scale: true,
                    labels: false,
                    width:'auto',
                    onChange: function (vals) {
                        //console.log(vals);
                    }
                });
             
            

               slider_consumers = new rSlider({
                    target: '#consumers',
                    values: {min: 0, max: 100},
                    step: 1,
                    range: true,
                    set: [10, 40],
                    scale: true,
                    labels: false,
                    width:'auto',
                    onChange: function (vals) {
                        //console.log(vals);
                    }
                });
                  slider_load = new rSlider({
                    target: '#load',
                    values: {min: 0, max: 100},
                    step: 1,
                    range: true,
                    set: [10, 40],
                    scale: true,
                    labels: false,
                    width:'auto',
                    onChange: function (vals) {
                        //console.log(vals);
                    }
                });

                   slider_loss = new rSlider({
                    target: '#loss',
                    values: {min: 0, max: 100},
                    step: 1,
                    range: true,
                    set: [10, 40],
                    scale: true,
                    labels: false,
                    width:'auto',
                    onChange: function (vals) {
                        //console.log(vals);
                    }
                });
        }

         $(document).ready(function() {

            on();
            let month,year;

            month=$('#month').val();
            year=$('#year').val();
            $('#dt').text(month+'-'+year);
                
        });

         function process_filter_data()
         {
           
           $('input[name="filter_basis"]:checked').each(function() {
            selectedfilters.push(this.value);
         });

           selectedfilters_length=selectedfilters.length;

           selectedfilters.forEach(item=>{


                if(item=='length')
                {
                    length=slider_length.getValue().split(',');
                    length_min=length[0]
                    length_max=length[1]
                    
                    if($('input[name=length_rd]').prop("checked"))
                    {
                            length_op=$('input[name=length_rd]:checked').val()
                    }else{
                        length_op='AND'
                    }
                    if(selectedfilters_length>1)
                    {
                        query_string+='length_min='+length_min+'&length_max='+length_max+'&length_op='+length_op+'&'
                    }else{
                         query_string+='length_min='+length_min+'&length_max='+length_max
                    }
                    //console.log(query_string)
                    
                }
                if(item=='cons'){
                    consumer=slider_consumers.getValue().split(',');
                    consumer_min=consumer[0]
                    consumer_max=consumer[1]

                    if($('input[name=cons_rd]').prop("checked"))
                    {      
                        consumer_op=$('input[name=cons_rd]:checked').val()
                    }else{
                         
                        consumer_op='AND'
                    }
                    if(selectedfilters_length>1 && selectedfilters[selectedfilters_length-1]=='load' || selectedfilters[selectedfilters_length-1]=='loss')
                    {   
                        query_string+='consumers_min='+consumer_min+'&consumers_max='+consumer_max+'&consumer_op='+consumer_op+'&'
                    }else{
                         query_string+='consumers_min='+consumer_min+'&consumers_max='+consumer_max
                    }
                    //console.log(query_string)
                    
                }
                if(item=='load'){
                    load=slider_load.getValue().split(',');
                    load_min=load[0]
                    load_max=load[1]

                    if($('input[name=load_rd]').prop("checked"))
                    {      
                        load_op=$('input[name=load_rd]:checked').val()
                    }else{
                         
                        load_op='AND'
                    }
                    if(selectedfilters_length>1 && selectedfilters[selectedfilters_length-1]=='loss')
                    {
                        query_string+='load_min='+load_min+'&load_max='+load_max+'&load_op='+load_op
                    }else{
                         query_string+='&load_min='+load_min+'&load_max='+load_max
                    }
                    //console.log(query_string)
                    
                }
                if(item=='loss')
                {
                    loss=slider_loss.getValue().split(',');
                    loss_min=loss[0]
                    loss_max=loss[1]
                    if(selectedfilters_length>1)
                    {
                        amp_loss='&';
                    }
                   query_string+=amp_loss+'loss_min='+loss_min+'&loss_max='+loss_max 
                }

           })
                 
            $('#iQString').val(query_string); 
           console.log( $('#iQString').val()) 
           hide_modal()
         }
         function reset_fields() {

            slider_length.setValues(10, 40)
            slider_consumers.setValues(10, 40)
            slider_load.setValues(10, 40)
            selectedfilters=[]
            query_string=''
            $('input[name="filter_basis"]:checked').prop('checked', false);
            $('input[name=length_rd]:checked').prop('checked', false);
            $('input[name=cons_rd]:checked').prop('checked', false);
            $('input[name=load_rd]:checked').prop('checked', false);


             
         }

        function hide_modal(){
            $('#myModal').hide();
        } 
            
        function on() {
            document.getElementById("overlay_search").style.display = "block";
            hide_tab();
            document.getElementById("overlay_mohallah").style.display = "none";
            hide_grid_tab();
        }

        function off() {
            document.getElementById("overlay_search").style.display = "none";
            $('#company_select').val('0');

        }

        function show_tab() {
            document.getElementById("overlay_tab").style.display = "block";
            off();
            off_mohallah();
            hide_grid_tab();

        }

        async function show_grid_tab(company_code = null, grid_code = null, grid_name = null) {
            //document.getElementById("overlay_grid_tab").style.display = "block";
            hide_tab();
            off_mohallah();
            off();

            $("#overlay_grid_tab").show("slow");
            enable_list();

            let grid_list = null
            if (company_code) {
                if (grid_code == '') {
                    $("#grid_company").val(`${company_code}000`).change();
                } else {
                    $("#grid_company").val(`${company_code}000`);
                    grid_list = await getGridData(company_code);
                    if (grid_list) {
                        get_grid(grid_list)
                        $("#grid").val(grid_code);
                        get_feeder_on_grid_change(grid_code, grid_name)
                    }
                }
            }
        }

        function hide_grid_tab() {
            document.getElementById("overlay_grid_tab").style.display = "none";
        }

        function hide_tab() {
            document.getElementById("overlay_tab").style.display = "none";
        }

        function on_mohallah() {
            document.getElementById("overlay_mohallah").style.display = "block";
            document.getElementById("overlay_search").style.display = "block";
            hide_tab();

        }

        function off_mohallah() {
            document.getElementById("overlay_mohallah").style.display = "none";
        }

        function back() {
            document.getElementById("overlay_search").style.display = "block";
            document.getElementById("overlay_mohallah").style.display = "none";
        }
    </script>


    </body>

    </html>