<?php /* Template Name: Product settings  */ ?>

<?php get_header(); ?>

<form class="storesearch-form" method="POST">
    <img class="storesearch-form-icon" src="<?php echo get_template_directory_uri(); ?>/img/magnifying%20glass%20white.png">
    <input class="storesearch-form-input" type="text" name="productname">
    <input class="storesearch-form-submit" type="submit" name="submit" value="Search">
</form>
<?php //search form that gets user input and displays the results on the same page as the form
global $wpdb; //connect to wordpress database
   if(isset($_POST['submit'])){ //if submit is pressed do the script
       $name = $_POST['productname']; //store user input to $name
       $products = $wpdb->get_results("SELECT * FROM product WHERE ean_product LIKE '%".$name."%' OR name_product LIKE '%".$name."%'"); //store sql query that selects all from store table and matches the store name with user input
       foreach ($products as $productresult) {
           echo '<div class="searchresultbox"><a href=http://127.0.0.1/wordpress/product-settings/edit-items/?id='.$productresult->id_product.'>'. $productresult->name_product .'</a></div>';
       } //outputs all the results that match the users search term

       // input testausta varten echo '<p>' .'TÄSSÄ NÄKYY FORMIN SYÖTE = ' . $name . '</p>';
   }
?>


        <div class="previous-page">
            <a href="www.mypage.com" onclick="window.history.go(-1); return false;"><img class="back-arrow" src="<?php echo get_template_directory_uri(); ?>/img/back-arrow.png"></a>
            
        </div>
    </div>
	<main role="main">
		
	</main>


<?php get_footer(); ?>
