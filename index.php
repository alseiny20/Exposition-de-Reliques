<?php
/*
 * On indique que les chemins des fichiers qu'on inclut
 * seront relatifs au répertoire src.
 */
set_include_path("./src");
/* Inclusion des classes utilisées dans le projet */
require_once("model/ReliqueStorage.php");
require_once("Router.php");
require_once("view/View.php");
require_once("control/Controller.php");
require_once("model/ReliqueStorageFile.php");
require_once("model/ReliqueStorageMySQL.php");

require_once("model/Relique.php");
require_once("model/ReliqueBuilder.php");
require_once("lib/ObjectFileDB.php");
require_once("model/Relique.php");
require_once('/users/22011830/private/mysql_config.php');
/*
 * Cette page est simplement le point d'arrivée de l'internaute
 * sur notre site. On se contente de créer un routeur
 * et de lancer son main.
 */
$router = new Router();
/** donnees d'acces a la base */
$dsn = "mysql:host=".MYSQL_HOST.";port=".MYSQL_PORT.";dbname=".MYSQL_DB.";charset=utf8mb4";
$user =MYSQL_USER;
$pass =MYSQL_PASSWORD;
$pdo = new PDO($dsn, $user, $pass);
$router->main(new ReliqueStorageMySQL($pdo));
// $router->main(new ReliqueStorageFile("../../../tmp/file"));
