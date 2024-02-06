<?php 
require 'classes.php';

function homepage_api($request) {
    $homepage_id = get_option('page_on_front');

    if ($homepage_id) {

        $hero_slides = array();

        if (have_rows('hero_section', $homepage_id)) {
            while (have_rows('hero_section', $homepage_id)) {
                the_row();

                $hero_title = get_sub_field('title');
                $hero_img_arr = get_sub_field('image');
                $hero_img_url = $hero_img_arr['url'];

                $hero_slides[] = array(
                    'title' => $hero_title,
                    'image_url' => $hero_img_url,
                );
            }
        }

        $intro = get_field('intro_section', $homepage_id);
        
        $latest_products_title = get_field('latest_products_title', $homepage_id);

        $args = array(
            'post_type'      => 'products',
            'posts_per_page' => 4,
            'orderby'        => 'date', 
            'order'          => 'DESC', 
        );
        
        $query = new WP_Query( $args );

        $latest_products_list = array();
        if ( $query->have_posts() ) {
            while ( $query->have_posts() ) {
                $query->the_post();
                $latest_product = get_field("products");
                
                $latest_products_list[] = $latest_product;
            }
            wp_reset_postdata();
        } else {
            echo 'No products found';
        }

        $featured_events = get_field('featured_events', $homepage_id);
        $featured_events_arr = array();
        
        if($featured_events) {
            foreach($featured_events as $event_id){
                $event_title = get_field('event_title', $event_id);
                $event_video_url = get_field('event_video_url', $event_id);
                $event = new Featured_Event($event_title, $event_video_url);

                $featured_events_arr[] = $event;
            }
        }

        $featured_whisky_id = get_field('featured_whisky', $homepage_id);
        $featured_whisky_arr = array();

        if($featured_whisky_id) {
            foreach($featured_whisky_id as $whisky_id){
                $product = get_field('products', $whisky_id);
                $title = $product['title'];
                $description = $product['description'];
                $image = $product['image'];
                $distilery = get_field('distilery', $whisky_id);
                $bottling_date = get_field('bottling_date', $whisky_id);
                $price_per_bottle = get_field('price_per_bottle', $whisky_id);

                $featured_whisky_arr[] = new Featured_Whisky($title, $description, $image, $distilery, $bottling_date, $price_per_bottle);
            }
            
            $label = get_field('featured_whisky_label', $homepage_id);

            $featured_whisky = new Featured_Whisky_Section($label, $featured_whisky_arr);
        }


        $cta_banner_label = get_field('cta_label',$homepage_id);

        $featured_articles_label = get_field('articles_label', $homepage_id);
        $featured_articles_list = array();
        $blog_args = array(
            'post_type'      => 'post',
            'posts_per_page' => 4,
            'orderby'        => 'date', 
            'order'          => 'DESC', 
        );

        $blog_query = new WP_Query($blog_args);

        if ( $blog_query->have_posts() ) {
            while ( $blog_query->have_posts() ) {
                $blog_query->the_post();
                
                $featured_articles_list[] = array(
                    'title' => get_the_title(),
                    'desc' => get_the_excerpt(),
                );
            }
            wp_reset_postdata();
        } else {
            echo 'No articles found';
        }

        $featured_articles = new Featured_Articles($featured_articles_label, $featured_articles_list);


        //


        $data = array(
            'message' => 'Custom endpoint for homepage works!',
            'homepage_id' => $homepage_id,
            'hero_slides' => $hero_slides,
            'intro' => $intro,
            'latest_products' => new Latest_Products($latest_products_title, $latest_products_list),
            'featured_events' => $featured_events_arr,
            'featured_whisky' => $featured_whisky,
            'cta_banner' => $cta_banner_label,
            'latest_articles' => $featured_articles
        );

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