<?php
####################################################################################################
## File : items.php
## Author : Nils Laumaill�
## Description : Items page
##
## DON'T CHANGE !!!
##
####################################################################################################

require_once ("sources/NestedTree.class.php");

//D�finir liste des utilisateurs existants
$liste_utilisateurs = array();
$tmp = "";
$rows = $db->fetch_all_array("SELECT id,login,email FROM ".$pre."users ORDER BY login ASC");
foreach($rows as $record){
    $liste_utilisateurs[$record['login']] = array(
        "id" => $record['id'],
        "login" => $record['login'],
        "email" => $record['email'],
    );
    $tmp .= $record['id'].'.'.$record['login'].";";
}


//Choses cach�es
echo '
<input type="hidden" name="hid_cat" id="hid_cat" />
<input type="hidden" id="complexite_groupe" />
<input type="text" style="display:none;" name="selected_items" id="selected_items" />
<input type="hidden" name="input_liste_utilisateurs" id="input_liste_utilisateurs" value="'.$tmp.'" />
<input type="hidden" id="bloquer_creation_complexite" />
<input type="hidden" id="bloquer_modification_complexite" />
<input type="hidden" id="error_detected" />
<input type="hidden" name="random_id" id="random_id" />
<input type="hidden" id="edit_wysiwyg_displayed" value="" />';

//Afficher mdp suite � recherche
if ( isset($_GET['group']) && isset($_GET['id']) ){
    echo '<input type="hidden" name="recherche_groupe" id="recherche_groupe" value="'.$_GET['group'].'" />';
    echo '<input type="hidden" name="recherche_id" id="recherche_id" value="'.$_GET['id'].'" />';
    echo '<input type="hidden" name="recherche_group_pf" id="recherche_group_pf" value="', in_array($_GET['group'],$_SESSION['personal_visible_groups']) ? '1' : '', '" />';
}elseif ( isset($_GET['group']) && !isset($_GET['id']) ){
    echo '<input type="hidden" name="recherche_groupe" id="recherche_groupe" value="'.$_GET['group'].'" />';
    echo '<input type="hidden" name="recherche_id" id="recherche_id" value="" />';
    echo '<input type="hidden" name="recherche_group_pf" id="recherche_group_pf" value="" />';
}else{
    echo '<input type="hidden" name="recherche_groupe" id="recherche_groupe" value="" />';
    echo '<input type="hidden" name="recherche_id" id="recherche_id" value="" />';
    echo '<input type="hidden" name="recherche_group_pf" id="recherche_group_pf" value="" />';
}


