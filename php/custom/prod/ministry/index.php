<?php

header("Location: index2.php");

include ('../include/config.php');
$dbConn = getDBConnection();
$stmtComp = $dbConn->prepare("SELECT * FROM `lov_company` ORDER BY `company_code` ASC ");
$stmtComp->execute();
$i = 1;
$options = "";
if ($stmtComp->rowCount() > 0)
{

    while ($row4 = $stmtComp->FETCH(PDO::FETCH_ASSOC))
    {
        $options .= '<option value="' . $row4['company_code'] . '">' . $row4['company_code'] . " --- " . $row4['company_value'] . '</option>';
    }
}

include ('header.php');
?>

<div class="page-wrapper">
    <!-- <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex justify-content-end no-block"> <span class="badge rounded-pill bg-warning " id="clock"
             style="font-size:14px;font-weight:bold"></span> </div>
        </div>
    </div>-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="col-md-12">
                    <div class="card border border-4 border-light shadow-lg">
                        <form class="form-horizontal" id="searchForm">
                            <div class="card-body">
                                <div class="col-12 d-flex justify-content-end no-block">
                                    <span class="badge rounded-pill bg-warning " id="clock"
                                        style="font-size:14px;font-weight:bold"></span>
                                </div>
                                <h4 class="card-title badge bg-secondary"
                                    style="font-size:18px;color:#fff;font-weight:bold;margin-bottom: 20px;">SEARCH
                                    CRITERIA</h4>

                                <span id="disco" class="badge rounded-pill bg-primary el_span"></span>
                                <span id="cir_dis_bg" class="badge rounded-pill bg-info el_span"
                                    style="margin-right:5px;"></span>
                                <span id="div_teh_bg" class="badge rounded-pill bg-success el_span"
                                    style="margin-right:5px;"></span>
                                <span id="sdiv_feed_bg" class="badge rounded-pill bg-danger el_span"
                                    style="margin-right:5px;"></span>
                                <span id="mohal_feed_bg" class=" badge rounded-pill bg-warning el_span"></span>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <div class="form-check-inline">
                                            <input type="radio" class="form-check-input" id="formation_wapda"
                                                name="formation" value="wapda" onchange="select_div()" checked="checked" />
                                            <label for="formation_wapda" class="form-check-label mb-1" for="customControlValidation1">Wapda
                                                Formation</label>
                                        </div>
                                        <div class="form-check-inline">
                                            <input type="radio" class="form-check-input" name="formation" value="civil" onchange="select_div()" id="formation_civil" />
                                            <label for ="formation_civil" class="form-check-label mb-1" for="customControlValidation1">Civil
                                                Formation</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row" id="wapda_div">
                                    <label for="fname" class="col-sm-1 text-left control-label col-form-label ">
                                        <span class="border-bottom border-warning ">
                                            Company :</span></label>
                                    <div class="col-sm-2 ">
                                        <select name="company" id="company" class="select2 form-select shadow-none"
                                            style="width: 100%; height: 36px" onchange="get_circle()">
                                            <option value="comp">Select Company</option>
                                            <?php echo $options; ?>
                                        </select>
                                    </div>
                                    <label for="fname" class="col-sm-1 text-left control-label col-form-label"><span
                                            class="border-bottom border-warning">Circles :</span></label>
                                    <div class="col-sm-2">
                                        <select name="circle" id="circle" class="select2 form-select shadow-none"
                                            style="width: 100%; height: 36px" onchange="get_divisions('wapda')">
                                            <option value="cir">Select Circle</option>
                                        </select>
                                    </div>
                                    <label for="fname" class="col-sm-1 text-left control-label col-form-label"><span
                                            class="border-bottom border-warning">Divisions :</span></label>
                                    <div class="col-sm-2">
                                        <select name="division" id="divisions" class="select2 form-select shadow-none"
                                            style="width: 100%; height: 36px" onchange="get_subdivisions()">
                                            <option value="subdiv">Select Divisions</option>
                                        </select>
                                    </div>
                                    <label for="fname" class="col-sm-1 text-left control-label col-form-label  "><span
                                            class="border-bottom border-warning">Subdivisions :</span></label>
                                    <div class="col-sm-2">
                                        <select name="subdivision" id="subdivisions"
                                            class="select2 form-select shadow-none" style="width: 100%; height: 36px"
                                            onchange="get_feeder_frm_sdiv('wapda')">
                                            <option value="subdiv">Select Subdivisions</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row" id="civil_div" style="display:none">
                                    <label for="fname" class="col-sm-1 text-left control-label col-form-label"><span
                                            class="border-bottom border-warning"><span
                                                class="border-bottom border-warning ">Company :</span></label>
                                    <div class="col-sm-2">
                                        <select name="company_civil" id="company_civil"
                                            class="select2 form-select shadow-none" style="width: 100%; height: 36px"
                                            onchange="get_districts()">
                                            <option value="comp_civil">Select Company</option>
                                            <?php echo $options; ?>
                                        </select>
                                    </div>
                                    <label for="fname" class="col-sm-1 text-left control-label col-form-label"><span
                                            class="border-bottom border-warning">District :</span></label>
                                    <div class="col-sm-2">
                                        <select name="district" id="district" class="select2 form-select shadow-none"
                                            style="width: 100%; height: 36px" onchange="get_tehsil()">
                                            <option value="dis">Select Districts</option>
                                        </select>
                                    </div>
                                    <label for="fname" class="col-sm-1 text-left control-label col-form-label"><span
                                            class="border-bottom border-warning">Tehsil :</span></label>
                                    <div class="col-sm-2">
                                        <select name="tehsil" id="tehsil" class="select2 form-select shadow-none"
                                            style="width: 100%; height: 36px" onchange="get_mohallah()">
                                            <option value="tehsil">Select Tehsil</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="fname"
                                        class=" civil col-sm-1 text-left control-label col-form-label"><span
                                            class="border-bottom border-warning">Area / Mohalla:</span></label>
                                    <div class="col-sm-2 civil ">
                                       <select id="mohallah_txt" class="form-control" onchange="get_feeder_frm_mohallah()">
                                        </select>

                                    </div>
                                    <label for="fname" class="col-sm-1 text-left control-label col-form-label"><span
                                            class="border-bottom border-warning">Feeder:</span></label>
                                    <div class="col-sm-2">
                                        <select name="feeder" id="feeder" class="select2 form-select shadow-none"
                                            style="width: 100%; height: 36px" onchange="get_bage()">
                                            <option value="feeder">Select Feeders</option>
                                        </select>
                                    </div>

                                    <div class="col-sm-2">
                                        <button type="button" id="search" class="btn btn-info" disabled
                                            onclick="get_feeder_loadsheddding_schdule()"> <i class="fas fa-search "></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card border border-4 border-light shadow-lg">
                    <div class="card-body ">
                        <!--<div class="d-md-flex align-items-center">
                            <div>
                                <h4 class="card-title">Map</h4>
                                <h5 class="card-subtitle">Islamabad</h5>
                            </div>
                        </div>-->
                        <div class="row">
                            <!-- column -->
                            <div class="col-lg-9">
                                <!--Map Div Here-->
                                <div class="row">
                                    <div id="map" style="width: 100%; height: 600px;"></div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card" style="width: 18rem;">
                                            <div class="card-body">
                                                <div class="alert" style="background-color:#c6eb81 ;" type="button"
                                                    role="alert">
                                                    Subdivison:
                                                    <span id="selected_sdiv"></span>
                                                </div>
                                                <div id="toggle_fdr_wrapper" class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="toggle_fdr_list_on_map">
                                                    <label class="form-check-label" for="toggle_fdr_list_on_map">
                                                        Draw all feeders on map</label>
                                                </div>
                                                <button class="btn btn-info" id="loader" type="button" disabled
                                                    style="display:none;margin-bottom: 5px;">
                                                    <span class="spinner-border spinner-border-sm" role="status"
                                                        aria-hidden="true"></span>
                                                    Loading...
                                                </button>

                                                <ul id="nearest_feeder" class="list-group"
                                                    style="width:250px; height:350px; overflow: auto;">
                                                    Feeder List
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- column -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Sales chart -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Recent comment and chats -->
    <!-- ============================================================== -->
    <div class="row"> </div>
    <!-- ============================================================== -->
    <!-- Recent comment and chats -->
    <!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- footer -->
