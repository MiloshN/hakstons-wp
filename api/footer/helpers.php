<?php

function get_footer_details(){
    $footer_details = get_field('footer_details', 'options');
    $footer_contact_section = $footer_details['footer_contact_section'];
    $footer_opening_hours = $footer_details['footer_opening_hours_section'];
    $footer_review_section = $footer_details['footer_reviews_section'];

    $footer_reviews = array();


    foreach($footer_review_section as $footer_review){
        $review = $footer_review['review'];
        $footer_reviews[] = array(
             'review_img_url' => $review['url'],
             'review_img_alt' => $review['alt']
        );
    }

    return array(
        'footer_contact_section' => $footer_contact_section,
        'footer_opening_hours' => $footer_opening_hours,
        'footer_review_section' => $footer_reviews
    );
};

function get_social_media(){
    $social_media = get_field('footer_social_media','options');

    $social_media_new_arr = array();

    foreach($social_media as $media){
        $social_media_icon = $media['social_media_icon'];
        $social_media_link = $media['social_media_link'];

        $social_media_new_arr[] = array(
                'social_media_icon_img_url' => $social_media_icon['url'],
                'social_media_icon_img_alt' => $social_media_icon['alt'],
                'social_media_link' => $social_media_link
            );
    }

    return $social_media_new_arr;
}

function get_company_details(){

    return get_field('footer_company_details','options');
}

?>