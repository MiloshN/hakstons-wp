<?php 
    $URL = 'localhost:3000';

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

    function get_header_logo(){
        $header_logo_arr = get_field('header_logo', 'options');

        return array(
            'header_logo_url' => $header_logo_arr['url'],
            'header_logo_alt' => $header_logo_arr['alt']
        );
    }

    function get_header_menu(){
        global $URL; 

        $menu_items = wp_get_nav_menu_items('Header menu');
        $new_menu_items = array();

        if ($menu_items) {
        
            foreach ($menu_items as $menu_item) {

                $menu_item_title = $menu_item->title;
                $menu_item_slug = string_to_slug($menu_item_title);
                $menu_item_link = $URL . '/' . $menu_item_slug;

                $new_menu_items[] = array(
                    'menu_item_title' => $menu_item->title,
                    'menu_item_slug' => $menu_item_slug,
                    'menu_item_link' => $menu_item_link,
                );   
            }
            
            return $new_menu_items;
        }

    }

    function get_contact_num(){
        return get_field('contact_number','options');
    }

?>