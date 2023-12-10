INSERT INTO Client
VALUES (NULL,"$2y$10$JWBDjQyVkhe2zjhD1he3c.wgD59rAWQLBlJIQyrECyjUTcVm.Drpe",0,'H',"Bastien","Perruffel","27 Boulevard des minimes",
31200,"Toulouse",0768420195,'2002-10-22',"bastienperruffel@gmail.com","Admin");

INSERT INTO Client
VALUES (NULL,"$2y$10$9Mx4PvF4K.5INrRHN/wBRuZ.nkTZMa8UVqHPYHJj9nOUycMin7W/6",0,'H',"Tristan","Delthil","44 rue des Mimosas",
31000,"Toulouse",0764526192,'1977-03-06',"TristanDelthil@gmail.com","Admin");

INSERT INTO Client
VALUES (NULL,"$2y$10$GJ/KQ30i2RvLmnoBn94Joui0DNSFPNNXVpYOd/6FbXdn0NkQSKGvW",0,'H',"Paul","Espinasse","08 avenue du Flambeau",
31000,"Toulouse",0673829171,'1999-10-28',"P.Espinasse@gmail.com","Admin");

INSERT INTO Client
VALUES (NULL,"MdpAdmin01",0,'H',"AdminTest01","AdminTest01","adresse fictive",
00000,"ville fictive",0000000000,'2000-01-01',"AdminTest01","Admin");

INSERT INTO Client
VALUES (NULL,"MdpAdmin02",0,'H',"AdminTest02","AdminTest02","adresse fictive",
00000,"ville fictive",0000000000,'2000-01-01',"AdminTest02","Admin");

INSERT INTO Client
VALUES (NULL,"MdpClient01",0,'N',"ClientTest01","ClientTest01","adresse fictive",
00000,"ville fictive",0000000000,'2000-01-01',"ClientTest01","Client");

INSERT INTO Client
VALUES (NULL,"MdpClient02",0,'N',"ClientTest02","ClientTest02","adresse fictive",
00000,"ville fictive",0000000000,'2000-01-01',"ClientTest02","Client");

INSERT INTO Client
VALUES (NULL,"MdpClient03",0,'N',"ClientTest03","ClientTest03","adresse fictive",
00000,"ville fictive",0000000000,'2000-01-01',"ClientTest03","Client");

INSERT INTO Categorie
VALUES ("complement", "Compléments alimentaires", NULL);

INSERT INTO Categorie
VALUES ("nutr", "Nutrition", NULL);

INSERT INTO Categorie
VALUES ("vetement", "Vêtements", NULL);

INSERT INTO Categorie
VALUES ("conseil", "Conseils Sportifs", NULL);

INSERT INTO Categorie
VALUES ("whey", "Whey Protéine", "complement");

INSERT INTO Categorie
VALUES ("creatine", "Créatine", "complement");

INSERT INTO Categorie
VALUES ("bcaa", "Branched-Chain Amino Acids", "complement");

INSERT INTO Categorie
VALUES ("omega3", "Oméga-3", "complement");

INSERT INTO Categorie
VALUES ("collagene", "Collagène", "complement");

INSERT INTO Categorie
VALUES ("vitamine", "Vitamines", "complement");


INSERT INTO Categorie
VALUES ("barprot", "Barres Protéinées", "nutr");

INSERT INTO Categorie
VALUES ("substrepas", "Substitut de Repas", "nutr");

INSERT INTO Categorie
VALUES ("flavdrops", "FlavDrops (Arômes alimentaires)", "nutr");

INSERT INTO Categorie
VALUES ("avoine", "Flocons d'Avoine", "nutr");

INSERT INTO Categorie
VALUES ("thedetox", "Thé Détox", "nutr");

INSERT INTO Categorie
VALUES ("beurrec", "Beurre de Cacahuètes", "nutr");


INSERT INTO Categorie
VALUES ("tshirt", "T-shirts", "vetement");

INSERT INTO Categorie
VALUES ("debardeur", "Débardeurs", "vetement");

INSERT INTO Categorie
VALUES ("legging", "Leggings", "vetement");

INSERT INTO Categorie
VALUES ("short", "Shorts", "vetement");

