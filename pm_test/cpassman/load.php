<?php
####################################################################################################
## File : load.php
## Author : Nils Laumaillé
## Description : Loads things depending on the pages. It is called by index.php page.
##
## DON'T CHANGE !!!
##
####################################################################################################

//Common elements
$htmlHeaders = '
        <link rel="stylesheet" href="includes/css/passman.css" type="text/css" />
        <script type="text/javascript" src="includes/js/functions.js"></script>

        <script type="text/javascript" src="includes/jquery-ui/js/jquery-'.$k['jquery-version'].'.min.js"></script>
        <script type="text/javascript" src="includes/jquery-ui/js/jquery-ui-'.$k['jquery-ui-version'].'.custom.min.js"></script>
        <link rel="stylesheet" href="includes/jquery-ui/css/'.$k['jquery-ui-theme'].'/jquery-ui-'.$k['jquery-ui-version'].'.custom.css" type="text/css" />

        <script language="JavaScript" type="text/javascript" src="includes/js/jquery.tooltip.js"></script>
        <link rel="stylesheet" href="includes/css/jquery.tooltip.css" type="text/css" />

        <script language="JavaScript" type="text/javascript" src="includes/js/pwd_strength.js"></script>';




//For ITEMS page, load specific CSS files for treeview
if ( isset($_GET['page']) && $_GET['page'] == "items")
    $htmlHeaders .= '
        <link rel="stylesheet" type="text/css" href="includes/css/jquery.treeview.css" />
        <link rel="stylesheet" type="text/css" href="includes/css/items.css" />

        <script type="text/javascript" src="includes/js/jquery.cookie.pack.js"></script>
        <script type="text/javascript" src="includes/js/jquery.treeview.pack.js"></script>

        <script type="text/javascript" src="includes/js/jquery.search.js"></script>
        <script type="text/javascript" src="includes/libraries/zeroclipboard/ZeroClipboard.js"></script>

        <link rel="stylesheet" type="text/css" href="includes/css/jquery.autocomplete.css" />
        <script type="text/javascript" src="includes/js/jquery.bgiframe.min.js"></script>
        <script type="text/javascript" src="includes/js/jquery.autocomplete.pack.js"></script>

        <link rel="stylesheet" type="text/css" href="includes/libraries/uploadify/uploadify.css" />
        <script type="text/javascript" src="includes/libraries/uploadify/jquery.uploadify.v2.1.0.min.js"></script>
        <script type="text/javascript" src="includes/libraries/uploadify/swfobject.js"></script>

        <script type="text/javascript" src="includes/js/jquery.autoResizable.min.js"></script>

        <link rel="stylesheet" type="text/css" href="includes/libraries/jwysiwyg/jquery.wysiwyg.css" />
        <link rel="stylesheet" type="text/css" href="includes/libraries/jwysiwyg/jquery.wysiwyg.modal.css" />
        <script type="text/javascript" src="includes/libraries/jwysiwyg/jquery.wysiwyg.min.js"></script>';

else
if ( isset($_GET['page']) && $_GET['page'] == "manage_settings")
    $htmlHeaders .= '
        <link rel="stylesheet" type="text/css" href="includes/libraries/uploadify/uploadify.css" />
        <script type="text/javascript" src="includes/libraries/uploadify/jquery.uploadify.v2.1.0.min.js"></script>
        <script type="text/javascript" src="includes/libraries/uploadify/swfobject.js"></script>';

else
if ( isset($_GET['page']) && ( $_GET['page'] == "manage_users" ||$_GET['page'] == "manage_folders") )
    $htmlHeaders .= '
        <script src="includes/js/jquery.jeditable.js" type="text/javascript"></script>';

else
if ( isset($_GET['page']) && $_GET['page'] == "find")
    $htmlHeaders .= '
        <link rel="stylesheet" type="text/css" href="includes/libraries/datatable/jquery.dataTables.css" />
        <link rel="stylesheet" type="text/css" href="includes/libraries/datatable/jquery.dataTablesUI.css" />
        <script type="text/javascript" src="includes/libraries/datatable/jquery.dataTables.min.js"></script>';

else
if ( !isset($_GET['page']) )
    $htmlHeaders .= '
        <link rel="stylesheet" type="text/css" href="includes/libraries/uploadify/uploadify.css" />
        <script type="text/javascript" src="includes/libraries/uploadify/jquery.uploadify.v2.1.0.min.js"></script>
        <script type="text/javascript" src="includes/libraries/uploadify/swfobject.js"></script>';


