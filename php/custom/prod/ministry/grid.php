    <!--High charts libraries-->
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<!--High charts libraries end-->

<script type="text/javascript">
    let fdr_list = null
    let grid_list = null
    let data_for_graph = null
    let comp;
    let grid;
    let name;

    let selected_month;
    let selected_year;
    let date;
    

    function enable_list() {

        let month;
        let year;
        month = $("#month").val();
        year = $('#year').val();
        selected_month = $('#month').val() + '-';
        selected_year = $('#year').val();
        date = '01-' + selected_month + selected_year;
        $("#d").html(date);
        if (month != '00' && year != '00') {
            $('#grid_company').prop('disabled', false);
            $('#dt').html(date.toUpperCase().slice(3));
            if ($('#grid_company').val() != 'comp' && $('#grid').val() != 'grid') {
                get_feeder_on_grid_change();

            } else if ($('#grid_company').val() != 'comp' && $('#grid').val() == 'grid') {

                get_grid_on_company_change();
            } else {

            }
        } else {
            $('#grid_company').prop('disabled', true);
            $('#grid_company').val('comp');
            $('#grid').prop('disabled', true);

            reset();
        }


    }

    function reset() { //clear all
        $('#nav_breadcrum').hide();
        $('#tbl-fdr-stats').empty();
        $('#grid_table').DataTable().clear().destroy();
        $("#disco_name").empty();
       // $('#dt').html('');
    }
    async function get_grid_on_company_change(company = null) {

        $('#month').prop('disabled', false);
        $('#year').prop('disabled', false);
        $('#pie_chart_div').hide();
        if ($('#grid_company').val() != 'comp') {
            let sorted_array;

            $('#loader').show();
            $('#opt').html("Grid Wise");
            $('#sel_grid').html('');
            $('#grid').prop('disabled', 'disabled');
            if (company == null) {
                comp = $('#grid_company').val().slice(0, -3);
            } else {
                comp = company;
            }
            //show breadcrums
            show_breadcrum();
            // get gid data on company change
            grid_list = await getGridData(comp);

            // execute only if grid_list has data
            if (grid_list) {
                // save data in global variable
                data_for_graph = grid_list.slice();
                //populate grid drop down
                get_grid(grid_list);
                $('#grid').prop('disabled', false);
                //send data for preparation to graph function
                //prepare_graph_data(grid_list,'grid');
                //calculate loss column for the grid data
                sorted_array = await calculate_loss("grid", grid_list);

                // execute only if sorted_array has data

                if (sorted_array) {

                    //show Data Table
                    show_table('grid', sorted_array);
                    graph_data();
                }
            }

        } else {
            reset();

        }


    }
    async function get_feeder_on_grid_change(grd = null, grid_name = null) {
        let sorted_array;
        $('#opt').html("Feeder Wise");
        $('#loader').show();

        if (grd == null) {
            grid = $('#grid').val();
            name = $('#grid option:selected').text();
        } else {
            grid = grd;
            name = grid_name;
        }

        $('#sel_grid').html("-" + name);

        show_breadcrum(grid);

        // get feeders data on grid change
        fdr_list = await getFeeders(grid);


        // execute only if grid_list has data
        if (fdr_list) {

            if (fdr_list.Message) {
                $('#msg').show();
                $('#loader').hide();
            } else {

                //save data in global variable
                data_for_graph = fdr_list.lstCP22Data.slice();

                //calculate loss column for the grid data
                sorted_array = await calculate_loss("feeder", fdr_list);
                // execute only if sorted_array has data

                if (sorted_array) {

                    //show Data Table
                    show_table('feeder', sorted_array);
                    graph_data();


                }
                $('#msg').hide();
            }


        }


    }

    function show_breadcrum(data = null) {
        let list_items;
        let company;
        let company_code;
        let grid_name;
        company = $('#grid_company option:selected').text().slice(9);
        company_code = $('#grid_company').val().slice(0, -3);
        if (data == null) {

            data = `<li class="breadcrumb-item active" aria-current="page">${company}</li>`;
        } else {
            $('#grid').val(data);
            grid_name = $('#grid option:selected').text();
            data = `<li class="breadcrumb-item" aria-current="page"><a href="#" onClick='get_grid_on_company_change(${company_code})'>${company}</a></li>
            <li class="breadcrumb-item active" aria-current="page">${grid_name}</li>`;
        }
        $('#breadcrumb').empty().append(data);
        $('#nav_breadcrum').show();
    }

    async function getFeeders(grid_code, billing_month = null) {

        let feeders_url = ""
        let QString = $('#iQString').val(); 
        console.log('**getFeeders QString: '+QString);
        if (billing_month) feeders_url = `http://117.20.28.181:9075/CISDBAPI/GetCP22Feeders/${grid_code}/${billing_month}/${QString}`;
        else feeders_url = `http://117.20.28.181:9075/CISDBAPI/GetCP22Feeders/${grid_code}/${date}/${QString}`;

        try {
            fdr_list = await fetch(feeders_url);
            return await fdr_list.json();
        } catch (error) {
            console.log(error);
        }
    }

    async function getGridData(comp) {

        let result;
        let QString = $('#iQString').val(); 
        console.log('**getGridData QString: '+QString);
        let grids_url = `http://117.20.28.181:9075/CISDBAPI/GetGrids/${comp}/${date}/${QString}`;

        try {
            result = await fetch(grids_url);
            return await result.json();
        } catch (error) {
            console.log(error);
        }
    }
    async function calculate_loss(option, gridList) {

        let data;
        if (option == "grid") {
            data = gridList;
        } else {
            data = gridList.lstCP22Data;
        }


        var billing = 0;
        var collection = 0;
        var diff = 0;
        //add amount key pair value
        let new_array_with_amount_loss = data.map(feeder => {

            diff = +feeder.recovery_loss; 
			return {
                ...feeder,
                amount_loss: +diff
            };
        });
        //sort array in descending order

        let new_array = [];
        //make a copy of array
        new_array = new_array_with_amount_loss.slice();

        //sort array descending
        new_array.sort((a, b) => {
            return b.amount_loss - a.amount_loss;

        });

        return new_array;

    }


    async function show_table(option, gridList) {

        let html = '';
        let htmlSegment;
        $('#grid_table').DataTable().clear().destroy();

        gridList.forEach(fdr => {

            htmlSegmentOption = "";

            if (option == 'grid') {
                htmlSegmentOption = `
                <td class='feeders center'><a href='#' onClick="get_feeder_on_grid_change('${fdr.grid_code}','${fdr.grid_name}')">${fdr.grid_code}</a></td>
                <td class='feeders left'><a href='#' onClick="get_feeder_on_grid_change('${fdr.grid_code}','${fdr.grid_name}')">${fdr.grid_name}</a></td>
                `;
            } else {
                htmlSegmentOption = `
                <td class='feeders center'>${fdr.feeder_code}</td>
                <td class='feeders left'>${fdr.feeder_name}</td>
				`;
            }

            htmlSegment = `
			<tr>` +
                htmlSegmentOption +
                `<td>${+fdr.no_of_consumers}</td>
				<td class='units'><span>${+fdr.units_received}</span></td>
				<td class='units'><span>${+fdr.units_sold}</span></td>
				<td class="units_lost"><span>${+fdr.units_lost}</span></td>
				<td class='units'>${+fdr.units_age_loss_per}</td>
				<td class='amount'><span>${+fdr.recovery_billing}</span></td>
				<td class='amount'><span>${+fdr.recovery_collection}</span></td>
				<td class="amount_lost">${+fdr.recovery_loss}</td>
				<td class='amount'>${+fdr.recovery_loss_per}</td>
				<td class="atc_data">${+fdr.atc_loss_per}</td>
			</tr>`;

            html += htmlSegment;
        });


        $('#tbl-fdr-stats').empty();
        $('#tbl-fdr-stats').append(html);
        $('#loader').hide();
        $('#grid_table').DataTable({
            dom: 'lBfrtip',
            buttons: [{
              extend: "excel", 
              className: "btn btn-default btn-sm export_button",
              text:'Export to Excel',
              title: $('#opt').text()+' Distribution Losses, Billing & Recovery (without subsidy) for '+$('#disco_name').text()+''+$('#sel_grid').text()
            }],
            "order": [],
             "pageLength": 10,
            "lengthMenu": [
                [10, 20, -1],
                [10, 20, 30, 50, 'Todos']
            ]
              
        });

    }

    function graph_data() {
        //make a copy of dataset from global variable 

        $('#filter_loader').show();
        let raw_data = data_for_graph.slice();
        let appended_col_array;
        let sorted_array;
        let compressed_data_array;

        //add recovery loss per col in dataset
        appended_col_array=calculate_recover_loss_per(raw_data);
       
        if(appended_col_array)
        {
            sorted_array = desc_sort_array(appended_col_array);
             
        }
        
        if (sorted_array.length > 0) { //get_no_of_elements_from_array either returns false or data array
            compressed_data_array = get_no_of_elements_from_array(sorted_array);
            // if is, to check either compressed_data_array is false of having data
            if (compressed_data_array) {
                plot_graph(compressed_data_array);
            }
        }


    }

    function calculate_recover_loss_per(dataSet)
    {
        let raw_data=dataSet;
        let new_dataSet;
         
        //add recovery_lost_per key pair value in dataset
        new_dataSet = raw_data.map(item => {

             recovery_loss_per = item.recovery_loss_per
            return {
                ...item,
                recovery_loss_per: recovery_loss_per
            };
            
        });
        return new_dataSet;

    }

    function desc_sort_array(dataSet) {
        let option;
        option = $("input[name='select_sort_type']:checked").val();

        if (option == 'unit') {
            // sort on basis of units loss %

            sorted_array = dataSet.sort((a, b) => {
                return b.units_lost - a.units_lost;
            });


        } else {
            // sort on basis of recovery loss %
            sorted_array = dataSet.sort((a, b) => {
                return b.recovery_loss - a.recovery_loss;
            });

        }

        return sorted_array;

    }

    function get_no_of_elements_from_array(dataSet) {

        let select_no_of_element;
        let working_array;
        let final_data;
        let array_length=dataSet.length;
        select_no_of_element = $('#select_record').val();

        if(select_no_of_element == '00')
        {
             final_data = dataSet.slice()
         }else{

            if(array_length<=select_no_of_element)
            {
                final_data = dataSet.slice(0, array_length);
            }else{
                final_data=dataSet.slice(0,select_no_of_element)
            }
         }
        return final_data;
    }

    async function plot_graph(data) {

        $('#filter_loader').hide();

        let categories = [];
        let series = [];
        let obj1, obj2, obj3, obj4, obj5, obj6,obj11,obj22;
        let data1 = [],
            data2 = [];
            data11 = [];
            data22 = [];
        let text, subtitle;
        let grid_name;
        let fdr_list;
        let datasetPieOne = [],
            datasetPieTwo = [];
       let dt1,dt2;
       let name1='',name11='';
       let option;
       let color1,color2;
       option= $("input[name='select_sort_type']:checked").val();
        if (data.length > 0) {
            if ($("#grid").val() == 'grid') {
                data.forEach(item => {
                    
                    if(option=='unit')
                    {
                        //dt2=(item.units_sold / 1000000).toFixed(2);
                        //data1.push((+item.units_lost/1000000));
                       
                        data1.push(+item.units_lost);
                        data11.push(+item.units_sold);
                        name1='Units Lost';
                        name11='Units Sold';
                        color1='teal';
                        color2='red';
                    }else{
                        //dt2=(item.recovery_collection / 1000000).toFixed(2);
                        data1.push(+item.recovery_loss);//already in millions
                        data11.push(+item.recovery_collection);
                        name1='Recovery Loss';
                        name11='Recovery Collection';
                        color1='grey';
                        color2='red';

                    }
                    
                     categories.push(item.grid_name)
                    
                   
                });
                
                text = "";
                subtitle = $('#grid_company option:selected').text().slice(9);
            } else {
                    let unit_amount;
                data.forEach(item => {

                     if(option=='unit')
                    {
                        //dt2=(item.units_sold / 1000000).toFixed(2);
                        //data1.push((+item.units_lost/1000000));
                        data1.push(+item.units_lost);
                        data11.push(+item.units_sold);
                        name1='Units Lost';
                        name11='Units Sold';
                        color1='teal';
                        color2='red';

                    }else{
                        //dt2=(item.recovery_collection / 1000000).toFixed(2);
                        data1.push(+item.recovery_loss);//already in millions
                        data11.push(+item.recovery_collection);
                         name1='Recovery Loss';
                        name11='Recovery Collection';
                        color1='grey';
                        color2='red';
                    }
                    
                    
                    categories.push(item.feeder_name + '(' + item.feeder_code + ')')

                });




                grid_name = $("#grid option:selected").text();
                text = "";
                subtitle = grid_name;

                fdr_list = await getFeeders($("#grid").val());

                if (fdr_list) {

                    //data preparation for pie charts

                    obj3 = {
                        name: 'Units Sold',
                        y: +fdr_list.units_sold,
                        sliced: false,
                        selected: true,
                        color: '#e8a71c'
                    }
                    obj4 = {
                        name: 'Units Received',
                        y: +fdr_list.units_received,
                        color: '#cde81c'
                    }

                    datasetPieOne.push(obj3, obj4);


                    obj5 = {
                        name: 'Recovery Billing',
                        y: +fdr_list.recovery_billing,
                        sliced: false,
                        selected: true,
                        color: '#e8411c'
                    }
                    obj6 = {
                        name: 'Recovery collection',
                        y: +fdr_list.recovery_collection,
                        color: '#a2dfe0'
                    }

                    datasetPieTwo.push(obj5, obj6);


                    $('#pie_chart_div').show();
                }

            }

            obj11 = {
                name: name11,
                data: data11,
                color:color1,
                stack:'one'
            };

            obj1={
                name: name1,
                data: data1,
                color:color2,
                stack:'one'
            };
          
            series.push(obj11,obj1);
          

        }

       
        Highcharts.chart('container', {

                chart: {
                    type: 'column'
                },

                title: {
                    text: text
                },

                xAxis: {
                    categories: categories
                },

                yAxis: {
                    allowDecimals: false,
                    min: 0,
                    title: {
                        text: 'Losses (Millions)'
                    }
                },

                tooltip: {
                    formatter: function () {
                        return '<b>' + this.x + '</b><br/>' +
                            this.series.name + ': ' + this.y + '<br/>' +
                            'Total: ' + this.point.stackTotal;
                    }
                },

                plotOptions: {
                    column: {
                        stacking: 'normal',
                        dataLabels: {
                            enabled: true
                        }
                    }
                },

                series: series
        });


        //pie chart

        Highcharts.chart('pie_one', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie',

            },
            title: {
                text: 'Units Received Vs Units Sold',
                style: {
                    fontWeight: 'bold',
                    fontSize: '12px'
                }
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '{point.percentage:.1f} %',
                        style: {
                            textOverflow: 'clip',
                            fontSize: 9
                        }
                    },
                    size: '87%',
                    borderWidth: 0
                }
            },
            series: [{
                name: 'Total',
                colorByPoint: true,
                data: datasetPieOne
            }]
        });

        Highcharts.chart('pie_two', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie',

            },
            title: {
                text: 'Billing Vs Recovery',
                style: {
                    fontWeight: 'bold',
                    fontSize: '12px'
                }
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '{point.percentage:.1f} %',
                        style: {
                            textOverflow: 'clip',
                            fontSize: 9
                        }
                    },
                    size: '87%'
                }
            },
            series: [{
                name: 'Total',
                colorByPoint: true,
                data: datasetPieTwo
            }]
        });

    }
