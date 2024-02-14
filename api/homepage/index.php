<?php 
require 'helpers.php';

function homepage_api($request) {
    $homepage_id = get_option('page_on_front');

    if ($homepage_id) {

        $homepage_title = get_the_title($homepage_id);
        $hero_slides = get_hero_slides($homepage_id);
        $intro = get_field('intro_section', $homepage_id);   
        $latest_products = get_latest_products($homepage_id);
        $featured_events_arr = get_featured_events($homepage_id); 
        $featured_whisky = get_featured_whiskys($homepage_id);
        $cta_banner_label = get_cta_banner($homepage_id);       
        $featured_articles = get_featured_articles($homepage_id);
        $featured_press = get_featured_press($homepage_id);
        //

        $data =array(    
            'data' => array(
                'homepage_title' => $homepage_title,
                'hero_slides' => $hero_slides,
                'intro' => $intro,
                'latest_products' => $latest_products,
                'featured_events' => $featured_events_arr,
                'featured_whisky' => $featured_whisky,
                'cta_banner' => $cta_banner_label,
                'latest_articles' => $featured_articles,
                'featured_press' => $featured_press
            ));

        $response = new WP_REST_Response($data);
        $response->set_status(200);

        return $response;
    } else {
        // Handle the case where the homepage ID is not set
        return rest_ensure_response(array('error' => 'Homepage ID not set.'));
    }
}

add_action('rest_api_init', function () {
    register_rest_route('myApi/v1', '/homepage', array(
        'methods' => 'GET',
        'callback' => 'homepage_api',
    ));
});



?>