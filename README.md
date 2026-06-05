# # **Projet : EatSmart**

**Etudiants :**

Touchene Sherine

### **1. Description du projet**

EatSmart est une application qui permet de consulter le menu de la pizzeria et de passer commande directement depuis celle-ci. Elle gère également le traitement des commandes et garde l'historique des commandes .
Elle prévient directement le client lorsque sa commande est terminer.

<img src="./Assets/img/Capture.PNG">


3.1 Frontend (eatSmartFront)

Fonctionnalité 1 :
Affichage dynamique du menu de la pizzeria, permettant aux utilisateurs de naviguer facilement entre les différentes catégories de plats (pizzas, boissons, desserts, etc.). Chaque plat est accompagné de détails comme la description, les ingrédients, et le prix.

Fonctionnalité 2 :
Processus de commande simplifié, où l'utilisateur peut sélectionner les plats qu'il souhaite commander, personnaliser sa commande (choix de garnitures, tailles, etc.), puis ajouter au panier avant de procéder au paiement.

3.2 Backend (eatSmartBack)

Fonctionnalité 1 :
Gestion des commandes en temps réel, avec un tableau de bord permettant aux administrateurs de suivre l'état des commandes (en préparation, prêtes à être livrées, etc.) et de gérer les clients.

Fonctionnalité 2 :
Administration du menu, permettant d'ajouter, modifier ou supprimer des plats dans le menu de la pizzeria. Les prix, descriptions et ingrédients sont également mis à jour à partir de cette interface.

### **4. Technologies utilisées**

- **Frontend :** HTML/CSS/Javascript
- **Backend :** API
- **Base de données :** MYSQL

### **5. MCD/MLD/MPD**

<img src="./Assets/img/mcd.PNG">
---
## Endpoints de l'API

Adresse de l'API (en local) : http://localhost/sherine-api-eatsmart.

Voici les différents endpoints de l'API : 
- `GET /articles` → Afficher la liste des articles
- `GET /articles/{id}` → Afficher l'article avec l'id égal à {id}
- `GET /categories` → Afficher la liste des catégories
- `GET /categories/{id}` → Afficher la catégorie avec l'id égal à {id}
- `GET /commandes` → Afficher la liste des commandes
- `GET /commandes/{id}` → Afficher la commande avec l'id égal à {id}
- `GET /categories/{id}/articles`→Afficher tous les articles appartenant à la catégorie avec l'id égal à {id}
- `GET /articles/{id}/commandes` → Afficher toutes les commandes contenant l'article avec l'id égal à {id}

