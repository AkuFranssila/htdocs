<?php /* Template Name: Check store settings before report */ ?>

<?php get_header(); ?>


    <div class="app-container">
        
        <?php
        $store_id = $_GET["ids"]; // id for store
        $storechain_id = $_GET["idsc"]; //id for store chain
        $mainchain_id = $_GET["idmc"]; //id for main chain
        $settings_id = $_GET["idss"]; //id for store settings
        $dateandtime = date("d.m.Y"); //gets the time and date from server, used as report creation date
        
        
        $name_storesettings = $wpdb->get_results("SELECT name_store FROM store WHERE id_store = ".$store_id."");
        foreach ($name_storesettings as $storename) { 
            echo '<h1 class="product-store-name">'.$storename->name_store.'</h1>';
            echo '<br>';   
        }
        $storename = $storename->name_store;
            
        $settings_for_store = $wpdb->get_results("SELECT * FROM store_settings WHERE id_store_settings = ".$settings_id."");
        echo '<div class="check-store-settings">';
        foreach ($settings_for_store as $checksettings) { 
            echo '<h3 class="check-settings">HoTo/ToTi</h3>';
            echo '<h3 class="check-settings"></h3>';
            echo '<h3 class="check-settings">Hankies</h3>';
            echo '<h3 class="check-settings">'.$checksettings->paper_segments.'</h3>';
            echo '<h3 class="check-settings"> Segments </h3>'; 
            echo '<h3 class="check-settings">'.$checksettings->hank_segment.'</h3>';  
            echo '<h3 class="check-settings">'.$checksettings->paper_shelf_count.'</h3>';  
            echo '<h3 class="check-settings"> No. shelves </h3>';  
            echo '<h3 class="check-settings">'.$checksettings->hank_shelf_count.'</h3>';  
            echo '<h3 class="check-settings"> '.$checksettings->paper_width . ' / ' . $checksettings->paper_depth.'</h3>';  
            echo '<h3 class="check-settings"> Width/Depth </h3>';  
            echo '<h3 class="check-settings"> '.$checksettings->hank_width . ' / ' . $checksettings->hank_depth.'</h3>';
            
            //Storing shelf count 
            $shelves = $checksettings->paper_shelf_count;
            $shelveshank = $checksettings->hank_shelf_count;
            
            //doing if to see how many shelf numbers needed and storing it
            if ($shelves >= $shelveshank) {
                $highestshelfnumber = $shelves;
            } else {
                $highestshelfnumber = $shelveshank;
            }
            
            
            //switch statement for which shelf height rows need to displayed for hoto and toti
            echo '<div class="height-box">';
            switch ($shelves) {
                case 0:
                    echo '<h3 class="check-settings-height"> There are currently 0 shelves. Please edit store settings </h3>';
                    echo '<br>';
                    break;
                case 1:
                    echo '<h3 class="check-settings-height"> '.$checksettings->paper_height1.'</h3>';
                    echo '<br>';
                    break;
                case 2:
                    echo '<h3 class="check-settings-height"> '.$checksettings->paper_height1.'</h3>';
                    echo '<br>';
                    echo '<h3 class="check-settings-height"> '.$checksettings->paper_height2.'</h3>';
                    echo '<br>';
                    break;
                case 3:
                    echo '<h3 class="check-settings-height"> '.$checksettings->paper_height1.'</h3>';
                    echo '<br>';
                    echo '<h3 class="check-settings-height"> '.$checksettings->paper_height2.'</h3>';
                    echo '<br>';
                    echo '<h3 class="check-settings-height"> '.$checksettings->paper_height3.'</h3>';
                    echo '<br>';
                    break;
                case 4:
                    echo '<h3 class="check-settings-height"> '.$checksettings->paper_height1.'</h3>';
                    echo '<br>';
                    echo '<h3 class="check-settings-height"> '.$checksettings->paper_height2.'</h3>';
                    echo '<br>';
                    echo '<h3 class="check-settings-height"> '.$checksettings->paper_height3.'</h3>';
                    echo '<br>';
                    echo '<h3 class="check-settings-height"> '.$checksettings->paper_height4.'</h3>';
                    echo '<br>';
                    break;
                case 5:
                    echo '<h3 class="check-settings-height"> '.$checksettings->paper_height1.'</h3>';
                    echo '<br>';
                    echo '<h3 class="check-settings-height"> '.$checksettings->paper_height2.'</h3>';
                    echo '<br>';
                    echo '<h3 class="check-settings-height"> '.$checksettings->paper_height3.'</h3>';
                    echo '<br>';
                    echo '<h3 class="check-settings-height"> '.$checksettings->paper_height4.'</h3>';
                    echo '<br>';
                    echo '<h3 class="check-settings-height"> '.$checksettings->paper_height5.'</h3>';
                    echo '<br>';
                    break;
                default:
                    echo '<h3 class="check-settings-height">There can only be maximum of 5 shelves. Please contact the coder to make better code where you can add amount of shelves yourself. Edit shelf count to be between 1-5</h3>';
            }
            echo '</div>';
            //switch statement to output the right amount of needed shelf texts
            echo '<div class="height-box">';
            switch ($highestshelfnumber) {
                case 0:
                    echo '<h3 </h3>';
                    echo '<br>';
                    break;
                case 1:
                    echo '<h3 class="check-settings-height"> Height 1 </h3>';
                    echo '<br>';
                    break;
                case 2:
                    echo '<h3 class="check-settings-height"> Height 1 </h3>';
                    echo '<br>';
                    echo '<h3 class="check-settings-height"> Height 2 </h3>';
                    echo '<br>';
                    break;
                case 3:
                    echo '<h3 class="check-settings-height"> Height 1 </h3>';
                    echo '<br>';
                    echo '<h3 class="check-settings-height"> Height 2 </h3>';
                    echo '<br>';
                    echo '<h3 class="check-settings-height"> Height 3 </h3>';
                    echo '<br>';
                    break;
                case 4:
                    echo '<h3 class="check-settings-height"> Height 1 </h3>';
                    echo '<br>';
                    echo '<h3 class="check-settings-height"> Height 2 </h3>';
                    echo '<br>';
                    echo '<h3 class="check-settings-height"> Height 3 </h3>';
                    echo '<br>';
                    echo '<h3 class="check-settings-height"> Height 4 </h3>';
                    echo '<br>';
                    break;
                case 5:
                    echo '<h3 class="check-settings-height"> Height 1 </h3>';
                    echo '<br>';
                    echo '<h3 class="check-settings-height"> Height 2 </h3>';
                    echo '<br>';
                    echo '<h3 class="check-settings-height"> Height 3 </h3>';
                    echo '<br>';
                    echo '<h3 class="check-settings-height"> Height 4 </h3>';
                    echo '<br>';
                    echo '<h3 class="check-settings-height"> Height 5 </h3>';
                    echo '<br>';
                    break;
                default:
                    echo '<h3 class="check-settings-height">Not possible</h3>';
            }
            echo '</div>';
            
            //switch statement for which shelf height rows need to displayed for hankies
            echo '<div class="height-box">';
            switch ($shelveshank) {
                case 0:
                    echo '<h3 class="check-settings-height"> There are currently 0 shelves. Please edit store settings </h3>';
                    echo '<br>';
                    break;
                case 1:
                    echo '<h3 class="check-settings-height"> '.$checksettings->hank_height1.'</h3>';
                    echo '<br>';
                    break;
                case 2:
                    echo '<h3 class="check-settings-height"> '.$checksettings->hank_height1.'</h3>';
                    echo '<br>';
                    echo '<h3 class="check-settings-height"> '.$checksettings->hank_height2.'</h3>';
                    echo '<br>';
                    break;
                case 3:
                    echo '<h3 class="check-settings-height"> '.$checksettings->hank_height1.'</h3>';
                    echo '<br>';
                    echo '<h3 class="check-settings-height"> '.$checksettings->hank_height2.'</h3>';
                    echo '<br>';
                    echo '<h3 class="check-settings-height"> '.$checksettings->hank_height3.'</h3>';
                    echo '<br>';
                    break;
                case 4:
                    echo '<h3 class="check-settings-height"> '.$checksettings->hank_height1.'</h3>';
                    echo '<br>';
                    echo '<h3 class="check-settings-height"> '.$checksettings->hank_height2.'</h3>';
                    echo '<br>';
                    echo '<h3 class="check-settings-height"> '.$checksettings->hank_height3.'</h3>';
                    echo '<br>';
                    echo '<h3 class="check-settings-height"> '.$checksettings->hank_height4.'</h3>';
                    echo '<br>';
                    break;
                case 5:
                    echo '<h3 class="check-settings-height"> '.$checksettings->hank_height1.'</h3>';
                    echo '<br>';
                    echo '<h3 class="check-settings-height"> '.$checksettings->hank_height2.'</h3>';
                    echo '<br>';
                    echo '<h3 class="check-settings-height"> '.$checksettings->hank_height3.'</h3>';
                    echo '<br>';
                    echo '<h3 class="check-settings-height"> '.$checksettings->hank_height4.'</h3>';
                    echo '<br>';
                    echo '<h3 class="check-settings-height"> '.$checksettings->hank_height5.'</h3>';
                    echo '<br>';
                    break;
                default:
                    echo '<h3 class="check-settings-height">There can only be maximum of 5 shelves. Please contact the coder to make better code where you can add amount of shelves yourself. Edit shelf count to be between 1-5</h3>';
            }
            echo '</div>';
        }
        echo '</div>';
        
        echo '<div class="menu-item-orange"><a href=http://127.0.0.1/wordpress/store-settings/edit-settings/?id='.$settings_id.'&amp;id2=' . $store_id . '> Change store settings </a></div>'; 
        echo '<div class="menu-item-orange"><a href=http://127.0.0.1/wordpress/create-a-report/store-check-for-report/point-calculation/?idmc='.$mainchain_id.'&amp;idsc='.$storechain_id.'&amp;ids='.$store_id .'&amp;idss='.$settings_id.'> Start counting </a></div>';
        /* echo '<form method="post">';
        echo '<input class="menu-item-orange" type="submit" name="start-counting" value="Start counting"></input>';
        echo '</form>'; */
        
        /* if(isset($_POST['start-counting'])) 
        {
            global $wpdb;
            $wpdb->show_errors();
            $store_id = $_GET["ids"]; // id for store
            $storechain_id = $_GET["idsc"]; //id for store chain
            $mainchain_id = $_GET["idmc"]; //id for main chain
            $settings_id = $_GET["idss"]; //id for store settings
            $dateandtime = date("d.m.Y"); //gets the time and date from server, used as report creation date
            $insertsyntax = $wpdb->insert(
                'reports',
                array (
                    'id_store' => $store_id,
                    'id_store_chain' => $storechain_id,
                    'id_main_chain' => $mainchain_id,
                    'date_reports' => $dateandtime,
                    'name_reports' => $storename
                ),array( 
		          '%d', 
		          '%d',
                    '%d', 
		              '%s',
                '%s'
	           ) 
            );
            
            $newreport_id = $wpdb->insert_id;
            echo $wpdb->last_query;
            echo $newreport_id; 
        } */
        // <a href="http://127.0.0.1/wordpress/create-a-report/store-check-for-report/point-calculation/?r_id="'.$newreport_id.'"></a>
        ?>
        
        <div class="previous-page">
            <a href="www.mypage.com" onclick="window.history.go(-1); return false;"><img class="back-arrow" src="<?php echo get_template_directory_uri(); ?>/img/back-arrow.png"></a>
        </div>
    </div>
	<main role="main">
		
	</main>


<?php get_footer(); ?>