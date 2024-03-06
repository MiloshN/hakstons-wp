<?php 

$globals_route = dirname(__DIR__) . '/globals.php';
require_once $globals_route;
require_once 'helpers.php';

function shop_api($request){
    $page = $request->get_param('page');
    $per_page = $request->get_param('per_page');
    $category_filter = $request->get_param('filter');

    // Validate and convert $page to an integer
    if (!is_numeric($page) || intval($page) != $page || $page < 1 || $page) {
        $page = 1; // Set default value if $page is not valid
    }

    // Validate and convert $per_page to an integer
    if (!is_numeric($per_page) || intval($per_page) != $per_page || $per_page <= 0) {
        $per_page = 10; // Set default value if $per_page is not valid
    }

    $category_slug = 'whisky-product';

    $args = array(
        'post_type' => 'products',
        'posts_per_page' => $per_page, 
        'paged' => $page,
      //  'category_name' => $category_slug,
        'tax_query' => array(
            'relation' => 'AND',  
            'default_filter' => array(
                'taxonomy' => 'category',
                'field'    => 'slug',
                'terms'    => $category_slug,
            ),
        )
            
    );

     if( $category_filter != null ){
         $args['tax_query'][] = array(
             'relation' => 'OR',
             array(
                 'taxonomy' => 'category',
                 'field'    => 'slug',
                 'terms'    => $category_filter,
             ),
         );
     };


    $whisky_products = new WP_Query($args);

    $total_posts = $whisky_products->found_posts;
    $total_pages = ceil($total_posts/$per_page);

    if($page > $total_posts){
        $total_pages = 1;
    }

    //next page url
    $next_page = $page+1;

    $next_page_url = construct_url($next_page, $per_page, $category_filter);
    
    if($page >= $total_pages){
        $next_page_url = null;
    };

    // previous page url
    $prev_page = $page - 1;

    $prev_page_url = construct_url($prev_page, $per_page, $category_filter);
    
    if($page == 1){
        $prev_page_url = null;
    }

    // first and last page url
    $last_page_url = construct_url($total_pages, $per_page, $category_filter);
    $first_page_url = construct_url(1, $per_page, $category_filter);
    
    $data = array(  
        'category_filter' => $category_filter,
        'per_page' => $per_page,
        'current_page' => $page,
        'total_pages' => $total_pages,
        'data' => get_shop_whisky_products($whisky_products, $per_page, $page),
        'prev_page_url' => $prev_page_url,
        'next_page_url' => $next_page_url,
        'first_page_url' => $first_page_url,
        'last_page_url' => $last_page_url
    );

    $response = new WP_REST_Response($data);
    $response->set_status(200);

    return $response;
}


add_action('rest_api_init', function () {
    register_rest_route('myApi/v1', '/shop', array(
        'methods' => 'GET',
        'callback' => 'shop_api',
    ));
});

function shop_page($request){
    
    $data = array(  
        'data' => array(
            'hero_slides' => get_hero_slides_global(244),
            'cta_banner' => get_cta_banner_global(244)
        )
    );

    $response = new WP_REST_Response($data);
    $response->set_status(200);

    return $response;
}


add_action('rest_api_init', function () {
    register_rest_route('myApi/v1', '/shop-page', array(
        'methods' => 'GET',
        'callback' => 'shop_page',
    ));
});





?>
