/* Supprimer Toutes les tables  */

DROP TABLE  cours_equipements;
DROP TABLE  equipements;
DROP TABLE  cours;
DROP TABLE  users;

/*Creation du Base De donnée*/
create DATABASE Fitmanager;
USE Fitmanager;

/* création des tables */

/* Table cours */
create table cours(
    courId int auto_increment primary key,
    nom varchar(50) not null,
    categorie varchar(60) not null,
    dateDebut date not null,
    dateFin date not null ,
    heure time not null,
    nbmax int not null
);

/* Table equipements */
create table equipements(
    equipe_ID int auto_increment primary key,
    nom varchar(50)not null,
    type varchar(50)not null,
    quantite int not null,
    etat varchar(40) CHECK (etat IN ('bon', 'moyen', 'a remplacer'))
    --   etat ENUM ('bon', 'moyen', 'a remplacer')
);

/* table Associative */
create table cours_equipements(
    ID int auto_increment primary key,
    courId int not null ,
    equipe_ID int not null,
    constraint fk_cours foreign key (courId) references cours(courId) on delete CASCADE,
    constraint fk_equipement foreign key (equipe_ID) references equipements(equipe_ID) on delete CASCADE,
    unique (courId,equipe_ID)
);
/*Céation Du table Users Pour Authentification */

create table users(
    id int auto_increment Primary key,
    nom varchar(50) Not null,
    email varchar(50) unique ,
    password varchar(50) not null
);

/* Lister les Données */

select * from cours;
select * from equipements;
select * from cours_equipements;
select * from cours order by dateDebut desc;
SELECT * FROM equipements ORDER BY nom DESC;
select * from users;

/***************************
        INSERTION  
*************************/

/* Ajouter Dans cours */
insert into cours(nom,categorie,dateDebut,dateFin,heure,nbmax) values("cours1","yoga","2025-2-3","2026-3-4",4,20);
insert into cours(nom,categorie,dateDebut,dateFin,heure,nbmax) values("cours2","Musculation","2025-11-3","2026-12-4",300,20);
insert into cours(nom,categorie,dateDebut,dateFin,heure,nbmax) values("cours3","Cardio","2025-11-3","2026-12-4",11300,20);

/* Ajouter Un equipement */
INSERT INTO equipements (nom, type, quantite, etat) VALUES ("equipe1","Tapis de course", 7, "bon")
INSERT INTO equipements (nom, type, quantite, etat) VALUES ("equipe2","Haltères", 17, "bon")
INSERT INTO equipements (nom, type, quantite, etat) VALUES ("equipe3","Ballons", 17, "moyen")
INSERT INTO equipements (nom, type, quantite, etat) VALUES ("equipe4","Ballons", 20, "bon")

/* Inserer Dans La table Users*/
insert into users(nom,email,password) values('maryem','lkhwil@gmail.com','lakhouil2003');

/**************************
    Supprimer Les Données
**************************/

/*Supprimer Un cours du tableau cours*/
delete from cours where courId = 6;

/* Suprimer Un Equipements */
DELETE FROM equipements where equipe_ID=1;

/*******************************
    Modifier les Données 
******************************/

/*Modifier Un cours */
Update cours
    SET nom="sience", categorie="Yoga", nbmax=30
    WHERE courId=7;

/*Modifier Un equipements */
Update equipements
    SET type="Ballons",etat="moyen"
    WHERE equipe_ID=1;

/* Modifier le colonne Password */
alter table users modify password varchar(255);

/*****************************
    Récuperer Les Données 
*****************************/

/*Récupération des cours par catégorie*/
SELECT categorie, COUNT(*) AS total
FROM cours
WHERE categorie IS NOT NULL
GROUP BY categorie;

/* Récuperation ds equipements par leur type */
SELECT type, COUNT(*) AS total 
FROM equipements
WHERE type is not null 
GROUP BY type;

/* Le nombre de categorie de cours */
SELECT COUNT(DISTINCT categorie) AS nb_categories
FROM cours;


