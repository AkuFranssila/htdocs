<?php
global $wpdb;
if (isset($_GET['term'])){
    $return_arr = array();
    $term = $_GET['term'];
    try {
        $stmt = $wpdb->get_results("SELECT name_product FROM product WHERE name_product LIKE "'.);
        
        foreach ($stmt as $row){
            $return_arr[] =  $row['name_product'];
        }

    } catch(PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
    }


    /* Toss back results as json encoded array. */
    echo json_encode($return_arr);
}

?>