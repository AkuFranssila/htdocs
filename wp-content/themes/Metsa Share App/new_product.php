<?php /* Template Name: Add new product  */ ?>

<?php get_header(); ?>

    <div class="app-container">
        <?php 
        
        $product_id = $_GET["id"]; //store ID that is transferred from store_settings.php store search using GET
            echo '<h1 class="product-store-name"> Add product </h1>'; //Title for the page

        echo '<form class="change_settings" method="post">';
           echo '<div class="change-settings-single-result"><h2> Name: </h2><input name="name_product" type="textarea" value=""></div>'; //user input for the product name
           echo '<br>';
           
 
           echo '<div class="change-settings-single-result">';
           echo '<h2> Producer: </h2>'; //title for the box
            echo '<select name="name_producer">';
           $producerid = $outputsettings->id_producer;
           $producers = 1; //for selecting the first producer when we go through all the producers from database
           $prodid = $wpdb->get_results("SELECT * FROM producer"); //Creating a dropdown menu for the producers 
            foreach ($prodid as $producer) {
                if ($producerid == $producers) { //if producer id matches that of a producer then echoes them and the first one will be automatically selected
                echo '<option name="id_lab" type="text" value="'.$producer->id_producer.'" selected>'.$producer->name_producer.'</option>';
                    } else {
                    echo '<option name="id_lab" type="text" value="'.$producer->id_producer.'">'.$producer->name_producer.'</option>'; //normally echoes the rest of the producers without the selected option
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
           $labid = $wpdb->get_results("SELECT * FROM label"); //Creating a dropdown menu for the labels
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
           $catid = $wpdb->get_results("SELECT * FROM category"); //Creating a dropdown menu for the category
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
           $subid = $wpdb->get_results("SELECT * FROM subcat"); // Creating a dropdown menu for sub categories
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
           echo '<div class="change-settings-single-result"><h2> EAN: </h2><input name="ean_product" type="text" value=""></div>'; //area where user can input the ean for the product
           echo '<br>';
           echo '<div class="change-settings-single-result"><h2> Extra info: </h2><input name="desc_product" type="textarea" value=""></div>'; //input field where user can input extra information about the product
           echo '<br>';

           echo '<br style="clear:both;">';  
           echo '<br>';
            echo '<div class="horizontal_checkbox">';
           echo '<h1 class="product-store-name">Width</h1>';
            echo '<select class="hidescroll" name="width_select" size="8">';
            //echo '<option value="0" name="0">0</selection>';
            $width_select = 0; //selecting the value if there already is one. If there isn't then it will give it a 0 as a default.
            while ($width_select < 1001) { //maximum number count 1000
                if ($width_select == $outputsettings->width_product) { //selecting the product width and comparing it to $width_select, if there isnt anything returns a null which reads as 0
                echo '<option value="'.$width_select.'" name="horizontal_selection" autofocus selected>'.$width_select.'</selection>'; //will then echo option with SELECTED option which will be the one selected automatically
                } else {
                    echo '<option value="'.$width_select.'" name="horizontal_selection">'.$width_select.'</selection>'; //then echoes rest of the fields up to 1000
                }
                $width_select++; //adding a number to the counter 
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
       
        echo '<br>';
        echo '<input class="accept-changes" type="submit" name="update_settings_submit" value="Accept">';
        echo '</form>';
        
        
        if(isset($_POST['update_settings_submit'])) {
            
            //when clicking Accept button get all the ids for the following things
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
            

        //inserting the user inputs to product table
        $wpdb->insert( 
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
                        // Below we redirect the user back to product search page
                 ?>
                <script type="text/javascript">
                    window.location = "http://127.0.0.1/wordpress/product-settings/";
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
