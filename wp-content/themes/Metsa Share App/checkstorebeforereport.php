<?php /* Template Name: Check store settings before report */ ?>

<?php get_header(); ?>


    <div class="app-container">
        
        <?php
        
        //
        
        $store_id = $_GET["ids"]; // id for store
        $storechain_id = $_GET["idsc"]; //id for store chain
        $mainchain_id = $_GET["idmc"]; //id for main chain
        $settings_id = $_GET["idss"]; //id for store settings
        $dateandtime = date("d.m.Y"); //gets the time and date from server, used as report creation date
        
        
        $name_storesettings = $wpdb->get_results("SELECT name_store FROM store WHERE id_store = ".$store_id.""); //select store names from store database with the store ID from previous page
        foreach ($name_storesettings as $storename) { 
            echo '<h1 class="product-store-name">'.$storename->name_store.'</h1>'; //echoes the store name as the title for the page, easier to remember which store you were looking at
            echo '<br>';   
        }
        $storename = $storename->name_store;
            
        $settings_for_store = $wpdb->get_results("SELECT * FROM store_settings WHERE id_store_settings = ".$settings_id.""); //
        echo '<div class="check-store-settings">';
        foreach ($settings_for_store as $checksettings) { //here we echo all store settings than can be checked before you start making a report
            echo '<h3 class="check-settings">HoTo/ToTi</h3>';
            echo '<h3 class="check-settings"></h3>';
            echo '<h3 class="check-settings">Hankies</h3>';
            echo '<h3 class="check-settings">'.$checksettings->paper_segments.'</h3>'; //how many modules/segments are in the store
            echo '<h3 class="check-settings"> Segments </h3>'; 
            echo '<h3 class="check-settings">'.$checksettings->hank_segment.'</h3>';  //
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
                    $shelf_counter = 1;
                    while ($shelf_counter < $highestshelfnumber) {
                        echo '<h3 class="check-settings-height"></h3>';
                        echo '<br>';
                        $shelf_counter++;
                    }
                    echo '<h3 class="check-settings-height"> '.$checksettings->paper_height1.'</h3>';
                    echo '<br>';
                    break;
                case 2:
                    $shelf_counter = 2;
                    while ($shelf_counter < $highestshelfnumber) {
                        echo '<h3 class="check-settings-height"></h3>';
                        echo '<br>';
                        $shelf_counter++;
                    }
                    echo '<h3 class="check-settings-height"> '.$checksettings->paper_height2.'</h3>';
                    echo '<br>';
                    echo '<h3 class="check-settings-height"> '.$checksettings->paper_height1.'</h3>';
                    echo '<br>';
                    break;
                case 3:
                    $shelf_counter = 3;
                    while ($shelf_counter < $highestshelfnumber) {
                        echo '<h3 class="check-settings-height"></h3>';
                        echo '<br>';
                        $shelf_counter++;
                    }
                    echo '<h3 class="check-settings-height"> '.$checksettings->paper_height3.'</h3>';
                    echo '<br>';
                    echo '<h3 class="check-settings-height"> '.$checksettings->paper_height2.'</h3>';
                    echo '<br>';
                    echo '<h3 class="check-settings-height"> '.$checksettings->paper_height1.'</h3>';
                    echo '<br>';
                    break;
                case 4:
                    $shelf_counter = 4;
                    while ($shelf_counter < $highestshelfnumber) {
                        echo '<h3 class="check-settings-height"></h3>';
                        echo '<br>';
                        $shelf_counter++;
                    }
                    echo '<h3 class="check-settings-height"> '.$checksettings->paper_height4.'</h3>';
                    echo '<br>';
                    echo '<h3 class="check-settings-height"> '.$checksettings->paper_height3.'</h3>';
                    echo '<br>';
                    echo '<h3 class="check-settings-height"> '.$checksettings->paper_height2.'</h3>';
                    echo '<br>';
                    echo '<h3 class="check-settings-height"> '.$checksettings->paper_height1.'</h3>';
                    echo '<br>';
                    break;
                case 5:

                    echo '<h3 class="check-settings-height"> '.$checksettings->paper_height5.'</h3>';
                    echo '<br>';
                    echo '<h3 class="check-settings-height"> '.$checksettings->paper_height4.'</h3>';
                    echo '<br>';
                    echo '<h3 class="check-settings-height"> '.$checksettings->paper_height3.'</h3>';
                    echo '<br>';
                    echo '<h3 class="check-settings-height"> '.$checksettings->paper_height2.'</h3>';
                    echo '<br>';
                    echo '<h3 class="check-settings-height"> '.$checksettings->paper_height1.'</h3>';
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
                    echo '<table class="shelf-box-table">';
                    echo '<tr>';
                    echo '<th class="shelf-box">1</th>';
                    echo '</tr>';
                    echo '</table>';
                    break;
                case 2:
                    echo '<table class="shelf-box-table">';
                    echo '<tr>';
                    echo '<th class="shelf-box">2</th>';
                    echo '</tr>';
                    echo '<table class="shelf-box-table">';
                    echo '<tr>';
                    echo '<th class="shelf-box">1</th>';
                    echo '</tr>';
                    echo '</table>';
                    break;
                case 3:
                    echo '<table class="shelf-box-table">';
                    echo '<tr>';
                    echo '<th class="shelf-box">3</th>';
                    echo '</tr>';
                    echo '<table class="shelf-box-table">';
                    echo '<tr>';
                    echo '<th class="shelf-box">2</th>';
                    echo '</tr>';
                    echo '<table class="shelf-box-table">';
                    echo '<tr>';
                    echo '<th class="shelf-box">1</th>';
                    echo '</tr>';
                    echo '</table>';
                    break;
                case 4:
                    echo '<table class="shelf-box-table">';
                    echo '<tr>';
                    echo '<th class="shelf-box">4</th>';
                    echo '</tr>';
                    echo '<table class="shelf-box-table">';
                    echo '<tr>';
                    echo '<th class="shelf-box">3</th>';
                    echo '</tr>';
                    echo '<table class="shelf-box-table">';
                    echo '<tr>';
                    echo '<th class="shelf-box">2</th>';
                    echo '</tr>';
                    echo '<table class="shelf-box-table">';
                    echo '<tr>';
                    echo '<th class="shelf-box">1</th>';
                    echo '</tr>';
                    echo '</table>';
                    break;
                case 5:
                    
                    echo '<table class="shelf-box-table">';
                    echo '<tr>';
                    echo '<th class="shelf-box">5</th>';
                    echo '</tr>';
                    echo '<table class="shelf-box-table">';
                    echo '<tr>';
                    echo '<th class="shelf-box">4</th>';
                    echo '</tr>';
                    echo '<table class="shelf-box-table">';
                    echo '<tr>';
                    echo '<th class="shelf-box">3</th>';
                    echo '</tr>';
                    echo '<table class="shelf-box-table">';
                    echo '<tr>';
                    echo '<th class="shelf-box">2</th>';
                    echo '</tr>';
                    echo '<table class="shelf-box-table">';
                    echo '<tr>';
                    echo '<th class="shelf-box">1</th>';
                    echo '</tr>';
                    echo '</table>';
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
                    $shelf_counter = 1;
                    while ($shelf_counter < $highestshelfnumber) {
                        echo '<h3 class="check-settings-height"></h3>';
                        echo '<br>';
                        $shelf_counter++;
                    }
                    echo '<h3 class="check-settings-height"> '.$checksettings->hank_height1.'</h3>';
                    echo '<br>';
                    break;
                case 2:
                    $shelf_counter = 2;
                    while ($shelf_counter < $highestshelfnumber) {
                        echo '<h3 class="check-settings-height"></h3>';
                        echo '<br>';
                        $shelf_counter++;
                    }
                    echo '<h3 class="check-settings-height"> '.$checksettings->hank_height2.'</h3>';
                    echo '<br>';
                    echo '<h3 class="check-settings-height"> '.$checksettings->hank_height1.'</h3>';
                    echo '<br>';
                    break;
                case 3:
                    $shelf_counter = 3;
                    while ($shelf_counter < $highestshelfnumber) {
                        echo '<h3 class="check-settings-height"></h3>';
                        echo '<br>';
                        $shelf_counter++;
                    }
                    echo '<h3 class="check-settings-height"> '.$checksettings->hank_height3.'</h3>';
                    echo '<br>';
                    echo '<h3 class="check-settings-height"> '.$checksettings->hank_height2.'</h3>';
                    echo '<br>';
                    echo '<h3 class="check-settings-height"> '.$checksettings->hank_height1.'</h3>';
                    echo '<br>';
                    break;
                case 4:
                    $shelf_counter = 4;
                    while ($shelf_counter < $highestshelfnumber) {
                        echo '<h3 class="check-settings-height"></h3>';
                        echo '<br>';
                        $shelf_counter++;
                    }
                    echo '<h3 class="check-settings-height"> '.$checksettings->hank_height4.'</h3>';
                    echo '<br>';
                    echo '<h3 class="check-settings-height"> '.$checksettings->hank_height3.'</h3>';
                    echo '<br>';
                    echo '<h3 class="check-settings-height"> '.$checksettings->hank_height2.'</h3>';
                    echo '<br>';
                    echo '<h3 class="check-settings-height"> '.$checksettings->hank_height1.'</h3>';
                    echo '<br>';
                    break;
                case 5:
                    echo '<h3 class="check-settings-height"> '.$checksettings->hank_height5.'</h3>';
                    echo '<br>';
                    echo '<h3 class="check-settings-height"> '.$checksettings->hank_height4.'</h3>';
                    echo '<br>';
                    echo '<h3 class="check-settings-height"> '.$checksettings->hank_height3.'</h3>';
                    echo '<br>';
                    echo '<h3 class="check-settings-height"> '.$checksettings->hank_height2.'</h3>';
                    echo '<br>';
                    echo '<h3 class="check-settings-height"> '.$checksettings->hank_height1.'</h3>';
                    echo '<br>';
                    break;
                default:
                    echo '<h3 class="check-settings-height">There can only be maximum of 5 shelves. Please contact the coder to make better code where you can add amount of shelves yourself. Edit shelf count to be between 1-5</h3>';
            }
            echo '</div>';
        }
        echo '</div>';
        
        echo '<div class="menu-item-orange"><a href=http://127.0.0.1/wordpress/store-settings/edit-settings/?id='.$settings_id.'&amp;id2=' . $store_id . '> Change store settings </a></div>';
        echo '<form method="post">';
        echo '<input id="hidemeafterclick" class="menu-item-orange" type="submit"  name="input_report" value="Make report" ></input>';
        if(isset($_POST['input_report'])) 
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
            
            $save_url = 'http://127.0.0.1/wordpress/create-a-report/store-check-for-report/point-calculation/?idmc='.$mainchain_id.'&idsc='.$storechain_id.'&ids='.$store_id .'&idss='.$settings_id.'&idr='.$newreport_id.'';
            ?>
            <script type="text/javascript">
                window.location = "<?php echo $save_url; ?>";
            </script>      
            <?php
        } 
        echo '</form>';
        /* if(isset($_POST['input_report'])) {
        echo '<input type="hidden" id="hidesomething" style="color:white;"></input>';
        echo '<div class="showmeafterclick"><a href=http://127.0.0.1/wordpress/create-a-report/store-check-for-report/point-calculation/?idmc='.$mainchain_id.'&amp;idsc='.$storechain_id.'&amp;ids='.$store_id .'&amp;idss='.$settings_id.'&amp;idr='.$newreport_id.'> Continue </a></div>';
        /* echo '<form method="post">';
        echo '<input class="menu-item-orange" type="submit" name="start-counting" value="Start counting"></input>';
        echo '</form>'; */
        
        //}
        // <a href="http://127.0.0.1/wordpress/create-a-report/store-check-for-report/point-calculation/?r_id="'.$newreport_id.'"></a>
        ?>
        <script>
        $("#hidemeafterclick").click(function(){
                $("#hidemeafterclick").toggle();
            });
            
        $("#hidesomething").trigger(function(){
                $("#hidemeafterclick").toggle();
            });
        </script>
        <div class="previous-page">
            <a href="www.mypage.com" onclick="window.history.go(-1); return false;"><img class="back-arrow" src="<?php echo get_template_directory_uri(); ?>/img/back-arrow.png"></a>
        </div>
    </div>
	<main role="main">
		
	</main>


<?php get_footer(); ?>