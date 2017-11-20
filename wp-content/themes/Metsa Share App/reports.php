<?php /* Template Name: Report List */ ?>

<?php get_header(); ?>

    <div class="app-container">
<div class="buttonholder">
    <div class="boxx"><a class="reports_button" href='index.php?hello=true'>Main chains</a></div>
    <div class="boxx"><a class="reports_button" href='index.php?bye=true'>Store chains</a></div>
    <div class="boxx"><a class="reports_button" href='index.php?cya=true'>Stores</a></div>
        
<?php
  function runMyFunction1() {
    global $wpdb;
    $mainchains = $wpdb->get_results("SELECT * FROM main_chain");
    foreach ($mainchains as $names) {
        echo '<a class="report_p" href="list-of-reports.php/?val='.$names->id_main_chain.'">'. $names->name_main_chain .'</a>';
    }
  }

  if (isset($_GET['hello'])) {
    runMyFunction1();
  }
        
        
function runMyFunction2() {
    global $wpdb;
    $mainchains = $wpdb->get_results("SELECT * FROM store_chain");
    foreach ($mainchains as $names) {
        echo '<a class="report_p" href="list-of-reports.php/?val='.$names->id_store_chain.'">'. $names->name_store_chain .'</a>';
    }
  }
  if (isset($_GET['bye'])) {
    runMyFunction2();
  }
        
function runMyFunction3() {
    global $wpdb;
    $name = $_POST['storename']; //store user input to $name
    $mainchains = $wpdb->get_results("SELECT * FROM store WHERE name_store LIKE '%".$name."%'");
    foreach ($mainchains as $names) {
        echo '<a class="report_p" href="http://127.0.0.1/wordpress/reports/list-of-reports/?val='.$names->id_store.'">'. $names->name_store .'</a>';
    }
    
  }

  if (isset($_GET['cya'])) {
    echo '<form class="storesearch-form" method="POST">';
    echo '<img class="storesearch-form-icon" src="get_template_directory_uri();/img/magnifying%20glass%20white.png">';
    echo '<input class="storesearch-form-input" type="text" name="storename">';
    echo '<input class="storesearch-form-submit" type="submit" name="submit" value="Search">';
    echo '</form>';
    if(isset($_POST['submit'])) {
        runMyFunction3();
    }
  }
       
?>
</div>       
        <div class="previous-page">
            <a href="www.mypage.com" onclick="window.history.go(-1); return false;"><img class="back-arrow" src="<?php echo get_template_directory_uri(); ?>/img/back-arrow.png"></a>
        </div>
    </div>
	<main role="main">
		
	</main>


<?php get_footer(); ?>