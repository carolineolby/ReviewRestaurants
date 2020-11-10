<?php 
    //CREATING RESTAURANTS ADMIN
    function restaurants_admin() {
        //Title of the page
        //Menu title
        //premission
        //Menu_slug
        //Our callback function
        add_menu_page(
            'Restaurant Admin', 
            'Restaurants Admin', 
            'manage_options', 
            'restaurant-admin', 
            'restaurants_admin_create_page'
        ); 
        add_action('admin_init', 'restaurants_admin_custom_settings');
        // add_submenu_page('restaurant-admin-menu', 'Change color', 'Change color', 'manage_options'
    }

    //RESTAURANTS ADMIN SETTINGS 
    function restaurants_admin_custom_settings() {
        register_setting( 'restaurants-settings-group', 'colors' );
        add_settings_section('restaurants-admin-form-options', 'Change button color: ', 'restaurants_admin_form_options', 'restaurant-admin');
        add_settings_field('change_color', '', 'restaurants_admin_form_options', 'restaurant-admin', 'restaurants-admin-form-options'); 
    }


    function restaurants_admin_form_options() { 
        $pink = esc_attr_e( get_option('pink'));
        $purple = esc_attr_e( get_option('purple'));
        $blue = esc_attr_e( get_option('blue'));
        $red = esc_attr_e( get_option('red'));

        echo '
        <select id="colors" name="colors">
            <option name="color" value="'.$pink.'">pink</option>
            <option name="color" value="'.$purple.'">purple</option>
            <option name="color" value="'.$blue.'">blue</option>
            <option name="color" value="'.$red.'">red</option>
        </select>';
    }

    //RESTAURANTS ADMIN CONTENT 


    function restaurants_admin_create_page() { ?>
        <div class='wrap'>
            <h1>Test Admin Panel</h1>
            <form name='changeColor' method='post' action='options.php'> 
                <?php 
                    settings_errors(); 
                    settings_fields('restaurants-settings-group'); 
                    do_settings_sections('restaurant-admin');    
                ?>
                <input type='submit' name='submit' class='button-primary' value='<?php esc_attr_e('Save Changes') ?>' />
            </form>
        </div>
    <?php }


    //CHECK IF THE FORM IS SUBMITTET 
    // function check_form() {
    //     if(isset($_POST['submit'])) {
    //         $selected_val = $_POST['colors']; 
    //     }
    // }

    //SUB MENU
    // function restaurant_admin_menu_sub() {
    //     include ('ctp_restaurants.php');
    //     echo
    //     "<div class='wrap'>
    //         <h1>Submenu option page</h1>
    //     </div>";
    // }
    add_action('admin_menu', 'restaurants_admin');
    add_action('init', 'create_cpt_restaurant'); 
?>