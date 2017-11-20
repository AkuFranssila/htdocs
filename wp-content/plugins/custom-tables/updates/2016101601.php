<?php

if (!isset($wpdb)) { exit; }

$wpdb->get_row("ALTER TABLE `".$wpdb->prefix."wct_form`
    ADD COLUMN `p_fields` text NULL AFTER `r_fields`;");

?>
  