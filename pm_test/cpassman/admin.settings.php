<?php
####################################################################################################
## File : admin.settings.php
## Author : Nils Laumaillé
## Description : Settings page
##
## DON'T CHANGE !!!
##
####################################################################################################
?>
<script type="text/javascript">
$(function() {
    $("#tabs").tabs();
});
</script>

<?php
#################
## FUNCTION permitting to store into DB the settings changes
################
function UpdateSettings($setting, $val, $type=''){
    global $server, $user, $pass, $database, $pre;

    if ( empty($type) ) $type = 'admin';

    //Connect to database
    require_once("sources/class.database.php");
    $db = new Database($server, $user, $pass, $database, $pre);
    $db->connect();

    //Check if setting is already in DB. If NO then insert, if YES then update.
    $data = $db->fetch_row("SELECT COUNT(*) FROM ".$pre."misc WHERE type='".$type."' AND intitule = '".$setting."'");
    if ( $data[0] == 0 ){
        $db->query_insert(
            "misc",
            array(
                'valeur' => $val,
                'type' => $type,
                'intitule' => $setting
            )
        );
        //in case of stats enabled, add the actual time
        if ( $setting == 'send_stats' )
            $db->query_insert(
                "misc",
                array(
                    'valeur' => time(),
                    'type' => $type,
                    'intitule' => $setting.'_time'
                )
            );
    }else{
        $db->query_update(
            "misc",
            array(
                'valeur' => $val
            ),
            "type='".$type."' AND intitule = '".$setting."'"
        );
        //in case of stats enabled, update the actual time
    	if ($setting == 'send_stats'){
    		//Check if previous time exists, if not them insert this value in DB
    		$data_time = $db->fetch_row("SELECT COUNT(*) FROM ".$pre."misc WHERE type='".$type."' AND intitule = '".$setting."_time'");
    		if ( $data_time[0] == 0 ){
    			$db->query_insert(
	    			"misc",
	    			array(
	    			    'valeur' => 0,
	    			    'type' => $type,
	    			    'intitule' => $setting.'_time'
	    			)
    			);
    		}else {
    			$db->query_update(
	    			"misc",
	    			array(
	    			    'valeur' => 0
	    			),
	    			"type='".$type."' AND intitule = '".$setting."_time'"
    			);
    		}
    	}

    }
    //save in variable
    if ( $type == "admin" ) $_SESSION['settings'][$setting] = $val;
    else if ( $type == "settings" ) $settings[$setting] = $val;
}

