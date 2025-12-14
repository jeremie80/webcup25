# 🔧 Correction de l'erreur "updated_at"

## ❌ Erreur rencontrée

```
Fatal error: SQLSTATE[42S22]: Column not found: 1054 Unknown column 'updated_at' in 'field list'
```

## 🔍 Cause

La table `matches` ne possède pas de colonne `updated_at`, mais le code tentait de la mettre à jour lors de l'acceptation d'un match avec un mode de contact.

## ✅ Solution appliquée

**Fichier modifié :** `app/Models/MatchModel.php`

### Avant (ligne 299-309)

```php
$stmt = $this->db->prepare(
    "UPDATE matches 
     SET status = 'accepted', {$contactModeColumn} = :contact_mode, updated_at = :updated_at
     WHERE id = :id"
);

return $stmt->execute([
    'id' => $matchId,
    'contact_mode' => $contactMode,
    'updated_at' => time()
]);
```

### Après

```php
$stmt = $this->db->prepare(
    "UPDATE matches 
     SET status = 'accepted', {$contactModeColumn} = :contact_mode
     WHERE id = :id"
);

return $stmt->execute([
    'id' => $matchId,
    'contact_mode' => $contactMode
]);
```

## 📝 Notes

- La colonne `updated_at` a été complètement retirée de la requête SQL
- Le code fonctionne maintenant sans cette colonne
- Si besoin d'un horodatage de mise à jour, il faudrait d'abord ajouter la colonne à la table

## ✅ Statut

**Problème résolu** - Le système de modes de contact fonctionne maintenant correctement.

