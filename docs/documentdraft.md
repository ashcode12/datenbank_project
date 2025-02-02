# Datenbank Project Documentation

## Overview
This project involves creating a MySQL database for managing recipes, users, ingredients, and shopping lists. The database was developed step by step, ensuring that every table, relationship, and query was designed to simulate a real-world application while meeting academic requirements.

---

## Step 1: Setting Up the Database

### Commands Executed:
1. **Create the Database:**
   ```sql
   CREATE DATABASE datenbank_project;
   ```
   - **Explanation:** This command initializes the database named `datenbank_project`. The database will store all tables and data for the project.

2. **Use the Database:**
   ```sql
   USE datenbank_project;
   ```
   - **Explanation:** This command sets the context to the `datenbank_project` database, ensuring all subsequent commands are executed within this database.

---

## Step 2: Creating Tables

### 1. Benutzer (Users)
**Command:**
```sql
CREATE TABLE Benutzer (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    erstellt_am TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```
- **Explanation:**
  - `id`: Auto-incremented primary key for uniquely identifying each user.
  - `name`: Stores the user's name, limited to 50 characters.
  - `email`: Stores the user’s unique email address.
  - `erstellt_am`: Automatically captures the timestamp when the record is created.

**Sample Data Inserted:**
```sql
INSERT INTO Benutzer (name, email) VALUES
('Ashfaaq', 'ashfaaq@example.com'),
('John Doe', 'johndoe@example.com'),
('Jane Doe', 'janedoe@example.com');
```
- **Explanation:** These are sample users added to test the table.

---

### 2. Kategorien (Categories)
**Command:**
```sql
CREATE TABLE Kategorien (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    beschreibung TEXT
);
```
- **Explanation:**
  - `id`: Unique ID for each category.
  - `name`: Stores the category name (e.g., Dessert, Main Course).
  - `beschreibung`: Optional text description for the category.

**Sample Data Inserted:**
```sql
INSERT INTO Kategorien (name, beschreibung) VALUES
('Desserts', 'Sweet and tasty treats'),
('Main Course', 'Hearty dishes for lunch or dinner'),
('Appetizers', 'Small dishes to start your meal');
```

---

### 3. Rezepte (Recipes)
**Command:**
```sql
CREATE TABLE Rezepte (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    kategorie_id INT,
    zubereitungszeit INT,
    anleitung TEXT,
    erstellt_am TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_kategorie FOREIGN KEY (kategorie_id) REFERENCES Kategorien(id)
);
```
- **Explanation:**
  - `kategorie_id`: Foreign key linking recipes to categories.
  - `zubereitungszeit`: Preparation time in minutes.
  - `anleitung`: Stores instructions for making the recipe.

**Sample Data Inserted:**
```sql
INSERT INTO Rezepte (name, kategorie_id, zubereitungszeit, anleitung) VALUES
('Chocolate Cake', 1, 60, 'Mix ingredients, bake at 180°C for 40 minutes.'),
('Grilled Chicken', 2, 30, 'Season chicken and grill for 20 minutes.'),
('Spring Rolls', 3, 20, 'Roll veggies in wraps, fry until golden.');
```

---

## Query Results

### Query 1: List All Recipes with Their Categories
**Command:**
```sql
SELECT r.name AS recipe, k.name AS category
FROM Rezepte r
JOIN Kategorien k ON r.kategorie_id = k.id;
```
**Output:**
```
+-----------------+-------------+
| recipe          | category    |
+-----------------+-------------+
| Chocolate Cake  | Desserts    |
| Grilled Chicken | Main Course |
| Spring Rolls    | Appetizers  |
+-----------------+-------------+
```
**Explanation:**
This query joins `Rezepte` and `Kategorien` tables using the `kategorie_id` foreign key. It successfully displays all recipes with their corresponding categories.

---

### Query 2: Fetch Ingredients for a Recipe
**Command:**
```sql
SELECT r.name AS recipe, z.name AS ingredient, rz.menge AS quantity
FROM Rezeptzutaten rz
JOIN Rezepte r ON rz.rezept_id = r.id
JOIN Zutaten z ON rz.zutat_id = z.id
WHERE r.id = 1;
```
**Output:**
```
+----------------+------------+----------+
| recipe         | ingredient | quantity |
+----------------+------------+----------+
| Chocolate Cake | Flour      | 200g     |
| Chocolate Cake | Sugar      | 100g     |
+----------------+------------+----------+
```
**Explanation:**
This query joins `Rezeptzutaten`, `Rezepte`, and `Zutaten` tables to fetch ingredients and their quantities for the recipe with `id = 1` (Chocolate Cake).

---

### Query 3: List Favorites of a User
**Command:**
```sql
SELECT b.name AS user, r.name AS favorite_recipe
FROM Favoriten f
JOIN Benutzer b ON f.benutzer_id = b.id
JOIN Rezepte r ON f.rezept_id = r.id
WHERE b.id = 1;
```
**Output:**
```
+---------+-----------------+
| user    | favorite_recipe |
+---------+-----------------+
| Ashfaaq | Chocolate Cake  |
+---------+-----------------+
```
**Explanation:**
This query joins `Favoriten`, `Benutzer`, and `Rezepte` tables to display all favorite recipes of the user with `id = 1` (Ashfaaq).

---

### Query 4: Generate a Shopping List for a User
**Command:**
```sql
SELECT b.name AS user, z.name AS ingredient, ed.menge AS quantity
FROM EinkaufslistenDetails ed
JOIN Einkaufslisten e ON ed.einkaufsliste_id = e.id
JOIN Benutzer b ON e.benutzer_id = b.id
JOIN Zutaten z ON ed.zutat_id = z.id
WHERE b.id = 1;
```
**Output:**
```
+---------+------------+----------+
| user    | ingredient | quantity |
+---------+------------+----------+
| Ashfaaq | Flour      | 1kg      |
| Ashfaaq | Sugar      | 500g     |
+---------+------------+----------+
```
**Explanation:**
This query joins `EinkaufslistenDetails`, `Einkaufslisten`, `Benutzer`, and `Zutaten` tables to generate a detailed shopping list for the user with `id = 1` (Ashfaaq).

