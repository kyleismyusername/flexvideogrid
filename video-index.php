<?php
 /**
 * Plugin Name: Vue Video Index App
 * Description: Custom VueJS plugin to list and filter videos post type.
 * Version: 0.4
 * GitHub Plugin URI: https://github.com/kyleismyusername/flexvideogrid
 */

// Vue scripts
 function load_vuescripts()
 {
     wp_register_script('vue_video_a', plugin_dir_url(__FILE__).'dist/js/app.js', true);
     wp_register_script('vue_video_b', plugin_dir_url(__FILE__).'dist/js/chunk-vendors.js', true);
 }

 add_action('wp_enqueue_scripts', 'load_vuescripts');

 //Add shortcode
 function video_index()
 {
     wp_enqueue_script('vue_video_a');
     wp_enqueue_script('vue_video_b');
     wp_enqueue_style('vue_video_css', plugin_dir_url(__FILE__).'dist/css/app.css');

     return "<div id='vue-video-index'></div>";
 }

  add_shortcode('video_index_app', 'video_index');