echo '
<div id="div_items">';

    // MAIN ITEMS TREE
    echo '
    <div style="width:300px;border-right:1px solid #FF8000;background:#FF8000;">
        <div style="margin:3px;font-weight:bold;">
            '.$txt['items_browser_title'].'
        </div>
        <div id="sidetreecontrol" style="position:absolute;float:right;width:40px;text-align:right;height:30px;margin-top:-19px;text-decoration:none;margin-left:260px;">
            <a href="?#"><img src="includes/images/chevron-small.png" alt="" /></a>&nbsp;<a href="?#"><img src="includes/images/chevron-small-expand.png" alt="" /></a>
        </div>
    </div>
    <div id="sidebar" class="sidebar" style="border-right:1px solid #FF8000;overflow-y:auto;">';

        $tree = new NestedTree($pre.'nested_tree', 'id', 'parent_id', 'title');
        $tree->rebuild();
        $tst = $tree->getDescendants();

        $tab_items = array();
        $cpt_total = 0;
        $folder_cpt = 1;
        $prev_level = 1;
        $first_group = "";

        echo '
        <ul id="browser" class="filetree" style="margin-top:3px;min-height:200px;">';
        foreach($tst as $t){
            //Be sure that user can only see folders he/she is allowed to
            if ( !in_array($t->id,$_SESSION['forbiden_pfs']) ) {
            	$display_this_node = false;
            	// Check if any allowed folder is part of the descendants of this node
            	$node_descendants = $tree->getDescendants($t->id, true, false, true);
            	foreach ($node_descendants as $node){
            		if (in_array($node, $_SESSION['groupes_visibles'])) {
            			$display_this_node = true;
            			break;
            		}
            	}

				if ($display_this_node == true) {

		            $data = $db->fetch_row("SELECT COUNT(*) FROM ".$pre."items WHERE inactif=0 AND id_tree = ".$t->id);
		            $nb_items = $data[0];

		            //get 1st folder
		            if (empty($first_group)) $first_group = $t->id;

		            //Construire l'arborescence
		            if ( $cpt_total == 0 ) {
		        		// Force the name of the personal folder with the login name
						if ( $t->title ==$_SESSION['user_id'] && $t->nlevel == 1 ) $t->title = $_SESSION['login'];

						echo '
						<li id="li_'.$t->id.'"><span class="folder">&nbsp;</span>
							<div style="display:inline;cursor:pointer;">',
							in_array($t->id,$_SESSION['groupes_visibles']) ?
							'<a class="folder_item" onclick="ListerItems(\''.$t->id.'\');">'.str_replace("&","&amp;",$t->title).'</a> ('.$nb_items.')' :
							'<span class="folder_item">'.str_replace("&","&amp;",$t->title).'</span>',
							'</div>';
						//sauver les items de ce groupe
						//$tab_items[$t->nlevel] = $text_items;
		            }else{
		                //Construire l'arborescence
		                if ( $prev_level < $t->nlevel ){
		                    echo '
							<ul id="folder'.$folder_cpt.'">
		                    <li id="li_'.$t->id.'">
								<span class="folder">&nbsp;</span>
			                    <div style="display:inline;cursor:pointer;">',
			                    in_array($t->id,$_SESSION['groupes_visibles']) ?
			                    '<a class="folder_item" onclick="ListerItems(\''.$t->id.'\');">'.str_replace("&","&amp;",$t->title).'</a> ('.$nb_items.')' :
			                    '<span class="folder_item">'.str_replace("&","&amp;",$t->title).'</span>',
			                    '</div>';

		                    //sauver les items de ce groupe
		                    //$tab_items[$t->nlevel] = $text_items;

		                    $folder_cpt++;
		                }else if ( $prev_level == $t->nlevel ){
		                    //ecrire la structure
		                    echo '
		                    </li>
		                    <li id="li_'.$t->id.'"><span class="folder">&nbsp;</span>
		                    <div style="display:inline;cursor:pointer;">',
		                    in_array($t->id,$_SESSION['groupes_visibles']) ?
		                    '<a class="folder_item" onclick="ListerItems(\''.$t->id.'\');">'.str_replace("&","&amp;",$t->title).'</a> ('.$nb_items.')' :
		                    '<span class="folder_item">'.str_replace("&","&amp;",$t->title).'</span>',
		                    '</div>';
		                }else{
		                    //Afficher les items de la derni�eres cat s'ils existent
		                    for($x=$t->nlevel;$x<$prev_level;$x++){
		                        echo "
		                        </li>
		                    </ul>";
		                    }
		                    echo '</li>
		                    <li id="li_'.$t->id.'"><span class="folder">&nbsp;</span>
		                    <div style="display:inline;cursor:pointer;">',
		                    in_array($t->id,$_SESSION['groupes_visibles']) ?
		                    '<a class="folder_item" onclick="ListerItems(\''.$t->id.'\');">'.str_replace("&","&amp;",$t->title).'</a> ('.$nb_items.')' :
		                    '<span class="folder_item">'.str_replace("&","&amp;",$t->title).'</span>',
		                    '</div>';
		                    $folder_cpt++;
		                }
		            }
	            	$prev_level = $t->nlevel;

		            $cpt_total++;
				}
	        }
        }

        //clore toutes les balises de l'arbo
        for($x=1;$x<$prev_level;$x++)
                        echo "</li>
                        </ul>";
        echo '
			</li>
		</ul>
    </div>';

    ##
    echo '
    <div id="content" style="float:left;width:660px;margin-left:10px;margin-top:-20px;">
        <div id="content_1" style="border-left:1px solid #FF8000;">
            <div id="arborescence" style="font-size: 15px; font-family:arial; color:#242D35; margin-left:10px;">
            </div>
            <div id="liste_des_items" style="display:none;float:left;width:100%;padding-left:0px;overflow:auto ;">
            </div>
        </div>';

    ## ITEM DETAIL
    echo '
        <div id="item_details_ok" style="width:660px;height:250px;border:1px solid #FF8000; background:url(includes/images/stripe_orange.png) repeat;" class="">';

        echo '
            <div style="border-right:1px solid #FF8000;background:#FF8000;width:654px;font-weight:bold;padding-left:5px;">
                <div style="width:200px;">'.$txt['description'].'</div>
            </div>

            <input type="hidden" id="id_categorie" value="" />
            <input type="hidden" id="id_item" value="" />
            <div style="height:230px;overflow-y:auto;">

                <div id="item_details_expired" style="display:none;background-color:white; margin:5px;">
                    <div class="ui-state-error ui-corner-all" style="padding:2px;">
                        <img src="includes/images/error.png" alt="" />&nbsp;<b>'.$txt['pw_is_expired_-_update_it'].'</b>
                    </div>
                </div>
                <table>';
                //Line fot LABEL
                echo '
                <tr>
                    <td valign="top" class="td_title"><span class="ui-icon ui-icon-carat-1-e" style="float: left; margin-right: .3em;">&nbsp;</span>'.$txt['label'].' :</td>
                    <td>
                        <input type="hidden" id="hid_label" value="', isset($data_item) ? $data_item['label'] : '', '" />
                        <div id="id_label" style="display:inline;"></div>
                    </td>
                </tr>';
                //Line fot DESCRIPTION
                echo '
                <tr>
                    <td valign="top" class="td_title"><span class="ui-icon ui-icon-carat-1-e" style="float: left; margin-right: .3em;">&nbsp;</span>'.$txt['description'].' :</td>
                    <td>
                        <div id="id_desc" style="font-style:italic;display:inline;"></div><input type="hidden" id="hid_desc" value="', isset($data_item) ? $data_item['description'] : '', '" />
                    </td>
                </tr>';
                //Line fot PW
                echo '
                <tr>
                    <td valign="top" class="td_title"><span class="ui-icon ui-icon-carat-1-e" style="float: left; margin-right: .3em;">&nbsp;</span>'.$txt['pw'].' :</td>
                    <td>
                        <div id="id_pw" style="float:left;"></div>
                        <input type="hidden" id="hid_pw" value="" />
                    </td>
                </tr>';
                //Line fot LOGIN
                echo '
                <tr>
                    <td valign="top" class="td_title"><span class="ui-icon ui-icon-carat-1-e" style="float: left; margin-right: .3em;">&nbsp;</span>'.$txt['index_login'].' :</td>
                    <td>
                        <div id="id_login" style="float:left;"></div>
                        <input type="hidden" id="hid_login" value="" />
                    </td>
                </tr>';
                //Line fot URL
                echo '
                <tr>
                    <td valign="top" class="td_title"><span class="ui-icon ui-icon-carat-1-e" style="float: left; margin-right: .3em;">&nbsp;</span>'.$txt['url'].' :</td>
                    <td>
                        <div id="id_url" style="display:inline;"></div><input type="hidden" id="hid_url" value="" />
                    </td>
                </tr>';
                //Line fot FILES
                echo '
                <tr>
                    <td valign="top" class="td_title"><span class="ui-icon ui-icon-carat-1-e" style="float: left; margin-right: .3em;">&nbsp;</span>'.$txt['files_&_images'].' :</td>
                    <td>
                        <div id="id_files" style="display:inline;font-size:11px;"></div><input type="hidden" id="hid_files" />
                        <div id="dialog_files" style="display: none;">
                          <img id="image_files" src="includes/images" />
                        </div>
                    </td>
                </tr>';
                //Line fot RESTRICTED TO
                echo '
                <tr>
                    <td valign="top" class="td_title"><span class="ui-icon ui-icon-carat-1-e" style="float: left; margin-right: .3em;">&nbsp;</span>'.$txt['restricted_to'].' :</td>
                    <td>
                        <div id="id_restricted_to" style="display:inline;"></div><input type="hidden" id="hid_restricted_to" />
                    </td>
                </tr>';
                //Line fot TAGS
                echo '
                <tr>
                    <td valign="top" class="td_title"><span class="ui-icon ui-icon-carat-1-e" style="float: left; margin-right: .3em;">&nbsp;</span>'.$txt['tags'].' :</td>
                    <td>
                        <div id="id_tags" style="display:inline;"></div><input type="hidden" id="hid_tags" />
                    </td>
                </tr>';
                //Line fot HISTORY
                echo '
                <tr>
                    <td valign="top" class="td_title"><span class="ui-icon ui-icon-carat-1-e" style="float: left; margin-right: .3em;">&nbsp;</span>'.$txt['history'].' :</td>
                    <td>
                        <div onclick="ouvrir_div(\'id_info\')" style="cursor:pointer">
                            <img src="includes/images/layout_split_vertical.png" />
                        </div>
                        <div id="id_info" style="font-size:8pt;margin-top:4px;display:none;"></div>
                    </td>
                </tr>
                </table>
            </div>
        </div>';

        ## NOT ALLOWED
        echo '
        <div id="item_details_nok" style="display:none;float:left;background-color:white; margin:30px;">
            <div class="ui-state-highlight ui-corner-all" style="padding:10px;">
                <img src="includes/images/lock.png" alt="" />&nbsp;<b>'.$txt['not_allowed_to_see_pw'].'</b>
            </div>
        </div>';
    echo '
    </div>
