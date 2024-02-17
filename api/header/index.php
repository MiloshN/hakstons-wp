<?php 

require 'helpers.php';

function header_api($request){


    $header_menu = get_header_menu('Header menu');
    $header_logo = get_header_logo();
    $contact_num = get_contact_num();
    

    $data =array(    
        'data' => array(
            'header_logo' => $header_logo,
            'header_menu' => $header_menu,
            'contact_num' => $contact_num
        ));

    $response = new WP_REST_Response($data);
    $response->set_status(200);

    return $response;
}


add_action('rest_api_init', function () {
    register_rest_route('myApi/v1', '/header', array(
        'methods' => 'GET',
        'callback' => 'header_api',
    ));
});

?>