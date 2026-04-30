CREATE TABLE IF NOT EXISTS llx_immo_mandat_vente (
    rowid SERIAL PRIMARY KEY, ref VARCHAR(128) NOT NULL UNIQUE,
    fk_bien INTEGER NOT NULL, fk_proprietaire INTEGER NOT NULL,
    type_mandat VARCHAR(32) DEFAULT 'SIMPLE', date_debut DATE NOT NULL, date_fin DATE,
    prix_net_vendeur DECIMAL(24,8) DEFAULT 0, prix_minimum DECIMAL(24,8) DEFAULT 0,
    commission_type VARCHAR(32) DEFAULT 'POURCENTAGE', commission_valeur DECIMAL(24,8) DEFAULT 0,
    fk_acquereur INTEGER, statut VARCHAR(32) DEFAULT 'ACTIF',
    fk_user_creat INTEGER NOT NULL, fk_user_modif INTEGER,
    datec TIMESTAMP DEFAULT CURRENT_TIMESTAMP, tms TIMESTAMP DEFAULT CURRENT_TIMESTAMP, status INTEGER NOT NULL DEFAULT 0
);
CREATE INDEX idx_immo_mandat_ref ON llx_immo_mandat_vente(ref);
CREATE INDEX idx_immo_mandat_fk_bien ON llx_immo_mandat_vente(fk_bien);
DROP TRIGGER IF EXISTS trg_immo_mandat_tms ON llx_immo_mandat_vente;
CREATE TRIGGER trg_immo_mandat_tms BEFORE UPDATE ON llx_immo_mandat_vente FOR EACH ROW EXECUTE FUNCTION update_tms();
