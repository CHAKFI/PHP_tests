<?php
####################################################################################################
## File : users.php
## Author : Nils Laumaillé
## Description : Users page
##
## DON'T CHANGE !!!
##
####################################################################################################

//load help
require_once('includes/language/'.$_SESSION['user_language'].'_admin_help.php');

require_once ("sources/NestedTree.class.php");
$tree = new NestedTree($pre.'nested_tree', 'id', 'parent_id', 'title');
$tree_desc = $tree->getDescendants();

//Build FUNCTIONS list
$liste_fonctions = array();
$rows = $db->fetch_all_array("SELECT id,title FROM ".$pre."functions ORDER BY title ASC");
foreach($rows as $reccord) {
    $liste_fonctions[$reccord['id']] = array('id'=>$reccord['id'],'title'=>$reccord['title']);
}

//Display list of USERS
echo '
<div class="title ui-widget-content ui-corner-all">
    '.$txt['admin_users'].'&nbsp;&nbsp;&nbsp;
    <img src="includes/images/user--plus.png" title="'.$txt['new_user_title'].'" onclick="OpenDialog(\'add_new_user\')" style="cursor:pointer;" />
    <span style="float:right;margin-right:5px;"><img src="includes/images/question-white.png" style="cursor:pointer" title="'.$txt['show_help'].'" onclick="OpenDialog(\'help_on_users\')" /></span>
</div>';