</script>
<style type="text/css">
    .export_button{
        margin-left: 10px;
        
    }
    .breadcrumb {
        background-color: #c1e92363;
        padding-left: 3px;
        font-weight: bold;
        margin: 0px;
    }

    #grid_table th,
    #grid_table td {
        border: 1px solid #eee;
        color: black;
        background-color: white;
        font-size: 12px;
        padding: 5px;
        font-family: arial;

    }
    
    #grid_table th{
        text-align: center;
    }

    #grid_table td {
        text-align: right;
    }

    #grid_table td span{
        margin-right: 5px;
    }

    #grid_table th {
        background: #e9e9e9;
        vertical-align: bottom;
    }

    #grid_table thead,
    #grid_table tbody tr {
        display: table;
        width: 100%;
        table-layout: fixed;
    }

    #grid_table tbody {
        display: block;
        height: 270px;
        overflow: auto;
    }

    .nav-link,
    .nav-link active {
        background: transparent;
        color: white;

    }

    .pole {
        background: url("pole.png") no-repeat left top;
        background-size: 15px 15px;
        padding-left: 30px;
        font-weight: bold;
        /*color:#69dd21;*/

    }

    .olMohala {
        background: transparent;
        padding-top: 10px;
        padding-bottom: 10px;
    }

    /*.olMohala b{
 color: white !important;
}
*/

    .olMohala li {
        margin-right: 15px;
        border-bottom: 1px solid #444;
        padding: 10px;

    }

    .olMohala li:hover {
        background: #fff;
        color: black
    }

    .olMohala .sdiv {
        /*padding-left: 30px */
    }

    .mohSeachPanel {
        background: rgba(0, 0, 0, 0.5);
        padding: 10px;
        /*border: 2px solid #fbe35d;*/
        border: 0.5px dotted #C8C8C8;
        font-family: arial;
        font-size: 12px;
        line-height: 1.75em;
        width: 70%;
        margin-left: 20px;
        color: white;

    }

    .mohSeachPanel a {
        float: right;
    }

    td.default_td,
    #grid_table th.default_td {
        background: #ffc4ce !important;
    }

    #graph_filter {
        border: 1 solid #e9ecef;
        margin-top: 10px;
        padding-left: 5px;

    }

    .atc_data{ width: 40px !important; }

   #tbl-fdr-stats td.units, #tbl-fdr-stats th.units{
        background: #ddf3f8 !important;
    }

    #tbl-fdr-stats td.amount, #tbl-fdr-stats th.amount{
        background: #b3f6d7 !important;
    }

    #grid_table td.units_lost,
    #grid_table th.units_lost {
        background: #c0e2ef !important;
    }

    #grid_table td.amount_lost,
    #grid_table th.amount_lost {
        background: #88d7b3 !important;
    }

    #tbl-fdr-stats tr:hover td {
        background: #e9ad8a63 !important;
        
    }

    #tbl-fdr-stats tr:hover td:hover {
        background: #d45d1763 !important;
        font-weight: bold;
    }

   
