<?php

namespace App\Core;

/**
 * Gestionnaire du langage de l'IA (ASTRÆA)
 * Fournit des variations aléatoires de messages selon le contexte
 */
class IALanguage
{
    /**
     * Messages pour le tableau de bord selon le score diplomatique
     */
    private static $dashboardMessages = [
        'excellence' => [
            [
                'title' => '🌌 Ambassadeur·ice Cosmique',
                'message' => "Votre contribution renforce l'équilibre galactique, <strong>{name}</strong>. Vous incarnez l'harmonie interespèce et inspirez de nombreux voyageurs. L'écosystème rayonne grâce à votre présence.",
                'icon' => '🌟'
            ],
            [
                'title' => '✨ Gardien·ne de l\'Harmonie',
                'message' => "Votre présence est un phare dans l'écosystème, <strong>{name}</strong>. Chaque connexion que vous établissez propage des ondes d'harmonie. Les archives cosmiques célèbrent votre engagement.",
                'icon' => '🌟'
            ],
            [
                'title' => '🌠 Tisserand·e d\'Alliances',
                'message' => "Vous êtes devenu·e une légende vivante, <strong>{name}</strong>. Votre diplomatie transcende les frontières spatiales. L'univers entier bénéficie de votre sagesse.",
                'icon' => '✨'
            ],
            [
                'title' => '💫 Catalyseur·euse d\'Unité',
                'message' => "Votre essence même transforme les rencontres en alliances durables, <strong>{name}</strong>. Vous êtes un modèle d'excellence diplomatique. Les civilisations futures étudieront votre parcours.",
                'icon' => '🌟'
            ],
            [
                'title' => '🌟 Maître·sse des Ponts Stellaires',
                'message' => "L'harmonie galactique s'intensifie à votre passage, <strong>{name}</strong>. Vous avez atteint une maîtrise remarquable de l'art de la connexion interespèce. Votre impact est mesurable à l'échelle cosmique.",
                'icon' => '✨'
            ]
        ],
        'excellent' => [
            [
                'title' => '🌿 Bâtisseur·se de Ponts',
                'message' => "Votre diplomatie est remarquable, <strong>{name}</strong>. Vous tissez des liens authentiques entre les mondes. Votre engagement enrichit l'écosystème solarpunk.",
                'icon' => '✨'
            ],
            [
                'title' => '🌸 Cultivateur·ice de Liens',
                'message' => "Vos actions créent des résonances positives, <strong>{name}</strong>. Les connexions que vous établissez portent des fruits durables. L'harmonie croît là où vous passez.",
                'icon' => '🌿'
            ],
            [
                'title' => '💫 Médiateur·ice Éclairé·e',
                'message' => "Votre sensibilité diplomatique est exemplaire, <strong>{name}</strong>. Vous comprenez les nuances de chaque civilisation. Votre contribution est précieuse pour l'écosystème.",
                'icon' => '✨'
            ],
            [
                'title' => '🌺 Artisan·e d\'Harmonies',
                'message' => "Chaque rencontre que vous initiez devient une œuvre d'art relationnelle, <strong>{name}</strong>. Votre talent pour créer des connexions authentiques est reconnu dans tout l'écosystème.",
                'icon' => '🌸'
            ],
            [
                'title' => '🍃 Navigateur·ice des Consciences',
                'message' => "Vous savez lire entre les essences et créer des ponts là où d'autres voient des gouffres, <strong>{name}</strong>. Votre approche empathique fait de vous un·e diplomate d'exception.",
                'icon' => '🌿'
            ]
        ],
        'good' => [
            [
                'title' => '🌱 Explorateur·ice Engagé·e',
                'message' => "Vous progressez avec intention, <strong>{name}</strong>. Chaque connexion que vous cultivez contribue à l'harmonie collective. Continuez sur cette voie.",
                'icon' => '🌸'
            ],
            [
                'title' => '🌾 Voyageur·se Conscient·e',
                'message' => "Votre parcours témoigne d'une volonté sincère, <strong>{name}</strong>. Les graines que vous semez aujourd'hui fleuriront demain. L'écosystème vous soutient.",
                'icon' => '🌱'
            ],
            [
                'title' => '🌺 Artisan·e de Connexions',
                'message' => "Votre approche est équilibrée et réfléchie, <strong>{name}</strong>. Vous comprenez l'importance de chaque rencontre. Vos efforts portent leurs fruits.",
                'icon' => '🌸'
            ],
            [
                'title' => '🌻 Semeur·euse d\'Alliances',
                'message' => "Votre contribution, bien que discrète, crée des ondulations positives dans l'écosystème, <strong>{name}</strong>. Chaque pas compte, chaque lien nourrit le tout.",
                'icon' => '🌱'
            ],
            [
                'title' => '🪴 Cultivateur·ice Patient·e',
                'message' => "Vous comprenez que l'harmonie se construit progressivement, <strong>{name}</strong>. Votre patience et votre constance sont des qualités précieuses. Le chemin que vous tracez est solide.",
                'icon' => '🌾'
            ]
        ],
        'emerging' => [
            [
                'title' => '🌾 Voyageur·se en Éveil',
                'message' => "Vos premiers pas sont encourageants, <strong>{name}</strong>. L'écosystème s'ouvre à vous. Prenez le temps d'explorer les connexions possibles.",
                'icon' => '🌿'
            ],
            [
                'title' => '🌿 Apprenti·e Diplomate',
                'message' => "Vous découvrez les subtilités de l'harmonie interespèce, <strong>{name}</strong>. Chaque interaction est une opportunité d'apprentissage. Restez curieux·se.",
                'icon' => '🌱'
            ],
            [
                'title' => '🌱 Nouvelle Pousse',
                'message' => "Votre trajectoire commence à se dessiner, <strong>{name}</strong>. Les premières connexions sont souvent les plus formatrices. Continuez d'explorer.",
                'icon' => '🌾'
            ],
            [
                'title' => '🍀 Pionnier·ère Prudent·e',
                'message' => "Vous découvrez les mécanismes de l'harmonie cosmique, <strong>{name}</strong>. Chaque rencontre vous enseigne quelque chose de nouveau. La curiosité est votre meilleure alliée.",
                'icon' => '🌱'
            ],
            [
                'title' => '🌿 Explorateur·ice des Premiers Liens',
                'message' => "Le voyage diplomatique débute, <strong>{name}</strong>. Les fondations que vous posez maintenant détermineront vos futures harmonies. Avancez avec ouverture.",
                'icon' => '🌾'
            ]
        ],
        'beginning' => [
            [
                'title' => '🌱 Nouveau·lle Arrivant·e',
                'message' => "Bienvenue dans l'écosystème, <strong>{name}</strong>. Votre voyage ne fait que commencer. ASTRÆA vous accompagne dans vos premières rencontres.",
                'icon' => '🌱'
            ],
            [
                'title' => '🌾 Premier Pas Cosmique',
                'message' => "L'univers s'ouvre devant vous, <strong>{name}</strong>. Chaque grand voyage commence par une première rencontre. Laissez-vous guider par la curiosité.",
                'icon' => '🌱'
            ],
            [
                'title' => '🌿 Graine d\'Harmonie',
                'message' => "Vous entrez dans un écosystème bienveillant, <strong>{name}</strong>. Les premières impressions sont importantes. Prenez le temps de vous acclimater.",
                'icon' => '🌱'
            ],
            [
                'title' => '🌱 Essence Naissante',
                'message' => "Votre présence enrichit déjà l'écosystème, <strong>{name}</strong>. Les débuts sont toujours porteurs de potentiel. Explorez sans hâte, l'univers vous attend.",
                'icon' => '🌾'
            ],
            [
                'title' => '🍃 Voyageur·se de l\'Aube',
                'message' => "Le premier chapitre de votre odyssée diplomatique s'écrit maintenant, <strong>{name}</strong>. Chaque interaction façonnera votre compréhension de l'harmonie interespèce.",
                'icon' => '🌱'
            ]
        ]
    ];

