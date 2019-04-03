Auth middleware to access the app.

- Root : HomeController#index
- Repas : MealsController scaffolded (index, show, create, store, edit, update & destroy)
- Produits : ProductsController
  - Create : Formulaire d'ajout de Product à un Meal avec input du barcode
  - Store : Ajoute le Product au Meal.
    Workflow :
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
          
  - Destroy : Supprime le Product d'un Meal (pas de la db)
  - Search : via OpenFoodFacts API : code barre -> infos produit. Méthode appelée par XHR. LoadProductInfoFromAPI as private

- Sur un repas, CTA "ajouter un produit"
  -> Input Search Barcode
  -> Recherche du produit. 3 cas possibles :
    -> Produit trouvé :
        - si pas en base : on ajoute le produit à la DB. /!\ Récupération de la valeur énergétique : si kJ, recalculer en kcal
        - on ajoute au repas
    -> Produit non trouvé : on retourne à la page précédente avec une alerte 'Not found'
  -> Une fois la quantité renseignée, on ajoute un MealProduct

N.B. Une fois le product importé avec le barcode, il n'est plus supprimé de la DB, les données étant statiques et provenant de l'API OpenFoodFacts.

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

Via API : `data["product"]["nutriments"]["energy"]` & unité `data["product"]["nutriments"]["energy_unit"]`

Meals<=>Products Join Table
- meal_id (PFK)
- product_id (PFK)