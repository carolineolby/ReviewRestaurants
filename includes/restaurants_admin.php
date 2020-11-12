<?php 
    add_action('admin_menu', 'restaurants_plugin_admin');
 
    //CREATING RESTAURANTS ADMIN
    function restaurants_plugin_admin() {
        add_menu_page('Restaurants Plugin Options', 'Restaurants Admin Options', 'manage_options', 'restaurant-admin', 'restaurants_admin_create_page'); 
        add_action('admin_init', 'restaurants_admin_custom_settings');
    }

    //RESTAURANTS ADMIN SETTINGS 
    function restaurants_admin_custom_settings() {
        register_setting( 'restaurants-settings-group', 'review_btn_color');
        register_setting( 'restaurants-settings-group', 'remove_review_btn_color');
        add_settings_section('restaurants-admin-form-options', 'Change button color: ', 'restaurants_admin_form', 'restaurant-admin');
    }

    //RESTAURANTS ADMIN FORM 
    function restaurants_admin_form() { 
        $hidden_field_name = 'mt_submit_hidden';

        ?>
        <div class="restaurants_form">
            <form name='change_btn_color' method='post' action=''>
                <input type='hidden' name='<?php echo $hidden_field_name; ?>' value='Y'>
                    <label for="review_btn_color">Review Button:</label>
                    <select id='review_btn_color_select' name='review_btn_color'>
                        <option value="1" <?php if($_POST['review_btn_color'] == "1" ) echo 'selected' ; ?>>pink</option>
                        <option value="2" <?php if($_POST['review_btn_color'] == "2" ) echo 'selected' ; ?>>purple</option>
                        <option value="3" <?php if($_POST['review_btn_color'] == "3" ) echo 'selected' ; ?>>blue</option>
                    </select>

                    <label for="remove_review_btn_color">Remove Review Button:</label>
                    <select id='remove_review_btn_color' name='remove_review_btn_color'>
                        <option value="4" <?php if($_POST['remove_review_btn_color'] == "4" ) echo 'selected' ; ?>>green</option>
                        <option value="5" <?php if($_POST['remove_review_btn_color'] == "5" ) echo 'selected' ; ?>>orange</option>
                        <option value="6" <?php if($_POST['remove_review_btn_color'] == "6" ) echo 'selected' ; ?>>red</option>
                    </select>
                <input type='submit' name='submit' class='button-primary' value='<?php esc_attr_e('Save Changes') ?>' />
            </form>
        </div>
        <?php

        if(isset($_POST[ $hidden_field_name ]) && $_POST[ $hidden_field_name ] == 'Y') {
            if($_POST['review_btn_color'] == 1 ) {
                update_option('review_btn_color', 'pink'); 
            } else if($_POST['review_btn_color'] == 2 ) {
                update_option('review_btn_color', 'purple'); 
            } else if($_POST['review_btn_color'] == 3 ) {
                update_option('review_btn_color', 'blue'); 
            }

            if($_POST['remove_review_btn_color'] == 4 ) {
                update_option('remove_review_btn_color', 'green'); 
            } else if($_POST['remove_review_btn_color'] == 5 ) {
                update_option('remove_review_btn_color', 'orange'); 
            } else if($_POST['remove_review_btn_color'] == 6 ) {
                update_option('remove_review_btn_color', 'red'); 
            }
        }
    }


    //RESTAURANTS ADMIN CONTENT 
    function restaurants_admin_create_page() { ?>
        <div class='wrap'>
            <h1>Restaurants Plugin Admin</h1>
                <?php 
                    settings_errors('restaurant-admin'); 
                    settings_fields('restaurants-settings-group'); 
                    do_settings_sections('restaurant-admin');      
                ?>
        </div>
    <?php }
?>