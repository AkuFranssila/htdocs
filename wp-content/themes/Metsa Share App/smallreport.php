<?php /* Template Name: Small report */ ?>

<?php get_header(); ?>

    <div class="app-container">
         
        <?php  
        
        $id_report = $_GET['id']; //Get the report ID transferred from pointcalculation
        
    // Report name and date
    $name_date = $wpdb->get_results("SELECT name_reports, date_reports FROM reports WHERE id_report =".$id_report.""); //Getting report date and name to be used as the name of the visual report
    foreach ($name_date as $nd) {
    echo '<h1 class="product-store-name">'. $nd->name_reports . ' ' . $nd->date_reports.'</h1>';
    }
    
    // CALCULATING HOW SHARE OF SHELF SPACE IS DIVIDED 
        
    $allfaces = 0; 
        
    //CATEGORIES
    $hoto = 0; 
    $toti = 0; 
    $hank = 0;
        
    // PRODUCERS
    $ruokakesko = 0;
    $mt = 0;
    $sca = 0;
    $kimberly = 0;
    $majesta = 0;
    $horizon = 0;
    $srl = 0;
    $shs = 0;
        
    //MT FAIRSHARE
    $mt_hoto = 0;
    $mt_toti = 0;
    $mt_hank = 0;
        
    //LABELS
    $kmenu = 0;
    $lambi = 0;
    $lotus = 0;
    $pirkka = 0;
    $serla = 0;
    $angrybirds = 0;
    $daisy = 0;
    $harmony = 0;
    $kleenex = 0;
    $majesta = 0;
    $nessu = 0;
        
        
 // SQUARE AREA OF PRODUCTS DIVIDED BY        
    //CATEGORIES
    $hoto_sq = 0; 
    $toti_sq = 0; 
    $hank_sq = 0;
        
    // PRODUCERS
    $ruokakesko_sq = 0;
    $mt_sq = 0;
    $sca_sq = 0;
    $kimberly_sq = 0;
    $majesta_sq = 0;
    $horizon_sq = 0;
    $srl_sq = 0;
    $shs_sq = 0;
        
    $ruokakesko_sq_shelf = 0;
    $mt_sq_shelf = 0;
    $sca_sq_shelf = 0;
    $kimberly_sq_shelf = 0;
    $majesta_sq_shelf = 0;
    $horizon_sq_shelf = 0;
    $srl_sq_shelf = 0;
    $shs_sq_shelf = 0;
        
    //MT FAIRSHARE
    $mt_hoto_sq = 0;
    $mt_toti_sq = 0;
    $mt_hank_sq = 0;
        
    $mt_hoto_product_sq = 0;
    $mt_toti_product_sq = 0;
    $mt_hank_product_sq = 0;
        
    //MT FAIRSHARE
    $mt_hoto_pallet = 0;
    $mt_toti_pallet = 0;
    $mt_hank_pallet = 0; 
    
    
        
    //LABELS
    $kmenu_sq = 0;
    $lambi_sq = 0;
    $lotus_sq = 0;
    $pirkka_sq = 0;
    $serla_sq = 0;
    $angrybirds_sq = 0;
    $daisy_sq = 0;
    $harmony_sq = 0;
    $kleenex_sq = 0;
    $majesta_sq = 0;
    $nessu_sq = 0;
    
    $kmenu_sq_shelf = 0;
    $lambi_sq_shelf = 0;
    $lotus_sq_shelf = 0;
    $pirkka_sq_shelf = 0;
    $serla_sq_shelf = 0;
    $angrybirds_sq_shelf = 0;
    $daisy_sq_shelf = 0;
    $harmony_sq_shelf = 0;
    $kleenex_sq_shelf = 0;
    $majesta_sq_shelf = 0;
    $nessu_sq_shelf = 0;
        
        
        
        
    $total_pallets = 0; //calculating how many pallets are in total for pallet square meter area 
    $total_pallets_hoto = 0;
    $total_pallets_toti = 0;      
    $total_pallets_hank = 0;
        
    $hoto_pallet_sq = 0;
    $toti_pallet_sq = 0;
    $hank_pallet_sq = 0;
        
    $hoto_product_sq = 0;
    $toti_product_sq = 0;
    $hank_product_sq = 0;
        
        
    $product_sq = 0; //calculates square meter area for products in shelves
    $pallet_product_sq = 0; //calculates square meter area for products in pallets
        
        
    //Measurements for toti and hoto pallets and hank pallets, hardcoded because we didn't have to time to add it to the database
    $euro_pallet_width = 800;
    $euro_pallet_depth = 1200;
    $euro_pallet_height = 2400;
    $euro_pallet_sq = $euro_pallet_width * $euro_pallet_depth * $euro_pallet_height; //calculates total pallet square meter area
                
    $hank_pallet_width = 800;
    $hank_pallet_depth = 800;
    $hank_pallet_height = 1100;
    $hank_pallet_sq = $hank_pallet_width * $hank_pallet_depth * $hank_pallet_height; //calculates total pallet square meter area
        
        
    //STORE TOTAL SALES AREA 
    $total_store_area = 0;
        
        
    // ARRAYS FOR PRODUCT SPECIFIC SHARE OF SHELF SPACE
        
    $id_array = array();
    $share_array = array();
    $product_name = array();
        
    
    // Selecting all the products from points table where id report is the one we got from previous page
    $category_fairshare = $wpdb->get_results("SELECT * FROM points WHERE id_report =".$id_report."");
    foreach ($category_fairshare as $cat_fairshare) {
        $id_category = $cat_fairshare->id_category;
        $id_product = $cat_fairshare->id_product;
        $id_producer = $cat_fairshare->id_producer;
        $id_label = $cat_fairshare->id_label;
        $shelf1 = $cat_fairshare->shelf1_points;
        $shelf2 = $cat_fairshare->shelf2_points; 
        $shelf3 = $cat_fairshare->shelf3_points;
        $shelf4 = $cat_fairshare->shelf4_points;
        $shelf5 = $cat_fairshare->shelf5_points;
        $pallet_points = $cat_fairshare->pallet_points; //gets how many points the pallets get
        $pallet = $cat_fairshare->pallet_productcount_points; //gets the productcount from pallets
        $shelf_products = $cat_fairshare->productcount_points; //gets the productcount from shelf products
        
        
        $allfaces = $shelf1 + $shelf2 + $shelf3 + $shelf4 + $shelf5; //counts together all the faces from the shelves
        $product_info = $wpdb->get_results("SELECT * FROM product WHERE id_product = ".$id_product."" );
        foreach ($product_info as $info) {
            $width_product = $info->width_product;
            $height_product = $info->height_product;
            $depth_product = $info->depth_product;
            $wxh = $width_product * $height_product;
            $allfaces_switch = $allfaces; //this is not needed but I wasn't sure and made this to be sure
            $product_share = $allfaces_switch * $wxh;
            $product_share_sq = $shelf_products * $width_product * $height_product * $depth_product; //SQ OF SHELF PRODUCT
            $product_pallet_sq = $width_product * $height_product * $depth_product * $pallet; //SQ OF PALLET PRODUCTS
            $shelf_pallet_sq = $product_share_sq + $product_pallet_sq; //TOtal shelf + pallet square area one product, this is then added to the total below
            
            $id_label = $id_label;
            $idcat = $id_category;
            $idprodc = $id_producer;
            
            $product_sq = $product_sq + ($width_product * $height_product * $depth_product * $shelf_products); //total square area of products in shelves
            $pallet_product_sq = $pallet_product_sq + ($width_product * $height_product * $depth_product * $pallet); //total square area of products in pallet
            
            $id_array[] = array('id_product' => $id_product);
            $share_array[] = $shelf_pallet_sq;
            
            //CALCULATING TOTAL SHELF AREA VS AREA USED FOR PRODUCTS
            
            // Getting the store ID from store settings using the report id we got from previous page
            $id_for_store = $wpdb->get_results("SELECT id_store FROM reports WHERE id_report = ".$id_report."");
            foreach ($id_for_store as $store_id) {
                $id_store = $store_id->id_store;
                //With the store ID we get the settings for the store
                $ss = $wpdb->get_results("SELECT id_store_settings FROM store WHERE id_store = ".$id_store."");
                foreach ($ss as $settingss) {
                    $id_ss = $settingss->id_store_settings;
                    //GETTING ALL STORE SETTINGS FOR THE STORE
                    $store_s = $wpdb->get_results("SELECT * FROM store_settings WHERE id_store_settings = ".$id_ss."");
                    foreach ($store_s as $settings) {
                    $paper_total_height = $settings->paper_height1 + $settings->paper_height2 + $settings->paper_height3 + $settings->paper_height4 + $settings->paper_height5; //Calculating the total height of the shelves
                    $paper_width = $settings->paper_width;
                    $paper_segments = $settings->paper_segments;
                    $paper_depth = $settings->paper_depth;
                    
                    $paper_total_area = $paper_total_height * $paper_width * $paper_segments; 
                    $paper_total_sq = $paper_total_height * $paper_width * $paper_depth * $paper_segments; //total square area of hoti toti shelves
                    
                    $hank_total_height = $settings->hank_height1 + $settings->hank_height2 + $settings->hank_height3 + $settings->hank_height4 + $settings->hank_height5;
                    $hank_width = $settings->hank_width;
                    $hank_segment = $settings->hank_segment;
                    $hank_depth = $settings->hank_depth;
                    
                    $hank_total_area = $hank_total_height * $hank_width * $hank_segment;
                    $hank_total_sq = $hank_total_height * $hank_width * $hank_depth * $hank_segment; //total square area of hankies shelves
                    
                    $total_store_area = $total_store_area + $paper_total_area + $hank_total_area; //Adding the products paper total area and hank area, this way we don't have to check which category the product is
                    //$total_store_area_sq = $paper_total_sq + $hank_total_sq; //combining the area that the product takes this is then added below to their 
                     }
                    
                }
            }
        // Switch statement for checking which category the product belongs to
        switch ($id_category) {
            case 1:
                $hoto = $hoto + $product_share; //this is old coded used to calculate the fairshare only for the shelves and it couldn't be used with pallets
                
                $hoto_sq = $hoto_sq + $shelf_pallet_sq; //shelf + pallet sq area for hoto
                
                $total_pallets_hoto = $total_pallets_hoto + $pallet_points; //number of pallets for hoto
                
                $hoto_pallet_sq = $hoto_pallet_sq + $product_pallet_sq; //pallet sq for hoto
                
                $hoto_product_sq = $hoto_product_sq + $product_share_sq; //shelf sq for hoto
                
                break;
            case 2:
                $toti = $toti + $product_share; //this is old coded used to calculate the fairshare only for the shelves and it couldn't be used with pallets
                
                $toti_sq = $toti_sq + $shelf_pallet_sq;
                
                $total_pallets_toti = $total_pallets_toti + $pallet_points;
                
                $toti_pallet_sq = $toti_pallet_sq + $product_pallet_sq;
                
                $toti_product_sq = $toti_product_sq + $product_share_sq;
                
                break;
            case 3:
                $hank = $hank + $product_share; //this is old coded used to calculate the fairshare only for the shelves and it couldn't be used with pallets
                
                $hank_sq = $hank_sq + $shelf_pallet_sq;
                
                $total_pallets_hank = $total_pallets_hank + $pallet_points;
                
                $hank_pallet_sq = $hank_pallet_sq + $product_pallet_sq;
                 
                
                $hank_product_sq = $hank_product_sq + $product_share_sq;
                
                /* FOR TESTING
                echo 'Category ID: '.$id_category;
                echo '<br>';
                echo 'ID cat: '.$id_cat;
                echo '<br>';
                echo 'Product id: '.$id_product;
                echo '<br>';
                echo ' Tuotteen pinta-ala' . $product_share_sq;
                echo '<br>';
                echo 'Hank kokonais pinta-ala: '.$hank_product_sq;
                echo '<br>';
                echo '<br>';
                echo '<br>'; */
                break;
            default:
        }
        
            
        //Switch statement to calculate fairshare for producers
        switch ($id_producer) {
            case 1:
            // $fairshare_area = $wxh * $allfaces;
                $ruokakesko = $ruokakesko + $product_share;
                $ruokakesko_sq = $ruokakesko_sq + $shelf_pallet_sq;
                $ruokakesko_sq_shelf = $ruokakesko_sq_shelf + $product_share_sq;
            break;
            case 2:
                $mt = $mt + $product_share;
                $mt_sq = $mt_sq + $shelf_pallet_sq;
                $mt_sq_shelf = $mt_sq_shelf + $product_share_sq;
            break;
            case 3:
                $sca = $sca + $product_share;
                $sca_sq = $sca_sq + $shelf_pallet_sq;
                $sca_sq_shelf = $sca_sq_shelf + $product_share_sq;
            break;
            case 4:
                $kimberly = $kimberly + $product_share;
                $kimberly_sq = $kimberly_sq + $shelf_pallet_sq;
                $kimberly_sq_shelf = $kimberly_sq_shelf + $product_share_sq;
            break;
            case 5:
                $majesta = $majesta + $product_share;
                $majesta_sq = $majesta_sq + $shelf_pallet_sq;
                $majesta_sq_shelf = $majesta_sq_shelf + $product_share_sq;
            break;
            case 6:
                $horizon = $horizon + $product_share;
                $horizon_sq = $horizon_sq + $shelf_pallet_sq;
                $horizon_sq_shelf = $horizon_sq_shelf + $product_share_sq;
            break;
            case 7:
                $srl = $srl + $product_share;
                $srl_sq = $srl_sq + $shelf_pallet_sq;
                $srl_sq_shelf = $srl_sq_shelf + $product_share_sq;
            break;
            case 8:
                $shs = $shs + $product_share;
                $shs_sq = $shs_sq + $shelf_pallet_sq;
                $shs_sq_shelf = $shs_sq_shelf + $product_share_sq;
            break;
            default:
        }
            
        //Switch statement to calculate fairshare for labels
        switch ($id_label) {
            case 1:
                $kmenu = $kmenu + $product_share;
                $kmenu_sq = $kmenu_sq + $shelf_pallet_sq;
                $kmenu_sq_shelf = $kmenu_sq_shelf + $product_share_sq;
            break;
            case 2:
                $lambi = $lambi + $product_share;
                $lambi_sq = $lambi_sq + $shelf_pallet_sq;
                $lambi_sq_shelf = $lambi_sq_shelf + $product_share_sq;
            break;    
            case 3:
                $lotus = $lotus + $product_share;
                $lotus_sq = $lotus_sq + $shelf_pallet_sq;
                $lotus_sq_shelf = $lotus_sq_shelf + $product_share_sq;
            break;    
            case 4:
                $pirkka = $pirkka + $product_share;
                $pirkka_sq = $pirkka_sq + $shelf_pallet_sq;
                $pirkka_sq_shelf = $pirkka_sq_shelf + $product_share_sq;
            break;    
            case 5:
                $serla = $serla + $product_share;
                $serla_sq = $serla_sq + $shelf_pallet_sq;
                $serla_sq_shelf = $serla_sq_shelf + $product_share_sq;
            break;    
            case 6:
                $angrybirds = $angrybirds + $product_share;
                $angrybirds_sq = $angrybirds_sq + $shelf_pallet_sq;
                $angrybirds_sq_shelf = $angrybirds_sq_shelf + $product_share_sq;
            break;    
            case 7:
                $daisy = $daisy + $product_share;
                $daisy_sq = $daisy_sq + $shelf_pallet_sq;
                $daisy_sq_shelf = $daisy_sq_shelf + $product_share_sq;
            break;    
            case 8:
                $harmony = $harmony + $product_share;
                $harmony_sq = $harmony_sq + $shelf_pallet_sq;
                $harmony_sq_shelf = $harmony_sq_shelf + $product_share_sq;
            break;    
            case 9:
                $kleenex = $kleenex + $product_share;
                $kleenex_sq = $kleenex_sq + $shelf_pallet_sq;
                $kleenex_sq_shelf = $kleenex_sq_shelf + $product_share_sq;
            break;    
            case 10:
                $majesta =$majesta + $product_share;
                $majesta_sq =$majesta_sq + $shelf_pallet_sq;
                $majesta_sq_shelf =$majesta_sq_shelf + $product_share_sq;
            break;    
            case 11:
                $nessu = $nessu + $product_share;
                $nessu_sq = $nessu_sq + $shelf_pallet_sq;
                $nessu_sq_shelf = $nessu_sq_shelf + $product_share_sq;
            break; 
            default:
        }
        //if statement to calculate Metsä Tissue fairshare for categories
        if ($idcat == 1 AND $idprodc == 2) {
            $mt_hoto = $mt_hoto + $product_share;
            $mt_hoto_sq = $mt_hoto_sq + $shelf_pallet_sq;
            $mt_hoto_pallet = $mt_hoto_pallet + $product_pallet_sq;
            $mt_hoto_product_sq = $mt_hoto_product_sq + $product_share_sq;
        } elseif ($idcat == 2 AND $idprodc == 2) {
            $mt_toti = $mt_toti + $product_share;
            $mt_toti_sq = $mt_toti_sq + $shelf_pallet_sq;
            $mt_toti_pallet = $mt_toti_pallet + $product_pallet_sq;
            $mt_toti_product_sq = $mt_toti_product_sq + $product_share_sq;
        } elseif ($idcat == 3 AND $idprodc == 2) {
            $mt_hank = $mt_hank + $product_share;
            $mt_hank_sq = $mt_hank_sq + $shelf_pallet_sq;
            $mt_hank_pallet = $mt_hank_pallet + $product_pallet_sq;
            $mt_hank_product_sq = $mt_hank_product_sq + $product_share_sq;
            
        }
        }
    }
        
        
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////    
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////  
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////   
    $zero_checker = 0;   
    //Checks if there are any products in the points table and if there isn't the fairshare calculations won't be done. 
    $check_if_zero = $wpdb->get_results("SELECT * FROM points WHERE id_report =".$id_report."");
        foreach ($check_if_zero as $checking) {
            $check_product_id = $checking->id_product;
            $zero_checker++;
        }
    
    if ($zero_checker > 0) {
    $total_shelf_sq_area = $hoto_product_sq + $toti_product_sq + $hank_product_sq;  //SHELF SQ AREA WITH CATEGORIES
    $hotototihank_sq = $hoto_sq + $toti_sq + $hank_sq;                         // HOTO TOTI HANK TOTAL AREA PALLET + SHELF
    $hotototihank_sq_pallet = $hoto_pallet_sq + $toti_pallet_sq + $hank_pallet_sq;    //HOTO TOTI HANK TOTAL AREA PALLET
    $mt_pallet_total = $mt_hoto_pallet + $mt_toti_pallet + $mt_hank_pallet;  //MT TOTAL AREA OF PRODUCTS IN PALLETS
    $mt_total_shelf_sq = $mt_hoto_product_sq + $mt_toti_product_sq + $mt_hank_product_sq;//MT TOTAL AREA OF PRODUCTS IN SHELF
        
        
    $store_sq_shelf = $mt_total_shelf_sq / $total_shelf_sq_area;    // TOTAL AREA OF SHELF PRODUCTS WHEN REMOVING PALLET AREA FROM SHELF + PALLET AREA
        
    $mt_pallet_fairshare_total = $mt_pallet_total / $hotototihank_sq_pallet * 100;  //MT PALLET FAIRSHARE AREA
    $mt_pallet_fairshare_total = round($mt_pallet_fairshare_total,2);    
        
        
    $mt_shelf_sq_fairshare = $mt_total_shelf_sq / $total_shelf_sq_area * 100; //DIVIDING MT SHELF AREA WITH TOTAL SHELF AREA
    $mt_shelf_sq_fairshare = round($mt_shelf_sq_fairshare,2); //MT SHELF FAIRSHARE  
        
        
    $mt_pallet_shelf_total =$mt_pallet_total + $mt_total_shelf_sq; //MT PALLET + MT SHELF AREA SUMMED TOGETHER
    
    $mt_pallet_shelf_total = $mt_pallet_shelf_total / $hotototihank_sq * 100; //DIVIDING MT PALLET + SHELF AREA WITH TOTAL SHELF + PALLET AREA
    $mt_pallet_shelf_total = round($mt_pallet_shelf_total, 2);
        
    $total_pallets_all = $total_pallets_hank + $total_pallets_hoto + $total_pallets_toti; //checking if there are any pallets in the report
        
    $total_store_area_sq = $total_store_area_sq + $hotototihank_sq_pallet; // Maximum pallet area is only what is being used as store personnel don't fill the pallets themselves. So they have little say how they are ordered.
        
    //CATEGORY SHARE IN STORE - SHELVES
    
    $hoto_share_shelves = round(($hoto_product_sq / $total_shelf_sq_area * 100),2);
    $toti_share_shelves = round(($toti_product_sq / $total_shelf_sq_area * 100),2);
    $hank_share_shelves = round(($hank_product_sq / $total_shelf_sq_area * 100),2);
        
    //CATEGORY SHARE IN STORE - TOTAL
    
    $hoto_share_all = round(($hoto_sq / $hotototihank_sq * 100),2);
    $toti_share_all = round(($toti_sq / $hotototihank_sq * 100),2);
    $hank_share_all = round(($hank_sq / $hotototihank_sq * 100),2);
        
    
    //CATEGORY SHARE IN STORE - PALLET
        
    $hoto_share_pallet = round(($hoto_pallet_sq / $hotototihank_sq_pallet * 100),2);
    $toti_share_pallet = round(($toti_pallet_sq / $hotototihank_sq_pallet * 100),2);
    $hank_share_pallet = round(($hank_pallet_sq / $hotototihank_sq_pallet * 100),2);
    
        
    //MT CATEGORY SHARE WITH SHELF SQ
    $mt_shelf_only_hoto = round(($mt_hoto_product_sq / $hoto_product_sq * 100),2);
    $mt_shelf_only_toti = round(($mt_toti_product_sq / $toti_product_sq * 100),2);
    $mt_shelf_only_hank = round(($mt_hank_product_sq / $hank_product_sq * 100),2);
        
    //Calculating how much pallet area labels have. Calculated by reducing the label total area with the labels shelf area
    $kmenu_sq_pallet = $kmenu_sq - $kmenu_sq_shelf; 
    $lambi_sq_pallet = $lambi_sq - $lambi_sq_shelf;
    $lotus_sq_pallet = $lotus_sq - $lotus_sq_shelf;
    $pirkka_sq_pallet = $pirkka_sq - $pirkka_sq_shelf;
    $serla_sq_pallet = $serla_sq - $serla_sq_shelf;
    $angrybirds_sq_pallet = $angrybirds_sq - $angrybirds_sq_shelf;
    $daisy_sq_pallet = $daisy_sq - $daisy_sq_shelf;
    $harmony_sq_pallet = $harmony_sq - $harmony_sq_shelf;
    $kleenex_sq_pallet = $kleenex_sq - $kleenex_sq_shelf;
    $majesta_sq_pallet = $majesta_sq - $majesta_sq_shelf;
    $nessu_sq_pallet = $nessu_sq - $nessu_sq_shelf;
    
        
     //Calculating how much pallet area producers have. Calculated by reducing the producer total area with the producers shelf area   
    $ruokakesko_sq_pallet = $ruokakesko_sq - $ruokakesko_sq_shelf;
    $mt_sq_pallet = $mt_sq - $mt_sq_shelf;
    $sca_sq_pallet = $sca_sq - $sca_sq_shelf;
    $kimberly_sq_pallet = $kimberly_sq - $kimberly_sq_shelf;
    $majesta_sq_pallet = $majesta_sq - $majesta_sq_shelf;
    $horizon_sq_pallet = horizon_sq - horizon_sq_shelf;
    $srl_sq_pallet = $srl_sq - $srl_sq_shelf;
    $shs_sq_pallet = $shs_sq - $shs_sq_shelf;
        
        
        
    //MT CATEGORY SHARE WITH PALLET SQ checking if there are any pallets, if there are then calculates if MT has any pallets
    if ($hoto_pallet_sq > 0) {
        $mt_pallet_only_hoto = round(($mt_hoto_pallet / $hoto_pallet_sq * 100),2);
    } 
    if ($toti_pallet_sq > 0) {
    $mt_pallet_only_toti = round(($mt_toti_pallet / $toti_pallet_sq * 100),2);
        }
    if ($hank_pallet_sq > 0) {
    $mt_pallet_only_hank = round(($mt_hank_pallet / $hank_pallet_sq * 100),2);
    }
        
    //MT CATEGORY SHARE WITH SHELF + PALLET SQ
    $mt_shelf_pallet_hoto = round(($mt_hoto_sq / $hoto_sq * 100),2);
    $mt_shelf_pallet_toti = round(($mt_toti_sq / $toti_sq * 100),2);
    $mt_shelf_pallet_hank = round(($mt_hank_sq / $hank_sq * 100),2);
        
    $percent = $hoto + $toti + $hank; //old code used to calculate fairshare
        
    //checks with the old code if there are any hoto/toti/hank products and if the result is 0 then echoes error
    if ($hoto > 0)  {
            $mt_hoto = $mt_hoto / $hoto * 100;    // MT HOTO FAIRSHARE
            $mt_hoto = round($mt_hoto, 2);
        
            $mt_hoto_sq = $mt_hoto_sq / $hoto_sq * 100;
            $mt_hoto_sq = round($mt_hoto_sq, 2);
        }else {
        echo '<h1 class="menu-item-orange"> Not enough data to calculate MT hoto fairshare </h1>';
        $mt_hoto = 0;
    }
        if ($toti > 0 )  {
            $mt_toti = $mt_toti / $toti * 100;     // MT TOTI FAIRSHARE
            $mt_toti = round($mt_toti, 2);
            
            $mt_toti_sq = $mt_toti_sq / $toti_sq * 100;
            $mt_toti_sq = round($mt_toti_sq, 2);
            }else {
        echo '<h1 class="menu-item-orange"> Not enough data to calculate MT toti fairshare </h1>';
            $mt_toti = 0;
    }
        if ($hank > 0 )  {
            $mt_hank = $mt_hank / $hank * 100;      // MT HANK FAIR SHARE
            $mt_hank = round($mt_hank, 2);
            
            $mt_hank_sq = $mt_hank_sq / $hank_sq * 100;
            $mt_hank_sq = round($mt_hank_sq, 2);
        }else {
        echo '<h1 class="menu-item-orange"> Not enough data to calculate MT hank fairshare </h1>';
        $mt_hank = 0;
    }        
    
        
    //old code    
    if ($percent > 0 ) {
    $hoto = round(($hoto / $percent * 100),2);
    $toti = round(($toti / $percent * 100),2);
    $hank = round(($hank / $percent * 100),2);
        
        
        
    /* $category_total_share = array(
	array("y" => $hoto, "name" => "Hoto"),
	array("y" => $toti, "name" => "Toti"),
	array("y" => $hank, "name" => "Hank")
    ); */
    //ARRAY THAT TELLS HOW MUCH SPACE CATEGORIES HAVE IN STORE
        
    //TOTAL
    $category_total_share = array(
	array("y" => $hoto_share_all, "name" => "Hoto"),
	array("y" => $toti_share_all, "name" => "Toti"),
	array("y" => $hank_share_all, "name" => "Hank")
    );
    //SHELVES    
    $category_total_share_shelf = array(
	array("y" => $hoto_share_shelves, "name" => "Hoto"),
	array("y" => $toti_share_shelves, "name" => "Toti"),
	array("y" => $hank_share_shelves, "name" => "Hank")
    );
        
    //PALLETS
    if ($total_pallets_all > 0) { 
    $category_total_share_pallet = array(
	array("y" => $hoto_share_pallet, "name" => "Hoto"),
	array("y" => $toti_share_pallet, "name" => "Toti"),
	array("y" => $hank_share_pallet, "name" => "Hank")
    );
    } else {
        echo '<h1 class="menu-item-orange"> Not enough data to calculate pallet category share </h1>';
    }
    }else {
        echo '<h1 class="menu-item-orange"> Not enough data to calculate category share </h1>';
    }
        
    //old code
    $producer_percent = $ruokakesko + $mt + $sca + $kimberly + $majesta + $horizon + $srl + $shs;
    
    //used to check if there any products for producers then runs code if positive
    if ($producer_percent > 0) {
    $ruokakesko = round(($ruokakesko / $producer_percent * 100),2);
    $mt = round(($mt / $producer_percent * 100),2); // MT TOTAL FAIRSHARE
    $sca = round(($sca / $producer_percent * 100),2);
    $kimberly = round(($kimberly / $producer_percent * 100),2);
    $majesta = round(($majesta / $producer_percent * 100),2);
    $horizon = round(($horizon / $producer_percent * 100),2);
    $srl = round(($srl / $producer_percent * 100),2);
    $shs = round(($shs / $producer_percent * 100),2);
        
    //producer share from total area with shelf and pallet    
    $ruokakesko_sq = round(($ruokakesko_sq / $hotototihank_sq * 100),2);
    $mt_sq = round(($mt_sq / $hotototihank_sq * 100),2); // MT TOTAL FAIRSHARE
    $sca_sq = round(($sca_sq / $hotototihank_sq * 100),2);
    $kimberly_sq = round(($kimberly_sq / $hotototihank_sq * 100),2);
    $majesta_sq = round(($majesta_sq / $hotototihank_sq * 100),2);
    $horizon_sq = round(($horizon_sq / $hotototihank_sq * 100),2);
    $srl_sq = round(($srl_sq / $hotototihank_sq * 100),2);
    $shs_sq = round(($shs_sq / $hotototihank_sq * 100),2);
        
        
    //producer share from total area in shelves
    $ruokakesko_sq_shelf = round(($ruokakesko_sq_shelf / $total_shelf_sq_area * 100),2);
    $mt_sq_shelf = round(($mt_sq_shelf / $total_shelf_sq_area * 100),2); // MT TOTAL FAIRSHARE
    $sca_sq_shelf = round(($sca_sq_shelf / $total_shelf_sq_area * 100),2);
    $kimberly_sq_shelf = round(($kimberly_sq_shelf / $total_shelf_sq_area * 100),2);
    $majesta_sq_shelf = round(($majesta_sq_shelf / $total_shelf_sq_area * 100),2);
    $horizon_sq_shelf = round(($horizon_sq_shelf / $total_shelf_sq_area * 100),2);
    $srl_sq_shelf = round(($srl_sq_shelf / $total_shelf_sq_area * 100),2);
    $shs_sq_shelf = round(($shs_sq_shelf / $total_shelf_sq_area * 100),2);
        
    //producer share from total area in pallets
    $ruokakesko_sq_pallet = round(($ruokakesko_sq_pallet / $hotototihank_sq_pallet * 100),2);
    $mt_sq_pallet = round(($mt_sq_pallet / $hotototihank_sq_pallet * 100),2); // MT TOTAL FAIRSHARE
    $sca_sq_pallet = round(($sca_sq_pallet / $hotototihank_sq_pallet * 100),2);
    $kimberly_sq_pallet = round(($kimberly_sq_pallet / $hotototihank_sq_pallet * 100),2);
    $majesta_sq_pallet = round(($majesta_sq_pallet / $hotototihank_sq_pallet * 100),2);
    $horizon_sq_pallet = round(($horizon_sq_pallet / $hotototihank_sq_pallet * 100),2);
    $srl_sq_pallet = round(($srl_sq_pallet / $hotototihank_sq_pallet * 100),2);
    $shs_sq_pallet = round(($shs_sq_pallet / $hotototihank_sq_pallet * 100),2);
    
        }else {
        echo '<h1 class="menu-item-orange"> Not enough data to calculate producer share </h1>';
    }
    if ($mt < 100) {   
    $mt_total_fs = round($mt, 3); //old code
     }  else {
        echo '<h1 class="menu-item-orange"> Not enough data to calculate MT total fair share </h1>';
    }
        
    //LABEL SHARE MATH
        
    //FOR OLD FAIRSHARE CALCULATION
    $label_all = $kmenu_sq + $lambi_sq + $lotus_sq + $pirkka_sq + $serla_sq + $angrybirds_sq + $daisy_sq + $harmony_sq + $kleenex_sq + $majesta_sq + $nessu_sq;
        
    //TOTAL SHELF AREA CALCULATED WITH ADDING ALL LABEL AREA TOGETHER, SHELVES ONLY
    $label_all2 = $kmenu_sq_shelf + $lambi_sq_shelf + $lotus_sq_shelf + $pirkka_sq_shelf + $serla_sq_shelf + $angrybirds_sq_shelf + $daisy_sq_shelf + $harmony_sq_shelf + $kleenex_sq_shelf + $majesta_sq_shelf + $nessu_sq_shelf;
        
    //TOTAL PALLET AREA CALCULATED WITH ADDING ALL LABEL AREA TOGETHER
    $label_all3 = $kmenu_sq_pallet + $lambi_sq_pallet + $lotus_sq_pallet + $pirkka_sq_pallet + $serla_sq_pallet + $angrybirds_sq_pallet + $daisy_sq_pallet + $harmony_sq_pallet + $kleenex_sq_pallet + $majesta_sq_pallet + $nessu_sq_pallet;
        
    if ($label_all > 0)  {
    $kmenu_sq = round(($kmenu_sq / $label_all * 100),2);
    $lambi_sq = round(($lambi_sq / $label_all * 100),2);
    $lotus_sq = round(($lotus_sq / $label_all * 100),2);
    $pirkka_sq = round(($pirkka_sq / $label_all * 100),2);
    $serla_sq = round(($serla_sq / $label_all * 100),2);
    $angrybirds_sq = round(($angrybirds_sq / $label_all * 100),2);
    $daisy_sq = round(($daisy_sq / $label_all * 100),2);
    $harmony_sq = round(($harmony_sq / $label_all * 100),2);
    $kleenex_sq = round(($kleenex_sq / $label_all * 100),2);
    $majesta_sq = round(($majesta_sq / $label_all * 100),2);
    $nessu_sq = round(($nessu_sq / $label_all * 100),2);  
    } else {
        echo '<h1 class="menu-item-orange"> Not enough data to calculate total label share </h1>';
    }
    
    //CHECKING THAT THERE ARE PRODUCTS IN SHELVES AND THEN CALCULATING THE SHARE FOR EACH LABEL
    if ($label_all2 > 0) {
    $kmenu_sq_shelf = round(($kmenu_sq_shelf / $label_all2 * 100),2);
    $lambi_sq_shelf = round(($lambi_sq_shelf / $label_all2 * 100),2);
    $lotus_sq_shelf = round(($lotus_sq_shelf / $label_all2 * 100),2);
    $pirkka_sq_shelf = round(($pirkka_sq_shelf / $label_all2 * 100),2);
    $serla_sq_shelf = round(($serla_sq_shelf / $label_all2 * 100),2);
    $angrybirds_sq_shelf = round(($angrybirds_sq_shelf / $label_all2 * 100),2);
    $daisy_sq_shelf = round(($daisy_sq_shelf / $label_all2 * 100),2);
    $harmony_sq_shelf = round(($harmony_sq_shelf / $label_all2 * 100),2);
    $kleenex_sq_shelf = round(($kleenex_sq_shelf / $label_all2 * 100),2);
    $majesta_sq_shelf = round(($majesta_sq_shelf / $label_all2 * 100),2);
    $nessu_sq_shelf = round(($nessu_sq_shelf / $label_all2 * 100),2); 
    } else {
        echo '<h1 class="menu-item-orange"> Not enough data to calculate shelf label share </h1>';
    }
        
    //CHECKING THAT THERE ARE PRODUCTS IN THE PALLETS AND THEN CALCULATING THE SHARE FOR EACH LABEL
    if ($label_all3 > 0) {
    $kmenu_sq_pallet = round(($kmenu_sq_pallet / $label_all3 * 100),2);
    $lambi_sq_pallet = round(($lambi_sq_pallet / $label_all3 * 100),2);
    $lotus_sq_pallet = round(($lotus_sq_pallet / $label_all3 * 100),2);
    $pirkka_sq_pallet = round(($pirkka_sq_pallet / $label_all3 * 100),2);
    $serla_sq_pallet = round(($serla_sq_pallet / $label_all3 * 100),2);
    $angrybirds_sq_pallet = round(($angrybirds_sq_pallet / $label_all3 * 100),2);
    $daisy_sq_pallet = round(($daisy_sq_pallet / $label_all3 * 100),2);
    $harmony_sq_pallet = round(($harmony_sq_pallet / $label_all3 * 100),2);
    $kleenex_sq_pallet = round(($kleenex_sq_pallet / $label_all3 * 100),2);
    $majesta_sq_pallet = round(($majesta_sq_pallet / $label_all3 * 100),2);
    $nessu_sq_pallet = round(($nessu_sq_pallet / $label_all3 * 100),2);  
    } else {
        echo '<h1 class="menu-item-orange"> Not enough data to calculate pallet label share </h1>';
    }
      
    // LABEL CHART ARRAYS   
    
        
    //TOTAL AREA
    $label_share_array = array (
    array("y" => $kmenu_sq, "label" => "K-Menu"),
	array("y" => $lambi_sq, "label" => "Lambi"),
	array("y" => $lotus_sq, "label" => "Lotus"),
	array("y" => $pirkka_sq, "label" => "Pirkka"),
	array("y" => $serla_sq, "label" => "Serla"),
	array("y" => $angrybirds_sq, "label" => "Angry Birds"),
	array("y" => $daisy_sq, "label" => "Daisy"),
	array("y" => $harmony_sq, "label" => "Harmony"),
    array("y" => $kleenex_sq, "label" => "Kleenex"),
	array("y" => $majesta_sq, "label" => "Majesta"),
	array("y" => $nessu_sq, "label" => "Nessu")
    );
    //SHELF    
    $label_share_array_shelf = array (
    array("y" => $kmenu_sq_shelf, "label" => "K-Menu"),
	array("y" => $lambi_sq_shelf, "label" => "Lambi"),
	array("y" => $lotus_sq_shelf, "label" => "Lotus"),
	array("y" => $pirkka_sq_shelf, "label" => "Pirkka"),
	array("y" => $serla_sq_shelf, "label" => "Serla"),
	array("y" => $angrybirds_sq_shelf, "label" => "Angry Birds"),
	array("y" => $daisy_sq_shelf, "label" => "Daisy"),
	array("y" => $harmony_sq_shelf, "label" => "Harmony"),
    array("y" => $kleenex_sq_shelf, "label" => "Kleenex"),
	array("y" => $majesta_sq_shelf, "label" => "Majesta"),
	array("y" => $nessu_sq_shelf, "label" => "Nessu")
    );
    
    //PALLET AREA
    if ($total_pallets_all > 0) {
    $label_share_array_pallet = array (
    array("y" => $kmenu_sq_pallet, "label" => "K-Menu"),
	array("y" => $lambi_sq_pallet, "label" => "Lambi"),
	array("y" => $lotus_sq_pallet, "label" => "Lotus"),
	array("y" => $pirkka_sq_pallet, "label" => "Pirkka"),
	array("y" => $serla_sq_pallet, "label" => "Serla"),
	array("y" => $angrybirds_sq_pallet, "label" => "Angry Birds"),
	array("y" => $daisy_sq_pallet, "label" => "Daisy"),
	array("y" => $harmony_sq_pallet, "label" => "Harmony"),
    array("y" => $kleenex_sq_pallet, "label" => "Kleenex"),
	array("y" => $majesta_sq_pallet, "label" => "Majesta"),
	array("y" => $nessu_sq_pallet, "label" => "Nessu")
    );
    }
    
    ////////////// ARRAYS FOR PRODUCER PIE    
        
    $producer_total_share = array(
	array("y" => $ruokakesko_sq, "name" => "Ruokakesko Oy"),
	array("y" => $mt_sq, "name" => "Metsä Tissue"),
    array("y" => $sca_sq, "name" => "SCA"),
	array("y" => $kimberly_sq, "name" => "Kimberly-Clark"),
    array("y" => $majesta_sq, "name" => "Majesta"),
    array("y" => $horizon_sq, "name" => "Horizon Tissue"),
	array("y" => $srl_sq, "name" => "World Cart SRL"),
	array("y" => $shs_sq, "name" => "SHS Harmanec")
    );
        
    $producer_total_share_shelf = array(
	array("y" => $ruokakesko_sq_shelf, "name" => "Ruokakesko Oy"),
	array("y" => $mt_sq_shelf, "name" => "Metsä Tissue"),
    array("y" => $sca_sq_shelf, "name" => "SCA"),
	array("y" => $kimberly_sq_shelf, "name" => "Kimberly-Clark"),
    array("y" => $majesta_sq_shelf, "name" => "Majesta"),
    array("y" => $horizon_sq_shelf, "name" => "Horizon Tissue"),
	array("y" => $srl_sq_shelf, "name" => "World Cart SRL"),
	array("y" => $shs_sq_shelf, "name" => "SHS Harmanec")
    );
    if ($total_pallets_all > 0) {    
    $producer_total_share_pallet = array(
	array("y" => $ruokakesko_sq_pallet, "name" => "Ruokakesko Oy"),
	array("y" => $mt_sq_pallet, "name" => "Metsä Tissue"),
    array("y" => $sca_sq_pallet, "name" => "SCA"),
	array("y" => $kimberly_sq_pallet, "name" => "Kimberly-Clark"),
    array("y" => $majesta_sq_pallet, "name" => "Majesta"),
    array("y" => $horizon_sq_pallet, "name" => "Horizon Tissue"),
	array("y" => $srl_sq_pallet, "name" => "World Cart SRL"),
	array("y" => $shs_sq_pallet, "name" => "SHS Harmanec")
    );
    } else {
         echo '<h1 class="menu-item-orange"> Not enough data to calculate pallet producer share </h1>';
    }
    //print_r($category_total_share);    
    // CATEGORY SHARE CODE ENDS
    } else {
        echo '<h1 class="menu-item-orange"> No products in the report </h1>';
    }
        
    echo '<div class="fairshare-container">';
    echo '<h2>Total Fairshare</h2>';
    echo '<h1>' . $mt_pallet_shelf_total . '%</h1>'; // ECHOES THE TOTAL FAIRSHARE FOR METSÄ
    echo '<h2>Shelf Fairshare</h2>';
    echo '<h1>' . $mt_shelf_sq_fairshare . '%</h1>'; // ECHOES SHELF FAIRSHARE FOR METSÄ
    echo '<h2>Pallet Fairshare</h2>';
    echo '<h1>' . $mt_pallet_fairshare_total . '%</h1>'; // ECHOES PALLET FAIRSHARE FOR METSÄ
    echo '</div>';
    echo '<h1 class="product-store-name">Total Fairshare statistics</h1>';
    echo '<div class="fairshare-container">';
    echo '<h2>MT Share of categories</h2>';
    echo '<p>HOTO</p>';
    echo '<p>TOTI</p>';
    echo '<p>HANK</p>';
    echo '<h3>' .  $mt_shelf_pallet_hoto . '%</h3>'; //METSÄ TOTAL FAIRSHARE FOR HOTO
    echo '<h3>' .  $mt_shelf_pallet_toti . '%</h3>'; //METSÄ TOTAL FAIRSHARE FOR TOTI
    echo '<h3>' .  $mt_shelf_pallet_hank . '%</h3>'; //METSÄ TOTAL FAIRSHARE FOR HANK
    echo '</div>';
 