</div>';

//Formulaire NOUVEAU
echo '
<div id="div_formulaire_saisi" style="display:none;">
    <form method="post" name="new_item" action="">
        <div id="afficher_visibilite" style="text-align:center;margin-bottom:6px;height:20px;"></div>
        <div id="display_title" style="text-align:center;margin-bottom:6px;font-size:17px;font-weight:bold;height:25px;"></div>
        <div id="new_show_error" style="text-align:center;margin:2px;display:none;" class="ui-state-error ui-corner-all"></div>

        <div id="item_tabs">
        <ul>
            <li><a href="#tabs-01">'.$txt['definition'].'</a></li>
            <li><a href="#tabs-02">'.$txt['index_password'].' &amp; '.$txt['visibility'].'</a></li>
            <li><a href="#tabs-03">'.$txt['files_&_images'].'</a></li>
        </ul>
        <div id="tabs-01">';
            //Line for LABEL
            echo '
            <label for="" class="label_cpm">'.$txt['label'].' : </label>
            <input type="text" name="label" id="label" onchange="javascript:$(\'#display_title\').html(this.value)" class="input_text text ui-widget-content ui-corner-all" />';
            //Line for DESCRIPTION
            echo '
            <label for="" class="label_cpm">'.$txt['description'].' : </label>
            <span id="desc_span">
                <textarea rows="5" name="desc" id="desc" class="input_text text ui-widget-content ui-corner-all"></textarea>
            </span>
            <br />';
            //Line for FOLDERS
            echo '
            <label for="" class="label_cpm">'.$txt['group'].' : </label>
            <select name="categorie" id="categorie" onChange="RecupComplexite(this.value,0)" class="input_text text ui-widget-content ui-corner-all">
                <option value="na">---'.$txt['select'].'---</option>';
                foreach($tst as $t){
                    if ( in_array($t->id,$_SESSION['groupes_visibles']) ){
                        $ident="";
                        for($x=1;$x<$t->nlevel;$x++) $ident .= "&nbsp;&nbsp;";
                        if ( $prev_level < $t->nlevel ){
                            echo '<option value="'.$t->id.'">'.$ident.str_replace("&","&amp;",$t->title).'</option>';
                        }else if ( $prev_level == $t->nlevel ){
                           echo '<option value="'.$t->id.'">'.$ident.str_replace("&","&amp;",$t->title).'</option>';
                        }else{
                            echo '<option value="'.$t->id.'">'.$ident.str_replace("&","&amp;",$t->title).'</option>';
                        }
                        $prev_level = $t->nlevel;
                    }
                }
            echo '
            </select>';
            //Line for LOGIN
            echo '
            <label for="" class="label_cpm">'.$txt['login'].' : </label>
            <input type="text" name="item_login" id="item_login" class="input_text text ui-widget-content ui-corner-all" />';
            //Line for URL
            echo '
            <label for="" class="label_cpm">'.$txt['url'].' : </label>
            <input type="text" name="url" id="url" class="input_text text ui-widget-content ui-corner-all" />
        </div>';
        //Tabs Items N�2
        echo '
        <div id="tabs-02">';
            //Line for folder complexity
            echo'
			<div style="margin-bottom:10px;">
	            <label for="" class="form_label_120">'.$txt['complex_asked'].'</label>
	            <span id="complex_attendue" style="color:#D04806;"></span>
            </div>';
            //Line for SALT KEY
            echo '
            <div style="display:none;margin-top:15px;" id="new_item_salt_key">
                <label class="label_cpm">'.$txt['personal_salt_key'].'&nbsp;<img src="includes/images/question-small-white.png" title="<span style=\'font-size:9px;\'>'.$txt['personal_salt_key_info'].'</span>" alt="" /></label>
                <input type="text" name="personal_salt_key" id="personal_salt_key" value="" class="input_text text ui-widget-content ui-corner-all" />
            </div>';
            //Line for PW
            echo '
            <label class="label_cpm">'.$txt['used_pw'].' :
				<span id="pw_wait" style="display:none;margin-left:10px;"><img src="includes/images/ajax-loader.gif" /></span>
			</label>
            <div style="width:250px; margin:0px auto 0px auto;">
                <div id="mypassword_text" style="font-size: 10px;;"></div><input type="hidden" id="mypassword_complex" />
                <div id="mypassword_bar" style="font-size: 1px; height: 2px; width: 0px; border: 1px solid white;"></div>
            </div>
            <input type="text" id="pw1" onkeyup="runPassword(this.value, \'mypassword\');" onchange="runPassword(this.value, \'mypassword\');" class="input_text text ui-widget-content ui-corner-all" />

            <div style="font-size:9px; text-align:center; width:100%;">
	            <span id="custom_pw">
	                <input type="checkbox" id="pw_numerics" /><label for="pw_numerics">123</label>
	                <input type="checkbox" id="pw_maj" /><label for="pw_maj">ABC</label>
	                <input type="checkbox" id="pw_symbols" /><label for="pw_symbols">@#&amp;</label>
	                <input type="checkbox" id="pw_secure" /><label for="pw_secure">'.$txt['secure'].'</label>
	            	&nbsp;<label for="pw_size">'.$txt['size'].' : </label>
						<img src="includes/images/minus.gif" style="cursor:pointer;" onclick="javascript:$(\'#pw_size\').text(parseInt($(\'#pw_size\').text())-1);" />
							<span id="pw_size" style="font-size:11px; margin:0px 2px 0px 2px; width:50px;">8</span>
						<img src="includes/images/plus.gif" style="cursor:pointer;" onclick="javascript:$(\'#pw_size\').text(parseInt($(\'#pw_size\').text())+1);"  />
	            </span>
				<a href="#" title="'.$txt['pw_generate'].'" onclick="pwGenerate(\'\')" class="cpm_button">
					<img  src="includes/images/arrow_refresh.png"  />
				</a>
				<a href="#" title="'.$txt['copy'].'" onclick="pwCopy(\'\')" class="cpm_button">
					<img  src="includes/images/paste_plain.png"  />
				</a>
			</div>';
            //Line for PW CONFIRMATION
            echo '
            <label for="" class="label_cpm">'.$txt['index_change_pw_confirmation'].' :</label>
            <input type="text" name="pw2" id="pw2" class="input_text text ui-widget-content ui-corner-all" />';
            //Line for RESTRICTED TO
            echo '
            <label for="" class="label_cpm">'.$txt['restricted_to'].' : </label>
            <select name="restricted_to_list" id="restricted_to_list" size="3" multiple="multiple" class="input_text text ui-widget-content ui-corner-all">
            	<option value="">-- '.$txt['all'].' --</option>';
                foreach($liste_utilisateurs as $user){
                    echo '<option value="'.$user['id'].'">'.$user['login'].'</option>';
                }
            echo '
            </select>
            <input type="hidden" name="restricted_to" id="restricted_to" />';
            //Line for TAGS
            echo '
            <label for="" class="label_cpm">'.$txt['tags'].' : </label>
            <input type="text" name="item_tags" id="item_tags" class="input_text text ui-widget-content ui-corner-all" />';
            //Line for EMAIL
            echo '
            <input type="checkbox" name="annonce" id="annonce" onChange="AfficherCacher(\'annonce_liste\')" />
            <label for="annonce">'.$txt['email_announce'].'</label>
            <div style="display:none; border:1px solid #808080; margin-left:30px; margin-top:3px;padding:5px;" id="annonce_liste">
                <h3>'.$txt['email_select'].'</h3>
                <select id="annonce_liste_destinataires" multiple="multiple" size="10">';
                foreach($liste_utilisateurs as $user){
                    echo '<option value="'.$user['email'].'">'.$user['login'].'</option>';
                }
                echo '
                </select>
            </div>
        </div>';
        //Tabs EDIT N�3
        echo '
        <div id="tabs-03">
            <div id="item_file_queue"></div>
            <input type="file" name="item_files_upload" id="item_files_upload" /><br />
            <a href="#" onclick="upload_attached_files()">'.$txt['start_upload'].'</a>
        </div>
    </div>
    </form>