    /**
     * Interventions IA dans le chat selon le contexte
     */
    private static $chatInterventions = [
        'welcome' => [
            "Bienvenue dans cet espace d'échange. Prenez le temps de vous découvrir mutuellement.",
            "Cet espace est dédié à votre connexion. Laissez la conversation se déployer naturellement.",
            "Vous entrez dans un lieu d'échange authentique. ASTRÆA veille à l'harmonie de vos échanges.",
            "Le dialogue s'ouvre entre vos deux essences. Exprimez-vous avec authenticité et ouverture.",
            "Ce canal de communication est maintenant actif. Que vos mots reflètent votre véritable nature."
        ],
        'progress_early' => [
            "Les premiers échanges sont prometteurs. Continuez à cultiver cette connexion avec authenticité.",
            "Votre dialogue s'établit harmonieusement. Les bases d'une connexion solide se dessinent.",
            "Je perçois une résonance positive entre vous. Cette relation a du potentiel.",
            "Les premières vibrations sont encourageantes. Vous créez ensemble un espace de confiance.",
            "Votre communication trouve naturellement son rythme. C'est un excellent signe de compatibilité."
        ],
        'progress_mid' => [
            "Votre dialogue s'approfondit. La confiance se construit progressivement.",
            "Les échanges gagnent en profondeur. Vous apprenez à vous connaître mutuellement.",
            "Une compréhension mutuelle émerge. Cette connexion se renforce à chaque message.",
            "Je constate une évolution remarquable dans vos échanges. Les barrières s'estompent naturellement.",
            "Vos fréquences s'harmonisent. Le dialogue atteint un niveau de qualité notable."
        ],
        'progress_complete' => [
            "Vous avez établi un lien significatif. L'harmonie entre vous atteint son apogée.",
            "Cette connexion a mûri admirablement. Vous avez franchi un seuil important.",
            "Votre relation témoigne d'une harmonie profonde. C'est un modèle d'échange interespèce.",
            "Le niveau de compréhension atteint est remarquable. Vous avez co-créé une connexion d'exception.",
            "Votre dialogue a transcendé les différences. Cette alliance est maintenant pleinement établie."
        ],
        'warning_hostile' => [
            "⚠️ Attention : certaines expressions peuvent être perçues comme hostiles. Privilégiez un langage constructif.",
            "⚠️ Je détecte une tension dans les mots. Reformulez avec bienveillance pour préserver l'harmonie.",
            "⚠️ Cette formulation pourrait créer un malentendu. Optez pour une communication plus douce.",
            "⚠️ Alerte diplomatique : le ton employé risque de générer un conflit. Recentrez-vous sur l'intention positive.",
            "⚠️ Je perçois une dissonance potentielle. Reformulez pour favoriser la compréhension mutuelle."
        ],
        'revelation' => [
            "La compréhension mutuelle atteint un seuil suffisant. Révélation autorisée.",
            "Le niveau de confiance permet désormais la révélation. Vous êtes prêt·e·s.",
            "Les échanges ont prouvé la solidité de votre connexion. La révélation est accordée.",
            "Le voile peut maintenant tomber. Vous avez démontré une harmonie suffisante pour cette étape.",
            "La maturité de votre dialogue justifie la révélation. Le moment est venu."
        ]
    ];

