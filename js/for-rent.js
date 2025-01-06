var $j = jQuery.noConflict();
var default_sort = 'low';
var $table;

function buildResult()
{
  var html = '';
  html += '<table id="result-rows">';
  html += '<thead>';
  html += '<tr>';
  html += '<th data-sort="int">Suite #</th>';
  html += '<th data-sort="string-ins">Building</th>';
  html += '<th id="h-city" data-sort="string-ins">City</th>';
  html += '<th data-sort="int">Bedroom(s)</th>';
  html += '<th data-sort="int">Den/Study</th>';
  html += '<th data-sort="int">Bath(s)</th>';
  html += '<th data-sort="int">Suite Size</th>';
  html += '<th data-sort="string-ins">Available</th>';
  html += '<th id="h-price" data-sort="string-ins">Price</th>';
  html += '<th>Floorplans</th>';
  // html += '<th>Share</th>';
  html += '</tr>';
  html += '</thead>';
  html += '<tbody>';
  var cnt = 0;
  for (var i=0; i < SUITES.length; i++) {
    cnt++;
    html += '<tr>';
    html += '<td>'+SUITES[i].unit+'</td>';
    html += '<td>'+SUITES[i].building+'</td>';
    html += '<td>'+SUITES[i].city+'</td>';
    html += '<td>'+SUITES[i].bed+'</td>';
    html += '<td>'+SUITES[i].den+'</td>';
    html += '<td>'+SUITES[i].bath+'</td>';
    html += '<td>'+SUITES[i].sf+' sq.ft.</td>';
    html += '<td>';
    if (SUITES[i].available_on)
      html += SUITES[i].available_on;
    else
      html += 'Now';
    html += '</td>';
    html += '<td>$'+new Intl.NumberFormat('en-US',{ minimumFractionDigits: 2 }).format(SUITES[i].price)+'</td>';
    html += '<td><a href="https://floorplan.atriadevelopment.ca/'+SUITES[i].folder+'/'+SUITES[i].floorplan+'.pdf"><img src="'+DIRECTORY_URI+'/img/btn-floorplan-blank.svg" alt="Floorplan" class="btn-floorplan"></a></td>';
    // html += '<td><a href="https://floorplan.atriadevelopment.ca/'+SUITES[i].folder+'/'+SUITES[i].floorplan+'.pdf"><img src="'+DIRECTORY_URI+'/img/btn-share.svg"></a></td>';

    
    html += '</tr>';
  }
  html += '</tbody>';
  html += '</table>';
  $j('.results').html(html);
  $table = $j('#result-rows').stupidtable();
  doSort("low")
  $j('.showing strong').html(cnt);
}

function doSort(value) {
  if (value == "low") {
    $table.find("thead th#h-price").stupidsort('asc')
  } else if (value == "high") {
    $table.find("thead th#h-price").stupidsort('desc')
  } else if (value == "city") {
    $table.find("thead th#h-city").stupidsort('asc')
  }
}

function doFilter(task) {
  var city = $j('select[name=city]').val();
  var bed = $j('select[name=bed]').val();
  var bath = $j('select[name=bath]').val();
  var floor = $j('select[name=floor]').val();
  var building = $j('select[name=building]').val();
  var sort = $j('select[name=sort]').val();

  if (task == 'city') {
    doBuildingSelect();
    doBedSelect();
    doBathSelect();
    doFloorSelect();
    building = '';
    bed = '';
    bath = '';
    floor = '';
  } else if (task == 'building') {
    
    doBedSelect();
    doBathSelect();
    doFloorSelect();
    bed = '';
    bath = '';
    floor = '';
  }

  var cnt = 0;
  var html = '';
  for (var i=0; i < SUITES.length; i++) {
    if ((city == '' || city == SUITES[i].city) &&
      (bed == '' || bed == SUITES[i].bed) &&
      (bath == '' || bath == SUITES[i].bath) &&
      (building == '' || building == SUITES[i].building) &&
      (floor == '' || floor == SUITES[i].floor) 
      ) {
      cnt++;
      html += '<tr>';
      html += '<td>'+SUITES[i].unit+'</td>';
      html += '<td>'+SUITES[i].building+'</td>';
      html += '<td>'+SUITES[i].city+'</td>';
      html += '<td>'+SUITES[i].bed+'</td>';
      html += '<td>'+SUITES[i].den+'</td>';
      html += '<td>'+SUITES[i].bath+'</td>';
      html += '<td>'+SUITES[i].sf+' sq.ft.</td>';
      html += '<td>';
      if (SUITES[i].available_on)
        html += SUITES[i].available_on;
      else
        html += 'Now';
      html += '</td>';      
      html += '<td>$'+new Intl.NumberFormat('en-US',{ minimumFractionDigits: 2 }).format(SUITES[i].price)+'</td>';
      html += '<td><a href="https://floorplan.atriadevelopment.ca/'+SUITES[i].folder+'/'+SUITES[i].floorplan+'.pdf"><img src="'+DIRECTORY_URI+'/img/btn-floorplan-blank.svg" alt="Floorplan" class="btn-floorplan"></a></td>';
    
      // html += '<td><<img src="'+DIRECTORY_URI+'/img/btn-share.svg"></td>';

      html += '</tr>';
    }
  }
  $j('#result-rows tbody').html(html)
  $j('.showing strong').html(cnt);
  $table = $j('#result-rows').stupidtable();
  doSort(sort);
}