</div>';

//Formulaire EDITION ITEM
echo '
<div id="div_formulaire_edition_item" style="display:none;">
    <form method="post" name="form_edit" action="">
    <div id="edit_afficher_visibilite" style="text-align:center;margin-bottom:6px;height:25px;"></div>
    <div id="edit_display_title" style="text-align:center;margin-bottom:6px;font-size:17px;font-weight:bold;height:25px;"></div>
    <div id="edit_show_error" style="text-align:center;margin:2px;display:none;" class="ui-state-error ui-corner-all"></div>';

    //Prepare TABS
    echo '
    <div id="item_edit_tabs">
        <ul>
            <li><a href="#tabs-1">'.$txt['definition'].'</a></li>
            <li><a href="#tabs-2">'.$txt['index_password'].' &amp; '.$txt['visibility'].'</a></li>
            <li><a href="#tabs-3">'.$txt['files_&_images'].'</a></li>
        </ul>
        <div id="tabs-1">
            <label for="" class="cpm_label">'.$txt['label'].' : </label>
            <input type="text" size="60" id="edit_label" onchange="javascript:$(\'#edit_display_title\').html(this.value)" class="input_text text ui-widget-content ui-corner-all" />

            <label for="" class="cpm_label">'.$txt['description'].'&nbsp;<img src="includes/images/broom.png" style="cursor:pointer;" onclick="clear_html_tags()" /> </label>
            <span id="edit_desc_span">
                <textarea rows="5" id="edit_desc" name="edit_desc" class="input_text text ui-widget-content ui-corner-all"></textarea>
            </span>';
            //Line for FOLDER
            echo '
            <label for="" class="cpm_label">'.$txt['group'].' : </label>
            <select id="edit_categorie" onChange="RecupComplexite(this.value,1)" class="input_text text ui-widget-content ui-corner-all">';
                foreach($tst as $t){
                    if ( in_array($t->id,$_SESSION['groupes_visibles']) ){
                        $ident="";
                        for($x=1;$x<$t->nlevel;$x++) $ident .= "&nbsp;&nbsp;";
                        if ( $prev_level < $t->nlevel ){
                            echo '<option value="'.$t->id.'">'.$ident.str_replace("&","&amp;",$t->title).'</option>';
                        }else if ( $prev_level == $t->nlevel ){
                           echo '<option value="'.$t->id.'">'.$ident.str_replace("&","&amp;",$t->title).'</option>';
                        }else{
                            echo '<option value="'.$t->id.'">'.$ident.str_replace("&","&amp;",$t->title).'</option>';
                        }
                        $prev_level = $t->nlevel;
                    }
                }
            echo '
            </select>';
            //Line for LOGIN
            echo '
            <label for="" class="cpm_label">'.$txt['login'].' : </label>
            <input type="text" id="edit_item_login" class="input_text text ui-widget-content ui-corner-all" />

            <label for="" class="cpm_label">'.$txt['url'].' : </label>
            <input type="text" id="edit_url" class="input_text text ui-widget-content ui-corner-all" />
        </div>';

        //TABS edit n�2
        echo '
        <div id="tabs-2">';
            //Line for folder complexity
            echo'
			<div style="margin-bottom:10px;">
	            <label for="" class="cpm_label">'.$txt['complex_asked'].'</label>
	            <span id="edit_complex_attendue" style="color:#D04806;"></span>
            </div>';
            echo '
            <div style="display:none;" id="edit_item_salt_key">
                <label for="" class="cpm_label">'.$txt['personal_salt_key'].'&nbsp;<img src="includes/images/question-small-white.png" title="<span style=\'font-size:9px;\'>'.$txt['personal_salt_key_info'].'</span>" alt="" /></label>
                <input type="text" size="20" name="edit_personal_salt_key" id="edit_personal_salt_key" value="" class="input_text text ui-widget-content ui-corner-all" />
            </div>

            <label for="" class="label_cpm">'.$txt['used_pw'].' :
				<span id="edit_pw_wait" style="display:none;margin-left:10px;"><img src="includes/images/ajax-loader.gif" /></span>
			</label>
            <div style="width:250px; margin:0px auto 0px auto;">
                <div id="edit_mypassword_text" style="font-size: 10px;;"></div><input type="hidden" id="edit_mypassword_complex" />
                <div id="edit_mypassword_bar" style="font-size: 1px; height: 2px; width: 0px; border: 1px solid white;"></div>
            </div>
            <input type="text" id="edit_pw1" onkeyup="runPassword(this.value, \'edit_mypassword\');" class="input_text text ui-widget-content ui-corner-all" />
            <script type="text/javascript">
            	runPassword(document.getElementById(\'edit_pw1\').value, \'edit_mypassword\');
            </script>

            <div style="font-size:9px; text-align:center; width:100%;">
	            <span id="edit_custom_pw">
	                <input type="checkbox" id="edit_pw_numerics" /><label for="edit_pw_numerics">123</label>
	                <input type="checkbox" id="edit_pw_maj" /><label for="edit_pw_maj">ABC</label>
	                <input type="checkbox" id="edit_pw_symbols" /><label for="edit_pw_symbols">@#&amp;</label>
	                <input type="checkbox" id="edit_pw_secure" /><label for="edit_pw_secure">'.$txt['secure'].'</label>
	            	&nbsp;<label for="edit_pw_size">'.$txt['size'].' : </label>
						<img src="includes/images/minus.gif" style="cursor:pointer;" onclick="javascript:$(\'#edit_pw_size\').text(parseInt($(\'#edit_pw_size\').text())-1);" />
						<span id="edit_pw_size" style="font-size:11px; margin:0px 2px 0px 2px; width:50px;">8</span>
						<img src="includes/images/plus.gif" style="cursor:pointer;" onclick="javascript:$(\'#edit_pw_size\').text(parseInt($(\'#edit_pw_size\').text())+1);"  />
	            </span>
				<a href="#" title="'.$txt['pw_generate'].'" onclick="pwGenerate(\'edit\')" class="cpm_button">
					<img  src="includes/images/arrow_refresh.png"  />
				</a>
				<a href="#" title="'.$txt['copy'].'" onclick="pwCopy(\'edit\')" class="cpm_button">
					<img  src="includes/images/paste_plain.png"  />
				</a>
			</div>

            <label for="" class="cpm_label">'.$txt['confirm'].' : </label>
            <input type="text" size="30" id="edit_pw2" class="input_text text ui-widget-content ui-corner-all" />

            <label for="" class="cpm_label">'.$txt['restricted_to'].' : </label>
            <select name="edit_restricted_to_list" id="edit_restricted_to_list" size="3" multiple="multiple" class="input_text text ui-widget-content ui-corner-all">
            	<option value="">-- '.$txt['all'].' --</option>
            </select>
            <input type="hidden" size="50" name="edit_restricted_to" id="edit_restricted_to" />

            <label for="" class="cpm_label">'.$txt['tags'].' : </label>
            <input type="text" size="50" name="edit_tags" id="edit_tags" class="input_text text ui-widget-content ui-corner-all" />

            <input type="checkbox" name="edit_annonce" id="edit_annonce" onChange="AfficherCacher(\'edit_annonce_liste\')" />
            <label for="edit_annonce">'.$txt['email_announce'].'</label>
            <div style="display:none; border:1px solid #808080; margin-left:30px; margin-top:3px;padding:5px;" id="edit_annonce_liste">
                <h3>'.$txt['email_select'].'</h3>
                <select id="edit_annonce_liste_destinataires" multiple="multiple" size="10">';
                foreach($liste_utilisateurs as $user){
                    echo '<option value="'.$user['email'].'">'.$user['login'].'</option>';
                }
                echo '
                </select>
            </div>
        </div>';
        //Tabs EDIT N�3
        echo '
        <div id="tabs-3">
            <div style="font-weight:bold;font-size:12px;">
                <span class="ui-icon ui-icon-folder-open" style="float: left; margin-right: .3em;">&nbsp;</span>
                '.$txt['uploaded_files'].'
            </div>
            <div id="item_edit_list_files" style="margin-left:25px;"></div>
            <div style="margin-top:10px;font-weight:bold;font-size:12px;">
                <span class="ui-icon ui-icon-folder-open" style="float: left; margin-right: .3em;">&nbsp;</span>
                '.$txt['upload_files'].'
            </div>
            <div id="item_edit_file_queue"></div>
            <input type="file" name="item_edit_files_upload" id="item_edit_files_upload" /><br />
            <a href="#" onclick="upload_attached_files_edit_mode()">'.$txt['start_upload'].'</a>

        </div>
    </div>';
        echo '
    </form>
</div>';

//Formulaire AJOUT REPERTORIE
echo '
<div id="div_ajout_rep" style="display:none;">
    <div id="new_rep_show_error" style="text-align:center;margin:2px;display:none;" class="ui-state-error ui-corner-all"></div>
    <table>
        <tr>
            <td>'.$txt['label'].' : </td>
            <td><input type="text" size="20" id="new_rep_titre" /></td>
        </tr>
        <tr>
            <td>'.$txt['sub_group_of'].' : </td>
            <td><select id="new_rep_groupe">';
                echo '<option value="0">---</option>';
                foreach($tst as $t){
                    if ( in_array($t->id,$_SESSION['groupes_visibles']) ){
                        $ident="";
                        for($x=1;$x<$t->nlevel;$x++) $ident .= "&nbsp;&nbsp;";
                        if ( $prev_level < $t->nlevel ){
                            echo '<option value="'.$t->id.'">'.$ident.str_replace("&","&amp;",$t->title).'</option>';
                        }else if ( $prev_level == $t->nlevel ){
                           echo '<option value="'.$t->id.'">'.$ident.str_replace("&","&amp;",$t->title).'</option>';
                        }else{
                            echo '<option value="'.$t->id.'">'.$ident.str_replace("&","&amp;",$t->title).'</option>';
                        }
                        $prev_level = $t->nlevel;
                    }
                }
            echo '
            </select></td>
        </tr>
        <tr>
            <td>'.$txt['complex_asked'].' : </td>
            <td><select id="new_rep_complexite">
                <option value="">---</option>';
                foreach($mdp_complexite as $complex)
                    echo '<option value="'.$complex[0].'">'.$complex[1].'</option>';
            echo '
            </select>
        </tr>
    </table>
</div>';

//Formulaire EDITER REPERTORIE
echo '
<div id="div_editer_rep" style="display:none;">
    <div id="edit_rep_show_error" style="text-align:center;margin:2px;display:none;" class="ui-state-error ui-corner-all"></div>
    <table>
        <tr>
            <td>'.$txt['new_label'].' : </td>
            <td><input type="text" size="20" id="edit_rep_titre" /></td>
        </tr>
        <tr>
            <td>'.$txt['group_select'].' : </td>
            <td><select id="edit_rep_groupe">';
                echo '<option value="0">-choisir-</option>';
                foreach($tst as $t){
                    if ( in_array($t->id,$_SESSION['groupes_visibles']) ){
                        $ident="";
                        for($x=1;$x<$t->nlevel;$x++) $ident .= "&nbsp;&nbsp;";
                        if ( $prev_level < $t->nlevel ){
                            echo '<option value="'.$t->id.'">'.$ident.str_replace("&","&amp;",$t->title).'</option>';
                        }else if ( $prev_level == $t->nlevel ){
                           echo '<option value="'.$t->id.'">'.$ident.str_replace("&","&amp;",$t->title).'</option>';
                        }else{
                            echo '<option value="'.$t->id.'">'.$ident.str_replace("&","&amp;",$t->title).'</option>';
                        }
                        $prev_level = $t->nlevel;
                    }
                }
            echo '
            </select></td>
        </tr>
        <tr>
            <td>'.$txt['complex_asked'].' : </td>
            <td><select id="edit_rep_complexite">
                <option value="">---</option>';
                foreach($mdp_complexite as $complex)
                    echo '<option value="'.$complex[0].'">'.$complex[1].'</option>';
            echo '
            </select>
        </tr>
    </table>
</div>';

//Formulaire SUPPRIMER REPERTORIE
echo '
<div id="div_supprimer_rep" style="display:none;">
    <table>
        <tr>
            <td>'.$txt['group_select'].' : </td>
            <td><select id="delete_rep_groupe">';
                echo '<option value="0">-choisir-</option>';
                foreach($tst as $t){
                    if ( in_array($t->id,$_SESSION['groupes_visibles']) ){
                        $ident="";
                        for($x=1;$x<$t->nlevel;$x++) $ident .= "&nbsp;&nbsp;";
                        if ( $prev_level < $t->nlevel ){
                            echo '<option value="'.$t->id.'">'.$ident.str_replace("&","&amp;",$t->title).'</option>';
                        }else if ( $prev_level == $t->nlevel ){
                           echo '<option value="'.$t->id.'">'.$ident.str_replace("&","&amp;",$t->title).'</option>';
                        }else{
                            echo '<option value="'.$t->id.'">'.$ident.str_replace("&","&amp;",$t->title).'</option>';
                        }
                        $prev_level = $t->nlevel;
                    }
                }
            echo '
            </select></td>
        </tr>
    </table>
</div>';

//SUPPRIMER UN ELEMENT
echo '
<div id="div_del_item" style="display:none;">
    <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;">&nbsp;</span>'.$txt['confirm_deletion'].'</p>
</div>';

//DIALOG INFORM USER THAT LINK IS COPIED
echo '
<div id="div_item_copied" style="display:none;">
    <p>
        <span class="ui-icon ui-icon-info" style="float:left; margin:0 7px 20px 0;">&nbsp;</span>'.$txt['link_is_copied'].'
    </p>
    <div id="div_display_link"></div>
</div>';


require_once("items.load.php");

//CHECK IF CACHE TABLE EXISTS
//UpdateCacheTable("reload");
?>