drop table if exists type_ingredient;
drop table if exists groupe;
drop table if exists unite;
drop table if exists ingredient;
drop table if exists type_recette;
drop table if exists etape;
drop table if exists recette;



create table type_recette (
    id_type_recette integer not null primary key auto_increment,
    nom_type_recette varchar(250) not null
) engine=innodb character set utf8 collate utf8_unicode_ci;

create table unite (
    id_unite integer not null primary key auto_increment,
    type_unite integer not null,
    nom_unite varchar(250) not null
) engine=innodb character set utf8 collate utf8_unicode_ci;

create table type_ingredient (
    id_type_ingredient integer not null primary key auto_increment,
    nom_type_ingredient varchar(250) not null
) engine=innodb character set utf8 collate utf8_unicode_ci;

create table groupe (
    id_groupe integer not null primary key auto_increment,
    nom_groupe varchar(250) not null
) engine=innodb character set utf8 collate utf8_unicode_ci;


create table recette (
    id_recette integer not null primary key auto_increment,
    nom_recette varchar(250) not null,
    id_type_recette integer not null,
    duree_prep integer not null,
    duree_cuisson integer not null,
    duree_attente integer not null,
    id_unite integer not null,
    quantite_rec integer not null,
    url_photo varchar(250) not null,
    constraint fk_type_recette foreign key(id_type_recette) references type_recette(id_type_recette),
    constraint fk_unite_rec foreign key(id_unite) references unite(id_unite)
) engine=innodb character set utf8 collate utf8_unicode_ci;


create table ingredient (
    id_recette integer not null,
    id_groupe integer not null,
    id_type_ingredient integer not null,
    id_unite integer not null,
    quantite_ing integer not null,
    primary key(id_recette, id_groupe, id_type_ingredient, id_unite),
    constraint fk_recette_ing foreign key(id_recette) references recette(id_recette),
    constraint fk_groupe_ing foreign key(id_groupe) references groupe(id_groupe),
    constraint fk_ingredient foreign key(id_type_ingredient) references type_ingredient(id_type_ingredient),
    constraint fk_unite_ing foreign key(id_unite) references unite(id_unite)
) engine=innodb character set utf8 collate utf8_unicode_ci;
    
create table etape (
    id_recette integer not null,
    id_groupe integer not null,
    id_etape integer not null,
    description integer not null,
    primary key(id_recette, id_groupe, id_etape),
    constraint fk_recette_etape foreign key(id_recette) references recette(id_recette),
    constraint fk_groupe_etape foreign key(id_groupe) references groupe(id_groupe)
) engine=innodb character set utf8 collate utf8_unicode_ci;