INSERT INTO Categorie
VALUES ("pull", "Pulls", "vetement");


INSERT INTO Categorie
VALUES ("guidesport", "Guide « Programme Sportifs »", "conseil");

INSERT INTO Categorie
VALUES ("guidealim", "Guide « Conseils d'Alimentation »", "conseil");

INSERT INTO Categorie
VALUES ("guideprat", "Guide « Bonnes Pratiques »", "conseil");



INSERT INTO Regroupement
VALUES ("nvte", "Nouveautés");

INSERT INTO Regroupement
VALUES ("debutant", "Conseillés pour les débutants");

INSERT INTO Regroupement
VALUES ("prixcasse", "Prix cassés !");

INSERT INTO Article
VALUES ("whey1kg", "Whey Protéine (1kg)", "1kg", NULL, NULL, 30.00,"La Whey Protéine est une poudre de protéines de haute 
qualité qui aide à favoriser la croissance musculaire et la récupération 
après l'entraînement. Disponible en différentes tailles, elle est une 
source essentielle d'acides aminés pour les athlètes et les amateurs 
de fitness.",100, "whey",NULL,NULL);

INSERT INTO Article
VALUES ("whey2kg", "Whey Protéine (2kg)", "2kg", NULL, NULL, 50.00,"La Whey Protéine est une poudre de protéines de haute 
qualité qui aide à favoriser la croissance musculaire et la récupération 
après l'entraînement. Disponible en différentes tailles, elle est une 
source essentielle d'acides aminés pour les athlètes et les amateurs 
de fitness.",100, "whey",NULL,NULL);

INSERT INTO Article
VALUES ("whey5kg", "Whey Protéine (5kg)", "5kg", NULL, NULL, 120.00,"La Whey Protéine est une poudre de protéines de haute 
qualité qui aide à favoriser la croissance musculaire et la récupération 
après l'entraînement. Disponible en différentes tailles, elle est une 
source essentielle d'acides aminés pour les athlètes et les amateurs 
de fitness.",100, "whey","prixcasse",NULL);


INSERT INTO Article
VALUES ("creamono", "Créatine Monohydrate", "250g", NULL, NULL, 20.00,"Le monohydrate de créatine est l’une des formes les 
plus connues de créatine et a été prouvé d'améliorer les 
performances physiques dans les exercices de haute intensité durant 
vos séances de musculation.",100, "creatine",NULL,NULL);

INSERT INTO Article
VALUES ("creatampo", "Créatine Tamponnée", "250g", NULL, NULL, 25.00,"Le monohydrate de créatine est l’une des formes les 
plus connues de créatine et a été prouvé d'améliorer les 
performances physiques dans les exercices de haute intensité durant 
vos séances de musculation.",100, "creatine",NULL,"creamono");


INSERT INTO Article
VALUES ("bcaafruit", "BCAA Fruit Punch", "250g", NULL, "Fruit Punch", 25.00,"Les BCAA sont des acides aminés 
essentiels qui aident à prévenir la dégradation 
musculaire et à stimuler la croissance musculaire. 
Disponibles dans diverses saveurs, nos BCAA sont 
parfaits pour une récupération optimale.",100, "bcaa",NULL,NULL);

INSERT INTO Article
VALUES ("bcaacitron", "BCAA Citron Vert", "250g", NULL, "Citron Vert", 28.00,"Les BCAA sont des acides aminés 
essentiels qui aident à prévenir la dégradation 
musculaire et à stimuler la croissance musculaire. 
Disponibles dans diverses saveurs, nos BCAA sont 
parfaits pour une récupération optimale.",100, "bcaa",NULL,NULL);

INSERT INTO Article
VALUES ("bcaaframb", "BCAA Framboise", "250g", NULL, "Framboise", 28.00,"Les BCAA sont des acides aminés 
essentiels qui aident à prévenir la dégradation 
musculaire et à stimuler la croissance musculaire. 
Disponibles dans diverses saveurs, nos BCAA sont 
parfaits pour une récupération optimale.",100, "bcaa",NULL,NULL);

INSERT INTO Article
VALUES ("omega3pois", "Oméga-3 Huile de Poisson", "100 capsules", NULL, "Huile de poisson", 15.00,"Les Oméga-3 sont des acides gras essentiels qui 
soutiennent la santé cardiaque, cérébrale et articulaire. Nous proposons deux types d'Oméga-3 : l'huile de poisson et l'huile 
de lin, pour répondre à vos besoins spécifiques.",100, "omega3",NULL,NULL);

INSERT INTO Article
VALUES ("omega3lin", "Oméga-3 Huile de Lin", "100 capsules", NULL, "Huile de lin", 12.00,"Les Oméga-3 sont des acides gras essentiels qui 
soutiennent la santé cardiaque, cérébrale et articulaire. Nous 
proposons deux types d'Oméga-3 : l'huile de poisson et l'huile 
de lin, pour répondre à vos besoins spécifiques.",100, "omega3",NULL,NULL);

INSERT INTO Article
VALUES ("collaboeuf", "Collagène de Bœuf", "300g", NULL, "Boeuf", 30.00,"Choisissez le Collagène qui convient le mieux à vos besoins de beauté 
et de bien-être. Notre Collagène est facile à intégrer dans votre 
routine quotidienne. Ajoutez-le à vos boissons, shakes ou recettes 
préférées pour un coup de pouce nutritif.",100, "collagene",NULL,NULL);

INSERT INTO Article
VALUES ("collapois", "Collagène de Poisson", "300g", NULL, "Poisson", 35.00,"Choisissez le Collagène qui convient le mieux à vos besoins de beauté 
et de bien-être. Notre Collagène est facile à intégrer dans votre 
routine quotidienne. Ajoutez-le à vos boissons, shakes ou recettes 
préférées pour un coup de pouce nutritif.",100, "collagene",NULL,NULL);

INSERT INTO Article
VALUES ("multivit", "Multivitamines", "60 comprimés", NULL, NULL, 15.00,"Nos compléments de vitamines sont conçus pour soutenir la 
santé globale. Que vous ayez besoin de vitamines spécifiques comme les 
Multivitamines, la Vitamine D ou la Vitamine C, nous avons ce qu'il vous 
faut.",100, "vitamine","debutant",NULL);

INSERT INTO Article
VALUES ("vitC", "Vitamines C", "60 comprimés", NULL, NULL, 15.00,"Nos compléments de vitamines sont conçus pour soutenir la 
santé globale. Que vous ayez besoin de vitamines spécifiques comme les 
Multivitamines, la Vitamine D ou la Vitamine C, nous avons ce qu'il vous 
faut.",100, "vitamine",NULL,NULL);

INSERT INTO Article
VALUES ("vitD", "Vitamines D", "60 comprimés", NULL, NULL, 15.00,"Nos compléments de vitamines sont conçus pour soutenir la 
santé globale. Que vous ayez besoin de vitamines spécifiques comme les 
Multivitamines, la Vitamine D ou la Vitamine C, nous avons ce qu'il vous 
faut.",100, "vitamine",NULL,"vitC");

INSERT INTO Article
VALUES ("barrechoc", "Barres Protéinées au Chocolat", "5 unités", NULL, "Chocolat", 2.00,"Nos Barres Protéinées délicieusement 
savoureuses sont une excellente option pour une collation 
riche en protéines. Choisissez parmi une variété de saveurs 
pour satisfaire vos papilles.",100, "barprot",NULL,NULL);

INSERT INTO Article
VALUES ("barrefrse", "Barres Protéinées à la Fraise", "5 unités", NULL, "Fraise", 2.50,"Nos Barres Protéinées délicieusement 
savoureuses sont une excellente option pour une collation 
riche en protéines. Choisissez parmi une variété de saveurs 
pour satisfaire vos papilles.",100, "barprot",NULL,NULL);

INSERT INTO Article
VALUES ("barrecoco", "Barres Protéinées à la Noix de Coco", "5 unités", NULL, "Noix de Coco", 2.50,"Nos Barres Protéinées délicieusement 
savoureuses sont une excellente option pour une collation 
riche en protéines. Choisissez parmi une variété de saveurs 
pour satisfaire vos papilles.",100, "barprot",NULL,NULL);

INSERT INTO Article
VALUES ("shake", "Shake", "10 portions", NULL, NULL, 5.00,"Les Substituts de Repas sont une solution pratique pour 
ceux qui ont un mode de vie actif. Disponibles sous forme de shakes 
ou de barres, ils fournissent une nutrition équilibrée en déplacement.",100, "substrepas",NULL,NULL);

INSERT INTO Article
VALUES ("barre", "Barre-Repas", "10 portions", NULL, NULL, 3.00,"Les Substituts de Repas sont une solution pratique pour 
ceux qui ont un mode de vie actif. Disponibles sous forme de shakes 
ou de barres, ils fournissent une nutrition équilibrée en déplacement.",100, "substrepas",NULL,NULL);


INSERT INTO Article
VALUES ("dropsvan", "FlavDrops saveur Vanille", NULL, NULL, "Vanille", 6.00,"Ajoutez de la saveur à votre alimentation avec nos FlavDrops. 
Parfait pour aromatiser vos shakes protéinés, yaourts, et bien plus encore, sans 
calories supplémentaires.",100, "flavdrops",NULL,NULL);

INSERT INTO Article
VALUES ("dropschoc", "FlavDrops saveur Chocolat", NULL, NULL, "Chocolat", 6.00,"Ajoutez de la saveur à votre alimentation avec nos FlavDrops. 
Parfait pour aromatiser vos shakes protéinés, yaourts, et bien plus encore, sans 
calories supplémentaires.",100, "flavdrops",NULL,NULL);

INSERT INTO Article
VALUES ("dropsfrais", "FlavDrops saveur Fraise", NULL, NULL, "Fraise", 6.00,"Ajoutez de la saveur à votre alimentation avec nos FlavDrops. 
Parfait pour aromatiser vos shakes protéinés, yaourts, et bien plus encore, sans 
calories supplémentaires.",100, "flavdrops",NULL,NULL);

INSERT INTO Article
VALUES ("avoine500g", "Flocons d'Avoine (500g)", "500g", NULL, NULL, 3.00,"Les Flocons d'Avoine sont une source saine de glucides 
complexes et de fibres. Ils sont parfaits pour un petit-déjeuner nutritif 
ou comme base pour vos recettes de pâtisserie",100, "avoine",NULL,NULL);

INSERT INTO Article
VALUES ("avoine1kg", "Flocons d'Avoine (1kg)", "1kg", NULL, NULL, 3.00,"Les Flocons d'Avoine sont une source saine de glucides 
complexes et de fibres. Ils sont parfaits pour un petit-déjeuner nutritif 
ou comme base pour vos recettes de pâtisserie",100, "avoine","prixcasse",NULL);


INSERT INTO Article
VALUES ("thevert", "Thé vert", "200g", NULL, NULL, 8.00,"Détendez-vous et purifiez votre corps 
avec notre Thé Détox. Choisissez entre le Thé Vert 
riche en antioxydants ou le Thé à la Menthe 
rafraîchissant.",100, "thedetox",NULL,NULL);

INSERT INTO Article
VALUES ("thementhe", "Thé à la menthe", "200g", NULL, NULL, 7.00,"Détendez-vous et purifiez votre corps 
avec notre Thé Détox. Choisissez entre le Thé Vert 
riche en antioxydants ou le Thé à la Menthe 
rafraîchissant.",100, "thedetox",NULL,NULL);

INSERT INTO Article
VALUES ("beurrenat", "Beurre de Cacahuètes Nature", "500g", NULL, NULL, 4.00,"Notre Beurre de Cacahuètes est une source délicieuse 
de protéines et de graisses saines. Disponible en version naturelle ou 
croquante, c'est une collation énergétique appréciée de tous.",100, "beurrec",NULL,NULL);

INSERT INTO Article
VALUES ("beurrecroc", "Beurre de Cacahuètes Croquant", "500g", NULL, NULL, 5.00,"Notre Beurre de Cacahuètes est une source délicieuse 
de protéines et de graisses saines. Disponible en version naturelle ou 
croquante, c'est une collation énergétique appréciée de tous.",100, "beurrec",NULL,NULL);