<?php

if (!isset($wpdb)) { exit; }

$wpdb->get_row("ALTER TABLE `".$wpdb->prefix."wct_form`
    ADD COLUMN `t_val` text NULL AFTER `t_setup`;");

?>
  