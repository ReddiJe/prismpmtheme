var $j = jQuery.noConflict();

var future_properties;
var carousel_items = [];
var selected_marker = null;
var marker_popup = null;
var filtered_properties;
var is_init = true;
var map;
var rental_living_data;
var pre_selected = -1;

function loadPropertyGallery(id) {
  var imgs = filtered_properties[id].imgs;
  var html = '';
  for (var i = 0; i < imgs.length; i++) {
    html += '<li style="background-image:url('+imgs[i]+')" data-url="'+imgs[i]+'"></li>';
  }
  $j('#property-gallery').html(html);
}

function loadPUMLightBox(url) {
  $j('#pum-lightbox').css('background-image','url('+url+')');
  $j('#pum-lightbox').fadeIn('fast');
}

function initPUMLightBox() {
  if ($j("#property-gallery").length) {
    var html = '<div id="pum-lightbox"><button><i class="fa-sharp fa-solid fa-circle-xmark"></i></button</div>';
    $j('body').append(html);

    $j('#pum-lightbox button').on('click',function() {
      $j('#pum-lightbox').fadeOut('fast');
    })
  }
}

$j(document).ready(function() {
  loadMapBox();
  initPUMLightBox();

  $j(document).on('click',"#property-gallery li",function() {
    loadPUMLightBox($j(this).attr('data-url'))
  });

  $j(document).on('click',"#properties-list ul li",function() {
    showOnMap($j(this).attr('data-target'));
  });

  $j('.pum').on('click',function() {
    //var target_id = $j(this).attr('id').replace('pum-','');
    var target_id = $j(this).parent().index() - 1;
    $j('.pum').removeClass('selected');
    $j(this).addClass('selected');
    
    showOnMap(target_id);
    loadPropertyGallery(target_id);
  });
});

function toggleLayerVisibility(layerId) {
  const visibility = map.getLayoutProperty(layerId, "visibility")

  if (visibility === "visible") {
    map.setLayoutProperty(layerId, "visibility", "none")
  } else {
    map.setLayoutProperty(layerId, "visibility", "visible")
  }
}

// jQuery.fn.scrollTo = function(elem,speed) { 
//     $j(this).animate({
//         scrollTop:  $j(this).scrollTop() - $j(this).offset().top + $j(elem).offset().top 
//     }, speed == undefined ? 1000 : speed); 
//     return this; 
// };

function toggleMapSelection(id) {
  $j('#properties-list ul li').removeClass('active');
  if (id != null) {
    $j('#properties-list ul li[data-target="'+id+'"]').addClass('active');  

    $j("#properties-list").scrollTo($j('#properties-list ul li[data-target="'+id+'"]'), 1000); //custom animation speed 

  }
}

function showOnMap(id) {
  // toggleMapSelection(id);
  const coordinates = filtered_properties[id].geometry.coordinates.slice();
  var description = '';
  const point = [-20,0];
  description += '<img src="'+filtered_properties[id].properties.img+'" class="thumb">';
  description += '<img src="'+DIRECTORY_URI+'/img/prism-marker.svg" class="marker">';
  description += '<span><h2>'+filtered_properties[id].properties.name+'</h2>';
  description += filtered_properties[id].properties.address;
  description += '<br>'+filtered_properties[id].properties.city+', '+filtered_properties[id].properties.province+' '+filtered_properties[id].properties.postal;
  description += '</span>';

  if (marker_popup) {
    if (marker_popup.isOpen()) {
      marker_popup.remove();
    }
  }

  map.flyTo({
    center: [coordinates[0],Number(coordinates[1])+0.001800],
    zoom:15
  });

  marker_popup = new mapboxgl.Popup({closeOnClick:true,anchor:'bottom-left',offset:point,maxWidth:'400px'})
  .setLngLat(coordinates)
  .setHTML(description)

  marker_popup.addTo(map);

  selected_marker = id;

  map.setFeatureState({
    source: 'properties',
    id: selected_marker
  }, {
    hover: false
  });

  marker_popup.on('close',function(e) {
    if (selected_marker != null) {
      map.setFeatureState({
        source: 'properties',
        id: selected_marker
      }, {
        hover: true
      });
      selected_marker = null;
    }
  });
}