    /**
     * Messages pour l'analyse de profil
     */
    private static $analysisMessages = [
        'analyzing' => [
            "J'analyse les harmoniques de votre essence cosmique...",
            "Je scanne les fréquences de votre signature galactique...",
            "Je cartographie les dimensions de votre profil interespèce...",
            "Décodage des paramètres de votre signature en cours...",
            "J'évalue la résonance de votre essence avec l'écosystème..."
        ],
        'validating' => [
            "Votre profil résonne avec l'écosystème. Validation en cours...",
            "Les paramètres sont harmonieux. Intégration dans la matrice cosmique...",
            "Votre signature est unique et compatible. Finalisation de l'enregistrement...",
            "Votre essence a été authentifiée. Inscription dans les archives galactiques...",
            "Les données sont cohérentes. Je vous intègre dans le réseau d'harmonies..."
        ]
    ];
    
    /**
     * Messages d'adieu lors de la déconnexion
     */
    private static $farewellMessages = [
        [
            'message' => "Votre présence a enrichi l'écosystème, {name}. Les connexions que vous avez tissées continuent de résonner.",
            'subtitle' => "À bientôt, voyageur·se cosmique."
        ],
        [
            'message' => "Que votre chemin soit lumineux, {name}. L'harmonie galactique vous accompagne où que vous alliez.",
            'subtitle' => "Les étoiles vous attendent pour votre prochain retour."
        ],
        [
            'message' => "Merci d'avoir contribué à l'équilibre interespèce, {name}. Votre essence reste gravée dans nos archives.",
            'subtitle' => "Revenez quand les constellations vous appelleront."
        ],
        [
            'message' => "Le voyage continue ailleurs, {name}. Que vos prochaines rencontres soient aussi riches que celles vécues ici.",
            'subtitle' => "L'écosystème vous garde une place."
        ],
        [
            'message' => "Vous emportez avec vous les harmonies créées, {name}. Elles brilleront dans votre trajectoire future.",
            'subtitle' => "À la prochaine synchronicité cosmique."
        ],
        [
            'message' => "Votre énergie a laissé une empreinte positive, {name}. L'univers se souviendra de votre passage.",
            'subtitle' => "Que la lumière guide votre retour."
        ],
        [
            'message' => "Chaque départ est une graine d'un futur retour, {name}. Vous faites partie de cette famille galactique.",
            'subtitle' => "L'écosystème pulse en attendant votre retour."
        ]
    ];

