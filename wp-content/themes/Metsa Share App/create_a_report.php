<?php /* Template Name: Create a report - store search */ ?>

<?php get_header(); ?>

<script type="text/javascript">
function keep_store_id () {
    var stored_id = this.document.activeElement.getAttribute("name");
}

</script>

    <div class="app-container">
<form class="storesearch-form" method="POST"> <!-- Start the form for store search -->
    <img class="storesearch-form-icon" src="<?php echo get_template_directory_uri(); ?>/img/magnifying%20glass%20white.png"> <!-- Search icon  -->
    <input class="storesearch-form-input" type="text" name="storename"> <!-- Store name user input field -->
    <input class="storesearch-form-submit" type="submit" name="submit" value="Search"> <!-- Submit button for the form -->
</form>
<?php //search form that gets user input and displays the results on the same page as the form
global $wpdb; //connect to wordpress database
   if(isset($_POST['submit'])){ //if submit is pressed do the script
       $name = $_POST['storename']; //store user input to $name
       $mainchains = $wpdb->get_results("SELECT * FROM store WHERE name_store LIKE '%".$name."%'"); //store sql query that selects all from store table and matches the store name with user input
       foreach ($mainchains as $searchresult) {
           echo '<div class="searchresultbox"><a href=http://127.0.0.1/wordpress/create-a-report/store-check-for-report/?idmc='.$searchresult->id_main_chain.'&amp;idsc=' . $searchresult->id_store_chain . '&amp;ids=' . $searchresult->id_store . '&amp;idss=' . $searchresult->id_store_settings . '>'. $searchresult->name_store .'</a></div>';
       } //outputs all the results that match the users search term
       
       // input testausta varten echo '<p>' .'TÄSSÄ NÄKYY FORMIN SYÖTE = ' . $name . '</p>';
   }
        
?>
        
        
        <div class="previous-page">
            <a href="www.mypage.com" onclick="window.history.go(-1); return false;"><img class="back-arrow" src="<?php echo get_template_directory_uri(); ?>/img/back-arrow.png"></a> <!-- returns to previous page by browser history
        </div>
    </div>

