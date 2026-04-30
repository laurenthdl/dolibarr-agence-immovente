<?php
declare(strict_types=1);
require_once __DIR__ . '/../../main.inc.php';
require_once __DIR__ . '/class/immomandatvente.class.php';
$langs->load("immovente@immovente");
$action = GETPOST('action', 'aZ09'); $id = GETPOST('id', 'int');
if ($action === 'delete' && $id > 0) {
    $object = new ImmoMandatVente($db);
    if ($object->fetch($id) > 0) { $object->delete($user); setEventMessages('Mandat supprime', null, 'mesgs'); }
    header("Location: " . $_SERVER["PHP_SELF"]); exit;
}
llxHeader('', 'Mandats de vente');
print load_fiche_titre('Mandats de vente', '', 'company.png');
print '<div class="tabsAction"><a class="butAction" href="card.php?action=create">Nouveau mandat</a></div><br>';
$sql = "SELECT rowid, ref, fk_bien, type_mandat, date_debut, date_fin, prix_net_vendeur, commission_valeur, statut FROM " . $db->prefix() . "immo_mandat_vente ORDER BY datec DESC";
$resql = $db->query($sql);
print '<table class="noborder centpercent liste"><tr class="liste_titre"><th>Ref</th><th>Bien</th><th>Type</th><th>Debut</th><th>Fin</th><th class="right">Prix</th><th class="right">Commission</th><th>Statut</th><th class="center">Actions</th></tr>';
if ($resql) { while ($obj = $db->fetch_object($resql)) {
    print '<tr class="oddeven"><td><a href="card.php?id=' . $obj->rowid . '">' . $obj->ref . '</a></td>';
    print '<td>Bien #' . $obj->fk_bien . '</td><td>' . $obj->type_mandat . '</td>';
    print '<td>' . dol_print_date($obj->date_debut, 'day') . '</td><td>' . dol_print_date($obj->date_fin, 'day') . '</td>';
    print '<td class="right">' . price($obj->prix_net_vendeur) . '</td><td class="right">' . price($obj->commission_valeur) . '</td>';
    print '<td>' . $obj->statut . '</td><td class="center"><a href="card.php?action=edit&id=' . $obj->rowid . '">' . img_edit() . '</a> <a href="' . $_SERVER["PHP_SELF"] . '?action=delete&id=' . $obj->rowid . '&token=' . newToken() . '" onclick="return confirm('Supprimer ?')">' . img_delete() . '</a></td></tr>';
}}
print '</table>'; llxFooter();