echo '
<form name="form_utilisateurs" method="post" action="">
    <div style="line-height:20px;"  align="center">
        <table cellspacing="0" cellpadding="2">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>'.$txt['index_login'].'</th>
                    <th>'.$txt['functions'].'</th>
                    <th>'.$txt['authorized_groups'].'</th>
                    <th>'.$txt['forbidden_groups'].'</th>
                    <th title="'.$txt['god'].'"><img src="includes/images/user-black.png" /></th>
                    <th title="'.$txt['gestionnaire'].'"><img src="includes/images/user-worker.png" /></th>
                    ', (isset($_SESSION['enable_pf_feature']) && $_SESSION['enable_pf_feature']==1) ? '<th title="'.$txt['enable_personal_folder'].'"><img src="includes/images/folder_key.png" /></th>' : '', '
                    <th title="'.$txt['user_del'].'"><img src="includes/images/user--minus.png" /></th>
                    <th title="'.$txt['pw_change'].'"><img src="includes/images/lock__pencil.png" /></th>
                    <th title="'.$txt['email_change'].'"><img src="includes/images/mail.png" /></th>
                </tr>
            </thead>
            <tbody>';
        $x = 0;
        //Get through all users
        $rows = $db->fetch_all_array("SELECT * FROM ".$pre."users");
        foreach($rows as $reccord){
            //Get list of allowed functions
                $list_allo_fcts = "";
                if ( $reccord['admin'] != 1 ){
                    if ( count($liste_fonctions) > 0 ){
                        foreach($liste_fonctions as $fonction){
                            if ( in_array($fonction['id'],explode(";",$reccord['fonction_id'])) )
                                $list_allo_fcts .= '<img src="includes/images/arrow-000-small.png" />'.htmlspecialchars($fonction['title'],ENT_COMPAT,$k['charset']).'<br />';
                        }
                    }
                    if ( empty($list_allo_fcts) ) $list_allo_fcts = '<img src="includes/images/error.png" title="'.$txt['user_alarm_no_function'].'" />';
                }

            //Get list of allowed groups
                $list_allo_grps = "";
                if ( $reccord['admin'] != 1 ){
                    if ( count($tree_desc) > 0 ){
                        foreach($tree_desc as $t){
                            if ( @!in_array($t->id,$_SESSION['groupes_interdits']) && in_array($t->id,$_SESSION['groupes_visibles']) ){
                                $ident="";
                                if ( in_array($t->id,explode(";",$reccord['groupes_visibles'])) )
                                    $list_allo_grps .= '<img src="includes/images/arrow-000-small.png" />'.htmlspecialchars($ident.$t->title,ENT_COMPAT,$k['charset']).'<br />';
                                $prev_level = $t->nlevel;
                            }
                        }
                    }
                }

            //Get list of forbidden groups
                $list_forb_grps = "";
                if ( $reccord['admin'] != 1 ){
                    if ( count($tree_desc) > 0 ){
                        foreach($tree_desc as $t){
                            $ident="";
                            if ( in_array($t->id,explode(";",$reccord['groupes_interdits'])) )
                                $list_forb_grps .= '<img src="includes/images/arrow-000-small.png" />'.htmlspecialchars($ident.$t->title,ENT_COMPAT,$k['charset']).'<br />';
                            $prev_level = $t->nlevel;
                        }
                    }
                }

            //Display Grid
            if ( !($_SESSION['user_gestionnaire'] == 1 && $reccord['admin'] == 1) ){
            echo '<tr class="ligne'.($x%2).'">
                    <td align="center">'.$reccord['id'].'</td>
                    <td align="center"><p class="editable_textarea" id="login_'.$reccord['id'].'">'.$reccord['login'].'</p></td>
                    <td>', $reccord['admin'] != 1 ? '
                        <div id="list_function_user_'.$reccord['id'].'" style="text-align:center;">'
                            .$list_allo_fcts.'
                        </div>
                        <div style="text-align:center;"><img src="includes/images/cog_edit.png" style="cursor:pointer;" onclick="Open_Div_Change(\''.$reccord['id'].'\',\'functions\')" title="'.$txt['change_function'].'" /></div>' : '', '
                    </td>
                    <td>', $reccord['admin'] != 1 ? '
                        <div id="list_autgroups_user_'.$reccord['id'].'" style="text-align:center;">'
                        .$list_allo_grps.'
                        </div>
                        <div style="text-align:center;"><img src="includes/images/cog_edit.png" style="cursor:pointer;" onclick="Open_Div_Change(\''.$reccord['id'].'\',\'autgroups\')" title="'.$txt['change_authorized_groups'].'" /></div>' : '', '
                    </td>
                    <td>', $reccord['admin'] != 1 ? '
                        <div id="list_forgroups_user_'.$reccord['id'].'" style="text-align:center;">'
                            .$list_forb_grps. '
                        </div>
                        <div style="text-align:center;"><img src="includes/images/cog_edit.png" style="cursor:pointer;" onclick="Open_Div_Change(\''.$reccord['id'].'\',\'forgroups\')" title="'.$txt['change_forbidden_groups'].'" /></div>' : '', '
                    </td>
                    <td align="center">
                        <input type="checkbox" id="cb_admin_'.$reccord['id'].'" onchange="Changer_Droit_Admin(\''.$reccord['id'].'\')"', $reccord['admin']==1 ? 'checked' : '', ' ', $_SESSION['user_gestionnaire'] == 1 ? 'disabled':'' , ' />
                    </td>
                    <td align="center">
                        <input type="checkbox" id="cb_gest_groupes_'.$reccord['id'].'" onchange="Changer_Droit_Groupes(\''.$reccord['id'].'\')"', $reccord['gestionnaire']==1 ? 'checked' : '', ' />
                    </td>';
                    if( isset($_SESSION['enable_pf_feature']) && $_SESSION['enable_pf_feature']==1)
                        echo '
                    <td align="center">
                        <input type="checkbox" id="cb_personal_folder_'.$reccord['id'].'" onchange="Change_Personal_Folder(\''.$reccord['id'].'\')"', $reccord['personal_folder']==1 ? 'checked' : '', ' />
                    </td>';
                    echo '
                    <td align="center">
                        <img src="includes/images/user--minus.png" onclick="supprimer_user(\''.$reccord['id'].'\',\''.addslashes($reccord['login']).'\')" style="cursor:pointer;" />
                    </td>
                    <td align="center">
                        &nbsp;<img src="includes/images/lock__pencil.png" onclick="mdp_user(\''.$reccord['id'].'\',\''.addslashes($reccord['login']).'\')" style="cursor:pointer;" />
                    </td>
                    <td align="center">
                        &nbsp;<img src="includes/images/', empty($reccord['email']) ? 'mail--exclamation.png':'mail--pencil.png', '" onclick="mail_user(\''.$reccord['id'].'\',\''.addslashes($reccord['login']).'\',\''.addslashes($reccord['email']).'\')" style="cursor:pointer;" title="'.$reccord['email'].'" />
                    </td>
                </tr>';
                $x++;
            }
        }
        echo '
            </tbody>
        </table>
    </div>
