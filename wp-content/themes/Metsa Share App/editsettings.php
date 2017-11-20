<?php /* Template Name: Edit store settings  */ ?>

<?php get_header(); ?>

<script>
setTimeout(pagereloading(){
    parent.window.location.reload(true);
},4000); 
</script>

    <div class="app-container">
        <?php 
        $name_store_settings = $_GET["id2"];
        $name_storesettings = $wpdb->get_results("SELECT name_store FROM store WHERE id_store = ".$name_store_settings."");
        foreach ($name_storesettings as $storename) { 
            echo '<h1 class="product-store-name"> Store settings for '.$storename->name_store.'</h1>';
            echo '<br>';
        }
        echo '<form class="change_settings" method="post">';
        $settings_id = $_GET["id"]; //store ID that is transferred from store_settings.php store search using GET
        
        $storeinfo = $wpdb->get_results("SELECT * FROM store WHERE id_store = ".$name_store_settings."");
        foreach ($storeinfo as $storeinfos) {
            echo '<div class="change-settings-single-result"><h2> Change store name: </h2><input name="name_store" type="text" value="'.$storeinfos->name_store.'"></div>';
           echo '<br>';
            echo '<div class="change-settings-single-result"><h2> Contact person: </h2><input name="contactperson" type="text" value="'.$storeinfos->contactperson_store.'"></div>';
           echo '<br>';
            echo '<div class="change-settings-single-result"><h2> Phone number: </h2><input name="phone_store" type="text" value="'.$storeinfos->phone_contactperson_store.'"></div>';
           echo '<br>';
            echo '<div class="change-settings-single-result"><h2> Address: </h2><input name="address_store" type="text" value="'.$storeinfos->address_store.'"></div>';
           echo '<br>';
            echo '<div class="change-settings-single-result"><h2> Postal store: </h2><input name="postal_store" type="text" value="'.$storeinfos->postal_store.'"></div>';
           echo '<br>';
            echo '<div class="change-settings-single-result"><h2> City: </h2><input name="city_store" type="text" value="'.$storeinfos->city_store.'"></div>';
           echo '<br>';
        }
        
        
        $storesettings = $wpdb->get_results("SELECT * FROM store_settings WHERE id_store_settings = ".$settings_id.""); //
       foreach ($storesettings as $outputsettings) {
           echo '<h3 class="extrainfo"> HoTi & ToTi shelf settings </h3>';
           echo '<div class="change-settings-single-result"><h2> Paper segments: </h2><input name="paper_segments" type="text" value="'.$outputsettings->paper_segments.'"></div>';
           echo '<br>';
           echo '<div class="change-settings-single-result"><h2> Paper shelf count: </h2><input name="paper_shelf_count" type="text" value="'.$outputsettings->paper_shelf_count.'"></div>';
           echo '<br>';
           echo '<div class="change-settings-single-result"><h2> Paper height 1: </h2><input name="paper_height1" type="text" value="'.$outputsettings->paper_height1.'"></div>';
           echo '<br>';
           echo '<div class="change-settings-single-result"><h2> Paper height 2: </h2><input name="paper_height2" type="text" value="'.$outputsettings->paper_height2.'"></div>';
           echo '<br>';
           echo '<div class="change-settings-single-result"><h2> Paper height 3: </h2><input name="paper_height3" type="text" value="'.$outputsettings->paper_height3.'"></div>';
           echo '<br>';
           echo '<div class="change-settings-single-result"><h2> Paper height 4: </h2><input name="paper_height4" type="text" value="'.$outputsettings->paper_height4.'"></div>';
           echo '<br>';
           echo '<div class="change-settings-single-result"><h2> Paper height 5: </h2><input name="paper_height5" type="text" value="'.$outputsettings->paper_height5.'"></div>';
           echo '<br>';
           echo '<div class="change-settings-single-result"><h2> Paper width: </h2><input name="paper_width" type="text" value="'.$outputsettings->paper_width.'"></div>';
           echo '<br>';
           echo '<div class="change-settings-single-result"><h2> Paper depth: </h2><input name="paper_depth" type="text" value="'.$outputsettings->paper_depth.'"></div>';
           echo '<br>';
           echo '<h3 class="extrainfo"> Hankies shelf settings </h3>';
           echo '<div class="change-settings-single-result"><h2> Hankies segments: </h2><input name="hankies_segment" type="text" value="'.$outputsettings->hank_segment.'"></div>';
           echo '<br>';
           echo '<div class="change-settings-single-result"><h2> Hankies shelf count: </h2><input name="hankies_shelf_count" type="text" value="'.$outputsettings->hank_shelf_count.'"></div>';
           echo '<br>';
           echo '<div class="change-settings-single-result"><h2> Hankies height 1: </h2><input name="hankies_height1" type="text" value="'.$outputsettings->hank_height1.'"></div>';
           echo '<br>';
           echo '<div class="change-settings-single-result"><h2> Hankies height 2: </h2><input name="hankies_height2" type="text" value="'.$outputsettings->hank_height2.'"></div>';
           echo '<br>';
           echo '<div class="change-settings-single-result"><h2> Hankies height 3: </h2><input name="hankies_height3" type="text" value="'.$outputsettings->hank_height3.'"></div>';
           echo '<br>';
           echo '<div class="change-settings-single-result"><h2> Hankies height 4: </h2><input name="hankies_height4" type="text" value="'.$outputsettings->hank_height4.'"></div>';
           echo '<br>';
           echo '<div class="change-settings-single-result"><h2> Hankies height 5: </h2><input name="hankies_height5" type="text" value="'.$outputsettings->hank_height5.'"></div>';
           echo '<br>';
           echo '<div class="change-settings-single-result"><h2> Hankies width: </h2><input name="hankies_width" type="text" value="'.$outputsettings->hank_width.'"></div>';
           echo '<br>';
           echo '<div class="change-settings-single-result"><h2> Hankies depth: </h2><input name="hankies_depth" type="text" value="'.$outputsettings->hank_depth.'"></div>';
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
            
       $wpdb->update( 
	           'store', 
	           array( 
                    'name_store' => $name_store,
                    'contactperson_store' => $contactperson_store,
                    'phone_contactperson_store' => $phone_contactperson_store,
                    'address_store' => $address_store,
                    'postal_store' => $postal_store,
                    'city_store' => $city_store                 
	           ), 
	           array( 'id_store' => $name_store_settings ),
	           array( 
		          '%s',// value1
                    '%s'
	           ), 
	           array( '%s' ) );
                
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
        }
        ?>
        <div class="previous-page">
            <a href="www.mypage.com" onclick="window.history.go(-1); return false;"><img class="back-arrow" src="<?php echo get_template_directory_uri(); ?>/img/back-arrow.png"></a>
            
        </div>
    </div>
	<main role="main">
		
	</main>


<?php get_footer(); ?>
