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

/* Lister les Données */

select * from cours;
select * from equipements;
select * from cours_equipements;



