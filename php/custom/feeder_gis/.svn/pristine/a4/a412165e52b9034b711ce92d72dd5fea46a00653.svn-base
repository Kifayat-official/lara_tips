$(document).ready(function() {
  
 
$('#wapda_div').show();
$('.civil').css('display', 'none');
});

function select_div()
{
  var Option=$('input[name=formation]:checked').val();
  if(Option=='wapda')
  {
  $("#civil_div").css('display', 'none');
  $('.civil').hide();
  $('#wapda_div').show();
  $('.el_span').hide();
  $("#searchForm").trigger("reset");
  $("#formation_wapda").prop("checked", true);

  }else{
  $('#civil_div').show();
  $('.civil').show();
  $('#wapda_div').hide();
   $('.el_span').hide(); 
   $("#searchForm").trigger("reset");
  $("#formation_civil").prop("checked", true);
  }

}
function get_circle()
{
  var comp=$('#company').val();
 
  if(comp!='comp')
  {
     var comp_name=$( "#company option:selected" ).text();
     $("#disco").show();
      $("#disco").html(comp_name);
  }else{
     $("#disco").hide();
  }
 
  $('#spinner').show();
  $.post("get_circle.php",{code:comp},function(ress){
    $('#spinner').hide();
    $('#circle').html(ress);
  });
}
function get_districts()
{
  var comp=$('#company_civil').val();
  if(comp!='comp_civil')
  {
    var comp_name=$( "#company_civil option:selected" ).text();
     $("#disco").show();
     $("#disco").html(comp_name);
  }else{
     $("#disco").hide();
  }$("#comp_bg").html(comp);
  $('#spinner').show();
  $.post("get_district.php",{code:comp},function(ress){
    $('#spinner').hide();
    $('#district').html(ress);
  });
}
function get_tehsil()
{
  var district=$('#district').val();
  if(district!='dis')
  {
    var comp_name=$( "#district option:selected" ).text();
     $("#cir_dis_bg").show();
     $("#cir_dis_bg").html(comp_name);
  }else{
     $("#cir_dis_bg").hide();
  }

  $('#spinner').show();
  $.post("get_tehsil.php",{code:district},function(ress){
    $('#spinner').hide();
    $('#tehsil').html(ress);
  });
}
function get_divisions()
{

  
  var cir=$('#circle').val();
  if(cir!='cir')
  {
     var cir_name=$( "#circle option:selected" ).text();
     $("#cir_dis_bg").show();
      $("#cir_dis_bg").html(cir_name);
  }else{
     $("#cir_dis_bg").hide();
  }
 
 
  $('#spinner').show();
$.post('get_division.php', 
  {   code:cir
  
  },function(response){
    $('#spinner').hide();
    $('#divisions').html(response);
});

}
function get_bage(){
  var feed=$('#feeder').val();
  var feed_name=$('#feeder option:selected').text();

  if(feed!='feeder')
  {
      $("#mohal_feed_bg").show();
      $("#mohal_feed_bg").html(feed_name);
  }else{
    $("mohal_feed_bg").hide();
  }
      
}
function get_subdivisions()
{

  var div=$('#divisions').val();
  if(div!='div')
  {
      var div_name=$( "#divisions option:selected" ).text();
      $("#div_teh_bg").show();
      $("#div_teh_bg").html(div_name);
  }else{
    $("#div_teh_bg").hide();
  }
  
  $('#spinner').show();
  $.post('get_subdivision.php', 
  {   code:div
  },function(response){
    $('#spinner').hide();
    $('#subdivisions').html(response);
});

}

function get_feeder_frm_sdiv()
{ 
     var subdiv=$('#subdivisions').val();
           if(subdiv!='subdiv')
        {
          var subdiv_name=$( "#subdivisions option:selected" ).text();
           $("#sdiv_feed_bg").show();
           $("#sdiv_feed_bg").html(subdiv_name);
        }else{
          $("#sdiv_feed_bg").hide();
        }
   
  $('#spinner').show();
  $('#search').prop('disabled', false);
  $.post('get_feeder.php', 
    {   code:subdiv
      
    },function(response){
      $('#spinner').hide();
      $('#feeder').html(response);
  });

}

function get_feeder_lat_lon()
{
  var feeder=$('#feeder').val();
  $('#spinner').show();
  $.post('get_feeder_lat_lon.php', 
    {   code:feeder

    },function(data){
      var obj=JSON.parse(data);
      
      var lat=obj['lat'];
      var lon=obj['lon'];
      
      get_nearest_feeder(lon,lat);
     
  });

}

function get_feeder_loadsheddding_schdule()
{
  var feeder=$('#feeder').val();
  var url="http://ccms.pitc.com.pk/flsfeeder_index?search_type=feeder_code&search_value="+feeder;
  
   window.open(url);
}
function get_feeder_frm_mohallah()
{

  
  var mohallah_name=$('#mohallah_txt').val();

  if(mohallah_name!='')
  {   $('#sdiv_feed_bg').show();
    $('#sdiv_feed_bg').html(mohallah_name);
  }else{
    $('#sdiv_feed_bg').hide();
  }

  $('#spinner').show();
  $.post('../../get_feeder_frm_mohallah.php', 
      {   mohallah:mohallah_name

      },function(response){
      $('#spinner').hide();
      $('#feeder').html(response);
  });

}
function get_mohallah()
{
  var tehsil=$('#tehsil').val();
  var tehsil_name=$('#tehsil option:selected' ).text();
    if(tehsil!='tehsil')
    {
      $('#div_teh_bg').show();
      $('#div_teh_bg').html(tehsil_name);
    }else{
      $('#div_teh_bg').hide();
    }
  
  
   $('#search').prop('disabled', false);
  $('#spinner').show();
  $.post('../../get_mohallah.php', 
    {   tehsil_name:tehsil

    },function(response){
      $('#spinner').hide();
      $('#mohallah_txt').html(response);
       $('#mohallah_txt').editableSelect({effects: 'slide'});
  });

}
function currentTime() {
let d = new Date(); 
let date=d.toDateString();
let hh = d.getHours();
let mm = d.getMinutes();
let ss = d.getSeconds();
let session = "AM";

if(hh == 0){
hh = 12;
}
if(hh > 12){
hh = hh - 12;
session = "PM";
}

hh = (hh < 10) ? "0" + hh : hh;
mm = (mm < 10) ? "0" + mm : mm;
ss = (ss < 10) ? "0" + ss : ss;

let time = hh + ":" + mm + ":" + ss + " " + session;

document.getElementById("clock").innerText = date + ' ' + time;
let t = setTimeout(function() {
currentTime()
}, 1000);
}
currentTime();