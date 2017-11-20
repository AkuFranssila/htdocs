<?php

// [wctform id="1" limit="50"] als ausgabe zu Form 1

$form = $wpdb->get_row("SELECT `e_setup`,`t_setup`,`t_val`,`rights`,`r_table`,`r_fields`,`r_filter`,`htmlview`,`smail`,`toapprove`,`p_fields` FROM `".$wpdb->prefix."wct_form` WHERE `id`='".$id."' LIMIT 1;");
$felder2 =  explode(",",$form->r_fields);
$felder3 =  explode(",",$form->p_fields);

if (strstr($form->t_val,",")) { $valu = explode(",",$form->t_val); } else { $valu= array(); } 
for ($i=0;$felder2[$i]!='';$i++) {
	// uses variables as std values
	$val = str_replace(array("'","\"",";","[","]"),"",stripslashes($valu[$i]));
	$val = str_replace(array("date()","time()"),array(date("m/d/Y",time()),time()),$val);
	if (strstr($val,"\$_GET")) { $valu[$felder2[$i]] =  htmlentities($_GET[str_replace("\$_GET","",$val)]); }
	elseif (strstr($val,"\$_POST")) { $valu[$felder2[$i]] = htmlentities($_POST[str_replace("\$_POST","",$val)]); }
	elseif (strstr($val,"\$_REQUEST")) { $valu[$felder2[$i]] = htmlentities($_REQUEST[str_replace("\$_REQUEST","",$val)]); }
	elseif (strstr($val,"\$")) { $val = str_replace("\$","",$val); $valu[$felder2[$i]] = htmlentities($$val); }
	else { $valu[$felder2[$i]] = $val; }
}


if ($form->rights[3] == '1' AND $_GET['wctdfid'] != '') {
	if ($form->r_filter != '') { $filter = "AND ".sqldatefilter(stripslashes($form->r_filter)); } else { $filter = ''; }
	if ($form->toapprove == '1') {
		$wpdb->get_row("UPDATE `".$wpdb->prefix."wct".$form->r_table."` SET `status`='passive' WHERE `status` != 'passive' AND `id`='".mres($_GET['wctdfid'])."' ".$filter." LIMIT 1;");
		do_action('wct_formupdate', array('id' => $_GET['wctdfid'], 'action' => 'update'));
	}
	else {
		$wpdb->get_row("DELETE FROM `".$wpdb->prefix."wct".$form->r_table."` WHERE `status` != 'passive' AND `id`='".mres($_GET['wctdfid'])."' ".$filter." LIMIT 1;");
		do_action('wct_formupdate', array('id' => $_GET['wctdfid'], 'action' => 'delete'));
	}
	if ($form->smail == '1') {
		wp_mail(get_option( 'admin_email' ), "Custom Forms - ".__('Entry was deleted','wct'),"Please check the if the Entry can be deleted (located in passive Section).\r\n\r\nLink ".admin_url('admin.php?page=wct_table_'.$form->r_table.'&wcttab=content&wcttab2=passive&action=edit&wcts=0&rid='.$_GET['wctdfid']));
	}
	$_GET['wctdfid'] = '';
	if ($url != '') { wp_redirect( $url ); exit; }
}
elseif ($_GET['wctefid'] == 'save') {
	if (!isset($_POST['multicreate'])) { $_POST['multicreate'] = '0'; }
	for ($a=0;$a <= $_POST['multicreate'];$a++) {
		$tmpvar = $a;
		unset($sqlstring);
		if ($tmpvar == '0') { $tmpvar = ''; }

		foreach ($_POST as $var => $wert) {
			if ($var != 'submit' AND strpos($var,"wct".$tmpvar."f_") !== false) {
				if (is_array($wert)) {
					$set = '';
					foreach ($wert as $wertb) {
						$set .= $wertb.",";
					}
					if ($set != '') { $set = substr($set,0,strlen($set)-1); }
					$wert = $set;
				}
				elseif (preg_match("/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/",$wert)) {
					$t = explode("-",$wert);
					$wert = mktime(1,1,1,$t[1],$t[2],$t[0]);
				}
				$sqlstring .= "`".mres(str_replace("wct".$tmpvar."f_","",$var))."`='".mres(str_replace("\r\n","",$wert))."',";
			}
		}

		if ($_FILES) {
			if (!function_exists('wp_generate_attachment_metadata')) {
				require_once(ABSPATH . "wp-admin" . '/includes/admin.php');
				require_once(ABSPATH . "wp-admin" . '/includes/image.php');
				require_once(ABSPATH . "wp-admin" . '/includes/file.php');
				require_once(ABSPATH . "wp-admin" . '/includes/media.php');
			}
			foreach ($_FILES as $file => $array) {
				if ($_FILES[$file]['error'] == UPLOAD_ERR_OK) {
					$attach_id = media_handle_upload( $file, get_the_ID());
					if (!is_wp_error($attach_id)) {
						$sqlstring .= "`".mres(str_replace("wct".$tmpvar."p_","",$file))."`='".mres(wp_get_attachment_url($attach_id))."',";
					}
				}
			}   
		}
		$sqlstring = substr($sqlstring,0,strlen($sqlstring)-1);
		
		$captcha = $this->captcha('check');
		if ($captcha != '0') {
			if ($_GET['wct'.$tmpvar.'fid'] == '' AND $form->rights[2] == '1') {
				if ($form->smail == '1') {
					$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct".$form->r_table."` SET ".$sqlstring.", `status`='".($form->toapprove != '1' ? 'active' : 'draft')."';");
					$tableid = $wpdb->insert_id;
					wp_mail(get_option( 'admin_email' ), "Custom Forms - ".__('Entry was created','wct'),"Please check the if the Entry can be published (located in draft Section).\r\n\r\nLink ".admin_url('admin.php?page=wct_table_'.$form->r_table.'&wcttab=content&wcttab2=draft&action=edit&wcts=0&rid='.$tableid));
				}
				else {
					$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct".$form->r_table."` SET ".$sqlstring.", `status`='active';");
				}
				do_action('wct_formupdate', array('id' => $_GET['wctdfid'], 'action' => 'new'));
				if ($url != '') { wp_redirect( $url ); exit; }
			}
			elseif ($_GET['wct'.$tmpvar.'fid'] != '' AND $form->rights[1] == '1') {
				if ($form->smail == '1') {
					$wpdb->get_row("UPDATE `".$wpdb->prefix."wct".$form->r_table."` SET ".$sqlstring.",`status`='".($form->toapprove != '1' ? 'active' : 'draft')."' WHERE `status`!='passive' AND `id`='".mres($_GET['wct'.$tmpvar.'fid'])."' LIMIT 1;");
					$createid = $wpdb->insert_id;
					if ($createid != '0') { wp_mail(get_option( 'admin_email' ), "Custom Forms - ".__('Entry was updated','wct'),"Please check the if the Entry can be published (located in draft Section).\r\n\r\nLink ".admin_url('admin.php?page=wct_table_'.$form->r_table.'&wcttab=content&wcttab2=draft&action=edit&wcts=0&rid='.$createid)); }
					do_action('wct_formupdate', array('id' => $_GET['wctdfid'], 'action' => 'new'));
				}
				else {
					
					$wpdb->get_row("UPDATE `".$wpdb->prefix."wct".$form->r_table."` SET ".$sqlstring." WHERE `status`!='passive' AND `id`='".mres($_GET['wct'.$tmpvar.'fid'])."' LIMIT 1;");
					do_action('wct_formupdate', array('id' => $_GET['wctdfid'], 'action' => 'update'));
				}
				if ($url != '') { wp_redirect( $url ); exit; }
			}
		}
	}
	$_GET['wctnew'] = $_GET['wct'.$tmpvar.'fid'] = $_GET['wctnew'] = $_GET['wctfid'] = '';
}

