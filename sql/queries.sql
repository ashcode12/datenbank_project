

-- Query 1: List all recipes with their categories
SELECT r.name AS recipe, k.name AS category
FROM Rezepte r
JOIN Kategorien k ON r.kategorie_id = k.id;

-- Purpose: This query shows the recipes and their associated categories.
-- Explanation:
-- - Rezepte is joined to Kategorien using kategorie_id.
-- - The AS keyword renames columns in the result for better readability.

-- Query 2: Fetch ingredients for a recipe
SELECT r.name AS recipe, z.name AS ingredient, rz.menge AS quantity
FROM Rezeptzutaten rz
JOIN Rezepte r ON rz.rezept_id = r.id
JOIN Zutaten z ON rz.zutat_id = z.id
WHERE r.id = 1;

-- Purpose: Displays ingredients and their quantities for a specific recipe.
-- Explanation:
-- - Rezeptzutaten links recipes to ingredients.
-- - Rezepte and Zutaten provide recipe names and ingredient details.

-- Query 3: List favorites of a user
SELECT b.name AS user, r.name AS favorite_recipe
FROM Favoriten f
JOIN Benutzer b ON f.benutzer_id = b.id
JOIN Rezepte r ON f.rezept_id = r.id
WHERE b.id = 1;

-- Purpose: Lists all recipes marked as favorites by a specific user.
-- Explanation:
-- - Favoriten links users (Benutzer) to recipes (Rezepte).

-- Query 4: Generate a shopping list for a user
SELECT b.name AS user, z.name AS ingredient, ed.menge AS quantity
FROM EinkaufslistenDetails ed
JOIN Einkaufslisten e ON ed.einkaufsliste_id = e.id
JOIN Benutzer b ON e.benutzer_id = b.id
JOIN Zutaten z ON ed.zutat_id = z.id
WHERE b.id = 1;

-- Purpose: Retrieves the shopping list for a specific user.
-- Explanation:
-- - Einkaufslisten connects users to their shopping lists.
-- - EinkaufslistenDetails links shopping lists to ingredients.