//SAVE CHANGES
if ( isset($_POST['save_button']) || isset($_POST['save_button_2']) ){
    //Update last seen items
    if ( isset($_SESSION['settings']['max_latest_items']) && $_SESSION['settings']['max_latest_items'] != $_POST['max_last_items'] ){
        UpdateSettings('max_latest_items',$_POST['max_last_items']);
    }

    //Update favourites
    if ( isset($_SESSION['settings']['enable_favourites']) && $_SESSION['settings']['enable_favourites'] != $_POST['enable_favourites'] ){
        UpdateSettings('enable_favourites',$_POST['enable_favourites']);
    }

    //Update last shown items
    if ( isset($_SESSION['settings']['show_last_items']) && $_SESSION['settings']['show_last_items'] != $_POST['show_last_items'] ){
        UpdateSettings('show_last_items',$_POST['show_last_items']);
    }

    //Update personal feature
    if ( isset($_SESSION['settings']['enable_pf_feature']) && $_SESSION['settings']['enable_pf_feature'] != $_POST['enable_pf_feature'] ){
        UpdateSettings('enable_pf_feature',$_POST['enable_pf_feature']);
    }

    //Update loggin connections setting
    if ( isset($_SESSION['settings']['log_connections']) && $_SESSION['settings']['log_connections'] != $_POST['log_connections'] ){
        UpdateSettings('log_connections',$_POST['log_connections']);
    }

    //Update date format setting
    if ( isset($_SESSION['settings']['date_format']) && $_SESSION['settings']['date_format'] != $_POST['date_format'] ){
        UpdateSettings('date_format',$_POST['date_format']);
    }

    //Update time format setting
    if ( isset($_SESSION['settings']['time_format']) && $_SESSION['settings']['time_format'] != $_POST['time_format'] ){
        UpdateSettings('time_format',$_POST['time_format']);
    }

    //Update duplicate folder setting
    if ( isset($_SESSION['settings']['duplicate_folder']) && $_SESSION['settings']['duplicate_folder'] != $_POST['duplicate_folder'] ){
        UpdateSettings('duplicate_folder',$_POST['duplicate_folder']);
    }

    //Update duplicate item setting
    if ( isset($_SESSION['settings']['duplicate_item']) && $_SESSION['settings']['duplicate_item'] != $_POST['duplicate_item'] ){
        UpdateSettings('duplicate_item',$_POST['duplicate_item']);
    }

    //Update number_of_used_pw setting
    if ( isset($_SESSION['settings']['number_of_used_pw']) && $_SESSION['settings']['number_of_used_pw'] != $_POST['number_of_used_pw'] ){
        UpdateSettings('number_of_used_pw',$_POST['number_of_used_pw']);
    }

    //Update duplicate Manager edit
    if ( isset($_SESSION['settings']['manager_edit']) && $_SESSION['settings']['manager_edit'] != $_POST['manager_edit'] ){
        UpdateSettings('manager_edit',$_POST['manager_edit']);
    }

    //Update cpassman_dir
    if ( isset($_SESSION['settings']['cpassman_dir']) && $_SESSION['settings']['cpassman_dir'] != $_POST['cpassman_dir'] ){
        UpdateSettings('cpassman_dir',$_POST['cpassman_dir']);
    }

    //Update cpassman_url
    if ( isset($_SESSION['settings']['cpassman_url']) && $_SESSION['settings']['cpassman_url'] != $_POST['cpassman_url'] ){
        UpdateSettings('cpassman_url',$_POST['cpassman_url']);
    }

    //Update pw_life_duration
    if ( isset($_SESSION['settings']['pw_life_duration']) && $_SESSION['settings']['pw_life_duration'] != $_POST['pw_life_duration'] ){
        UpdateSettings('pw_life_duration',$_POST['pw_life_duration']);
    }

    //Update favicon
    if ( isset($_SESSION['settings']['favicon']) && $_SESSION['settings']['favicon'] != $_POST['favicon'] ){
        UpdateSettings('favicon',$_POST['favicon']);
    }

    //Update activate_expiration setting
    if ( isset($_SESSION['settings']['activate_expiration']) && $_SESSION['settings']['activate_expiration'] != $_POST['activate_expiration'] ){
        UpdateSettings('activate_expiration',$_POST['activate_expiration']);
    }

    //Update maintenance mode
    if ( @$_SESSION['settings']['maintenance_mode'] != $_POST['maintenance_mode'] ){
        UpdateSettings('maintenance_mode',$_POST['maintenance_mode']);
    }
/*
    //Update LDAP mode
    if ( @$_SESSION['settings']['ldap_mode'] != $_POST['ldap_mode'] ){
        UpdateSettings('ldap_mode',$_POST['ldap_mode']);
    }
*/
    //Update richtext
    if ( @$_SESSION['settings']['richtext'] != $_POST['richtext'] ){
        UpdateSettings('richtext',$_POST['richtext']);
    }

    //Update send_stats
    if ( @$_SESSION['settings']['send_stats'] != $_POST['send_stats'] ){
        UpdateSettings('send_stats',$_POST['send_stats']);
    }

	//Update allow_print
	if ( @$_SESSION['settings']['allow_print'] != $_POST['allow_print'] ){
		UpdateSettings('allow_print',$_POST['allow_print']);
	}
}