function doBuildingSelect() 
{
  var city = $j('select[name=city]').val();

  var html = '';
  html += '<option value="" selected>Building</option>';
  if (city) {
    for (var i=0; i < CITY[city].length; i++) {
      html += '<option value="'+CITY[city][i]+'">'+CITY[city][i]+'</option>';
    }
  } else {
    for (var i=0; i < Object.keys(BUILDING).length; i++) {
      html += '<option value="'+Object.keys(BUILDING)[i]+'">'+Object.keys(BUILDING)[i]+'</option>';
    }
  }
  $j('select[name=building]').html(html); 
}

function doBedSelect()
{
  var city = $j('select[name=city]').val();
  var building = $j('select[name=building]').val();
  var html = '';
  var max_bed = 0;
  if (building) {
    max_bed = BUILDING[building].bed
  } else if (city) {
    for (var i=0; i < CITY[city].length; i++) {
      var key = CITY[city][i];
      if (max_bed < BUILDING[key].bed)
        max_bed = BUILDING[key].bed
    }
  } else {
    for (var i=0; i < Object.keys(BUILDING).length; i++) {
      var key = Object.keys(BUILDING)[i];
      if (max_bed < BUILDING[key].bed)
        max_bed = BUILDING[key].bed
    }
  }

  html += '<option value=""  selected>Bedroom(s)</option>';
  for (var i=0; i <= max_bed; i++) {
    html += '<option value="'+i+'">'+i+'</option>';
  }
  $j('select[name=bed]').html(html); 
}

function doBathSelect()
{
  var city = $j('select[name=city]').val();
  var building = $j('select[name=building]').val();
  var html = '';
  var max_bath = 0;
  if (building) {
    max_bath = BUILDING[building].bath
  } else if (city) {
    for (var i=0; i < CITY[city].length; i++) {
      var key = CITY[city][i];
      if (max_bath < BUILDING[key].bath)
        max_bath = BUILDING[key].bath
    }
  } else {
    for (var i=0; i < Object.keys(BUILDING).length; i++) {
      var key = Object.keys(BUILDING)[i];
      if (max_bath < BUILDING[key].bath)
        max_bath = BUILDING[key].bath
    }
  }

  html += '<option value="" selected>Bath(s)</option>';
  for (var i=1; i <= max_bath; i++) {
    html += '<option value="'+i+'">'+i+'</option>';
  }

  $j('select[name=bath]').html(html); 
}

function doFloorSelect()
{
  var city = $j('select[name=city]').val();
  var building = $j('select[name=building]').val();
  var html = '';
  var max_floor = 0;
  if (building) {
    max_floor = BUILDING[building].floor
  } else if (city) {
    for (var i=0; i < CITY[city].length; i++) {
      var key = CITY[city][i];
      if (max_floor < BUILDING[key].floor)
        max_floor = BUILDING[key].floor
    }
  } else {
    for (var i=0; i < Object.keys(BUILDING).length; i++) {
      var key = Object.keys(BUILDING)[i];
      if (max_floor < BUILDING[key].floor)
        max_floor = BUILDING[key].floor
    }
  }

  html += '<option value="" selected>Floor</option>';
  for (var i=1; i <= max_floor; i++) {
    html += '<option value="'+i+'">'+i+'</option>';
  }

  $j('select[name=floor]').html(html); 
}

function buildFilter()
{
  var html = '';
  html += '<select name="building" onchange="doFilter(\'building\')">';
  html += '</select>';

  html += '<select name="city" onchange="doFilter(\'city\')">';
  html += '<option value="" selected>City</option>';
  for (var i=0; i < Object.keys(CITY).length; i++) {
   html += '<option value="'+Object.keys(CITY)[i]+'">'+Object.keys(CITY)[i]+'</option>';
  }
  html += '</select>';

  html += '<select name="bed" onchange="doFilter(\'bed\')">';
  html += '</select>';

  html += '<select name="bath" onchange="doFilter(\'bath\')">';
  html += '</select>';

  html += '<select name="floor" onchange="doFilter(\'floor\')">';
  html += '</select>';

  $j('.filter').html(html);

  doBuildingSelect();
  doBedSelect();
  doBathSelect();
  doFloorSelect();
}



$j(document).ready(function() {
  buildFilter();
  buildResult();
});


  
