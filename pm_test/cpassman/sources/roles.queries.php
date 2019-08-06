<?php
####################################################################################################
## File : views.queries.php
## Author : Nils Laumaillé
## Description : File contains queries for ajax
## 
## DON'T CHANGE !!!
## 
####################################################################################################

session_start();

include('../includes/language/'.$_SESSION['user_language'].'.php'); 
include('../includes/settings.php');
header("Content-type: text/html; charset=".$k['charset']); 

//Connect to mysql server
require_once("class.database.php"); 
$db = new Database($server, $user, $pass, $database, $pre);
$db->connect(); 

// Construction de la requête en fonction du type de valeur
if ( !empty($_POST['type']) ){
    switch($_POST['type'])
    {
        #CASE adding a new role
        case "add_new_function":
            $db->query("INSERT INTO ".$pre."functions SET title = '".mysql_real_escape_string(stripslashes(($_POST['name'])))."'");
            //Actualize the variable
            $_SESSION['nb_roles'] ++;
            //reload page
            echo 'window.location.href = "index.php?page=manage_roles";';
        break;
        
        #-------------------------------------------
        #CASE delete a role
        case "delete_role":
            $db->query("DELETE FROM ".$pre."functions WHERE id = ".$_POST['id']);
            //Actualize the variable
            $_SESSION['nb_roles'] --;
            //reload page
            echo 'window.location.href = "index.php?page=manage_roles";';
        break;
        
        #-------------------------------------------
        #CASE editing a role
        case "edit_role":
            $db->query_update(
                "functions",
                array(
                    'title' => mysql_real_escape_string(stripslashes(($_POST['title'])))
                ),
                'id = '.$_POST['id']
            );
            //reload matrix
            echo 'var data = "type=rafraichir_matrice";httpRequest("sources/roles.queries.php",data);';
        break;
        
                
        #-------------------------------------------
        #CASE refresh the matrix
        case "rafraichir_matrice": 
            echo 'document.getElementById(\'matrice_droits\').innerHTML = "";';
            require_once ("NestedTree.class.php");
            $tree = new NestedTree($pre.'nested_tree', 'id', 'parent_id', 'title');
            $tst = $tree->getDescendants();
            $texte = '<table><thead><tr><th>'.$txt['group'].'s</th>';
            $gpes_ok = array();
            $gpes_nok = array();
            $tab_fonctions = array();
            $rows = $db->fetch_all_array("SELECT title,id,groupes_visibles,groupes_interdits FROM ".$pre."functions ORDER BY title ASC");
            foreach( $rows as $reccord ){
                $texte .= '<th style="font-size:10px;" class="edit_role">'.
                    $reccord['title'].'<br><img src=\'includes/images/ui-tab--pencil.png\' onclick=\'edit_this_role('.$reccord['id'].',"'.$reccord['title'].'")\' style=\'cursor:pointer;\' \>&nbsp;<img src=\'includes/images/ui-tab--minus.png\' onclick=\'delete_this_role('.$reccord['id'].',"'.$reccord['title'].'")\' style=\'cursor:pointer;\' \></th>';
                //Get all descendents groups
                $gpok = $reccord['groupes_visibles'];
                $gpnok = $reccord['groupes_interdits'];
                $tmp_ok = explode(';',$reccord['groupes_visibles']);
                $tmp_nok = explode(';',$reccord['groupes_interdits']);
                foreach($tmp_ok as $t){
                    if ( !empty($t) ){
                        $desc = $tree->getDescendants($t);
                        foreach($desc as $d)
                            $gpok .= ';'.$d->id;
                    }
                }
                foreach($tmp_nok as $t){
                    if ( !empty($t) ){
                        $desc = $tree->getDescendants($t);
                        foreach($desc as $d)
                            $gpnok .= ';'.$d->id;
                    }
                }
                //save into array
                $tab_fonctions[$reccord['id']] = array(
                    "ok" => $gpok,
                    "nok" => $gpnok,
                    "id" => $reccord['id'],
                    "titre" => $reccord['title']
                );
            }
            $texte .= '</tr></thead><tbody>';
            //construire tableau des groupes
            $tab_groupes = array();
            foreach($tst as $t){
                if ( in_array($t->id,$_SESSION['groupes_visibles']) ) {
                    $ident="";
                    for($a=1;$a<$t->nlevel;$a++) $ident .= "&nbsp;&nbsp;";
                    $tab_groupes[$t->id] = array(
                            'id' => $t->id,
                            'titre' => $t->title,
                            'ident' => $ident
                            );
                }
            } 
            
            //afficher
            $i=0;
            foreach ($tab_groupes as $groupe){
                $visibilite = "";
                $texte .= '<tr><td style="font-size:10px; font-family:arial;">'.$groupe['ident'].$groupe['titre'].'</td>';
                foreach ($tab_fonctions as $fonction){  
                    if ( !empty($fonction) ){          
                        if ( !empty($fonction['ok']) ) $gpes_ok = explode(';',$fonction['ok']);else $gpes_ok = array();
                        if ( !empty($fonction['nok']) ) $gpes_nok = explode(';',$fonction['nok']);else $gpes_nok = array();
                        if ( in_array($groupe['id'],$gpes_ok) ) {
                            $couleur = '#008000';
                            $accessible = 1;
                        }else{
                            $couleur = '#FF0000';
                            $accessible = 0;
                        }
                        if ( count($gpes_nok)>0 && in_array($groupe['id'],$gpes_nok) ) $couleur = '#FF0000';
                        $texte .= '<td align="center" style="background-color:'.$couleur.'" onclick="tm_change_role('.$fonction['id'].','.$groupe['id'].','.$accessible.','.$i.')" id="tm_cell_'.$i.'"></td>';
                        if ( $couleur != '#FF0000') {
                            if ( empty($visibilite) ) $visibilite =  $fonction['id'];
                            else $visibilite .= ";".$fonction['id'];
                        }
                    }
                    $i++;
                }
                $texte .= '</tr>';
                
                //Store in DB
                $data = $db->fetch_row("SELECT COUNT(*) FROM ".$pre."misc WHERE type='visibilite' AND intitule = '".$groupe['id']."'");
                if ( $data[0] == 0 ){
                    $db->query_insert(
                        'misc',
                        array(
                            'type' => 'visibilite',
                            'intitule' => $groupe['id'],
                            'valeur' => $visibilite
                        )
                    );
                }else{
                    $db->query_update(
                        'misc',
                        array(
                            'valeur' => $visibilite
                        ),
                        "type='visibilite' AND intitule = '".$groupe['id']."'"
                    );
                }
            }
            $texte .= '</tbody></table>';
            echo 'document.getElementById(\'matrice_droits\').innerHTML = "'.addslashes($texte).'";';
            echo '$("#div_loading").hide()';  //hide loading div
        break;
        
        #-------------------------------------------
        #CASE change right for a role on a folder via the TM
        case "change_role_via_tm";
            //get from DB previous value
            $data = $db->fetch_row("SELECT groupes_visibles, groupes_interdits FROM ".$pre."functions WHERE id = '".$_POST['role']."'");
            if ( !empty($data[0]) ) $folders_ok = explode(';',$data[0]);
            else $folders_ok = array();
            if ( !empty($data[1]) ) $folders_nok = explode(';',$data[1]);
            else $folders_nok = array();
            
            //get full tree dependencies
            require_once ("NestedTree.class.php");
            $tree = new NestedTree($pre.'nested_tree', 'id', 'parent_id', 'title');
            $descendants = $tree->getDescendants($_POST['folder'],true);
            
            //Manage new right depending on cell color
            if ( $_POST['color'] == 'rgb(255, 0, 0)' ){
                $couleur = 'rgb(0, 128, 0)';
                foreach($descendants as $descendant){
                    if ( !in_array($descendant->id,$folders_ok)) array_push($folders_ok,$descendant->id);
                    unset($folders_nok[array_search($descendant->id, $folders_nok)]);
                }
            }else{
                $couleur = 'rgb(255, 0, 0)';
                foreach($descendants as $descendant){
                    if ( !in_array($descendant->id,$folders_nok)) array_push($folders_nok,$descendant->id);
                    unset($folders_ok[array_search($descendant->id, $folders_ok)]);
                }
            }
                        
            //prepare next query
            $folders_ok = implode(';',$folders_ok);
            $folders_nok = implode(';',$folders_nok);
                        
            //Store in DB
            $db->query_update(
                'functions',
                array(
                    'groupes_visibles' => $folders_ok,
                    'groupes_interdits' => $folders_nok
                ),
                "id = '".$_POST['role']."'"
            );
            
            echo 'httpRequest("sources/roles.queries.php","type=rafraichir_matrice");';
                        
            echo '$("#div_loading").hide();';
        break;        
    }
}else if ( !empty($_POST['edit_fonction']) ){
    $id = explode('_',$_POST['id']);
    //Update DB
    $db->query_update(
        'functions',
        array(
            'title' => mysql_real_escape_string(stripslashes(utf8_decode($_POST['edit_fonction'])))
        ),
        "id = ".$id[1]
    );
    //Show value
    echo $_POST['edit_fonction'];
}
?>