echo '
<div style="margin-top:10px;">
    <form name="form_settings" method="post" action="">';
        // Main div for TABS
        echo '
        <div style="width:900px;margin:auto; line-height:20px; padding:10px;" id="tabs">';
            // Tabs menu
            echo '
            <ul>
                <li><a href="#tabs-1">'.$txt['admin_settings_title'].'</a></li>
                <li><a href="#tabs-3">'.$txt['admin_misc_title'].'</a></li>
                <li><a href="#tabs-2">'.$txt['admin_actions_title'].'</a></li>
            </ul>';
			//<li><a href="#tabs-4">'.$txt['admin_ldap_menu'].'</a></li>
            // --------------------------------------------------------------------------------
            // TAB N°1
            echo '
            <div id="tabs-1">
				<table border="0">';
                //cpassman_dir
                echo '
                <tr style="margin-bottom:3px">
                    <td>
                    	<span class="ui-icon ui-icon-disk" style="float: left; margin-right: .3em;">&nbsp;</span>
                    	<label for="cpassman_dir">'.$txt['admin_misc_cpassman_dir'].'</label>
					</td>
					<td>
                    	<input type="text" size="80" id="cpassman_dir" name="cpassman_dir" value="', isset($_SESSION['settings']['cpassman_dir']) ? $_SESSION['settings']['cpassman_dir'] : '', '" />
					<td>
                </tr>';

                //cpassman_url
				echo '
				<tr style="margin-bottom:3px">
				    <td>
				    	<span class="ui-icon ui-icon-disk" style="float: left; margin-right: .3em;">&nbsp;</span>
                    	<label for="cpassman_url">'.$txt['admin_misc_cpassman_url'].'</label>
					</td>
					<td>
                    	<input type="text" size="80" id="cpassman_url" name="cpassman_url" value="', isset($_SESSION['settings']['cpassman_url']) ? $_SESSION['settings']['cpassman_url'] : '', '" />
                	<td>
                </tr>';

                //Favicon
                echo '
                <tr style="margin-bottom:3px">
				    <td>
	                    <span class="ui-icon ui-icon-disk" style="float: left; margin-right: .3em;">&nbsp;</span>
	                    <label for="favicon">'.$txt['admin_misc_favicon'].'</label>
					</td>
					<td>
                    	<input type="text" size="80" id="favicon" name="favicon" value="', isset($_SESSION['settings']['favicon']) ? $_SESSION['settings']['favicon'] : '', '" />
					<td>
                </tr>
            </table>';

                //DATE format
                echo '
			<table>
                <tr style="margin-bottom:3px">
				    <td>
	                    <span class="ui-icon ui-icon-disk" style="float: left; margin-right: .3em;">&nbsp;</span>
	                    <label for="date_format">'.$txt['date_format'].'</label>
					</td>
					<td>
                    	<input type="text" size="6" id="date_format" name="date_format" value="', isset($_SESSION['settings']['date_format']) ? $_SESSION['settings']['date_format'] : 'd/m/Y', '" />
                	<td>
                </tr>';

                //TIME format
                echo '
                <tr style="margin-bottom:3px">
				    <td>
	                    <span class="ui-icon ui-icon-disk" style="float: left; margin-right: .3em;">&nbsp;</span>
	                    <label for="time_format">'.$txt['time_format'].'</label>
					</td>
					<td>
                    	<input type="text" size="6" id="time_format" name="time_format" value="', isset($_SESSION['settings']['time_format']) ? $_SESSION['settings']['time_format'] : 'H:i:s', '" />
					<td>
                </tr>';

                //Number of used pw
                echo '
                <tr style="margin-bottom:3px">
				    <td>
	                    <span class="ui-icon ui-icon-disk" style="float: left; margin-right: .3em;">&nbsp;</span>
	                    <label for="number_of_used_pw">'.$txt['number_of_used_pw'].'</label>
					</td>
					<td>
                    	<input type="text" size="4" id="number_of_used_pw" name="number_of_used_pw" value="', isset($_SESSION['settings']['number_of_used_pw']) ? $_SESSION['settings']['number_of_used_pw'] : '5', '" />
                	<td>
                </tr>';

                //Number days before changing pw
                echo '
                <tr style="margin-bottom:3px">
				    <td>
	                    <span class="ui-icon ui-icon-disk" style="float: left; margin-right: .3em;">&nbsp;</span>
	                    <label for="pw_life_duration">'.$txt['pw_life_duration'].'</label>
					</td>
					<td>
                    	<input type="text" size="4" id="pw_life_duration" name="pw_life_duration" value="', isset($_SESSION['settings']['pw_life_duration']) ? $_SESSION['settings']['pw_life_duration'] : '5', '" />
                	<td>
                </tr>';

                //Maintenance mode
                echo '
                <tr style="margin-bottom:3px">
				    <td>
	                    <span class="ui-icon ui-icon-disk" style="float: left; margin-right: .3em;">&nbsp;</span>
	                    <label for="maintenance_mode">'.
	                        $txt['settings_maintenance_mode'].'
	                        &nbsp;<img src="includes/images/question-small-white.png" class="tip" alt="" title="'.$txt['settings_maintenance_mode_tip'].'" />
	                    </label>
					</td>
					<td>
	                    <select id="maintenance_mode" name="maintenance_mode">
	                        <option value="1"', isset($_SESSION['settings']['maintenance_mode']) && $_SESSION['settings']['maintenance_mode'] == 1 ? ' selected="selected"' : '', '>'.$txt['yes'].'</option>
	                        <option value="0"', isset($_SESSION['settings']['maintenance_mode']) && $_SESSION['settings']['maintenance_mode'] != 1 ? ' selected="selected"' : (!isset($_SESSION['settings']['maintenance_mode']) ? ' selected="selected"':''), '>'.$txt['no'].'</option>
	                    </select>
	                <td>
                </tr>';

                //Enable send_stats
                echo '
                <tr style="margin-bottom:3px">
				    <td>
	                    <span class="ui-icon ui-icon-disk" style="float: left; margin-right: .3em;">&nbsp;</span>
	                    <label for="ldap_mode">'.
	                        $txt['settings_send_stats'].'
	                        &nbsp;<img src="includes/images/question-small-white.png" class="tip" alt="" title="'.$txt['settings_send_stats_tip'].'" />
	                    </label>
					</td>
					<td>
	                    <select id="send_stats" name="send_stats">
	                        <option value="1"', isset($_SESSION['settings']['send_stats']) && $_SESSION['settings']['send_stats'] == 1 ? ' selected="selected"' : '', '>'.$txt['yes'].'</option>
	                        <option value="0"', isset($_SESSION['settings']['send_stats']) && $_SESSION['settings']['send_stats'] != 1 ? ' selected="selected"' : (!isset($_SESSION['settings']['send_stats']) ? ' selected="selected"':''), '>'.$txt['no'].'</option>
	                    </select>
	                <td>
                </tr>
                </table>';

                //Save button
                echo '
                <div style="margin:auto;">
                    <input type="submit" id="save_button" name="save_button" value="'.$txt['save_button'].'" />
                </div>
            </div>';
            // --------------------------------------------------------------------------------

            // --------------------------------------------------------------------------------
            // TAB N°2
            echo '
            <div id="tabs-2">';

                //Update Personal folders for users
                echo '
                <div style="margin-bottom:3px">
                    <span class="ui-icon ui-icon-gear" style="float: left; margin-right: .3em;">&nbsp;</span>
                    <a href="#" onclick="LaunchAdminActions(\'admin_action_check_pf\')" style="cursor:pointer;">'.$txt['admin_action_check_pf'].'</a>
                    <span id="result_admin_action_check_pf" style="margin-left:10px;display:none;"><img src="includes/images/tick.png" alt="" /></span>
                </div>';

                //Clean DB with orphan items
                echo '
                <div style="margin-bottom:3px">
                    <span class="ui-icon ui-icon-gear" style="float: left; margin-right: .3em;">&nbsp;</span>
                    <a href="#" onclick="LaunchAdminActions(\'admin_action_db_clean_items\')" style="cursor:pointer;">'.$txt['admin_action_db_clean_items'].'</a>
                    <span style="margin-left:0px;"><img src="includes/images/question-small-white.png" class="tip" alt="" title="'.$txt['admin_action_db_clean_items_tip'].'" /></span>
                    <span id="result_admin_action_db_clean_items" style="margin-left:10px;"></span>
                </div>';

                //Optimize the DB
                echo '
                <div style="margin-bottom:3px">
                    <span class="ui-icon ui-icon-gear" style="float: left; margin-right: .3em;">&nbsp;</span>
                    <a href="#" onclick="LaunchAdminActions(\'admin_action_db_optimize\')" style="cursor:pointer;">'.$txt['admin_action_db_optimize'].'</a>
                    <span id="result_admin_action_db_optimize" style="margin-left:10px;"></span>
                </div>';

                //Backup the DB
                echo '
                <div style="margin-bottom:3px">
                    <span class="ui-icon ui-icon-gear" style="float: left; margin-right: .3em;">&nbsp;</span>
                    <a href="#" onclick="javascript:$(\'#result_admin_action_db_backup_get_key\').toggle();" style="cursor:pointer;">'.$txt['admin_action_db_backup'].'</a>
                    <span style="margin-left:0px;"><img src="includes/images/question-small-white.png" class="tip" alt="" title="'.$txt['admin_action_db_backup_tip'].'" /></span>
                    <span id="result_admin_action_db_backup" style="margin-left:10px;"></span>
                    <span id="result_admin_action_db_backup_get_key" style="margin-left:10px;display:none;">
                        &nbsp;'.$txt['encrypt_key'].'<input type="text" size="20" id="result_admin_action_db_backup_key" />
                        <img src="includes/images/question-small-white.png" class="tip" alt="" title="'.$txt['admin_action_db_backup_key_tip'].'" />
                        <img src="includes/images/asterisk.png" class="tip" alt="" title="'.$txt['admin_action_db_backup_start_tip'].'" onclick="LaunchAdminActions(\'admin_action_db_backup\')" style="cursor:pointer;" />
                    </span>
                </div>';

                //Restore the DB
                echo '
                <div style="margin-bottom:3px">
                    <span class="ui-icon ui-icon-gear" style="float: left; margin-right: .3em;">&nbsp;</span>
                    <a href="#" onclick="javascript:$(\'#result_admin_action_db_restore_get_file\').toggle();" style="cursor:pointer;">'.$txt['admin_action_db_restore'].'</a>
                    <span style="margin-left:0px;"><img src="includes/images/question-small-white.png" class="tip" alt="" title="'.$txt['admin_action_db_restore_tip'].'" /></span>
                    <span id="result_admin_action_db_restore" style="margin-left:10px;"></span>
                    <span id="result_admin_action_db_restore_get_file" style="margin-left:10px;display:none;"><input id="fileInput_restore_sql" name="fileInput_restore_sql" type="file" /></span>
                </div>';

                //Purge old files
                echo '
                <div style="margin-bottom:3px">
                    <span class="ui-icon ui-icon-gear" style="float: left; margin-right: .3em;">&nbsp;</span>
                    <a href="#" onclick="LaunchAdminActions(\'admin_action_purge_old_files\')" style="cursor:pointer;">'.$txt['admin_action_purge_old_files'].'</a>
                    <span style="margin-left:0px;"><img src="includes/images/question-small-white.png" class="tip" alt="" title="'.$txt['admin_action_purge_old_files_tip'].'" /></span>
                    <span id="result_admin_action_purge_old_files" style="margin-left:10px;"></span>
                </div>';

            echo '
            </div>';
            // --------------------------------------------------------------------------------

            // --------------------------------------------------------------------------------
            // TAB N°3
            echo '
            <div id="tabs-3">';

                //Managers can edit & delete items they are allowed to see
                echo '
                <div style="margin-bottom:3px">
                    <span class="ui-icon ui-icon-wrench" style="float: left; margin-right: .3em;">&nbsp;</span>
                    <label for="manager_edit" class="form_label_500">'.$txt['settings_manager_edit'].'</label>
                    <select id="manager_edit" name="manager_edit">
                        <option value="1"', isset($_SESSION['settings']['manager_edit']) && $_SESSION['settings']['manager_edit'] == 1 ? ' selected="selected"' : '', '>'.$txt['yes'].'</option>
                        <option value="0"', isset($_SESSION['settings']['manager_edit']) && $_SESSION['settings']['manager_edit'] != 1 ? ' selected="selected"' : (!isset($_SESSION['settings']['manager_edit']) ? ' selected="selected"':''), '>'.$txt['no'].'</option>
                    </select>
                </div>';

                //max items
                echo '
                <div style="margin-bottom:3px">
                    <span class="ui-icon ui-icon-wrench" style="float: left; margin-right: .3em;">&nbsp;</span>
                    <label for="max_last_items" class="form_label_500">'.$txt['max_last_items'].'</label>
                    <input type="text" size="4" id="max_last_items" name="max_last_items" value="', isset($_SESSION['settings']['max_latest_items']) ? $_SESSION['settings']['max_latest_items'] : '', '" />
                </div>';

                //Show last items
                echo '
                <div style="margin-bottom:3px">
                    <span class="ui-icon ui-icon-wrench" style="float: left; margin-right: .3em;">&nbsp;</span>
                    <label for="show_last_items" class="form_label_500">'.$txt['show_last_items'].'</label>
                    <select id="show_last_items" name="show_last_items">
                        <option value="1"', isset($_SESSION['settings']['show_last_items']) && $_SESSION['settings']['show_last_items'] == 1 ? ' selected="selected"' : '', '>'.$txt['yes'].'</option>
                        <option value="0"', isset($_SESSION['settings']['show_last_items']) && $_SESSION['settings']['show_last_items'] != 1 ? ' selected="selected"' : '', '>'.$txt['no'].'</option>
                    </select>
                </div>';

                //Duplicate folder
                echo '
                <div style="margin-bottom:3px">
                    <span class="ui-icon ui-icon-wrench" style="float: left; margin-right: .3em;">&nbsp;</span>
                    <label for="duplicate_folder" class="form_label_500">'.$txt['duplicate_folder'].'</label>
                    <select id="duplicate_folder" name="duplicate_folder">
                        <option value="1"', isset($_SESSION['settings']['duplicate_folder']) && $_SESSION['settings']['duplicate_folder'] == 1 ? ' selected="selected"' : '', '>'.$txt['yes'].'</option>
                        <option value="0"', isset($_SESSION['settings']['duplicate_folder']) && $_SESSION['settings']['duplicate_folder'] != 1 ? ' selected="selected"' : '', '>'.$txt['no'].'</option>
                    </select>
                </div>';

                //Duplicate item name
                echo '
                <div style="margin-bottom:3px">
                    <span class="ui-icon ui-icon-wrench" style="float: left; margin-right: .3em;">&nbsp;</span>
                    <label for="duplicate_item" class="form_label_500">'.$txt['duplicate_item'].'</label>
                    <select id="duplicate_item" name="duplicate_item">
                        <option value="1"', isset($_SESSION['settings']['duplicate_item']) && $_SESSION['settings']['duplicate_item'] == 1 ? ' selected="selected"' : '', '>'.$txt['yes'].'</option>
                        <option value="0"', isset($_SESSION['settings']['duplicate_item']) && $_SESSION['settings']['duplicate_item'] != 1 ? ' selected="selected"' : '', '>'.$txt['no'].'</option>
                    </select>
                </div>';

                //enable FAVOURITES
                echo '
                <div style="margin-bottom:3px">
                    <span class="ui-icon ui-icon-wrench" style="float: left; margin-right: .3em;">&nbsp;</span>
                    <label for="enable_favourites" class="form_label_500">'.$txt['enable_favourites'].'</label>
                    <select id="enable_favourites" name="enable_favourites">
                        <option value="1"', isset($_SESSION['settings']['settings']['enable_favourites']) && $_SESSION['settings']['enable_favourites'] == 1 ? ' selected="selected"' : '', '>'.$txt['yes'].'</option>
                        <option value="0"', isset($_SESSION['settings']['enable_favourites']) && $_SESSION['settings']['enable_favourites'] != 1 ? ' selected="selected"' : '', '>'.$txt['no'].'</option>
                    </select>
                </div>';

                //enable PF
                echo '
                <div style="margin-bottom:3px">
                    <span class="ui-icon ui-icon-wrench" style="float: left; margin-right: .3em;">&nbsp;</span>
                    <label for="enable_pf_feature" class="form_label_500">'.$txt['enable_personal_folder_feature'].'</label>
                    <select id="enable_pf_feature" name="enable_pf_feature">
                        <option value="1"', isset($_SESSION['settings']['enable_pf_feature']) && $_SESSION['settings']['enable_pf_feature'] == 1 ? ' selected="selected"' : '', '>'.$txt['yes'].'</option>
                        <option value="0"', isset($_SESSION['settings']['enable_pf_feature']) && $_SESSION['settings']['enable_pf_feature'] != 1 ? ' selected="selected"' : '', '>'.$txt['no'].'</option>
                    </select>
                </div>';

                //Enable log connections
                echo '
                <div style="margin-bottom:3px">
                    <span class="ui-icon ui-icon-wrench" style="float: left; margin-right: .3em;">&nbsp;</span>
                    <label for="log_connections" class="form_label_500">'.$txt['settings_log_connections'].'</label>
                    <select id="log_connections" name="log_connections">
                        <option value="1"', isset($_SESSION['settings']['log_connections']) && $_SESSION['settings']['log_connections'] == 1 ? ' selected="selected"' : '', '>'.$txt['yes'].'</option>
                        <option value="0"', isset($_SESSION['settings']['log_connections']) && $_SESSION['settings']['log_connections'] != 1 ? ' selected="selected"' : '', '>'.$txt['no'].'</option>
                    </select>
                </div>';

                //Enable activate_expiration
                echo '
                <div style="margin-bottom:3px">
                    <span class="ui-icon ui-icon-wrench" style="float: left; margin-right: .3em;">&nbsp;</span>
                    <label for="activate_expiration" class="form_label_500">
                        '.$txt['admin_setting_activate_expiration'].'
                        <span style="margin-left:0px;"><img src="includes/images/question-small-white.png" class="tip" alt="" title="'.$txt['admin_setting_activate_expiration_tip'].'" /></span>
                    </label>
                    <select id="activate_expiration" name="activate_expiration">
                        <option value="1"', isset($_SESSION['settings']['activate_expiration']) && $_SESSION['settings']['activate_expiration'] == 1 ? ' selected="selected"' : '', '>'.$txt['yes'].'</option>
                        <option value="0"', ( (isset($_SESSION['settings']['activate_expiration']) && $_SESSION['settings']['activate_expiration'] != 1) || !isset($_SESSION['settings']['activate_expiration']) ) ? ' selected="selected"' : '', '>'.$txt['no'].'</option>
                    </select>
                </div>';

                //Enable richtext
                echo '
                <div style="margin-bottom:3px">
                    <span class="ui-icon ui-icon-wrench" style="float: left; margin-right: .3em;">&nbsp;</span>
                    <label for="richtext" class="form_label_500">
                        '.$txt['settings_richtext'].'
                        <span style="margin-left:0px;"><img src="includes/images/question-small-white.png" class="tip" alt="" title="'.$txt['settings_richtext_tip'].'" /></span>
                    </label>
                    <select id="richtext" name="richtext">
                        <option value="1"', isset($_SESSION['settings']['richtext']) && $_SESSION['settings']['richtext'] == 1 ? ' selected="selected"' : '', '>'.$txt['yes'].'</option>
                        <option value="0"', ( (isset($_SESSION['settings']['richtext']) && $_SESSION['settings']['richtext'] != 1) || !isset($_SESSION['settings']['richtext']) ) ? ' selected="selected"' : '', '>'.$txt['no'].'</option>
                    </select>
                </div>';

				//Enable Printing
				echo '
				<div style="margin-bottom:3px">
				    <span class="ui-icon ui-icon-wrench" style="float: left; margin-right: .3em;">&nbsp;</span>
				    <label for="allow_print" class="form_label_500">
				        '.$txt['settings_printing'].'
				        <span style="margin-left:0px;"><img src="includes/images/question-small-white.png" class="tip" alt="" title="'.$txt['settings_printing_tip'].'" /></span>
				    </label>
				    <select id="allow_print" name="allow_print">
				        <option value="1"', isset($_SESSION['settings']['allow_print']) && $_SESSION['settings']['allow_print'] == 1 ? ' selected="selected"' : '', '>'.$txt['yes'].'</option>
				        <option value="0"', ( (isset($_SESSION['settings']['allow_print']) && $_SESSION['settings']['allow_print'] != 1) || !isset($_SESSION['settings']['allow_print']) ) ? ' selected="selected"' : '', '>'.$txt['no'].'</option>
				    </select>
				</div>';

                //Save button
                echo '
                <div style="margin:auto;">
                    <input type="submit" id="save_button2" name="save_button_2" value="'.$txt['save_button'].'" />
                </div>';

            echo '
            </div>';
			// --------------------------------------------------------------------------------