?>
        

<!-- CONTAINERS FOR JAVASCRIPT STATS -->
<div class="reportcontainer">
<div id="chartContainer"></div>
</div>
 <div class="reportcontainer">       
<div id="chartContainer2"></div>
</div>
 <div class="reportcontainer">       
<div id="chartContainer3"></div>
</div>
<?php
    // ECHOES FAIRSHARE STATISTICS FOR SHELVES
    echo '<h1 class="product-store-name">Shelf Fairshare statistics</h1>';
    echo '<div class="fairshare-container">';
    echo '<h2>MT Share in categories</h2>';
    echo '<p>HOTO</p>';
    echo '<p>TOTI</p>';
    echo '<p>HANK</p>';
    echo '<h3>' . $mt_shelf_only_hoto . '%</h3>';
    echo '<h3>' . $mt_shelf_only_toti . '%</h3>';
    echo '<h3>' . $mt_shelf_only_hank . '%</h3>';
    echo '</div>';
?>
<!-- CONTAINERS FOR JAVASCRIPT STATS -->
<div class="reportcontainer">
<div id="chartContainer_shelf_category"></div>
</div>
 <div class="reportcontainer">       
<div id="chartContainer_shelf_producer"></div>
</div>
 <div class="reportcontainer">       
<div id="chartContainer_shelf_label"></div>
</div>
        
