<?php
declare(strict_types=1);
require_once DOL_DOCUMENT_ROOT . '/core/modules/DolibarrModules.class.php';
class modImmovente extends DolibarrModules {
    public function __construct($db) {
        $this->db = $db; $this->numero = 700004; $this->rights_class = 'immovente';
        $this->family = "other"; $this->module_position = '90';
        $this->name = preg_replace('/^mod/i', '', get_class($this));
        $this->description = "Transactions de vente immobiliere";
        $this->version = '1.0.0'; $this->const_name = 'MAIN_MODULE_' . strtoupper($this->name);
        $this->picto = 'company'; $this->config_page_url = array("");
        $this->depends = array('mod_immocore'=>1,'mod_immobien'=>1,'mod_immoclient'=>1);
        $this->langfiles = array("immovente"); $this->phpmin = array(8,1);
        $this->need_dolibarr_version = array(23,0);
        $this->menu = array(); $r=0;
        $this->menu[$r] = array('fk_menu'=>'fk_mainmenu=immobilier','type'=>'left','titre'=>'Vente','mainmenu'=>'immobilier','leftmenu'=>'immovente','url'=>'/custom/immovente/index.php','langs'=>'immovente','position'=>700008,'perms'=>'1','user'=>2); $r++;
        $this->rights = array(); $this->rights_class = 'immovente'; $r=0;
        $this->rights[$r][0] = 700004001; $this->rights[$r][1] = 'Lire les mandats'; $this->rights[$r][3] = 0; $this->rights[$r][4] = 'read'; $r++;
        $this->rights[$r][0] = 700004002; $this->rights[$r][1] = 'Creer/Modifier les mandats'; $this->rights[$r][3] = 0; $this->rights[$r][4] = 'write'; $r++;
        $this->rights[$r][0] = 700004003; $this->rights[$r][1] = 'Supprimer les mandats'; $this->rights[$r][3] = 0; $this->rights[$r][4] = 'delete';
    }
    public function init($options=''): int { $sql=array(); return $this->_init($sql,$options); }
    public function remove($options=''): int { $sql=array(); return $this->_remove($sql,$options); }
}
