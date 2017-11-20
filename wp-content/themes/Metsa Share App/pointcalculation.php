<?php /* Template Name: Points calculation */ ?>

<?php get_header(); ?>


    <div class="app-container">
        
        
        <?php
        if(isset($_SESSION['user'])) {

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
            echo $newreport_id;          
        ?>
        <form class="storesearch-form" method="POST">
            <img class="storesearch-form-icon" src="<?php echo get_template_directory_uri(); ?>/img/magnifying%20glass%20white.png">
            <input class="storesearch-form-input" type="text" name="storename">
            <input class="storesearch-form-submit" type="submit" name="submit" value="Search">
        </form>

        
        <?php
        global $wpdb; //connect to wordpress database
            if(isset($_POST['submit'])){ //if submit is pressed do the script
       $name = $_POST['storename']; //store user input to $name
       $mainchains = $wpdb->get_results("SELECT * FROM product WHERE ean_product LIKE '%".$name."%' OR name_product LIKE '%".$name."%'"); //store sql query that selects all from store table and matches the store name with user input
        echo '<form method="POST">';
       foreach ($mainchains as $searchresult) {
           echo '<input type="hidden" name="id_product" value="'.$searchresult->id_product.'"></input>';
           echo '<input type="hidden" name="id_producer" value="'.$searchresult->id_producer.'"></input>';
           echo '<input type="hidden" name="id_label" value="'.$searchresult->id_label.'"></input>';
           echo '<input type="hidden" name="id_subcat" value="'.$searchresult->id_subcat.'"></input>';
           echo '<input type="hidden" name="id_category" value="'.$searchresult->id_category.'"></input>';
           echo '<input type="hidden" name="name_product" value="'.$searchresult->name_product.'"></input>';
           echo '<input type="hidden" name="ean_product" value="'.$searchresult->ean_product.'"></input>';
           echo '<input type="hidden" name="width_product" value="'.$searchresult->width_product.'"></input>';
           echo '<input type="hidden" name="height_product" value="'.$searchresult->height_product.'"></input>';
           echo '<input type="hidden" name="depth_product" value="'.$searchresult->depth_product.'"></input>';
           
           echo '<button class="showpoints" type="submit" name="showpoints" onclick="inputpoints()" value="'. $searchresult->name_product. ' - ' .$searchresult->ean_product.'"></button>';
       }
            echo '</form>';
            }
        /* 
        Tuotteen etsiminen -> tuo suoraan pisteytyksen
        Syöttää tuotteen pisteet
        Next item tallentaa 
        Button to add products, button to edit them - product points sivun avaaminen luo aina uuden raportin, miten se
        
        */
        ?>
        <script>
        
            $(".goback").click(function(){
                $(".hidden_points").hide();
            });

            $(".showpoints").click(function(){
                $(".hidden_points").show();
            });
        </script>
        
        
        <div class="hidden_points">
        <?php
            if(isset($_POST['showpoints'])) {
            $id_product = $_POST["id_product"]; // id for store
            $id_producer = $_POST["id_producer"]; 
            $id_label = $_POST["id_label"]; 
            $id_subcat = $_POST["id_subcat"]; 
            $id_category = $_POST["id_category"]; 
            $name_product = $_POST["name_product"]; 
            $ean_product = $_POST["ean_product"];
            $width_product = $_POST["width_product"];
            $height_product = $_POST["height_product"];
            $depth_product = $_POST["depth_product"];
            $settings_id = $_GET["idss"];
                
            $shelfcount = $wpdb->get_results("SELECT * FROM store_settings WHERE id_store_settings = ".$settings_id."");
            foreach ($shelfcount as $shelves) {
                $paper_shelves = $shelves->paper_shelf_count;
                $hank_shelves = $shelves->hank_shelf_count;
                $paper_depth = $shelves->paper_depth;
                $hank_depth = $shelves->hank_depth;
            }
                
            echo '<div class="goback">X</div>';
            echo '<form method="post">';
            if ($id_category == 1 or 2) {
                switch ($paper_shelves) {
                    case 0:
                        echo 'There are currently 0 shelves set for your store. Please edit the settings';
                        break;
                    case 1:
                        echo '<input type="text" name="shelf1_points" value=""></input>';
                        break;
                    case 2:
                        echo '<input type="text" name="shelf1_points" value=""></input>';
                        echo '<input type="text" name="shelf2_points" value=""></input>';
                        break;
                    case 3:
                        echo '<input type="text" name="shelf1_points" value=""></input>';
                        echo '<input type="text" name="shelf2_points" value=""></input>';
                        echo '<input type="text" name="shelf3_points" value=""></input>';
                        break;
                    case 4:
                        echo '<input type="text" name="shelf1_points" value=""></input>';
                        echo '<input type="text" name="shelf2_points" value=""></input>';
                        echo '<input type="text" name="shelf3_points" value=""></input>';
                        echo '<input type="text" name="shelf4_points" value=""></input>';
                        break;
                    case 5:
                        echo '<input type="text" name="shelf1_points" value=""></input>';
                        echo '<input type="text" name="shelf2_points" value=""></input>';
                        echo '<input type="text" name="shelf3_points" value=""></input>';
                        echo '<input type="text" name="shelf4_points" value=""></input>';
                        echo '<input type="text" name="shelf5_points" value=""></input>';
                        break;
                    default:
                        echo '!Error!';
                    }
                } elseif ($id_category == 3) {
                    switch ($hank_shelves) {
                    case 0:
                        echo 'There are currently 0 shelves set for your store. Please edit the settings';
                        break;
                    case 1:
                        echo '<input type="text" name="shelf1_points" value=""></input>';
                        break;
                    case 2:
                        echo '<input type="text" name="shelf1_points" value=""></input>';
                        echo '<input type="text" name="shelf2_points" value=""></input>';
                        break;
                    case 3:
                        echo '<input type="text" name="shelf1_points" value=""></input>';
                        echo '<input type="text" name="shelf2_points" value=""></input>';
                        echo '<input type="text" name="shelf3_points" value=""></input>';
                        break;
                    case 4:
                        echo '<input type="text" name="shelf1_points" value=""></input>';
                        echo '<input type="text" name="shelf2_points" value=""></input>';
                        echo '<input type="text" name="shelf3_points" value=""></input>';
                        echo '<input type="text" name="shelf4_points" value=""></input>';
                        break;
                    case 5:
                        echo '<input type="text" name="shelf1_points" value=""></input>';
                        echo '<input type="text" name="shelf2_points" value=""></input>';
                        echo '<input type="text" name="shelf3_points" value=""></input>';
                        echo '<input type="text" name="shelf4_points" value=""></input>';
                        echo '<input type="text" name="shelf5_points" value=""></input>';
                        break;
                    default:
                        echo '!Error!';
                    }
                }
            }
            echo '<input type="text" name="pallet_points" value=""></input>';
            echo '<input type="text" name="empty_points" value=""></input>';
            echo '<button type="submit" name="accept" value="Add points"></button>';
            echo '</form>';

            if(isset($_POST['accept'])) {
                
                
                $productinfo = $wpdb->get_results("SELECT * FROM product WHERE id_product = ".$id_product."");
                foreach ($shelfcount as $shelves) {
                    $width = $shelves->width_product;
                    $height = $shelves->height_product;
                    $depth = $shelves->depth_product;
                }
                $shelf1_points = $_POST['shelf1_points'];
                $shelf2_points = $_POST['shelf2_points'];
                $shelf3_points = $_POST['shelf3_points'];
                $shelf4_points = $_POST['shelf4_points'];
                $shelf5_points = $_POST['shelf5_points'];
                $pallet_points = $_POST['pallet_points'];
                $empty_points = $_POST['empty_points'];
                
                if ($id_category == 3) {
                    $productcount_points1 = $hank_depth / $depth * $shelf1_points;
                    $productcount_points2 = $hank_depth / $depth * $shelf2_points;
                    $productcount_points3 = $hank_depth / $depth * $shelf3_points;
                    $productcount_points4 = $hank_depth / $depth * $shelf4_points;
                    $productcount_points5 = $hank_depth / $depth * $shelf5_points;
                    
                    $finalpoints = $productcount_points1 + $productcount_points2 + $productcount_points3 + $productcount_points4 + $productcount_points5;
                }
                // hyllyn syvyys / tuotteen syvyydellä * feissien määrä
                
                
                $wpdb->insert(
                'points',
                array (
                    'id_report' => $newreport_id,
                    'id_main_chain' => $mainchain_id,
                    'id_store_chain' => $mainchain_id,
                    'id_store' => $store_id,
                    'id_product' => $id_product,
                    'id_producer' => $id_producer,
                    'id_subcat' => $id_subcat,
                    'id_category' => $id_category,
                    'id_label' => $id_label,
                    'shelf1_points' => $shelf1_points,
                    'shelf2_points' => $shelf2_points,
                    'shelf3_points' => $shelf3_points,
                    'shelf4_points' => $shelf4_points,
                    'shelf5_points' => $shelf5_points,
                    'pallet_points' => $pallet_points,
                    'empty_points' => $empty_points,
                    'id_store_settings' => $id_settings,
                    'productcount_points' => $finalpoints
                ),array( 
		          '%d', 
		          '%d',
                    '%d', 
		              '%s',
                '%s'
	           ) 
            );
            $pointsid = $wpdb->insert_id;
            }
            $wpdb->last_error;    
            //shelf1-5_points if lause jos tuote on paperia niin cat 1-2 tai jos hank nii cat 3
            //pallet_points
            //empty_points
            //productcount_points
        ?>
        </div>
                
                
        <div class="previous-page">
            <a href="www.mypage.com" onclick="window.history.go(-1); return false;"><img class="back-arrow" src="<?php echo get_template_directory_uri(); ?>/img/back-arrow.png"></a>
        </div>
    </div>
	<main role="main">
		
	</main>


<?php get_footer(); ?>