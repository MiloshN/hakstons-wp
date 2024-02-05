<?php 

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


        // 




        $data = array(
            'message' => 'Custom endpoint for homepage works!',
            'homepage_id' => $homepage_id,
            'hero_slides' => $hero_slides,
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