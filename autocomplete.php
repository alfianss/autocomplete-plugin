<?php
/*
Plugin Name: Autocomplete Plugin
Plugin URI: http://example.com
Description: Simple WordPress Autocomplete
Version: 1.0
Author: Alfian SS
Author URI: http://example.com
*/

class Autocomplete {
    

    public function wp6_training_sc() {
        $widget =  '<div>
                        <form action="#fsearch" id="fsearch">
                            <input type="text" name="search" id="search">
                            <input type="submit" name="submit" value="Search">
                        </form>
                    </div>';
        
        return $widget;
    }    
    
    public function enqueue_autocomplete() {
        
        wp_enqueue_style('style-css', '//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css');        
        
        wp_enqueue_script( 'jquery-ui-autocomplete' );
        wp_enqueue_script( 'script-js', plugins_url( '/autocomplete.js', __FILE__ ),array('jquery'));

        wp_localize_script( 'script-js', 'autocomplete_ajax', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
    }

    public function autocomplete_callback() {
        // echo "hello";
        return true;
    }

}

$autocomplete = new Autocomplete();

add_action('wp_enqueue_scripts', array($autocomplete, 'enqueue_autocomplete'));

add_action( 'wp_ajax_autocomplete_post', 'autocomplete_callback' );
add_action( 'wp_ajax_nopriv_autocomplete_post', 'autocomplete_callback' );

add_shortcode('wp6_training', array($autocomplete, 'wp6_training_sc'));
