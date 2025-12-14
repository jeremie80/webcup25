# Tests Unitaires - IAstroMatch

## Structure des tests

```
tests/
├── Models/              # Tests des modèles
│   ├── UserTest.php
│   ├── ProfileTest.php
│   └── MatchModelTest.php
├── Controllers/         # Tests des contrôleurs
│   └── MatchControllerTest.php
├── Core/               # Tests du core
│   ├── RouterTest.php
│   └── DatabaseTest.php
├── Integration/        # Tests d'intégration
│   └── MatchingFlowTest.php
└── ExampleTest.php     # Tests d'exemple
```

## Exécution des tests

### Tous les tests
```bash
vendor/bin/phpunit
```

### Tests d'un dossier spécifique
```bash
vendor/bin/phpunit tests/Models
```

### Test d'un fichier spécifique
```bash
vendor/bin/phpunit tests/Models/UserTest.php
```

### Avec couverture de code
```bash
vendor/bin/phpunit --coverage-html coverage
```

## Types de tests

### 1. Tests de validation (Models)
- Validation des données d'entrée
- Vérification des contraintes (longueur, enum, etc.)
- Tests des méthodes getter

### 2. Tests de logique métier (Controllers)
- Calcul de compatibilité
- Génération de suggestions
- Mapping des types/emojis/labels

### 3. Tests d'architecture (Core)
- Pattern Singleton (Database)
- Routing
- Configuration

### 4. Tests d'intégration
- Flux complet de matching
- Interactions entre modèles
- Scénarios utilisateur

## Configuration

Le fichier `phpunit.xml.dist` configure :
- **Bootstrap** : `vendor/autoload.php`
- **Environnement** : `APP_ENV=testing`
- **Base de données de test** : `webcup25_test`
- **Couverture** : Dossier `app/` (sauf `Views/`)

## Bonnes pratiques

1. **Nommage** : `test{MethodName}{Scenario}`
2. **Arrange-Act-Assert** : Structure claire des tests
3. **Isolation** : Chaque test est indépendant
4. **Mock** : Utiliser des mocks pour les dépendances externes
5. **Assertions** : Une assertion principale par test

## Tests à implémenter (TODO)

- [ ] Tests avec base de données réelle (tests d'intégration)
- [ ] Tests des méthodes CRUD complètes
- [ ] Tests des sessions et authentification
- [ ] Tests des uploads de fichiers
- [ ] Tests de performance (algorithme de matching)
- [ ] Tests de sécurité (injection SQL, XSS)

## Couverture de code cible

- **Modèles** : 80%+
- **Contrôleurs** : 70%+
- **Core** : 90%+
- **Global** : 75%+