<?php
    // ECHOES FAIRSHARE STATISTICS FOR PALLETS
    echo '<h1 class="product-store-name">Pallet Fairshare statistics</h1>';
    echo '<div class="fairshare-container">';
    echo '<h2>MT Share in categories</h2>';
    echo '<p>HOTO</p>';
    echo '<p>TOTI</p>';
    echo '<p>HANK</p>';
    echo '<h3>' . $mt_pallet_only_hoto . '%</h3>';
    echo '<h3>' . $mt_pallet_only_toti . '%</h3>';
    echo '<h3>' . $mt_pallet_only_hank . '%</h3>';
    echo '</div>';
?>
 <!-- CONTAINERS FOR JAVASCRIPT STATS -->       
<div class="reportcontainer">
<div id="chartContainer_pallet_category"></div>
</div>
 <div class="reportcontainer">       
<div id="chartContainer_pallet_producer"></div>
</div>
 <div class="reportcontainer">       
<div id="chartContainer_pallet_label"></div>
</div>

        
<?php
 ///////                REALOGRAM //////////
 ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////       
        
// THE REALOGRAM    
    
//the whole realogram works in a way that we search all users inputs in the order they are in the database. 
//If there are points on the shelf number 1 it makes a box based on the % size of the box and the total shelf width. 
//this is then repeated for all shelves from 1 to 5
//In order to make the shelf look right the user has to start from left 
//the order which user can do the input has to be shelf first and then pallets
//the order how shelf can be inputted is from bottom to top or from top to bottom or row by row. 
//The realogram doesn't understand that product can be on multiple places in the shelf as we only make 1 database input per product
    
