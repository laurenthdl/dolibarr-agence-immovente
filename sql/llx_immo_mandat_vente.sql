-- Table immo_mandat_vente
CREATE TABLE IF NOT EXISTS {db_prefix}immo_mandat_vente (
    rowid SERIAL PRIMARY KEY,
    ref VARCHAR(128) NOT NULL,
    fk_user_creat INTEGER NOT NULL,
    datec TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    tms TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status INTEGER NOT NULL DEFAULT 0
) TABLESPACE pg_default;

-- Indexes
CREATE INDEX IF NOT EXISTS idx_immo_mandat_vente_ref ON {db_prefix}immo_mandat_vente(ref);
CREATE INDEX IF NOT EXISTS idx_immo_mandat_vente_status ON {db_prefix}immo_mandat_vente(status);

-- Trigger for tms
CREATE OR REPLACE FUNCTION update_tms_column()
RETURNS TRIGGER AS $$
BEGIN
    NEW.tms = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$ language 'plpgsql';

DROP TRIGGER IF EXISTS trg_immo_mandat_vente_tms ON {db_prefix}immo_mandat_vente;
CREATE TRIGGER trg_immo_mandat_vente_tms
    BEFORE UPDATE ON {db_prefix}immo_mandat_vente
    FOR EACH ROW
    EXECUTE FUNCTION update_tms_column();
