# DishManager
![npm bundle size (version)](https://img.shields.io/badge/version-0.0.1-darkblue)  ![npm bundle size (version)](https://img.shields.io/badge/language-PHP-purple)  ![npm bundle size (version)](https://img.shields.io/badge/MySQL-lightgreen) 
## Beschreibung
Dieses Projekt ist eine einfache REST-API für ein Restaurant, entwickelt mit **PHP** und **MySQL**.  
Sie ermöglicht das **Verwalten von Gerichten** (CRUD: Create, Read, Update, Delete) über HTTP-Methoden.

## 📌 Projektübersicht

* Verwaltung von Restaurant-Gerichten (CRUD)

* Abruf einzelner Gerichte oder des gesamten Menüs

* Hinzufügen, Aktualisieren und Löschen von Gerichten

* Persistente Speicherung über MySQL

* Datenbereitstellung im JSON-Format

## 🔍 Endpunkte

| Methode   | Endpoint                   | Beschreibung                              |
|-----------|----------------------------|-------------------------------------------|
| `GET`     | `/menu`                    | Gibt alle Gerichte zurück                 |
| `GET`     | `/menu/:id`                | Zeigt ein einzelnes Gericht anhand der ID |
| `POST`    | `/menu`                    | Fügt ein neues Gericht hinzu              |
| `PUT`     | `/menu/:id`                | Aktualisiert ein vorhandenes Gericht      |
| `DELETE`  | `/menu/:id`                | Löscht ein Gericht anhand der ID          |
