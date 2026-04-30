<?php
declare(strict_types=1);
if (!class_exists('CommonObject')) { require_once DOL_DOCUMENT_ROOT . '/core/class/commonobject.class.php'; }
class ImmoMandatVente extends CommonObject {
    public $table_element = 'llx_immo_mandat_vente'; public $element = 'immovente';
    public $ref; public $fk_bien; public $fk_proprietaire; public $type_mandat; public $date_debut; public $date_fin;
    public $prix_net_vendeur; public $prix_minimum; public $commission_type; public $commission_valeur; public $fk_acquereur; public $statut;
    protected $fields = array(
        'rowid'=>array('type'=>'integer','enabled'=>1,'visible'=>-1,'position'=>10,'notnull'=>1),
        'ref'=>array('type'=>'varchar(128)','label'=>'Ref','enabled'=>1,'visible'=>1,'position'=>20,'notnull'=>1),
        'fk_bien'=>array('type'=>'integer','label'=>'Bien','enabled'=>1,'visible'=>1,'position'=>30,'notnull'=>1),
        'fk_proprietaire'=>array('type'=>'integer','label'=>'Proprietaire','enabled'=>1,'visible'=>1,'position'=>40),
        'type_mandat'=>array('type'=>'varchar(32)','label'=>'Type','enabled'=>1,'visible'=>1,'position'=>50),
        'date_debut'=>array('type'=>'date','label'=>'Debut','enabled'=>1,'visible'=>1,'position'=>60),
        'date_fin'=>array('type'=>'date','label'=>'Fin','enabled'=>1,'visible'=>1,'position'=>70),
        'prix_net_vendeur'=>array('type'=>'decimal(24,8)','label'=>'Prix','enabled'=>1,'visible'=>1,'position'=>80),
        'prix_minimum'=>array('type'=>'decimal(24,8)','label'=>'Minimum','enabled'=>1,'visible'=>1,'position'=>90),
        'commission_type'=>array('type'=>'varchar(32)','label'=>'Comm. type','enabled'=>1,'visible'=>1,'position'=>100),
        'commission_valeur'=>array('type'=>'decimal(24,8)','label'=>'Comm.','enabled'=>1,'visible'=>1,'position'=>110),
        'fk_acquereur'=>array('type'=>'integer','label'=>'Acquereur','enabled'=>1,'visible'=>1,'position'=>120),
        'statut'=>array('type'=>'varchar(32)','label'=>'Statut','enabled'=>1,'visible'=>1,'position'=>130),
        'fk_user_creat'=>array('type'=>'integer','label'=>'Auteur','enabled'=>1,'visible'=>-2,'position'=>510),
        'datec'=>array('type'=>'datetime','enabled'=>1,'visible'=>-2,'position'=>520),
        'tms'=>array('type'=>'timestamp','enabled'=>1,'visible'=>-2,'position'=>530),
        'status'=>array('type'=>'integer','enabled'=>1,'visible'=>1,'position'=>1000,'default'=>0),
    );
    public function __construct(DoliDB $db) { $this->db = $db; }
    public function create(User $user, $notrigger=false): int { $this->ref = $this->getRefNum(); return $this->createCommon($user,$notrigger); }
    public function fetch($id,$ref=''): int { return $this->fetchCommon($id,$ref); }
    public function update(User $user, $notrigger=false): int { return $this->updateCommon($user,$notrigger); }
    public function delete(User $user, $notrigger=false): int { return $this->deleteCommon($user,$notrigger); }
    public function calculCommission(): float {
        if ($this->commission_type==='FIXE') return (float)$this->commission_valeur;
        if ($this->commission_type==='POURCENTAGE') return (float)$this->prix_net_vendeur * (float)$this->commission_valeur / 100;
        return 0;
    }
    protected function getRefNum(): string {
        $sql = "SELECT MAX(CAST(SUBSTRING(ref FROM '.*-([0-9]+)$') AS INTEGER)) as maxref FROM " . $this->db->prefix() . $this->table_element;
        $resql = $this->db->query($sql); $num = ($resql && ($obj=$this->db->fetch_object($resql))) ? ((int)$obj->maxref + 1) : 1;
        return 'MV' . date('Y') . '-' . str_pad((string)$num, 4, '0', STR_PAD_LEFT);
    }
}
