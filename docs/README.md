# Datenbank Project

## Tables Created:
1. `Kategorien` - Stores recipe categories.
2. `Rezepte` - Stores recipe details, linked to categories.
3. `Favoriten` - Tracks user favorites.
4. `Zutaten` - Stores ingredient details.
5. `Rezeptzutaten` - Links recipes to their ingredients.
6. `Einkaufslisten` - Tracks shopping lists.
7. `EinkaufslistenDetails` - Links shopping lists to ingredients.

## Sample Data:
- Added categories like `Desserts`, `Main Course`.
- Recipes like `Chocolate Cake` and `Grilled Chicken`.
- Ingredients like `Flour` and `Sugar`.

### Challenges:
- Linking tables required multiple foreign keys. We verified relationships using `SHOW TABLES` and `DESCRIBE`.
- Adding sample data was tricky but gave insights into data dependencies.