$empty_space_shelf1 = 0;
$empty_space_shelf2 = 0;
$empty_space_shelf3 = 0;
$empty_space_shelf4 = 0;
$empty_space_shelf5 = 0;
    
// $id_report = 2; this id was only for testing purposes, the report id will be inputted dynamically from the previous page to final report.
    
$get_storeid = $wpdb->get_results("SELECT * FROM reports WHERE id_report = ".$id_report."");
foreach ($get_storeid as $storeid) {
    $id_store = $storeid->id_store;


$get_settingsid = $wpdb->get_results("SELECT * FROM store WHERE id_store = ".$id_store."");
foreach ($get_settingsid as $settingsid) {
    $id_store_settings = $settingsid->id_store_settings;

    
$get_shelf_info = $wpdb->get_results("SELECT * FROM store_settings WHERE id_store_settings = ".$id_store_settings."");
foreach ($get_shelf_info as $shelf_info) {
    $shelfwidth = $shelf_info->paper_width;
    $shelfsegments = $shelf_info->paper_segments;
    $shelfshelves = $shelf_info->paper_shelf_count;
    $shelfheight1 = $shelf_info->paper_height1;
    $shelfheight2 = $shelf_info->paper_height2;
    $shelfheight3 = $shelf_info->paper_height3;
    $shelfheight4 = $shelf_info->paper_height4;
    $shelfheight5 = $shelf_info->paper_height5;
    
    
    //Easy fix to make tables smaller
    $shelfheight1_table = $shelf_info->paper_height1 / 3;
    $shelfheight2_table = $shelf_info->paper_height2 / 3;
    $shelfheight3_table = $shelf_info->paper_height3 / 3;
    $shelfheight4_table = $shelf_info->paper_height4 / 3;
    $shelfheight5_table = $shelf_info->paper_height5 / 3;
    
    $totalwidth = $shelfwidth * $shelfsegments;
    $totalwidth_table = $shelfwidth * $shelfsegments / 4; //to make the table width smaller for easier visuals
    echo '<div class="realogram-box">';
    switch($shelfshelves) {
        case 0:
            echo '<h1 class="product-store-name"> No shelves in settings to create a realogram </h1>'; //if no shelves in the store displays this message as an error
            break;
        case 1:
            // SHELF 1 REALOGRAM
            echo '<table style="width:'.$totalwidth_table.'px;height:'.$shelfheight1_table.'px;">'; // echoing the table start
            echo '<tr>'; //start of top shelf
            //echo '<td style="width:'.$totalwidth.'px;height:'.$shelfheight3.'px;"></td>'; //column of top shelf
            $get_report = $wpdb->get_results("SELECT * FROM points WHERE id_report =".$id_report."");
            //echo '<table>';
            //echo '<tr>';
            foreach ($get_report as $realogram) {
                $category = $realogram->id_category;
                $points_empty = $realogram->empty_points;
                if ($category == 1 or $category == 2 or $category == 4) {
                $id_product = $realogram->id_product;
                    
                    
                $shelf1_points = $realogram->shelf1_points; //CHANGE THIS DEPENDING ON SHELF
                    
                    
                if ($shelf1_points > 0) {
                    $product_info = $wpdb->get_results("SELECT * FROM product WHERE id_product =".$id_product."");
                    foreach ($product_info as $info) {
                        $name_p = $info->name_product;
                        $width_p = $info->width_product;
                        $height_p = $info->height_product;
                       
                        //Calculate how many go on top of each other
                        if ($height_p > 0) {
                        $height_count = floor($shelfheight1 / $height_p);
                        }
                        if ($height_count > 0) {
                        $width_count = $shelf1_points / $height_count;
                        }
                        
                        $total_height = $height_count * $height_p;
                        $total_width_p = $width_count * $width_p;
                        
                        if ($totalwidth > 0) {
                        $width_percent = $total_width_p / $totalwidth * 100;
                        }
                        $rounded_width = round($width_percent, 2);
                        $empty_space_shelf1 = $empty_space_td + $width_percent;
                        if ($category == 1 and $points_empty == 0 ) { //HOTO GREEN
                        echo '<td style="width:'.$width_percent.'%;height:'.$product_td_height.'px;border: 1px solid black;background-color:white;table-layout:fixed;background-color:#aee892;">'.$name_p.' -     Faces  '. $shelf1_points.' -  Space  ' . $rounded_width.'%</td>';
                        } elseif ($category == 2 and $points_empty == 0) { //TOTI CYAN
                            echo '<td style="width:'.$width_percent.'%;height:'.$product_td_height.'px;border: 1px solid black;background-color:white;table-layout:fixed;background-color:#a2e9ef;">'.$name_p.' -     Faces ' . $shelf1_points.' -  Space  ' . $rounded_width.'%</td>';
                        } elseif ($points_empty == 1) {
                        echo '<td style="width:'.$width_percent.'%;height:'.$product_td_height.'px;border: 1px solid black;background-color:white;table-layout:fixed;background-color:#ff6442;"> Out of stock - '.$name_p.' -     Faces ' . $shelf1_points.' -  Space  ' . $rounded_width.'%</td>';    
                        }else { //placeholders orange
                            echo '<td style="width:'.$width_percent.'%;height:'.$product_td_height.'px;border: 1px solid black;background-color:white;table-layout:fixed;background-color:#ffab51;">'.$name_p.' -     Faces ' . $shelf1_points.' -  Space  ' . $rounded_width.'%</td>';
                        }
                        
                    }
                }
                    }
            }
            
            //empty space td
            
            $empty_space_shelf1 = 100 - $empty_space_shelf1;
            echo '<td style="width:'.$empty_space_shelf1.'%;height:100%;border: 1px solid black;background-color:white;table-layout:fixed;">Empty</td>';
            //echo '</table>';
            //echo '</tr>';
            //echo '</td>'; //end of top shelf column
            echo '</tr>'; //end of top shelf
            echo '</table>';
            
            // SHELF 1 REALOGRAM
            break;
        case 2:
            // SHELF 2 REALOGRAM
            echo '<table style="width:'.$totalwidth_table.'px;height:'.$shelfheight2_table.'px;">'; // echoing the table start
            echo '<tr>'; //start of top shelf
            //echo '<td style="width:'.$totalwidth.'px;height:'.$shelfheight3.'px;"></td>'; //column of top shelf
            $get_report = $wpdb->get_results("SELECT * FROM points WHERE id_report =".$id_report."");
            //echo '<table>';
            //echo '<tr>';
            foreach ($get_report as $realogram) {
                $category = $realogram->id_category;
                $points_empty = $realogram->empty_points;
                if ($category == 1 or $category == 2 or $category == 4) {
                $id_product = $realogram->id_product;
                $shelf2_points = $realogram->shelf2_points;
                if ($shelf2_points > 0) {
                    $product_info = $wpdb->get_results("SELECT * FROM product WHERE id_product =".$id_product."");
                    foreach ($product_info as $info) {
                        $name_p = $info->name_product;
                        $width_p = $info->width_product;
                        $height_p = $info->height_product;
                       
                        //Calculate how many go on top of each other
                        if ($height_p > 0) {
                        $height_count = floor($shelfheight2 / $height_p);
                        }
                        if ($height_count > 0) {
                        $width_count = $shelf2_points / $height_count;
                        }
                        
                        $total_height = $height_count * $height_p;
                        $total_width_p = $width_count * $width_p;
                        
                        if ($totalwidth > 0) {
                        $width_percent = $total_width_p / $totalwidth * 100;
                        }
                        $rounded_width = round($width_percent, 2);
                        $empty_space_shelf2 = $empty_space_td + $width_percent;
                        if ($category == 1 and $points_empty == 0 ) { //HOTO GREEN
                        echo '<td style="width:'.$width_percent.'%;height:'.$product_td_height.'px;border: 1px solid black;background-color:white;table-layout:fixed;background-color:#aee892;">'.$name_p.' -     Faces  '. $shelf2_points.' -  Space  ' . $rounded_width.'%</td>';
                        } elseif ($category == 2 and $points_empty == 0) { //TOTI CYAN
                            echo '<td style="width:'.$width_percent.'%;height:'.$product_td_height.'px;border: 1px solid black;background-color:white;table-layout:fixed;background-color:#a2e9ef;">'.$name_p.' -     Faces ' . $shelf2_points.' -  Space  ' . $rounded_width.'%</td>';
                        } elseif ($points_empty == 1) {
                        echo '<td style="width:'.$width_percent.'%;height:'.$product_td_height.'px;border: 1px solid black;background-color:white;table-layout:fixed;background-color:#ff6442;"> Out of stock - '.$name_p.' -     Faces ' . $shelf2_points.' -  Space  ' . $rounded_width.'%</td>';    
                        }else { //placeholders orange
                            echo '<td style="width:'.$width_percent.'%;height:'.$product_td_height.'px;border: 1px solid black;background-color:white;table-layout:fixed;background-color:#ffab51;">'.$name_p.' -     Faces ' . $shelf2_points.' -  Space  ' . $rounded_width.'%</td>';
                        }
                        
                    }
                }
                    }
            }
            
            //empty space td
            
            $empty_space_shelf2 = 100 - $empty_space_shelf2;
            echo '<td style="width:'.$empty_space_shelf2.'%;height:100%;border: 1px solid black;background-color:white;table-layout:fixed;">Empty</td>';
            //echo '</table>';
            //echo '</tr>';
            //echo '</td>'; //end of top shelf column
            echo '</tr>'; //end of top shelf
            echo '</table>';
            
            // SHELF 2 REALOGRAM
            
            
            
            // SHELF 1 REALOGRAM
            echo '<table style="width:'.$totalwidth_table.'px;height:'.$shelfheight1_table.'px;">'; // echoing the table start
            echo '<tr>'; //start of top shelf
            //echo '<td style="width:'.$totalwidth.'px;height:'.$shelfheight3.'px;"></td>'; //column of top shelf
            $get_report = $wpdb->get_results("SELECT * FROM points WHERE id_report =".$id_report."");
            //echo '<table>';
            //echo '<tr>';
            foreach ($get_report as $realogram) {
                $category = $realogram->id_category;
                $points_empty = $realogram->empty_points;
                if ($category == 1 or $category == 2 or $category == 4) {
                $id_product = $realogram->id_product;
                    
                    
                $shelf1_points = $realogram->shelf1_points; //CHANGE THIS DEPENDING ON SHELF
                    
                    
                if ($shelf1_points > 0) {
                    $product_info = $wpdb->get_results("SELECT * FROM product WHERE id_product =".$id_product."");
                    foreach ($product_info as $info) {
                        $name_p = $info->name_product;
                        $width_p = $info->width_product;
                        $height_p = $info->height_product;
                       
                        //Calculate how many go on top of each other
                        if ($height_p > 0) {
                        $height_count = floor($shelfheight1 / $height_p);
                        }
                        if ($height_count > 0) {
                        $width_count = $shelf1_points / $height_count;
                        }
                        
                        $total_height = $height_count * $height_p;
                        $total_width_p = $width_count * $width_p;
                        
                        if ($totalwidth > 0) {
                        $width_percent = $total_width_p / $totalwidth * 100;
                        }
                        $rounded_width = round($width_percent, 2);
                        $empty_space_shelf1 = $empty_space_td + $width_percent;
                        if ($category == 1 and $points_empty == 0 ) { //HOTO GREEN
                        echo '<td style="width:'.$width_percent.'%;height:'.$product_td_height.'px;border: 1px solid black;background-color:white;table-layout:fixed;background-color:#aee892;">'.$name_p.' -     Faces  '. $shelf1_points.' -  Space  ' . $rounded_width.'%</td>';
                        } elseif ($category == 2 and $points_empty == 0) { //TOTI CYAN
                            echo '<td style="width:'.$width_percent.'%;height:'.$product_td_height.'px;border: 1px solid black;background-color:white;table-layout:fixed;background-color:#a2e9ef;">'.$name_p.' -     Faces ' . $shelf1_points.' -  Space  ' . $rounded_width.'%</td>';
                        } elseif ($points_empty == 1) {
                        echo '<td style="width:'.$width_percent.'%;height:'.$product_td_height.'px;border: 1px solid black;background-color:white;table-layout:fixed;background-color:#ff6442;"> Out of stock - '.$name_p.' -     Faces ' . $shelf1_points.' -  Space  ' . $rounded_width.'%</td>';    
                        }else { //placeholders orange
                            echo '<td style="width:'.$width_percent.'%;height:'.$product_td_height.'px;border: 1px solid black;background-color:white;table-layout:fixed;background-color:#ffab51;">'.$name_p.' -     Faces ' . $shelf1_points.' -  Space  ' . $rounded_width.'%</td>';
                        }
                        
                    }
                }
                    }
            }
            
            //empty space td
            
            $empty_space_shelf1 = 100 - $empty_space_shelf1;
            echo '<td style="width:'.$empty_space_shelf1.'%;height:100%;border: 1px solid black;background-color:white;table-layout:fixed;">Empty</td>';
            //echo '</table>';
            //echo '</tr>';
            //echo '</td>'; //end of top shelf column
            echo '</tr>'; //end of top shelf
            echo '</table>';
            
            // SHELF 1 REALOGRAM
            break;
        case 3:
            
            // SHELF 3 REALOGRAM
            echo '<table style="width:'.$totalwidth_table.'px;height:'.$shelfheight3_table.'px;">'; // echoing the table start
            echo '<tr>'; //start of top shelf
            //echo '<td style="width:'.$totalwidth.'px;height:'.$shelfheight3.'px;"></td>'; //column of top shelf
            $get_report = $wpdb->get_results("SELECT * FROM points WHERE id_report =".$id_report."");
            //echo '<table>';
            //echo '<tr>';
            foreach ($get_report as $realogram) {
                $category = $realogram->id_category;
                $points_empty = $realogram->empty_points;
                if ($category == 1 or $category == 2 or $category == 4) {
                $id_product = $realogram->id_product;
                $shelf3_points = $realogram->shelf3_points;
                if ($shelf3_points > 0) {
                    $product_info = $wpdb->get_results("SELECT * FROM product WHERE id_product =".$id_product."");
                    foreach ($product_info as $info) {
                        $name_p = $info->name_product;
                        $width_p = $info->width_product;
                        $height_p = $info->height_product;
                       
                        //Calculate how many go on top of each other
                        if ($height_p > 0) {
                        $height_count = floor($shelfheight3 / $height_p);
                        }
                        if ($height_count > 0) {
                        $width_count = $shelf3_points / $height_count;
                        }
                        
                        $total_height = $height_count * $height_p;
                        $total_width_p = $width_count * $width_p;
                        
                        if ($totalwidth > 0) {
                        $width_percent = $total_width_p / $totalwidth * 100;
                        }
                        $rounded_width = round($width_percent, 2);
                        $empty_space_shelf3 = $empty_space_td + $width_percent;
                        
                        if ($category == 1 and $points_empty == 0 ) { //HOTO GREEN
                        echo '<td style="width:'.$width_percent.'%;height:'.$product_td_height.'px;border: 1px solid black;background-color:white;table-layout:fixed;background-color:#aee892;">'.$name_p.' -     Faces  '. $shelf3_points.' -  Space  ' . $rounded_width.'%</td>';
                        } elseif ($category == 2 and $points_empty == 0) { //TOTI CYAN
                            echo '<td style="width:'.$width_percent.'%;height:'.$product_td_height.'px;border: 1px solid black;background-color:white;table-layout:fixed;background-color:#a2e9ef;">'.$name_p.' -     Faces ' . $shelf3_points.' -  Space  ' . $rounded_width.'%</td>';
                        } elseif ($points_empty == 1) {
                        echo '<td style="width:'.$width_percent.'%;height:'.$product_td_height.'px;border: 1px solid black;background-color:white;table-layout:fixed;background-color:#ff6442;"> Out of stock - '.$name_p.' -     Faces ' . $shelf3_points.' -  Space  ' . $rounded_width.'%</td>';    
                        }else { //placeholders orange
                            echo '<td style="width:'.$width_percent.'%;height:'.$product_td_height.'px;border: 1px solid black;background-color:white;table-layout:fixed;background-color:#ffab51;">'.$name_p.' -     Faces ' . $shelf3_points.' -  Space  ' . $rounded_width.'%</td>';
                        }
                        
                    }
                }
                    }
            }
            
            //empty space td
            
            $empty_space_shelf3 = 100 - $empty_space_shelf3;
            echo '<td style="width:'.$empty_space_shelf3.'%;height:100%;border: 1px solid black;background-color:white;table-layout:fixed;">Empty</td>';
            //echo '</table>';
            //echo '</tr>';
            //echo '</td>'; //end of top shelf column
            echo '</tr>'; //end of top shelf
            echo '</table>';
            
            // SHELF 3 REALOGRAM
            
            
            
            
            // SHELF 2 REALOGRAM
            echo '<table style="width:'.$totalwidth_table.'px;height:'.$shelfheight2_table.'px;">'; // echoing the table start
            echo '<tr>'; //start of top shelf
            //echo '<td style="width:'.$totalwidth.'px;height:'.$shelfheight3.'px;"></td>'; //column of top shelf
            $get_report = $wpdb->get_results("SELECT * FROM points WHERE id_report =".$id_report."");
            //echo '<table>';
            //echo '<tr>';
            foreach ($get_report as $realogram) {
                $category = $realogram->id_category;
                $points_empty = $realogram->empty_points;
                if ($category == 1 or $category == 2 or $category == 4) {
                $id_product = $realogram->id_product;
                $shelf2_points = $realogram->shelf2_points;
                if ($shelf2_points > 0) {
                    $product_info = $wpdb->get_results("SELECT * FROM product WHERE id_product =".$id_product."");
                    foreach ($product_info as $info) {
                        $name_p = $info->name_product;
                        $width_p = $info->width_product;
                        $height_p = $info->height_product;
                       
                        //Calculate how many go on top of each other
                        if ($height_p > 0) {
                        $height_count = floor($shelfheight2 / $height_p);
                        }
                        if ($height_count > 0) {
                        $width_count = $shelf2_points / $height_count;
                        }
                        
                        $total_height = $height_count * $height_p;
                        $total_width_p = $width_count * $width_p;
                        
                        if ($totalwidth > 0) {
                        $width_percent = $total_width_p / $totalwidth * 100;
                        }
                        $rounded_width = round($width_percent, 2);
                        $empty_space_shelf2 = $empty_space_td + $width_percent;
                        if ($category == 1 and $points_empty == 0 ) { //HOTO GREEN
                        echo '<td style="width:'.$width_percent.'%;height:'.$product_td_height.'px;border: 1px solid black;background-color:white;table-layout:fixed;background-color:#aee892;">'.$name_p.' -     Faces  '. $shelf2_points.' -  Space  ' . $rounded_width.'%</td>';
                        } elseif ($category == 2 and $points_empty == 0) { //TOTI CYAN
                            echo '<td style="width:'.$width_percent.'%;height:'.$product_td_height.'px;border: 1px solid black;background-color:white;table-layout:fixed;background-color:#a2e9ef;">'.$name_p.' -     Faces ' . $shelf2_points.' -  Space  ' . $rounded_width.'%</td>';
                        } elseif ($points_empty == 1) {
                        echo '<td style="width:'.$width_percent.'%;height:'.$product_td_height.'px;border: 1px solid black;background-color:white;table-layout:fixed;background-color:#ff6442;"> Out of stock - '.$name_p.' -     Faces ' . $shelf2_points.' -  Space  ' . $rounded_width.'%</td>';    
                        }else { //placeholders orange
                            echo '<td style="width:'.$width_percent.'%;height:'.$product_td_height.'px;border: 1px solid black;background-color:white;table-layout:fixed;background-color:#ffab51;">'.$name_p.' -     Faces ' . $shelf2_points.' -  Space  ' . $rounded_width.'%</td>';
                        }
                        
                    }
                }
                    }
            }
            
            //empty space td
            
            $empty_space_shelf2 = 100 - $empty_space_shelf2;
            echo '<td style="width:'.$empty_space_shelf2.'%;height:100%;border: 1px solid black;background-color:white;table-layout:fixed;">Empty</td>';
            //echo '</table>';
            //echo '</tr>';
            //echo '</td>'; //end of top shelf column
            echo '</tr>'; //end of top shelf
            echo '</table>';
            
            // SHELF 2 REALOGRAM
            
            
            
            // SHELF 1 REALOGRAM
            echo '<table style="width:'.$totalwidth_table.'px;height:'.$shelfheight1_table.'px;">'; // echoing the table start
            echo '<tr>'; //start of top shelf
            //echo '<td style="width:'.$totalwidth.'px;height:'.$shelfheight3.'px;"></td>'; //column of top shelf
            $get_report = $wpdb->get_results("SELECT * FROM points WHERE id_report =".$id_report."");
            //echo '<table>';
            //echo '<tr>';
            foreach ($get_report as $realogram) {
                $category = $realogram->id_category;
                $points_empty = $realogram->empty_points;
                if ($category == 1 or $category == 2 or $category == 4) {
                $id_product = $realogram->id_product;
                    
                    
                $shelf1_points = $realogram->shelf1_points; //CHANGE THIS DEPENDING ON SHELF
                    
                    
                if ($shelf1_points > 0) {
                    $product_info = $wpdb->get_results("SELECT * FROM product WHERE id_product =".$id_product."");
                    foreach ($product_info as $info) {
                        $name_p = $info->name_product;
                        $width_p = $info->width_product;
                        $height_p = $info->height_product;
                       
                        //Calculate how many go on top of each other
                        if ($height_p > 0) {
                        $height_count = floor($shelfheight1 / $height_p);
                        }
                        if ($height_count > 0) {
                        $width_count = $shelf1_points / $height_count;
                        }
                        
                        $total_height = $height_count * $height_p;
                        $total_width_p = $width_count * $width_p;
                        
                        if ($totalwidth > 0) {
                        $width_percent = $total_width_p / $totalwidth * 100;
                        }
                        $rounded_width = round($width_percent, 2);
                        $empty_space_shelf1 = $empty_space_td + $width_percent;
                        if ($category == 1 and $points_empty == 0 ) { //HOTO GREEN
                        echo '<td style="width:'.$width_percent.'%;height:'.$product_td_height.'px;border: 1px solid black;background-color:white;table-layout:fixed;background-color:#aee892;">'.$name_p.' -     Faces  '. $shelf1_points.' -  Space  ' . $rounded_width.'%</td>';
                        } elseif ($category == 2 and $points_empty == 0) { //TOTI CYAN
                            echo '<td style="width:'.$width_percent.'%;height:'.$product_td_height.'px;border: 1px solid black;background-color:white;table-layout:fixed;background-color:#a2e9ef;">'.$name_p.' -     Faces ' . $shelf1_points.' -  Space  ' . $rounded_width.'%</td>';
                        } elseif ($points_empty == 1) {
                        echo '<td style="width:'.$width_percent.'%;height:'.$product_td_height.'px;border: 1px solid black;background-color:white;table-layout:fixed;background-color:#ff6442;"> Out of stock - '.$name_p.' -     Faces ' . $shelf1_points.' -  Space  ' . $rounded_width.'%</td>';    
                        }else { //placeholders orange
                            echo '<td style="width:'.$width_percent.'%;height:'.$product_td_height.'px;border: 1px solid black;background-color:white;table-layout:fixed;background-color:#ffab51;">'.$name_p.' -     Faces ' . $shelf1_points.' -  Space  ' . $rounded_width.'%</td>';
                        }
                        
                    }
                }
                    }
            }
            
            //empty space td
            
            $empty_space_shelf1 = 100 - $empty_space_shelf1;
            echo '<td style="width:'.$empty_space_shelf1.'%;height:100%;border: 1px solid black;background-color:white;table-layout:fixed;">Empty</td>';
            //echo '</table>';
            //echo '</tr>';
            //echo '</td>'; //end of top shelf column
            echo '</tr>'; //end of top shelf
            echo '</table>';
            
            // SHELF 1 REALOGRAM
            break;
        case 4:
            // SHELF 4 REALOGRAM
            echo '<table style="width:'.$totalwidth_table.'px;height:'.$shelfheight4_table.'px;">'; // echoing the table start
            echo '<tr>'; //start of top shelf
            //echo '<td style="width:'.$totalwidth.'px;height:'.$shelfheight3.'px;"></td>'; //column of top shelf
            $get_report = $wpdb->get_results("SELECT * FROM points WHERE id_report =".$id_report."");
            //echo '<table>';
            //echo '<tr>';
            foreach ($get_report as $realogram) {
                $category = $realogram->id_category;
                $points_empty = $realogram->empty_points;
                if ($category == 1 or $category == 2 or $category == 4) {
                $id_product = $realogram->id_product;
                $shelf4_points = $realogram->shelf4_points;
                if ($shelf4_points > 0) {
                    $product_info = $wpdb->get_results("SELECT * FROM product WHERE id_product =".$id_product."");
                    foreach ($product_info as $info) {
                        $name_p = $info->name_product;
                        $width_p = $info->width_product;
                        $height_p = $info->height_product;
                       
                        //Calculate how many go on top of each other
                        if ($height_p > 0) {
                        $height_count = floor($shelfheight4 / $height_p);
                        }
                        if ($height_count > 0) {
                        $width_count = $shelf4_points / $height_count;
                        }
                        
                        $total_height = $height_count * $height_p;
                        $total_width_p = $width_count * $width_p;
                        
                        if ($totalwidth > 0) {
                        $width_percent = $total_width_p / $totalwidth * 100;
                        }
                        $rounded_width = round($width_percent, 2);
                        $empty_space_shelf4 = $empty_space_td + $width_percent;
                        if ($category == 1 and $points_empty == 0 ) { //HOTO GREEN
                        echo '<td style="width:'.$width_percent.'%;height:'.$product_td_height.'px;border: 1px solid black;background-color:white;table-layout:fixed;background-color:#aee892;">'.$name_p.' -     Faces  '. $shelf4_points.' -  Space  ' . $rounded_width.'%</td>';
                        } elseif ($category == 2 and $points_empty == 0) { //TOTI CYAN
                            echo '<td style="width:'.$width_percent.'%;height:'.$product_td_height.'px;border: 1px solid black;background-color:white;table-layout:fixed;background-color:#a2e9ef;">'.$name_p.' -     Faces ' . $shelf4_points.' -  Space  ' . $rounded_width.'%</td>';
                        } elseif ($points_empty == 1) {
                        echo '<td style="width:'.$width_percent.'%;height:'.$product_td_height.'px;border: 1px solid black;background-color:white;table-layout:fixed;background-color:#ff6442;"> Out of stock - '.$name_p.' -     Faces ' . $shelf4_points.' -  Space  ' . $rounded_width.'%</td>';    
                        }else { //placeholders orange
                            echo '<td style="width:'.$width_percent.'%;height:'.$product_td_height.'px;border: 1px solid black;background-color:white;table-layout:fixed;background-color:#ffab51;">'.$name_p.' -     Faces ' . $shelf4_points.' -  Space  ' . $rounded_width.'%</td>';
                        }
                        
                    }
                }
                    }
            }
            
            //empty space td
            
            $empty_space_shelf4 = 100 - $empty_space_shelf4;
            echo '<td style="width:'.$empty_space_shelf4.'%;height:100%;border: 1px solid black;background-color:white;table-layout:fixed;">Empty</td>';
            //echo '</table>';
            //echo '</tr>';
            //echo '</td>'; //end of top shelf column
            echo '</tr>'; //end of top shelf
            echo '</table>';
            
            // SHELF 4 REALOGRAM
            
            
            
            // SHELF 3 REALOGRAM
            echo '<table style="width:'.$totalwidth_table.'px;height:'.$shelfheight3_table.'px;">'; // echoing the table start
            echo '<tr>'; //start of top shelf
            //echo '<td style="width:'.$totalwidth.'px;height:'.$shelfheight3.'px;"></td>'; //column of top shelf
            $get_report = $wpdb->get_results("SELECT * FROM points WHERE id_report =".$id_report."");
            //echo '<table>';
            //echo '<tr>';
            foreach ($get_report as $realogram) {
                $category = $realogram->id_category;
                $points_empty = $realogram->empty_points;
                if ($category == 1 or $category == 2 or $category == 4) {
                $id_product = $realogram->id_product;
                $shelf3_points = $realogram->shelf3_points;
                if ($shelf3_points > 0) {
                    $product_info = $wpdb->get_results("SELECT * FROM product WHERE id_product =".$id_product."");
                    foreach ($product_info as $info) {
                        $name_p = $info->name_product;
                        $width_p = $info->width_product;
                        $height_p = $info->height_product;
                       
                        //Calculate how many go on top of each other
                        if ($height_p > 0) {
                        $height_count = floor($shelfheight3 / $height_p);
                        }
                        if ($height_count > 0) {
                        $width_count = $shelf3_points / $height_count;
                        }
                        
                        $total_height = $height_count * $height_p;
                        $total_width_p = $width_count * $width_p;
                        
                        if ($totalwidth > 0) {
                        $width_percent = $total_width_p / $totalwidth * 100;
                        }
                        $rounded_width = round($width_percent, 2);
                        $empty_space_shelf3 = $empty_space_td + $width_percent;
                        if ($category == 1 and $points_empty == 0 ) { //HOTO GREEN
                        echo '<td style="width:'.$width_percent.'%;height:'.$product_td_height.'px;border: 1px solid black;background-color:white;table-layout:fixed;background-color:#aee892;">'.$name_p.' -     Faces  '. $shelf3_points.' -  Space  ' . $rounded_width.'%</td>';
                        } elseif ($category == 2 and $points_empty == 0) { //TOTI CYAN
                            echo '<td style="width:'.$width_percent.'%;height:'.$product_td_height.'px;border: 1px solid black;background-color:white;table-layout:fixed;background-color:#a2e9ef;">'.$name_p.' -     Faces ' . $shelf3_points.' -  Space  ' . $rounded_width.'%</td>';
                        } elseif ($points_empty == 1) {
                        echo '<td style="width:'.$width_percent.'%;height:'.$product_td_height.'px;border: 1px solid black;background-color:white;table-layout:fixed;background-color:#ff6442;"> Out of stock - '.$name_p.' -     Faces ' . $shelf3_points.' -  Space  ' . $rounded_width.'%</td>';    
                        }else { //placeholders orange
                            echo '<td style="width:'.$width_percent.'%;height:'.$product_td_height.'px;border: 1px solid black;background-color:white;table-layout:fixed;background-color:#ffab51;">'.$name_p.' -     Faces ' . $shelf3_points.' -  Space  ' . $rounded_width.'%</td>';
                        }
                        
                    }
                }
                    }
            }
            
            //empty space td
            
            $empty_space_shelf3 = 100 - $empty_space_shelf3;
            echo '<td style="width:'.$empty_space_shelf3.'%;height:100%;border: 1px solid black;background-color:white;table-layout:fixed;">Empty</td>';
            //echo '</table>';
            //echo '</tr>';
            //echo '</td>'; //end of top shelf column
            echo '</tr>'; //end of top shelf
            echo '</table>';
            
            // SHELF 3 REALOGRAM
            
            
            
            
            // SHELF 2 REALOGRAM
            echo '<table style="width:'.$totalwidth_table.'px;height:'.$shelfheight2_table.'px;">'; // echoing the table start
            echo '<tr>'; //start of top shelf
            //echo '<td style="width:'.$totalwidth.'px;height:'.$shelfheight3.'px;"></td>'; //column of top shelf
            $get_report = $wpdb->get_results("SELECT * FROM points WHERE id_report =".$id_report."");
            //echo '<table>';
            //echo '<tr>';
            foreach ($get_report as $realogram) {
                $category = $realogram->id_category;
                $points_empty = $realogram->empty_points;
                if ($category == 1 or $category == 2 or $category == 4) {
                $id_product = $realogram->id_product;
                $shelf2_points = $realogram->shelf2_points;
                if ($shelf2_points > 0) {
                    $product_info = $wpdb->get_results("SELECT * FROM product WHERE id_product =".$id_product."");
                    foreach ($product_info as $info) {
                        $name_p = $info->name_product;
                        $width_p = $info->width_product;
                        $height_p = $info->height_product;
                       
                        //Calculate how many go on top of each other
                        if ($height_p > 0) {
                        $height_count = floor($shelfheight2 / $height_p);
                        }
                        if ($height_count > 0) {
                        $width_count = $shelf2_points / $height_count;
                        }
                        
                        $total_height = $height_count * $height_p;
                        $total_width_p = $width_count * $width_p;
                        
                        if ($totalwidth > 0) {
                        $width_percent = $total_width_p / $totalwidth * 100;
                        }
                        $rounded_width = round($width_percent, 2);
                        $empty_space_shelf2 = $empty_space_td + $width_percent;
                        if ($category == 1 and $points_empty == 0 ) { //HOTO GREEN
                        echo '<td style="width:'.$width_percent.'%;height:'.$product_td_height.'px;border: 1px solid black;background-color:white;table-layout:fixed;background-color:#aee892;">'.$name_p.' -     Faces  '. $shelf2_points.' -  Space  ' . $rounded_width.'%</td>';
                        } elseif ($category == 2 and $points_empty == 0) { //TOTI CYAN
                            echo '<td style="width:'.$width_percent.'%;height:'.$product_td_height.'px;border: 1px solid black;background-color:white;table-layout:fixed;background-color:#a2e9ef;">'.$name_p.' -     Faces ' . $shelf2_points.' -  Space  ' . $rounded_width.'%</td>';
                        } elseif ($points_empty == 1) {
                        echo '<td style="width:'.$width_percent.'%;height:'.$product_td_height.'px;border: 1px solid black;background-color:white;table-layout:fixed;background-color:#ff6442;"> Out of stock - '.$name_p.' -     Faces ' . $shelf2_points.' -  Space  ' . $rounded_width.'%</td>';    
                        }else { //placeholders orange
                            echo '<td style="width:'.$width_percent.'%;height:'.$product_td_height.'px;border: 1px solid black;background-color:white;table-layout:fixed;background-color:#ffab51;">'.$name_p.' -     Faces ' . $shelf2_points.' -  Space  ' . $rounded_width.'%</td>';
                        }
                        
                    }
                }
                    }
            }
            
            //empty space td
            
            $empty_space_shelf2 = 100 - $empty_space_shelf2;
            echo '<td style="width:'.$empty_space_shelf2.'%;height:100%;border: 1px solid black;background-color:white;table-layout:fixed;">Empty</td>';
            //echo '</table>';
            //echo '</tr>';
            //echo '</td>'; //end of top shelf column
            echo '</tr>'; //end of top shelf
            echo '</table>';
            
            // SHELF 2 REALOGRAM
            
            
            
            // SHELF 1 REALOGRAM
            echo '<table style="width:'.$totalwidth_table.'px;height:'.$shelfheight1_table.'px;">'; // echoing the table start
            echo '<tr>'; //start of top shelf
            //echo '<td style="width:'.$totalwidth.'px;height:'.$shelfheight3.'px;"></td>'; //column of top shelf
            $get_report = $wpdb->get_results("SELECT * FROM points WHERE id_report =".$id_report."");
            //echo '<table>';
            //echo '<tr>';
            foreach ($get_report as $realogram) {
                $category = $realogram->id_category;
                $points_empty = $realogram->empty_points;
                if ($category == 1 or $category == 2 or $category == 4) {
                $id_product = $realogram->id_product;
                    
                    
                $shelf1_points = $realogram->shelf1_points; //CHANGE THIS DEPENDING ON SHELF
                    
                    
                if ($shelf1_points > 0) {
                    $product_info = $wpdb->get_results("SELECT * FROM product WHERE id_product =".$id_product."");
                    foreach ($product_info as $info) {
                        $name_p = $info->name_product;
                        $width_p = $info->width_product;
                        $height_p = $info->height_product;
                       
                        //Calculate how many go on top of each other
                        if ($height_p > 0) {
                        $height_count = floor($shelfheight1 / $height_p);
                        }
                        if ($height_count > 0) {
                        $width_count = $shelf1_points / $height_count;
                        }
                        
                        $total_height = $height_count * $height_p;
                        $total_width_p = $width_count * $width_p;
                        
                        if ($totalwidth > 0) {
                        $width_percent = $total_width_p / $totalwidth * 100;
                        }
                        $rounded_width = round($width_percent, 2);
                        $empty_space_shelf1 = $empty_space_td + $width_percent;
                        if ($category == 1 and $points_empty == 0 ) { //HOTO GREEN
                        echo '<td style="width:'.$width_percent.'%;height:'.$product_td_height.'px;border: 1px solid black;background-color:white;table-layout:fixed;background-color:#aee892;">'.$name_p.' -     Faces  '. $shelf1_points.' -  Space  ' . $rounded_width.'%</td>';
                        } elseif ($category == 2 and $points_empty == 0) { //TOTI CYAN
                            echo '<td style="width:'.$width_percent.'%;height:'.$product_td_height.'px;border: 1px solid black;background-color:white;table-layout:fixed;background-color:#a2e9ef;">'.$name_p.' -     Faces ' . $shelf1_points.' -  Space  ' . $rounded_width.'%</td>';
                        } elseif ($points_empty == 1) {
                        echo '<td style="width:'.$width_percent.'%;height:'.$product_td_height.'px;border: 1px solid black;background-color:white;table-layout:fixed;background-color:#ff6442;"> Out of stock - '.$name_p.' -     Faces ' . $shelf1_points.' -  Space  ' . $rounded_width.'%</td>';    
                        }else { //placeholders orange
                            echo '<td style="width:'.$width_percent.'%;height:'.$product_td_height.'px;border: 1px solid black;background-color:white;table-layout:fixed;background-color:#ffab51;">'.$name_p.' -     Faces ' . $shelf1_points.' -  Space  ' . $rounded_width.'%</td>';
                        }
                        
                    }
                }
                    }
            }
            
            //empty space td
            
            $empty_space_shelf1 = 100 - $empty_space_shelf1;
            echo '<td style="width:'.$empty_space_shelf1.'%;height:100%;border: 1px solid black;background-color:white;table-layout:fixed;">Empty</td>';
            //echo '</table>';
            //echo '</tr>';
            //echo '</td>'; //end of top shelf column
            echo '</tr>'; //end of top shelf
            echo '</table>';
            
            // SHELF 1 REALOGRAM
            break;
        case 5:
            // SHELF 5 REALOGRAM
            echo '<table style="width:'.$totalwidth_table.'px;height:'.$shelfheight5_table.'px;">'; // echoing the table start
            echo '<tr>'; //start of top shelf
            //echo '<td style="width:'.$totalwidth.'px;height:'.$shelfheight3.'px;"></td>'; //column of top shelf
            $get_report = $wpdb->get_results("SELECT * FROM points WHERE id_report =".$id_report."");
            //echo '<table>';
            //echo '<tr>';
            foreach ($get_report as $realogram) {
                $category = $realogram->id_category;
                $points_empty = $realogram->empty_points;
                if ($category == 1 or $category == 2 or $category == 4) {
                $id_product = $realogram->id_product;
                $shelf5_points = $realogram->shelf5_points;
                if ($shelf5_points > 0) {
                    $product_info = $wpdb->get_results("SELECT * FROM product WHERE id_product =".$id_product."");
                    foreach ($product_info as $info) {
                        $name_p = $info->name_product;
                        $width_p = $info->width_product;
                        $height_p = $info->height_product;
                       
                        //Calculate how many go on top of each other
                        if ($height_p > 0) {
                        $height_count = floor($shelfheight5 / $height_p);
                        }
                        if ($height_count > 0) {
                        $width_count = $shelf5_points / $height_count;
                        }
                        
                        $total_height = $height_count * $height_p;
                        $total_width_p = $width_count * $width_p;
                        
                        if ($totalwidth > 0) {
                        $width_percent = $total_width_p / $totalwidth * 100;
                        }
                        $rounded_width = round($width_percent, 2);
                        $empty_space_shelf5 = $empty_space_td + $width_percent;
                        if ($category == 1 and $points_empty == 0 ) { //HOTO GREEN
                        echo '<td style="width:'.$width_percent.'%;height:'.$product_td_height.'px;border: 1px solid black;background-color:white;table-layout:fixed;background-color:#aee892;">'.$name_p.' -     Faces  '. $shelf5_points.' -  Space  ' . $rounded_width.'%</td>';
                        } elseif ($category == 2 and $points_empty == 0) { //TOTI CYAN
                            echo '<td style="width:'.$width_percent.'%;height:'.$product_td_height.'px;border: 1px solid black;background-color:white;table-layout:fixed;background-color:#a2e9ef;">'.$name_p.' -     Faces ' . $shelf5_points.' -  Space  ' . $rounded_width.'%</td>';
                        } elseif ($points_empty == 1) {
                        echo '<td style="width:'.$width_percent.'%;height:'.$product_td_height.'px;border: 1px solid black;background-color:white;table-layout:fixed;background-color:#ff6442;"> Out of stock - '.$name_p.' -     Faces ' . $shelf5_points.' -  Space  ' . $rounded_width.'%</td>';    
                        }else { //placeholders orange
                            echo '<td style="width:'.$width_percent.'%;height:'.$product_td_height.'px;border: 1px solid black;background-color:white;table-layout:fixed;background-color:#ffab51;">'.$name_p.' -     Faces ' . $shelf5_points.' -  Space  ' . $rounded_width.'%</td>';
                        }
                        
                    }
                }
                    }
            }
            
            //empty space td
            //this is made because tables want to fill all of its width. But we can use this empty block to keep the product widths correct and display how much empty space there should/might be on the shelf
            $empty_space_shelf5 = 100 - $empty_space_shelf5;
            echo '<td style="width:'.$empty_space_shelf5.'%;height:100%;border: 1px solid black;background-color:white;table-layout:fixed;">Empty</td>';
            echo '</tr>'; //end of top shelf
            echo '</table>';
            
            // SHELF 5 REALOGRAM
            
            
            
            
            // SHELF 4 REALOGRAM
            echo '<table style="width:'.$totalwidth_table.'px;height:'.$shelfheight4_table.'px;">'; // echoing the table start
            echo '<tr>'; //start of top shelf
            //echo '<td style="width:'.$totalwidth.'px;height:'.$shelfheight3.'px;"></td>'; //column of top shelf
            $get_report = $wpdb->get_results("SELECT * FROM points WHERE id_report =".$id_report."");
            //echo '<table>';
            //echo '<tr>';
            foreach ($get_report as $realogram) {
                $category = $realogram->id_category;
                $points_empty = $realogram->empty_points;
                if ($category == 1 or $category == 2 or $category == 4) {
                $id_product = $realogram->id_product;
                $shelf4_points = $realogram->shelf4_points;
                if ($shelf4_points > 0) {
                    $product_info = $wpdb->get_results("SELECT * FROM product WHERE id_product =".$id_product."");
                    foreach ($product_info as $info) {
                        $name_p = $info->name_product;
                        $width_p = $info->width_product;
                        $height_p = $info->height_product;
                       
                        //Calculate how many go on top of each other
                        if ($height_p > 0) {
                        $height_count = floor($shelfheight4 / $height_p);
                        }
                        if ($height_count > 0) {
                        $width_count = $shelf4_points / $height_count;
                        }
                        
                        $total_height = $height_count * $height_p;
                        $total_width_p = $width_count * $width_p;
                        
                        if ($totalwidth > 0) {
                        $width_percent = $total_width_p / $totalwidth * 100;
                        }
                        $rounded_width = round($width_percent, 2);
                        $empty_space_shelf4 = $empty_space_td + $width_percent;
                        if ($category == 1 and $points_empty == 0 ) { //HOTO GREEN
                        echo '<td style="width:'.$width_percent.'%;height:'.$product_td_height.'px;border: 1px solid black;background-color:white;table-layout:fixed;background-color:#aee892;">'.$name_p.' -     Faces  '. $shelf4_points.' -  Space  ' . $rounded_width.'%</td>';
                        } elseif ($category == 2 and $points_empty == 0) { //TOTI CYAN
                            echo '<td style="width:'.$width_percent.'%;height:'.$product_td_height.'px;border: 1px solid black;background-color:white;table-layout:fixed;background-color:#a2e9ef;">'.$name_p.' -     Faces ' . $shelf4_points.' -  Space  ' . $rounded_width.'%</td>';
                        } elseif ($points_empty == 1) {
                        echo '<td style="width:'.$width_percent.'%;height:'.$product_td_height.'px;border: 1px solid black;background-color:white;table-layout:fixed;background-color:#ff6442;"> Out of stock - '.$name_p.' -     Faces ' . $shelf4_points.' -  Space  ' . $rounded_width.'%</td>';    
                        }else { //placeholders orange
                            echo '<td style="width:'.$width_percent.'%;height:'.$product_td_height.'px;border: 1px solid black;background-color:white;table-layout:fixed;background-color:#ffab51;">'.$name_p.' -     Faces ' . $shelf4_points.' -  Space  ' . $rounded_width.'%</td>';
                        }
                        
                    }
                }
                    }
            }
            
            //empty space td
            
            $empty_space_shelf4 = 100 - $empty_space_shelf4;
            echo '<td style="width:'.$empty_space_shelf4.'%;height:100%;border: 1px solid black;background-color:white;table-layout:fixed;">Empty</td>';
            //echo '</table>';
            //echo '</tr>';
            //echo '</td>'; //end of top shelf column
            echo '</tr>'; //end of top shelf
            echo '</table>';
            
            // SHELF 4 REALOGRAM
            
            
            
            // SHELF 3 REALOGRAM
            echo '<table style="width:'.$totalwidth_table.'px;height:'.$shelfheight3_table.'px;">'; // echoing the table start
            echo '<tr>'; //start of top shelf
            //echo '<td style="width:'.$totalwidth.'px;height:'.$shelfheight3.'px;"></td>'; //column of top shelf
            $get_report = $wpdb->get_results("SELECT * FROM points WHERE id_report =".$id_report."");
            //echo '<table>';
            //echo '<tr>';
            foreach ($get_report as $realogram) {
                $category = $realogram->id_category;
                $points_empty = $realogram->empty_points;
                if ($category == 1 or $category == 2 or $category == 4) {
                $id_product = $realogram->id_product;
                $shelf3_points = $realogram->shelf3_points;
                if ($shelf3_points > 0) {
                    $product_info = $wpdb->get_results("SELECT * FROM product WHERE id_product =".$id_product."");
                    foreach ($product_info as $info) {
                        $name_p = $info->name_product;
                        $width_p = $info->width_product;
                        $height_p = $info->height_product;
                       
                        //Calculate how many go on top of each other
                        if ($height_p > 0) {
                        $height_count = floor($shelfheight3 / $height_p);
                        }
                        if ($height_count > 0) {
                        $width_count = $shelf3_points / $height_count;
                        }
                        
                        $total_height = $height_count * $height_p;
                        $total_width_p = $width_count * $width_p;
                        
                        if ($totalwidth > 0) {
                        $width_percent = $total_width_p / $totalwidth * 100;
                        }
                        $rounded_width = round($width_percent, 2);
                        $empty_space_shelf3 = $empty_space_td + $width_percent;
                        
                       if ($category == 1 and $points_empty == 0 ) { //HOTO GREEN
                        echo '<td style="width:'.$width_percent.'%;height:'.$product_td_height.'px;border: 1px solid black;background-color:white;table-layout:fixed;background-color:#aee892;">'.$name_p.' -     Faces  '. $shelf3_points.' -  Space  ' . $rounded_width.'%</td>';
                        } elseif ($category == 2 and $points_empty == 0) { //TOTI CYAN
                            echo '<td style="width:'.$width_percent.'%;height:'.$product_td_height.'px;border: 1px solid black;background-color:white;table-layout:fixed;background-color:#a2e9ef;">'.$name_p.' -     Faces ' . $shelf3_points.' -  Space  ' . $rounded_width.'%</td>';
                        } elseif ($points_empty == 1) {
                        echo '<td style="width:'.$width_percent.'%;height:'.$product_td_height.'px;border: 1px solid black;background-color:white;table-layout:fixed;background-color:#ff6442;"> Out of stock - '.$name_p.' -     Faces ' . $shelf3_points.' -  Space  ' . $rounded_width.'%</td>';    
                        }else { //placeholders orange
                            echo '<td style="width:'.$width_percent.'%;height:'.$product_td_height.'px;border: 1px solid black;background-color:white;table-layout:fixed;background-color:#ffab51;">'.$name_p.' -     Faces ' . $shelf3_points.' -  Space  ' . $rounded_width.'%</td>';
                        }
                    }
                }
                    }
            }
            
            //empty space td
            
            $empty_space_shelf3 = 100 - $empty_space_shelf3;
            echo '<td style="width:'.$empty_space_shelf3.'%;height:100%;border: 1px solid black;background-color:white;table-layout:fixed;">Empty</td>';
            //echo '</table>';
            //echo '</tr>';
            //echo '</td>'; //end of top shelf column
            echo '</tr>'; //end of top shelf
            echo '</table>';
            
            // SHELF 3 REALOGRAM
            
            
            
            
            // SHELF 2 REALOGRAM
            echo '<table style="width:'.$totalwidth_table.'px;height:'.$shelfheight2_table.'px;">'; // echoing the table start
            echo '<tr>'; //start of top shelf
            //echo '<td style="width:'.$totalwidth.'px;height:'.$shelfheight3.'px;"></td>'; //column of top shelf
            $get_report = $wpdb->get_results("SELECT * FROM points WHERE id_report =".$id_report."");
            //echo '<table>';
            //echo '<tr>';
            foreach ($get_report as $realogram) {
                $category = $realogram->id_category;
                $points_empty = $realogram->empty_points;
                if ($category == 1 or $category == 2 or $category == 4) {
                $id_product = $realogram->id_product;
                $shelf2_points = $realogram->shelf2_points;
                if ($shelf2_points > 0) {
                    $product_info = $wpdb->get_results("SELECT * FROM product WHERE id_product =".$id_product."");
                    foreach ($product_info as $info) {
                        $name_p = $info->name_product;
                        $width_p = $info->width_product;
                        $height_p = $info->height_product;
                       
                        //Calculate how many go on top of each other
                        if ($height_p > 0) {
                        $height_count = floor($shelfheight2 / $height_p);
                        }
                        if ($height_count > 0) {
                        $width_count = $shelf2_points / $height_count;
                        }
                        
                        $total_height = $height_count * $height_p;
                        $total_width_p = $width_count * $width_p;
                        
                        if ($totalwidth > 0) {
                        $width_percent = $total_width_p / $totalwidth * 100;
                        }
                        $rounded_width = round($width_percent, 2);
                        $empty_space_shelf2 = $empty_space_td + $width_percent;
                        if ($category == 1 and $points_empty == 0 ) { //HOTO GREEN
                        echo '<td style="width:'.$width_percent.'%;height:'.$product_td_height.'px;border: 1px solid black;background-color:white;table-layout:fixed;background-color:#aee892;">'.$name_p.' -     Faces  '. $shelf2_points.' -  Space  ' . $rounded_width.'%</td>';
                        } elseif ($category == 2 and $points_empty == 0) { //TOTI CYAN
                            echo '<td style="width:'.$width_percent.'%;height:'.$product_td_height.'px;border: 1px solid black;background-color:white;table-layout:fixed;background-color:#a2e9ef;">'.$name_p.' -     Faces ' . $shelf2_points.' -  Space  ' . $rounded_width.'%</td>';
                        } elseif ($points_empty == 1) {
                        echo '<td style="width:'.$width_percent.'%;height:'.$product_td_height.'px;border: 1px solid black;background-color:white;table-layout:fixed;background-color:#ff6442;"> Out of stock - '.$name_p.' -     Faces ' . $shelf2_points.' -  Space  ' . $rounded_width.'%</td>';    
                        }else { //placeholders orange
                            echo '<td style="width:'.$width_percent.'%;height:'.$product_td_height.'px;border: 1px solid black;background-color:white;table-layout:fixed;background-color:#ffab51;">'.$name_p.' -     Faces ' . $shelf2_points.' -  Space  ' . $rounded_width.'%</td>';
                        }
                        
                    }
                }
                    }
            }
            
            //empty space td
            
            $empty_space_shelf2 = 100 - $empty_space_shelf2;
            echo '<td style="width:'.$empty_space_shelf2.'%;height:100%;border: 1px solid black;background-color:white;table-layout:fixed;">Empty</td>';
            //echo '</table>';
            //echo '</tr>';
            //echo '</td>'; //end of top shelf column
            echo '</tr>'; //end of top shelf
            echo '</table>';
            
            // SHELF 2 REALOGRAM
            
            
            
            // SHELF 1 REALOGRAM
            echo '<table style="width:'.$totalwidth_table.'px;height:'.$shelfheight1_table.'px;">'; // echoing the table start
            echo '<tr>'; //start of top shelf
            //echo '<td style="width:'.$totalwidth.'px;height:'.$shelfheight3.'px;"></td>'; //column of top shelf
            $get_report = $wpdb->get_results("SELECT * FROM points WHERE id_report =".$id_report."");
            //echo '<table>';
            //echo '<tr>';
            foreach ($get_report as $realogram) {
                $category = $realogram->id_category;
                $points_empty = $realogram->empty_points;
                if ($category == 1 or $category == 2 or $category == 4) {
                $id_product = $realogram->id_product;
                    
                    
                $shelf1_points = $realogram->shelf1_points; //CHANGE THIS DEPENDING ON SHELF
                    
                    
                if ($shelf1_points > 0) {
                    $product_info = $wpdb->get_results("SELECT * FROM product WHERE id_product =".$id_product."");
                    foreach ($product_info as $info) {
                        $name_p = $info->name_product;
                        $width_p = $info->width_product;
                        $height_p = $info->height_product;
                       
                        //Calculate how many go on top of each other
                        if ($height_p > 0) {
                        $height_count = floor($shelfheight1 / $height_p);
                        }
                        if ($height_count > 0) {
                        $width_count = $shelf1_points / $height_count;
                        }
                        
                        $total_height = $height_count * $height_p;
                        $total_width_p = $width_count * $width_p;
                        
                        if ($totalwidth > 0) {
                        $width_percent = $total_width_p / $totalwidth * 100;
                        }
                        $rounded_width = round($width_percent, 2);
                        $empty_space_shelf1 = $empty_space_td + $width_percent;
                        if ($category == 1 and $points_empty == 0 ) { //HOTO GREEN
                        echo '<td style="width:'.$width_percent.'%;height:'.$product_td_height.'px;border: 1px solid black;background-color:white;table-layout:fixed;background-color:#aee892;">'.$name_p.' -     Faces  '. $shelf1_points.' -  Space  ' . $rounded_width.'%</td>';
                        } elseif ($category == 2 and $points_empty == 0) { //TOTI CYAN
                            echo '<td style="width:'.$width_percent.'%;height:'.$product_td_height.'px;border: 1px solid black;background-color:white;table-layout:fixed;background-color:#a2e9ef;">'.$name_p.' -     Faces ' . $shelf1_points.' -  Space  ' . $rounded_width.'%</td>';
                        } elseif ($points_empty == 1) {
                        echo '<td style="width:'.$width_percent.'%;height:'.$product_td_height.'px;border: 1px solid black;background-color:white;table-layout:fixed;background-color:#ff6442;"> Out of stock - '.$name_p.' -     Faces ' . $shelf1_points.' -  Space  ' . $rounded_width.'%</td>';    
                        }else { //placeholders orange
                            echo '<td style="width:'.$width_percent.'%;height:'.$product_td_height.'px;border: 1px solid black;background-color:white;table-layout:fixed;background-color:#ffab51;">'.$name_p.' -     Faces ' . $shelf1_points.' -  Space  ' . $rounded_width.'%</td>';
                        }
                        
                    }
                }
                    }
            }
            
            //empty space td
            
            $empty_space_shelf1 = 100 - $empty_space_shelf1;
            echo '<td style="width:'.$empty_space_shelf1.'%;height:100%;border: 1px solid black;background-color:white;table-layout:fixed;">Empty</td>';
            //echo '</table>';
            //echo '</tr>';
            //echo '</td>'; //end of top shelf column
            echo '</tr>'; //end of top shelf
            echo '</table>';
            
            // SHELF 1 REALOGRAM
            break;
        default:
    }
    echo '</div>';
        }

        }

} 
             
 ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////       
        