/*
			// --------------------------------------------------------------------------------
			// TAB N°4
			echo '
			<div id="tabs-4">';

			//Enable LDAP mode
			echo '
			<div style="margin-bottom:3px">
			    <span class="ui-icon ui-icon-disk" style="float: left; margin-right: .3em;">&nbsp;</span>
			    <label for="ldap_mode" class="form_label_500">'.
			        $txt['settings_ldap_mode'].'
			        &nbsp;<img src="includes/images/question-small-white.png" class="tip" alt="" title="'.$txt['settings_ldap_mode_tip'].'" />
                </label>
                <select id="ldap_mode" name="ldap_mode">
			        <option value="1"', isset($_SESSION['settings']['ldap_mode']) && $_SESSION['settings']['ldap_mode'] == 1 ? ' selected="selected"' : '', '>'.$txt['yes'].'</option>
			        <option value="0"', isset($_SESSION['settings']['ldap_mode']) && $_SESSION['settings']['ldap_mode'] != 1 ? ' selected="selected"' : (!isset($_SESSION['settings']['ldap_mode']) ? ' selected="selected"':''), '>'.$txt['no'].'</option>
            	</select>
            </div>';

			echo '
			</div>';
			// --------------------------------------------------------------------------------
*/
        echo '
        </div>
    </form>
</div>';
?>