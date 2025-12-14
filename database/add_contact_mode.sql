-- Ajouter la colonne contact_mode à la table matches
-- Cette colonne stocke le mode de contact choisi par profile_a

ALTER TABLE `matches` 
ADD COLUMN `contact_mode_a` VARCHAR(50) DEFAULT NULL COMMENT 'Mode de contact choisi par profile_a: emotional, diplomatic, guided',
ADD COLUMN `contact_mode_b` VARCHAR(50) DEFAULT NULL COMMENT 'Mode de contact choisi par profile_b: emotional, diplomatic, guided'
AFTER `status`;

-- Note: Chaque utilisateur peut choisir son propre mode de contact
-- Ce qui permettra d'avoir des interactions asymétriques si besoin

