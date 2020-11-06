<?php
     //CREATING THE WIDGET
    class review_date_widget extends WP_Widget {
        // The construct part  
        function __construct() {       
            parent::__construct (
                'latest_reviewed_restaurant',
                'Latest reviewed',
                array('description' => 'Display latest reviewed restaurant')
            );
        }

        //CREATING WIDGET FRONT-END
        function widget($args, $instance){
            global $wpdb; 
            $id = get_the_ID(); 

            $title = 'Latest reviewed restaurants';

            //CREATING TITLE 
            echo $args['before_widget'];
            if (!empty( $title ) )
            echo $args['before_title'] . $title . $args['after_title'];

            $sortByLatests = $wpdb->get_results( 
                //SORTERAR EFTER SENASTE RATING
                "SELECT wp_posts.post_title, wp_rates.rates_date FROM wp_posts 
                INNER JOIN wp_rates ON wp_rates.post_id = wp_posts.ID
                WHERE wp_rates.post_id = wp_posts.ID GROUP BY wp_rates.rates_date ORDER BY rates_date DESC" 
            );

            $newArray = array(); 

            foreach($sortByLatests as $sortByLatest) {
                array_push($newArray, $sortByLatest->post_title); 
            }

            if (!empty ($instance['amount'])) {
                for ($i = 0; $i < $instance['amount']; $i++) {
                    echo "<p>$newArray[$i]</p>"; 
                }
            }

            // echo __($post_title);
            // echo __($post_title , 'wpb_widget_domain' );
            echo $args['after_widget'];
        }


        //CREATING WIDGET BACK-END
        function form($instance){
            printf('<input type="number" name="%s" value="' . $instance['amount'] . '" placeholder="how many? "></input>',
                $this->get_field_name("amount")
            );
        }
    }

    function review_date_init_widget(){
        register_widget('review_date_widget');
    }
    
    add_action('widgets_init', 'review_date_init_widget');
?>