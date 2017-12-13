<?php
global $wpdb;

    //This is excel output file that doesnt work. This is accessed when user has first saved report to finalreport table and then clicks download excel

    $id_finalreport = $_POST['finalreport_id']; 
    
    //$data = $wpdb->get_results("SELECT * FROM finalreport WHERE id_finalreport = ".$id_finalreport."");
    $data = $wpdb->get_results("SELECT * FROM finalreport WHERE id_finalreport = 18");
    $columnHeader = '';  
    $columnHeader = "Sr NO" . "\t" . "User Name" . "\t" . "Password" . "\t";  
  
    $setData = '';
    $rowData = '';


    foreach ($data as $results) {
        
        
        $results = '"' . $results . '"' . "\t";
        $rowData .= $results;     
    }
$setData .= trim($rowData)."\n";
echo ucwords($columnHeader) . "\n" . $setData . "\n"; 

header("Content-Type: application/force-download");
header("Content-type: application/octet-stream");  
header("Content-Disposition: attachment; filename=fairshare_report.xls");  
header("Pragma: no-cache");  
header("Expires: 0");
    

?>