</form>
<input type="hidden" id="selected_user" />';

// DIV FOR CHANGING FUNCTIONS
echo '
<div id="change_user_functions" style="display:none;">'.
$txt['change_user_functions_info'].'
<form name="tmp_functions" action="">
<div id="change_user_functions_list" style="margin-left:15px;"></div>
</form>
</div>';

// DIV FOR CHANGING AUTHORIZED GROUPS
echo '
<div id="change_user_autgroups" style="display:none;">'.
$txt['change_user_autgroups_info'].'
<form name="tmp_autgroups" action="">
<div id="change_user_autgroups_list" style="margin-left:15px;"></div>
</form>
</div>';

// DIV FOR CHANGING FUNCTIONS
echo '
<div id="change_user_forgroups" style="display:none;">'.
$txt['change_user_forgroups_info'].'
<form name="tmp_forgroups" action="">
<div id="change_user_forgroups_list" style="margin-left:15px;"></div>
</form>
</div>';

/* DIV FOR ADDING A USER */
echo '
<div id="add_new_user" style="display:none;">
    <label for="new_login" class="label_cpm">'.$txt['name'].'</label>
	<input type="text" id="new_login" class="input_text text ui-widget-content ui-corner-all" />

    <label for="new_pwd" class="label_cpm">'.$txt['pw'].'&nbsp;<img src="includes/images/refresh.png" onclick="pwGenerate(\'new_pwd\')" style="cursor:pointer;" /></label>
	<input type="text" id="new_pwd" class="input_text text ui-widget-content ui-corner-all" />

   	<label for="new_email" class="label_cpm"">'.$txt['email'].'</label>
	<input type="text" id="new_email" class="input_text text ui-widget-content ui-corner-all" />

	<input type="checkbox" id="new_admin" />
   	<label for="new_admin">'.$txt['is_admin'].'</label>
	<br />
	<input type="checkbox" id="new_manager" />
   	<label for="new_manager">'.$txt['is_manager'].'</label>
	<br />
	<input type="checkbox" id="new_personal_folder" />
   	<label for="new_personal_folder">'.$txt['personal_folder'].'</label>
</div>';

// DIV FOR DELETING A USER
echo '
<div id="delete_user" style="display:none;">
    <div>'.$txt['confirm_del_account'].'</div>
    <div style="font-weight:bold;text-align:center;color:#FF8000;text-align:center;font-size:13pt;" id="delete_user_show_login"></div>
    <input type="hidden" id="delete_user_login" />
    <input type="hidden" id="delete_user_id" />
</div>';

// DIV FOR CHANGING PASWWORD
echo '
<div id="change_user_pw" style="display:none;">
    <div style="text-align:center;padding:2px;display:none;" class="ui-state-error ui-corner-all" id="change_user_pw_error"></div>'.
    $txt['give_new_pw'].'
    <div style="font-weight:bold;text-align:center;color:#FF8000;display:inline;" id="change_user_pw_show_login"></div>
    <div style="margin-top:10px;text-align:center;">
        <input type="text" size="30" id="change_user_pw_newpw" /><br />
        '.$txt['index_change_pw_confirmation'].' : <input type="text" size="30" id="change_user_pw_newpw_confirm" />
    </div>
    <input type="hidden" id="change_user_pw_id" />
</div>';

// DIV FOR CHANGING EMAIL
echo '
<div id="change_user_email" style="display:none;">
    <div style="text-align:center;padding:2px;display:none;" class="ui-state-error ui-corner-all" id="change_user_email_error"></div>'.
    $txt['give_new_email'].'
    <div style="font-weight:bold;text-align:center;color:#FF8000;display:inline;" id="change_user_email_show_login"></div>
    <div style="margin-top:10px;text-align:center;">
        <input type="text" size="50" id="change_user_email_newemail" />
    </div>
    <input type="hidden" id="change_user_email_id" />
</div>';

// DIV FOR HELP
echo '
<div id="help_on_users" style="">
    <div>'.$txt['help_on_users'].'</div>
</div>';

?>