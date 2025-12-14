<?php

namespace App\Config;

use App\Core\IALanguage;

/**
 * Configuration personnalisée des messages de l'IA
 * 
 * Ce fichier permet d'enrichir facilement le langage d'ASTRÆA
 * sans modifier directement la classe IALanguage.
 * 
 * Pour activer : require ce fichier dans index.php ou un bootstrap
 */
class CustomIAMessages
{
    /**
     * Enregistrer tous les messages personnalisés
     */
    public static function register()
    {
        self::registerSeasonalMessages();
        self::registerTimeBasedMessages();
        self::registerSpecialEvents();
    }

    /**
     * Messages saisonniers (exemple)
     */
    private static function registerSeasonalMessages()
    {
        // Printemps (Mars-Mai)
        if (date('n') >= 3 && date('n') <= 5) {
            IALanguage::addDashboardVariation(
                'excellent',
                '🌸 Jardinier·ère du Printemps Cosmique',
                "Comme les bourgeons éclosent, vos connexions fleurissent, <strong>{name}</strong>. Le renouveau que vous apportez est précieux.",
                '🌸'
            );

            IALanguage::addChatIntervention(
                'welcome',
                "Le printemps cosmique éclaire cet espace. Que vos échanges bourgeonnent comme les premières fleurs."
            );
        }

        // Été (Juin-Août)
        if (date('n') >= 6 && date('n') <= 8) {
            IALanguage::addDashboardVariation(
                'excellent',
                '☀️ Rayon de Soleil Interespèce',
                "Votre chaleur illumine l'écosystème, <strong>{name}</strong>. Les liens que vous créez rayonnent comme des soleils.",
                '☀️'
            );
        }

        // Automne (Septembre-Novembre)
        if (date('n') >= 9 && date('n') <= 11) {
            IALanguage::addDashboardVariation(
                'excellent',
                '🍂 Gardien·ne des Récoltes Relationnelles',
                "Vos efforts portent leurs fruits, <strong>{name}</strong>. Les graines semées donnent naissance à de belles alliances.",
                '🍂'
            );
        }

        // Hiver (Décembre-Février)
        if (date('n') == 12 || date('n') <= 2) {
            IALanguage::addDashboardVariation(
                'excellent',
                '❄️ Étoile du Solstice',
                "Dans le calme hivernal, vos connexions brillent d'une lumière particulière, <strong>{name}</strong>. Vous réchauffez l'écosystème.",
                '❄️'
            );
        }
    }

    /**
     * Messages selon l'heure de la journée
     */
    private static function registerTimeBasedMessages()
    {
        $hour = (int)date('G'); // 0-23

        // Matin (6h-12h)
        if ($hour >= 6 && $hour < 12) {
            IALanguage::addChatIntervention(
                'welcome',
                "L'aube d'une nouvelle connexion se lève. Que ce matin apporte clarté et harmonie à vos échanges."
            );
        }

        // Après-midi (12h-18h)
        if ($hour >= 12 && $hour < 18) {
            IALanguage::addChatIntervention(
                'welcome',
                "L'après-midi est propice aux échanges profonds. Prenez le temps de vous découvrir pleinement."
            );
        }

        // Soirée (18h-22h)
        if ($hour >= 18 && $hour < 22) {
            IALanguage::addChatIntervention(
                'welcome',
                "La lumière du soir invite à l'introspection. Partagez vos réflexions en toute authenticité."
            );
        }

        // Nuit (22h-6h)
        if ($hour >= 22 || $hour < 6) {
            IALanguage::addChatIntervention(
                'welcome',
                "Les étoiles veillent sur cet échange nocturne. Que la douceur de la nuit guide vos mots."
            );
        }
    }

    /**
     * Messages pour événements spéciaux
     */
    private static function registerSpecialEvents()
    {
        // Nouvel An
        if (date('m-d') === '01-01') {
            IALanguage::addDashboardVariation(
                'excellence',
                '🎆 Architecte du Nouveau Cycle',
                "En ce nouveau cycle galactique, vous incarnez le renouveau, <strong>{name}</strong>. Votre contribution inspire l'écosystème entier.",
                '🎆'
            );
        }

        // Équinoxe de printemps (approx. 20 mars)
        if (date('m-d') === '03-20') {
            IALanguage::addDashboardVariation(
                'excellent',
                '⚖️ Harmonisateur·ice de l\'Équilibre',
                "En ce jour d'équilibre parfait, votre diplomatie résonne avec les cycles cosmiques, <strong>{name}</strong>.",
                '⚖️'
            );
        }

        // Solstice d'été (approx. 21 juin)
        if (date('m-d') === '06-21') {
            IALanguage::addChatIntervention(
                'progress_complete',
                "Le solstice célèbre votre union. Cette connexion atteint son apogée comme le soleil à son zénith."
            );
        }

        // Halloween / Samhain (31 octobre)
        if (date('m-d') === '10-31') {
            IALanguage::addChatIntervention(
                'welcome',
                "Le voile entre les mondes s'amincit. Vos échanges transcendent les frontières ordinaires."
            );
        }
    }

    /**
     * Exemples de messages pour des milestones utilisateur
     * (à appeler manuellement selon la logique métier)
     */
    public static function registerMilestoneMessages()
    {
        // Premier match révélé
        IALanguage::addChatIntervention(
            'revelation',
            "C'est votre première révélation cosmique. Ce moment est unique et précieux. Savourez-le pleinement."
        );

        // 10ème connexion
        IALanguage::addDashboardVariation(
            'excellent',
            '🏆 Vétéran·e des Connexions',
            "Dix alliances tissées, <strong>{name}</strong>. Votre expérience diplomatique est désormais reconnue dans l'écosystème.",
            '🏆'
        );

        // 100 messages échangés
        IALanguage::addChatIntervention(
            'progress_complete',
            "Cent messages partagés. Votre dialogue a franchi un seuil symbolique. Cette relation est maintenant profondément enracinée."
        );
    }
}

// Auto-enregistrement (décommenter pour activer automatiquement)
// CustomIAMessages::register();

