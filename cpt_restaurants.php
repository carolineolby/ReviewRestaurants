<?php
    /* 
        Plugin Name: Restaurant Post Type
    */

    include( plugin_dir_path( __FILE__ ) . '/includes/restaurants_widget.php'); 
    include( plugin_dir_path( __FILE__ ) . '/includes/restaurants_admin.php'); 

    //CREATE CUSTOM POST TYPES 
    function create_cpt_restaurant() {
        wp_enqueue_style('style', plugin_dir_url( __FILE__ ) . '/includes/css/style.css');

        register_post_type('cpt_restaurant', 
            array(
                'labels' => array (
                    'name' => 'Restaurants', 
                    'singular_name' => 'Restaurant',
                ),
                    'public' => true,
                    'has_archive' => true,
                    'supports' => array( 'title', 'editor', 'author', 'thumbnail')
            )
        );
    }

    //REVIEWSSYSTEM 
    //UNINSTALL RATES TABLE IN PHP SQL 
    function rates_uninstall() {
        global $wpdb; 
        $table_name = $wpdb->prefix . "rates"; 
        $wpdb->query("DROP TABLE IF EXISTS $table_name"); 
    }
    
    //CREATE REVIEWS TABLE IN PHP SQL
    function create_rates_table() {
        global $wpdb; 

        $charset_collate = $wpdb->get_charset_collate(); 
        $table_name = $wpdb->prefix . "rates"; 
        $post_table = $wpdb->prefix . "posts"; 
        $user_table = $wpdb->prefix . "users"; 

        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            rates_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, 
            rates_content varchar(255) NOT NULL,
            owner_id BIGINT(20) UNSIGNED NOT NULL,
            post_id BIGINT(20) UNSIGNED NOT NULL, 
            PRIMARY KEY (id),
            FOREIGN KEY (owner_id) REFERENCES $user_table(ID),
            FOREIGN KEY (post_id) REFERENCES $post_table(ID)
        ) $charset_collate;"; 

        require_once ( ABSPATH . 'wp-admin/includes/upgrade.php'); 
        dbDelta ($sql); 
    }

    //ADD A ROW IN REVIEW TABLE
    function check_input() {
        global $wpdb; 
    
        if(isset($_POST['isreviewed'])) {
            $user_id = wp_get_current_user();
            $post_id = $_POST['isreviewed']; 
            $review = $_POST['review'];
            // $wpdb->get_results( "INSERT INTO wp_rates (rates_date, rates_content, owner_id, post_id) VALUES (CURRENT_TIMESTAMP, '$review', $user_id->ID, $post_id)"); 

            //SQL Injection
            $query = $wpdb->prepare( "INSERT INTO wp_rates (rates_date, rates_content, owner_id, post_id) VALUES (CURRENT_TIMESTAMP, %s, %s, %s)", $review, $user_id->ID, $post_id); 
            $wpdb->get_results($query); 
        }
    
    }

    //REMOVE A ROW IN REVIEW TABLE 
    function uncheck_input() {
        global $wpdb; 

        if(isset($_POST['isremoved'])) {
            $user_id = wp_get_current_user(); 
            $post_id = $_POST['isremoved']; 
            // $wpdb->get_results( "DELETE FROM wp_rates WHERE (owner_id = $user_id->ID AND post_id = $post_id)");

            //SQL Injection
            $query = $wpdb->prepare( "DELETE FROM wp_rates WHERE (owner_id = %s AND post_id = %s)", $user_id->ID, $post_id );
            $wpdb->get_results($query); 
        }
    }

    //CREATE REVIEW BUTTON
    function add_input($content) {
        global $wpdb; 
        global $review_count; 

        if (is_singular() && in_the_loop() && is_main_query() ) {
            $id = get_the_ID(); 
            $user_id = wp_get_current_user(); 

            // $query = $wpdb->get_results( "SELECT rates_date, owner_id, post_id FROM wp_rates WHERE (owner_id = $user_id->ID AND post_id = $post_id) ORDER BY rates_date DESC LIMIT 10");

            //SQL Injection
            $query = $wpdb->prepare( "SELECT rates_date, owner_id, post_id FROM wp_rates WHERE (owner_id = %s AND post_id = %s) ORDER BY rates_date DESC LIMIT 10", $user_id->ID, $post_id);
            $wpdb->get_results($query); 

            $review_count = count($review_amount); 

            if($wpdb->num_rows == 0) {
                $review = $_POST['review'];
                $content .= 
                "<form method=POST style='padding-top: 100px; text-align:center;'>
                    <input style='padding:20px;' type=select placeholder='add review' name=review>
                    <button class=" . get_option('review_btn_color') . " id='review_btn_color' style='text-align:center;'> send your review </button>
                    <input type=hidden name=isreviewed value=$id></input>
                </form>"; 

            }   
        }
        return $content; 
    }

    //CREATE REMOVE REVIEW BUTTON
    function remove_input($content) {
        global $wpdb; 
        global $review_count; 

        if (is_singular() && in_the_loop() && is_main_query() ) { 
            $id = get_the_ID(); 
            $user_id = wp_get_current_user(); 

            // $query = $wpdb->get_results( "SELECT owner_id, post_id FROM wp_rates WHERE (owner_id = $user_id->ID AND post_id = $id)");

            //SQL Injection
            $query = $wpdb->prepare( "SELECT owner_id, post_id FROM wp_rates WHERE (owner_id = %s AND post_id = %s)", $user_id->ID, $id);
            $wpdb->get_results($query); 

            $review_count = count($review_amount); 
            
            if($wpdb->num_rows > 0) {
                $content .= 
                "<form method=POST style='padding-top: 100px; text-align:center;'>
                    <button class=" . get_option('remove_review_btn_color') . " id='remove_review_btn_color'> remove your review </button>
                    <input type=hidden name=isremoved value=$id></input>
                </form>"; 
            }
        }
        return $content; 
    }

    //COUNT THE AMOUNT OF REVIEWS 
    function count_reviews($content) {
        global $wpdb; 
        global $review_count;  

        if (is_singular() && in_the_loop() && is_main_query() ) { 
            $id = get_the_ID(); 
            $user_id = wp_get_current_user(); 

            $review_amount = $wpdb->get_results( "SELECT * FROM wp_rates WHERE (post_id = $id)");

            //SQL Injection
            // $review_amount = $wpdb->prepare( "SELECT * FROM wp_rates WHERE (post_id = %s)", $id);
            // $wpdb->get_results($review_amount); 

            $review_count = count($review_amount);
            $content .= "<p style='font-size: 15px; text-align:center;'> $review_count REVIEWS </p> <h3 class='Headline_AllReviews'; text-align:center;> All reviews </h3>" ; 

        }
        return $content; 
    }


    //DISPLAY REVIEWS 
    function display_reviews($content) {
        global $wpdb; 

        if (is_singular() && in_the_loop() && is_main_query() ) { 
            $id = get_the_ID(); 
            $user_id = wp_get_current_user(); 

            $review_displays = $wpdb->get_results( 
                 "SELECT wp_users.display_name, wp_rates.rates_content
                 FROM wp_users
                 INNER JOIN wp_rates 
                 ON wp_rates.owner_id = wp_users.ID AND post_id = $id
                 WHERE wp_rates.owner_id = wp_users.ID AND post_id = $id"
            );

            //SQL Injection
        //     $review_displays = $wpdb->prepare( 
        //         "SELECT wp_users.display_name, wp_rates.rates_content
        //         FROM wp_users
        //         INNER JOIN wp_rates 
        //         ON wp_rates.owner_id = wp_users.ID AND post_id = %s
        //         WHERE wp_rates.owner_id = wp_users.ID AND post_id = %s", $id, $id
        //    );
        //    $wpdb->get_results($review_displays); 

            foreach($review_displays as $review_display) {
                $display_users = $review_display->display_name; 
                $display = $review_display->rates_content;  
                $content .= "<div><div style='background: #fff; padding: 20px;'>
                    <p style='color: #000; font-size: 20px;'> user: $display_users <br> $display</p>
                </div></div>"; 
            }
            return $content; 
        }
        return $content; 
    }


    add_filter('the_content', 'add_input'); 
    add_filter('the_content', 'remove_input'); 
    add_filter('the_content', 'count_reviews'); 
    add_filter('the_content', 'display_reviews'); 

    add_action('init', 'check_input');
    add_action('init', 'uncheck_input');

    register_activation_hook(__FILE__, 'create_rates_table'); 
    register_deactivation_hook(__FILE__, 'rates_uninstall'); 
    register_uninstall_hook(__FILE__, 'rates_uninstall'); 

    add_action('init', 'create_cpt_restaurant'); 
?>