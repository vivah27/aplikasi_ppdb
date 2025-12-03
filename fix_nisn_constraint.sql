-- Drop existing NISN indexes/constraints
ALTER TABLE biodatas DROP FOREIGN KEY IF EXISTS biodatas_user_id_foreign;
ALTER TABLE biodatas DROP INDEX IF EXISTS biodatas_nisn_unique;
ALTER TABLE biodatas DROP INDEX IF EXISTS biodatas_user_id_nisn_unique;

-- Delete duplicate NISN - keep latest per NISN
DELETE FROM biodatas 
WHERE id NOT IN (
    SELECT id FROM (
        SELECT MAX(id) as id 
        FROM biodatas 
        GROUP BY nisn
    ) AS temp
);

-- Add foreign key back if needed
ALTER TABLE biodatas ADD CONSTRAINT biodatas_user_id_foreign 
FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE;

-- Add new unique constraint scoped by user_id
ALTER TABLE biodatas ADD UNIQUE INDEX biodatas_user_id_nisn_unique (user_id, nisn);
