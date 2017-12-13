<?php /* Template Name: Add new store  */ ?>

<?php get_header(); ?>


    <div class="app-container">
        <?php 
            echo '<h1 class="product-store-name"> Add new store </h1>'; //Name for the page to make it easier to see where you are
            echo '<br>';
        
        echo '<form class="change_settings" method="post">';
            echo '<div class="change-settings-single-result"><h2> Store name: </h2><input name="name_store" type="text" value=""></div>'; //user input for store name
           echo '<br>'; 
            
            
            echo '<div class="change-settings-single-result">';
           echo '<h2> Main chain: </h2>'; 
            echo '<select name="main_chain">';
           $mcid = $wpdb->get_results("SELECT * FROM main_chain"); //selecting all main chains and then makes a dropdown menu for the user to select, the value of the dropdown is the main chain ID as we need to insert this to the database
            foreach ($mcid as $id_mc) {
                    echo '<option name="id_mc" type="text" value="'.$id_mc->id_main_chain.'">'.$id_mc->name_main_chain.'</option>';
                }
           echo '</select>';
           echo '</div>';
            
             echo '<div class="change-settings-single-result">';
           echo '<h2> Store chain: </h2>'; 
            echo '<select name="store_chain">';
           $scid = $wpdb->get_results("SELECT * FROM store_chain"); //selecting all store chains and then makes a dropdown menu for the user to select, the value of the dropdown is the store chain ID as we need to insert this to the database
            foreach ($scid as $id_sc) {
                    echo '<option name="id_sc" type="text" value="'.$id_sc->id_store_chain.'">'.$id_sc->name_store_chain.'</option>';
                }
           echo '</select>';
           echo '</div>';
            
            //user inputs for contact person, emails, phone numbers, address, postal code, city.
            echo '<div class="change-settings-single-result"><h2> Contact person: </h2><input name="contactperson" type="text" value=""></div>';
           echo '<br>';
        echo '<div class="change-settings-single-result"><h2> Email: </h2><input name="email" type="text" value=""></div>';
           echo '<br>';
            echo '<div class="change-settings-single-result"><h2> Phone number: </h2><input name="phone_store" type="text" value=""></div>';
           echo '<br>';
            echo '<div class="change-settings-single-result"><h2> Address: </h2><input name="address_store" type="text" value=""></div>';
           echo '<br>';
            echo '<div class="change-settings-single-result"><h2> Postal: </h2><input name="postal_store" type="text" value=""></div>';
           echo '<br>';
            echo '<div class="change-settings-single-result"><h2> City: </h2><input name="city_store" type="text" value=""></div>';
           echo '<br>';
        
        
            //shelf settings for the store
           echo '<h3 class="extrainfo"> HoTi & ToTi shelf settings </h3>';
           echo '<input type="hidden" name="id_store_settings">';
           // echo '<div class="change-settings-single-result"><h2> Paper segments: </h2><input name="paper_segments" type="text" value="'.$outputsettings->paper_segments.'"></div>';
           echo '<br>';
           //-----------------------------------------------------
           echo '<div class="horizontal_checkbox">';
           echo '<h1 class="selection_title">Number of segments</h1>';
            echo '<select class="hidescroll" name="paper_segments" size="8">';
            //echo '<option value="0" name="0">0</selection>';
            $paper_segment_select = 0;
            while ($paper_segment_select < 1001) {
                    echo '<option value="'.$paper_segment_select.'" name="horizontal_selection">'.$paper_segment_select.'</selection>';
                $paper_segment_select++;
                }
            echo '</select>';
            echo '</div>';
           //-----------------------------------------------------
           //echo '<div class="change-settings-single-result"><h2> Paper shelf count: </h2><input name="paper_shelf_count" type="text" value="'.$outputsettings->paper_shelf_count.'"></div>';
           echo '<br>';
           //-----------------------------------------------------
           echo '<div class="horizontal_checkbox">';
           echo '<h1 class="selection_title">Number of shelves</h1>';
            echo '<select class="hidescroll" name="paper_shelf_count" size="8">';
            //echo '<option value="0" name="0">0</selection>';
            $paper_shelf_select = 0;
            while ($paper_shelf_select < 12) {
                    echo '<option value="'.$paper_shelf_select.'" name="horizontal_selection">'.$paper_shelf_select.'</selection>';
                    $paper_shelf_select++;
                }
            
            echo '</select>';
            echo '</div>';
            echo '<br>';
           //-----------------------------------------------------
           //-----------------------------------------------------
           //echo '<div class="change-settings-single-result"><h2> Paper height 1: </h2><input name="paper_height1" type="text" value="'.$outputsettings->paper_height1.'"></div>';
           //-----------------------------------------------------
           echo '<div class="horizontal_checkbox">';
           echo '<h1 class="selection_title">Depth in mm</h1>';
            echo '<select class="hidescroll" name="paper_depth" size="8">';
            //echo '<option value="0" name="0">0</selection>';
            $paper_depth_select = 0;
            while ($paper_depth_select < 1001) {
                    echo '<option value="'.$paper_depth_select.'" name="horizontal_selection">'.$paper_depth_select.'</selection>';
                    $paper_depth_select++;
                }
            
            
            echo '</select>';
            echo '</div>';
           //-----------------------------------------------------
           echo '<br>';
           //-----------------------------------------------------
           //echo '<div class="change-settings-single-result"><h2> Paper height 1: </h2><input name="paper_height1" type="text" value="'.$outputsettings->paper_height1.'"></div>';
           //-----------------------------------------------------
           echo '<div class="horizontal_checkbox">';
           echo '<h1 class="selection_title">Width in mm</h1>';
            echo '<select class="hidescroll" name="paper_width" size="8">';
            //echo '<option value="0" name="0">0</selection>';
            $paper_width_select = 0;
            while ($paper_width_select < 1001) {
                    echo '<option value="'.$paper_width_select.'" name="horizontal_selection">'.$paper_width_select.'</selection>';
                    $paper_width_select++;
                }
            
            echo '</select>';
            echo '</div>';
           //-----------------------------------------------------
           echo '<br>';
           //echo '<div class="change-settings-single-result"><h2> Paper height 1: </h2><input name="paper_height1" type="text" value="'.$outputsettings->paper_height1.'"></div>';
           //-----------------------------------------------------
           echo '<div class="horizontal_checkbox">';
           echo '<h1 class="selection_title">Height of shelf 1 in mm</h1>';
            echo '<select class="hidescroll" name="paper_height1" size="8">';
            //echo '<option value="0" name="0">0</selection>';
            $paper_shelf1_select = 0;
            while ($paper_shelf1_select < 1001) {
                    echo '<option value="'.$paper_shelf1_select.'" name="horizontal_selection">'.$paper_shelf1_select.'</selection>';
                    $paper_shelf1_select++;
                }
            
            echo '</select>';
            echo '</div>';
           //-----------------------------------------------------
           
           //-----------------------------------------------------
           echo '<div class="horizontal_checkbox">';
           echo '<h1 class="selection_title">Height of shelf 2 in mm</h1>';
            echo '<select class="hidescroll" name="paper_height2" size="8">';
            //echo '<option value="0" name="0">0</selection>';
            $paper_shelf_select = 0;
            while ($paper_shelf_select < 1001) {

                    echo '<option value="'.$paper_shelf_select.'" name="horizontal_selection">'.$paper_shelf_select.'</selection>';
                    $paper_shelf_select++;
                }
            
            echo '</select>';
            echo '</div>';
           //-----------------------------------------------------
           
           //-----------------------------------------------------
           echo '<div class="horizontal_checkbox">';
           echo '<h1 class="selection_title">Height of shelf 3 in mm</h1>';
            echo '<select class="hidescroll" name="paper_height3" size="8">';
            //echo '<option value="0" name="0">0</selection>';
            $paper_shelf_select = 0;
            while ($paper_shelf_select < 1001) {
                    
                    echo '<option value="'.$paper_shelf_select.'" name="horizontal_selection">'.$paper_shelf_select.'</selection>';
                    $paper_shelf_select++;
                }
            
            echo '</select>';
            echo '</div>';
           //-----------------------------------------------------
           
           //-----------------------------------------------------
           echo '<div class="horizontal_checkbox">';
           echo '<h1 class="selection_title">Height of shelf 4 in mm</h1>';
            echo '<select class="hidescroll" name="paper_height4" size="8">';
            //echo '<option value="0" name="0">0</selection>';
            $paper_shelf_select = 0;
            while ($paper_shelf_select < 1001) {
                    echo '<option value="'.$paper_shelf_select.'" name="horizontal_selection">'.$paper_shelf_select.'</selection>';
                    $paper_shelf_select++;
                }
                
            
            echo '</select>';
            echo '</div>';
           //-----------------------------------------------------
           
           //-----------------------------------------------------
           echo '<div class="horizontal_checkbox">';
           echo '<h1 class="selection_title">Height of shelf 5 in mm</h1>';
            echo '<select class="hidescroll" name="paper_height5" size="8">';
            //echo '<option value="0" name="0">0</selection>';
            $paper_shelf_select = 0;
            while ($paper_shelf_select < 1001) {
                    echo '<option value="'.$paper_shelf_select.'" name="horizontal_selection">'.$paper_shelf_select.'</selection>';
                    $paper_shelf_select++;
                }
                
            
            echo '</select>';
            echo '</div>';
           //-----------------------------------------------------

           echo '<br>';
           echo '<h3 class="extrainfo"> Hankies shelf settings </h3>';
           echo '<br>';
           //-----------------------------------------------------
           echo '<div class="horizontal_checkbox">';
           echo '<h1 class="selection_title">Segments</h1>';
            echo '<select class="hidescroll" name="hankies_segment" size="8">';
            //echo '<option value="0" name="0">0</selection>';
            $hank_segments_select = 0;
            while ($hank_segments_select < 1001) {
                if ($hank_segments_select == $outputsettings->hank_segment) {
                echo '<option value="'.$hank_segments_select.'" name="horizontal_selection" autofocus selected>'.$hank_segments_select.'</selection>';
                } else {
                    echo '<option value="'.$hank_segments_select.'" name="horizontal_selection">'.$hank_segments_select.'</selection>';
                }
                $hank_segments_select++;
            }
            echo '</select>';
            echo '</div>';
            echo '<br>';
           //-----------------------------------------------------
           echo '<br>';
           //-----------------------------------------------------
           echo '<div class="horizontal_checkbox">';
           echo '<h1 class="selection_title">Number of shelves</h1>';
            echo '<select class="hidescroll" name="hankies_shelf_count" size="8">';
            //echo '<option value="0" name="0">0</selection>';
            $hankies_shelf_select = 0;
            while ($hankies_shelf_select < 12) {
                if ($hankies_shelf_select == $outputsettings->hank_shelf_count) {
                echo '<option value="'.$hankies_shelf_select.'" name="horizontal_selection" autofocus selected>'.$hankies_shelf_select.'</selection>';
                } else {
                    echo '<option value="'.$hankies_shelf_select.'" name="horizontal_selection">'.$hankies_shelf_select.'</selection>';
                }
                $hankies_shelf_select++;
            }
            echo '</select>';
            echo '</div>';
            echo '<br>';
           //-----------------------------------------------------
           echo '<br>';
           //-----------------------------------------------------
           echo '<div class="horizontal_checkbox">';
           echo '<h1 class="selection_title">Depth in mm</h1>';
            echo '<select class="hidescroll" name="hankies_depth" size="8">';
            //echo '<option value="0" name="0">0</selection>';
            $hank_depth_select = 0;
            while ($hank_depth_select < 1001) {
                if ($hank_depth_select == $outputsettings->hank_depth) {
                echo '<option value="'.$hank_depth_select.'" name="horizontal_selection" autofocus selected>'.$hank_depth_select.'</selection>';
                } else {
                    echo '<option value="'.$hank_depth_select.'" name="horizontal_selection">'.$hank_depth_select.'</selection>';
                }
                $hank_depth_select++;
            }
            echo '</select>';
            echo '</div>';
            echo '<br>';
           //-----------------------------------------------------
           echo '<br>';
           //-----------------------------------------------------
           echo '<div class="horizontal_checkbox">';
           echo '<h1 class="selection_title">Width in mm</h1>';
            echo '<select class="hidescroll" name="hankies_width" size="8">';
            //echo '<option value="0" name="0">0</selection>';
            $hank_width_select = 0;
            while ($hank_width_select < 1001) {
                if ($hank_width_select == $outputsettings->hank_width) {
                echo '<option value="'.$hank_width_select.'" name="horizontal_selection" autofocus selected>'.$hank_width_select.'</selection>';
                } else {
                    echo '<option value="'.$hank_width_select.'" name="horizontal_selection">'.$hank_width_select.'</selection>';
                }
                $hank_width_select++;
            }
            echo '</select>';
            echo '</div>';
            echo '<br>';
           //-----------------------------------------------------
           echo '<br>';
           //-----------------------------------------------------
           echo '<div class="horizontal_checkbox">';
           echo '<h1 class="selection_title">Height of shelf 1 in mm</h1>';
            echo '<select class="hidescroll" name="hankies_height1" size="8">';
            //echo '<option value="0" name="0">0</selection>';
            $hank_height1_select = 0;
            while ($hank_height1_select < 1001) {
                if ($hank_height1_select == $outputsettings->hank_height1) {
                echo '<option value="'.$hank_height1_select.'" name="horizontal_selection" autofocus selected>'.$hank_height1_select.'</selection>';
                } else {
                    echo '<option value="'.$hank_height1_select.'" name="horizontal_selection">'.$hank_height1_select.'</selection>';
                }
                $hank_height1_select++;
            }
            echo '</select>';
            echo '</div>';
           //-----------------------------------------------------
           echo '<div class="horizontal_checkbox">';
           echo '<h1 class="selection_title">Height of shelf 2 in mm</h1>';
            echo '<select class="hidescroll" name="hankies_height2" size="8">';
            //echo '<option value="0" name="0">0</selection>';
            $hank_height2_select = 0;
            while ($hank_height2_select < 1001) {
                if ($hank_height2_select == $outputsettings->hank_height2) {
                echo '<option value="'.$hank_height2_select.'" name="horizontal_selection" autofocus selected>'.$hank_height2_select.'</selection>';
                } else {
                    echo '<option value="'.$hank_height2_select.'" name="horizontal_selection">'.$hank_height2_select.'</selection>';
                }
                $hank_height2_select++;
            }
            echo '</select>';
            echo '</div>';
           //-----------------------------------------------------
           echo '<div class="horizontal_checkbox">';
           echo '<h1 class="selection_title">Height of shelf 3 in mm</h1>';
            echo '<select class="hidescroll" name="hankies_height3" size="8">';
            //echo '<option value="0" name="0">0</selection>';
            $hank_height3_select = 0;
            while ($hank_height3_select < 1001) {
                if ($hank_height3_select == $outputsettings->hank_height3) {
                echo '<option value="'.$hank_height3_select.'" name="horizontal_selection" autofocus selected>'.$hank_height3_select.'</selection>';
                } else {
                    echo '<option value="'.$hank_height3_select.'" name="horizontal_selection">'.$hank_height3_select.'</selection>';
                }
                $hank_height3_select++;
            }
            echo '</select>';
            echo '</div>';
           //-----------------------------------------------------
           echo '<div class="horizontal_checkbox">';
           echo '<h1 class="selection_title">Height of shelf 4 in mm</h1>';
            echo '<select class="hidescroll" name="hankies_height4" size="8">';
            //echo '<option value="0" name="0">0</selection>';
            $hank_height4_select = 0;
            while ($hank_height4_select < 1001) {
                if ($hank_height4_select == $outputsettings->hank_height4) {
                echo '<option value="'.$hank_height4_select.'" name="horizontal_selection" autofocus selected>'.$hank_height4_select.'</selection>';
                } else {
                    echo '<option value="'.$hank_height4_select.'" name="horizontal_selection">'.$hank_height4_select.'</selection>';
                }
                $hank_height4_select++;
            }
            echo '</select>';
            echo '</div>';
           //-----------------------------------------------------
           echo '<div class="horizontal_checkbox">';
           echo '<h1 class="selection_title">Height of shelf 5 in mm</h1>';
            echo '<select class="hidescroll" name="hankies_height5" size="8">';
            //echo '<option value="0" name="0">0</selection>';
            $hank_height5_select = 0;
            while ($hank_height5_select < 1001) {
                if ($hank_height5_select == $outputsettings->hank_height5) {
                echo '<option value="'.$hank_height5_select.'" name="horizontal_selection" autofocus selected>'.$hank_height5_select.'</selection>';
                } else {
                    echo '<option value="'.$hank_height5_select.'" name="horizontal_selection">'.$hank_height5_select.'</selection>';
                }
                $hank_height5_select++;
            }
            echo '</select>';
            echo '</div>';
            echo '<br>';
           //-----------------------------------------------------

       
        echo '<br>';
        echo '<input class="accept-changes" type="submit" onclick="pagereloading();" name="update_settings_submit" value="Accept"><a href="http://127.0.0.1/wordpress/store-settings/"></a></input>'; //goes back to the store settings page menu so the user can search the newly made store. This could be improved by making the user go to the store they just made
        echo '</form>';

        if(isset($_POST['update_settings_submit'])) { //if user clicks button named "Accept" then run this
            
            //here we get all the variables from user inputs 
            
            $id_store_settings = $_POST['id_store_settings'];
            $paper_segments = $_POST['paper_segments'];
            $paper_shelf_count = $_POST['paper_shelf_count'];
            if ($paper_shelf_count > 5) { //as we only have 5 shelves currently, the code limits it to 5
                $paper_shelf_count = 5;
            }
            $paper_height1 = $_POST['paper_height1'];
            $paper_height2 = $_POST['paper_height2'];
            $paper_height3 = $_POST['paper_height3'];
            $paper_height4 = $_POST['paper_height4'];
            $paper_height5 = $_POST['paper_height5'];
            $paper_width = $_POST['paper_width'];
            $paper_depth = $_POST['paper_depth'];
            $hankies_segment = $_POST['hankies_segment'];
            $hankies_shelf_count = $_POST['hankies_shelf_count'];
            if ($hankies_shelf_count > 5) { //as we only have 5 shelves currently, the code limits it to 5
                $hankies_shelf_count = 5;
            }
            $hankies_height1 = $_POST['hankies_height1'];
            $hankies_height2 = $_POST['hankies_height2'];
            $hankies_height3 = $_POST['hankies_height3'];
            $hankies_height4 = $_POST['hankies_height4'];
            $hankies_height5 = $_POST['hankies_height5'];
            $hankies_width = $_POST['hankies_width'];
            $hankies_depth = $_POST['hankies_depth'];         
            $contactperson_store = $_POST['contactperson'];
            $phone_contactperson_store = $_POST['phone_store']; 
            $address_store = $_POST['address_store'];
            $postal_store = $_POST['postal_store'];
            $city_store = $_POST['city_store'];
            $name_store = $_POST['name_store'];
            $email_store = $_POST['email'];
            
            $id_main_chain = $_POST['main_chain'];
            $id_store_chain = $_POST['store_chain'];
            
            //First we insert the store settings as store settings are not tied in anyway to stores but store DB needs a store_settings id
            $wpdb->insert( 
	           'store_settings', 
	           array( 
                    'paper_segments' => $paper_segments,
                    'paper_shelf_count' => $paper_shelf_count,
                    'paper_height1' => $paper_height1,
                    'paper_height2' => $paper_height2,
                    'paper_height3' => $paper_height3,
                    'paper_height4' => $paper_height4,
                    'paper_height5' => $paper_height5,
                    'paper_width' => $paper_width,
                    'paper_depth' => $paper_depth,
                    'hank_segment' => $hankies_segment,
                    'hank_shelf_count' => $hankies_shelf_count,
                    'hank_height1' => $hankies_height1,
                    'hank_height2' => $hankies_height2,
                    'hank_height3' => $hankies_height3,
                    'hank_height4' => $hankies_height4,
                    'hank_height5' => $hankies_height5,
                    'hank_width' => $hankies_width,
                    'hank_depth' => $hankies_depth
	           ),
	           array( 
		          '%s',	// value1
		          '%d'	// value2
	           ));
            $id_store_settings = $wpdb->insert_id; //we get the ID of the newly made store settings
                
            //Now that we have the store settings we just made and the ID we can use the ID with the other information from user inputs to create a new store
             $wpdb->insert( 
	           'store', 
	           array( 
                    'id_main_chain' => $id_main_chain,
                    'id_store_chain' => $id_store_chain,
                    'id_store_settings' => $id_store_settings,
                    'name_store' => $name_store,
                    'contactperson_store' => $contactperson_store,
                    'phone_contactperson_store' => $phone_contactperson_store,
                    'email_store' => $email_store,
                    'address_store' => $address_store,
                    'postal_store' => $postal_store,
                    'city_store' => $city_store                 
	           ), 
	           array( 
                    '%d',
                    '%d',
                    '%d',
		          '%s',
                   '%s',
                   '%s',
                   '%s',
                   '%s',
                    '%s',
                    '%s'
	           ));   
            
            
            //in the script below we forward the user to the store search page
                ?>
        <script type="text/javascript">
            window.location = "http://127.0.0.1/wordpress/store-settings/";
        </script>      
        <?php
    

        }
        
        ?>
        <div class="previous-page">
            <a href="www.mypage.com" onclick="window.history.go(-1); return false;"><img class="back-arrow" src="<?php echo get_template_directory_uri(); ?>/img/back-arrow.png"></a>
            
        </div>
    </div>
	<main role="main">
		
	</main>


<?php get_footer(); ?>
