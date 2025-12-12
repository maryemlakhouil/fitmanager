# FitManager 

FitManager est une application web permettant de gérer les **cours sportifs**, les **équipements** de la salle de sport, ainsi que leur **association** (quel équipement appartient à quel cours).
Elle propose également un dashboard avec graphique pour visualiser les données, ainsi qu’un système d’authentification.


##  Fonctionnalités

### Authentification
- Création de compte (Register)
- Connexion sécurisée (Login)
- Déconnexion (Logout)
- Protection des pages via session 

###  Gestion des cours
- Ajouter, modifier, supprimer un cours
-  afficher les cours

###  Gestion des équipements
- Ajouter, modifier, supprimer un équipement
- Filtrer par type 

###  Association cours <-> équipements
- Associer un équipement à un cours
- Supprimer une association

###  Dashboard
- Statistiques :
  - Nombre de cours
  - Nombre d'équipements
  - Nombre de catégories
  - Nombre de types d'équipements
- Graphiques (Chart.js) :
  - Répartition des cours par catégorie
  - Répartition des équipements par type

---

##  Technologies utilisées

| Catégorie | Technologie |
|----------|-------------|
| Frontend | HTML, TailwindCSS, JavaScript |
| Backend | PHP (PDO) |
| Base de données | MySQL |
| Graphiques | Chart.js |
| Serveur local | Laragon |


##  Structure du projet
FitManager/
│──  assests
├── cours.php
├── equipements.php
├── association.php
├── dashboard.php
│
├── login.php
├── register.php
├── logout.php
├── checker.php
 ── index.php
│
├── connex.php (connexion à MySQL)
│
└── README.md

