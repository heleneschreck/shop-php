<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        
        <link rel="stylesheet" type="text/css" href="signin.css"/>
        <title>connexion base de donnee</title>
    </head>
    <body>
<?php 

// constantes d'environnement
    define("DBHOST", "localhost");
    define("DBUSER", "root");
    define("DBPASS","");
    define("DBNAME","my_shop");

//data sources name de connexion
    $dsn="mysql:dbname=".DBNAME.";host=".DBHOST;

// connection

try{
// instanciation PDO
$db = new PDO($dsn, DBUSER, DBPASS);

// envoyer les données en UTF8
// $db->exec("SET NAMES utf8");



}catch(PDOException $e){
    die("Erreur:".$e->getMessage());
}
// on est connectés
// récupération de la liste des utilisateur(users)
$sql= "SELECT * FROM `users`";

// execution de la requète
$query = $db->query($sql);

// recuperation avec fetch
$users = $query->fetchAll();


?>



    </body>
</html>