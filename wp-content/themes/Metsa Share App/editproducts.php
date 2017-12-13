<?php /* Template Name: Edit product settings  */ ?>

<?php get_header(); ?>

    <div class="app-container">
        <?php 
        
        $product_id = $_GET["id"]; //store ID that is transferred from store_settings.php store search using GET
        $product_name = $wpdb->get_results("SELECT name_product FROM product WHERE id_product = ".$product_id."");
        foreach ($product_name as $name) { 
            echo '<h1 class="product-store-name">' . $name->name_product . '</h1>';
            echo '<br>';
        }
        echo '<form class="change_settings" method="post">';
        $storesettings = $wpdb->get_results("SELECT * FROM product WHERE id_product = ".$product_id.""); //
       foreach ($storesettings as $outputsettings) {
           echo '<input name="id_product" type="hidden" value="'.$outputsettings->id_product.'">';
           echo '<div class="change-settings-single-result"><h2> Name: </h2><input name="name_product" type="textarea" value="'.$outputsettings->name_product.'"></div>';
           echo '<br>';
           
           /*
           echo '<select name="id_producer">';
           $producerid = $outputsettings->id_producer;
           echo '<div class="change-settings-single-result"><h2> Producer: </h2><input name="ean_product22" type="text" value="'.$outputsettings->ean_product.'"></div>';
           echo '</select>';
           
           
           echo '<br>';
           echo '<select name="id_label">';
           $labelid = $outputsettings->id_label;
           echo '<div class="change-settings-single-result"><h2> Label: </h2><input name="ean_product2" type="text" value="'.$outputsettings->ean_product.'"></div>';
           echo '</select>';
           echo '<br>';
            */
           echo '<div class="change-settings-single-result">';
           echo '<h2> Producer: </h2>'; 
            echo '<select name="name_producer">';
           $producerid = $outputsettings->id_producer;
           $producers = 1;
           $prodid = $wpdb->get_results("SELECT * FROM producer"); //
            foreach ($prodid as $producer) {
                if ($producerid == $producers) {
                echo '<option name="id_lab" type="text" value="'.$producer->id_producer.'" selected>'.$producer->name_producer.'</option>';
                    } else {
                    echo '<option name="id_lab" type="text" value="'.$producer->id_producer.'">'.$producer->name_producer.'</option>';
                }
                $producers++;
            }
           echo '</select>';
           echo '</div>';
           
           
           
           echo '<div class="change-settings-single-result">';
           echo '<h2> Label: </h2>'; 
            echo '<select name="name_label">';
           $labelid = $outputsettings->id_label;
           $labels = 1;
           $labid = $wpdb->get_results("SELECT * FROM label"); //
            foreach ($labid as $label) {
                if ($labels == $labelid) {
                echo '<option name="id_lab" type="text" value="'.$label->id_label.'" selected>'.$label->name_label.'</option>';
                } else {
                    echo '<option name="id_lab" type="text" value="'.$label->id_label.'">'.$label->name_label.'</option>';
                }
                $labels++;
            }
           echo '</select>';
           echo '</div>';
           
           
           
           echo '<div class="change-settings-single-result">';
           echo '<h2> Category: </h2>'; 
            echo '<select name="name_category">';
           $cats = 1;
           $categoryid = $outputsettings->id_category;
           $catid = $wpdb->get_results("SELECT * FROM category"); //
            foreach ($catid as $category) {
                if ($categoryid == $cats) {
                echo '<option name="id_cat" type="text" value="'.$category->id_category.'" selected>'.$category->name_category.'</option>';
                    } else {
                    echo '<option name="id_cat" type="text" value="'.$category->id_category.'">'.$category->name_category.'</option>';
                }
                $cats++;
            }
           echo '</select>';
           echo '</div>';
           
           
           echo '<div class="change-settings-single-result">';
           echo '<h2> Subcategory: </h2>'; 
            echo '<select name="name_subcat">';
           $subcatid = $outputsettings->id_subcat;
           $subcats = 1;
           $subid = $wpdb->get_results("SELECT * FROM subcat"); //
            foreach ($subid as $subcat) {
                if ($subcatid == $subcats) {
                echo '<option name="id_cat" type="text" value="'.$subcat->id_subcat.'" selected>'.$subcat->name_subcat.'</option>';
                    } else {
                    echo '<option name="id_cat" type="text" value="'.$subcat->id_subcat.'">'.$subcat->name_subcat.'</option>';
                }
                $subcats++;
            }
           echo '</select>';
           echo '</div>';
           
           
           echo '<br>';
           echo '<div class="change-settings-single-result"><h2> EAN: </h2><input name="ean_product" type="text" value="'.$outputsettings->ean_product.'"></div>';
           echo '<br>';
           echo '<div class="change-settings-single-result"><h2> Extra info: </h2><input name="desc_product" type="textarea" value="'.$outputsettings->desc_product.'"></div>';
           echo '<br>';
           /* echo '<div class="change-settings-single-result"><h2> Product width: </h2><input name="width_product" type="text" value="'.$outputsettings->width_product.'"></div>';
           echo '<br>';
           echo '<div class="change-settings-single-result"><h2> Product height: </h2><input name="height_product" type="text" value="'.$outputsettings->height_product.'"></div>';
           echo '<br>';
           echo '<div class="change-settings-single-result"><h2> Product depth: </h2><input name="depth_product" type="text" value="'.$outputsettings->depth_product.'"></div>'; */
           echo '<br style="clear:both;">';  
           echo '<br>';
            echo '<div class="horizontal_checkbox">';
           echo '<h1 class="product-store-name">Width</h1>';
            echo '<select class="hidescroll" name="width_select" size="8">';
            //echo '<option value="0" name="0">0</selection>';
            $width_select = 0;
            while ($width_select < 1001) {
                if ($width_select == $outputsettings->width_product) {
                echo '<option value="'.$width_select.'" name="horizontal_selection" autofocus selected>'.$width_select.'</selection>';
                } else {
                    echo '<option value="'.$width_select.'" name="horizontal_selection">'.$width_select.'</selection>';
                }
                $width_select++;
            }
            echo '</select>';
            echo '</div>';
           echo '<div class="horizontal_checkbox">';
           echo '<h1 class="product-store-name">Height</h1>';
            echo '<select class="hidescroll" name="height_select" size="8">';
            //echo '<option value="0" name="0">0</selection>';
            $height_select = 0;
            while ($height_select < 1001) {
                if ($height_select == $outputsettings->height_product) {
                echo '<option value="'.$height_select.'" name="horizontal_selection" autofocus selected>'.$height_select.'</selection>';
                } else {
                    echo '<option value="'.$height_select.'" name="horizontal_selection">'.$height_select.'</selection>';
                }
                $height_select++;
            }
            echo '</select>';
            echo '</div>';
           echo '<div class="horizontal_checkbox">';
           echo '<h1 class="product-store-name">Depth</h1>';
            echo '<select class="hidescroll" name="depth_select" size="8">';
            //echo '<option value="0" name="0">0</selection>';
            $depth_select = 0;
            while ($depth_select < 1001) {
                if ($depth_select == $outputsettings->depth_product) {
                echo '<option value="'.$depth_select.'" name="horizontal_selection" autofocus selected>'.$depth_select.'</selection>';
                } else {
                    echo '<option value="'.$depth_select.'" name="horizontal_selection">'.$depth_select.'</selection>';
                }
                $depth_select++;
            }
            echo '</select>';
            echo '</div>';
       }
        echo '<br>';
        echo '<input class="accept-changes" type="submit" name="update_settings_submit" value="Accept">';
        echo '</form>';
        

        if(isset($_POST['update_settings_submit'])) {
            $id_product = $_POST['id_product'];
            $ean_product = $_POST['ean_product'];
            $name_product = $_POST['name_product'];
            $width_product = $_POST['width_product'];
            $height_product = $_POST['height_select'];
            $depth_product = $_POST['depth_select'];
            $desc_product = $_POST['desc_product'];
            $width_product2 = $_POST['width_select'];
            $id_producer = $_POST['name_producer'];
            $id_label = $_POST['name_label'];
            $id_category = $_POST['name_category'];
            $id_subcat = $_POST['name_subcat'];
            
            
        
        $wpdb->update( 
	           'product', 
	           array( 
                    'id_producer' => $id_producer,
                    'id_label' => $id_label,
                    'id_category' => $id_category,
                    'id_subcat' => $id_subcat,
                    'ean_product' => $ean_product,
                    'name_product' => $name_product,
                    'width_product' => $width_product2,
                    'height_product' => $height_product,
                    'depth_product' => $depth_product,
                    'desc_product' => $desc_product
	           ), 
	           array( 'id_product' => $id_product ),
	           array( 
                    '%d',
                    '%d',
                    '%d',
                    '%d',
		              '%d',	// value1 %d is for integers
		              '%s',// value2 %s is for strings
                    '%d',
                    '%d',
                    '%d',
                    '%s'
                    
	           ), 
	           array( '%s' ) );
   
            
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
