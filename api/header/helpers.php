<?php 
    $URL = 'localhost:3000';

    function get_header_logo(){
        $header_logo_arr = get_field('header_logo', 'options');

        return array(
            'header_logo_url' => $header_logo_arr['url'],
            'header_logo_alt' => $header_logo_arr['alt']
        );
    }

    function get_contact_num(){
        return get_field('contact_number','options');
    }

?>