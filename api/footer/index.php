<?php 

$globals_route = dirname(__DIR__) . '/globals.php';
require_once $globals_route;
require_once 'helpers.php';

function footer_api($request){
    
    $data =array(    
        'data' => array(
            'footer_details' => get_footer_details(),
            'footer_social_media' => get_social_media(),
            'footer_company_details' => get_company_details(),
            'footer_menu' => get_menu('Footer menu')
        ));

    $response = new WP_REST_Response($data);
    $response->set_status(200);

    return $response;
}


add_action('rest_api_init', function () {
    register_rest_route('myApi/v1', '/footer', array(
        'methods' => 'GET',
        'callback' => 'footer_api',
    ));
});

?>