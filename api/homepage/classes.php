<?php 

    class Featured_Event{
        public $title;
        public $video_url;

        public function __construct($title, $video_url) {
            $this->title = $title;
            $this->video_url = $video_url;
        }
    };

    class Latest_Products{
        public $title;
        public $products_arr;

        public function __construct($title, $products_arr){
            $this->title = $title;
            $this->products_arr = $products_arr;
        }
    };

    class Featured_Whisky{
        public $title;
        public $description;
        public $image;
        public $distilery;
        public $bottling_date;
        public $price_per_bottle;

        public function __construct($title, $description, $image, $distilery, $bottling_date, $price_per_bottle){
            $this->title = $title;
            $this->description = $description;
            $this->image = $image;
            $this->distilery = $distilery;
            $this->bottling_date = $bottling_date;
            $this->price_per_bottle = $price_per_bottle;
        }
    }

    class Featured_Whisky_Section{
        public $label;
        public $whisky_arr;

        public function __construct($label, $whisky_arr){
            $this->label = $label;
            $this->whisky_arr = $whisky_arr;
        }
    }
    
    class Featured_Articles{
        public $label;
        public $articles;

        public function __construct($label, $articles){
            $this->label = $label;
            $this->articles = $articles;
        }
    }
?>