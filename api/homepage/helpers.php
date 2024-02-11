<?php 
require 'classes.php';

    function get_featured_whiskys($page_id){
        $featured_whisky_id = get_field('featured_whisky', $page_id);
        $featured_whisky_arr = array();

        if($featured_whisky_id) {
            foreach($featured_whisky_id as $whisky_id){
                $product = get_field('products', $whisky_id);
                $title = $product['title'];
                $description = $product['description'];
                $image = $product['image'];
                $currency = $product['currency'];
                $distillery = get_field('distilery', $whisky_id);
                $bottling_date = get_field('bottling_date', $whisky_id);
                $price_per_bottle = get_field('price_per_bottle', $whisky_id);

                $featured_whisky_arr[] = new Featured_Whisky($title, $description, $image, $currency, $distillery, $bottling_date, $price_per_bottle);
            }
            
            $label = get_field('featured_whisky_label', $page_id);

            $featured_whisky = new Featured_Whisky_Section($label, $featured_whisky_arr);
        }

        return $featured_whisky;

    }

    function get_hero_slides($page_id){
        $hero_slides = array();

        if (have_rows('hero_section', $page_id)) {
            while (have_rows('hero_section', $page_id)) {
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

        return $hero_slides;
    }

    function get_latest_products($page_id){
        $latest_products_title = get_field('latest_products_title', $page_id);

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

       return new Latest_Products($latest_products_title, $latest_products_list);
    }

    function get_featured_events($page_id){
        $featured_events = get_field('featured_events', $page_id);
        $featured_events_arr = array();
        
        if($featured_events) {
            foreach($featured_events as $event_id){
                $event_title = get_field('event_title', $event_id);
                $event_video_url = get_field('event_video_url', $event_id);
                $event = new Featured_Event($event_title, $event_video_url);

                $featured_events_arr[] = $event;
            }
        }
        
        return $featured_events_arr;
    }

    function get_featured_articles($page_id){
        $featured_articles_label = get_field('articles_label', $page_id);
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

        return $featured_articles = new Featured_Articles($featured_articles_label, $featured_articles_list);
    }

    function get_featured_press($page_id){
        $featured_press_label = get_field('press_label', $page_id);
        $featured_press_arr = array();

         if(have_rows('single_press', $page_id)){
             while(have_rows('single_press', $page_id)){
                the_row();
                 $logo = get_sub_field('single_press_logo');
                 $text = get_sub_field('single_press_text');
                 $url = get_sub_field('press_article_link');
                
                 $featured_press_arr[] = array(
                     'logo' => $logo,
                     'text' => $text,
                     'url' => $url
                 );
             }  
         }

         return new Featured_Press_Section($featured_press_label, $featured_press_arr);

    }


    function get_cta_banner($page_id){
        $cta_banner = get_field('cta_label',$page_id);
        $cta_img = $cta_banner['logo'];

        return array(
            'heading' => $cta_banner['heading'],
            'text' => $cta_banner['text'],
            'logo' => array(
                'url' => $cta_img['url'],
                'alt' => $cta_img['alt']
            )            
        );

    }
?>