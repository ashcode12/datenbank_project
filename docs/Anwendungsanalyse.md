**Anwendungsanalyse: Rezept- und Einkaufslistenverwaltung**

## **1. Einleitung**
Die Rezept- und Einkaufslistenverwaltung ist eine Webanwendung zur Organisation von Rezepten, Zutaten und Einkaufslisten. Nutzer können Rezepte speichern, Zutaten verwalten und Einkaufslisten für den täglichen Bedarf erstellen. Ziel ist es, eine einfache Verwaltung von Rezepten und den dazugehörigen Zutaten zu ermöglichen und Nutzern die Möglichkeit zu geben, Einkaufslisten effizient zu organisieren.

## **2. Zielgruppe und Benutzerrollen**
Die Anwendung richtet sich an:
- **Privatpersonen:** Nutzer, die ihre Lieblingsrezepte speichern und personalisierte Einkaufslisten erstellen möchten.
- **Küchenchefs und Hobbyköche:** Personen, die ihre Rezepte strukturiert organisieren und teilen wollen.
- **Familien:** Mitglieder, die eine gemeinsame Einkaufsplanung durchführen möchten.

## **3. Kernfunktionen der Anwendung**
### **a) Verwaltung von Benutzern**
- Erstellung und Verwaltung von Benutzerkonten
- Speicherung von Namen und E-Mail-Adressen

### **b) Kategorienverwaltung**
- Gruppierung von Rezepten in Kategorien (z. B. Desserts, Hauptgerichte, Vorspeisen)

### **c) Rezeptverwaltung**
- Erstellen, Bearbeiten und Löschen von Rezepten
- Angabe der Zubereitungszeit und detaillierte Kochanleitung
- Verknüpfung eines Rezepts mit einer Kategorie

### **d) Zutatenverwaltung**
- Verwaltung der Zutaten mit Angabe von Kalorien und Allergeninformationen
- Verknüpfung von Zutaten mit Rezepten (Mengenangaben für jede Zutat pro Rezept)

### **e) Einkaufslistenverwaltung**
- Erstellen und Verwalten von Einkaufslisten
- Automatische Generierung von Einkaufslisten basierend auf Rezeptauswahl
- Manuelles Hinzufügen und Entfernen von Zutaten

### **f) Favoritenverwaltung**
- Nutzer können Rezepte als Favoriten speichern und schnell darauf zugreifen

## **4. Technische Umsetzung**
Die Anwendung basiert auf **PHP und MySQL** mit einer strukturierten relationalen Datenbank. Die Nutzeroberfläche ist in **HTML, CSS und Bootstrap** gestaltet. Die Datenbank ermöglicht:
- **Lesenden Zugriff über Joins** für die Anzeige verknüpfter Daten
- **Schreibenden Zugriff** für das Hinzufügen, Ändern und Löschen von Datensätzen

## **5. Fazit**
Die Anwendung bietet eine strukturierte Lösung zur Verwaltung von Rezepten, Zutaten und Einkaufslisten. Durch die intuitive Benutzeroberfläche und die Nutzung relationaler Datenbanken wird eine effiziente Verwaltung und Planung ermöglicht.