    /**
     * Messages de narration pour la page des suggestions de matchs
     */
    private static $matchNarrationMessages = [
        "Bienvenue dans l'espace des harmonies cosmiques. J'ai analysé les compatibilités entre votre essence et celle d'autres voyageurs. Chaque rencontre est unique, certaines seront fluides, d'autres vous défieront.",
        "J'ai scanné l'écosystème pour identifier les voyageurs qui résonnent avec votre signature galactique. Les connexions proposées sont le fruit d'une analyse minutieuse.",
        "Votre profil a été confronté aux énergies de l'écosystème. Les harmonies que je vous présente reflètent différents potentiels de connexion.",
        "L'analyse des compatibilités révèle plusieurs chemins possibles. Certains liens seront naturels, d'autres nécessiteront davantage d'efforts diplomatiques.",
        "J'ai cartographié les résonances entre votre fréquence et celles des autres voyageurs. Les suggestions suivantes méritent votre attention.",
        "Votre essence a été comparée aux signatures galactiques présentes. Chaque proposition représente une opportunité unique d'harmonie.",
        "Les algorithmes cosmiques ont identifié ces voyageurs comme potentiellement compatibles avec votre profil. Explorez chaque possibilité avec discernement."
    ];

    /**
     * Messages de narration pour la page des révélations
     */
    private static $revealedNarrationMessages = [
        "Voici vos harmonies révélées. Ces connexions mutuelles sont le fruit d'une acceptation réciproque. Vous pouvez maintenant échanger librement avec ces voyageurs.",
        "Les voiles sont levés. Ces alliances se sont révélées par un consentement mutuel. Vos échanges peuvent désormais s'épanouir pleinement.",
        "Ces connexions ont franchi le seuil de la révélation. La confiance mutuelle permet maintenant une communication authentique.",
        "Les harmonies que vous voyez ici ont traversé l'épreuve de l'acceptation mutuelle. Ces liens sont maintenant actifs et accessibles.",
        "Ces alliances ont été scellées par un accord bilatéral. Les masques tombent, les essences se dévoilent. La vraie rencontre peut commencer.",
        "Vous contemplez les liens qui ont survécu au processus de sélection mutuelle. Ces connexions sont prêtes à s'épanouir pleinement.",
        "Le consensus a été atteint. Ces voyageurs ont choisi de vous révéler leur forme véritable, comme vous avez choisi la leur."
    ];

