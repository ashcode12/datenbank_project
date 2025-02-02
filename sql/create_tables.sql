USE datenbank_project;

-- Create the Benutzer table
Create table Benutzer (
    id INT AUTO_INCREMENT PRIMARY KEY, -- Primary Key
    name VARCHAR(50) NOT NULL, -- User's nmae
    email VARCHAR(100) UNIQUE NOT NULL, -- Users email must be unique
    erstellt_am TIMESTAMP DEFAULT CURRENT_TIMESTAMP // Timestamp for when the user was created
);

-- Explanation: 
    -- We made 'id' an AUTO_INCREMENT field so it automaticallz generates unique IDS. 
    -- 'erstellt_am' is a timestamp to track when each user is added. This helps us later for filtering or sorting users by creation date. 
    -- Why VARCHAR? Because names and emails vary in length, and this saves space compared to fixed-length CHAR.


-- 1. Kategorien (Categories)
CREATE TABLE Kategorien (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL, -- Category name
    beschreibung TEXT -- Optional description
);

-- Explanation:
-- - Each category has a unique ID and a name.
-- - We added a `beschreibung` field to allow storing additional details if needed.

-- 2. Rezepte (Recipes)
CREATE TABLE Rezepte (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,      -- Recipe name
    kategorie_id INT,                -- Foreign key to Kategorien
    zubereitungszeit INT,            -- Preparation time in minutes
    anleitung TEXT,                  -- Instructions for the recipe
    erstellt_am TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_kategorie FOREIGN KEY (kategorie_id) REFERENCES Kategorien(id)
);

-- Explanation:
-- - Recipes are linked to categories using `kategorie_id` as a foreign key.
-- - `zubereitungszeit` represents time in minutes.
-- - `anleitung` is for storing detailed instructions.

-- 3. Favoriten (Favorites)
CREATE TABLE Favoriten (
    id INT AUTO_INCREMENT PRIMARY KEY,
    benutzer_id INT,   -- Foreign key to Benutzer
    rezept_id INT,     -- Foreign key to Rezepte
    hinzugefuegt_am TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_benutzer FOREIGN KEY (benutzer_id) REFERENCES Benutzer(id),
    CONSTRAINT fk_rezept FOREIGN KEY (rezept_id) REFERENCES Rezepte(id)
);

-- Explanation:
-- - Tracks which recipes are marked as favorites by users.
-- - `hinzugefuegt_am` stores when the favorite was added.

-- 4. Zutaten (Ingredients)
CREATE TABLE Zutaten (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,       -- Ingredient name
    ist_allergen BOOLEAN DEFAULT 0, -- Whether the ingredient is an allergen
    kalorien_pro_einheit INT        -- Calories per unit
);

-- Explanation:
-- - Each ingredient has a name, allergen flag, and calorie information.

-- 5. Rezeptzutaten (Recipe Ingredients)
CREATE TABLE Rezeptzutaten (
    id INT AUTO_INCREMENT PRIMARY KEY,
    rezept_id INT,       -- Foreign key to Rezepte
    zutat_id INT,        -- Foreign key to Zutaten
    menge VARCHAR(50),   -- Quantity (e.g., '200g', '1 cup')
    CONSTRAINT fk_rezept_zutat FOREIGN KEY (rezept_id) REFERENCES Rezepte(id),
    CONSTRAINT fk_zutat FOREIGN KEY (zutat_id) REFERENCES Zutaten(id)
);

-- Explanation:
-- - Links recipes to their ingredients and specifies the quantity of each ingredient.

-- 6. Einkaufslisten (Shopping Lists)
CREATE TABLE Einkaufslisten (
    id INT AUTO_INCREMENT PRIMARY KEY,
    benutzer_id INT,    -- Foreign key to Benutzer
    erstellt_am TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_benutzer_einkauf FOREIGN KEY (benutzer_id) REFERENCES Benutzer(id)
);

-- Explanation:
-- - Tracks shopping lists created by users.

-- 7. EinkaufslistenDetails (Shopping List Details)
CREATE TABLE EinkaufslistenDetails (
    id INT AUTO_INCREMENT PRIMARY KEY,
    einkaufsliste_id INT, -- Foreign key to Einkaufslisten
    zutat_id INT,         -- Foreign key to Zutaten
    menge VARCHAR(50),    -- Quantity of the ingredient
    CONSTRAINT fk_einkauf FOREIGN KEY (einkaufsliste_id) REFERENCES Einkaufslisten(id),
    CONSTRAINT fk_zutat_einkauf FOREIGN KEY (zutat_id) REFERENCES Zutaten(id)
);

-- Explanation:
-- - Links shopping lists to ingredients, specifying quantities for each item.
