<?php /* Template Name: Edit store settings  */ ?>

<?php get_header(); ?>


    <div class="app-container">
        <?php 
        $name_store_settings = $_GET["id2"];
        $name_storesettings = $wpdb->get_results("SELECT name_store FROM store WHERE id_store = ".$name_store_settings.""); //getting name_store rows from store table where id of store is what we got from previous page
        foreach ($name_storesettings as $storename) { //going through all the results with foreach
            echo '<h1 class="product-store-name"> Store settings for '.$storename->name_store.'</h1>'; //echo store name after selecting it from database
            echo '<br>';
        }
        echo '<form class="change_settings" method="post">';
        $settings_id = $_GET["id"]; //store ID that is transferred from store_settings.php store search using GET
        
        $storeinfo = $wpdb->get_results("SELECT * FROM store WHERE id_store = ".$name_store_settings."");
        foreach ($storeinfo as $storeinfos) {
            echo '<div class="change-settings-single-result"><h2> Store name: </h2><input name="name_store" type="text" value="'.$storeinfos->name_store.'"></div>';
           echo '<br>';
            
            
            echo '<div class="change-settings-single-result">';
           echo '<h2> Main chain: </h2>'; 
            echo '<select name="main_chain">';
           $main_id = $storeinfos->id_main_chain;
           $mcid2 = 1;
           $mcid = $wpdb->get_results("SELECT * FROM main_chain"); //
            foreach ($mcid as $id_mc) {
                if ($mcid2 == $main_id) {
                echo '<option name="id_mc" type="text" value="'.$id_mc->id_main_chain.'" selected>'.$id_mc->name_main_chain.'</option>';
                } else {
                    echo '<option name="id_mc" type="text" value="'.$id_mc->id_main_chain.'">'.$id_mc->name_main_chain.'</option>';
                }
                $mcid2++;
            }
           echo '</select>';
           echo '</div>';
            
             echo '<div class="change-settings-single-result">';
           echo '<h2> Store chain: </h2>'; 
            echo '<select name="store_chain">';
           $chain_id = $storeinfos->id_store_chain;
           $scid2 = 1;
           $scid = $wpdb->get_results("SELECT * FROM store_chain"); //
            foreach ($scid as $id_sc) {
                if ($scid2 == $chain_id) {
                echo '<option name="id_sc" type="text" value="'.$id_sc->id_store_chain.'" selected>'.$id_sc->name_store_chain.'</option>';
                } else {
                    echo '<option name="id_sc" type="text" value="'.$id_sc->id_store_chain.'">'.$id_sc->name_store_chain.'</option>';
                }
                $scid2++;
            }
           echo '</select>';
           echo '</div>';
            
            
            echo '<div class="change-settings-single-result"><h2> Contact person: </h2><input name="contactperson" type="text" value="'.$storeinfos->contactperson_store.'"></div>';
           echo '<br>';
            echo '<div class="change-settings-single-result"><h2> Phone number: </h2><input name="phone_store" type="text" value="'.$storeinfos->phone_contactperson_store.'"></div>';
           echo '<br>';
            echo '<div class="change-settings-single-result"><h2> Email: </h2><input name="email" type="text" value="'.$storeinfos->email_store.'"></div>';
           echo '<br>';
            echo '<div class="change-settings-single-result"><h2> Address: </h2><input name="address_store" type="text" value="'.$storeinfos->address_store.'"></div>';
           echo '<br>';
            echo '<div class="change-settings-single-result"><h2> Postal: </h2><input name="postal_store" type="text" value="'.$storeinfos->postal_store.'"></div>';
           echo '<br>';
            echo '<div class="change-settings-single-result"><h2> City: </h2><input name="city_store" type="text" value="'.$storeinfos->city_store.'"></div>';
           echo '<br>';
        }
        
        
        $storesettings = $wpdb->get_results("SELECT * FROM store_settings WHERE id_store_settings = ".$settings_id.""); //
       foreach ($storesettings as $outputsettings) {
           echo '<h3 class="extrainfo"> HoTi & ToTi shelf settings </h3>';
           echo '<input type="hidden" name="id_store_settings">';
           echo '<br>';
           //-----------------------------------------------------
           echo '<div class="horizontal_checkbox">';
           echo '<h1 class="selection_title">Number of segments</h1>';
            echo '<select class="hidescroll" name="paper_segments" size="8">';
            //echo '<option value="0" name="0">0</selection>';
            $paper_segment_select = 0;
            while ($paper_segment_select < 1001) {
                if ($paper_segment_select == $outputsettings->paper_segments) {
                echo '<option value="'.$paper_segment_select.'" name="horizontal_selection" autofocus selected>'.$paper_segment_select.'</selection>';
                } else {
                    echo '<option value="'.$paper_segment_select.'" name="horizontal_selection">'.$paper_segment_select.'</selection>';
                }
                $paper_segment_select++;
            }
            echo '</select>';
            echo '</div>';
           //-----------------------------------------------------
           echo '<br>';
           //-----------------------------------------------------
           echo '<div class="horizontal_checkbox">';
           echo '<h1 class="selection_title">Number of shelves</h1>';
            echo '<select class="hidescroll" name="paper_shelf_count" size="8">';
            //echo '<option value="0" name="0">0</selection>';
            $paper_shelf_select = 0;
            while ($paper_shelf_select < 12) {
                if ($paper_shelf_select == $outputsettings->paper_shelf_count) {
                echo '<option value="'.$paper_shelf_select.'" name="horizontal_selection" autofocus selected>'.$paper_shelf_select.'</selection>';
                } else {
                    echo '<option value="'.$paper_shelf_select.'" name="horizontal_selection">'.$paper_shelf_select.'</selection>';
                }
                $paper_shelf_select++;
            }
            echo '</select>';
            echo '</div>';
            echo '<br>';
           //-----------------------------------------------------
           //-----------------------------------------------------
           //-----------------------------------------------------
           echo '<div class="horizontal_checkbox">';
           echo '<h1 class="selection_title">Depth in mm</h1>';
            echo '<select class="hidescroll" name="paper_depth" size="8">';
            //echo '<option value="0" name="0">0</selection>';
            $paper_depth_select = 0;
            while ($paper_depth_select < 1001) {
                if ($paper_depth_select == $outputsettings->paper_depth) {
                echo '<option value="'.$paper_depth_select.'" name="horizontal_selection" autofocus selected>'.$paper_depth_select.'</selection>';
                } else {
                    echo '<option value="'.$paper_depth_select.'" name="horizontal_selection">'.$paper_depth_select.'</selection>';
                }
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
                if ($paper_width_select == $outputsettings->paper_width) {
                echo '<option value="'.$paper_width_select.'" name="horizontal_selection" autofocus selected>'.$paper_width_select.'</selection>';
                } else {
                    echo '<option value="'.$paper_width_select.'" name="horizontal_selection">'.$paper_width_select.'</selection>';
                }
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
                if ($paper_shelf1_select == $outputsettings->paper_height1) {
                echo '<option value="'.$paper_shelf1_select.'" name="horizontal_selection" autofocus selected>'.$paper_shelf1_select.'</selection>';
                } else {
                    echo '<option value="'.$paper_shelf1_select.'" name="horizontal_selection">'.$paper_shelf1_select.'</selection>';
                }
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
                if ($paper_shelf_select == $outputsettings->paper_height2) {
                echo '<option value="'.$paper_shelf_select.'" name="horizontal_selection" autofocus selected>'.$paper_shelf_select.'</selection>';
                } else {
                    echo '<option value="'.$paper_shelf_select.'" name="horizontal_selection">'.$paper_shelf_select.'</selection>';
                }
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
                if ($paper_shelf_select == $outputsettings->paper_height3) {
                echo '<option value="'.$paper_shelf_select.'" name="horizontal_selection" autofocus selected>'.$paper_shelf_select.'</selection>';
                } else {
                    echo '<option value="'.$paper_shelf_select.'" name="horizontal_selection">'.$paper_shelf_select.'</selection>';
                }
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
                if ($paper_shelf_select == $outputsettings->paper_height4) {
                echo '<option value="'.$paper_shelf_select.'" name="horizontal_selection" autofocus selected>'.$paper_shelf_select.'</selection>';
                } else {
                    echo '<option value="'.$paper_shelf_select.'" name="horizontal_selection">'.$paper_shelf_select.'</selection>';
                }
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
                if ($paper_shelf_select == $outputsettings->paper_height5) {
                echo '<option value="'.$paper_shelf_select.'" name="horizontal_selection" autofocus selected>'.$paper_shelf_select.'</selection>';
                } else {
                    echo '<option value="'.$paper_shelf_select.'" name="horizontal_selection">'.$paper_shelf_select.'</selection>';
                }
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

       }
        echo '<br>';
        echo '<input class="accept-changes" type="submit" onclick="pagereloading();" name="update_settings_submit" value="Accept">';
        echo '</form>';

        if(isset($_POST['update_settings_submit'])) {
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
            
       //updating the store info with the user inputs     
       $wpdb->update( 
	           'store', 
	           array( 
                    'id_main_chain' => $id_main_chain,
                    'id_store_chain' => $id_store_chain,
                    'name_store' => $name_store,
                    'contactperson_store' => $contactperson_store,
                    'phone_contactperson_store' => $phone_contactperson_store,
                    'email_store' => $email_store,
                    'address_store' => $address_store,
                    'postal_store' => $postal_store,
                    'city_store' => $city_store                 
	           ), 
	           array( 'id_store' => $name_store_settings ),
	           array( 
                    '%d',
                    '%d',
		          '%s',
                   '%s',
                   '%s',
                   '%s',
                   '%s',
                    '%s',
                    '%s'
	           ), 
	           array( '%s' ) );
        //updating the store settings with the user inputs      
        $wpdb->update( 
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
	           array( 'id_store_settings' => $settings_id ),
	           array( 
		          '%s',	// value1
		          '%d'	// value2
	           ), 
	           array( '%d' ) );
         //in the script below we reload the page so the user will see the refreshed results from database 
        ?>
        <script>
                window.onload = function() {
                if(!window.location.hash) {
                    window.location = window.location + '#loaded';
                    window.location.reload();
                }
            }
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
