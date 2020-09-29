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
                        <form id="fsearch">
                            <input type="text" name="search" id="search">
                            <input type="button" id="submit" value="Search">
                        </form>
                    </div>
                    <div id="result">
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
        global $wpdb;

        $search = $_POST['search'];
        $response = array();

        $query = new WP_Query( array( 'post_type' => 'post', 's' =>  $search, 'post_status' => 'publish') );        
        while ( $query->have_posts() ) {
            $query->the_post();
            array_push($response, get_the_title());
        }
        wp_reset_postdata();

        echo json_encode($response);
        wp_die();
    }

    public function list_post_callback() {
        global $wpdb;

        $spost = $_POST['submit'];

        $paged = (get_query_var('page')) ? get_query_var('page') : 1;        
        $query = new WP_Query( 
            array( 
                'post_type' => 'post', 
                's' =>  $spost, 
                'post_status' => 'publish',
                'posts_per_page' => 2,
                'paged' => $paged
            ) 
        );

        if($query->have_posts()) {

            while ( $query->have_posts() ) {
                $query->the_post();
                echo "<div><h2>".get_the_title()."</h2></div>";
            }

            $total_pages = $query->max_num_pages;
            
            if ($total_pages > 1){
                $current_page = max(1, get_query_var('page'));
                echo paginate_links(array(
                    'base' => get_pagenum_link(1) . '%_%',
                    'format' => '/page/%#%',
                    'current' => $current_page,
                    'total' => $total_pages,
                    'prev_text'    => __('prev'),
                    'next_text'    => __('next'),
                ));
            }
        }
        wp_reset_postdata();

        wp_die();
    }

}

$autocomplete = new Autocomplete();

add_action('wp_enqueue_scripts', array($autocomplete, 'enqueue_autocomplete'));

add_action( 'wp_ajax_autocomplete_post', array($autocomplete,'autocomplete_callback') );
add_action( 'wp_ajax_nopriv_autocomplete_post', array($autocomplete,'autocomplete_callback') );

add_action( 'wp_ajax_list_post', array($autocomplete,'list_post_callback') );
add_action( 'wp_ajax_nopriv_list_post', array($autocomplete,'list_post_callback') );

add_shortcode('wp6_training', array($autocomplete, 'wp6_training_sc'));
