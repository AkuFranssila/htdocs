<?php /* Template Name: Edit product settings  */ ?>

<?php get_header(); ?>

<script>
setTimeout(pagereloading(){
    parent.window.location.reload(true);
},4000); 
</script>

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
           echo '<div class="change-settings-single-result"><h2> Product ID: </h2><input name="id_product" type="text" value="'.$outputsettings->id_product.'"></div>';
           echo '<br>';
           echo '<div class="change-settings-single-result"><h2> Product name: </h2><input name="name_product" type="textarea" value="'.$outputsettings->name_product.'"></div>';
           echo '<br>';
           echo '<div class="change-settings-single-result"><h2> Product EAN: </h2><input name="ean_product" type="text" value="'.$outputsettings->ean_product.'"></div>';
           echo '<br>';
           echo '<div class="change-settings-single-result"><h2> Product width: </h2><input name="width_product" type="text" value="'.$outputsettings->width_product.'"></div>';
           echo '<br>';
           echo '<div class="change-settings-single-result"><h2> Product height: </h2><input name="height_product" type="text" value="'.$outputsettings->height_product.'"></div>';
           echo '<br>';
           echo '<div class="change-settings-single-result"><h2> Product depth: </h2><input name="depth_product" type="text" value="'.$outputsettings->depth_product.'"></div>';
           echo '<br>';
           echo '<div class="change-settings-single-result"><h2> Product description: </h2><input name="desc_product" type="textarea" value="'.$outputsettings->desc_product.'"></div>';
           echo '<br>';
           
       }
        echo '<br>';
        echo '<input class="accept-changes" type="submit" onclick="pagereloading();" name="update_settings_submit" value="Accept">';
        echo '</form>';

        if(isset($_POST['update_settings_submit'])) {
            $id_product = $_POST['id_product'];
            $ean_product = $_POST['ean_product'];
            $name_product = $_POST['name_product'];
            $width_product = $_POST['width_product'];
            $height_product = $_POST['height_product'];
            $depth_product = $_POST['depth_product'];
            $desc_product = $_POST['desc_product'];
        
        $wpdb->update( 
	           'product', 
	           array( 
                    'ean_product' => $ean_product,
                    'name_product' => $name_product,
                    'width_product' => $width_product,
                    'height_product' => $height_product,
                    'depth_product' => $depth_product,
                    'desc_product' => $desc_product
	           ), 
	           array( 'id_product' => $id_product ),
	           array( 
		              '%d',	// value1 %d is for integers
		              '%s',// value2 %s is for strings
                    '%d',
                    '%d',
                    '%d',
                    '%s'
                    
	           ), 
	           array( '%s' ) );
        }
        ?>
        <div class="previous-page">
            <a href="www.mypage.com" onclick="window.history.go(-1); return false;"><img class="back-arrow" src="<?php echo get_template_directory_uri(); ?>/img/back-arrow.png"></a>
            
        </div>
    </div>
	<main role="main">
		
	</main>


<?php get_footer(); ?>