</style>

<script>
    function show_hide(){

        var l = $("#side_left_pop");
        var r = $("#side_right_pop");

        if( l.hasClass('col-lg-3') ){
            l.removeClass('col-lg-3');
            l.hide('slow');
            r.removeClass('col-lg-9').addClass('col-lg-12');

            $('#i_show_hide').removeClass('fa fa-expand').addClass('fa fa-arrows-h')
        }else{
            l.addClass('col-lg-3');
            l.show('slow');
            r.removeClass('col-lg-12').addClass('col-lg-9');
            $('#i_show_hide').removeClass('fa fa-arrows-h').addClass('fa fa-expand')
        }
        
    }
</script>
<!-- <i class="fas fa-times" style="float: right;color: white;" onclick="hide_tab()"></i> -->
<div class="col-lg-3" id="side_left_pop">
    <div class="row">
        <div class="col-md-12">
            <div class="card card_overlay" style="margin-bottom: 0px">
                <form class="form-horizontal" id="searchForm">
                    <div class="card-body ">
                        <div class="form-group row">
                            <span class="badge rounded-pill bg-warning" style="font-size:14px;font-weight:bold;display: block;margin-bottom: 10px;">
                                Grid Search
                            </span>
                            <select name="month" id="month" class="select2 form-select shadow-none" style="width: 45%;margin-bottom:3px;margin-right: 18px;" onchange="enable_list()">
                                <option value="00">Select Month</option>
                                <option value="jan">Jan</option>
                                <option value="feb">Feb</option>
                                <option value="mar">Mar</option>
                                <option value="apr">Apr</option>
                                <option value="may">May</option>
                                <option value="jun">Jun</option>
                                <option value="jul">Jul</option>
                                <option value="aug">Aug</option>
                                <option value="sep" selected>Sep</option>
                                <option value="oct">Oct</option>
                                <option value="nov">Nov</option>
                                <option value="dec">Dec</option>
                            </select>
                            <select name="year" id="year" class="select2 form-select shadow-none" style="width: 47%;margin-bottom:3px;" onchange="enable_list()">
                                <option value="00">Select Year</option>
                                <option value="2022" selected>2022</option>
                                <option value="2020">2021</option>
                                <option value="2021">2020</option>


                            </select>
                            <select name="grid_company" id="grid_company" class="select2 form-select shadow-none" style="width: 100%;margin-bottom:3px;" onchange="get_grid_on_company_change()" disabled>
                                <option value="comp">Select Company</option>
                                <?php echo $options; ?>
                            </select>
                            <select name="grid" id="grid" class="select2 form-select shadow-none" style="width: 100%;margin-bottom:3px " onchange="get_feeder_on_grid_change()">
                                <option value="grid">Select Grid</option>
                            </select>
                            <div class="text-center" style="margin-top: 10px;display: none;" id='loader'>
                                <div class="spinner-border text-success" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                            <div class="alert alert-danger alert-dismissible fade" id='msg' role="alert" style="display: none;">
                                <strong>No feeders found for the selected Grid</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>

                            <div id='pie_chart_div' class="row" style="display:none;">
                                <div id="pie_one" class="col-md-12" style="height:200px;width: 300px;margin: 0 auto;"></div>
                                <div id="pie_two" class="col-md-12" style="height:200px;width: 300px;margin: 0 auto;"></div>
                            </div>



                            <!-- <select name="grid_feeder" id="grid_feeder" class="select2 form-select shadow-none" style="width: 100%;margin-bottom:3px" onchange="$('#search_grid').prop('disabled',false)">
                                <option value="div">Select Feeder</option>
                            </select> -->

                        </div>
                        <div class="feeder_container"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-9" id="side_right_pop">
    <div class="row">
        <div class="col-lg-12">
            <!-- <input id="chart" type="button" value="chart" onclick="show_chart();" />
                                                       <div id="container" style="height: 300px"></div> -->
            <ul class="nav nav-tabs" id="myTab" role="tablist" style="margin-top:10px;">

                <li class="nav-item" role="presentation" style='padding-left: 10px;'>
                    <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Statistics</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link " id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Graph</button>
                </li>

            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade " id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div id='graph_filter'>
                        <div class="form-check form-check-inline">Sort By: </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="select_sort_type" id="select_sort_type1" value="recovery" checked onchange="graph_data()">
                            <label class="form-check-label" for="select_sort_type1">Recovery loss</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="select_sort_type" id="select_sort_type" value="unit"  onchange="graph_data()">
                            <label class="form-check-label" for="select_sort_type">Units loss</label>
                        </div>
                        
                        <div class="form-check form-check-inline">
                            <select name="select_record" id="select_record" class="select2 form-select shadow-none" style="margin-bottom:3px;" onchange="graph_data()">
                                <option value="">Select Records</option>
                                <option value="00">All</option>
                                <option value="10" selected>10 Records</option>
                                <option value="20">20 Records</option>
                                <option value="30">30 Records</option>
                                <option value="50">50 Records</option>
                            </select>
                        </div>
                        
                                <div class="spinner-border text-success" role="status" id='filter_loader' style="display:none">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            

                    </div>

                    <div id="container" style="height:500px;margin-top:10px;"></div>

                </div>
                <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab" style="font-size: 12px;">
                    <nav aria-label="breadcrumb" style="display:none;" id="nav_breadcrum">
                        <ol class="breadcrumb" id='breadcrumb'></ol>
                    </nav>
                    <p class="title_pop"><span id="opt">Grid wise</span> Distribution Losses, Billing & Recovery (without subsidy)<br><span id='disco_name'></span><span id='sel_grid'></span></p>
                    <table id='grid_table' style="width:100%">
                        <thead>
                            <tr>

                                <th colspan="3"rowspan="2">Feeder</th>
                                <th colspan="8">Monthly (<span id='dt'></span>)</th>
                                <th rowspan="3" class="atc_data">%ATC</th>
                            </tr>
                            <tr>
                                <th colspan="4">Units (MkWH)</th>
                                <th colspan="4">Recovery (in millions)</th>
                            </tr>
                            <tr>

                                <th>Code</th>
                                <th>Name</th>
                                <th>No.of Consumers</th>
                                <th class="units">Received</th>
                                <th class="units">Sold</th>
                                <th class="units">Lost</th>
                                <th class="units">%Loss</th>
                                <th class="amount">Billing</th>
                                <th class="amount">Collection</th>
                                <th class="amount">Lost</th>
                                <th>%Loss</th>
                            </tr>
                        </thead>
                        <tbody id="tbl-fdr-stats">

                        </tbody>
                    </table>
                </div>
            </div>

        </div>


    </div>
</div>