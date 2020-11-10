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
            'restaurants_admin_form'
        ); 
        add_action('admin_init', 'restaurants_admin_settings');
        // add_submenu_page('restaurant-admin-menu', 'Change color', 'Change color', 'manage_options'
    }


    //RESTAURANTS ADMIN SETTINGS 
    function restaurants_admin_settings() {
        // register_setting( 'restaurants-settings-group', 'first_color' );
        // add_settings_section('restaurants-admin-form-options', 'Restaurants Form Options', 'restaurants_admin_form_options', 'restaurant-admin'); 
        // add_settings_field('form-name', 'First Color', 'restaurants_admin_form_name', 'restaurant-admin', 'restaurants-admin-form-options'); 
        register_setting( 'restaurants-settings-group', 'pink' );
        register_setting( 'restaurants-settings-group', 'purple' );
        register_setting( 'restaurants-settings-group', 'blue' );
        register_setting( 'restaurants-settings-group', 'red' );
    }


    //RESTAURANTS ADMIN CONTENT 
    function restaurants_admin_form() {
        ?>
        <div class='wrap'>
            <h1>Restaurant Admin Panel</h1>
            <p>Change button color: </p>
            <form name='changeColor' method='post' action='options.php'> 
                <?php 
                    settings_errors(); 
                    settings_fields('restaurants-settings-group');  
                    do_settings_sections('restaurants-settings-group');
            
                    $pink = esc_attr( get_option('pink') );
                    $purple = esc_attr( get_option('purple') );
                    $blue = esc_attr( get_option('blue') );
                    $red = esc_attr( get_option('red') );    
                ?>
                <select id='colors' name='colors'>
                    <option name='color' value='<?php $pink ?>'>#ff0059</option>
                    <option name='color' value='<?php $purple ?>'>#2e007b</option>
                    <option name='color' value='<?php $blue ?>'>#006bc6</option>
                    <option name='color' value='<?php $red ?>'>#dd0000</option>
                </select>

                <input type='submit' name='submit' class='button-primary' value='<?php esc_attr_e('Save Changes') ?>' />

                <!-- Please enter your color code: <input type="text" id="color" name="color" />
                <input type="submit" id="submitBtn" name="button1" /> -->

            </form>
        </div>
        <?php
    }

    // function create_section_for_color_picker($value) { 
	// 	create_opening_tag($value);
	// 	$color_value = "";
	// 	if (get_option($value['id']) === FALSE) {
	// 		$color_value = $value['std'];
	// 	}
	// 	else {
	// 		$color_value = get_option($value['id']);
	// 	}
	 
	// 	echo '<div class="color-picker">'."\n";
	// 	echo '<input type="text" id="'.$value['id'].'" name="'.$value['id'].'" value="'.$color_value.'" class="color" />';
	// 	echo ' « Click to select color<br/>'."\n";
	// 	echo "<strong>Default: <font color='".$value['std']."'> ".$value['std']."</font></strong>";
	// 	echo " (You can copy and paste this into the box above)\n";
	// 	echo "</div>\n";
	// 	create_closing_tag($value);
	//  }

    // CHECK IF THE FORM IS SUBMITET 
    function check_form() {
        if(isset($_POST['submit'])) {
            $selected_val = $_POST['colors']; 
            echo 'You have selected :' .$selected_val;
        }
    }

    // function restaurant_form_options() {
    //     echo "customize"; 
    // }

    // function restaurants_admin_form_name() {
    //     $firstColor = get_option('first_color');
    //     echo '<input type="text" name="first_color" value="'.$firstColor.'" />';
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
    add_action('init', 'check_form');

?>