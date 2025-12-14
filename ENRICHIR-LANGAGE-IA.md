# 🤖 Enrichir le Langage de l'IA (ASTRÆA)

## 📚 Vue d'ensemble

Le système de langage de l'IA est géré par la classe `App\Core\IALanguage`. Cette classe permet de gérer des **variations aléatoires** de messages selon le contexte, rendant ASTRÆA plus naturelle et moins répétitive.

## 🎯 Contextes disponibles

### 1. **Tableau de Bord** (Score diplomatique)

5 niveaux de messages selon le score :
- `excellence` (90-100) - Ambassadeur·ice Cosmique
- `excellent` (70-89) - Bâtisseur·se de Ponts
- `good` (50-69) - Explorateur·ice Engagé·e
- `emerging` (30-49) - Voyageur·se en Éveil
- `beginning` (0-29) - Nouveau·lle Arrivant·e

**Actuellement : 3 variations par niveau = 15 messages différents**

### 2. **Chat / Interventions**

6 contextes d'intervention :
- `welcome` - Premier message
- `progress_early` - Après 3 messages
- `progress_mid` - Après 6 messages
- `progress_complete` - Après 10 messages
- `warning_hostile` - Détection de langage hostile
- `revelation` - Moment de révélation

**Actuellement : 3 variations par contexte = 18 messages différents**

### 3. **Résultats de Lien**

4 types de résultats :
- `harmonious` - Lien harmonieux
- `complex` - Relation complexe
- `risky` - Risque élevé
- `historic` - Alliance historique

**Actuellement : 3 variations par type = 12 messages différents**

### 4. **Analyse de Profil**

2 étapes :
- `analyzing` - En cours d'analyse
- `validating` - Validation

**Actuellement : 3 variations par étape = 6 messages différents**

## ✏️ Comment ajouter des variations

### Méthode 1 : Modifier le fichier IALanguage.php

Ouvrir `app/Core/IALanguage.php` et ajouter des entrées dans les tableaux correspondants :

```php
private static $dashboardMessages = [
    'excellence' => [
        [
            'title' => '🌌 Nouveau Titre',
            'message' => "Nouveau message avec <strong>{name}</strong>.",
            'icon' => '🌟'
        ],
        // ... autres variations
    ]
];
```

### Méthode 2 : Ajouter dynamiquement (dans un contrôleur)

```php
use App\Core\IALanguage;

// Ajouter une variation de dashboard
IALanguage::addDashboardVariation(
    'excellence',
    '🌌 Titre Custom',
    "Message personnalisé pour <strong>{name}</strong>.",
    '✨'
);

// Ajouter une intervention de chat
IALanguage::addChatIntervention(
    'welcome',
    "Nouveau message d'accueil personnalisé."
);
```

## 📝 Exemples d'enrichissement

### Exemple 1 : Ajouter un message de dashboard

```php
IALanguage::addDashboardVariation(
    'excellent',
    '🌸 Architecte d\'Harmonies',
    "Votre capacité à créer des ponts est inspirante, <strong>{name}</strong>. Chaque connexion que vous établissez enrichit l'écosystème de manière significative.",
    '🌸'
);
```

### Exemple 2 : Ajouter une intervention de chat

```php
IALanguage::addChatIntervention(
    'progress_mid',
    "Je constate une évolution remarquable dans vos échanges. La compréhension mutuelle se développe harmonieusement."
);
```

## 🎨 Bonnes pratiques

### Style de langage ASTRÆA

✅ **À faire :**
- Ton bienveillant et poétique
- Vocabulaire cosmique/galactique
- Métaphores naturelles (jardins, écosystèmes, lumière)
- Inclusivité (formes neutres en français)
- Valorisation des efforts

❌ **À éviter :**
- Langage trop technique/robotique
- Jugements négatifs directs
- Répétitions exactes
- Ton moralisateur
- Références contemporaines hors contexte

### Exemples de formulations

**Bon :**
> "Votre présence illumine l'écosystème, [Nom]. Les connexions que vous tissez propagent des ondes d'harmonie."

**Moins bon :**
> "Vous avez un bon score. Continuez comme ça."

## 🔄 Synchronisation Frontend/Backend

Les interventions de chat sont dupliquées dans le JavaScript (`app/Views/chat/conversation.php`) pour l'AJAX.

**Après modification du backend, mettre à jour :**

```javascript
const iaMessages = {
    welcome: [
        "Message 1",
        "Message 2",
        "Message 3 (NOUVEAU)"
    ]
};
```

## 📊 Statistiques actuelles

| Contexte | Variations | Total |
|----------|-----------|-------|
| Dashboard | 5 niveaux × 3 | 15 messages |
| Chat | 6 contextes × 3 | 18 messages |
| Résultats | 4 types × 3 | 12 messages |
| Analyse | 2 étapes × 3 | 6 messages |
| **TOTAL** | | **51 messages** |

## 🚀 Suggestions d'enrichissement

### Variations saisonnières
Ajouter des messages thématiques selon les événements cosmiques :
- Équinoxes
- Solstices
- Conjonctions planétaires

### Variations selon l'heure
Messages différents selon le moment de la journée :
- Matin : énergie montante
- Après-midi : plénitude
- Soirée : introspection
- Nuit : contemplation

### Variations selon la langue
Adapter les métaphores selon les références culturelles des utilisateurs.

## 🛠️ Exemple complet

Fichier : `app/Controllers/CustomIAMessages.php`

```php
<?php

namespace App\Controllers;

use App\Core\IALanguage;

class CustomIAMessages
{
    public static function registerSeasonalMessages()
    {
        // Messages de printemps
        IALanguage::addDashboardVariation(
            'excellent',
            '🌸 Jardinier·ère du Printemps Cosmique',
            "Comme les bourgeons éclosent, vos connexions fleurissent, <strong>{name}</strong>. Le renouveau que vous apportez est précieux.",
            '🌸'
        );

        // Messages d'été
        IALanguage::addDashboardVariation(
            'excellent',
            '☀️ Rayon de Soleil Interespèce',
            "Votre chaleur humaine réchauffe l'écosystème, <strong>{name}</strong>. Les liens que vous créez rayonnent comme des soleils.",
            '☀️'
        );

        // Interventions nocturnes
        IALanguage::addChatIntervention(
            'welcome',
            "Les étoiles brillent sur cet échange nocturne. Que vos mots soient doux comme la lumière lunaire."
        );
    }
}

// Enregistrer au démarrage de l'application
CustomIAMessages::registerSeasonalMessages();
```

## 📞 API complète

```php
// Obtenir un message de dashboard
$message = IALanguage::getDashboardMessage('excellent', 'NomUtilisateur');

// Obtenir une intervention de chat
$intervention = IALanguage::getChatIntervention('welcome');

// Obtenir un message d'analyse
$analysis = IALanguage::getAnalysisMessage('analyzing');

// Obtenir un message de résultat
$result = IALanguage::getLinkResultMessage('harmonious');

// Ajouter une variation de dashboard
IALanguage::addDashboardVariation($type, $title, $message, $icon);

// Ajouter une intervention de chat
IALanguage::addChatIntervention($context, $message);
```

## 🎯 Objectifs futurs

- [ ] Système de personnalisation par profil utilisateur
- [ ] Messages adaptatifs selon l'historique
- [ ] Intégration d'un moteur de génération de texte
- [ ] Traductions multilingues
- [ ] Analyse sentimentale pour adapter le ton

---

**Contribuez à enrichir le langage d'ASTRÆA pour une expérience toujours plus immersive ! 🌌✨**

