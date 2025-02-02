USE datenbank_project;

INSERT INTO Benutzer (name, email) VALUES
('Ashfaaq', 'ashfaaq@example.com'),
('John Doe', 'johndoe@example.com'),
('Jane Doe', 'janedoe@example.com');

-- Insert into Kategorien
INSERT INTO Kategorien (name, beschreibung) VALUES
('Desserts', 'Sweet and tasty treats'),
('Main Course', 'Hearty dishes for lunch or dinner'),
('Appetizers', 'Small dishes to start your meal');

-- Insert into Rezepte
INSERT INTO Rezepte (name, kategorie_id, zubereitungszeit, anleitung) VALUES
('Chocolate Cake', 1, 60, 'Mix ingredients, bake at 180°C for 40 minutes.'),
('Grilled Chicken', 2, 30, 'Season chicken and grill for 20 minutes.'),
('Spring Rolls', 3, 20, 'Roll veggies in wraps, fry until golden.');

-- Insert into Zutaten
INSERT INTO Zutaten (name, ist_allergen, kalorien_pro_einheit) VALUES
('Flour', 0, 364),
('Sugar', 0, 387),
('Chicken', 0, 239),
('Carrots', 0, 41);

-- Insert into Rezeptzutaten
INSERT INTO Rezeptzutaten (rezept_id, zutat_id, menge) VALUES
(1, 1, '200g'),
(1, 2, '100g'),
(2, 3, '500g'),
(3, 4, '2 cups');

-- Insert into Einkaufslisten
INSERT INTO Einkaufslisten (benutzer_id) VALUES
(1),
(2);

-- Insert into EinkaufslistenDetails
INSERT INTO EinkaufslistenDetails (einkaufsliste_id, zutat_id, menge) VALUES
(1, 1, '1kg'),
(1, 2, '500g'),
(2, 3, '1kg');
