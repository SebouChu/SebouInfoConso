Auth middleware to access the app.

- Root : HomeController#index
- Repas : MealsController scaffolded (index, show, create, store, edit, update & destroy)
- Produits : ProductsController scaffolded + search
  - Search : via OpenFoodFacts API : code barre -> infos produit. Méthode appelée par XHR. LoadProductInfoFromAPI as private

# Modèles

**Meal**

    ====================
    Schema : Meal
    ====================

    id              integer         primary key
    date            date
    type            integer         (0 = BREAKFAST, 1 = LUNCH, 2 = SNACK, 3 = DINNER)
    user_id         integer         reference to users.id
    created_at      datetime
    updated_at      datetime

Product
- id:integer (PK)
- name:string
- image:string
- barcode:string
- energy:integer -> en kcal

Via API : `data["product"]["nutriments"]["energy_serving"]` & unité `data["product"]["nutriments"]["energy_unit"]`

MealsProducts
- meal_id (PFK)
- product_id (PFK)
- quantity:integer -> en g.