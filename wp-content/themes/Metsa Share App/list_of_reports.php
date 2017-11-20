<?php /* Template Name: List of reports  */ ?>

<?php get_header(); ?>


    <div class="app-container">
        
        
        <?php
        $store_id = $_GET["val"]; // id for store
                
        $listofreports = $wpdb->get_results("SELECT * FROM reports WHERE id_store = ".$store_id."");
        foreach ($listofreports as $reports) { 
            echo '<div class="report-item">'.$reports->name_reports. ' ' . $reports->date_reports.'</div>';
            echo '<br>';   
        }
        ?>
        
        
        <div class="previous-page">
            <a href="www.mypage.com" onclick="window.history.go(-1); return false;"><img class="back-arrow" src="<?php echo get_template_directory_uri(); ?>/img/back-arrow.png"></a>
        </div>
    </div>
	<main role="main">
		
	</main>


<?php get_footer(); ?>