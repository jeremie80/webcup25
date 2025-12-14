# 🎭 Implémentation des Modes de Contact

## ✅ Ce qui a été implémenté

### 1. Base de données

**Nouvelles colonnes ajoutées à la table `matches` :**
- `contact_mode_a` : Mode choisi par profile_a (emotional, diplomatic, guided)
- `contact_mode_b` : Mode choisi par profile_b (emotional, diplomatic, guided)

**Script SQL :** `database/add_contact_mode.sql`

```sql
ALTER TABLE `matches` 
ADD COLUMN `contact_mode_a` VARCHAR(50) DEFAULT NULL,
ADD COLUMN `contact_mode_b` VARCHAR(50) DEFAULT NULL
AFTER `status`;
```

### 2. Backend - Modèle

**`app/Models/MatchModel.php`**

Méthode `accept()` mise à jour pour accepter le mode de contact :

```php
public function accept($matchId, $profileId, $contactMode = null)
{
    // Détermine quelle colonne mettre à jour (contact_mode_a ou contact_mode_b)
    $contactModeColumn = ($match['profile_a_id'] == $profileId) 
        ? 'contact_mode_a' 
        : 'contact_mode_b';
    
    // Valide le mode (emotional, diplomatic, guided)
    // Stocke en base de données
}
```

### 3. Backend - Contrôleur

**`app/Controllers/MatchController.php`**

La méthode `accept()` transmet maintenant le mode de contact :

```php
$contactMode = $_POST['contact_mode'] ?? 'emotional';
$matchModel->accept($matchId, $_SESSION['profile_id'], $contactMode);
```

**`app/Controllers/ChatController.php`**

Récupère et transmet les modes de contact à la vue :

```php
$myContactMode = $isProfileA ? $match['contact_mode_a'] : $match['contact_mode_b'];
$otherContactMode = $isProfileA ? $match['contact_mode_b'] : $match['contact_mode_a'];

$data = [
    'my_contact_mode' => $myContactMode,
    'other_contact_mode' => $otherContactMode,
    'contact_mode_labels' => [
        'emotional' => 'Message Émotionnel',
        'diplomatic' => 'Protocole Diplomatique',
        'guided' => 'Dialogue Guidé par l\'IA'
    ]
];
```

### 4. Frontend - Vue du Chat

**`app/Views/chat/conversation.php`**

#### Affichage des badges de mode

```php
<div class="contact-modes-info">
    <div class="mode-badge mode-emotional">
        <span class="mode-label">Votre mode :</span>
        <span class="mode-name">💌 Message Émotionnel</span>
    </div>
    
    <div class="mode-badge mode-diplomatic">
        <span class="mode-label">Mode de Lyra :</span>
        <span class="mode-name">🕊️ Protocole Diplomatique</span>
    </div>
</div>
```

#### Interventions IA adaptées

**Message de bienvenue (1er message) :**
- Mode Émotionnel : "Exprimez-vous avec authenticité et sincérité."
- Mode Diplomatique : "Je veillerai à maintenir une communication courtoise et structurée."
- Mode Guidé : "Je vous accompagnerai avec des suggestions pour faciliter vos échanges."

**Suggestions (3e et 6e message) - Mode Guidé uniquement :**
- "💡 Suggestion : Partagez une expérience marquante de votre civilisation."
- "💡 Suggestion : Demandez à votre interlocuteur·ice ce qui le·la passionne le plus."
- "💡 Suggestion : Explorez vos visions communes pour l'avenir cosmique."

**Avertissements hostiles - Mode Diplomatique :**
- Message standard + "Le protocole diplomatique encourage la reformulation constructive."

### 5. CSS - Styles

**`assets/css/style.css`**

```css
.contact-modes-info {
    display: flex;
    gap: var(--spacing-sm);
    margin: var(--spacing-md) 0;
    padding: var(--spacing-sm);
    background: rgba(255, 255, 255, 0.03);
    border-radius: 12px;
    flex-wrap: wrap;
}

.mode-badge {
    display: flex;
    align-items: center;
    gap: var(--spacing-xs);
    padding: 0.5rem 1rem;
    border-radius: 8px;
}

.mode-badge.mode-emotional {
    background: rgba(255, 182, 193, 0.1);
    border-color: rgba(255, 182, 193, 0.4);
}

.mode-badge.mode-diplomatic {
    background: rgba(126, 200, 227, 0.1);
    border-color: rgba(126, 200, 227, 0.4);
}

.mode-badge.mode-guided {
    background: rgba(168, 230, 207, 0.1);
    border-color: rgba(168, 230, 207, 0.4);
}
```

## 🎯 Fonctionnement

### Flux utilisateur

1. **Sélection du mode** (`/match/contact-mode?id=X`)
   - L'utilisateur voit 3 cartes avec les modes disponibles
   - Chaque carte affiche : description, niveau d'engagement, niveau de risque
   - Clic sur "Choisir ce mode"

2. **Soumission du formulaire**
   - POST vers `/match/accept` avec `match_id` et `contact_mode`
   - Le mode est stocké en base (`contact_mode_a` ou `contact_mode_b`)
   - Redirection vers `/match` avec message de confirmation

3. **Affichage dans le chat** (`/chat?match_id=X`)
   - Les badges de mode apparaissent en haut de la conversation
   - Couleurs différentes selon le mode choisi
   - Affichage du mode de l'utilisateur ET du mode de l'autre

4. **Interventions IA adaptées**
   - **1er message** : Explication du mode choisi
   - **3e et 6e messages (mode guidé)** : Suggestions de conversation
   - **Détection hostile (mode diplomatique)** : Message renforcé

## 📊 Les 3 modes

| Mode | Emoji | Engagement | Risque | Description |
|------|-------|------------|--------|-------------|
| **Émotionnel** | 💌 | Élevé | Modéré | Expression authentique, directe et sincère |
| **Diplomatique** | 🕊️ | Modéré | Faible | Approche respectueuse, structurée et progressive |
| **Guidé** | 🌱 | Progressif | Minimal | ASTRÆA facilite avec suggestions et guidance |

## 🎨 Couleurs des badges

- **Émotionnel** : Rose doux (`rgba(255, 182, 193, 0.1)`)
- **Diplomatique** : Bleu ciel (`rgba(126, 200, 227, 0.1)`)
- **Guidé** : Vert menthe (`rgba(168, 230, 207, 0.1)`)

## 🔄 Asymétrie possible

Chaque utilisateur choisit son propre mode :
- User A peut choisir "Émotionnel"
- User B peut choisir "Diplomatique"
- Les deux modes coexistent dans la conversation
- Les interventions IA s'adaptent au mode de chaque utilisateur

## 📝 Fichiers modifiés

```
database/
└── add_contact_mode.sql                  ← Nouveau fichier SQL

app/
├── Models/
│   └── MatchModel.php                    ← accept() mis à jour
├── Controllers/
│   ├── MatchController.php               ← Transmission du mode
│   └── ChatController.php                ← Récupération et affichage
└── Views/
    └── chat/
        └── conversation.php              ← Badges + interventions adaptées

assets/
└── css/
    └── style.css                         ← Styles des badges

CONTACT-MODE-IMPLEMENTATION.md            ← Cette documentation
```

## 🚀 Prochaines étapes (optionnel)

1. **Statistiques** : Tracker les modes les plus populaires
2. **Recommandations** : Suggérer un mode selon le type de compatibilité
3. **Changement de mode** : Permettre de changer en cours de conversation
4. **Analyse IA** : Évaluer si le mode choisi correspond au comportement réel

---

**Le système de modes de contact est maintenant pleinement fonctionnel ! 🎭✨**