// PRODUCTS OUT OF STOCK 
echo '<h4 id="OpenMe" class="productlist"> Products out of stock</h4>';
echo '<div id="ShowMe" class="product-list-report">';
$emptypoints = 0; //calculating how many 1's in points if result at the end is 0 echoes that no products out of stock
 $outofstock = $wpdb->get_results("SELECT * FROM points WHERE id_report =".$id_report."");
    foreach ($outofstock as $empty) {
    $id_product = $empty->id_product;
    $isempty = $empty->empty_points; //empty points table default value is 0 and if the checkbox is clicked it goes to the database as 1
    switch ($isempty) {
        case 0: //if value is 0 does nothing
        break;
        case 1: //if database value is 1 then echoes the name of the product that is out of stock
            $name = $wpdb->get_results("SELECT name_product FROM product WHERE id_product =".$id_product."");
            foreach ($name as $n) {
                echo '<h3>'.$n->name_product.'</h3>';
            }
            $emptypoints++;
        break;
    }
    }
if ($emptypoints == 0) { 
    echo '<h3> No items out of stock </h3>';
}
echo '</div>';
        
$summa = array_sum($share_array); //old code
        
//echo '<div class="fairshare-container">';
        
// CALCULATES THE AREA THAT PRODUCT TAKES DIVIDED BY TOTAL STORE AREA USED BY PRODUCTS

