<?php

function string_to_slug($string, $separator = '-') {
    // Convert to lowercase
    $string = strtolower($string);

    // Replace spaces with the separator
    $string = str_replace(' ', $separator, $string);

    // Remove special characters except alphanumeric and the separator
    $string = preg_replace('/[^a-z0-9' . preg_quote($separator, '/') . ']+/', '', $string);

    // Trim separator from the beginning and end of the string
    $string = trim($string, $separator);

    return $string;
}

function get_submenu($menu_items, $menu_id){
    $sub_menu_array = array();
    foreach ($menu_items as $menu_item) {
        $menu_item_title = $menu_item->title;
        $menu_item_slug = string_to_slug($menu_item_title);
        $menu_item_link = $menu_item->url;
        $menu_item_id = $menu_item->ID;
        $menu_item_parent_id = $menu_item->menu_item_parent;

        if($menu_id == $menu_item_parent_id){
            $sub_menu_array[] = array(
                'menu_item_title' => $menu_item->title,
                'menu_item_slug' => $menu_item_slug,
                'menu_item_link' => $menu_item_link,
                'menu_item_id' => $menu_item_id,
                'menu_item_parent' => $menu_item_parent_id,
                'target' => $menu_item->target,
                'sub_menu' => get_submenu($menu_items, $menu_item_id)
            );
        }
    }

    return $sub_menu_array;
}

function get_menu($menu_name){
    global $URL; 

    $menu_items = wp_get_nav_menu_items($menu_name);
    $new_menu_items = array();

    if ($menu_items) {
    
        foreach ($menu_items as $menu_item) {

            $menu_item_title = $menu_item->title;
            $menu_item_slug = string_to_slug($menu_item_title);
            $menu_item_link = $menu_item->url;
            $menu_item_id = $menu_item->ID;
            $menu_item_parent_id = $menu_item->menu_item_parent;

            if($menu_item_parent_id == 0)
            {$new_menu_items[] = array(
                'menu_item_title' => $menu_item->title,
                'menu_item_slug' => $menu_item_slug,
                'menu_item_link' => $menu_item_link,
                'menu_item_id' => $menu_item_id,
                'menu_item_parent' => $menu_item_parent_id,
                'target' => $menu_item->target,
                'sub_menu' => get_submenu($menu_items, $menu_item_id)
            ); 
            }    
        }
        
        return $new_menu_items;
        //return $menu_items;
    }

}

function get_hero_slides_global($page_id){
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

function get_cta_banner_global($page_id){
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