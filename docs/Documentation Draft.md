# Anwendungsanalyse: Rezept- und Einkaufslistenverwaltung

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

---

# ER-Entwurf

**[Insert ER-Diagram here]**

---

# Relationaler Entwurf, inkl. Normalisierung Implementierung der Datenbank

Die Datenbank wurde nach den Prinzipien der Normalisierung entworfen, um Redundanz zu vermeiden und die Konsistenz der Daten zu gewährleisten. Die Tabellenstruktur wurde entsprechend der logischen Zusammenhänge zwischen den Entitäten erstellt. Die Normalisierung bis zur dritten Normalform (3NF) wurde angewendet.

---

# Entwurf der Anwendung (Site-Map, Mock-Ups)

**[Insert Site-Map and Mock-Ups here]**

---

# Implementierung der PHP-Skripte, Test, Fehleranalyse

Die Implementierung der PHP-Skripte ermöglicht eine interaktive Nutzung der Datenbank durch die Webanwendung. Jedes Skript wurde getestet, um sicherzustellen, dass die CRUD-Operationen (Create, Read, Update, Delete) korrekt funktionieren. Fehlerbehandlung wurde implementiert, um ungültige Eingaben zu verhindern und Nutzereingaben zu validieren.

---

# Datenbank-Projekt Dokumentation

## **1. Projektübersicht**
Dieses Projekt beinhaltet die Entwicklung einer relationalen MySQL-Datenbank zur Verwaltung von Rezepten, Zutaten, Einkaufslisten und Benutzerfavoriten. Ziel ist es, eine strukturierte Datenbanklösung für die Organisation und Nutzung von Kochrezepten zu schaffen. Die Datenbank ermöglicht sowohl lesenden als auch schreibenden Zugriff über eine Webanwendung mit PHP.

## **2. Datenbankeinrichtung**
### **Datenbank erstellen:**
```sql
CREATE DATABASE datenbank_project;
```
**Erklärung:**
- Erstellt eine neue Datenbank namens `datenbank_project`.

### **Datenbank auswählen:**
```sql
USE datenbank_project;
```
**Erklärung:**
- Setzt `datenbank_project` als aktive Datenbank, sodass alle folgenden SQL-Befehle in dieser Datenbank ausgeführt werden.

## **3. Tabellenstruktur**
### **Benutzer (User-Tabelle)**
```sql
CREATE TABLE Benutzer (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    erstellt_am TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```
**Erklärung:**
- Speichert Benutzerinformationen mit einer eindeutigen ID.
- `email` ist einzigartig und darf sich nicht wiederholen.
- `erstellt_am` speichert das Datum und die Uhrzeit der Erstellung.

[...]

## **5. Fazit**
Die entwickelte Datenbank erfüllt alle Anforderungen hinsichtlich der Verwaltung von Rezepten, Zutaten und Einkaufslisten. Durch die Nutzung von Joins wird eine verbesserte Nutzer-Sicht ermöglicht. Die Anwendung wurde getestet und erfolgreich implementiert.

