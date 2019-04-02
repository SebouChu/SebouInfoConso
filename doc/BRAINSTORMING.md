Auth middleware to access the app.

- Root : HomeController#index
- Repas : MealsController scaffolded (index, show, create, store, edit, update & destroy)
- Produits : ProductsController scaffolded + search
  - Search : via OpenFoodFacts API : code barre -> infos produit. Méthode appelée par XHR. LoadProductInfoFromAPI as private

Modèles :

Meal
- id:integer (PK)
- date:date
- type:enum (BREAKFAST, LUNCH, SNACK, DINNER)

Product
- id:integer (PK)
- name:string
- image:string
- barcode:string
- energy:integer -> en kcal. Via API : `data["product"]["nutriments"]["energy_serving"]` & unité `data["product"]["nutriments"]["energy_unit"]`

MealsProducts
- meal_id
- product_id
- quantity:integer -> en g.