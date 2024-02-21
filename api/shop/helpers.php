<?php 

    function validateNumeric($value, $defaultValue = null, $minValue = null) {
        if (is_numeric($value)) {
            $value = (float) $value; // Cast to float to handle both integers and floats
            if ($minValue !== null) {
                // Ensure the value is greater than or equal to the specified minimum value
                $value = max($minValue, $value);
            }
            return $value;
        } else {
            // If not numeric, return the default value or handle the error accordingly
            return $defaultValue;
        }
    } 

    
    function get_tax_query_filter_arr($filter_list){
        $new_filter_list = array();
        foreach($filter_list as $filter){
            $new_filter_list[] = array(
                'taxonomy' => 'category',
                'field'    => 'slug',
                'terms'    => $filter
            );
        }
        return $new_filter_list;
    }

    function construct_url($page_to, $per_page, $filter){
        if(!empty($filter)){
            return rest_url("myApi/v1/shop?page=$page_to&per_page=$per_page&" . http_build_query(['filter' => $filter]));
        } else {
            return rest_url("myApi/v1/shop?page=$page_to&per_page=$per_page");
        };
    }


    function get_shop_whisky_products($query, $per_page, $page){

        $per_page = validateNumeric($per_page);
        $page = validateNumeric($page);
        
        
        $whisky_products = $query;

        $result = array();

        if ($whisky_products->have_posts()) {
            while ($whisky_products->have_posts()) {
                $whisky_products->the_post();
                $whisky_id = get_the_ID();
                $category = get_the_category($whisky_id);
                
                $product = get_field('products', $whisky_id);
                $title = $product['title'];
                $description = $product['description'];
                $image = $product['image'];
                $currency = $product['currency'];
                $distillery = get_field('distilery', $whisky_id);
                $bottling_date = get_field('bottling_date', $whisky_id);
                $price_per_bottle = get_field('price_per_bottle', $whisky_id);

    
                $post_data = array(
                    'id' => $whisky_id,
                    'title'   => $title,
                    'descripiton' => $description,
                    'image' => $image,
                    'currency' => $currency,
                    'distillery' => $distillery,
                    'bottling_date' => $bottling_date,
                    'price_per_bottle' => $price_per_bottle
                );
    
                $result[] = $post_data;
            }
    
            // Restore original post data
            wp_reset_postdata();
        }
    
        return $result;
    }

?>