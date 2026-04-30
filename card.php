<?php
declare(strict_types=1);
require_once __DIR__ . '/../../main.inc.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/html.form.class.php';
require_once __DIR__ . '/class/immomandatvente.class.php';
$langs->load("immovente@immovente"); $form = new Form($db);
$action = GETPOST('action', 'aZ09'); $id = GETPOST('id', 'int');
$object = new ImmoMandatVente($db);
if ($action === 'create' && !empty($_POST['fk_bien'])) {
    $object->fk_bien = GETPOST('fk_bien','int'); $object->fk_proprietaire = GETPOST('fk_proprietaire','int');
    $object->type_mandat = GETPOST('type_mandat','alpha'); $object->date_debut = GETPOST('date_debut','alpha');
    $object->date_fin = GETPOST('date_fin','alpha'); $object->prix_net_vendeur = GETPOST('prix_net_vendeur','alpha');
    $object->prix_minimum = GETPOST('prix_minimum','alpha'); $object->commission_type = GETPOST('commission_type','alpha');
    $object->commission_valeur = GETPOST('commission_valeur','alpha'); $object->statut = 'ACTIF'; $object->status = 1;
    $res = $object->create($user);
    if ($res > 0) { setEventMessages('Mandat cree : ' . $object->ref, null, 'mesgs'); header("Location: card.php?id=" . $object->rowid); exit; }
    else { setEventMessages($object->error, null, 'errors'); }
}
if ($action === 'update' && $id > 0 && $object->fetch($id) > 0) {
    $object->fk_bien = GETPOST('fk_bien','int'); $object->fk_proprietaire = GETPOST('fk_proprietaire','int');
    $object->type_mandat = GETPOST('type_mandat','alpha'); $object->date_debut = GETPOST('date_debut','alpha');
    $object->date_fin = GETPOST('date_fin','alpha'); $object->prix_net_vendeur = GETPOST('prix_net_vendeur','alpha');
    $object->prix_minimum = GETPOST('prix_minimum','alpha'); $object->commission_type = GETPOST('commission_type','alpha');
    $object->commission_valeur = GETPOST('commission_valeur','alpha');
    if ($object->update($user) > 0) { setEventMessages('Modifications enregistrees', null, 'mesgs'); header("Location: card.php?id=" . $id); exit; }
}
if ($id > 0) $object->fetch($id);
$title = ($action === 'create') ? 'Nouveau mandat' : (($action === 'edit') ? 'Modifier mandat' : 'Fiche mandat');
llxHeader('', $title); print load_fiche_titre($title, '', 'company.png');
if ($action === 'create' || $action === 'edit') {
    print '<form method="POST" action="' . $_SERVER["PHP_SELF"] . '"><input type="hidden" name="token" value="' . newToken() . '">';
    if ($action === 'edit') print '<input type="hidden" name="id" value="' . $id . '">';
    print '<input type="hidden" name="action" value="' . ($action === 'create' ? 'create' : 'update') . '">';
    print '<table class="border centpercent">';
    print '<tr><td class="fieldrequired">Bien ID</td><td><input name="fk_bien" value="' . ($object->fk_bien ?? '') . '"></td></tr>';
    print '<tr><td>Proprietaire</td><td>' . $form->select_company($object->fk_proprietaire ?? '', 'fk_proprietaire', '', 0, 1, 0, []) . '</td></tr>';
    print '<tr><td>Type</td><td><select name="type_mandat"><option value="SIMPLE"' . (($object->type_mandat??'')=='SIMPLE'?' selected':'') . '>Simple</option><option value="EXCLUSIF"' . (($object->type_mandat??'')=='EXCLUSIF'?' selected':'') . '>Exclusif</option></select></td></tr>';
    print '<tr><td>Date debut</td><td><input type="date" name="date_debut" value="' . ($object->date_debut ?? '') . '"></td></tr>';
    print '<tr><td>Date fin</td><td><input type="date" name="date_fin" value="' . ($object->date_fin ?? '') . '"></td></tr>';
    print '<tr><td class="fieldrequired">Prix net vendeur</td><td><input name="prix_net_vendeur" value="' . ($object->prix_net_vendeur ?? '') . '"></td></tr>';
    print '<tr><td>Prix minimum</td><td><input name="prix_minimum" value="' . ($object->prix_minimum ?? '') . '"></td></tr>';
    print '<tr><td>Commission</td><td><select name="commission_type"><option value="POURCENTAGE"' . (($object->commission_type??'')=='POURCENTAGE'?' selected':'') . '>%</option><option value="FIXE"' . (($object->commission_type??'')=='FIXE'?' selected':'') . '>Fixe</option></select> <input name="commission_valeur" value="' . ($object->commission_valeur ?? '') . '"></td></tr>';
    print '</table>';
    print '<div class="center"><input type="submit" class="button" value="Enregistrer"> <a class="butActionDelete" href="index.php">Annuler</a></div></form>';
} else {
    print '<table class="border centpercent">';
    print '<tr><td class="titlefield">Ref</td><td>' . ($object->ref) . '</td></tr>';
    print '<tr><td>Bien</td><td>#' . $object->fk_bien . '</td></tr>';
    print '<tr><td>Type</td><td>' . $object->type_mandat . '</td></tr>';
    print '<tr><td>Periode</td><td>' . dol_print_date($object->date_debut, 'day') . ' - ' . dol_print_date($object->date_fin, 'day') . '</td></tr>';
    print '<tr><td>Prix net vendeur</td><td>' . price($object->prix_net_vendeur) . ' FCFA</td></tr>';
    print '<tr><td>Commission</td><td>' . price($object->calculCommission()) . ' FCFA</td></tr>';
    print '</table>';
    print '<div class="tabsAction"><a class="butAction" href="card.php?action=edit&id=' . $id . '">Modifier</a> <a class="butAction" href="index.php">Retour liste</a></div>';
}
llyFooter();