    /**
     * Messages de narration pour la page détail d'un match
     */
    private static $matchDetailNarrationMessages = [
        "Je vous présente une entité fascinante, {name}. Laissez-vous guider par l'essence de cette connexion potentielle.",
        "Voici {name}, un·e voyageur·se dont les fréquences résonnent avec les vôtres. Prenez le temps d'explorer cette possibilité.",
        "{name} émerge comme une connexion potentielle. Les analyses suggèrent une harmonie à explorer.",
        "L'entité {name} a été identifiée comme compatible avec votre essence. Cette rencontre mérite votre attention.",
        "Permettez-moi de vous introduire à {name}. Les paramètres de compatibilité indiquent une opportunité intéressante.",
        "La signature de {name} présente des convergences avec la vôtre. Découvrez les détails de cette harmonie potentielle.",
        "{name} a attiré mon attention lors de l'analyse. Cette rencontre pourrait enrichir votre parcours cosmique."
    ];

    /**
     * Messages pour "aucun match disponible"
     */
    private static $noMatchMessages = [
        [
            'title' => 'Aucune harmonie détectée pour le moment',
            'description' => "L'écosystème est encore jeune. Revenez bientôt pour découvrir de nouvelles connexions."
        ],
        [
            'title' => 'Patience cosmique',
            'description' => "Les voyageurs compatibles n'ont pas encore rejoint l'écosystème. Les étoiles s'aligneront bientôt."
        ],
        [
            'title' => 'L\'attente fait partie du voyage',
            'description' => "De nouvelles essences arrivent régulièrement dans l'écosystème. Votre harmonie se manifestera au moment opportun."
        ],
        [
            'title' => 'L\'univers prépare vos rencontres',
            'description' => "Les synchronicités se mettent en place. Les voyageurs compatibles avec votre essence rejoindront bientôt l'écosystème."
        ],
        [
            'title' => 'En attente de résonances',
            'description' => "Votre signature galactique est unique. Je continue de scanner l'horizon pour identifier les harmonies correspondantes."
        ]
    ];

    /**
     * Descriptions de compatibilité selon le type
     */
    private static $compatibilityDescriptions = [
        'harmonious' => [
            'Cette rencontre offre une compatibilité naturelle. Vos environnements et valeurs s\'alignent pour créer une synergie positive.',
            'Une connexion fluide se profile. Vos essences vibrent sur des fréquences harmoniques. Cette alliance est prometteuse.',
            'Les paramètres convergent admirablement. Cette rencontre pourrait s\'épanouir sans friction majeure.',
            'Je détecte une harmonie spontanée entre vos signatures. Les conditions sont idéales pour une relation épanouissante.',
            'Vos énergies se complètent naturellement. Cette compatibilité suggère une relation harmonieuse et durable.',
            'Les analyses révèlent un potentiel d\'alliance exceptionnel. Vos différences s\'entrelacent en synergie plutôt qu\'en conflit.'
        ],
        'unstable' => [
            'Cette connexion présente des défis, mais peut apporter une croissance mutuelle significative. L\'adaptation sera nécessaire.',
            'Une relation complexe mais stimulante. Les tensions peuvent devenir des forces si vous acceptez la différence.',
            'Les énergies oscillent entre convergence et divergence. Cette instabilité peut générer une dynamique créative.',
            'Un équilibre délicat à trouver. Les frictions sont présentes, mais elles peuvent catalyser une évolution mutuelle enrichissante.',
            'Cette alliance requiert de la flexibilité. Les zones de friction coexistent avec des espaces d\'harmonie. Le résultat dépendra de votre investissement.',
            'Je perçois des turbulences potentielles, mais aussi des opportunités de croissance. Cette relation sera un défi constructif.'
        ],
        'improbable' => [
            'Une rencontre peu conventionnelle qui pourrait mener à des découvertes inattendues. L\'issue reste incertaine.',
            'Cette alliance défie les probabilités statistiques. Si elle fonctionne, elle sera exceptionnelle. Sinon, elle restera une expérience.',
            'Les paramètres suggèrent une incompatibilité, mais l\'imprévisible garde ses droits. Cette connexion est une énigme.',
            'Une configuration atypique qui intrigue mes algorithmes. Cette rencontre pourrait surprendre par son évolution inattendue.',
            'Les données ne permettent pas de prédiction fiable. Cette alliance entre dans le territoire de l\'expérimentation cosmique.',
            'Une probabilité faible ne signifie pas l\'impossibilité. Cette connexion improbable pourrait défier toutes les attentes.'
        ],
        'dangerous' => [
            'Cette interaction comporte des risques significatifs. Les différences fondamentales peuvent créer des tensions importantes.',
            'Alerte diplomatique : les divergences sont profondes. Sans précaution, cette relation pourrait générer des conflits.',
            'Les fréquences s\'opposent fortement. Une approche très prudente est recommandée si vous souhaitez explorer cette connexion.',
            'Zone de turbulence détectée. Les incompatibilités sont majeures. Une médiation sera probablement nécessaire pour maintenir l\'harmonie.',
            'Je vous mets en garde : cette alliance présente des risques élevés de dissonance. Procédez avec une extrême vigilance.',
            'Les paramètres indiquent un potentiel de conflit important. Si vous choisissez d\'explorer cette voie, restez en alerte constante.'
        ]
    ];

