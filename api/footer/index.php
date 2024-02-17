<?php 

$globals_route = dirname(__DIR__) . '/globals.php';
require_once $globals_route;

function footer_api($request){
    
    $data =array(    
        'data' => array(
            'menu' => get_menu('')
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