<?php /* Template Name: List of reports  */ ?>

<?php get_header(); ?>


    <div class="app-container">
        
        
        <?php
        $store_id = $_GET["val"]; // id for store from previous page
        $report_number = 0; //this is used to display no reports found text if the table doesnt have any rows
        $listofreports = $wpdb->get_results("SELECT * FROM reports WHERE id_store = ".$store_id." ORDER BY id_report DESC"); //selecting all rows from reports table with the store ID we got from previous page, then making them in descending order so the newest input is the first one
        foreach ($listofreports as $reports) { 
            $id_report = $reports->id_report;
            echo '<div class="report-list-item"><a class="report-list-item-a1" href=http://127.0.0.1/wordpress/reports/list-of-reports/visual-report/?id='.$reports->id_report.'>'.$reports->name_reports. ' ' . $reports->date_reports.'</a>'; //On the div will give the report a text that gives the name of the store and when the report was made 
            $report_number++; //
            
            $store_info = $wpdb->get_results ("SELECT * FROM store WHERE id_store = ".$store_id."");
                foreach ($store_info as $info ) {
                    $id_sc = $info->id_store_chain; //get store chain id
                    $id_mc = $info->id_main_chain; //get main chain id
                    $id_ss = $info->id_store_settings; //get store settings id
                    echo '<a class="report-list-item-a2" href=http://127.0.0.1/wordpress/create-a-report/store-check-for-report/point-calculation/?idmc='.$id_mc.'&amp;idsc='.$id_sc.'&amp;ids='.$store_id .'&amp;idss='.$id_ss.'&amp;idr='.$id_report.'> Edit </a>'; //we echo the ids to the url so that we can access them on the smallreport.php page that prints all the data
                }
            echo '</div>';
            echo '<br>'; 
        }
        if ($report_number == 0) {
            echo '<h1 class="product-store-name"> No reports found </h1>'; //if there weren't any rows in the table it echoes that no reports found
        }
        ?>
        
        
        <div class="previous-page">
            <a href="www.mypage.com" onclick="window.history.go(-1); return false;"><img class="back-arrow" src="<?php echo get_template_directory_uri(); ?>/img/back-arrow.png"></a>
        </div>
    </div>
	<main role="main">
		
	</main>


<?php get_footer(); ?>