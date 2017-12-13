<?php /* Template Name: Report List */ ?>

<?php get_header(); ?>

    <div class="app-container">
<div class="buttonholder"> <!-- Holder box for Main chain, store chain and store buttons in report -->
    <div class="boxx"><a class="reports_button" href='index.php?hello=true'>Main chains</a></div>
    <div class="boxx"><a class="reports_button" href='index.php?bye=true'>Store chains</a></div>
    <div class="boxx"><a class="reports_button" href='index.php?cya=true'>Stores</a></div>
    <br style="clear:both">
        
<?php
  function runMyFunction1() { //function that echoes all main chains when clicked
    global $wpdb;
    $mainchains = $wpdb->get_results("SELECT * FROM main_chain"); //select all from main chain table
    foreach ($mainchains as $names) {
        echo '<a class="report_p" href="list-of-reports.php/?val='.$names->id_main_chain.'">'. $names->name_main_chain .'</a>'; //echoes the name of the chain in the box and when clicked it gives the link the ID of the main chain
    }
  }

  if (isset($_GET['hello'])) { //if box is clicked and the url has changed to "hello" it runs function 1
    runMyFunction1();
  }
        
        
function runMyFunction2() {
    global $wpdb;
    $mainchains = $wpdb->get_results("SELECT * FROM store_chain");
    foreach ($mainchains as $names) {
        echo '<a class="report_p" href="list-of-reports.php/?val='.$names->id_store_chain.'">'. $names->name_store_chain .'</a>';
    }
  }
  if (isset($_GET['bye'])) { //if box is clicked and the url has changed to "bye" it runs function 2
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

  if (isset($_GET['cya'])) { //when cya is clicked it runs this function and echoes the store search form
    echo '<form class="storesearch-form" method="POST">';
    echo '<img class="storesearch-form-icon" src="get_template_directory_uri();/img/magnifying%20glass%20white.png">';
    echo '<input class="storesearch-form-input" type="text" name="storename">';
    echo '<input class="storesearch-form-submit" type="submit" name="submit" value="Search">';
    echo '</form>';
  }
  if(isset($_POST['submit'])) { //if box is clicked and the url has changed to "cya" it runs function 3
        runMyFunction3();
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