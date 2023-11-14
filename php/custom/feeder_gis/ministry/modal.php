<style type="text/css">
.pole{ 
  background:  url("pole.png") no-repeat left top;
  background-size: 15px 15px;
  padding-left: 30px; 
  font-weight: bold;
  /*color:#69dd21;*/
 
}

.olMohala{
  background:transparent; 
  padding-top:10px; 
  padding-bottom:10px;
}
/*.olMohala b{
 color: white !important;
}
*/

.olMohala li{ 
  margin-right: 15px;
  border-bottom: 1px solid #444;
  padding: 10px;

}

.olMohala li:hover { background:#fff; color: black}

.olMohala .sdiv{ /*padding-left: 30px */; }
.mohSeachPanel{
  background: rgba(0, 0, 0, 0.5);
  padding: 10px;
  /*border: 2px solid #fbe35d;*/
  border: 0.5px dotted #C8C8C8;
  font-family: arial;
  font-size: 12px;
  line-height: 1.75em;
  width:70%;
  margin-left: 20px;
  color: white;
  
}

.mohSeachPanel a{
  float: right;
}

</style>


                                <!-- <i class="fas fa-times" style="float: right;color: white;" onclick="hide_tab()"></i> -->
                                  <div class="col-lg-4">
                                      <div class="row">
                                          <div class="col-md-12">
                                             <div class="card card_overlay" style="margin-bottom: 0px">
                                                <form class="form-horizontal" id="searchForm">
                                                    <div class="card-body ">   <span class="badge rounded-pill bg-warning" id="clock"
                                                            style="font-size:14px;font-weight:bold;display: block;margin-bottom: 10px;">
                                                        </span>
                                                        <div class="form-group row">
                                                            <div class="col-sm-12">
                                                                <div class="form-check-inline">
                                                                    <input type="radio" class="form-check-input"
                                                                        id="formation_wapda" name="formation" value="wapda"
                                                                        onchange="select_div()" checked="checked" />
                                                                    <label for="formation_wapda"
                                                                        class="form-check-label mb-1"
                                                                        for="customControlValidation1">Wapda
                                                                        Formation</label>
                                                                </div>
                                                                <div class="form-check-inline">
                                                                    <input type="radio" class="form-check-input"
                                                                        name="formation" value="civil"
                                                                        onchange="select_div()" id="formation_civil" />
                                                                    <label for="formation_civil"
                                                                        class="form-check-label mb-1"
                                                                        for="customControlValidation1">Civil
                                                                        Formation</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="row" id="wapda_div">
                                                                
                                                                    <select name="company" id="company"
                                                                        class="select2 form-select shadow-none"
                                                                        style="width: 100%;margin-bottom:3px;"
                                                                        onchange="get_circle()">
                                                                        <option value="comp">Select Company</option>
                                                                        <?php echo $options; ?>
                                                                    </select>
                                                                    <select name="circle" id="circle"
                                                                        class="select2 form-select shadow-none"
                                                                        style="width: 100%;margin-bottom:3px "
                                                                        onchange="get_divisions('wapda')">
                                                                        <option value="cir">Select Circle</option>
                                                                    </select>
                                                                    <select name="division" id="divisions"
                                                                        class="select2 form-select shadow-none"
                                                                        style="width: 100%;margin-bottom:3px"
                                                                        onchange="get_subdivisions()">
                                                                        <option value="div">Select Divisions</option>
                                                                    </select>
                                                                    <select name="subdivision" id="subdivisions"
                                                                        class="select2 form-select shadow-none"
                                                                        style="width: 100%;margin-bottom:3px"
                                                                        onchange="get_feeder_frm_sdiv('wapda')">
                                                                        <option value="subdiv">Select Subdivisions</option>
                                                                    </select>
                                                                    <select name="feeder_wapda" id="feeder_wapda"
                                                                        class="select2 form-select shadow-none"
                                                                        style="width: 100%;margin-bottom: 3px;"
                                                                        onchange="get_bage('wapda')">
                                                                        <option value="feeder_sdiv">Select Feeders</option>
                                                                    </select>
                                                               
                                                            </div>
                                                            <div class="row" id="civil_div" style="display:none">
                                                                    <select name="company_civil" id="company_civil"
                                                                        class="select2 form-select shadow-none"
                                                                        style="width: 100%; margin-bottom: 3px;"
                                                                        onchange="get_districts()">
                                                                        <option value="comp_civil">Select Company</option>
                                                                        <?php echo $options; ?>
                                                                    </select>
                                                                    <select name="district" id="district"
                                                                        class="select2 form-select shadow-none"
                                                                        style="width: 100%;margin-bottom: 3px;"
                                                                        onchange="get_tehsil()">
                                                                        <option value="dis">Select Districts</option>
                                                                    </select>
                                                                    <select name="tehsil" id="tehsil"
                                                                        class="select2 form-select shadow-none"
                                                                        style="width: 100%;margin-bottom: 3px;"
                                                                        onchange="get_mohallah()">
                                                                        <option value="tehsil">Select Tehsil</option>
                                                                    </select>
                          
                                                                <div class="col-sm-8 civil ">
                                                                    <!--<select id="mohallah_txt" style="width: 100%;margin-bottom: 3px;" onchange="get_feeder_frm_mohallah()">
                                                                    </select>-->

                                                                    <input list="mohallah_txt" name="mohallah_txt"
                                                                        id="mohallah_txt_field"
                                                                        onblur="get_feeder_frm_mohallah()"
                                                                        class="form-control"
                                                                        style="margin-left:-8px" 
                                                                        value='Area/Mohallah'/>
                                                                    <datalist id="mohallah_txt">

                                                                    </datalist>
                                                                    <div id='mohallah_msg' style="display: none;margin-left: -10px;"></div>

                                                                </div>
                                                               
                                                                    <select name="feeder_civil" id="feeder_civil"
                                                                        class="select2 form-select shadow-none"
                                                                        style="width: 100%;margin-bottom: 3px;"
                                                                        onchange="get_bage('civil')">
                                                                        <option value="feeder_moh">Select Feeders</option>
                                                                    </select>
                                                              
                                                            </div>
                                                        </div>
                                                        <!--btn-->
                                                        <div class="form-group row">
                                                            <div class="col-sm-12">
                                                                <button type="button" id="search" class="btn btn-info" style="float: right;margin-right: 20px;" disabled onclick="get_feeder_loadsheddding_schdule()">
                                                                    <i class="fas fa-search "></i> Search
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                             </div>
                                          </div>
                                      </div>
                                  </div>

                                  <div class="col-lg-8 ">
                                     <div class="row">
                                            <div id="filter" style="margin: 20px 10px auto;">

                                                <h6 style="color:white;">Select Disco:</h6>
                                                      <select id="search_company" class="select2 form-select shadow-none mb-3"  style='float: left;width:100px;margin-right:5px;' onchange="resetMohala2();">
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
                                                        <input list="mohallah_txt2" name="mohallah_txt" style="width:50%" id="mohallah_txt_field2"  autocomplete="off" class="form-control" placeholder="Type Mohala Name Here" onkeyup="get_feeder_frm_mohallah2()" />
                                            </div>
                                                <div class='mohSeachPanel' style="height:380px;overflow: auto;">
                                                    <div id='mohalalist'></div>
                                    
                                     </div>      </div>          
                                  </div>


