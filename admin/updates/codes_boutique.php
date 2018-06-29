<?php
define('FP_CHEMIN' , dirname(__file__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR);
define('FP_CHEMIN_PHP' , FP_CHEMIN . 'php' . DIRECTORY_SEPARATOR);
include(FP_CHEMIN_PHP . 'page_start' . '.php');
if(1 /**$my_membre->membre_pseudo=='finalserafin'**/):


mysql_query("INSERT INTO codesgratis_codes_designation VALUES ( -4, 'Gratopass', 'Grat-o-foot.com',	 0, 0 , 0 , 0 )");
echo mysql_error() . FP_LIGNE;
/**/

mysql_query("INSERT INTO codesgratis_codes_designation VALUES ( -1 , 'CGRATIS' , 'codesgratis.fr' , 80 , 0 , 0 ,1 )");
echo mysql_error() . FP_LIGNE;
/**
mysql_query("INSERT INTO codesgratis_codes_designation VALUES ( -2 , 'CGCODES' , 'codesgratis.fr' , 0 , 0 , 0  ,0)");
echo mysql_error() . FP_LIGNE;
mysql_query("INSERT INTO codesgratis_codes_designation VALUES ( -3 , 'CGCODESPLUS' , 'codesgratis.fr', 0 , 0 , 0 ,0)");
echo mysql_error() . FP_LIGNE;
/**/
// 1	"Appelomini", 1	"Appel-gagnant.com", 400
mysql_query("INSERT INTO codesgratis_codes_designation VALUES ( 1 , 'Appelomini' , 'Appel-gagnant.com' , 400 , 0 , 0 , 1  )");
echo mysql_error() . FP_LIGNE;
/**/
// 2	"Appelogagne", "Appel-gagnant.com", 2000, 
mysql_query("INSERT INTO codesgratis_codes_designation VALUES ( 2 , 'Appelogagne' , 'Appel-gagnant.com' , 2000, 0 , 0 , 1 )");
echo mysql_error() . FP_LIGNE;

/**/
//3	"Azur-code", 3	"Voyage-eco.info", 3	 600), 
mysql_query("INSERT INTO codesgratis_codes_designation VALUES ( 3 , 'Azur-code'  , 'Voyage-eco.info' , 600 , 0 , 0 , 1 )");
echo mysql_error() . FP_LIGNE;

//4	"Bankiz+", 4	"Bankizocodes.com", 4	 1000), 
mysql_query("INSERT INTO codesgratis_codes_designation VALUES ( 4 , 'Bankiz plus'  , 'Bankizocodes.com'  , 1000 , 0 , 0 , 1 )");
echo mysql_error() . FP_LIGNE;

//5	"BonuCode", 5	"LeNetGagnant.fr", 5	 2500), 
mysql_query("INSERT INTO codesgratis_codes_designation VALUES ( 5 , 'BonusCode' , 'LeNetGagnant.fr' , 2500, 0 , 0 , 1 )");
echo mysql_error() . FP_LIGNE;
/**
//6	"Boop's",6	"Boomat.fr",6	 700), 
mysql_query("INSERT INTO codesgratis_codes_designation VALUES ( 6 ,  ,  , 700, 0 , 0 , 1 )");
echo mysql_error() . FP_LIGNE;

//7 "Boulicodes", //7	"Maxkdo.com",//7	 300), Plus en boutique
mysql_query("INSERT INTO codesgratis_codes_designation VALUES ( 7 ,  ,  , 300 , 0 , 0 , 0 )");
echo mysql_error() . FP_LIGNE;
/**/
//8	"Buzicodes", 8	"Sacokado.com", 8	 500), 
mysql_query("INSERT INTO codesgratis_codes_designation VALUES ( 8 ,	'Buzicodes', 'Sacokado.com',500, 0 , 0 , 1  )");
echo mysql_error() . FP_LIGNE;
/**/
//9	"Byncode", 9	"Toilokdo.com", 9	 500), 
mysql_query("INSERT INTO codesgratis_codes_designation VALUES ( 9 ,	'Byncode', 	'Toilokdo.com', 	 500,  0 , 0 ,1 )");
echo mysql_error() . FP_LIGNE;
/**/
//10	"Cagette", 10	"Marcher-o-kdos.com", 10	 600), 
mysql_query("INSERT INTO codesgratis_codes_designation VALUES (  10 , 'Cagette'  , 'Marcher-o-kdos.com' , 600 , 0 , 0 , 1 )");
echo mysql_error() . FP_LIGNE;
/**/
//11	"Cashcode", 11	"Cashkado.com", 11	 450), 
mysql_query("INSERT INTO codesgratis_codes_designation VALUES ( 11, 'Cashcode', 	'Cashkado.com',	 450, 0 , 0 , 1 )");
echo mysql_error() . FP_LIGNE;
/**/
//12	"CEpass", 12	"Chaudron-Empoisonne.fr", 12	 600), 
mysql_query("INSERT INTO codesgratis_codes_designation VALUES ( 12 , 'CEpass', 'Chaudron-Empoisonne.fr', 600 ,  0 , 0 , 1  )");
echo mysql_error() . FP_LIGNE;
/**
//13	"CGcode", 13	"CodesGratis.fr", 13	 80), 
mysql_query("INSERT INTO codesgratis_codes_designation VALUES (  ,  ,  , , 0 , 0  )");
echo mysql_error() . FP_LIGNE;

//14	"Cheyen-code", 14	"Cheyen-barre.com", 14	 2700), 
mysql_query("INSERT INTO codesgratis_codes_designation VALUES (  ,  ,  , , 0 , 0  )");
echo mysql_error() . FP_LIGNE;
/**/
//15	"Choco+", 15	"Binbango.com", 15	 1800), 
mysql_query("INSERT INTO codesgratis_codes_designation VALUES ( 15 , 'Choco plus' , 'Binbango.com', 1800 , 0 , 0 , 1  )");
echo mysql_error() . FP_LIGNE;
/**/
//16	"Cinecode", 16	"Cinemakado.com", 16	 500), 
mysql_query("INSERT INTO codesgratis_codes_designation VALUES ( 16 , 'Cinecode' , 'Cinemakado.com'  ,500 , 0 , 0 , 1  )");
echo mysql_error() . FP_LIGNE;
/**
//17	"Cinecode+", 17	"Cinemakado.com", 17	 2000), 
mysql_query("INSERT INTO codesgratis_codes_designation VALUES (  ,  ,  , , 0 , 0  )");
echo mysql_error() . FP_LIGNE;
/**/
//18	"Cliquopass", 18	"Cliquojeux.com", 18	 650), 
mysql_query("INSERT INTO codesgratis_codes_designation VALUES ( 18  , 'Cliquopass' , 'Cliquojeux.com' , 650 , 0 , 0 , 1 )");
echo mysql_error() . FP_LIGNE;
/**/
//19	"Cocoricode", 19	"Cocoricode.com", 19	 400), 
mysql_query("INSERT INTO codesgratis_codes_designation VALUES ( 19	, 'Cocoricode', 	'Cocoricode.com',	 400 , 0 , 0 , 1  )");
echo mysql_error() . FP_LIGNE;
/**/
//20	"Cocoricode+", 20	"Cocoricode.com", 20	 1200), 
mysql_query("INSERT INTO codesgratis_codes_designation VALUES ( 20 , 'Cocoricode plus', 'Cocoricode.com',  1200 ,  0 , 0 , 1  )");
echo mysql_error() . FP_LIGNE;
/**/
//21	"Codeclic", 21	"Codes-clic.com", 21	 550), 
mysql_query("INSERT INTO codesgratis_codes_designation VALUES (  21	, 'Codeclic' , 'Codes-clic.com' , 550 ,  0 , 0 , 1  )");
echo mysql_error() . FP_LIGNE;
/**/
//22	"Codesauxcliques A",22	"Codesauxcliques.com", 22	 650), 
mysql_query("INSERT INTO codesgratis_codes_designation VALUES ( 22 , 'Codesauxcliques A' , 'Codesauxcliques.com' , 650 , 0 , 0 , 1 )");
echo mysql_error() . FP_LIGNE;
/**
//23	 "Codesauxcliques B", 23	"Codesauxcliques.com", 23	 2700), 
mysql_query("INSERT INTO codesgratis_codes_designation VALUES (  ,  ,  , , 0 , 0  )");
echo mysql_error() . FP_LIGNE;
/**/
//24	 "Codilo : 1€", 24	"Codilo.com", 24	 2000), 
mysql_query("INSERT INTO codesgratis_codes_designation VALUES (24	, 'Codilo : 1€', 'Codilo.com', 20000 , 0 , 0 , 0)");
echo mysql_error() . FP_LIGNE;
/**
//25	 "Deficode", 25	"Defigames.com", 25	 1800), 
mysql_query("INSERT INTO codesgratis_codes_designation VALUES (  ,  ,  , , 0 , 0  )");
echo mysql_error() . FP_LIGNE;
/**/
//26	 "Dinocode", 26	"Dinogaia.com", 26	 650), 
mysql_query("INSERT INTO codesgratis_codes_designation VALUES ( 26 , 'Dinocode', 'Dinogaia.com', 650 , 0 , 0 , 1  )");
echo mysql_error() . FP_LIGNE;
/**/
//27	 "Duckypass A", 27	"Ducky-games.com", 27	 500), 
mysql_query("INSERT INTO codesgratis_codes_designation VALUES ( 27 , 'Duckypass A'  , 'Ducky-games.com' , 500 , 0 , 0 , 1 )");
echo mysql_error() . FP_LIGNE;
/**
//28	 "Duckypass B", 28	"Ducky-games.com", 28	 2500), 
mysql_query("INSERT INTO codesgratis_codes_designation VALUES (  ,  ,  , , 0 , 0  )");
echo mysql_error() . FP_LIGNE;
/**/
//29	 "EC Code", 29	"Ecbarre.com", 29	 2300), 
mysql_query("INSERT INTO codesgratis_codes_designation VALUES ( 29 , 'EC Code', 'Ecbarre.com', 2300 ,0 , 0 ,1 )");
echo mysql_error() . FP_LIGNE;
/**
//30	"Fourmicode", 30	"Fourmilimails.com", 30	 700), 
mysql_query("INSERT INTO codesgratis_codes_designation VALUES (  ,  ,  , , 0 , 0  )");
echo mysql_error() . FP_LIGNE;
/**/
//31	"Fresh-code A", 31	"Freshkado.com", 31	 600), 
mysql_query("INSERT INTO codesgratis_codes_designation VALUES ( 31 , 'Fresh-code A', 'Freshkado.com', 600,  0 , 0 , 1  )");
echo mysql_error() . FP_LIGNE;
/**/
//32	"Geniz+"	"Genieokados.com", 32	 600), 
mysql_query("INSERT INTO codesgratis_codes_designation VALUES ( 32  , 'Geniz Plus' , 'Genieokados.com', 600 , 0 , 0 , 1 )");
echo mysql_error() . FP_LIGNE;
/**
//33	"GoldOrs", 33	"Gold-Barre.com", 33	 2600), 
mysql_query("INSERT INTO codesgratis_codes_designation VALUES (  ,  ,  , , 0 , 0  )");
echo mysql_error() . FP_LIGNE;
/**/
//34	"Gothicode", 34	"Gothikado.com", 34	 600), 
mysql_query("INSERT INTO codesgratis_codes_designation VALUES ( 34 , 'Gothicode'  , 'Gothikado.com' , 600 , 0 , 0 , 1  )");
echo mysql_error() . FP_LIGNE;
/**/
//35	"Gratcode", 35	"Gratkado.com", 35	 450), 
mysql_query("INSERT INTO codesgratis_codes_designation VALUES ( 35 , 'Gratcode', 'Gratkado.com', 450 ,  0 , 0 , 1 )");
echo mysql_error() . FP_LIGNE;
/**/
//36	"GratOuille", 36	"Grat-os.com", 36	 600), 
mysql_query("INSERT INTO codesgratis_codes_designation VALUES ( 36, 'GratOuille', 'Grat-os.com',	 600, 0 , 0 , 1 )");
echo mysql_error() . FP_LIGNE;

/**/
//37	"Grizz+", 37	"Grizou.com", 37	 400), 
mysql_query("INSERT INTO codesgratis_codes_designation VALUES ( 37 , 'Grizz plus', 'Grizou.com', 400,  0 , 0 , 1 )");
echo mysql_error() . FP_LIGNE;
/**/
//38	"Kadofoot A", 38	"Kadosfoot.com", 38	 600), 
mysql_query("INSERT INTO codesgratis_codes_designation VALUES ( 38 ,	'Kadofoot A', 'Kadosfoot.com', 600, 0 , 0 , 1  )");
echo mysql_error() . FP_LIGNE;
/**/
//39	"Kadofoot B", 39	"Kadosfoot.com", 39	 2500), 
mysql_query("INSERT INTO codesgratis_codes_designation VALUES (  39	, 'Kadofoot B', 'Kadosfoot.com',	 2500, 0 , 0  , 1)");
echo mysql_error() . FP_LIGNE;
/**/
//40	"KetchupKOD", 40	"Barakofrite.com", 40	 1800), 
mysql_query("INSERT INTO codesgratis_codes_designation VALUES ( 40 , 'KetchupKOD' , 'barakofrite.com',  1800 ,  0 , 0 , 1 )");
echo mysql_error() . FP_LIGNE;
/**/
//41	"Loupocode", 41	"Loupokado.com", 41	 700), 
mysql_query("INSERT INTO codesgratis_codes_designation VALUES ( 41 , 'Loupocode', 'Loupokado.com', 700 ,  0 , 0 , 1  )");
echo mysql_error() . FP_LIGNE;
/**/
//42	"MagiKode 5", 42	"Magikdo.com", 42	 450), 
mysql_query("INSERT INTO codesgratis_codes_designation VALUES ( 42 , 'MagiKode 5', 'Magikdo.com', 450,  0 , 0 , 1  )");
echo mysql_error() . FP_LIGNE;
/**/
//43	"MagiKode 10", 43	"Magikdo.com", 43	 700), 
mysql_query("INSERT INTO codesgratis_codes_designation VALUES ( 43 , 'MagiKode 10', 'Magikdo.com', 700 ,  0 , 0 , 1 )");
echo mysql_error() . FP_LIGNE;
/**
//44	"MagiKode 30", 44	"Magikdo.com", 44	 1800), 
mysql_query("INSERT INTO codesgratis_codes_designation VALUES (  ,  ,  , , 0 , 0  )");
echo mysql_error() . FP_LIGNE;

//45	"MayoKOD", 45	"Barakofrite.com", 45	 850), 
mysql_query("INSERT INTO codesgratis_codes_designation VALUES (  ,  ,  , , 0 , 0  )");
echo mysql_error() . FP_LIGNE;
/**/
//46	"MiniSwitZ", 46	"Switcodes.com", 46	 550), 
mysql_query("INSERT INTO codesgratis_codes_designation VALUES ( 46 , 'MiniSwitZ'  , 'Switcodes.com' , 550 , 0 , 0 , 1 )");
echo mysql_error() . FP_LIGNE;
/**/
//47	"Namupack", 47	"Namuhon.com", 47	 2700), 
mysql_query("INSERT INTO codesgratis_codes_designation VALUES ( 47 , 'Namupack', 'Namuhon.com', 2700 ,  0 , 0 , 1  )");
echo mysql_error() . FP_LIGNE;
/**
//48	"Nipcode", 48	"Nipbarre.fr", 48	 2300), 
mysql_query("INSERT INTO codesgratis_codes_designation VALUES (  ,  ,  , , 0 , 0  )");
echo mysql_error() . FP_LIGNE;
/**/
//49	"Pack+", 49	"Prizee.com", 49	 2100), 
mysql_query("INSERT INTO codesgratis_codes_designation VALUES ( 49 , 'Pack plus', 'Prizee.com',  2100, 0 , 0  , 1)");
echo mysql_error() . FP_LIGNE;
/**/
//50	"Pass'Pass", 50	"Cartosort.com", 50	 1800), 
mysql_query("INSERT INTO codesgratis_codes_designation VALUES ( 50	, 'PassPass', 'Cartosort.com', 1800 , 0 , 0 ,1 )");
echo mysql_error() . FP_LIGNE;
/**
//51	"Plage-code A",51	"Plageokdo.fr", 51	 700), 
mysql_query("INSERT INTO codesgratis_codes_designation VALUES (  ,  ,  , , 0 , 0  )");
echo mysql_error() . FP_LIGNE;

//52	"Plage-code B", 52	"Plageokdo.fr", 52	 2000), 
mysql_query("INSERT INTO codesgratis_codes_designation VALUES (  ,  ,  , , 0 , 0  )");
echo mysql_error() . FP_LIGNE;
/**/
//53	"Poker+", 53	"Cadeaux-poker.com", 53	 1800), 
mysql_query("INSERT INTO codesgratis_codes_designation VALUES (53 , 'Poker plus', 'Cadeaux-poker.com', 1800,  0 , 0, 1  )");
echo mysql_error() . FP_LIGNE;
/**/
//54	"Smartcode", 54	"Smart-barre.com", 54	 2000), 
mysql_query("INSERT INTO codesgratis_codes_designation VALUES (54 ,	'Smartcode', 'Smart-barre.com' , 2000,  0 , 0 , 1 )");
echo mysql_error() . FP_LIGNE;
/**/
//55	"SurfCode", 55	"Surf-barre.com", 55	 2000), 
mysql_query("INSERT INTO codesgratis_codes_designation VALUES ( 55,	'SurfCode', 'Surf-barre.com', 2000 ,  0 , 0 , 1  )");
echo mysql_error() . FP_LIGNE;
/**
//56	"Tonik'Potion", 56	"Bullovor.com", 56	 1800), 
mysql_query("INSERT INTO codesgratis_codes_designation VALUES (  ,  ,  , , 0 , 0  )");
echo mysql_error() . FP_LIGNE;

//57	"Webocode", 57	"Webocodes.com",57	 2800), 
mysql_query("INSERT INTO codesgratis_codes_designation VALUES (  ,  ,  , , 0 , 0  )");
echo mysql_error() . FP_LIGNE;

//58	"Wincode+", 58	"Wincode.fr", 58	 1000), 
mysql_query("INSERT INTO codesgratis_codes_designation VALUES (  ,  ,  , , 0 , 0  )");
echo mysql_error() . FP_LIGNE;

//59	"Wiopass", 59	"Wiokado.com",59	 1000), 
mysql_query("INSERT INTO codesgratis_codes_designation VALUES (  ,  ,  , , 0 , 0  )");
echo mysql_error() . FP_LIGNE;
/**/
//60	"Y-code", 60	"Yacado.com", 60	 2700), 
mysql_query("INSERT INTO codesgratis_codes_designation VALUES ( 60 , 'Y-code'  , 'Yacado.com' , 2700 , 0 , 0 , 1 )");
echo mysql_error() . FP_LIGNE;
/**
//61	"Z-code", 61	"Zanimos.net", 61	 1800), 
mysql_query("INSERT INTO codesgratis_codes_designation VALUES (  ,  ,  , , 0 , 0  )");
echo mysql_error() . FP_LIGNE;

//62	"Zeepri+" 62	"Zeepri.com" 62	 1000)
mysql_query("INSERT INTO codesgratis_codes_designation VALUES ( 62 , Zeepri+ , Zeepri.com , 1000 , 0 , 0 , 1  )");
echo mysql_error() . FP_LIGNE;



/**/
/**

							
$nom_code_get = array(

2	"Appelogagne", 
3	"Azur-code", 
4	"Bankiz plus", 
5	"BonusCode", 
6	"Boop's",
7	"Buzicodes", 
8   "Byncode", 
9	"Cagette", 
10	"Cashcode", 
11	"CEpass", 
12	"CGcode", 
13	"Cheyen code", 
14	"Choco plus", 
15	"Cinecode", 
16	"Cinecode plus", 
17	"Cliquopass", 
18	"Cocoricode", 
19	"Cocoricode plus", 
20	"Codeclic", 
21	"Codesauxcliques A", 
22	"Codesauxcliques B", 
23	"Codilo 1 euro", 
24	"Deficode", 
25	"Dinocode", 
26	"Duckypass A", 
27	"Duckypass B", 
28	"EC Code", 
29	"Fourmicode", 
30	"Fresh-code A", 
31	"Geniz plus", 
32	"GoldOrs", 
33	"Gothicode", 
34	"Gratcode", 
35	"GratOuille", 
36	"Grizz plus", 
37	"Kadofoot A", 
38	"Kadofoot B", 
39	"KetchupKOD", 
40	"Loupocode", 
41	"MagiKode 5", 
42	"MagiKode 10", 
43	"MagiKode 30", 
44	"MayoKOD",  
45	"MiniSwitZ", 
46	"Namupack", 
47	"Nipcode", 
48	"Pack plus", 
49	"PassPass", 
50	"Plage code A", 
51	"Plage code B", 
52	"Poker plus", 
53	"Smartcode", 
54	"SurfCode", 
55	"TonikPotion", 
56	"Webocode", 
57	"Wincode plus", 
58	"Wiopass", 
59	"Y code", 
60	"Z code", 
61	"Zeepri plus"
);
							
$site_code = array(

2	"Appel-gagnant.com", 
3	"Voyage-eco.info", 
4	"Bankizocodes.com", 
5	"LeNetGagnant.fr", 
6	"Boomat.fr", 
7	"Sacokado.com", 
8	"Toilokdo.com", 
9	"Marcher-o-kdos.com", 
10	"Cashkado.com", 
11	"Chaudron-Empoisonne.fr", 
12	"CodesGratis.fr", 
13	"Cheyen-barre.com", 
14	"Binbango.com", 
15	"Cinemakado.com", 
16	"Cinemakado.com", 
17	"Cliquojeux.com", 
18	"Cocoricode.com", 
19	"Cocoricode.com", 
20	"Codes-clic.com", 
21	"Codesauxcliques.com", 
22	"Codesauxcliques.com", 
23	"Codilo.com", 
24	"Defigames.com", 
25	"Dinogaia.com", 
26	"Ducky-games.com", 
27	"Ducky-games.com", 
28	"Ecbarre.com", 
29	"Fourmilimails.com", 
30	"Freshkado.com", 
31	"Genieokados.com", 
32	"Gold-Barre.com", 
33	"Gothikado.com", 
34	"Gratkado.com", 
35	"Grat-os.com", 
36	"Grizou.com", 
37	"Kadosfoot.com", 
38	"Kadosfoot.com", 
39	"Barakofrite.com", 
40	"Loupokado.com", 
41	"Magikdo.com", 
42	"Magikdo.com", 
43	"Magikdo.com", 
44	"Barakofrite.com", 
45	"Switcodes.com", 
46	"Namuhon.com", 
47	"Nipbarre.fr", 
48	"Prizee.com", 
49	"Cartosort.com", 
50	"Plageokdo.fr", 
51	"Plageokdo.fr", 
52	"Cadeaux-poker.com", 
53	"Smart-barre.com", 
54	"Surf-barre.com", 
55	"Bullovor.com", 
56	"Webocodes.com", 
57	"Wincode.fr", 
58	"Wiokado.com", 
59	"Yacado.com", 
60	"Zanimos.net", 
61	"Zeepri.com"
);
							
$cout_code = array(

2	 2000), 
3	 600), 
4	 1000), 
5	 2500), 
6	 700), 
7	 500), 
8	 500), 
9	 600), 
10	 450), 
11	 600), 
12	 80), 
13	 2700), 
14	 1800), 
15	 500), 
16	 2000), 
17	 650), 
18	 400), 
19	 1200), 
20	 550), 
21	 650), 
22	 2700), 
23	 2000), 
24	 1800), 
25	 650), 
26	 500), 
27	 2500), 
28	 2300), 
29	 700), 
30	 600), 
31	 600), 
32	 2600), 
33	 600), 
34	 450), 
35	 600), 
36	 400), 
37	 600), 
38	 2500), 
39	 1800), 
40	 700), 
41	 450), 
42	 700), 
43	 1800), 
44	 850), 
45	 550), 
46	 2700), 
47	 2300), 
48	 2100), 
49	 1800), 
50	 700), 
51	 2000), 
52	 1800), 
53	 2000), 
54	 2000), 
55	 1800), 
56	 2800), 
57	 1000), 
58	 1000), 
59	 2700), 
60	 1800), 
61	 1000));
**/
endif;
?>