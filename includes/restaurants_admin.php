<?php 
    // include( plugin_dir_path( __FILE__ ) . '/css/style.css'); 
    function restaurant_admin_menu() {
        //Title of the page
        //Menu title, premission
        //Menu_slug
        //Our callback function
        add_menu_page(
            'Title of the page', 
            'Restaurants Admin', 
            'manage_options', 
            'restaurant-admin-menu', 
            'restaurant_admin_menu_main'
        ); 
        // add_submenu_page('restaurant-admin-menu', 'Change color', 'Change color', 'manage_options', 'restaurant-admin-submenu','restaurant_admin_menu_sub'); 
    }

    //MAIN MENU
    function restaurant_admin_menu_main() {
        // include ('ctp_restaurants.php');
        ?>
        "<div class='wrap'>
            <h1>Restaurant Admin Panel</h1>
            <p>Change button color: </p>
            <form name="changeColor" method='post' action=''>
            <input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">
                <!-- <select id="colors" name="colors">
                    <option name="color" value="pink">#ff0059</option>
                    <option name="color" value="purple">#2e007b</option>
                    <option name="color" value="blue">#006bc6</option>
                    <option name="color" value="red">#dd0000</option>
                </select> -->
                <p>
                    <input type='checkbox' id='pink' name='color'>
                    <label for='color'>Pink</label>
                </p>
                <p>
                    <input type='checkbox' id='blue' name='color'>
                    <label for='color'>Blue</label>
                </p>
                <p>
                    <input type='checkbox' id='purple' name='color'>
                    <label for='color'>Purple</label>
                </p>
                <p>
                    <input type='checkbox' id='green' name='color'>
                    <label for='color'>Green</label>
                </p>
                <p class='submit'>
                    <input type='submit' name='Submit' class='button-primary' value='<?php esc_attr_e('Save Changes') ?>' />
                </p>
            </form>
        </div>
    <?php }


    //SUB MENU
    // function restaurant_admin_menu_sub() {
    //     include ('ctp_restaurants.php');
    //     echo
    //     "<div class='wrap'>
    //         <h1>Submenu option page</h1>
    //     </div>";
    // }

    add_action('admin_menu', 'restaurant_admin_menu');






    // Hook for adding admin menus
    // add_action('admin_menu', 'mt_add_pages');

    // // action function for above hook
    // function mt_add_pages() {
    //     // Add a new submenu under Settings:
    //     add_options_page(__('Test Settings','menu-test'), __('Test Settings','menu-test'), 'manage_options', 'testsettings', 'mt_settings_page');

    //     // Add a new submenu under Tools:
    //     add_management_page( __('Test Tools','menu-test'), __('Test Tools','menu-test'), 'manage_options', 'testtools', 'mt_tools_page');

    //     // Add a new top-level menu (ill-advised):
    //     add_menu_page(__('Restaurant Admin','menu-test'), __('Restaurant Admin','menu-test'), 'manage_options', 'mt-top-level-handle', 'mt_toplevel_page' );

    //     // Add a submenu to the custom top-level menu:
    //     add_submenu_page('mt-top-level-handle', __('Test Sublevel','menu-test'), __('Test Sublevel','menu-test'), 'manage_options', 'sub-page', 'mt_sublevel_page');

    //     // Add a second submenu to the custom top-level menu:
    //     add_submenu_page('mt-top-level-handle', __('Test Sublevel 2','menu-test'), __('Test Sublevel 2','menu-test'), 'manage_options', 'sub-page2', 'mt_sublevel_page2');
    // }

    // // mt_settings_page() displays the page content for the Test Settings submenu
    // function mt_settings_page() {
    //     echo "<h2>" . __( 'Test Settings', 'menu-test' ) . "</h2>";
    // }

    // // mt_tools_page() displays the page content for the Test Tools submenu
    // function mt_tools_page() {
    //     echo "<h2>" . __( 'Test Tools', 'menu-test' ) . "</h2>";
    // }

    // // mt_toplevel_page() displays the page content for the custom Test Toplevel menu
    // function mt_toplevel_page() {
    //     echo "<h2>" . __( 'Restaurant Admin', 'menu-test' ) . "</h2>";
    //     echo "<p> Change button color: </p>";
    //     echo 
    //     "<form>
    //         <input type=select placeholder='add review' name=review>
    //         <button> submit </button>
    //         <input type=hidden name=issubmit value=$id></input>
    //     </form>"; 
    // }

    // // mt_sublevel_page() displays the page content for the first submenu
    // // of the custom Test Toplevel menu
    // function mt_sublevel_page() {
    //     echo "<h2>" . __( 'Test Sublevel', 'menu-test' ) . "</h2>";
    // }

    // // mt_sublevel_page2() displays the page content for the second submenu
    // // of the custom Test Toplevel menu
    // function mt_sublevel_page2() {
    //     echo "<h2>" . __( 'Test Sublevel2', 'menu-test' ) . "</h2>";
    // }

?>