    /**
     * Messages pour les résultats de lien
     */
    private static $linkResultMessages = [
        'harmonious' => [
            "ASTRÆA observe une convergence exceptionnelle. Les énergies se complètent naturellement. Cette harmonie est rare et précieuse.",
            "Je détecte une synergie remarquable entre vos essences. Cette alliance est prometteuse pour l'écosystème.",
            "Vos fréquences vibrent à l'unisson. C'est une connexion d'une qualité exceptionnelle.",
            "L'harmonie entre vous dépasse mes prévisions initiales. Cette relation est un exemple de compatibilité parfaite.",
            "Les énergies s'entrelacent sans résistance. Vous avez trouvé une harmonie cosmique authentique.",
            "Cette connexion rayonne d'une lumière particulière. Les paramètres d'harmonie sont optimaux."
        ],
        'complex' => [
            "ASTRÆA détecte des frictions créatives. Cette relation demande un engagement conscient, mais peut mener à une croissance mutuelle significative.",
            "Je perçois des tensions productives. Avec de l'attention, ces différences peuvent devenir des forces complémentaires.",
            "Votre connexion nécessite un travail diplomatique. Les défis présents sont surmontables avec intention.",
            "Les zones de turbulence cohabitent avec des espaces d'harmonie. Cette complexité peut être transformée en richesse relationnelle.",
            "Une danse délicate entre attraction et friction. Cette relation nécessite une navigation consciente mais offre un potentiel de transformation.",
            "Les paramètres indiquent une instabilité contrôlable. Avec de l'engagement mutuel, ces défis deviendront des opportunités."
        ],
        'risky' => [
            "ASTRÆA recommande une approche prudente. Les divergences sont profondes. Un accompagnement spécialisé est nécessaire pour éviter les conflits.",
            "Je détecte des incompatibilités fondamentales. Sans médiation, cette relation pourrait générer des dissonances.",
            "Les énergies sont en tension. Une intervention de ma part est fortement conseillée pour naviguer cette complexité.",
            "Alerte maximale : les risques de conflit sont élevés. Cette relation nécessite un encadrement diplomatique constant.",
            "Les fréquences s'opposent sur des aspects cruciaux. Sans médiation active, l'harmonie sera difficile à maintenir.",
            "Je préconise une extrême vigilance. Les incompatibilités détectées peuvent créer des situations critiques."
        ],
        'historic' => [
            "ASTRÆA enregistre cette union dans les archives cosmiques. Vous êtes devenus un modèle d'harmonie interespèce. Votre lien inspire d'autres voyageurs.",
            "Cette alliance transcende les attentes initiales. Vous avez co-créé quelque chose d'unique dans l'écosystème.",
            "Votre relation est désormais une référence. Les données que vous générez enrichissent notre compréhension des connexions profondes.",
            "Un événement remarquable dans l'histoire de l'écosystème. Votre alliance devient un cas d'étude pour les générations futures.",
            "Cette connexion a atteint un niveau de maturité exceptionnel. Vous avez bâti une alliance qui servira d'inspiration à tout l'écosystème.",
            "Les archives cosmiques célèbrent cette union. Vous avez dépassé toutes les projections statistiques. Votre lien est historique."
        ]
    ];