function doPropertiesList() {
  filtered_properties = geojson_data.features;
  
  // var html = '<ul>';
  // for (var i=0; i < filtered_properties.length; i++) {

  //   var city = filtered_properties[i].properties.city;
  //   var province = filtered_properties[i].properties.province;
  //   var city_province = city+', '+province;
  //   var prop_name = filtered_properties[i].properties.name;
  //   var address = filtered_properties[i].properties.address;
  //   address += '<br>'+city+', '+province+' '+filtered_properties[i].properties.postal;
  //   var img = filtered_properties[i].properties.img;
   
  //   if (carousel_items[city_province] === undefined) {
  //     carousel_items[city_province] = [];
  //   }

  //   var tmp = {};
  //   tmp.title = prop_name;
  //   tmp.loc = address;
  //   tmp.img = img;

  //   carousel_items[city_province].push(tmp);

  //   html += '<li data-target="'+i+'">'
  //   html += '<img src="'+DIRECTORY_URI+'/img/prism-marker.svg">';
  //   html += '<span><h3>'+prop_name+'</h3>';
  //   html += address
  //   html += '</span></li>';
  // }
  // html += '</ul>';
  // $j('#properties-list').html(html);
}

function preSelectProperty() {
  var id = filtered_properties[0].id;
  pre_selected = $j('#pum-'+id).parent().index() - 1;
  $j('#pum-'+id).addClass('selected');
  loadPropertyGallery(0);
}

function loadMapBox() {
  doPropertiesList();
  preSelectProperty()
  mapboxgl.accessToken = 'pk.eyJ1IjoiYXRyaWEtZGV2IiwiYSI6ImNsOXg2eHl6aTA3dWUzbnBhNXA4NTJpbGQifQ.czK214HlX_TPwg_eqoDe4Q';
  map = new mapboxgl.Map({
    container: 'properties-map',
    style: 'mapbox://styles/atria-dev/claa2brwt001216qvfamjhj30',
    center:[-79.38317951,43.6398134],
    zoom: 7,
    maxZoom: 17,
    minZoom: 7,
    cooperativeGestures: true,
    attributionControl: false
  });

  // Add zoom and rotation controls to the map.
  map.addControl(new mapboxgl.NavigationControl({showCompass: false}),'bottom-right');

  map.on('load', function() {

    map.loadImage(DIRECTORY_URI+'/img/prism-marker.png', function(error, image) {

      if (error) throw error;
      map.addImage('myMarker', image);

      map.addSource('properties', {
        'type': 'geojson',
        'data': geojson_data, // Use a URL for the value for the `data` property.
        'generateId': true // This ensures that all features have unique IDs
      });

      map.addLayer({
        "id": "places",
        "type": "symbol",
        "source": "properties",
        "layout": {
          "icon-image": "myMarker",
          "icon-size": 0.2,
          "icon-anchor":"bottom"
        },
        'paint': {
          'icon-opacity': [
            'case',
            ['boolean', ['feature-state', 'hover'], true],
            1,
            0
          ]
        }
      });

      // When a click event occurs outside of any places. reset the list selection
      map.on('click', function(e) {
        if (e.defaultPrevented === false) {
          // $j('#properties-list ul li').removeClass('active');
        }
      });

      // When a click event occurs on a feature in the places layer, open a popup at the
      // location of the feature, with description HTML from its properties.
      map.on('click', 'places', (e) => {
        // Copy coordinates array.
        const coordinates = e.features[0].geometry.coordinates.slice();
        var description = '';
        const point = [-20,0];
        description += '<img src="'+e.features[0].properties.img+'" class="thumb">';
        
        description += '<img src="'+DIRECTORY_URI+'/img/prism-marker.svg" class="marker">';
        description += '<span><h2>'+e.features[0].properties.name+'</h2>';
        description += e.features[0].properties.address;
        description += '<br>'+e.features[0].properties.city+', '+e.features[0].properties.province+' '+e.features[0].properties.postal
        description += '</span>';
        map.flyTo({                              
          center: [coordinates[0],Number(coordinates[1])+0.001800],//e.features[0].geometry.coordinates,
          zoom:15
        });

        // Ensure that if the map is zoomed out such that multiple
        // copies of the feature are visible, the popup appears
        // over the copy being pointed to.
        while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
          coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
        }
       
        marker_popup = new mapboxgl.Popup({closeOnClick:true,anchor:'bottom-left',offset:point,maxWidth:'400px'})
        .setLngLat(coordinates)
        .setHTML(description)
        .addTo(map);

        selected_marker = e.features[0].id;
        
        toggleMapSelection(selected_marker);

        map.setFeatureState({
          source: 'properties',
          id: selected_marker
        }, {
          hover: false
        });

        marker_popup.on('close',function(e) {
          if (selected_marker != null) {
            map.setFeatureState({
              source: 'properties',
              id: selected_marker
            }, {
              hover: true
            });
            selected_marker = null;
          } 
        });
      });

      map.on('mouseenter', 'places', (e) => {
        // Change the cursor style as a UI indicator.
        map.getCanvas().style.cursor = 'pointer';
      });
       
      map.on('mouseleave', 'places', () => {
        map.getCanvas().style.cursor = '';
      });

      if (pre_selected != -1) {
        showOnMap(pre_selected);
        loadPropertyGallery(pre_selected);
        pre_selected = -1
      }
    });
  });
}

  