//Get Favicon
$htmlHeaders .= isset($_SESSION['settings']['favicon']) ? '
        <link rel="icon" href="'. $_SESSION['settings']['favicon'] . '" type="image/vnd.microsoft.ico" />' : '';

$htmlHeaders .= '
<script type="text/javascript">
<!-- // --><![CDATA[
    //deconnexion
    function MenuAction(val){
        if ( val == "deconnexion" ) {
            document.getElementById("menu_action").value = val;
            document.main_form.submit();
        }
        else {
            if ( val == "") document.location.href="index.php";
            else document.location.href="index.php?page="+val;
        }
    }

    //Identifier l"utilisateur
    function identifyUser(redirect){
        if ( redirect == undefined ) redirect = ""; //Check if redirection
        if ( document.getElementById("login").value != "" && document.getElementById("pw").value != "" ){
            document.getElementById("erreur_connexion").innerHTML = "";
            document.getElementById("ajax_loader_connexion").style.display = "";
            var data = "type=identify_user"+
                        "&login="+escape(document.getElementById("login").value)+
                        "&pw="+escape(document.getElementById("pw").value)+
                        "&duree_session="+document.getElementById("duree_session").value+
                        "&hauteur_ecran="+window.innerHeight;
            httpRequest("sources/main.queries.php",data,redirect);
        }else{
            alert("'.$txt['error_no_password'].'");
        }
    }

    function ouvrir_div(div){
        $("#"+div).slideToggle("slow");
    }

    function OpenDialogBox(id){
        $("#"+id).dialog("open");
    }

    $(function() {
        //TOOLTIPS
        $("#main *, #footer *, #icon_last_items *, #top *, button, .tip").tooltip({
            delay: 0,
            showURL: false
        });

        //Display Tabs
        $("#item_edit_tabs, #item_tabs").tabs();

        //BUTTON
        $("#but_identify_user").hover(
            function(){
                $(this).addClass("ui-state-hover");
            },
            function(){
                $(this).removeClass("ui-state-hover");
            }
        ).mousedown(function(){
            $(this).addClass("ui-state-active");
        })
        .mouseup(function(){
                $(this).removeClass("ui-state-active");
        });

        //END SESSION DIALOG BOX
        $("#div_fin_session").dialog({
            bgiframe: true,
            modal: true,
            autoOpen: false,
            width: 400,
            height: 150,
            title: "'.$txt['index_alarm'].'",
            buttons: {
                "'.$txt['index_add_one_hour'].'": function() {
                    AugmenterSession();
                    document.getElementById("div_fin_session").style.display="none";
                    document.getElementById("countdown").style.color="black";
                    $(this).dialog("close");
                }
            }
        });

        //WARNING FOR QUERY ERROR
        $("#div_mysql_error").dialog({
            bgiframe: true,
            modal: true,
            autoOpen: false,
            width: 700,
            height: 150,
            title: "'.$txt['error_mysql'].'",
            buttons: {
                "'.$txt['ok'].'": function() {
                    $(this).dialog("close");
                }
            }
        });

        //PREPARE MAIN MENU
        $("#main_menu button, #personal_menu_actions button").button();

        //PREPARE LANGUGAGE DROPDOWN
            $(".dropdown dt").click(function() {
                $(".dropdown dd ul").toggle();
            });

            $(".dropdown dd ul li a").click(function() {
                var text = $(this).html();
                $(".dropdown dt a span").html(text);
                $(".dropdown dd ul").hide();
                $("#result").html("Selected value is: " + getSelectedValue("sample"));
            });

            function getSelectedValue(id) {
                return $("#" + id).find("dt a span.value").html();
            }

            $(document).bind("click", function(e) {
                var $clicked = $(e.target);
                if (! $clicked.parents().hasClass("dropdown"))
                    $(".dropdown dd ul").hide();
            });
        //END
    });';