<!-- ============================================================== -->
<?php
include ('footer.php');
?>
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
<!--This page JavaScript -->
<!-- <script src="../dist/js/pages/dashboards/dashboard1.js"></script> -->
<!-- Charts js Files -->
<script src="../assets/libs/flot/excanvas.js"></script>
<script src="../assets/libs/flot/jquery.flot.js"></script>
<script src="../assets/libs/flot/jquery.flot.pie.js"></script>
<script src="../assets/libs/flot/jquery.flot.time.js"></script>
<script src="../assets/libs/flot/jquery.flot.stack.js"></script>
<script src="../assets/libs/flot/jquery.flot.crosshair.js"></script>
<script src="../assets/libs/flot.tooltip/js/jquery.flot.tooltip.min.js"></script>
<script src="../dist/js/pages/chart/chart-page-init.js"></script>
<script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB4llhGXc9x34qijPofHcSsF7j39iXa0sA&region=Pk&language=en&callback=initMap"
    defer>
</script>
<!--<script src="//code.jquery.com/jquery-1.12.4.min.js"></script>-->
<script src="../dist/js/jquery-editable-select.min.js"></script>
<link href="../dist/css/jquery-editable-select.min.css" rel="stylesheet">
<script type="text/javascript" src="filter.js"></script>
<script type="text/javascript" src="nearest-fdr.js"></script>
</body>

</html>