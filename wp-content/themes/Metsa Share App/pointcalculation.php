<?php /* Template Name: Points calculation */ ?>

<?php get_header(); ?>


    <div class="app-container">
        
        
        <?php
        
        // STORING ALL IDS FROM THE URL WE GOT FROM PREVIOUS PAGE
        
        $store_id = $_GET["ids"]; // id for store
        $storechain_id = $_GET["idsc"]; //id for store chain
        $mainchain_id = $_GET["idmc"]; //id for main chain
        $settings_id = $_GET["idss"]; //id for store settings
        $dateandtime = date("d.m.Y"); //gets the time and date from server, used as report creation date
        $report_id = $_GET["idr"];
        $id_points = 0; // So we can access the products from points later on
        
        $storename = $storename->name_store;
        
        // ECHOES STORE NAME AS THE TITLE FOR THE PAGE
        $name_store = $wpdb->get_results("SELECT name_store FROM store WHERE id_store =".$store_id."");
            foreach ($name_store as $name) {
            echo '<h1 class="product-store-name">'. $name->name_store.'</h1>';
        }

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
       foreach ($mainchains as $searchresult) {
           
           //ALL THE IDS ARE STORES AS HIDDEN INPUTS THAT WE CAN RETRIEVE IF THE USER CLICKS THE PRODUCT
           echo '<form method="POST">';
           echo '<input type="hidden" name="id_store" value="'.$store_id.'"></input>';
           echo '<input type="hidden" name="id_store_chain" value="'.$storechain_id.'"></input>';
           echo '<input type="hidden" name="id_main_chain" value="'.$mainchain_id.'"></input>';
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
           echo '<input id="showpoints" class="showpoints" type="submit" name="showpoints" value="'. $searchresult->name_product. ' - ' .$searchresult->ean_product.'"></input>';
           echo '</form>';
           
           if ($searchresult->ean_product == $name) {
               ?>
                <script>
                    $("#showpoints").trigger("click");
                </script>
            <?php
           }
       }
        
            }
        /* 
        Tuotteen etsiminen -> tuo suoraan pisteytyksen
        Syöttää tuotteen pisteet
        Next item tallentaa 
        Button to add products, button to edit them - product points sivun avaaminen luo aina uuden raportin, miten se
            
        */
        
        if(isset($_POST['showpoints'])) {
            //IF PRODUCT IS CLICKED GETS THE HIDDEN INPUT IDS WITH $_POST
            $id_product = $_POST["id_product"]; 
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
            $report_id = $_GET["idr"];
            $id_store = $_GET["id_store"];
            $id_store_chain = $_GET["id_store_chain"];
            $id_main_chain = $_GET["id_main_chain"];
               
            
            //GET THE STORE DATA FROM STORE SETTINGS
            $shelfcount = $wpdb->get_results("SELECT * FROM store_settings WHERE id_store_settings = ".$settings_id."");
            foreach ($shelfcount as $shelves) {
                $paper_shelves = $shelves->paper_shelf_count;
                $hank_shelves = $shelves->hank_shelf_count;
                $paper_depth = $shelves->paper_depth;
                $hank_depth = $shelves->hank_depth;
            }
            
  
            echo '<h1 class="product-store-name">'.$name_product.'</h1>';
            echo '<br>';
            echo '<form class="inputpoints" method="post">';
            
            $check = $wpdb->get_results("SELECT * FROM points"); //CHECKS IF THERE ARE ANY DB INPUTS WITH THE REPORT ID AND PRODUCT ID AND ADDS IT TO COUNTER2
                $counter2 = 0;
                foreach ($check as $check2) {
                    $r_id2 = $check2->id_report;
                    $p_id2 = $check2->id_product;
                    if ($r_id2 == $report_id AND $p_id2 == $id_product){
                        $counter2++;
                    }
                }
        if ($id_product == 666 or $id_product == 101) { //CHECKS IF THE PRODUCT SELECTED IS A PLACEHOLDER PRODUCT
                echo '<div class="horizontal_checkbox">';
                echo '<h1 class="selection_title">Placeholder name</h1>';
                echo '<input class="placeholder_input" type="text" name="name_placeholder" value=""></input>';
                echo '<h1 class="selection_title">Placeholder EAN</h1>';
                echo '<input class="placeholder_input" type="text" name="ean_placeholder" value=""></input>';
                echo '</div>';
            }         
            
        if ($counter2 == 0) { //CHECKS IF COUNTER IS 0 - MEANS THAT THERE ARE NO INPUTS TO DATABASE WITH THIS PRODUCT ID, SO THERE ARE NO PREVIOUS INPUTS THAT NEED TO BE FETCHED FROM DB
            if ($id_category == 1 or $id_category == 2 or $id_category == 4) { // GETS THE SHELF COUNT FOR HOTO TOTI AND HOTO TOTI PLACEHOLDER 
                switch ($paper_shelves) {
                    case 0:
                        echo 'There are currently 0 shelves set for your store. Please edit the settings';
                        break;
                    case 1:
                        //-----------------------------------------------------
                       echo '<div class="horizontal_checkbox">';
                       echo '<h1 class="selection_title">Shelf 1</h1>';
                        echo '<select class="hidescroll" name="shelf1_points" size="8">';
                        //echo '<option value="0" name="0">0</selection>';
                        $shelf1_points = 0;
                        
                        while ($shelf1_points < 301) {
                            if ($shelf1_points == 0) {
                            echo '<option value="'.$shelf1_points.'" name="horizontal_selection" autofocus selected>'.$shelf1_points.'</selection>';
                            } else {
                                echo '<option value="'.$shelf1_points.'" name="horizontal_selection">'.$shelf1_points.'</selection>';
                            }
                            $shelf1_points++;
                        }
                        echo '</select>';
                        echo '</div>';
                       //-----------------------------------------------------
                        /* echo 'Shelf 1';
                        echo '<input type="text" name="shelf1_points" value="0"></input>';
                        echo '<br>'; */
                        break;
                    case 2:
                        //-----------------------------------------------------
                       echo '<div class="horizontal_checkbox">';
                       echo '<h1 class="selection_title">Shelf 1</h1>';
                        echo '<select class="hidescroll" name="shelf1_points" size="8">';
                        //echo '<option value="0" name="0">0</selection>';
                        $shelf1_points = 0;
                        while ($shelf1_points < 301) {
                            if ($shelf1_points == 0) {
                            echo '<option value="'.$shelf1_points.'" name="horizontal_selection" autofocus selected>'.$shelf1_points.'</selection>';
                            } else {
                                echo '<option value="'.$shelf1_points.'" name="horizontal_selection">'.$shelf1_points.'</selection>';
                            }
                            $shelf1_points++;
                        }
                        echo '</select>';
                        echo '</div>';
                       //-----------------------------------------------------
                        //-----------------------------------------------------
                       echo '<div class="horizontal_checkbox">';
                       echo '<h1 class="selection_title">Shelf 2</h1>';
                        echo '<select class="hidescroll" name="shelf2_points" size="8">';
                        //echo '<option value="0" name="0">0</selection>';
                        $shelf2_points = 0;
                        while ($shelf2_points < 301) {
                            if ($shelf2_points == 0) {
                            echo '<option value="'.$shelf2_points.'" name="horizontal_selection" autofocus selected>'.$shelf2_points.'</selection>';
                            } else {
                                echo '<option value="'.$shelf2_points.'" name="horizontal_selection">'.$shelf2_points.'</selection>';
                            }
                            $shelf2_points++;
                        }
                        echo '</select>';
                        echo '</div>';
                       //-----------------------------------------------------
                        break;
                    case 3:
                        //-----------------------------------------------------
                       echo '<div class="horizontal_checkbox">';
                       echo '<h1 class="selection_title">Shelf 1</h1>';
                        echo '<select class="hidescroll" name="shelf1_points" size="8">';
                        //echo '<option value="0" name="0">0</selection>';
                        $shelf1_points = 0;
                        while ($shelf1_points < 301) {
                            if ($shelf1_points == 0) {
                            echo '<option value="'.$shelf1_points.'" name="horizontal_selection" autofocus selected>'.$shelf1_points.'</selection>';
                            } else {
                                echo '<option value="'.$shelf1_points.'" name="horizontal_selection">'.$shelf1_points.'</selection>';
                            }
                            $shelf1_points++;
                        }
                        echo '</select>';
                        echo '</div>';
                       //-----------------------------------------------------
                        //-----------------------------------------------------
                       echo '<div class="horizontal_checkbox">';
                       echo '<h1 class="selection_title">Shelf 2</h1>';
                        echo '<select class="hidescroll" name="shelf2_points" size="8">';
                        //echo '<option value="0" name="0">0</selection>';
                        $shelf2_points = 0;
                        while ($shelf2_points < 301) {
                            if ($shelf2_points == 0) {
                            echo '<option value="'.$shelf2_points.'" name="horizontal_selection" autofocus selected>'.$shelf2_points.'</selection>';
                            } else {
                                echo '<option value="'.$shelf2_points.'" name="horizontal_selection">'.$shelf2_points.'</selection>';
                            }
                            $shelf2_points++;
                        }
                        echo '</select>';
                        echo '</div>';
                       //-----------------------------------------------------
                        //-----------------------------------------------------
                       echo '<div class="horizontal_checkbox">';
                       echo '<h1 class="selection_title">Shelf 3</h1>';
                        echo '<select class="hidescroll" name="shelf3_points" size="8">';
                        //echo '<option value="0" name="0">0</selection>';
                        $shelf3_points = 0;
                        while ($shelf3_points < 301) {
                            if ($shelf3_points == 0) {
                            echo '<option value="'.$shelf3_points.'" name="horizontal_selection" autofocus selected>'.$shelf3_points.'</selection>';
                            } else {
                                echo '<option value="'.$shelf3_points.'" name="horizontal_selection">'.$shelf3_points.'</selection>';
                            }
                            $shelf3_points++;
                        }
                        echo '</select>';
                        echo '</div>';
                       //-----------------------------------------------------
                        break;
                    case 4:
                        //-----------------------------------------------------
                       echo '<div class="horizontal_checkbox">';
                       echo '<h1 class="selection_title">Shelf 1</h1>';
                        echo '<select class="hidescroll" name="shelf1_points" size="8">';
                        //echo '<option value="0" name="0">0</selection>';
                        $shelf1_points = 0;
                        while ($shelf1_points < 301) {
                            if ($shelf1_points == 0) {
                            echo '<option value="'.$shelf1_points.'" name="horizontal_selection" autofocus selected>'.$shelf1_points.'</selection>';
                            } else {
                                echo '<option value="'.$shelf1_points.'" name="horizontal_selection">'.$shelf1_points.'</selection>';
                            }
                            $shelf1_points++;
                        }
                        echo '</select>';
                        echo '</div>';
                       //-----------------------------------------------------
                        //-----------------------------------------------------
                       echo '<div class="horizontal_checkbox">';
                       echo '<h1 class="selection_title">Shelf 2</h1>';
                        echo '<select class="hidescroll" name="shelf2_points" size="8">';
                        //echo '<option value="0" name="0">0</selection>';
                        $shelf2_points = 0;
                        while ($shelf2_points < 301) {
                            if ($shelf2_points == 0) {
                            echo '<option value="'.$shelf2_points.'" name="horizontal_selection" autofocus selected>'.$shelf2_points.'</selection>';
                            } else {
                                echo '<option value="'.$shelf2_points.'" name="horizontal_selection">'.$shelf2_points.'</selection>';
                            }
                            $shelf2_points++;
                        }
                        echo '</select>';
                        echo '</div>';
                       //-----------------------------------------------------
                        //-----------------------------------------------------
                       echo '<div class="horizontal_checkbox">';
                       echo '<h1 class="selection_title">Shelf 3</h1>';
                        echo '<select class="hidescroll" name="shelf3_points" size="8">';
                        //echo '<option value="0" name="0">0</selection>';
                        $shelf3_points = 0;
                        while ($shelf3_points < 301) {
                            if ($shelf3_points == 0) {
                            echo '<option value="'.$shelf3_points.'" name="horizontal_selection" autofocus selected>'.$shelf3_points.'</selection>';
                            } else {
                                echo '<option value="'.$shelf3_points.'" name="horizontal_selection">'.$shelf3_points.'</selection>';
                            }
                            $shelf3_points++;
                        }
                        echo '</select>';
                        echo '</div>';
                       //-----------------------------------------------------
                        //-----------------------------------------------------
                       echo '<div class="horizontal_checkbox">';
                       echo '<h1 class="selection_title">Shelf 4</h1>';
                        echo '<select class="hidescroll" name="shelf4_points" size="8">';
                        //echo '<option value="0" name="0">0</selection>';
                        $shelf4_points = 0;
                        while ($shelf4_points < 301) {
                            if ($shelf4_points == 0) {
                            echo '<option value="'.$shelf4_points.'" name="horizontal_selection" autofocus selected>'.$shelf4_points.'</selection>';
                            } else {
                                echo '<option value="'.$shelf4_points.'" name="horizontal_selection">'.$shelf4_points.'</selection>';
                            }
                            $shelf4_points++;
                        }
                        echo '</select>';
                        echo '</div>';
                       //-----------------------------------------------------
                        break;
                    case 5:
                        /*echo 'Shelf 1';
                        echo '<input type="text" name="shelf1_points" value="0"></input>';
                        echo 'Shelf 2';
                        echo '<input type="text" name="shelf2_points" value="0"></input>';
                        echo 'Shelf 3';
                        echo '<input type="text" name="shelf3_points" value="0"></input>';
                        echo 'Shelf 4';
                        echo '<input type="text" name="shelf4_points" value="0"></input>';
                        echo 'Shelf 5';
                        echo '<input type="text" name="shelf5_points" value="0"></input>';*/
                        //-----------------------------------------------------
                       echo '<div class="horizontal_checkbox">';
                       echo '<h1 class="selection_title">Shelf 1</h1>';
                        echo '<select class="hidescroll" name="shelf1_points" size="8">';
                        //echo '<option value="0" name="0">0</selection>';
                        $shelf1_points = 0;
                        while ($shelf1_points < 301) {
                            if ($shelf1_points == 0) {
                            echo '<option value="'.$shelf1_points.'" name="horizontal_selection" autofocus selected>'.$shelf1_points.'</selection>';
                            } else {
                                echo '<option value="'.$shelf1_points.'" name="horizontal_selection">'.$shelf1_points.'</selection>';
                            }
                            $shelf1_points++;
                        }
                        echo '</select>';
                        echo '</div>';
                       //-----------------------------------------------------
                        //-----------------------------------------------------
                       echo '<div class="horizontal_checkbox">';
                       echo '<h1 class="selection_title">Shelf 2</h1>';
                        echo '<select class="hidescroll" name="shelf2_points" size="8">';
                        //echo '<option value="0" name="0">0</selection>';
                        $shelf2_points = 0;
                        while ($shelf2_points < 301) {
                            if ($shelf2_points == 0) {
                            echo '<option value="'.$shelf2_points.'" name="horizontal_selection" autofocus selected>'.$shelf2_points.'</selection>';
                            } else {
                                echo '<option value="'.$shelf2_points.'" name="horizontal_selection">'.$shelf2_points.'</selection>';
                            }
                            $shelf2_points++;
                        }
                        echo '</select>';
                        echo '</div>';
                       //-----------------------------------------------------
                        //-----------------------------------------------------
                       echo '<div class="horizontal_checkbox">';
                       echo '<h1 class="selection_title">Shelf 3</h1>';
                        echo '<select class="hidescroll" name="shelf3_points" size="8">';
                        //echo '<option value="0" name="0">0</selection>';
                        $shelf3_points = 0;
                        while ($shelf3_points < 301) {
                            if ($shelf3_points == 0) {
                            echo '<option value="'.$shelf3_points.'" name="horizontal_selection" autofocus selected>'.$shelf3_points.'</selection>';
                            } else {
                                echo '<option value="'.$shelf3_points.'" name="horizontal_selection">'.$shelf3_points.'</selection>';
                            }
                            $shelf3_points++;
                        }
                        echo '</select>';
                        echo '</div>';
                       //-----------------------------------------------------
                        //-----------------------------------------------------
                       echo '<div class="horizontal_checkbox">';
                       echo '<h1 class="selection_title">Shelf 4</h1>';
                        echo '<select class="hidescroll" name="shelf4_points" size="8">';
                        //echo '<option value="0" name="0">0</selection>';
                        $shelf4_points = 0;
                        while ($shelf4_points < 301) {
                            if ($shelf4_points == 0) {
                            echo '<option value="'.$shelf4_points.'" name="horizontal_selection" autofocus selected>'.$shelf4_points.'</selection>';
                            } else {
                                echo '<option value="'.$shelf4_points.'" name="horizontal_selection">'.$shelf4_points.'</selection>';
                            }
                            $shelf4_points++;
                        }
                        echo '</select>';
                        echo '</div>';
                       //-----------------------------------------------------
                        //-----------------------------------------------------
                       echo '<div class="horizontal_checkbox">';
                       echo '<h1 class="selection_title">Shelf 5</h1>';
                        echo '<select class="hidescroll" name="shelf5_points" size="8">';
                        //echo '<option value="0" name="0">0</selection>';
                        $shelf5_points = 0;
                        while ($shelf5_points < 301) {
                            if ($shelf5_points == 0) {
                            echo '<option value="'.$shelf5_points.'" name="horizontal_selection" autofocus selected>'.$shelf5_points.'</selection>';
                            } else {
                                echo '<option value="'.$shelf5_points.'" name="horizontal_selection">'.$shelf5_points.'</selection>';
                            }
                            $shelf5_points++;
                        }
                        echo '</select>';
                        echo '</div>';
                       //-----------------------------------------------------
                        break;
                    default:
                        echo '!Error!';
                    }
                } elseif ($id_category == 3 or $id_category == 5) { // GETS SHELF COUNT FOR HANK AND HANK PLACEHOLDER
                    switch ($hank_shelves) {
                    case 0:
                        echo 'There are currently 0 shelves set for your store. Please edit the settings';
                        break;
                    case 1:
                        //-----------------------------------------------------
                       echo '<div class="horizontal_checkbox">';
                       echo '<h1 class="selection_title">Shelf 1</h1>';
                        echo '<select class="hidescroll" name="shelf1_points" size="8">';
                        //echo '<option value="0" name="0">0</selection>';
                        $shelf1_points = 0;
                        while ($shelf1_points < 301) {
                            if ($shelf1_points == 0) {
                            echo '<option value="'.$shelf1_points.'" name="horizontal_selection" autofocus selected>'.$shelf1_points.'</selection>';
                            } else {
                                echo '<option value="'.$shelf1_points.'" name="horizontal_selection">'.$shelf1_points.'</selection>';
                            }
                            $shelf1_points++;
                        }
                        echo '</select>';
                        echo '</div>';
                       //-----------------------------------------------------
                        break;
                    case 2:
                        //-----------------------------------------------------
                       echo '<div class="horizontal_checkbox">';
                       echo '<h1 class="selection_title">Shelf 1</h1>';
                        echo '<select class="hidescroll" name="shelf1_points" size="8">';
                        //echo '<option value="0" name="0">0</selection>';
                        $shelf1_points = 0;
                        while ($shelf1_points < 301) {
                            if ($shelf1_points == 0) {
                            echo '<option value="'.$shelf1_points.'" name="horizontal_selection" autofocus selected>'.$shelf1_points.'</selection>';
                            } else {
                                echo '<option value="'.$shelf1_points.'" name="horizontal_selection">'.$shelf1_points.'</selection>';
                            }
                            $shelf1_points++;
                        }
                        echo '</select>';
                        echo '</div>';
                       //-----------------------------------------------------
                        //-----------------------------------------------------
                       echo '<div class="horizontal_checkbox">';
                       echo '<h1 class="selection_title">Shelf 2</h1>';
                        echo '<select class="hidescroll" name="shelf2_points" size="8">';
                        //echo '<option value="0" name="0">0</selection>';
                        $shelf2_points = 0;
                        while ($shelf2_points < 301) {
                            if ($shelf2_points == 0) {
                            echo '<option value="'.$shelf2_points.'" name="horizontal_selection" autofocus selected>'.$shelf2_points.'</selection>';
                            } else {
                                echo '<option value="'.$shelf2_points.'" name="horizontal_selection">'.$shelf2_points.'</selection>';
                            }
                            $shelf2_points++;
                        }
                        echo '</select>';
                        echo '</div>';
                       //-----------------------------------------------------
                        break;
                    case 3:
                        //-----------------------------------------------------
                       echo '<div class="horizontal_checkbox">';
                       echo '<h1 class="selection_title">Shelf 1</h1>';
                        echo '<select class="hidescroll" name="shelf1_points" size="8">';
                        //echo '<option value="0" name="0">0</selection>';
                        $shelf1_points = 0;
                        while ($shelf1_points < 301) {
                            if ($shelf1_points == 0) {
                            echo '<option value="'.$shelf1_points.'" name="horizontal_selection" autofocus selected>'.$shelf1_points.'</selection>';
                            } else {
                                echo '<option value="'.$shelf1_points.'" name="horizontal_selection">'.$shelf1_points.'</selection>';
                            }
                            $shelf1_points++;
                        }
                        echo '</select>';
                        echo '</div>';
                       //-----------------------------------------------------
                        //-----------------------------------------------------
                       echo '<div class="horizontal_checkbox">';
                       echo '<h1 class="selection_title">Shelf 2</h1>';
                        echo '<select class="hidescroll" name="shelf2_points" size="8">';
                        //echo '<option value="0" name="0">0</selection>';
                        $shelf2_points = 0;
                        while ($shelf2_points < 301) {
                            if ($shelf2_points == 0) {
                            echo '<option value="'.$shelf2_points.'" name="horizontal_selection" autofocus selected>'.$shelf2_points.'</selection>';
                            } else {
                                echo '<option value="'.$shelf2_points.'" name="horizontal_selection">'.$shelf2_points.'</selection>';
                            }
                            $shelf2_points++;
                        }
                        echo '</select>';
                        echo '</div>';
                       //-----------------------------------------------------
                        //-----------------------------------------------------
                       echo '<div class="horizontal_checkbox">';
                       echo '<h1 class="selection_title">Shelf 3</h1>';
                        echo '<select class="hidescroll" name="shelf3_points" size="8">';
                        //echo '<option value="0" name="0">0</selection>';
                        $shelf3_points = 0;
                        while ($shelf3_points < 301) {
                            if ($shelf3_points == 0) {
                            echo '<option value="'.$shelf3_points.'" name="horizontal_selection" autofocus selected>'.$shelf3_points.'</selection>';
                            } else {
                                echo '<option value="'.$shelf3_points.'" name="horizontal_selection">'.$shelf3_points.'</selection>';
                            }
                            $shelf3_points++;
                        }
                        echo '</select>';
                        echo '</div>';
                       //-----------------------------------------------------
                        break;
                    case 4:
                        //-----------------------------------------------------
                       echo '<div class="horizontal_checkbox">';
                       echo '<h1 class="selection_title">Shelf 1</h1>';
                        echo '<select class="hidescroll" name="shelf1_points" size="8">';
                        //echo '<option value="0" name="0">0</selection>';
                        $shelf1_points = 0;
                        while ($shelf1_points < 301) {
                            if ($shelf1_points == 0) {
                            echo '<option value="'.$shelf1_points.'" name="horizontal_selection" autofocus selected>'.$shelf1_points.'</selection>';
                            } else {
                                echo '<option value="'.$shelf1_points.'" name="horizontal_selection">'.$shelf1_points.'</selection>';
                            }
                            $shelf1_points++;
                        }
                        echo '</select>';
                        echo '</div>';
                       //-----------------------------------------------------
                        //-----------------------------------------------------
                       echo '<div class="horizontal_checkbox">';
                       echo '<h1 class="selection_title">Shelf 2</h1>';
                        echo '<select class="hidescroll" name="shelf2_points" size="8">';
                        //echo '<option value="0" name="0">0</selection>';
                        $shelf2_points = 0;
                        while ($shelf2_points < 301) {
                            if ($shelf2_points == 0) {
                            echo '<option value="'.$shelf2_points.'" name="horizontal_selection" autofocus selected>'.$shelf2_points.'</selection>';
                            } else {
                                echo '<option value="'.$shelf2_points.'" name="horizontal_selection">'.$shelf2_points.'</selection>';
                            }
                            $shelf2_points++;
                        }
                        echo '</select>';
                        echo '</div>';
                       //-----------------------------------------------------
                        //-----------------------------------------------------
                       echo '<div class="horizontal_checkbox">';
                       echo '<h1 class="selection_title">Shelf 3</h1>';
                        echo '<select class="hidescroll" name="shelf3_points" size="8">';
                        //echo '<option value="0" name="0">0</selection>';
                        $shelf3_points = 0;
                        while ($shelf3_points < 301) {
                            if ($shelf3_points == 0) {
                            echo '<option value="'.$shelf3_points.'" name="horizontal_selection" autofocus selected>'.$shelf3_points.'</selection>';
                            } else {
                                echo '<option value="'.$shelf3_points.'" name="horizontal_selection">'.$shelf3_points.'</selection>';
                            }
                            $shelf3_points++;
                        }
                        echo '</select>';
                        echo '</div>';
                       //-----------------------------------------------------
                        //-----------------------------------------------------
                       echo '<div class="horizontal_checkbox">';
                       echo '<h1 class="selection_title">Shelf 4</h1>';
                        echo '<select class="hidescroll" name="shelf4_points" size="8">';
                        //echo '<option value="0" name="0">0</selection>';
                        $shelf4_points = 0;
                        while ($shelf4_points < 301) {
                            if ($shelf4_points == 0) {
                            echo '<option value="'.$shelf4_points.'" name="horizontal_selection" autofocus selected>'.$shelf4_points.'</selection>';
                            } else {
                                echo '<option value="'.$shelf4_points.'" name="horizontal_selection">'.$shelf4_points.'</selection>';
                            }
                            $shelf4_points++;
                        }
                        echo '</select>';
                        echo '</div>';
                       //-----------------------------------------------------
                        break;
                    case 5:
                        //-----------------------------------------------------
                       echo '<div class="horizontal_checkbox">';
                       echo '<h1 class="selection_title">Shelf 1</h1>';
                        echo '<select class="hidescroll" name="shelf1_points" size="8">';
                        //echo '<option value="0" name="0">0</selection>';
                        $shelf1_points = 0;
                        while ($shelf1_points < 301) {
                            if ($shelf1_points == 0) {
                            echo '<option value="'.$shelf1_points.'" name="horizontal_selection" autofocus selected>'.$shelf1_points.'</selection>';
                            } else {
                                echo '<option value="'.$shelf1_points.'" name="horizontal_selection">'.$shelf1_points.'</selection>';
                            }
                            $shelf1_points++;
                        }
                        echo '</select>';
                        echo '</div>';
                       //-----------------------------------------------------
                        //-----------------------------------------------------
                       echo '<div class="horizontal_checkbox">';
                       echo '<h1 class="selection_title">Shelf 2</h1>';
                        echo '<select class="hidescroll" name="shelf2_points" size="8">';
                        //echo '<option value="0" name="0">0</selection>';
                        $shelf2_points = 0;
                        while ($shelf2_points < 301) {
                            if ($shelf2_points == 0) {
                            echo '<option value="'.$shelf2_points.'" name="horizontal_selection" autofocus selected>'.$shelf2_points.'</selection>';
                            } else {
                                echo '<option value="'.$shelf2_points.'" name="horizontal_selection">'.$shelf2_points.'</selection>';
                            }
                            $shelf2_points++;
                        }
                        echo '</select>';
                        echo '</div>';
                       //-----------------------------------------------------
                        //-----------------------------------------------------
                       echo '<div class="horizontal_checkbox">';
                       echo '<h1 class="selection_title">Shelf 3</h1>';
                        echo '<select class="hidescroll" name="shelf3_points" size="8">';
                        //echo '<option value="0" name="0">0</selection>';
                        $shelf3_points = 0;
                        while ($shelf3_points < 301) {
                            if ($shelf3_points == 0) {
                            echo '<option value="'.$shelf3_points.'" name="horizontal_selection" autofocus selected>'.$shelf3_points.'</selection>';
                            } else {
                                echo '<option value="'.$shelf3_points.'" name="horizontal_selection">'.$shelf3_points.'</selection>';
                            }
                            $shelf3_points++;
                        }
                        echo '</select>';
                        echo '</div>';
                       //-----------------------------------------------------
                        //-----------------------------------------------------
                       echo '<div class="horizontal_checkbox">';
                       echo '<h1 class="selection_title">Shelf 4</h1>';
                        echo '<select class="hidescroll" name="shelf4_points" size="8">';
                        //echo '<option value="0" name="0">0</selection>';
                        $shelf4_points = 0;
                        while ($shelf4_points < 301) {
                            if ($shelf4_points == 0) {
                            echo '<option value="'.$shelf4_points.'" name="horizontal_selection" autofocus selected>'.$shelf4_points.'</selection>';
                            } else {
                                echo '<option value="'.$shelf4_points.'" name="horizontal_selection">'.$shelf4_points.'</selection>';
                            }
                            $shelf4_points++;
                        }
                        echo '</select>';
                        echo '</div>';
                       //-----------------------------------------------------
                        //-----------------------------------------------------
                       echo '<div class="horizontal_checkbox">';
                       echo '<h1 class="selection_title">Shelf 5</h1>';
                        echo '<select class="hidescroll" name="shelf5_points" size="8">';
                        //echo '<option value="0" name="0">0</selection>';
                        $shelf5_points = 0;
                        while ($shelf5_points < 301) {
                            if ($shelf5_points == 0) {
                            echo '<option value="'.$shelf5_points.'" name="horizontal_selection" autofocus selected>'.$shelf5_points.'</selection>';
                            } else {
                                echo '<option value="'.$shelf5_points.'" name="horizontal_selection">'.$shelf5_points.'</selection>';
                            }
                            $shelf5_points++;
                        }
                        echo '</select>';
                        echo '</div>';
                       //-----------------------------------------------------
                        break;
                    default:
                        echo '!Error!';
                    }
                }
            
            
            /* echo 'Pallets';
            echo '<input type="text" name="pallet_points" value="0"></input>'; */
           //-----------------------------------------------------
           echo '<div class="horizontal_checkbox">';
           echo '<h1 class="selection_title">Pallets</h1>';
            echo '<select class="hidescroll" name="pallet_points" size="8">';
            //echo '<option value="0" name="0">0</selection>';
            $pallets = 0;
            while ($pallets < 12) {
                if ($pallets == 0) {
                echo '<option value="'.$pallets.'" name="horizontal_selection" autofocus selected>'.$pallets.'</selection>';
                } else {
                    echo '<option value="'.$pallets.'" name="horizontal_selection">'.$pallets.'</selection>';
                }
                $pallets = $pallets + 0.5;
            }
            echo '</select>';
            echo '</div>';
           //-----------------------------------------------------
            
            
            echo '<div class="horizontal_checkbox">';
           echo '<h1 class="selection_title">Empty shelf</h1>';
            echo '<input type="hidden" name="empty_points" value="0"></input>';
            echo '<input class="empty_checkbox" type="checkbox" name="empty_points" value="1"></input>';
            echo '</div>';
            } else { /////////////////////////////////////////// IF THERE ARE PRODUCTS ALREADY IN THE SHELF //////////////////////////////////////////////
            // IF THE COUNTER IS SOMETHING ELSE THAN 0 IT MEANS THE PRODUCT IS ALREADY IN THE POINTS TABLE, THEN WE HAVE TO GET THE CURRENT DATA FROM DATABASE SO THAT THE SELECTION REMEMBERS WHAT THE PREVIOUS INPUTS WHERE
            $points_info = $wpdb->get_results("SELECT * FROM points WHERE id_report =".$report_id." AND id_product =".$id_product."");
            foreach ($points_info as $points) {
            if ($id_category == 1 or $id_category == 2 or $id_category == 4) {
                switch ($paper_shelves) {
                    case 0:
                        echo 'There are currently 0 shelves set for your store. Please edit the settings';
                        break;
                    case 1:
                        //-----------------------------------------------------
                       echo '<div class="horizontal_checkbox">';
                       echo '<h1 class="selection_title">Shelf 1</h1>';
                        echo '<select class="hidescroll" name="shelf1_points" size="8">';
                        //echo '<option value="0" name="0">0</selection>';
                        $shelf1_points = 0;
                        
                        while ($shelf1_points < 301) {
                            if ($shelf1_points == $points->shelf1_points) {
                            echo '<option value="'.$shelf1_points.'" name="horizontal_selection" autofocus selected>'.$shelf1_points.'</selection>';
                            } else {
                                echo '<option value="'.$shelf1_points.'" name="horizontal_selection">'.$shelf1_points.'</selection>';
                            }
                            $shelf1_points++;
                        }
                        echo '</select>';
                        echo '</div>';
                       //-----------------------------------------------------
                        /* echo 'Shelf 1';
                        echo '<input type="text" name="shelf1_points" value="0"></input>';
                        echo '<br>'; */
                        break;
                    case 2:
                        //-----------------------------------------------------
                       echo '<div class="horizontal_checkbox">';
                       echo '<h1 class="selection_title">Shelf 1</h1>';
                        echo '<select class="hidescroll" name="shelf1_points" size="8">';
                        //echo '<option value="0" name="0">0</selection>';
                        $shelf1_points = 0;
                        while ($shelf1_points < 301) {
                            if ($shelf1_points == $points->shelf1_points) {
                            echo '<option value="'.$shelf1_points.'" name="horizontal_selection" autofocus selected>'.$shelf1_points.'</selection>';
                            } else {
                                echo '<option value="'.$shelf1_points.'" name="horizontal_selection">'.$shelf1_points.'</selection>';
                            }
                            $shelf1_points++;
                        }
                        echo '</select>';
                        echo '</div>';
                       //-----------------------------------------------------
                        //-----------------------------------------------------
                       echo '<div class="horizontal_checkbox">';
                       echo '<h1 class="selection_title">Shelf 2</h1>';
                        echo '<select class="hidescroll" name="shelf2_points" size="8">';
                        //echo '<option value="0" name="0">0</selection>';
                        $shelf2_points = 0;
                        while ($shelf2_points < 301) {
                            if ($shelf2_points == $points->shelf2_points) {
                            echo '<option value="'.$shelf2_points.'" name="horizontal_selection" autofocus selected>'.$shelf2_points.'</selection>';
                            } else {
                                echo '<option value="'.$shelf2_points.'" name="horizontal_selection">'.$shelf2_points.'</selection>';
                            }
                            $shelf2_points++;
                        }
                        echo '</select>';
                        echo '</div>';
                       //-----------------------------------------------------
                        break;
                    case 3:
                        //-----------------------------------------------------
                       echo '<div class="horizontal_checkbox">';
                       echo '<h1 class="selection_title">Shelf 1</h1>';
                        echo '<select class="hidescroll" name="shelf1_points" size="8">';
                        //echo '<option value="0" name="0">0</selection>';
                        $shelf1_points = 0;
                        while ($shelf1_points < 301) {
                            if ($shelf1_points == $points->shelf1_points) {
                            echo '<option value="'.$shelf1_points.'" name="horizontal_selection" autofocus selected>'.$shelf1_points.'</selection>';
                            } else {
                                echo '<option value="'.$shelf1_points.'" name="horizontal_selection">'.$shelf1_points.'</selection>';
                            }
                            $shelf1_points++;
                        }
                        echo '</select>';
                        echo '</div>';
                       //-----------------------------------------------------
                        //-----------------------------------------------------
                       echo '<div class="horizontal_checkbox">';
                       echo '<h1 class="selection_title">Shelf 2</h1>';
                        echo '<select class="hidescroll" name="shelf2_points" size="8">';
                        //echo '<option value="0" name="0">0</selection>';
                        $shelf2_points = 0;
                        while ($shelf2_points < 301) {
                            if ($shelf2_points == $points->shelf2_points) {
                            echo '<option value="'.$shelf2_points.'" name="horizontal_selection" autofocus selected>'.$shelf2_points.'</selection>';
                            } else {
                                echo '<option value="'.$shelf2_points.'" name="horizontal_selection">'.$shelf2_points.'</selection>';
                            }
                            $shelf2_points++;
                        }
                        echo '</select>';
                        echo '</div>';
                       //-----------------------------------------------------
                        //-----------------------------------------------------
                       echo '<div class="horizontal_checkbox">';
                       echo '<h1 class="selection_title">Shelf 3</h1>';
                        echo '<select class="hidescroll" name="shelf3_points" size="8">';
                        //echo '<option value="0" name="0">0</selection>';
                        $shelf3_points = 0;
                        while ($shelf3_points < 301) {
                            if ($shelf3_points == $points->shelf3_points) {
                            echo '<option value="'.$shelf3_points.'" name="horizontal_selection" autofocus selected>'.$shelf3_points.'</selection>';
                            } else {
                                echo '<option value="'.$shelf3_points.'" name="horizontal_selection">'.$shelf3_points.'</selection>';
                            }
                            $shelf3_points++;
                        }
                        echo '</select>';
                        echo '</div>';
                       //-----------------------------------------------------
                        break;
                    case 4:
                        //-----------------------------------------------------
                       echo '<div class="horizontal_checkbox">';
                       echo '<h1 class="selection_title">Shelf 1</h1>';
                        echo '<select class="hidescroll" name="shelf1_points" size="8">';
                        //echo '<option value="0" name="0">0</selection>';
                        $shelf1_points = 0;
                        while ($shelf1_points < 301) {
                            if ($shelf1_points == $points->shelf1_points) {
                            echo '<option value="'.$shelf1_points.'" name="horizontal_selection" autofocus selected>'.$shelf1_points.'</selection>';
                            } else {
                                echo '<option value="'.$shelf1_points.'" name="horizontal_selection">'.$shelf1_points.'</selection>';
                            }
                            $shelf1_points++;
                        }
                        echo '</select>';
                        echo '</div>';
                       //-----------------------------------------------------
                        //-----------------------------------------------------
                       echo '<div class="horizontal_checkbox">';
                       echo '<h1 class="selection_title">Shelf 2</h1>';
                        echo '<select class="hidescroll" name="shelf2_points" size="8">';
                        //echo '<option value="0" name="0">0</selection>';
                        $shelf2_points = 0;
                        while ($shelf2_points < 301) {
                            if ($shelf2_points == $points->shelf2_points) {
                            echo '<option value="'.$shelf2_points.'" name="horizontal_selection" autofocus selected>'.$shelf2_points.'</selection>';
                            } else {
                                echo '<option value="'.$shelf2_points.'" name="horizontal_selection">'.$shelf2_points.'</selection>';
                            }
                            $shelf2_points++;
                        }
                        echo '</select>';
                        echo '</div>';
                       //-----------------------------------------------------
                        //-----------------------------------------------------
                       echo '<div class="horizontal_checkbox">';
                       echo '<h1 class="selection_title">Shelf 3</h1>';
                        echo '<select class="hidescroll" name="shelf3_points" size="8">';
                        //echo '<option value="0" name="0">0</selection>';
                        $shelf3_points = 0;
                        while ($shelf3_points < 301) {
                            if ($shelf3_points == $points->shelf3_points) {
                            echo '<option value="'.$shelf3_points.'" name="horizontal_selection" autofocus selected>'.$shelf3_points.'</selection>';
                            } else {
                                echo '<option value="'.$shelf3_points.'" name="horizontal_selection">'.$shelf3_points.'</selection>';
                            }
                            $shelf3_points++;
                        }
                        echo '</select>';
                        echo '</div>';
                       //-----------------------------------------------------
                        //-----------------------------------------------------
                       echo '<div class="horizontal_checkbox">';
                       echo '<h1 class="selection_title">Shelf 4</h1>';
                        echo '<select class="hidescroll" name="shelf4_points" size="8">';
                        //echo '<option value="0" name="0">0</selection>';
                        $shelf4_points = 0;
                        while ($shelf4_points < 301) {
                            if ($shelf4_points == $points->shelf4_points) {
                            echo '<option value="'.$shelf4_points.'" name="horizontal_selection" autofocus selected>'.$shelf4_points.'</selection>';
                            } else {
                                echo '<option value="'.$shelf4_points.'" name="horizontal_selection">'.$shelf4_points.'</selection>';
                            }
                            $shelf4_points++;
                        }
                        echo '</select>';
                        echo '</div>';
                       //-----------------------------------------------------
                        break;
                    case 5:
                        /*echo 'Shelf 1';
                        echo '<input type="text" name="shelf1_points" value="0"></input>';
                        echo 'Shelf 2';
                        echo '<input type="text" name="shelf2_points" value="0"></input>';
                        echo 'Shelf 3';
                        echo '<input type="text" name="shelf3_points" value="0"></input>';
                        echo 'Shelf 4';
                        echo '<input type="text" name="shelf4_points" value="0"></input>';
                        echo 'Shelf 5';
                        echo '<input type="text" name="shelf5_points" value="0"></input>';*/
                        //-----------------------------------------------------
                       echo '<div class="horizontal_checkbox">';
                       echo '<h1 class="selection_title">Shelf 1</h1>';
                        echo '<select class="hidescroll" name="shelf1_points" size="8">';
                        //echo '<option value="0" name="0">0</selection>';
                        $shelf1_points = 0;
                        while ($shelf1_points < 301) {
                            if ($shelf1_points == $points->shelf1_points) {
                            echo '<option value="'.$shelf1_points.'" name="horizontal_selection" autofocus selected>'.$shelf1_points.'</selection>';
                            } else {
                                echo '<option value="'.$shelf1_points.'" name="horizontal_selection">'.$shelf1_points.'</selection>';
                            }
                            $shelf1_points++;
                        }
                        echo '</select>';
                        echo '</div>';
                       //-----------------------------------------------------
                        //-----------------------------------------------------
                       echo '<div class="horizontal_checkbox">';
                       echo '<h1 class="selection_title">Shelf 2</h1>';
                        echo '<select class="hidescroll" name="shelf2_points" size="8">';
                        //echo '<option value="0" name="0">0</selection>';
                        $shelf2_points = 0;
                        while ($shelf2_points < 301) {
                            if ($shelf2_points == $points->shelf2_points) {
                            echo '<option value="'.$shelf2_points.'" name="horizontal_selection" autofocus selected>'.$shelf2_points.'</selection>';
                            } else {
                                echo '<option value="'.$shelf2_points.'" name="horizontal_selection">'.$shelf2_points.'</selection>';
                            }
                            $shelf2_points++;
                        }
                        echo '</select>';
                        echo '</div>';
                       //-----------------------------------------------------
                        //-----------------------------------------------------
                       echo '<div class="horizontal_checkbox">';
                       echo '<h1 class="selection_title">Shelf 3</h1>';
                        echo '<select class="hidescroll" name="shelf3_points" size="8">';
                        //echo '<option value="0" name="0">0</selection>';
                        $shelf3_points = 0;
                        while ($shelf3_points < 301) {
                            if ($shelf3_points == $points->shelf3_points) {
                            echo '<option value="'.$shelf3_points.'" name="horizontal_selection" autofocus selected>'.$shelf3_points.'</selection>';
                            } else {
                                echo '<option value="'.$shelf3_points.'" name="horizontal_selection">'.$shelf3_points.'</selection>';
                            }
                            $shelf3_points++;
                        }
                        echo '</select>';
                        echo '</div>';
                       //-----------------------------------------------------
                        //-----------------------------------------------------
                       echo '<div class="horizontal_checkbox">';
                       echo '<h1 class="selection_title">Shelf 4</h1>';
                        echo '<select class="hidescroll" name="shelf4_points" size="8">';
                        //echo '<option value="0" name="0">0</selection>';
                        $shelf4_points = 0;
                        while ($shelf4_points < 301) {
                            if ($shelf4_points == $points->shelf4_points) {
                            echo '<option value="'.$shelf4_points.'" name="horizontal_selection" autofocus selected>'.$shelf4_points.'</selection>';
                            } else {
                                echo '<option value="'.$shelf4_points.'" name="horizontal_selection">'.$shelf4_points.'</selection>';
                            }
                            $shelf4_points++;
                        }
                        echo '</select>';
                        echo '</div>';
                       //-----------------------------------------------------
                        //-----------------------------------------------------
                       echo '<div class="horizontal_checkbox">';
                       echo '<h1 class="selection_title">Shelf 5</h1>';
                        echo '<select class="hidescroll" name="shelf5_points" size="8">';
                        //echo '<option value="0" name="0">0</selection>';
                        $shelf5_points = 0;
                        while ($shelf5_points < 301) {
                            if ($shelf5_points == $points->shelf5_points) {
                            echo '<option value="'.$shelf5_points.'" name="horizontal_selection" autofocus selected>'.$shelf5_points.'</selection>';
                            } else {
                                echo '<option value="'.$shelf5_points.'" name="horizontal_selection">'.$shelf5_points.'</selection>';
                            }
                            $shelf5_points++;
                        }
                        echo '</select>';
                        echo '</div>';
                       //-----------------------------------------------------
                        break;
                    default:
                        echo '!Error!';
                    }
                } elseif ($id_category == 3 or $id_category == 5) {
                    switch ($hank_shelves) {
                    case 0:
                        echo 'There are currently 0 shelves set for your store. Please edit the settings';
                        break;
                    case 1:
                        //-----------------------------------------------------
                       echo '<div class="horizontal_checkbox">';
                       echo '<h1 class="selection_title">Shelf 1</h1>';
                        echo '<select class="hidescroll" name="shelf1_points" size="8">';
                        //echo '<option value="0" name="0">0</selection>';
                        $shelf1_points = 0;
                        while ($shelf1_points < 301) {
                            if ($shelf1_points == $points->shelf1_points) {
                            echo '<option value="'.$shelf1_points.'" name="horizontal_selection" autofocus selected>'.$shelf1_points.'</selection>';
                            } else {
                                echo '<option value="'.$shelf1_points.'" name="horizontal_selection">'.$shelf1_points.'</selection>';
                            }
                            $shelf1_points++;
                        }
                        echo '</select>';
                        echo '</div>';
                       //-----------------------------------------------------
                        break;
                    case 2:
                        //-----------------------------------------------------
                       echo '<div class="horizontal_checkbox">';
                       echo '<h1 class="selection_title">Shelf 1</h1>';
                        echo '<select class="hidescroll" name="shelf1_points" size="8">';
                        //echo '<option value="0" name="0">0</selection>';
                        $shelf1_points = 0;
                        while ($shelf1_points < 301) {
                            if ($shelf1_points == $points->shelf1_points) {
                            echo '<option value="'.$shelf1_points.'" name="horizontal_selection" autofocus selected>'.$shelf1_points.'</selection>';
                            } else {
                                echo '<option value="'.$shelf1_points.'" name="horizontal_selection">'.$shelf1_points.'</selection>';
                            }
                            $shelf1_points++;
                        }
                        echo '</select>';
                        echo '</div>';
                       //-----------------------------------------------------
                        //-----------------------------------------------------
                       echo '<div class="horizontal_checkbox">';
                       echo '<h1 class="selection_title">Shelf 2</h1>';
                        echo '<select class="hidescroll" name="shelf2_points" size="8">';
                        //echo '<option value="0" name="0">0</selection>';
                        $shelf2_points = 0;
                        while ($shelf2_points < 301) {
                            if ($shelf2_points == $points->shelf2_points) {
                            echo '<option value="'.$shelf2_points.'" name="horizontal_selection" autofocus selected>'.$shelf2_points.'</selection>';
                            } else {
                                echo '<option value="'.$shelf2_points.'" name="horizontal_selection">'.$shelf2_points.'</selection>';
                            }
                            $shelf2_points++;
                        }
                        echo '</select>';
                        echo '</div>';
                       //-----------------------------------------------------
                        break;
                    case 3:
                        //-----------------------------------------------------
                       echo '<div class="horizontal_checkbox">';
                       echo '<h1 class="selection_title">Shelf 1</h1>';
                        echo '<select class="hidescroll" name="shelf1_points" size="8">';
                        //echo '<option value="0" name="0">0</selection>';
                        $shelf1_points = 0;
                        while ($shelf1_points < 301) {
                            if ($shelf1_points == $points->shelf1_points) {
                            echo '<option value="'.$shelf1_points.'" name="horizontal_selection" autofocus selected>'.$shelf1_points.'</selection>';
                            } else {
                                echo '<option value="'.$shelf1_points.'" name="horizontal_selection">'.$shelf1_points.'</selection>';
                            }
                            $shelf1_points++;
                        }
                        echo '</select>';
                        echo '</div>';
                       //-----------------------------------------------------
                        //-----------------------------------------------------
                       echo '<div class="horizontal_checkbox">';
                       echo '<h1 class="selection_title">Shelf 2</h1>';
                        echo '<select class="hidescroll" name="shelf2_points" size="8">';
                        //echo '<option value="0" name="0">0</selection>';
                        $shelf2_points = 0;
                        while ($shelf2_points < 301) {
                            if ($shelf2_points == $points->shelf2_points) {
                            echo '<option value="'.$shelf2_points.'" name="horizontal_selection" autofocus selected>'.$shelf2_points.'</selection>';
                            } else {
                                echo '<option value="'.$shelf2_points.'" name="horizontal_selection">'.$shelf2_points.'</selection>';
                            }
                            $shelf2_points++;
                        }
                        echo '</select>';
                        echo '</div>';
                       //-----------------------------------------------------
                        //-----------------------------------------------------
                       echo '<div class="horizontal_checkbox">';
                       echo '<h1 class="selection_title">Shelf 3</h1>';
                        echo '<select class="hidescroll" name="shelf3_points" size="8">';
                        //echo '<option value="0" name="0">0</selection>';
                        $shelf3_points = 0;
                        while ($shelf3_points < 301) {
                            if ($shelf3_points == $points->shelf3_points) {
                            echo '<option value="'.$shelf3_points.'" name="horizontal_selection" autofocus selected>'.$shelf3_points.'</selection>';
                            } else {
                                echo '<option value="'.$shelf3_points.'" name="horizontal_selection">'.$shelf3_points.'</selection>';
                            }
                            $shelf3_points++;
                        }
                        echo '</select>';
                        echo '</div>';
                       //-----------------------------------------------------
                        break;
                    case 4:
                        //-----------------------------------------------------
                       echo '<div class="horizontal_checkbox">';
                       echo '<h1 class="selection_title">Shelf 1</h1>';
                        echo '<select class="hidescroll" name="shelf1_points" size="8">';
                        //echo '<option value="0" name="0">0</selection>';
                        $shelf1_points = 0;
                        while ($shelf1_points < 301) {
                            if ($shelf1_points == $points->shelf1_points) {
                            echo '<option value="'.$shelf1_points.'" name="horizontal_selection" autofocus selected>'.$shelf1_points.'</selection>';
                            } else {
                                echo '<option value="'.$shelf1_points.'" name="horizontal_selection">'.$shelf1_points.'</selection>';
                            }
                            $shelf1_points++;
                        }
                        echo '</select>';
                        echo '</div>';
                       //-----------------------------------------------------
                        //-----------------------------------------------------
                       echo '<div class="horizontal_checkbox">';
                       echo '<h1 class="selection_title">Shelf 2</h1>';
                        echo '<select class="hidescroll" name="shelf2_points" size="8">';
                        //echo '<option value="0" name="0">0</selection>';
                        $shelf2_points = 0;
                        while ($shelf2_points < 301) {
                            if ($shelf2_points == $points->shelf2_points) {
                            echo '<option value="'.$shelf2_points.'" name="horizontal_selection" autofocus selected>'.$shelf2_points.'</selection>';
                            } else {
                                echo '<option value="'.$shelf2_points.'" name="horizontal_selection">'.$shelf2_points.'</selection>';
                            }
                            $shelf2_points++;
                        }
                        echo '</select>';
                        echo '</div>';
                       //-----------------------------------------------------
                        //-----------------------------------------------------
                       echo '<div class="horizontal_checkbox">';
                       echo '<h1 class="selection_title">Shelf 3</h1>';
                        echo '<select class="hidescroll" name="shelf3_points" size="8">';
                        //echo '<option value="0" name="0">0</selection>';
                        $shelf3_points = 0;
                        while ($shelf3_points < 301) {
                            if ($shelf3_points == $points->shelf3_points) {
                            echo '<option value="'.$shelf3_points.'" name="horizontal_selection" autofocus selected>'.$shelf3_points.'</selection>';
                            } else {
                                echo '<option value="'.$shelf3_points.'" name="horizontal_selection">'.$shelf3_points.'</selection>';
                            }
                            $shelf3_points++;
                        }
                        echo '</select>';
                        echo '</div>';
                       //-----------------------------------------------------
                        //-----------------------------------------------------
                       echo '<div class="horizontal_checkbox">';
                       echo '<h1 class="selection_title">Shelf 4</h1>';
                        echo '<select class="hidescroll" name="shelf4_points" size="8">';
                        //echo '<option value="0" name="0">0</selection>';
                        $shelf4_points = 0;
                        while ($shelf4_points < 301) {
                            if ($shelf4_points == $points->shelf4_points) {
                            echo '<option value="'.$shelf4_points.'" name="horizontal_selection" autofocus selected>'.$shelf4_points.'</selection>';
                            } else {
                                echo '<option value="'.$shelf4_points.'" name="horizontal_selection">'.$shelf4_points.'</selection>';
                            }
                            $shelf4_points++;
                        }
                        echo '</select>';
                        echo '</div>';
                       //-----------------------------------------------------
                        break;
                    case 5:
                        //-----------------------------------------------------
                       echo '<div class="horizontal_checkbox">';
                       echo '<h1 class="selection_title">Shelf 1</h1>';
                        echo '<select class="hidescroll" name="shelf1_points" size="8">';
                        //echo '<option value="0" name="0">0</selection>';
                        $shelf1_points = 0;
                        while ($shelf1_points < 301) {
                            if ($shelf1_points == $points->shelf1_points) {
                            echo '<option value="'.$shelf1_points.'" name="horizontal_selection" autofocus selected>'.$shelf1_points.'</selection>';
                            } else {
                                echo '<option value="'.$shelf1_points.'" name="horizontal_selection">'.$shelf1_points.'</selection>';
                            }
                            $shelf1_points++;
                        }
                        echo '</select>';
                        echo '</div>';
                       //-----------------------------------------------------
                        //-----------------------------------------------------
                       echo '<div class="horizontal_checkbox">';
                       echo '<h1 class="selection_title">Shelf 2</h1>';
                        echo '<select class="hidescroll" name="shelf2_points" size="8">';
                        //echo '<option value="0" name="0">0</selection>';
                        $shelf2_points = 0;
                        while ($shelf2_points < 301) {
                            if ($shelf2_points == $points->shelf2_points) {
                            echo '<option value="'.$shelf2_points.'" name="horizontal_selection" autofocus selected>'.$shelf2_points.'</selection>';
                            } else {
                                echo '<option value="'.$shelf2_points.'" name="horizontal_selection">'.$shelf2_points.'</selection>';
                            }
                            $shelf2_points++;
                        }
                        echo '</select>';
                        echo '</div>';
                       //-----------------------------------------------------
                        //-----------------------------------------------------
                       echo '<div class="horizontal_checkbox">';
                       echo '<h1 class="selection_title">Shelf 3</h1>';
                        echo '<select class="hidescroll" name="shelf3_points" size="8">';
                        //echo '<option value="0" name="0">0</selection>';
                        $shelf3_points = 0;
                        while ($shelf3_points < 301) {
                            if ($shelf3_points == $points->shelf3_points) {
                            echo '<option value="'.$shelf3_points.'" name="horizontal_selection" autofocus selected>'.$shelf3_points.'</selection>';
                            } else {
                                echo '<option value="'.$shelf3_points.'" name="horizontal_selection">'.$shelf3_points.'</selection>';
                            }
                            $shelf3_points++;
                        }
                        echo '</select>';
                        echo '</div>';
                       //-----------------------------------------------------
                        //-----------------------------------------------------
                       echo '<div class="horizontal_checkbox">';
                       echo '<h1 class="selection_title">Shelf 4</h1>';
                        echo '<select class="hidescroll" name="shelf4_points" size="8">';
                        //echo '<option value="0" name="0">0</selection>';
                        $shelf4_points = 0;
                        while ($shelf4_points < 301) {
                            if ($shelf4_points == $points->shelf4_points) {
                            echo '<option value="'.$shelf4_points.'" name="horizontal_selection" autofocus selected>'.$shelf4_points.'</selection>';
                            } else {
                                echo '<option value="'.$shelf4_points.'" name="horizontal_selection">'.$shelf4_points.'</selection>';
                            }
                            $shelf4_points++;
                        }
                        echo '</select>';
                        echo '</div>';
                       //-----------------------------------------------------
                        //-----------------------------------------------------
                       echo '<div class="horizontal_checkbox">';
                       echo '<h1 class="selection_title">Shelf 5</h1>';
                        echo '<select class="hidescroll" name="shelf5_points" size="8">';
                        //echo '<option value="0" name="0">0</selection>';
                        $shelf5_points = 0;
                        while ($shelf5_points < 301) {
                            if ($shelf5_points == $points->shelf5_points) {
                            echo '<option value="'.$shelf5_points.'" name="horizontal_selection" autofocus selected>'.$shelf5_points.'</selection>';
                            } else {
                                echo '<option value="'.$shelf5_points.'" name="horizontal_selection">'.$shelf5_points.'</selection>';
                            }
                            $shelf5_points++;
                        }
                        echo '</select>';
                        echo '</div>';
                       //-----------------------------------------------------
                        break;
                    default:
                        echo '!Error!';
                    }
                }
            
            
            /* echo 'Pallets';
            echo '<input type="text" name="pallet_points" value="0"></input>'; */
           //-----------------------------------------------------
           echo '<div class="horizontal_checkbox">';
           echo '<h1 class="selection_title">Pallets</h1>';
            echo '<select class="hidescroll" name="pallet_points" size="8">';
            //echo '<option value="0" name="0">0</selection>';
            $pallets = 0;
            while ($pallets < 12) {
                if ($pallets == $points->pallet_points) {
                echo '<option value="'.$pallets.'" name="horizontal_selection" autofocus selected>'.$pallets.'</selection>';
                } else {
                    echo '<option value="'.$pallets.'" name="horizontal_selection">'.$pallets.'</selection>';
                }
                $pallets = $pallets + 0.5;
            }
            echo '</select>';
            echo '</div>';
           //-----------------------------------------------------
            
            
            echo '<div class="horizontal_checkbox">';
           echo '<h1 class="selection_title">Empty shelf</h1>';
            echo '<input type="hidden" name="empty_points" value="0"></input>';
            //echo '<input class="empty_checkbox" type="checkbox" name="empty_points" value="1"></input>';
                
                if ($points->empty_points == 1) {
                    echo '<input class="empty_checkbox" type="checkbox" name="empty_points" value="1" checked></input>';
                } else {
                    echo '<input class="empty_checkbox" type="checkbox" name="empty_points" value="1"></input>';
                }
                
            echo '</div>';
            }} /////////////////////////////////////////// IF THERE ARE PRODUCTS ALREADY IN THE SHELF
            
            //HERE WE GET THE HIDDEN INPUTS FOR EACH PRODUCT THAT ARE NEEDED 
            echo '<input type="hidden" name="id_product" value="'.$id_product.'"></input>';
           echo '<input type="hidden" name="id_producer" value="'.$id_producer.'"></input>';
           echo '<input type="hidden" name="id_label" value="'.$id_label.'"></input>';
           echo '<input type="hidden" name="id_subcat" value="'.$id_subcat.'"></input>';
           echo '<input type="hidden" name="id_category" value="'.$id_category.'"></input>';
           echo '<input type="hidden" name="name_product" value="'.$name_product.'"></input>';
           echo '<input type="hidden" name="ean_product" value="'.$ean_product.'"></input>';
           echo '<input type="hidden" name="width_product" value="'.$width_product.'"></input>';
           echo '<input type="hidden" name="height_product" value="'.$height_product.'"></input>';
           echo '<input type="hidden" name="depth_product" value="'.$depth_product.'"></input>';
            echo '<input type="hidden" name="id_store" value="'.$store_id.'"></input>';
           echo '<input type="hidden" name="id_store_chain" value="'.$storechain_id.'"></input>';
           echo '<input type="hidden" name="id_main_chain" value="'.$mainchain_id.'"></input>';
            echo '<input class="report-item" type="submit" name="addpoints" value="Add points"></input>';
            echo '</form>';
            }
            if(isset($_POST['addpoints'])) { //CHECK IF ADD POINTS BUTTON IS CLICKED
                
                
                //STORING ALL INPUTS FROM EITHER PRODUCTS ALREADY IN SHELF OR NOT DEPENDING WHAT WAS ECHOED
                $shelf1_points = $_POST['shelf1_points'];
                $shelf2_points = $_POST['shelf2_points'];
                $shelf3_points = $_POST['shelf3_points'];
                $shelf4_points = $_POST['shelf4_points'];
                $shelf5_points = $_POST['shelf5_points'];
                $pallet_points = $_POST['pallet_points'];
                $empty_points = $_POST['empty_points'];
                
                $name_placeholder = $_POST['name_placeholder']; //IF PRODUCT WAS PLACEHOLDER WE ALSO GET THE NAME THAT WAS PLACED
                $ean_placeholder = $_POST['ean_placeholder'];   //IF PRODUCT WAS PLACEHOLDER WE ALSO GET THE EAN THAT WAS PLACED
                
                $id_product = $_POST["id_product"]; 
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
                $report_id = $_GET["idr"];
                $id_store = $_POST["id_store"];
                $id_store_chain = $_POST["id_store_chain"];
                $id_main_chain = $_POST["id_main_chain"];
                
                
                //PALLET INFO HARD CODED AS WE DIDNT HAVE TIME TO ADD THEM
                $euro_pallet_width = 800;
                $euro_pallet_depth = 1200;
                $euro_pallet_height = 2400;
                
                $hank_pallet_width = 800;
                $hank_pallet_depth = 800;
                $hank_pallet_height = 1100;
                
                
                $productinfo = $wpdb->get_results("SELECT * FROM product WHERE id_product = ".$id_product."");
                $wpdb->last_query;
                foreach ($productinfo as $shelves) {
                    $width = $shelves->width_product;
                    $height = $shelves->height_product;
                    $depth = $shelves->depth_product;
                }
                
                $shelf_info = $wpdb->get_results("SELECT * FROM store_settings WHERE id_store_settings = ".$settings_id."");
                foreach ($shelf_info as $shelves) {
                    $paper_depth = $shelves->paper_depth;
                    $hank_depth = $shelves->hank_depth;
                }
                
                if ($id_category == 3) { //CALCULATING THE FACES FOR PRODUCT AND THEN HOW MANY PRODUCTS SHOULD BE IN THE SHELF 
                    $productcount_points1 = floor($hank_depth / $depth) * $shelf1_points;
                    $productcount_points2 = floor($hank_depth / $depth) * $shelf2_points;
                    $productcount_points3 = floor($hank_depth / $depth) * $shelf3_points;
                    $productcount_points4 = floor($hank_depth / $depth) * $shelf4_points;
                    $productcount_points5 = floor($hank_depth / $depth) * $shelf5_points;
                    
                    $pallet_products_width = floor($hank_pallet_depth / $width * $pallet_points);
                    $pallet_products_depth = floor($hank_pallet_width / $depth);
                    $pallet_products_height = floor($hank_pallet_height / $height);
                    
                    $pallet_points_count = $pallet_products_width * $pallet_products_depth * $pallet_products_height;
                    
                    $finalpoints = $productcount_points1 + $productcount_points2 + $productcount_points3 + $productcount_points4 + $productcount_points5;
                } elseif ($id_category == 1 or 2) { //CALCULATING THE FACES FOR PRODUCT AND THEN HOW MANY PRODUCTS SHOULD BE IN THE SHELF 
                    $productcount_points1 = floor($paper_depth / $depth) * $shelf1_points;
                    $productcount_points2 = floor($paper_depth / $depth) * $shelf2_points;
                    $productcount_points3 = floor($paper_depth / $depth) * $shelf3_points;
                    $productcount_points4 = floor($paper_depth / $depth) * $shelf4_points;
                    $productcount_points5 = floor($paper_depth / $depth) * $shelf5_points;
                    
                    $pallet_products_width = floor($euro_pallet_depth / $width * $pallet_points);
                    $pallet_products_depth = floor($euro_pallet_width / $depth);
                    $pallet_products_height = floor($euro_pallet_height / $height);
                    
                    $pallet_points_count = $pallet_products_width * $pallet_products_depth * $pallet_products_height;
                    
                    $finalpoints = $productcount_points1 + $productcount_points2 + $productcount_points3 + $productcount_points4 + $productcount_points5;
                    $total_products = $pallet_points_count + $finalpoints;
                }
                if ($id_product == 666) { //IF PRODUCT IS HOTO TOTI PLACEHOLDER THE VALUE NEEDS TO MATCH THE PRODUCT ID THAT IS MADE AS A PLACEHOLDER, ON LIVE SITE THE PLACEHOLDER IDS ARE 100 AND 101
                 $id_producer = 9; //PLACEHOLDER ID
                 $id_label = 13; //PLACEHOLDER ID
                 $id_category = 4; //PLACEHOLDER ID
                 $id_subcat = 11; //PLACEHOLDER ID
                     
                    
                //INSERTING THE PLACEHOLDER PRODUCT TO PRODUCTS 
                $wpdb->insert( 
	           'product', 
                   array( 
                        'id_producer' => $id_producer,
                        'id_label' => $id_label,
                        'id_category' => $id_category,
                        'id_subcat' => $id_subcat,
                        'ean_product' => $ean_placeholder,
                        'name_product' => $name_placeholder,
                        'width_product' => 150,
                        'height_product' => 150,
                        'depth_product' => 150,
                        'desc_product' => 'Placeholder for report ' .$report_id
                   ), 
                   array( 
                        '%d',
                        '%d',
                        '%d',
                          '%d',	// value1 %d is for integers
                          '%d',// value2 %s is for strings
                        '%s',
                        '%d',
                        '%d',
                        '%d',
                        '%s'

                   ));    
                    
                $id_product = $wpdb->insert_id; // GETTING THE ID OF THE PRODUCT WE JUST INSERTED
                    
                //INSERTING THE PRODUCT TO POINTS AS WE NEED TO FIRST CREATE IT TO GET THE PRODUCT ID
                $wpdb->insert(
                'points',
                array (
                    'id_report' => $report_id,
                    'id_main_chain' => $id_main_chain,
                    'id_store_chain' => $id_store_chain,
                    'id_store' => $id_store,
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
                    'id_store_settings' => $settings_id,
                    'productcount_points' => $finalpoints,
                    'pallet_productcount_points' => $pallet_points_count
                ),array( 
                    '%d', 
                    '%d',
                    '%d',
                    '%d', 
                    '%d',
                    '%d', 
                    '%d', 
                    '%d',
                    '%d', 
                    '%d',
                    '%d', 
                    '%d',
                    '%d', 
                    '%d', 
                    '%s',
                    '%d',
                    '%d',
                    '%d',
                    '%d'
	           ) 
            ); 
                    //THEN WE NEED TO DELETE THE PLACEHOLDER PRODUCT WE INSERTED TO THE POINTS, WE GET THE ID 
                    $wpdb->delete( 'points', array( 'id_points' => $id_points ), array( '%d' ) );
                    
                    echo '<div class="fairshare-container">';   
                        echo '<h1 class="product-store-name">'. $name_placeholder . ' added </h1>';
                        echo '<br>';
                        echo '</div>';
                    
                } elseif ($id_product == 101) {
                $id_producer = 9;
                 $id_label = 13;
                 $id_category = 5;
                 $id_subcat = 11;
                     
                $wpdb->insert( 
	           'product', 
                   array( 
                        'id_producer' => $id_producer,
                        'id_label' => $id_label,
                        'id_category' => $id_category,
                        'id_subcat' => $id_subcat,
                        'ean_product' => 1234567890,
                        'name_product' => $name_placeholder,
                        'width_product' => 150,
                        'height_product' => 150,
                        'depth_product' => 150,
                        'desc_product' => 'Placeholder for report ' .$report_id
                   ), 
                   array( 
                        '%d',
                        '%d',
                        '%d',
                          '%d',	// value1 %d is for integers
                          '%d',// value2 %s is for strings
                        '%s',
                        '%d',
                        '%d',
                        '%d',
                        '%s'

                   ));    
                    
                $id_product = $wpdb->insert_id;    
                $wpdb->insert(
                'points',
                array (
                    'id_report' => $report_id,
                    'id_main_chain' => $id_main_chain,
                    'id_store_chain' => $id_store_chain,
                    'id_store' => $id_store,
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
                    'id_store_settings' => $settings_id,
                    'productcount_points' => $finalpoints,
                    'pallet_productcount_points' => $pallet_points_count
                ),array( 
                    '%d', 
                    '%d',
                    '%d',
                    '%d', 
                    '%d',
                    '%d', 
                    '%d', 
                    '%d',
                    '%d', 
                    '%d',
                    '%d', 
                    '%d',
                    '%d', 
                    '%d', 
                    '%s',
                    '%d',
                    '%d',
                    '%d',
                    '%d'
	           ) 
            ); 
                    
                    $wpdb->delete( 'points', array( 'id_points' => $id_points ), array( '%d' ) ); 
                        echo '<div class="fairshare-container">';   
                        echo '<h1 class="product-store-name">'. $name_placeholder . ' added </h1>';
                        echo '<br>';
                        echo '</div>';
                } else {
                // $products_in_points = $wpdb->get_results("SELECT * FROM points WHERE id_report =".$id_report."");
                $products_in_points = $wpdb->get_results("SELECT * FROM points");
                $counter = 0;
                foreach ($products_in_points as $check_duplicate) {
                    $r_id = $check_duplicate->id_report;
                    $p_id = $check_duplicate->id_product;
                    if ($r_id == $report_id AND $p_id == $id_product){
                        $counter++;
                    }
                }
                
                $check_if_submit_empty = $shelf1_points + $shelf2_points + $shelf3_points + $shelf4_points + $shelf5_points + $pallet_points + $empty_points + $productcount_points + $pallet_productcount_points;
                
                if ($counter == 0) {
                $addpointstable = $wpdb->insert(
                'points',
                array (
                    'id_report' => $report_id,
                    'id_main_chain' => $id_main_chain,
                    'id_store_chain' => $id_store_chain,
                    'id_store' => $id_store,
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
                    'id_store_settings' => $settings_id,
                    'productcount_points' => $finalpoints,
                    'pallet_productcount_points' => $pallet_points_count
                ),array( 
                    '%d', 
                    '%d',
                    '%d',
                    '%d', 
                    '%d',
                    '%d', 
                    '%d', 
                    '%d',
                    '%d', 
                    '%d',
                    '%d', 
                    '%d',
                    '%d', 
                    '%d', 
                    '%s',
                    '%d',
                    '%d',
                    '%d',
                    '%d'
	           ) 
            ); 
            }  elseif ($check_if_submit_empty == 0) {
                    $id_for_points = $wpdb->get_results("SELECT id_points FROM points WHERE id_report =".$report_id." AND id_product = ".$id_product."");
                    foreach ($id_for_points as $po_id) {
                        $id_points = $po_id->id_points;
                    }  
                    $wpdb->delete( 'points', array( 'id_points' => $id_points ), array( '%d' ) );
                }
                
                elseif ($counter > 0) { //INSTEAD OF ADDING PRODUCT AGAIN TO POINTS IT UPDATES THE ROW WHERE THE PRODUCT IS
                $id_for_points = $wpdb->get_results("SELECT id_points FROM points WHERE id_report =".$report_id." AND id_product = ".$id_product."");
                foreach ($id_for_points as $po_id) {
                    $id_points = $po_id->id_points;
                }    
                    
                $wpdb->update( 
	           'points', 
	           array( 
                    'id_report' => $report_id,
                    'id_main_chain' => $id_main_chain,
                    'id_store_chain' => $id_store_chain,
                    'id_store' => $id_store,
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
                    'id_store_settings' => $settings_id,
                    'productcount_points' => $finalpoints,
                    'pallet_productcount_points' => $pallet_points_count
	           ), 
	           array( 'id_points' => $id_points ),
	           array( 
		          '%d', 
                    '%d',
                    '%d',
                    '%d', 
                    '%d',
                    '%d', 
                    '%d', 
                    '%d',
                    '%d', 
                    '%d',
                    '%d', 
                    '%d',
                    '%d', 
                    '%d', 
                    '%s',
                    '%d',
                    '%d',
                    '%d',
                    '%d'
	           ), 
	           array( '%d' ) );   

                }
            if ($counter == 0) {
            echo '<div class="fairshare-container">';   
            echo '<h1 class="product-store-name">'. $name_product . ' added </h1>';
            echo '<br>';
            echo '<h2 class="product-info"> Products in shelves: '.$finalpoints.'</h2>';
            echo '<br>';
            echo '<h2 class="product-info"> Products in pallets: '.$pallet_points_count.'</h2>';
            echo '<br>';
            echo '<h2 class="product-info"> Total product count: '.$total_products.'</h2>';
            echo '<br>';
            echo '</div>';
            } elseif ($check_if_submit_empty == 0) {
                 echo '<div class="fairshare-container">';   
                echo '<h1 class="product-store-name">'. $name_product . ' deleted </h1>';
                echo '<br>';
                echo '</div>';
            } elseif ($counter > 0) {
                echo '<div class="fairshare-container">';   
                echo '<h1 class="product-store-name">'. $name_product . ' updated </h1>';
                echo '<br>';
                echo '<h2 class="product-info"> Total amount of products in shelves: '.$finalpoints.'</h2>';
                echo '<br>';
                echo '<h2 class="product-info"> Products in pallets: '.$pallet_points_count.'</h2>';
                echo '<br>';
                echo '<h2 class="product-info"> Total product count: '.$total_products.'</h2>';
                echo '<br>';
                echo '</div>';
            }
                
            $id_points = $wpdb->insert_id;
            }
            }

        echo '<h4 id="OpenMe2" class="productlist"> Products in report</h4>'; //Box than will be opened on click with jquery toggle
        echo '<div id="ShowMe2" class="product-list-report">';
            $unique_products = 0;
            $productlist = $wpdb->get_results("SELECT id_product FROM points WHERE id_report =".$report_id."");
            foreach ($productlist as $products) {
                $idname = $products->id_product;
                $mainchains = $wpdb->get_results("SELECT * FROM product WHERE id_product =".$idname.""); //store sql query that selects all from store table and matches the store name with user input
               foreach ($mainchains as $searchresult) {
                   echo '<form method="POST">';
                   echo '<input type="hidden" name="id_store" value="'.$store_id.'"></input>';
                   echo '<input type="hidden" name="id_store_chain" value="'.$storechain_id.'"></input>';
                   echo '<input type="hidden" name="id_main_chain" value="'.$mainchain_id.'"></input>';
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
                   echo '<input class="showpoints" type="submit" name="showpoints" value="'. $searchresult->name_product. ' - ' .$searchresult->ean_product.'"></input>';
                    echo '</form>';
               }
                $unique_products++;
            } 
            echo '<br>';
            echo '<h3> Number of products in report: ' . $unique_products . '</h3>';
        echo '</div>';
        
        // CHANGING LOCAL PRODUCT IDS TO ONLINE PRODUCT IDS ON PLACEHOLDER
        // CHANGING LOCAL LABEL ID TO ONLINE LABEL ID
        
        echo '<div class="menu-item-orange"><a href=http://127.0.0.1/wordpress/reports/list-of-reports/visual-report/?id='.$report_id.'>Report ready</a></div>';

        ?>
        
        <script>
        $( "#OpenMe2" ).click(function() {
        $( "#ShowMe2" ).slideToggle( "slow", function() {
            // Animation complete.
          });
        });
        </script>
   
        </div>
                
        <div class="previous-page">
            <a href="www.mypage.com" onclick="window.history.go(-1); return false;"><img class="back-arrow" src="<?php echo get_template_directory_uri(); ?>/img/back-arrow.png"></a>
        </div>
	<main role="main">
		
	</main>


<?php get_footer(); ?>