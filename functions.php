<?php
/**
 * Theme functions and definitions
 *
 * @package HelloElementorChild
 */

/**
 * Load child theme css and optional scripts
 *
 * @return void
 */
function hello_elementor_child_enqueue_scripts() {
	wp_enqueue_style('hello-elementor-child-style',get_stylesheet_directory_uri() . '/style.css',['hello-elementor-theme-style'],'1.0.0');
    wp_enqueue_style('home-style',get_stylesheet_directory_uri() . '/css/home.css',['hello-elementor-theme-style',],'1.0.0'); 
  if (is_page('Home') && strpos($_SERVER['REQUEST_URI'],'elementor') === false) {
    wp_enqueue_style('mapbox-gl',get_stylesheet_directory_uri() . '/css/mapbox-gl.css',['hello-elementor-theme-style',],'1.0.0');
    wp_enqueue_script('mapbox', get_stylesheet_directory_uri() . '/js/mapbox-gl.js', array('jquery'), filemtime(get_stylesheet_directory() .'/js/mapbox-gl.js'), false );
    wp_enqueue_script('home', get_stylesheet_directory_uri() . '/js/home.js', array('jquery'), filemtime(get_stylesheet_directory() .'/js/home.js'), false );
  } else if (is_page('For Rent') && strpos($_SERVER['REQUEST_URI'],'elementor') === false) {
    wp_enqueue_script('stupidtable', get_stylesheet_directory_uri() . '/js/stupidtable.min.js', array('jquery'), filemtime(get_stylesheet_directory() .'/js/stupidtable.min.js'), false );
    wp_enqueue_script('prism-data', 'https://api.atriadevelopment.ca/json/prism.js', array('jquery'),time(), false );
    wp_enqueue_script('pirsm-setting', 'https://api.atriadevelopment.ca/json/prism-setting.js', array('jquery'),time(), false );
    wp_enqueue_script('for-rent', get_stylesheet_directory_uri() . '/js/for-rent.js', array('jquery'), filemtime(get_stylesheet_directory() .'/js/for-rent.js'), false );
    
  }
}
add_action( 'wp_enqueue_scripts', 'hello_elementor_child_enqueue_scripts', 20 );


function my_js_variables() {
  echo '<script type="text/javascript">';
  echo 'var DIRECTORY_URI = "'.get_stylesheet_directory_uri().'";';
  if (is_page('Home') && strpos($_SERVER['REQUEST_URI'],'elementor') === false) {
    echo prism_property_under_management();
  }
  echo '</script>';
}
add_action ( 'wp_enqueue_scripts', 'my_js_variables' );


function prism_property_under_management () {
  $args = array(
    'posts_per_page' => -1,
    'post_type' => 'property',
    'status' => 'publish',
    'tag' => 'completed'
    // 'tax_query' => array(
    //     array(
    //         'terms' => 'completed',
    //     ),
    // ),
    // 'meta_query' => array(
    //   array(
    //     'key'     => 'home_section',
    //     'value'   => 'upcoming',
    //     'compare' => 'LIKE',
    //   )
    // )
  );

  // $args['meta_key'] = 'home_ordering';
  // $args['orderby'] = 'meta_value'; 
  // $args['order'] = 'ASC'; 
  $postslist = new WP_Query($args);
  $data = [];
  while ( $postslist->have_posts() ) {
    $postslist->the_post();
    $post_id = get_the_ID();
    $images = get_field('gallery',$post_id);
    $items = [];
    for ($i=0; $i < count($images); $i++) {
      $items[] = $images[$i]['url'];
    }

    $data[] = ['type' => 'Feature',
            'properties' => [
              'name' => get_the_title(),
              'address' => get_field('address'),
              'city' => get_field('city'),
              'province' => get_field('province'),
              'postal' => get_field('postal_code'),
              'img' => get_the_post_thumbnail_url($post_id,'medium'),

            ],
            'geometry' => [
              'coordinates'=>[get_field('longitude'), get_field('latitude')],
              'type'=>'Point'
            ],
            'imgs' => $items,
            'id' => $post_id
          ];
  }

  return 'var geojson_data = '. json_encode(array('type'=>'FeatureCollection','features'=>$data)).';';
}

// This function runs after post is saved
function prism_acf_save_post( $post_id ) {
  
  if (get_post_type($post_id) != 'property') {
    $tmp = get_field( 'address', $post_id );
    $tmp .= ', '.get_field('city',$post_id);

    update_field('address_city', $tmp, $post_id);
  }
}
add_action('acf/save_post', 'prism_acf_save_post', 20);

/**
 * Just show the website name only
 *
 * @return string
 */
function render_title($title){
    return get_bloginfo( 'name' );
}
add_filter('pre_get_document_title' , 'render_title');

include "elementor-form-filter.php";