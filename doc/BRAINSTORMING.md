# Partie Controller

Auth middleware to access the app.

- Root : `HomeController#index`
- Repas : `MealsController` scaffolded (index, show, create, store, edit, update & destroy)
- Produits :
  - `ProductsController`
    - Index : Liste de tous les Products importés
    - Show : Détails d'un Product avec image
  - `Meal\ProductsController`
    - Create : Formulaire d'ajout de Product à un Meal avec input du barcode
    - Store : Ajoute le Product au Meal.
    - Destroy : Supprime le Product d'un Meal (pas de la db)
    - *Private*
      - Search : via OpenFoodFacts API : code barre -> infos produit.
      - Import : Ajoute un Product trouvé via API dans la DB

# Infos complémentaires

- Une fois le product importé avec le barcode, il n'est plus supprimé de la DB, les données étant statiques et provenant de l'API OpenFoodFacts.
- Valeur énergétique via API :
  - Valeur : `data["product"]["nutriments"]["energy_value"]`
  - Unité : `data["product"]["nutriments"]["energy_unit"]`
- Workflow d'ajout de Product à un Meal :
  - Recherche du barcode dans la DB
  - Si trouvé
    - On ajoute le product au meal
  - Sinon
    - Recherche du barcode dans l'API
    - Si trouvé
      - On importe les données dans la DB
      - On ajoute le product au meal
    - Sinon
      - On ramène l'utilisateur sur le create avec une alerte 'not found'

- Requête pour dernière stat

```sql
SELECT `products`.`barcode`, `products`.`name`, `products`.`energy`, `meal_product`.`meal_id`
FROM `meals`
INNER JOIN `meal_product` ON `meal_product`.`meal_id` = `meals`.`id`
INNER JOIN `products` ON `meal_product`.`product_id` = `products`.`id`
WHERE `meals`.`user_id` = 1
```

# Modèles

**Meal**

    ====================
    Schema : Meal
    ====================

    id              integer         primary key
    date            date
    type            integer         (0 = Breakfast, 1 = Lunch, 2 = Snack, 3 = Dinner)
    user_id         integer         reference to users.id
    created_at      datetime
    updated_at      datetime

**Product**

    ====================
    Schema : Product
    ====================

    id              integer         primary key
    name            string
    image           string          
    barcode         string          
    energy          integer          
    created_at      datetime
    updated_at      datetime

**Meal & Product Join Table**

    ====================
    Table : meal_product
    ====================

    meal_id         integer         primary key / reference to meals.id
    product_id      integer         primary key / reference to products.id