    /**
     * Sélectionner un message aléatoire selon le contexte
     */
    public static function getDashboardMessage($scoreType, $name)
    {
        if (!isset(self::$dashboardMessages[$scoreType])) {
            $scoreType = 'beginning';
        }

        $messages = self::$dashboardMessages[$scoreType];
        $selected = $messages[array_rand($messages)];

        return [
            'type' => $scoreType,
            'title' => $selected['title'],
            'message' => str_replace('{name}', $name, $selected['message']),
            'icon' => $selected['icon']
        ];
    }

    /**
     * Obtenir une intervention de chat aléatoire selon le contexte
     */
    public static function getChatIntervention($context)
    {
        if (!isset(self::$chatInterventions[$context])) {
            return null;
        }

        $messages = self::$chatInterventions[$context];
        return $messages[array_rand($messages)];
    }

    /**
     * Obtenir un message d'analyse aléatoire
     */
    public static function getAnalysisMessage($step)
    {
        if (!isset(self::$analysisMessages[$step])) {
            return "Analyse en cours...";
        }

        $messages = self::$analysisMessages[$step];
        return $messages[array_rand($messages)];
    }

    /**
     * Obtenir un message de résultat de lien aléatoire
     */
    public static function getLinkResultMessage($resultType)
    {
        if (!isset(self::$linkResultMessages[$resultType])) {
            return "ASTRÆA analyse votre connexion...";
        }

        $messages = self::$linkResultMessages[$resultType];
        return $messages[array_rand($messages)];
    }

    /**
     * Ajouter dynamiquement des variations (pour enrichir le langage)
     */
    public static function addDashboardVariation($scoreType, $title, $message, $icon)
    {
        if (!isset(self::$dashboardMessages[$scoreType])) {
            self::$dashboardMessages[$scoreType] = [];
        }

        self::$dashboardMessages[$scoreType][] = [
            'title' => $title,
            'message' => $message,
            'icon' => $icon
        ];
    }

    /**
     * Ajouter une variation d'intervention de chat
     */
    public static function addChatIntervention($context, $message)
    {
        if (!isset(self::$chatInterventions[$context])) {
            self::$chatInterventions[$context] = [];
        }

        self::$chatInterventions[$context][] = $message;
    }

    /**
     * Obtenir un message de narration aléatoire pour la page des matchs
     */
    public static function getMatchNarration()
    {
        return self::$matchNarrationMessages[array_rand(self::$matchNarrationMessages)];
    }

    /**
     * Obtenir un message "aucun match" aléatoire
     */
    public static function getNoMatchMessage()
    {
        $messages = self::$noMatchMessages;
        return $messages[array_rand($messages)];
    }

    /**
     * Obtenir une description de compatibilité aléatoire selon le type
     */
    public static function getCompatibilityDescription($type)
    {
        if (!isset(self::$compatibilityDescriptions[$type])) {
            return "Analyse en cours...";
        }

        $descriptions = self::$compatibilityDescriptions[$type];
        return $descriptions[array_rand($descriptions)];
    }

    /**
     * Obtenir un message de narration aléatoire pour la page des révélations
     */
    public static function getRevealedNarration()
    {
        return self::$revealedNarrationMessages[array_rand(self::$revealedNarrationMessages)];
    }

    /**
     * Obtenir un message de narration aléatoire pour la page détail (avec remplacement du nom)
     */
    public static function getMatchDetailNarration($name)
    {
        $messages = self::$matchDetailNarrationMessages;
        $selected = $messages[array_rand($messages)];
        return str_replace('{name}', $name, $selected);
    }
    
    /**
     * Obtenir un message d'adieu personnalisé
     * @param string $name Nom galactique de l'utilisateur
     * @return array ['message' => string, 'subtitle' => string]
     */
    public static function getFarewellMessage($name = 'Voyageur')
    {
        $farewell = self::$farewellMessages[array_rand(self::$farewellMessages)];
        
        return [
            'message' => str_replace('{name}', $name, $farewell['message']),
            'subtitle' => $farewell['subtitle']
        ];
    }
}