echo '<h4 id="OpenMe2" class="productlist"> Products in report</h4>';
echo '<div id="ShowMe2" class="product-list-report">';
    $unique_products = 0;
    $productlist = $wpdb->get_results("SELECT id_product FROM points WHERE id_report =".$id_report."");
        $arraycounter = 0; 
    foreach ($productlist as $products) {
        $idname = $products->id_product;
        $unique_products++;
        $productlist2 = $wpdb->get_results("SELECT * FROM product WHERE id_product  =".$idname."");
        foreach ($productlist2 as $namelist) {
            echo '<h2>'.$namelist->name_product.'</h2>';
        }
        $single_product_share = $share_array[$arraycounter] / $hotototihank_sq * 100;
        $single_product_share = round($single_product_share, 2);
        echo '<h2>'.$single_product_share.'%</h2>';
        $arraycounter++;
    } 
    echo '<br>';
    echo '<h3> Number of products in report: ' . $unique_products . '</h3>';
    echo '<h3> Total store area used: ' . $hotototihank_sq / $total_store_area_sq * 100 . '%</h3>';
echo '</div>';
//echo '</div>';

?>
 
<script type="text/javascript">
// JAVASCRIPT CODE COPYPASTED FROM CHARTJS 
$(function () {
var chart = new CanvasJS.Chart("chartContainer", {
	theme: "theme2",
	title:{
		text: "Total category share %"
	},
	exportFileName: "Category share of all space",
	exportEnabled: true,
	animationEnabled: true,		
	data: [
	{       
		type: "pie",
		showInLegend: true,
		toolTipContent: "{name}: <strong>{y}%</strong>",
		indexLabel: "{name} {y}%",
		dataPoints: <?php echo json_encode($category_total_share, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
});      
        $(function () {
var chart = new CanvasJS.Chart("chartContainer2", {
	theme: "theme2",
	title:{
		text: "Total producer share %"
	},
	exportFileName: "Producer Share",
	exportEnabled: true,
	animationEnabled: true,
	data: [
	{       
		type: "pie",
		showInLegend: true,
		toolTipContent: "{name}: <strong>{y}%</strong>",
		indexLabel: "{name} {y}%",
		dataPoints: <?php echo json_encode($producer_total_share, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
});
    
$(function () {
var chart = new CanvasJS.Chart("chartContainer3", {
	animationEnabled: true,
	title: {
		text: "Total label share %"
	},
	data: [
	{
		type: "column",                
		dataPoints: <?php echo json_encode($label_share_array, JSON_NUMERIC_CHECK); ?>
	}
	]
});
chart.render();
});
        
$(function () {
var chart = new CanvasJS.Chart("chartContainer_shelf_category", {
	theme: "theme2",
	title:{
		text: "Shelf category share %"
	},
	exportFileName: "Category share of all space",
	exportEnabled: true,
	animationEnabled: true,		
	data: [
	{       
		type: "pie",
		showInLegend: true,
		toolTipContent: "{name}: <strong>{y}%</strong>",
		indexLabel: "{name} {y}%",
		dataPoints: <?php echo json_encode($category_total_share_shelf, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
}); 
    
$(function () {
var chart = new CanvasJS.Chart("chartContainer_shelf_producer", {
	theme: "theme2",
	title:{
		text: "Shelf producer share %"
	},
	exportFileName: "Category share of all space",
	exportEnabled: true,
	animationEnabled: true,		
	data: [
	{       
		type: "pie",
		showInLegend: true,
		toolTipContent: "{name}: <strong>{y}%</strong>",
		indexLabel: "{name} {y}%",
		dataPoints: <?php echo json_encode($producer_total_share_shelf, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
}); 
        
$(function () {
var chart = new CanvasJS.Chart("chartContainer_shelf_label", {
	animationEnabled: true,
	title: {
		text: "Shelf label share %"
	},
	data: [
	{
		type: "column",                
		dataPoints: <?php echo json_encode($label_share_array_shelf, JSON_NUMERIC_CHECK); ?>
	}
	]
});
chart.render();
});

$(function () {
var chart = new CanvasJS.Chart("chartContainer_pallet_category", {
	theme: "theme2",
	title:{
		text: "Pallet category share %"
	},
	exportFileName: "Category share of all space",
	exportEnabled: true,
	animationEnabled: true,		
	data: [
	{       
		type: "pie",
		showInLegend: true,
		toolTipContent: "{name}: <strong>{y}%</strong>",
		indexLabel: "{name} {y}%",
		dataPoints: <?php echo json_encode($category_total_share_pallet, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
}); 
      
$(function () {
var chart = new CanvasJS.Chart("chartContainer_pallet_producer", {
	theme: "theme2",
	title:{
		text: "Pallet producer share in %"
	},
	exportFileName: "Pallet producer share %",
	exportEnabled: true,
	animationEnabled: true,		
	data: [
	{       
		type: "pie",
		showInLegend: true,
		toolTipContent: "{name}: <strong>{y}%</strong>",
		indexLabel: "{name} {y}%",
		dataPoints: <?php echo json_encode($producer_total_share_pallet, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
}); 
     
    $(function () {
var chart = new CanvasJS.Chart("chartContainer_pallet_label", {
	animationEnabled: true,
	title: {
		text: "Pallet label share %"
	},
	data: [
	{
		type: "column",                
		dataPoints: <?php echo json_encode($label_share_array_pallet, JSON_NUMERIC_CHECK); ?>
	}
	]
});
chart.render();
});
        
    
</script>

<script>
    
// MAKES THE DIVS CLICKABLE SO THAT THE CONTENT OPENS, USING JQUERY TO DO THIS WITH TOGGLE AND SMALL ANIMATION
$( "#OpenMe" ).click(function() {
$( "#ShowMe" ).slideToggle( "slow", function() {
    // Animation complete.
  });
});
    
$( "#OpenMe2" ).click(function() {
$( "#ShowMe2" ).slideToggle( "slow", function() {
    // Animation complete.
  });
});
        
</script>
        
        
        <form method="post">
        
            <input class="menu-item-orange" type="submit" name="save_report" value="Save report">
            
        </form>
        
        
        <?php
        
        // SAVES SELECTED DATA TO THE FINAL REPORT WHEN SAVE REPORT BUTTON IS CLICKED
        
        if(isset($_POST['save_report'])) {
            $date_finalreport = date("d.m.Y");
            $total_products = 0;
            $id_main_chain = 0;
            $id_store_chain = 0;
            $id_store = 0;
            $total = $wpdb->get_results("SELECT * FROM points WHERE id_report =".$id_report."");
            foreach ($total as $count) {
                $total_products = $total_products + $count->productcount_points;
                $id_main_chain = $count->id_main_chain;
                $id_store_chain = $count->id_store_chain;
                $id_store = $count->id_store;
            }
            $wpdb->last_query;
            echo '<div style="background-color:white;float:left;">';
            echo $wpdb->last_query;
            echo '<br>';
            echo $wpdb->show_errors;
            echo '<br>';
            echo $wpdb->last_error;
            echo '<br>';
            echo $id_report;
            echo '<br>';
            echo $id_main_chain;
            echo '<br>';
            echo $id_store_chain;
            echo '<br>';
            echo $id_store;
            echo '<br>';
            echo $date_finalreport;
            echo '<br>';
            echo $mt_hoto;
            echo '<br>';
            echo $mt_toti;
            echo '<br>';
            echo $mt_hank;
            echo '<br>';
            echo $mt;
            echo '<br>';
            echo $ruokakesko;
            echo '<br>';
            echo $sca;
            echo '<br>';
            echo $kimberly;
            echo '<br>';
            echo $majesta;
            echo '<br>';
            echo $horizon;
            echo '<br>';
            echo $srl;
            echo '<br>';
            echo $shs;
            echo '<br>';
            echo $total_products;
            echo '<br>';
            echo $date_finalreport;
            echo '</div>';
            
            $wpdb->insert(
                'finalreport',
                array (
                    'id_report' => $id_report,
                    'id_main_chain' => $id_main_chain,
                    'id_store_chain' => $id_store_chain,
                    'id_store' => $id_store,
                    'date_finalreport' => $date_finalreport,
                    'mt_hoto' => $mt_hoto,
                    'mt_toti' => $mt_toti,
                    'mt_hank' => $mt_hank,
                    'mt' => $mt,
                    'ruokakesko' => $ruokakesko,
                    'sca' => $sca,
                    'kimberly' => $kimberly,
                    'majesta' => $majesta,
                    'horizon' => $horizon,
                    'srl' => $srl,
                    'shs' => $shs,
                    'total_products' => $total_products
                ),array( 
		          '%d', 
		          '%d',
                    '%d', 
		              '%d',
                    '%s',
                    '%s', 
                    '%s',
                    '%s', 
		              '%s',
                    '%s',
                    '%s',
                    '%s', 
                    '%s',
                    '%s', 
		              '%s',
                    '%s',
                    '%s', 
                    '%d'
	           ) 
            );
            $finalreport_id = $wpdb->insert_id;
            
            
            // CLICKING DOWNLOAD EXCEL EXECUTES THE EXCEL CREATION ACTION
            echo '<form method="post">';
            echo '<input type="hidden" name="finalreport_id" value="'.$finalreport_id.'">';
            echo '<input class="menu-item-orange" action="export_excel.php" type="submit" name="finalreport_id" value="Download excel">';
            
            echo '</form>';
                
                
            echo '<div style="background-color:white;float:left;">';
            $wpdb->last_query;
            $wpdb->show_errors;
            $wpdb->last_error;
            echo '</div>';
        }
        
        ?>
        <!-- GOES TO PREVIOUS PAGE FROM BROWSER HISTORY -->
        <div class="previous-page">
            <a href="www.mypage.com" onclick="window.history.go(-1); return false;"><img class="back-arrow" src="<?php echo get_template_directory_uri(); ?>/img/back-arrow.png"></a>
        </div>
    </div>
	<main role="main">
		
	</main>


<?php get_footer(); ?>