if ( !isset($_GET['page']) ){
    $htmlHeaders .= '
    $(function() {
        //build nice buttonset
        $("#radio_import_type").buttonset();

        //Clear text when clicking on buttonset
        $(".import_radio").click(function() {
            $("#import_status").html("");
        });

        // DIALOG BOX FOR CHANGING PASSWORD
        $("#div_changer_mdp").dialog({
            bgiframe: true,
            modal: true,
            autoOpen: false,
            width: 300,
            height: 190,
            title: "'.$txt['index_change_pw'].'",
            buttons: {
                "'.$txt['index_change_pw_button'].'": function() {
                    ChangerMdp("'. (isset($_SESSION['last_pw']) ? $_SESSION['last_pw'] : ''). '");
                },
                "'.$txt['cancel_button'].'": function() {
                    $(this).dialog("close");
                }
            }
        });

        // DIALOG BOX FOR ASKING PASSWORD
        $("#div_forgot_pw").dialog({
            bgiframe: true,
            modal: true,
            autoOpen: false,
            width: 300,
            height: 190,
            title: "'.$txt['forgot_my_pw'].'",
            buttons: {
                "'.$txt['send'].'": function() {
                    var data = "type=send_pw_by_email&email="+document.getElementById("forgot_pw_email").value;
                    httpRequest("sources/main.queries.php",data);
                },
                "'.$txt['cancel_button'].'": function() {
                    $("#forgot_pw_email").val("");
                    $(this).dialog("close");
                }
            }
        });

        // DIALOG BOX FOR CSV IMPORT
        $("#div_import_from_csv").dialog({
            bgiframe: true,
            modal: true,
            autoOpen: false,
            width: 600,
            height: 500,
            title: "'.$txt['import_csv_menu_title'].'",
            buttons: {
                "'.$txt['import_button'].'": function() {
                    if ( $(\'#radio1\').attr(\'checked\') ) ImportItemsFromCSV();
                    else $(this).dialog("close");
                },
                "'.$txt['cancel_button'].'": function() {
                    $("#import_status").html("");
                    $(this).dialog("close");
                }
            }
        });

        //CALL TO UPLOADIFY FOR CSV IMPORT
        $("#fileInput_csv").uploadify({
            "uploader"  : "includes/libraries/uploadify/uploadify.swf",
            "scriptData": {"type_upload":"import_items_from_file"},
            "script"    : "includes/libraries/uploadify/uploadify.php",
            "cancelImg" : "includes/libraries/uploadify/cancel.png",
            "auto"      : true,
            "folder"    : "files",
            "fileDesc"  : "csv",
            "fileExt"   : "*.csv",
            "onComplete": function(event, queueID, fileObj, reponse, data){$("#import_status_ajax_loader").show();ImportCSV(fileObj.name);},
            "buttonText": \''.$txt['csv_import_button_text'].'\'
        });

        //CALL TO UPLOADIFY FOR KEEPASS IMPORT
        $("#fileInput_keepass").uploadify({
            "uploader"  : "includes/libraries/uploadify/uploadify.swf",
            "scriptData": {"type_upload":"import_items_from_file"},
            "script"    : "includes/libraries/uploadify/uploadify.php",
            "cancelImg" : "includes/libraries/uploadify/cancel.png",
            "auto"      : true,
            "folder"    : "files",
            "fileDesc"  : "xml",
            "fileExt"   : "*.xml",
            "onComplete": function(event, queueID, fileObj, reponse, data){$("#import_status_ajax_loader").show();ImportKEEPASS(fileObj.name);},
            "buttonText": \''.$txt['keepass_import_button_text'].'\'
        });

        // DIALOG BOX FOR PRINT OUT ITEMS
        $("#div_print_out").dialog({
            bgiframe: true,
            modal: true,
            autoOpen: false,
            width: 400,
            height: 400,
            title: "'.$txt['print_out_menu_title'].'",
            buttons: {
                "'.$txt['print'].'": function() {
					//Get list of selected folders
					var ids = "";
					$("#selected_folders :selected").each(function(i, selected){
						if (ids == "" ) ids = $(selected).val();
						else ids = ids + ";" + $(selected).val();
					});

                	//Send query
                    var data = "type=print_out_items&ids="+ids;
                    httpRequest("sources/main.queries.php",data);
                },
                "'.$txt['cancel_button'].'": function() {
                    $(this).dialog("close");
                }
            }
        });
    })

    //Change the Users password when he asks for
    function ChangerMdp(old_pw){
        if ( document.getElementById("new_pw").value != "" && document.getElementById("new_pw").value == document.getElementById("new_pw2").value ){
            var data = "type=change_pw&new_pw="+escape(document.getElementById("new_pw").value)+"&old_pw="+old_pw;
            httpRequest("sources/main.queries.php",data);
        }else{
            $("#change_pwd_error").addClass("ui-state-error ui-corner-all");
            document.getElementById("change_pwd_error").innerHTML = "'.$txt['index_pw_error_identical'].'";
        }
    }

    //Permits to upload passwords from KEEPASS file
    function ImportKEEPASS(file){
        //check if file has good format
        var data = "type=import_file_format_keepass&file="+file+"&destination="+$("#import_keepass_items_to").val();
        httpRequest("sources/import.queries.php",data);
    }

    //Permits to upload passwords from CSV file
    function ImportCSV(file){
        //check if file has good format
        var data = "type=import_file_format_csv&file="+file;
        httpRequest("sources/import.queries.php",data);
    }

    //get list of items checked by user
    function ImportItemsFromCSV(){
        var items = "";

        //Get data checked
        $("input[type=checkbox]:checked").each(function() {
            var elem = $(this).attr("id").split("-");
            if ( items == "") items = $("#item_to_import_values-"+elem[1]).val();
            else items = items + "@_#sep#_@" + $("#item_to_import_values-"+elem[1]).val();

        });

        //Lauchn ajax query that will insert items into DB
        var data = "type=import_items&folder="+document.getElementById("import_items_to").value+"&data="+escape(items);
        httpRequest("sources/import.queries.php",data);
    }

    //Toggle details importation
    function toggle_importing_details() {
        $("#div_importing_kp_details").toggle();
    }

    //PRINT OUT: select folders
    function print_out_items() {
    	//Lauchn ajax query that will build the select list
        var data = "type=get_folders_list&div_id=selected_folders";
        httpRequest("sources/main.queries.php",data);

    	//Open dialogbox
        $(\'#div_print_out\').dialog(\'open\');
    }';
}

else
//JAVASCRIPT FOR ITEMS PAGE
if ( isset($_GET['page']) && $_GET['page'] == "items"){
    $htmlHeaders .= '
    //Launch the copy in clipboard script
    ZeroClipboard.setMoviePath( "'.$_SESSION['settings']['cpassman_url'].'/includes/libraries/zeroclipboard/ZeroClipboard.swf");';
}

else
//JAVASCRIPT FOR FIND PAGE
if ( isset($_GET['page']) && $_GET['page'] == "find"){
    $htmlHeaders .= '
    $(function() {
        //Launch the datatables pluggin
        $("#t_items").dataTable({
            "aaSorting": [[ 1, "asc" ]],
            "sPaginationType": "full_numbers",
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": "sources/find.queries.php",
            "bJQueryUI": true,
            "oLanguage": {
                "sUrl": "includes/language/datatables.'.$_SESSION['user_language'].'.txt"
            }
        });
    });';
}

else
//JAVASCRIPT FOR ADMIN PAGE
if ( isset($_GET['page']) && $_GET['page'] == "manage_main" ){
    $htmlHeaders .= '
            //Function loads informations from cpassman FTP
            function LoadCPMInfo(){
                var data = "type=cpm_status";
                httpRequest("sources/admin.queries.php",data);
            }
            //Load function on page load
            $(function() {
                LoadCPMInfo();
            });';

}

else
//JAVASCRIPT FOR FAVOURITES PAGE
if ( isset($_GET['page']) && $_GET['page'] == "favourites" ){
    $htmlHeaders .= '
    $(function() {
        // DIALOG BOX FOR DELETING FAVOURITE
        $("#div_delete_fav").dialog({
            bgiframe: true,
            modal: true,
            autoOpen: false,
            width: 300,
            height: 60,
            title: "'.$txt['item_menu_del_from_fav'].'",
            buttons: {
                "'.$txt['index_change_pw_confirmation'].'": function() {
                    var data = "type=del_fav"+
                                "&id="+document.getElementById(\'detele_fav_id\').value;
                    httpRequest("sources/favourites.queries.php",data);
                },
                "'.$txt['cancel_button'].'": function() {
                    $(this).dialog("close");
                }
            }
        });
    })

    function prepare_delete_fav(id){
        document.getElementById("detele_fav_id").value = id;
        OpenDialogBox(\'div_delete_fav\');
    }';
}

else
//JAVASCRIPT FOR ADMIN_SETTIGNS PAGE
if ( isset($_GET['page']) && $_GET['page'] == "manage_settings" ){
    $htmlHeaders .= '
    $(function() {
        //CALL TO UPLOADIFY FOR RESTORE SQL FILE
        $("#fileInput_restore_sql").uploadify({
            "uploader"  : "includes/libraries/uploadify/uploadify.swf",
            "script"    : "includes/libraries/uploadify/uploadify.php",
            "cancelImg" : "includes/libraries/uploadify/cancel.png",
            "auto"      : true,
            "folder"    : "files",
            "fileDesc"  : "sql",
            "fileExt"   : "*.sql",
            "height"   : "18px",
            "width"   : "18px",
            "wmode"     : "transparent",
            "buttonImg" : "includes/images/inbox--plus.png",
            "onComplete": function(event, queueID, fileObj, reponse, data){
                var key = prompt("'.$txt['admin_action_db_restore_key'].'","'.$txt['encrypt_key'].'");
                if ( key != "" ) LaunchAdminActions("admin_action_db_restore",fileObj.name+"&key="+key);
            }
        });

        //BUILD BUTTONS
        $("#save_button, save_button2").button();
    });

    //###########
    //## FUNCTION : Launch the action the admin wants
    //###########
    function LaunchAdminActions(action,option){
        LoadingPage();
        if ( action == "admin_action_db_backup" ) option = $("#result_admin_action_db_backup_key").val();
        var data = "type="+action+"&option="+option;
        httpRequest("sources/admin.queries.php",data);
    }
    ';
}

else
//JAVASCRIPT FOR MANAGE ROLES PAGE
if ( isset($_GET['page']) && $_GET['page'] == "manage_roles" ){
    $htmlHeaders .= '
    //###########
    //## FUNCTION : Change the actual right of the role other the select folder
    //###########
    function tm_change_role(role,folder,right,cell_id){
        $("#div_loading").show()
        var data = "type=change_role_via_tm&role="+role+"&folder="+folder+"&color="+$("#tm_cell_"+cell_id).css("backgroundColor")+"&cell_id="+cell_id;
        httpRequest("sources/roles.queries.php",data);
    }

    function delete_this_role(id,name){
        document.getElementById("delete_role_id").value = id;
        document.getElementById("delete_role_show").innerHTML = name;
        $("#delete_role").dialog("open");
    }

    function edit_this_role(id,name){
        document.getElementById("edit_role_id").value = id;
        document.getElementById("edit_role_show").innerHTML = name;
        $("#edit_role").dialog("open");
    }

    function refresh_matrice(){
        $("#div_loading").show();
        var data = "type=rafraichir_matrice";
        httpRequest("sources/roles.queries.php",data);
    }

    $(function() {

        $("#add_new_function").dialog({
            bgiframe: true,
            modal: true,
            autoOpen: false,
            width: 400,
            height: 150,
            title: "'.$txt["give_function_title"].'",
            buttons: {
                "'.$txt["save_button"].'": function() {
                    LoadingPage();  //show loading div
                    var data = "type=add_new_function&"+
                        "&name="+document.getElementById("new_function").value;
                    httpRequest("sources/roles.queries.php",data);
                    $(this).dialog("close");
                },
                "'.$txt["cancel_button"].'": function() {
                    $(this).dialog("close");
                }
            }
        });

        $("#delete_role").dialog({
            bgiframe: true,
            modal: true,
            autoOpen: false,
            width: 400,
            height: 150,
            title: "'. $txt["admin_action"] .'",
            buttons: {
                "'.$txt["ok"].'": function() {
                    LoadingPage();  //show loading div
                    var data = "type=delete_role&id="+document.getElementById("delete_role_id").value;
                    httpRequest("sources/roles.queries.php",data);
                    $(this).dialog("close");
                },
                "'.$txt["cancel_button"].'": function() {
                    $(this).dialog("close");
                }
            }
        });

        $("#edit_role").dialog({
            bgiframe: true,
            modal: true,
            autoOpen: false,
            width: 400,
            height: 200,
            title: "'. $txt["admin_action"] .'",
            buttons: {
                "'.$txt["ok"].'": function() {
                    LoadingPage();  //show loading div
                    var data = "type=edit_role&id="+document.getElementById("edit_role_id").value+"&title="+escape(document.getElementById("edit_role_title").value);
                    httpRequest("sources/roles.queries.php",data);
                    $(this).dialog("close");
                },
                "'.$txt["cancel_button"].'": function() {
                    $(this).dialog("close");
                }
            }
        });

        $("#help_on_roles").dialog({
            bgiframe: false,
            modal: false,
            autoOpen: false,
            width: 850,
            height: 500,
            title: "'. $txt["admin_help"] .'",
            buttons: {
                "'.$txt["close"].'": function() {
                    $(this).dialog("close");
                }
            },
            open: function(){
                $("#accordion").accordion({ autoHeight: false, navigation: true, collapsible: true, active: false });
            }
        });

        refresh_matrice();
    });';
}

else
//JAVASCRIPT FOR MANAGE USERS PAGE
if ( isset($_GET['page']) && $_GET['page'] == "manage_users" ){
    $htmlHeaders .= '
    $(function() {
        //inline editing
        $(".editable_textarea").editable("sources/users.queries.php", {
              indicator : "<img src=\'includes/images/loading.gif\' />",
              type   : "textarea",
              select : true,
              submit : " <img src=\'includes/images/disk_black.png\' />",
              cancel : " <img src=\'includes/images/cross.png\' />",
              name : "newlogin"
        });

        $("#change_user_functions").dialog({
            bgiframe: true,
            modal: true,
            autoOpen: false,
            width: 400,
            height: 400,
            title: "'.$txt['change_user_functions_title'].'",
            buttons: {
                "'. $txt['save_button'].'": function() {
                    Change_user_rights(document.getElementById("selected_user").value,"functions");
                    $(this).dialog("close");
                },
                "'. $txt['cancel_button'].'": function() {
                    $(this).dialog("close");
                }
            }
        });

        $("#change_user_autgroups").dialog({
            bgiframe: true,
            modal: true,
            autoOpen: false,
            width: 400,
            height: 400,
            title: "'. $txt['change_user_autgroups_title'].'",
            buttons: {
                "'. $txt['save_button'].'": function() {
                    Change_user_rights(document.getElementById("selected_user").value,"autgroups");
                    $(this).dialog("close");
                },
                "'. $txt['cancel_button'].'": function() {
                    $(this).dialog("close");
                }
            }
        });

        $("#change_user_forgroups").dialog({
            bgiframe: true,
            modal: true,
            autoOpen: false,
            width: 400,
            height: 400,
            title: "'. $txt['change_user_forgroups_title'].'",
            buttons: {
                "'. $txt['save_button'].'": function() {
                    Change_user_rights(document.getElementById("selected_user").value,"forgroups");
                    $(this).dialog("close");
                },
                "'.$txt['cancel_button'].'": function() {
                    $(this).dialog("close");
                }
            }
        });

        $("#add_new_user").dialog({
            bgiframe: true,
            modal: true,
            autoOpen: false,
            width: 280,
            height: 340,
            title: "'.$txt['new_user_title'].'",
            buttons: {
                "'.$txt['save_button'].'": function() {
                    LoadingPage();  //show loading div
                    var data = "type=add_new_user&"+
                        "&login="+escape(document.getElementById("new_login").value)+
                        "&pw="+escape(document.getElementById("new_pwd").value)+
                        "&email="+document.getElementById("new_email").value+
                        "&admin="+document.getElementById("new_admin").checked+
                        "&manager="+document.getElementById("new_manager").checked+
                        "&personal_folder="+document.getElementById("new_personal_folder").checked;
                    httpRequest("sources/users.queries.php",data);
                    $(this).dialog("close");
                },
                "'.$txt['cancel_button'].'": function() {
                    $(this).dialog("close");
                }
            }
        });

        $("#delete_user").dialog({
            bgiframe: true,
            modal: true,
            autoOpen: false,
            width: 400,
            height: 150,
            title: "'.$txt['admin_action'].'",
            buttons: {
                "'.$txt['ok'].'": function() {
                    LoadingPage();  //show loading div
                    var data = "type=supprimer_user&id="+document.getElementById("delete_user_id").value;
                    httpRequest("sources/users.queries.php",data);
                    $(this).dialog("close");
                },
                "'.$txt['cancel_button'].'": function() {
                    $(this).dialog("close");
                }
            }
        });

        $("#change_user_pw").dialog({
            bgiframe: true,
            modal: true,
            autoOpen: false,
            width: 400,
            height: 200,
            title: "'.$txt['admin_action'].'",
            buttons: {
                "'.$txt['save_button'].'": function() {
                    if ( document.getElementById("change_user_pw_newpw").value == document.getElementById("change_user_pw_newpw_confirm").value ){
                        LoadingPage();  //show loading div
                        var data = "type=modif_mdp_user&"+
                        "id="+document.getElementById("change_user_pw_id").value+
                        "&newmdp="+escape(document.getElementById("change_user_pw_newpw").value);
                        httpRequest("sources/users.queries.php",data);
                        document.getElementById("change_user_pw_error").innerHTML = "";
                        $("#change_user_pw_error").hide();
                        document.getElementById("change_user_pw_newpw_confirm").value = "";
                        document.getElementById("change_user_pw_newpw").value = "";
                        $(this).dialog("close");
                    }else{
                        document.getElementById("change_user_pw_error").innerHTML = "'.$txt['error_password_confirmation'].'"
                        $("#change_user_pw_error").show();
                    }
                },
                "'.$txt['cancel_button'].'": function() {
                    $(this).dialog("close");
                }
            }
        });

        $("#change_user_email").dialog({
            bgiframe: true,
            modal: true,
            autoOpen: false,
            width: 400,
            height: 200,
            title: "'.$txt['admin_action'].'",
            buttons: {
                "'.$txt['save_button'].'": function() {
                    var data = "type=modif_mail_user"+
                    "&id="+document.getElementById("change_user_email_id").value+
                    "&newemail="+document.getElementById("change_user_email_newemail").value;
                    httpRequest("sources/users.queries.php",data);
                    $(this).dialog("close");
                },
                "'.$txt['cancel_button'].'": function() {
                    $(this).dialog("close");
                }
            }
        });

        $("#help_on_users").dialog({
            bgiframe: false,
            modal: false,
            autoOpen: false,
            width: 850,
            height: 500,
            title: "'. $txt["admin_help"] .'",
            buttons: {
                "'.$txt["close"].'": function() {
                    $(this).dialog("close");
                }
            },
            open: function(){
                $("#accordion").accordion({ autoHeight: false, navigation: true, collapsible: true, active: false });
            }
        });
    });

    function pwGenerate(elem){
        var data = "type=pw_generate"+
                    "&size="+(Math.floor((8-5)*Math.random()) + 6)+
                    "&num=true"+
                    "&maj=true"+
                    "&symb=false"+
                    "&fixed_elem=1"+
                    "&elem="+elem;
        httpRequest("sources/items.queries.php",data+"&force=false");
    }

    function supprimer_user(id,login){
        document.getElementById("delete_user_login").value = login;
        document.getElementById("delete_user_id").value = id;
        document.getElementById("delete_user_show_login").innerHTML = login;
        $("#delete_user").dialog("open");
    }

    function mdp_user(id,login){
        document.getElementById("change_user_pw_id").value = id;
        document.getElementById("change_user_pw_show_login").innerHTML = login;
        $("#change_user_pw").dialog("open");
    }

    function mail_user(id,login,email){
        document.getElementById("change_user_email_id").value = id;
        document.getElementById("change_user_email_show_login").innerHTML = login;
        document.getElementById("change_user_email_newemail").value = email;
        $("#change_user_email").dialog("open");
    }

    function Changer_Droit_Groupes(id){
        var droit = 0;
        if ( document.getElementById("cb_gest_groupes_"+id).checked == true ) droit = 1;
        var data = "type=modif_droit_gest_groupes_user&id="+id+"&gest_groupes="+droit;
        httpRequest("sources/users.queries.php",data);
    }

    function Changer_Droit_Admin(id){
        var admin = 0;
        if ( document.getElementById("cb_admin_"+id).checked == true ) admin = 1;
        var data = "type=modif_droit_admin_user&id="+id+"&admin="+admin;
        httpRequest("sources/users.queries.php",data);
    }

    function Change_Personal_Folder(id){
        var pers_fld = 0;
        if ( document.getElementById("cb_personal_folder_"+id).checked == true ) pers_fld = 1;
        var data = "type=modif_personal_folder_user&id="+id+"&pers_fld="+pers_fld;
        httpRequest("sources/users.queries.php",data);
    }

    function Open_Div_Change(id,type){
        LoadingPage();  //show loading div
        var data = "type=open_div_"+type+"&id="+id;
        httpRequest("sources/users.queries.php",data);
    }

    function Change_user_rights(id,type){
        var list = "";
        if ( type == "functions" ) var form = document.forms.tmp_functions;
        if ( type == "autgroups" ) var form = document.forms.tmp_autgroups;
        if ( type == "forgroups" ) var form = document.forms.tmp_forgroups;

        for (i=0 ; i<= form.length-1 ; i++){
            if (form[i].type == "checkbox" && form[i].checked){
                function_id = form[i].id.split("-")
                if ( list == "" ) list = function_id[1];
                else list = list + ";" + function_id[1];
            }
        }
        if ( type == "functions" ) var data = "type=change_user_functions&id="+id+"&list="+list;
        if ( type == "autgroups" ) var data = "type=change_user_autgroups&id="+id+"&list="+list;
        if ( type == "forgroups" ) var data = "type=change_user_forgroups&id="+id+"&list="+list;
        httpRequest("sources/users.queries.php",data);
    }
    ';
}

else
//JAVASCRIPT FOR MANAGE FOLDERS PAGE
if ( isset($_GET['page']) && $_GET['page'] == "manage_folders" ){
    $htmlHeaders .= '
    $(function() {
        //inline editing
        $(".editable_textarea").editable("sources/folders.queries.php", {
              indicator : "<img src=\'includes/images/loading.gif\' />",
              type   : "textarea",
              select : true,
              submit : " <img src=\'includes/images/disk_black.png\' />",
              cancel : " <img src=\'includes/images/cross.png\' />",
              name : "newtitle",
              width : "240"
          });

          //inline editing
        $(".renewal_textarea").editable("sources/folders.queries.php", {
              indicator : "<img src=\'includes/images/loading.gif\' />",
              type   : "textarea",
              select : true,
              submit : " <img src=\'includes/images/disk_black.png\' />",
              cancel : " <img src=\'includes/images/cross.png\' />",
              name : "renewal_period",
              width : "40"
          });

          //Prepare creation dialogbox
          $("#open_add_group_div").click(function() {
                $("#div_add_group").dialog("open");
          });

          $("#div_add_group").dialog({
            bgiframe: true,
            modal: true,
            autoOpen: false,
            width: 250,
            height: 330,
            title: "'.$txt['add_new_group'].'",
            buttons: {
                "'.$txt['save_button'].'": function() {
                    ajouter_groupe();
                },
                "'.$txt['cancel_button'].'": function() {
                    $(this).dialog("close");
                }
            }
        });

        $("#help_on_folders").dialog({
            bgiframe: false,
            modal: false,
            autoOpen: false,
            width: 850,
            height: 500,
            title: "'. $txt["admin_help"] .'",
            buttons: {
                "'.$txt["close"].'": function() {
                    $(this).dialog("close");
                }
            },
            open: function(){
                $("#accordion").accordion({ autoHeight: false, navigation: true, collapsible: true, active: false });
            }
        });
    });



    function ajouter_groupe(){
        //Check if renewal_period is an integer
        if ( isInteger(document.getElementById("add_node_renewal_period").value) == false ){
            document.getElementById("addgroup_show_error").innerHTML = "'.$txt['error_renawal_period_not_integer'].'";
            $("#addgroup_show_error").show();
        }else{
            if ( document.getElementById("new_rep_complexite").value == "" ){
                document.getElementById("addgroup_show_error").innerHTML = "'.$txt['error_group_complex'].'";
                $("#addgroup_show_error").show();
            }else{
                if ( document.getElementById("ajouter_groupe_titre").value != "" && document.getElementById("parent_id").value != "na" ){
                    $("#addgroup_show_error").hide();
                    var data = "type=ajouter_groupe"+
                                "&titre="+escape(document.getElementById("ajouter_groupe_titre").value)+
                                "&complex="+document.getElementById("new_rep_complexite").value+
                                "&renewal_period="+document.getElementById("add_node_renewal_period").value+
                                "&parent_id="+document.getElementById("parent_id").value;
                    httpRequest("sources/folders.queries.php",data);
                    $("#div_add_group").dialog("close");
                }else{
                    document.getElementById("addgroup_show_error").innerHTML = "'.$txt['error_fields_2'].'";
                    $("#addgroup_show_error").show();
                }
            }
        }
    }

    function supprimer_groupe(id){
        if ( confirm("'.$txt['confirm_delete_group'].'") ){
            var data = "type=supprimer_groupe&id="+id;
            httpRequest("sources/folders.queries.php",data);
        }
    }

    function Changer_Droit_Complexite(id,type){
        var droit = 0;
        if ( type == "creation" ){
            if ( document.getElementById("cb_droit_"+id).checked == true ) droit = 1;
            var data = "type=modif_droit_autorisation_sans_complexite&id="+id+"&droit="+droit;
        }else if ( type == "modification" ){
            if ( document.getElementById("cb_droit_modif_"+id).checked == true ) droit = 1;
            var data = "type=modif_droit_modification_sans_complexite&id="+id+"&droit="+droit;
        }
        httpRequest("sources/folders.queries.php",data);
    }';
}

$htmlHeaders .= '
// ]]>
</script>';
?>