if (($_GET['wctfid'] == '' AND $_GET['wctnew'] == '1' AND $form->rights[2] == '1') OR ($_GET['wctfid'] == '' AND $form->rights[2] == '1' AND $form->rights[0] != '1')) {
	if ($_GET['wctefid'] == 'save' AND $captcha != '0') {
		if ($form->smail == '1') {
			echo __('Thanks for the new entry.','wct')." ".__('It will be checked and if everything is ok approved.','wct');
		}
		else {
			echo __('Thanks for the new entry.','wct');
		}
	}
	else {
		
		$url = $this->generate_pagelink(array("/[&?]+wctnew=[0-9]*/","/[&?]+wctefid=save/","/[&?]+wctfid=[0-9]*/"),"");
		echo "<script>function getY (el) {y = el.offsetTop;if (!el.offsetParent) { return y; } else return (y+getY(el.offsetParent)-35);}</script>";

		$table = $wpdb->get_row("SHOW CREATE TABLE `".$wpdb->prefix."wct".$form->r_table."`;");
		$array=array(); foreach($table as $member=>$data) { $array[$member]=$data; }
		$tmp = explode("PRIMARY KEY",$array['Create Table']);
		$felder = explode("\n",$tmp[0]);
		for ($i=2;$felder[$i] != '';$i++) {
			$x++;
			$feld[$x] =  preg_replace("/.*`(.*?)`.*/","$1",$felder[$i-1]);
			if (strpos ($felder[$i-1]," text") !== false) {
				$feld2[$feld[$x]] =  preg_replace("/.*`(.*)`\s(.*?)\s.*/","$2",str_replace(array(",","8 ,2","' ,'"),array(" ,","8.2","'xxxoooxxx'"),$felder[$i-1]));
			}
			else {
				$feld2[$feld[$x]] =  preg_replace("/.*`(.*)`\s(.*\))\s.*/","$2",str_replace(array(",","8 ,2","' ,'"),array(" ,","8.2","'xxxoooxxx'"),$felder[$i-1]));
			}
		}
		$out .= "<h3>".__('Create Entry','wct')."</h3><form id=\"checking\" action=\"".$url."wctfid=".$_GET['wctfid']."&wctefid=save".($_GET['wctnew'] != '' ? "&wctnew=".$_GET['wctnew'] : "")."\" method=\"POST\" enctype=\"multipart/form-data\">";

		if ($captcha == '0') { $out .= "<h2><font color=\"red\">".__('Please fillout captcha corretly!','wct')."</font></h2>"; }
		
		$inhalt = $form->e_setup;
		$rights = ",".$form->r_fields.",";

		preg_match_all("/\{(.*?)\}/", $inhalt, $matches);

		foreach ($matches[1] as $val => $wert) {
			if (in_array($wert,$felder3)) { $addon2 = " required "; } else { $addon2 = "";}
			
			if (strpos($rights,",".$wert.",") === false) {
				$addon = " style=\"background-color: grey;\" readonly";
			}
			else {
				$addon = "";
				if ($feld2[$wert] == "int(10)") {
					$addon = " id=\"f_date_".$wert."\" style=\"background-image: url('".plugins_url('custom-tables/jquery/cal.png')."');background-repeat: no-repeat;background-position: right center;width:120px;\"";
					$skripte = "jQuery('#f_date_".$wert."').datepicker({dateFormat : 'yy-mm-dd',firstDay: 1});"; 
				}
			}

			if ($feld2[$wert] == "smallint(6)") { $inhalt = str_replace("{".$wert."}","<input class=\"wct-formint6\" type=\"text\" name=\"".($addon != '' ? "wctn_" : "wctf_").$wert."\" value=\"".$valu[$wert]."\" maxsize=\"6\"".$addon2.$addon."/>",$inhalt); }
			elseif ($feld2[$wert] == "int(10)") { 
				if (strpos($rights,",".$wert.",") === false) {
					$inhalt = str_replace("{".$wert."}","<input class=\"wct-formdate\" type=\"text\" name=\"wctn_".$wert."\" value=\"".($valu[$wert] != '' ? $valu[$wert] : date("Y-m-d",time()))."\" maxsize=\"10\"".$addon2.$addon.">",$inhalt);
				}
				else {
					$inhalt = str_replace("{".$wert."}","<input class=\"wct-formdate\" type=\"text\" name=\"wctf_".$wert."\" value=\"".($valu[$wert] != '' ? $valu[$wert] : date("Y-m-d",time()))."\" maxsize=\"10\"".$addon2.$addon.">",$inhalt);
				}
			}
			elseif ($feld2[$wert] == "int(11)") { $inhalt = str_replace("{".$wert."}","<input class=\"wct-formint11\" type=\"text\" name=\"".($addon != '' ? "wctn_" : "wctf_").$wert."\" value=\"".$valu[$wert]."\" maxsize=\"11\"".$addon2.$addon."/>",$inhalt); }
			elseif ($feld2[$wert] == "varchar(32)") { $inhalt = str_replace("{".$wert."}","<input class=\"wct-formchar32\" type=\"text\" name=\"".($addon != '' ? "wctn_" : "wctf_").$wert."\" value=\"".$valu[$wert]."\" maxsize=\"32\"".$addon2.$addon."/>",$inhalt); }
			elseif ($feld2[$wert] == "varchar(64)") { $inhalt = str_replace("{".$wert."}","<input class=\"wct-formchar64\" type=\"text\" name=\"".($addon != '' ? "wctn_" : "wctf_").$wert."\" value=\"".$valu[$wert]."\" maxsize=\"64\"".$addon2.$addon."/>",$inhalt); }
			elseif ($feld2[$wert] == "varchar(128)") { $inhalt = str_replace("{".$wert."}","<input class=\"wct-formchar128\" type=\"text\" name=\"".($addon != '' ? "wctn_" : "wctf_").$wert."\" value=\"".$valu[$wert]."\" maxsize=\"128\"".$addon2.$addon."/>",$inhalt); }
			elseif ($feld2[$wert] == "varchar(160)" OR $feld2[$wert] == "varchar(254)") { $inhalt = str_replace("{".$wert."}","<input class=\"wct-formpic\" id=\"wctp_".$wert."\" type=\"file\" size=\"50\" name=\"wctp_".$wert."\" value=\"".$valu[$wert]."\" ".$addon2."/>",$inhalt); }
			elseif (substr($feld2[$wert],0,4) == "enum") {
				if ($addon == "") {
					$tmp = "<select style=\"width:120px;\" name=\"".($addon != '' ? "wctn_" : "wctf_").$wert."\" ".$addon2.">";
					$defs = explode("xxxoooxxx",str_replace("'","",substr($feld2[$wert],6,(strlen(rtrim($feld2[$wert]))-8))));
					foreach ($defs as $posibility) {
						
						$tmp .= "<option value=\"".$posibility."\"".($valu[$wert] == $posibility ? ' selected' : '').">".$posibility."</option>";
					}
					$tmp .= "</select>";
				}
				else {
					$tmp = "<input size=\"10\" type=\"text\" name=\"wctn_".$wert."\" value=\"".($valu[$wert] != '' ? $valu[$wert] : stripslashes($row->$wert))."\" maxsize=\"32\"".$addon2.$addon."/>";
				}
				$inhalt = str_replace("{".$wert."}",$tmp,$inhalt);
			}
			elseif (substr($feld2[$wert],0,3) == "set") {
				$tmp = '';
				$defs = explode("xxxoooxxx",str_replace("'","",substr($feld2[$wert],5,(strlen(rtrim($feld2[$wert]))-7))));
				$wasjetzt = ",".stripslashes($qry->$feld[$wert]).",";
				foreach ($defs as $posibility) {
					$ji++;
					$tmp .= "<div class=\"set_checkbox\"><input type=\"checkbox\" name=\"".($addon != '' ? "wctn_" : "wctf_").$wert."[]\" value=\"".$posibility."\"".($valu[$wert] == $posibility ? ' checked' : '')."".$addon2.">".substr($posibility,0,17)."</div>";
				}
				$inhalt = str_replace("{".$wert."}",$tmp,$inhalt);
			}
			elseif ($feld2[$wert] == "float(8.2)") { $inhalt = str_replace("{".$wert."}","<input size=\"12\" type=\"text\" name=\"".($addon != '' ? "wctn_" : "wctf_").$wert."\" value=\"".$valu[$wert]."\" maxsize=\"11\"".$addon2.$addon."/>",$inhalt); }
			elseif ($feld2[$wert] == "text") {
				if ($addon != '') { $addon = " style=\"background-color: #CCC;\" readonly=\"readonly\""; } else { $mytextfelder .= "wctf_".$wert.","; }
				
				if ($mytextfelder != '') {
					ob_start();
					wp_editor(($valu[$wert] != '' ? $valu[$wert] : stripslashes($row->$wert)), ($addon != '' ? "wctn_" : "wctf_").$wert, array('media_buttons' => false,'textarea_rows' => '10','tinymce' => true,'editor_css' => '<style> .wp-editor-wrap { line-height: 1px; } .wp-editor-tabs br { float:right; } pre { line-height: 0px; }</style>'));
					$out2 = str_replace(array("id=\"".($addon != '' ? "wctn_" : "wctf_").$wert."\""),array("id=\"".($addon != '' ? "wctn_" : "wctf_").$wert."\"".$addon),ob_get_contents());
					ob_end_clean();
					$inhalt = str_replace("{".$wert."}",$out2,$inhalt);
				}
				else {
					$inhalt = str_replace("{".$wert."}","<textarea class=\"wct-formtext\" id=\"".($addon != '' ? "wctn_" : "wctf_").$wert."\" name=\"".($addon != '' ? "wctn_" : "wctf_").$wert."\" style=\"height: 155px;width: 100%;\"".$addon2.$addon.">".($valu[$wert] != '' ? $valu[$wert] : stripslashes($row->$wert))."</textarea>",$inhalt);
				}
			}
		}
		
		if ($skripte != '') {
			$inhalt .= "<script type=\"text/javascript\">jQuery(document).ready(function(){".$skripte."});</script>";
		}
		
		if (count($felder3) >= '1') {
			$inhalt .= '<script>jQuery.validator.setDefaults({showErrors: function(map, list) {var focussed = document.activeElement;if (focussed && jQuery(focussed).is("input, textarea")) {jQuery(this.currentForm).tooltip("close", {currentTarget: focussed}, true)}this.currentElements.removeAttr("title").removeClass("ui-state-highlight");jQuery.each(list, function(index, error) {jQuery(error.element).attr("title", error.message).addClass("ui-state-highlight");});if (focussed && jQuery(focussed).is("input, textarea")) {jQuery(this.currentForm).tooltip("open", {target: focussed});}}});(function() {jQuery("#checking").tooltip({show: false,hide: false});jQuery(\"#checking\").validate();jQuery(":submit").button();})();</script>';
		}
		
		// Create Multiple New Entries
		$menge = substr_count($inhalt,"[again]");
		for ($a=1;$a <= $menge;$a++) {
			$tmp = "tempvar".$a;
			$$tmp = str_replace("\"wct","\"wct".$a,str_replace("[again]","",$inhalt));
		}
		for ($a=1;$a <= $menge;$a++) {
			$tmp = "tempvar".$a;
			$inhalt = preg_replace("/\[again\]/",$$tmp,$inhalt,1);
		}
		if ($menge >= '1') { $out .= "<input type=\"hidden\" name=\"multicreate\" value=\"".$menge."\">"; }

		$cap = $this->captcha();
		$out .= rbr($this->filter_tables($inhalt)).($cap != '1' ? $cap : '')."<br/><input type=\"submit\" name=\"submit\" value=\"".__('Save all Changes', 'wct')."\"></form>";
		$out = do_shortcode(stripslashes($out));
	}
}
elseif ($_GET['wctfid'] == '' AND ($form->rights[0] == '1' OR $form->rights[3] == '1') AND $def != true) // Read rights needed
{
	$url = $this->generate_pagelink(array("/[&?]+wct[d-e]*fid=.*/","/[&?]+wctefid=[0-9]*/"),"");
	if ($form->t_setup != '') {
		if ($_REQUEST['wctstart'] != '') {
			$start = (integer)$_REQUEST['wctstart'];
			$limit2 = $start.",".$limit;
		} else { $limit2 = $limit; }

		$out .= "<script type=\"text/javascript\">
			function chkconfirm() {
				var answer = confirm('". __ ('Do you really want to delete this record?', 'wct')."');
				if (answer) { return true; } else { return false; }
			}
			</script>";

		if ($form->r_filter != '') { $filter = "AND ".$this->sqldatefilter(stripslashes($form->r_filter)); } else { $filter = ''; }
		$qry = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."wct".$form->r_table."` WHERE `status`='draft' ".$filter." LIMIT ".$limit2.";");
		if (count($qry) >= '1') {
			foreach ($qry as $row) {
				$out .= "<h3>".__('draft','wct')." ".__('Entries','wct')."</h3><table name=\"wct-table\" id=\"wct-table\" class=\"wct-table\">";
				$inhalt = preg_replace(array('/<\/td>[\r\n]*<td>/','/<\/td>[\r]*<td>/','/<\/td>[\n]*<td>/'), array('</td><td>','</td><td>','</td><td>'), $form->t_setup);
				if ($color == "1") { $color = "2"; } else { $color = "1"; }
					$out .= "<tr class=\"wct-td".$color."\" id=\"wct_omaster".$row->id."\" ".
					 "onmouseover=\"this.setAttribute('class', 'wct-td-hover')\" onmouseout=\"this.setAttribute('class', 'wct-td".$color."')\" >".
					 rbr(preg_replace("/\{(.*?)\}/e","((\$row->$1 >= '797043723' AND \$row->$1 < '3428195723') ? date('Y-m-d',\$row->$1) : \$row->$1)",$inhalt));

				if ($form->rights[1] == '1') { $out .= "<td><a href=\"".$url."wctfid=".$row->id."\" style=\"text-decoration:none;\">[EDIT]</a></td>"; }
				if ($form->rights[3] == '1') { $out .= "<td><a href=\"".$url."wctdfid=".$row->id."\" onclick=\"return chkconfirm()\" style=\"text-decoration:none;\">[DEL]</a></td>"; }
				$out .= "</tr>";
			}
			$qry = $wpdb->get_row("SELECT count(id) as `anz` FROM `".$wpdb->prefix."wct".$form->r_table."` WHERE `status`='draft' ".$filter);
			$menge = ceil($qry->anz / $limit);
			if ($menge > '1') {
				$url = $this->generate_pagelink("/[&?]+wctstart=[0-9]*/","");
				$out .= "<tr><td colspan=\"500\" class=\"wct-errorfield\"><center><b>".__('Page', 'wct').":</b> ";
				for ($x=1;$x <= $menge;$x++) {
					$l = ($limit * ($x - 1)) + 1;
					if($_GET['wctstart'] == $l OR ($l == '1' AND $_GET['wctstart'] == '')) { $out .= $x."&nbsp;"; }
					else {	$out .= "<a href=\"".$url."wctstart=".$l."\">".$x."</a>&nbsp;"; }
				}
				$out .= "</center></td></tr>";
			}
			$out .= "</table>".__('Draft Entries need an approval from an Admin to get published.','wct')."<h3>".__('active','wct')." ".__('Entries','wct')."</h3>";
		}		
		$out .= "<table name=\"wct-table\" id=\"wct-table\" class=\"wct-table\">";
		if ($form->r_filter != '') { $filter = "AND ".$this->sqldatefilter(stripslashes($form->r_filter)); } else { $filter = ''; }
		$qry = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."wct".$form->r_table."` WHERE `status`='active' ".$filter." LIMIT ".$limit2.";");
		if (count($qry) >= '1') {
			foreach ($qry as $row) {
				$inhalt = preg_replace(array('/<\/td>[\r\n]*<td>/','/<\/td>[\r]*<td>/','/<\/td>[\n]*<td>/'), array('</td><td>','</td><td>','</td><td>'), $form->t_setup);
				if ($color == "1") { $color = "2"; } else { $color = "1"; }
					$out .= "<tr class=\"wct-td".$color."\" id=\"wct_omaster".$row->id."\" ".
					 "onmouseover=\"this.setAttribute('class', 'wct-td-hover')\" onmouseout=\"this.setAttribute('class', 'wct-td".$color."')\" >".
					 rbr(preg_replace("/\{(.*?)\}/e","((\$row->$1 >= '797043723' AND \$row->$1 < '3428195723') ? date('Y-m-d',\$row->$1) : \$row->$1)",$inhalt));

				if ($form->rights[1] == '1') { $out .= "<td><a href=\"".$url."wctfid=".$row->id."\" style=\"text-decoration:none;\">[EDIT]</a></td>"; }
				if ($form->rights[3] == '1') { $out .= "<td><a href=\"".$url."wctdfid=".$row->id."\" onclick=\"return chkconfirm()\" style=\"text-decoration:none;\">[DEL]</a></td>"; }
				$out .= "</tr>";
			}
			$qry = $wpdb->get_row("SELECT count(id) as `anz` FROM `".$wpdb->prefix."wct".$form->r_table."` WHERE `status`='active' ".$filter);
			$menge = ceil($qry->anz / $limit);
			if ($menge > '1') {
				$url = $this->generate_pagelink("/[&?]+wctstart=[0-9]*/","");
				$out .= "<tr><td colspan=\"500\" class=\"wct-errorfield\"><center><b>".__('Page', 'wct').":</b> ";
				for ($x=1;$x <= $menge;$x++) {
					$l = ($limit * ($x - 1)) + 1;
					if($_GET['wctstart'] == $l OR ($l == '1' AND $_GET['wctstart'] == '')) { $out .= $x."&nbsp;"; }
					else {	$out .= "<a href=\"".$url."wctstart=".$l."\">".$x."</a>&nbsp;"; }
				}
				$out .= "</center></td></tr>";
			}
		}
		else {
			$out .= "<tr><td>".__('No entries found', 'wct')."</td></tr>";
		}
		$out .= "</table>\n\n<!-- Custom Tables Plugin 05a1a29bdcae7b12229e651a9fd48b11 -->\n\n";
		if ($form->rights[2] == '1') { $out .= "<form action=\"".$url."wctnew=1".($_GET['wctnew'] != '' ? "&wctnew=".$_GET['wctnew'] : "")."\" method=\"POST\"><input type=\"submit\" name=\"submit\" value=\"". __('New Entry', 'wct') ."\"></form>"; }

		}
	else {
		$out = "<p>".__('Form Setup', 'wct')." ".__('not configured', 'wct')."</p>";
	}
	$out = do_shortcode(stripslashes($out));
}
elseif (($_GET['wctfid'] != '' OR $def != false) AND $form->rights[1] == '1') { // write rights needed

	if ($form->r_filter != '') { $filter = "AND ".$this->sqldatefilter(stripslashes($form->r_filter)); } else { $filter = ''; }
	if ($def != false) {
		$row = $wpdb->get_row("SELECT * FROM `".$wpdb->prefix."wct".$form->r_table."` WHERE `status` != 'passive' ".$filter." LIMIT 1;");
		if (count($row) == '1') {
			$entry = $_GET['wctfid'] = (integer)$row->id;
		}
		else {
			if ($form->r_filter != '') {
				$wpdb->get_row("INSERT INTO `".$wpdb->prefix."wct".$form->r_table."` SET ".$filter.", `status`='active';");
				$entry = $_GET['wctfid'] = $wpdb->insert_id;
			}
			else {
				exit(__('ERROR: No entry defined yet and no filter given for autocreate.','wct'));
			}
		}
	}
	else {
		$entry = (integer)$_GET['wctfid'];
	}
	$url = $this->generate_pagelink(array("/[&?]+wctefid=save/","/[&?]+wctfid=[0-9]/","/[&?]+wctnew=[0-9]*/"),array("","","",""));

	echo "<script>function getY (el) {y = el.offsetTop;if (!el.offsetParent) { return y; } else return (y+getY(el.offsetParent)-35);}</script>";

	$table = $wpdb->get_row("SHOW CREATE TABLE `".$wpdb->prefix."wct".$form->r_table."`;");
	$array=array(); foreach($table as $member=>$data) { $array[$member]=$data; }
	$tmp = explode("PRIMARY KEY",$array['Create Table']);
	$felder = explode("\n",$tmp[0]);
	for ($i=2;$felder[$i] != '';$i++) {
		$x++;
		$feld[$x] =  preg_replace("/.*`(.*?)`.*/","$1",$felder[$i-1]);
		if (strpos ($felder[$i-1]," text") !== false) {
			$feld2[$feld[$x]] =  preg_replace("/.*`(.*)`\s(.*?)\s.*/","$2",str_replace(array(",","8 ,2","' ,'"),array(" ,","8.2","'.'"),$felder[$i-1]));
		}
		else {
			$feld2[$feld[$x]] =  preg_replace("/.*`(.*)`\s(.*\))\s.*/","$2",str_replace(array(",","8 ,2","' ,'"),array(" ,","8.2","'.'"),$felder[$i-1]));
		}
	}
	$row = $wpdb->get_row("SELECT * FROM `".$wpdb->prefix."wct".$form->r_table."` WHERE `status` != 'passive' AND `id`='".mres($entry)."' ".$filter." LIMIT 1;");
	$out .= "<h3>".__('Edit Entry','wct')."</h3><form id=\"checking\" action=\"".$url."wctfid=".$_GET['wctfid']."&wctefid=save".($_GET['wctnew'] != '' ? "&wctnew=".$_GET['wctnew'] : "")."\" method=\"POST\" enctype=\"multipart/form-data\">";

	$inhalt = str_replace("[again]","",$form->e_setup);
	$rights = ",".$form->r_fields.",";

	preg_match_all("/\{(.*?)\}/", $inhalt, $matches);

	foreach ($matches[1] as $val => $wert) {
		if (in_array($wert,$felder3)) { $addon2 = " required "; } else { $addon2 = ""; }
		if (strpos($rights,",".$wert.",") === false) {
			$addon = " style=\"background-color: #CCC;\" readonly";
		}
		else {
			$addon = "";
			if ($feld2[$wert] == "int(10)") {
				$addon = " id=\"f_date_".$wert."\" style=\"background-image: url('".plugins_url('custom-tables/jquery/cal.png')."');background-repeat: no-repeat;background-position: right center;width:120px;\"/>".
				     "<script type=\"text/javascript\">jQuery(document).ready(function(){jQuery('#f_date_".$wert."').datepicker({dateFormat : 'yy-mm-dd',firstDay: 1});});</script";
			}
		}

		if ($feld2[$wert] == "smallint(6)") { $inhalt = str_replace("{".$wert."}","<input size=\"7\" type=\"text\" name=\"".($addon != '' ? "wctn_" : "wctf_").$wert."\" value=\"".stripslashes($row->$wert)."\" maxsize=\"6\"".$addon2.$addon."/>",$inhalt); }
		elseif ($feld2[$wert] == "int(10)") {
			if (strpos($rights,",".$wert.",") === false) {
				$inhalt = str_replace("{".$wert."}","<input size=\"10\" type=\"text\" name=\"wctn_".$wert."\" value=\"".date("Y-m-d",$row->$wert)."\" maxsize=\"10\"".$addon2.$addon.">",$inhalt);
			}
			else {
				$inhalt = str_replace("{".$wert."}","<input size=\"10\" type=\"text\" name=\"wctf_".$wert."\" value=\"".date("Y-m-d",$row->$wert)."\" maxsize=\"10\"".$addon2.$addon.">",$inhalt);
			}
		}
		elseif ($feld2[$wert] == "int(11)") { $inhalt = str_replace("{".$wert."}","<input size=\"12\" type=\"text\" name=\"".($addon != '' ? "wctn_" : "wctf_").$wert."\" value=\"".stripslashes($row->$wert)."\" maxsize=\"11\"".$addon2.$addon."/>",$inhalt); }
		elseif ($feld2[$wert] == "varchar(32)") { $inhalt = str_replace("{".$wert."}","<input size=\"34\" type=\"text\" name=\"".($addon != '' ? "wctn_" : "wctf_").$wert."\" value=\"".stripslashes($row->$wert)."\" maxsize=\"32\"".$addon2.$addon."/>",$inhalt); }
		elseif ($feld2[$wert] == "varchar(64)") { $inhalt = str_replace("{".$wert."}","<input size=\"65\" type=\"text\" name=\"".($addon != '' ? "wctn_" : "wctf_").$wert."\" value=\"".stripslashes($row->$wert)."\" maxsize=\"64\"".$addon2.$addon."/>",$inhalt); }
		elseif ($feld2[$wert] == "varchar(128)") { $inhalt = str_replace("{".$wert."}","<input size=\"112\" type=\"text\" name=\"".($addon != '' ? "wctn_" : "wctf_").$wert."\" value=\"".stripslashes($row->$wert)."\" maxsize=\"128\"".$addon2.$addon."/>",$inhalt); }
		elseif ($feld2[$wert] == "varchar(160)" OR $feld2[$wert] == "varchar(254)") { $inhalt = str_replace("{".$wert."}","<input id=\"nix_".$wert."\" type=\"text\" size=\"50\" name=\"nix_".$wert."\" value=\"".stripslashes($row->$wert)."\" ".$addon2." readonly/><input id=\"nix2_".$wert."\" type=\"button\" value=\"".__('Browse','wct')."\" onclick=\"javascript:document.getElementById('nix_".$wert."').style.visibility = 'hidden';document.getElementById('nix_".$wert."').style.display = 'none';document.getElementById('wctp_".$wert."').style.visibility = 'visible';document.getElementById('wctp_".$wert."').style.display = 'block';document.getElementById('nix2_".$wert."').style.visibility = 'hidden';document.getElementById('nix2_".$wert."').style.display = 'none';document.getElementById('wctp_".$wert."').click();\"><input size=\"50\" id=\"wctp_".$wert."\" type=\"file\" name=\"wctp_".$wert."\" value=\"".stripslashes($row->$wert)."\" style=\"visibility:hidden;display:none;\"/>",$inhalt); }
		elseif (substr($feld2[$wert],0,4) == "enum") {
			if ($addon == "") {
				$tmp = "<select style=\"width:120px;\" name=\"".($addon != '' ? "wctn_" : "wctf_").$wert."\">";
				$defs = explode(".",str_replace("'","",substr($feld2[$wert],6,(strlen(rtrim($feld2[$wert]))-8))));

				foreach ($defs as $posibility) {
					$tmp .= "<option value=\"".$posibility."\"";
					if ($posibility == stripslashes($row->$wert)) { $tmp .= " selected"; }
					$tmp .= ">".$posibility."</option>";
				}
				$tmp .= "</select>";
			}
			else {
				$tmp = "<input size=\"10\" type=\"text\" name=\"wctn_".$wert."\" value=\"".stripslashes($row->$wert)."\" maxsize=\"32\"".$addon2.$addon."/>";
			}
			$inhalt = str_replace("{".$wert."}",$tmp,$inhalt);
		}
		elseif (substr($feld2[$wert],0,3) == "set") {
			$tmp = '';
			$defs = explode("'.'",substr($feld2[$wert],5,(strlen(rtrim($feld2[$wert]))-7)));
			$wasjetzt = ",".stripslashes($row->$wert).",";
			foreach ($defs as $posibility) {
				$ji++;
				$tmp .= "<div style=\"width:135px;float:left;overflow:hidden;\"><input ".$addon2." type=\"checkbox\" name=\"".($addon != '' ? "wctn_" : "wctf_").$wert."[]\" value=\"".$posibility."\"";
				if (stripos($wasjetzt,",".$posibility.",") !== false) { $tmp .= " checked"; }
				$tmp .= ">".substr($posibility,0,17)."</div>";
				if ($ji >= '6') { $tmp .= "<br/>"; $ji = '0'; }
			}
			$inhalt = str_replace("{".$wert."}",$tmp,$inhalt);
		}
		elseif ($feld2[$wert] == "float(8.2)") { $inhalt = str_replace("{".$wert."}","<input size=\"12\" type=\"text\" name=\"".($addon != '' ? "wctn_" : "wctf_").$wert."\" value=\"".stripslashes($row->$wert)."\" maxsize=\"11\"".$addon2.$addon."/>",$inhalt); }
		elseif ($feld2[$wert] == "text") {
			if ($addon != '') { $addon = " style=\"background-color: #CCC;\" readonly=\"readonly\""; } else { $mytextfelder .= "wctf_".$wert.","; }
			
			if ($mytextfelder != '') {
				ob_start();
				wp_editor(stripslashes($row->$wert), ($addon != '' ? "wctn_" : "wctf_").$wert, array('media_buttons' => false,'textarea_rows' => '10','tinymce' => true,'editor_css' => '<style> .wp-editor-wrap { line-height: 1px; } .wp-editor-tabs br { float:right; } pre { line-height: 0px; }</style>'));
				$out2 = str_replace(array("id=\"".($addon != '' ? "wctn_" : "wctf_").$wert."\""),array("id=\"".($addon != '' ? "wctn_" : "wctf_").$wert."\"".$addon),ob_get_contents());
				ob_end_clean();
				$inhalt = str_replace("{".$wert."}",$out2,$inhalt);
			}
			else {
				$inhalt = str_replace("{".$wert."}","<textarea id=\"wctf_".$wert."\" name=\"".($addon != '' ? "wctn_" : "wctf_").$wert."\" style=\"height: 155px;width: 100%;\"".$addon2.$addon.">".stripslashes($row->$wert)."</textarea>",$inhalt);
			}
		}
		else {
			$abfrage =  $wpdb->get_row("SELECT `name` FROM `".$wpdb->prefix."wct_fields` WHERE `definition`='".$feld2[$i]."' AND `special`='0' LIMIT 1;");
			if (count($abfrage) == '1') {
				if (preg_match("/(.*)/",$abfrage->name,$treffer)) {
					echo "<input id=\"wctf_".$wert."\" name=\"".($addon != '' ? "wctn_" : "wctf_").$wert."\" value=\"".stripslashes($row->$wert)."\"  size=\"".($treffer[1]+1)."\" type=\"text\" ".$addon2." />";
				}
				echo "<input id=\"wctf_".$wert."\" name=\"".($addon != '' ? "wctn_" : "wctf_").$wert."\" value=\"".stripslashes($row->$wert)."\" size=\"112\" type=\"text\" ".$addon2." />";
			}
			else {
				echo __('undefinied field type','wct')."<input id=\"wctf_".$wert."\" type=\"hidden\" name=\"".($addon != '' ? "wctn_" : "wctf_").$wert."\" value=\"".stripslashes($row->$wert)."\" ".$addon2." />";
			}
		}
	}
	
	if (count($felder3) >= '1') {
		$inhalt .= '<script>jQuery.validator.setDefaults({showErrors: function(map, list) {var focussed = document.activeElement;if (focussed && jQuery(focussed).is("input, textarea")) {jQuery(this.currentForm).tooltip("close", {currentTarget: focussed}, true)}this.currentElements.removeAttr("title").removeClass("ui-state-highlight");jQuery.each(list, function(index, error) {jQuery(error.element).attr("title", error.message).addClass("ui-state-highlight");});if (focussed && jQuery(focussed).is("input, textarea")) {jQuery(this.currentForm).tooltip("open", {target: focussed});}}});(function() {jQuery("#checking").tooltip({show: false,hide: false});jQuery(\"#checking\").validate();jQuery(":submit").button();})();</script>';
	}

	$out .= rbr($this->filter_tables($inhalt))."<br/>";
	
	$out .= "<input type=\"submit\" name=\"submit\" value=\"". __('Save all Changes', 'wct') ."\"></form>\n\n<!-- Custom Tables Plugin 05a1a29bdcae7b12229e651a9fd48b11 -->\n\n";
	$out = apply_filters('wctformoutput',do_shortcode(stripslashes($out)));
}

?>