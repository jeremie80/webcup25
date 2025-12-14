# Charte graphique/DA

# Solarpunk : utopie lumineuse, nature hybride avec la technologie, énergies renouvelables, architectures organiques.

Solarpunk
Interface lumineuse, apaisante, respirante.
Couleurs naturelles, formes organiques, végétation intégrée au design.
La technologie est discrète, bienveillante, en harmonie avec l’environnement.
L’IA est empathique, pédagogique, orientée équilibre et durabilité.

DESIGN SYSTEM — IAstroMatch (Solarpunk)

## Philosophie Solarpunk (à respecter partout)

> La technologie ne domine pas. Elle accompagne.
> 
> 
> Elle est douce, vivante, empathique, intégrée à la nature.
> 

### Règles d’or

- ❌ Pas de noir pur
- ❌ Pas de gris froid
- ❌ Pas d’angles agressifs
- ✅ Lumière
- ✅ Air
- ✅ Courbes
- ✅ Respiration visuelle

## 1. Palette de couleurs (tokens)

### 🎋 Couleurs principales

```jsx
Primary / Life Green      #5FB3A2
Primary Soft              #A8E6CF

Solar Light               #F6F7EB
Solar Glow                #FFE8A3

Sky Blue                  #7EC8E3
Earth Sand                #E8DCC4

```

⚠️ Couleurs d’état (matching)

```jsx
Harmonious                #7ED957   (vert vivant)
Unstable                  #FFD166   (jaune doux)
Improbable                #9D8DF1   (violet lumineux)
Dangerous                 #F28482   (rouge désaturé)

```

### Règles d’utilisation

- Fond majoritairement **clair**
- Les couleurs d’état sont **translucides**
- Jamais de rouge agressif

## 🖋️ 2. Typographie (très importante)

### Police principale (texte)

- **Manrope** ou **Inter**
    - Humaniste
    - Lisible
    - Moderne mais douce

```jsx
font-family: 'Manrope', sans-serif;

```

### Police secondaire (titres / IA)

- **DM Sans**
- ou **Sora**

### Hiérarchie

- Titres : poids 500–600 (jamais bold extrême)
- Texte : poids 400
- IA : italique léger ou opacity réduite

## 3. Formes & composants

### Cards

- Rayon : `24px`
- Ombre : **très légère**
- Fond translucide

```jsx
border-radius: 24px;
background: rgba(255,255,255,0.8);
backdrop-filter: blur(8px);

```

### Boutons

- Forme pilule
- Pas de contour dur
- Animation douce

```jsx
Hauteur min : 48px
Rayon : 999px

```

## 4. Animations & micro-interactions

### Règles

- Toujours lentes
- Toujours organiques
- Jamais “snappy”

```jsx
Hover : 300ms
Transition page : 600–800ms
Chargement IA : progressif

```

Durées recommandées

```jsx
Hover : 300ms
Transition page : 600–800ms
Chargement IA : progressif

```

### Exemples

- Apparition par **fade + translate Y**
- Pulsation douce (opacity / scale 1.02)
- Cercles concentriques pour l’IA

## 5. Design de l’IA (ASTRÆA)

### Présence

- Toujours visible
- Jamais intrusive
- Parle peu mais bien

### Visuel

- Cercle lumineux
- Halo
- Particules lentes

### Texte IA

- Ton calme
- Jamais impératif
- Toujours explicatif

> “Cette interaction pourrait nécessiter une adaptation mutuelle.”
> 

## 6. UI par écran (règles clés)

### Écran d’intro

- Plein écran
- Texte centré
- Beaucoup de vide
- Animation lente

### Profils

- Champs espacés
- Aide IA sous chaque champ
- Icônes organiques

### Matching

- Cards flottantes
- Couleur d’état subtile
- Texte IA dominant

### Chat

- Bulles larges
- Pas de timestamp visible
- Interventions IA en italique

## 7. Iconographie

### Style

- Outline
- Arrondie
- Simple

### Libs conseillées

- **Lucide**
- **Phosphor Icons**

👉 Jamais d’icônes “tech” agressives

## 8. Design du score de compatibilité

❌ Pas de %

❌ Pas de jauge classique

### À la place

- Cercles
- Courbes
- Symboles

Exemple :

- 3 cercles alignés = équilibre
- cercle instable = tension
- cercle pulsant = danger